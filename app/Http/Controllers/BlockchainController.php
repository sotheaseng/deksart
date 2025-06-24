<?php

namespace App\Http\Controllers;

use App\Models\BlockchainRecord;
use App\Services\BlockchainService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class BlockchainController extends Controller
{
    protected $blockchainService;

    public function __construct(BlockchainService $blockchainService)
    {
        $this->blockchainService = $blockchainService;
    }

    public function index(Request $request)
    {
        $query = BlockchainRecord::with('user');
        
        if ($request->filled('record_type')) {
            $query->where('record_type', $request->record_type);
        }
        
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        $records = $query->latest('timestamp')->paginate(20);

        // --- Blockchain integrity summary ---
        $uniqueChains = BlockchainRecord::select('record_type', 'record_id')->distinct()->get();
        $allValid = true;
        $chainStatusList = [];
        foreach ($uniqueChains as $chain) {
            $model = null;
            switch ($chain->record_type) {
                case 'room':
                    $model = \App\Models\Room::withTrashed()->find($chain->record_id);
                    break;
                case 'housekeeping_task':
                    $model = \App\Models\HousekeepingTask::withTrashed()->find($chain->record_id);
                    break;
                case 'user':
                    $model = \App\Models\User::find($chain->record_id);
                    break;
                case 'reservation':
                    $model = \App\Models\Reservation::withTrashed()->find($chain->record_id);
                    break;
            }
            $chainValid = false;
            if ($model) {
                $integrity = $this->blockchainService->verifyChainIntegrity($model);
                \Log::info('DEBUG: verifyChainIntegrity for record_type=' . $chain->record_type . ', record_id=' . $chain->record_id, $integrity);
                $chainValid = collect($integrity)->last()['overall_valid'] ?? false;
            }
            $chainStatusList[] = [
                'record_type' => $chain->record_type,
                'record_id' => $chain->record_id,
                'valid' => $chainValid,
            ];
            if (!$chainValid) {
                $allValid = false;
            }
        }
        // --- End blockchain integrity summary ---
        return view('blockchain.index', compact('records', 'allValid', 'chainStatusList'));
    }

    public function show(BlockchainRecord $record)
    {
        $record->load('user');
        $isValid = $this->blockchainService->verifyIntegrity($record);
        
        return view('blockchain.show', compact('record', 'isValid'));
    }

    public function verify(Request $request)
    {
        $recordType = $request->input('record_type');
        $recordId = $request->input('record_id');
        
        if (!$recordType || !$recordId) {
            return back()->with('error', 'Record type and ID are required.');
        }
        
        // Get the model instance
        $model = null;
        switch ($recordType) {
            case 'room':
                $model = \App\Models\Room::withTrashed()->find($recordId);
                break;
            case 'housekeeping_task':
                $model = \App\Models\HousekeepingTask::withTrashed()->find($recordId);
                break;
            case 'user':
                $model = \App\Models\User::find($recordId);
                break;
            case 'reservation':
                $model = \App\Models\Reservation::withTrashed()->find($recordId);
                break;
        }
        
        if (!$model) {
            return back()->with('error', 'Record not found.');
        }
        
        $integrityCheck = $this->blockchainService->verifyChainIntegrity($model);
        
        return view('blockchain.verify', compact('integrityCheck', 'model', 'recordType'));
    }

    public function verifyAllChains()
    {
        $uniqueChains = \App\Models\BlockchainRecord::select('record_type', 'record_id')
            ->distinct()
            ->get();
        $results = [];
        foreach ($uniqueChains as $chain) {
            $model = null;
            switch ($chain->record_type) {
                case 'room':
                    $model = \App\Models\Room::withTrashed()->find($chain->record_id);
                    break;
                case 'housekeeping_task':
                    $model = \App\Models\HousekeepingTask::withTrashed()->find($chain->record_id);
                    break;
                case 'user':
                    $model = \App\Models\User::find($chain->record_id);
                    break;
                case 'reservation':
                    $model = \App\Models\Reservation::withTrashed()->find($chain->record_id);
                    break;
            }
            if ($model) {
                $integrity = $this->blockchainService->verifyChainIntegrity($model);
                $lastValid = collect($integrity)->last()['overall_valid'] ?? false;
                $results[] = [
                    'record_type' => $chain->record_type,
                    'record_id' => $chain->record_id,
                    'valid' => $lastValid,
                    'details' => $integrity,
                ];
            } else {
                $results[] = [
                    'record_type' => $chain->record_type,
                    'record_id' => $chain->record_id,
                    'valid' => false,
                    'details' => [],
                    'error' => 'Model not found',
                ];
            }
        }
        return view('blockchain.verify_all', compact('results'));
    }

    public function clearAll()
    {
        \App\Models\BlockchainRecord::truncate();
        return redirect()->route('blockchain.index')->with('success', 'All blockchain history has been cleared.');
    }
}

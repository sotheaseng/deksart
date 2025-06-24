<?php

namespace App\Http\Controllers;

use App\Models\HousekeepingTask;
use App\Models\Room;
use App\Models\User;
use App\Services\BlockchainService;
use Illuminate\Http\Request;

class HousekeepingController extends Controller
{
    protected $blockchainService;

    public function __construct(BlockchainService $blockchainService)
    {
        $this->blockchainService = $blockchainService;
    }

    public function index()
    {
        $user = auth()->user();
        
        $tasks = HousekeepingTask::with(['room', 'assignedTo', 'createdBy'])
            ->when($user->isHousekeeper(), function ($query) use ($user) {
                return $query->where('assigned_to', $user->id);
            })
            ->latest()
            ->paginate(10);
        
        return view('housekeeping.index', compact('tasks'));
    }

    public function create()
    {
        $rooms = Room::all();
        $housekeepers = User::where('role', 'housekeeper')->where('is_active', true)->get();
        
        return view('housekeeping.create', compact('rooms', 'housekeepers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'assigned_to' => 'required|exists:users,id',
            'task_type' => 'required|in:cleaning,maintenance,inspection,deep_clean',
            'priority' => 'required|in:low,medium,high,urgent',
            'description' => 'nullable|string',
            'scheduled_at' => 'nullable|date',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['status'] = 'pending';
        
        $task = HousekeepingTask::create($validated);
        
        // Record in blockchain
        $this->blockchainService->recordTransaction($task, 'create');

        return redirect()->route('housekeeping.index')->with('success', 'Task created successfully!');
    }

    public function show(HousekeepingTask $housekeeping)
    {
        $housekeeping->load(['room', 'assignedTo', 'createdBy']);
        $history = $this->blockchainService->getRecordHistory($housekeeping);
        $integrityCheck = $this->blockchainService->verifyChainIntegrity($housekeeping);
        
        return view('housekeeping.show', compact('housekeeping', 'history', 'integrityCheck'));
    }

    public function edit(HousekeepingTask $housekeeping)
    {
        $rooms = Room::all();
        $housekeepers = User::where('role', 'housekeeper')->where('is_active', true)->get();
        
        return view('housekeeping.edit', compact('housekeeping', 'rooms', 'housekeepers'));
    }

    public function update(Request $request, HousekeepingTask $housekeeping)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'assigned_to' => 'required|exists:users,id',
            'task_type' => 'required|in:cleaning,maintenance,inspection,deep_clean',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'priority' => 'required|in:low,medium,high,urgent',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'scheduled_at' => 'nullable|date',
        ]);

        $dataBefore = $housekeeping->toArray();
        
        // Update timestamps based on status
        if ($validated['status'] === 'in_progress' && !$housekeeping->started_at) {
            $validated['started_at'] = now();
        } elseif ($validated['status'] === 'completed' && !$housekeeping->completed_at) {
            $validated['completed_at'] = now();
        }
        
        $housekeeping->update($validated);
        
        // Record in blockchain
        $this->blockchainService->recordTransaction($housekeeping, 'update', $dataBefore);

        return redirect()->route('housekeeping.index')->with('success', 'Task updated successfully!');
    }

    public function destroy(HousekeepingTask $housekeeping)
    {
        $dataBefore = $housekeeping->toArray();
        
        // Record in blockchain before deletion
        $this->blockchainService->recordTransaction($housekeeping, 'delete', $dataBefore);
        
        $housekeeping->delete();

        return redirect()->route('housekeeping.index')->with('success', 'Task deleted successfully!');
    }
}

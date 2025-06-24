<?php

namespace App\Services;

use App\Models\BlockchainRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

if (!defined('JSON_SORT_KEYS')) {
    define('JSON_SORT_KEYS', 0);
}

class BlockchainService
{
    public function recordTransaction(Model $model, string $action, array $dataBefore = null, array $dataAfter = null)
    {
        $recordType = Str::snake(class_basename($model));
        $recordId = $model->id;
        
        // Get the previous hash for blockchain integrity
        $previousRecord = BlockchainRecord::where('record_type', $recordType)
            ->where('record_id', $recordId)
            ->latest()
            ->first();
        
        $previousHash = $previousRecord ? $previousRecord->hash : null;
        
        // Prepare data
        $data = [
            'record_type' => $recordType,
            'record_id' => $recordId,
            'action' => $action,
            'data_before' => $this->normalizeDataForHash($dataBefore),
            'data_after' => $this->normalizeDataForHash($dataAfter ?? $model->toArray()),
            'user_id' => Auth::id(),
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'previous_hash' => $previousHash,
        ];
        
        // Remove debug logs
        // if ($action === 'delete') {
        //     \Log::info('--- DELETE ACTION: recordTransaction ---');
        //     \Log::info('Blockchain recordTransaction data for hash (DELETE)', $data);
        // }
        ksort($data);
        $jsonForHash = json_encode(collect($data)->except(['hash', 'created_at', 'updated_at'])->toArray(), \JSON_SORT_KEYS);
        // if ($action === 'delete') {
        //     \Log::info('Blockchain recordTransaction JSON for hash (DELETE)', ['json' => $jsonForHash]);
        // }
        
        // Generate hash for blockchain integrity
        $data['hash'] = $this->generateHash($data);
        // if ($action === 'delete') {
        //     \Log::info('Blockchain recordTransaction hash (DELETE)', ['hash' => $data['hash']]);
        // }
        
        return BlockchainRecord::create($data);
    }

    public function generateHash(array $data): string
    {
        // Remove hash and timestamps from data for consistent hashing
        $hashData = collect($data)->except(['hash', 'created_at', 'updated_at'])->toArray();
        
        return hash('sha256', json_encode($hashData, \JSON_SORT_KEYS));
    }

    public function verifyIntegrity(BlockchainRecord $record): bool
    {
        $data = $record->toArray();
        unset($data['user'], $data['id']);
        $storedHash = $data['hash'];
        unset($data['hash'], $data['created_at'], $data['updated_at']);
        
        // Normalize before hashing
        $data['data_before'] = $this->normalizeDataForHash($data['data_before']);
        $data['data_after'] = $this->normalizeDataForHash($data['data_after']);
        if (isset($data['timestamp'])) {
            $data['timestamp'] = \Carbon\Carbon::parse($data['timestamp'])->format('Y-m-d H:i:s');
        }
        if (isset($data['deleted_at'])) {
            $data['deleted_at'] = $data['deleted_at'] ? \Carbon\Carbon::parse($data['deleted_at'])->format('Y-m-d H:i:s') : null;
        }
        
        // Remove debug logs
        // if (isset($data['action']) && $data['action'] === 'delete') {
        //     \Log::info('--- DELETE ACTION: verifyIntegrity ---');
        //     \Log::info('Blockchain verifyIntegrity data for hash (DELETE)', $data);
        // }
        ksort($data);
        $jsonForHash = json_encode($data, \JSON_SORT_KEYS);
        // if (isset($data['action']) && $data['action'] === 'delete') {
        //     \Log::info('Blockchain verifyIntegrity JSON for hash (DELETE)', ['json' => $jsonForHash]);
        // }
        
        $calculatedHash = hash('sha256', $jsonForHash);
        // if (isset($data['action']) && $data['action'] === 'delete') {
        //     \Log::info('Blockchain verifyIntegrity calculated hash (DELETE)', ['hash' => $calculatedHash, 'stored' => $storedHash]);
        // }
        
        return $storedHash === $calculatedHash;
    }

    // IMPORTANT: Records must be in chronological (oldest to newest) order for blockchain validation.
    public function getRecordHistory(Model $model): \Illuminate\Database\Eloquent\Collection
    {
        $recordType = \Illuminate\Support\Str::snake(class_basename($model));
        
        return BlockchainRecord::where('record_type', $recordType)
            ->where('record_id', $model->id)
            ->with('user')
            ->orderBy('timestamp', 'asc')
            ->get();
    }

    // Chain validation must process records from oldest to newest.
    public function verifyChainIntegrity(Model $model): array
    {
        $records = $this->getRecordHistory($model);
        $results = [];
        
        foreach ($records as $index => $record) {
            $isValid = $this->verifyIntegrity($record);
            
            // Check if previous hash matches
            if ($index > 0) {
                $previousRecord = $records[$index - 1];
                $previousHashValid = $record->previous_hash === $previousRecord->hash;
            } else {
                $previousHashValid = $record->previous_hash === null;
            }
            
            $results[] = [
                'record_id' => $record->id,
                'timestamp' => $record->timestamp,
                'action' => $record->action,
                'hash_valid' => $isValid,
                'chain_valid' => $previousHashValid,
                'overall_valid' => $isValid && $previousHashValid,
            ];
        }
        
        return $results;
    }

    private function normalizeDataForHash($data)
    {
        if (is_null($data)) return null;
        unset($data['user']);
        if (isset($data['check_in_date'])) {
            $data['check_in_date'] = \Carbon\Carbon::parse($data['check_in_date'])->format('Y-m-d');
        }
        if (isset($data['check_out_date'])) {
            $data['check_out_date'] = \Carbon\Carbon::parse($data['check_out_date'])->format('Y-m-d');
        }
        if (isset($data['total_amount'])) {
            $data['total_amount'] = number_format((float)$data['total_amount'], 2, '.', '');
        }
        if (isset($data['deleted_at'])) {
            $data['deleted_at'] = $data['deleted_at'] ? \Carbon\Carbon::parse($data['deleted_at'])->format('Y-m-d H:i:s') : null;
        }
        // Recursively sort all keys and cast all values to string
        $data = $this->recursiveKeySortAndStringify($data);
        return $data;
    }

    private function recursiveKeySortAndStringify($array)
    {
        if (!is_array($array)) return is_null($array) ? null : (string)$array;
        ksort($array);
        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                $value = $this->recursiveKeySortAndStringify($value);
            } else if (!is_null($value)) {
                $value = (string)$value;
            }
        }
        return $array;
    }
}

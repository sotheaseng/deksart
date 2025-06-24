<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlockchainRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'record_type',
        'record_id',
        'action',
        'data_before',
        'data_after',
        'hash',
        'previous_hash',
        'user_id',
        'timestamp',
    ];

    protected function casts(): array
    {
        return [
            'data_before' => 'array',
            'data_after' => 'array',
            'timestamp' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRecordModel()
    {
        switch ($this->record_type) {
            case 'room':
                return Room::find($this->record_id);
            case 'user':
                return User::find($this->record_id);
            case 'housekeeping_task':
                return HousekeepingTask::find($this->record_id);
            case 'reservation':
                return Reservation::find($this->record_id);
            default:
                return null;
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'room_number',
        'room_type',
        'price_per_night',
        'status',
        'description',
        'amenities',
    ];

    protected function casts(): array
    {
        return [
            'amenities' => 'array',
            'price_per_night' => 'decimal:2',
        ];
    }

    public function housekeepingTasks()
    {
        return $this->hasMany(HousekeepingTask::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function blockchainRecords()
    {
        return $this->morphMany(BlockchainRecord::class, 'record');
    }

    public function isAvailable()
    {
        return $this->status === 'available';
    }

    public function isOccupied()
    {
        return $this->status === 'occupied';
    }

    public function isOccupiedToday()
    {
        $today = now()->toDateString();
        return $this->reservations()
            ->where('check_in_date', '<=', $today)
            ->where('check_out_date', '>', $today)
            ->whereIn('status', ['confirmed', 'checked_in'])
            ->exists();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function housekeepingTasks()
    {
        return $this->hasMany(HousekeepingTask::class, 'assigned_to');
    }

    public function createdTasks()
    {
        return $this->hasMany(HousekeepingTask::class, 'created_by');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'created_by');
    }

    public function blockchainRecords()
    {
        return $this->hasMany(BlockchainRecord::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isFrontdesk()
    {
        return $this->role === 'frontdesk';
    }

    public function isHousekeeper()
    {
        return $this->role === 'housekeeper';
    }
}

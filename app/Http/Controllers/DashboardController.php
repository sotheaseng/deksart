<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\HousekeepingTask;
use App\Models\Reservation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'total_rooms' => Room::count(),
            'available_rooms' => Room::where('status', 'available')->count(),
            'occupied_rooms' => Room::where('status', 'occupied')->count(),
            'maintenance_rooms' => Room::where('status', 'maintenance')->count(),
            'pending_tasks' => HousekeepingTask::where('status', 'pending')->count(),
            'active_reservations' => Reservation::whereIn('status', ['confirmed', 'checked_in'])->count(),
        ];
        
        if ($user->isHousekeeper()) {
            $stats['my_tasks'] = HousekeepingTask::where('assigned_to', $user->id)
                ->where('status', 'pending')
                ->count();
        }
        
        $recentTasks = HousekeepingTask::with(['room', 'assignedTo'])
            ->when($user->isHousekeeper(), function ($query) use ($user) {
                return $query->where('assigned_to', $user->id);
            })
            ->latest()
            ->take(5)
            ->get();
        
        $recentReservations = null;
        if ($user->isAdmin() || $user->isFrontdesk()) {
            $recentReservations = 
                \App\Models\Reservation::with(['room', 'creator'])
                ->latest('created_at')
                ->take(5)
                ->get();
        }
        
        return view('dashboard', compact('stats', 'recentTasks', 'recentReservations'));
    }
}

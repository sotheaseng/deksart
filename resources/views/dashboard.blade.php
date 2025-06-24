@extends('layouts.app')

@section('content')
    <header class="card-header">
        <div class="container">
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">
                Dashboard
            </h2>
        </div>
    </header>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 mb-6">
        <div class="stat-card">
            <div class="stat-number" style="color: #3b82f6;">{{ $stats['total_rooms'] }}</div>
            <div class="stat-label">Total Rooms</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number" style="color: #10b981;">{{ $stats['available_rooms'] }}</div>
            <div class="stat-label">Available Rooms</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number" style="color: #ef4444;">{{ $stats['occupied_rooms'] }}</div>
            <div class="stat-label">Occupied Rooms</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number" style="color: #6366f1;">{{ $stats['active_reservations'] }}</div>
            <div class="stat-label">Active Reservations</div>
        </div>
    </div>
    
    @if(auth()->user()->isAdmin() || auth()->user()->isFrontdesk())
        <div class="card" style="margin-bottom: 2rem;">
            <div class="card-header">
                <div class="flex justify-between items-center">
                    <h3 style="font-size: 1.125rem; font-weight: 600;">Recent Reservations</h3>
                    <a href="{{ route('reservations.index') }}" class="btn btn-primary" style="font-size: 0.875rem;">View All</a>
                </div>
            </div>
            <div class="card-body">
                @if($recentReservations && $recentReservations->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Room</th>
                                    <th>Guest Name</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentReservations as $reservation)
                                    <tr>
                                        <td>{{ $reservation->room->room_number ?? '-' }}</td>
                                        <td>{{ $reservation->guest_name }}</td>
                                        <td>{{ $reservation->check_in_date->format('M d, Y') }}</td>
                                        <td>{{ $reservation->check_out_date->format('M d, Y') }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($reservation->status === 'confirmed') badge-info
                                                @elseif($reservation->status === 'checked_in') badge-success
                                                @elseif($reservation->status === 'checked_out') badge-secondary
                                                @else badge-danger @endif">
                                                {{ ucfirst(str_replace('_', ' ', $reservation->status)) }}
                                            </span>
                                        </td>
                                        <td>{{ $reservation->creator->name ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p style="color: #6b7280; text-align: center; padding: 2rem;">No recent reservations found.</p>
                @endif
            </div>
        </div>
    @endif
    
    <!-- Recent Tasks -->
    <div class="card">
        <div class="card-header">
            <div class="flex justify-between items-center">
                <h3 style="font-size: 1.125rem; font-weight: 600;">Recent Housekeeping Tasks</h3>
                <a href="{{ route('housekeeping.index') }}" class="btn btn-primary" style="font-size: 0.875rem;">View All</a>
            </div>
        </div>
        <div class="card-body">
            @if($recentTasks->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Room</th>
                                <th>Task Type</th>
                                <th>Assigned To</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTasks as $task)
                                <tr>
                                    <td><strong>{{ $task->room->room_number }}</strong></td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $task->task_type)) }}</td>
                                    <td>{{ $task->assignedTo->name }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($task->status === 'completed') badge-success
                                            @elseif($task->status === 'in_progress') badge-warning
                                            @elseif($task->status === 'pending') badge-secondary
                                            @else badge-danger @endif">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            @if($task->priority === 'urgent') badge-danger
                                            @elseif($task->priority === 'high') badge-warning
                                            @elseif($task->priority === 'medium') badge-info
                                            @else badge-success @endif">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </td>
                                    <td>{{ $task->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="color: #6b7280; text-align: center; padding: 2rem;">No recent tasks found.</p>
            @endif
        </div>
    </div>
@endsection

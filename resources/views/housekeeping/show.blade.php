@extends('layouts.app')

@section('content')
    <header class="card-header">
        <div class="container">
            <div class="flex justify-between items-center">
                <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">
                    Task Details - Room {{ $housekeeping->room->room_number }}
                </h2>
                @if(auth()->user()->isAdmin() || auth()->user()->isFrontdesk() || auth()->user()->id === $housekeeping->assigned_to)
                    <a href="{{ route('housekeeping.edit', $housekeeping) }}" class="btn btn-primary">
                        Edit Task
                    </a>
                @endif
            </div>
        </div>
    </header>
    
    <div class="grid grid-cols-1 md:grid-cols-2" style="gap: 1.5rem;">
        <!-- Task Details -->
        <div class="card">
            <div class="card-header">
                <h3 style="font-size: 1.125rem; font-weight: 600;">Task Information</h3>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 1rem;">
                    <strong>Room:</strong> {{ $housekeeping->room->room_number }} ({{ ucfirst($housekeeping->room->room_type) }})
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <strong>Task Type:</strong> {{ ucfirst(str_replace('_', ' ', $housekeeping->task_type)) }}
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <strong>Status:</strong>
                    <span class="badge 
                        @if($housekeeping->status === 'completed') badge-success
                        @elseif($housekeeping->status === 'in_progress') badge-warning
                        @elseif($housekeeping->status === 'pending') badge-secondary
                        @else badge-danger @endif">
                        {{ ucfirst(str_replace('_', ' ', $housekeeping->status)) }}
                    </span>
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <strong>Priority:</strong>
                    <span class="badge 
                        @if($housekeeping->priority === 'urgent') badge-danger
                        @elseif($housekeeping->priority === 'high') badge-warning
                        @elseif($housekeeping->priority === 'medium') badge-info
                        @else badge-success @endif">
                        {{ ucfirst($housekeeping->priority) }}
                    </span>
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <strong>Assigned To:</strong> {{ $housekeeping->assignedTo->name }}
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <strong>Created By:</strong> {{ $housekeeping->createdBy->name }}
                </div>
                
                @if($housekeeping->scheduled_at)
                    <div style="margin-bottom: 1rem;">
                        <strong>Scheduled:</strong> {{ $housekeeping->scheduled_at->format('M d, Y H:i') }}
                    </div>
                @endif
                
                @if($housekeeping->started_at)
                    <div style="margin-bottom: 1rem;">
                        <strong>Started:</strong> {{ $housekeeping->started_at->format('M d, Y H:i') }}
                    </div>
                @endif
                
                @if($housekeeping->completed_at)
                    <div style="margin-bottom: 1rem;">
                        <strong>Completed:</strong> {{ $housekeeping->completed_at->format('M d, Y H:i') }}
                    </div>
                @endif
                
                <div style="margin-bottom: 1rem;">
                    <strong>Created:</strong> {{ $housekeeping->created_at->format('M d, Y H:i') }}
                </div>
            </div>
        </div>
        
        <!-- Description and Notes -->
        <div class="card">
            <div class="card-header">
                <h3 style="font-size: 1.125rem; font-weight: 600;">Description & Notes</h3>
            </div>
            <div class="card-body">
                @if($housekeeping->description)
                    <div style="margin-bottom: 1.5rem;">
                        <strong>Description:</strong>
                        <p style="margin-top: 0.5rem; color: #6b7280;">{{ $housekeeping->description }}</p>
                    </div>
                @endif
                
                @if($housekeeping->notes)
                    <div>
                        <strong>Notes:</strong>
                        <p style="margin-top: 0.5rem; color: #6b7280;">{{ $housekeeping->notes }}</p>
                    </div>
                @else
                    <p style="color: #6b7280; font-style: italic;">No notes added yet.</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Blockchain History -->
    @if(auth()->user()->isAdmin())
        <div class="card" style="margin-top: 1.5rem;">
            <div class="card-header">
                <h3 style="font-size: 1.125rem; font-weight: 600;">Blockchain History</h3>
            </div>
            <div class="card-body">
                @if($history->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Version</th>
                                    <th>Action</th>
                                    <th>User</th>
                                    <th>Timestamp</th>
                                    <th>Hash</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($history->reverse()->values() as $i => $record)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($record->action === 'create') badge-success
                                                @elseif($record->action === 'update') badge-warning
                                                @else badge-danger @endif">
                                                {{ ucfirst($record->action) }}
                                            </span>
                                        </td>
                                        <td>{{ $record->user->name }}</td>
                                        <td>{{ $record->timestamp->format('M d, Y H:i:s') }}</td>
                                        <td style="font-family: monospace; font-size: 0.875rem;">{{ substr($record->hash, 0, 16) }}...</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p style="color: #6b7280; text-align: center; padding: 1rem;">No blockchain records found.</p>
                @endif
            </div>
        </div>
    @endif
    
    <div style="margin-top: 1.5rem;">
        <a href="{{ route('housekeeping.index') }}" class="btn btn-secondary">Back to Tasks</a>
    </div>
@endsection

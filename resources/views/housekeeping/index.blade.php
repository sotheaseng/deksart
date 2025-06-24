@extends('layouts.app')

@section('content')
    <header class="card-header">
        <div class="w-full flex justify-between items-center px-6">
            <div class="flex justify-between items-center">
                <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">
                    Housekeeping Tasks
                </h2>
                @if(auth()->user()->isAdmin() || auth()->user()->isFrontdesk())
                    <a href="{{ route('housekeeping.create') }}" class="btn btn-primary">
                        Create New Task
                    </a>
                @endif
            </div>
        </div>
    </header>
    
    <div class="card">
        <div class="card-body">
            @if($tasks->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Room</th>
                                <th>Task Type</th>
                                <th>Assigned To</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Scheduled</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
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
                                    <td>
                                        @if($task->scheduled_at)
                                            {{ $task->scheduled_at->format('M d, Y H:i') }}
                                        @else
                                            <span style="color: #6b7280;">Not scheduled</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('housekeeping.show', $task) }}" class="btn btn-secondary" style="margin-right: 0.5rem; padding: 0.25rem 0.75rem; font-size: 0.875rem;">View</a>
                                        @if(auth()->user()->isAdmin() || auth()->user()->isFrontdesk() || auth()->user()->id === $task->assigned_to)
                                            <a href="{{ route('housekeeping.edit', $task) }}" class="btn btn-primary" style="margin-right: 0.5rem; padding: 0.25rem 0.75rem; font-size: 0.875rem;">Edit</a>
                                        @endif
                                        @if(auth()->user()->isAdmin())
                                            <form action="{{ route('housekeeping.destroy', $task) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-delete" style="padding: 0.25rem 0.75rem; font-size: 0.875rem;">Delete</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div style="margin-top: 1rem;">
                    {{ $tasks->links() }}
                </div>
            @else
                <p style="color: #6b7280; text-align: center; padding: 2rem;">No housekeeping tasks found.</p>
            @endif
        </div>
    </div>
@endsection

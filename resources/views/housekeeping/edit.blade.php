@extends('layouts.app')

@section('content')
    <header class="card-header">
        <div class="container">
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">
                Edit Housekeeping Task - Room {{ $housekeeping->room->room_number }}
            </h2>
        </div>
    </header>
    
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('housekeeping.update', $housekeeping) }}">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2" style="gap: 1rem;">
                    <div class="form-group">
                        <label for="room_id" class="form-label">Room</label>
                        <select id="room_id" name="room_id" class="form-select" required>
                            <option value="">Select Room</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ (old('room_id', $housekeeping->room_id) == $room->id) ? 'selected' : '' }}>
                                    {{ $room->room_number }} - {{ ucfirst($room->room_type) }}
                                </option>
                            @endforeach
                        </select>
                        @error('room_id')
                            <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="assigned_to" class="form-label">Assign To</label>
                        <select id="assigned_to" name="assigned_to" class="form-select" required>
                            <option value="">Select Housekeeper</option>
                            @foreach($housekeepers as $housekeeper)
                                <option value="{{ $housekeeper->id }}" {{ (old('assigned_to', $housekeeping->assigned_to) == $housekeeper->id) ? 'selected' : '' }}>
                                    {{ $housekeeper->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('assigned_to')
                            <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2" style="gap: 1rem;">
                    <div class="form-group">
                        <label for="task_type" class="form-label">Task Type</label>
                        <select id="task_type" name="task_type" class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="cleaning" {{ old('task_type', $housekeeping->task_type) === 'cleaning' ? 'selected' : '' }}>Cleaning</option>
                            <option value="maintenance" {{ old('task_type', $housekeeping->task_type) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="inspection" {{ old('task_type', $housekeeping->task_type) === 'inspection' ? 'selected' : '' }}>Inspection</option>
                            <option value="deep_clean" {{ old('task_type', $housekeeping->task_type) === 'deep_clean' ? 'selected' : '' }}>Deep Clean</option>
                        </select>
                        @error('task_type')
                            <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="">Select Status</option>
                            <option value="pending" {{ old('status', $housekeeping->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ old('status', $housekeeping->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ old('status', $housekeeping->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status', $housekeeping->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2" style="gap: 1rem;">
                    <div class="form-group">
                        <label for="priority" class="form-label">Priority</label>
                        <select id="priority" name="priority" class="form-select" required>
                            <option value="">Select Priority</option>
                            <option value="low" {{ old('priority', $housekeeping->priority) === 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority', $housekeeping->priority) === 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority', $housekeeping->priority) === 'high' ? 'selected' : '' }}>High</option>
                            <option value="urgent" {{ old('priority', $housekeeping->priority) === 'urgent' ? 'selected' : '' }}>Urgent</option>
                        </select>
                        @error('priority')
                            <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="scheduled_at" class="form-label">Scheduled Date & Time</label>
                        <input id="scheduled_at" class="form-input" type="datetime-local" name="scheduled_at" 
                               value="{{ old('scheduled_at', $housekeeping->scheduled_at ? $housekeeping->scheduled_at->format('Y-m-d\TH:i') : '') }}">
                        @error('scheduled_at')
                            <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" class="form-textarea" name="description" rows="3" placeholder="Describe the task details...">{{ old('description', $housekeeping->description) }}</textarea>
                    @error('description')
                        <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea id="notes" class="form-textarea" name="notes" rows="3" placeholder="Add any additional notes...">{{ old('notes', $housekeeping->notes) }}</textarea>
                    @error('notes')
                        <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Task Timeline -->
                @if($housekeeping->started_at || $housekeeping->completed_at)
                    <div class="card" style="margin: 1.5rem 0; background-color: #f9fafb;">
                        <div class="card-body">
                            <h4 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem;">Task Timeline</h4>
                            
                            <div style="margin-bottom: 0.5rem;">
                                <strong>Created:</strong> {{ $housekeeping->created_at->format('M d, Y H:i') }}
                            </div>
                            
                            @if($housekeeping->started_at)
                                <div style="margin-bottom: 0.5rem;">
                                    <strong>Started:</strong> {{ $housekeeping->started_at->format('M d, Y H:i') }}
                                </div>
                            @endif
                            
                            @if($housekeeping->completed_at)
                                <div style="margin-bottom: 0.5rem;">
                                    <strong>Completed:</strong> {{ $housekeeping->completed_at->format('M d, Y H:i') }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                
                <div class="flex justify-between" style="margin-top: 1.5rem;">
                    <a href="{{ route('housekeeping.show', $housekeeping) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Task</button>
                </div>
            </form>
        </div>
    </div>
@endsection

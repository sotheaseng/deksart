@extends('layouts.app')

@section('content')
    <header class="card-header">
        <div class="container">
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">
                Create Housekeeping Task
            </h2>
        </div>
    </header>
    
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('housekeeping.store') }}">
                @csrf
                <input type="hidden" name="status" value="pending">
                
                <div class="grid grid-cols-1 md:grid-cols-2" style="gap: 1rem;">
                    <div class="form-group">
                        <label for="room_id" class="form-label">Room</label>
                        <select id="room_id" name="room_id" class="form-select" required>
                            <option value="">Select Room</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ (
                                    old('room_id', request('room_id', $rooms->first()?->id)) == $room->id
                                ) ? 'selected' : '' }}>
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
                                <option value="{{ $housekeeper->id }}" {{ (
                                    old('assigned_to', request('assigned_to', $housekeepers->first()?->id)) == $housekeeper->id
                                ) ? 'selected' : '' }}>
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
                            <option value="cleaning" {{ old('task_type', request('task_type', 'cleaning')) === 'cleaning' ? 'selected' : '' }}>Cleaning</option>
                            <option value="maintenance" {{ old('task_type', request('task_type', 'cleaning')) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="inspection" {{ old('task_type', request('task_type', 'cleaning')) === 'inspection' ? 'selected' : '' }}>Inspection</option>
                            <option value="deep_clean" {{ old('task_type', request('task_type', 'cleaning')) === 'deep_clean' ? 'selected' : '' }}>Deep Clean</option>
                        </select>
                        @error('task_type')
                            <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="priority" class="form-label">Priority</label>
                        <select id="priority" name="priority" class="form-select" required>
                            <option value="">Select Priority</option>
                            <option value="low" {{ old('priority', request('priority', 'medium')) === 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority', request('priority', 'medium')) === 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority', request('priority', 'medium')) === 'high' ? 'selected' : '' }}>High</option>
                            <option value="urgent" {{ old('priority', request('priority', 'medium')) === 'urgent' ? 'selected' : '' }}>Urgent</option>
                        </select>
                        @error('priority')
                            <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="scheduled_at" class="form-label">Scheduled Date & Time</label>
                    <input id="scheduled_at" class="form-input" type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at', request('scheduled_at', now()->format('Y-m-d\TH:i'))) }}">
                    @error('scheduled_at')
                        <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" class="form-textarea" name="description" rows="3" placeholder="Describe the task details...">{{ old('description', request('description', 'Routine cleaning and inspection.')) }}</textarea>
                    @error('description')
                        <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="flex justify-between" style="margin-top: 1.5rem;">
                    <a href="{{ route('housekeeping.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Task</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <header class="card-header">
        <div class="container">
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">
                Edit Room - {{ $room->room_number }}
            </h2>
        </div>
    </header>
    
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('rooms.update', $room) }}">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2" style="gap: 1rem;">
                    <div class="form-group">
                        <label for="room_number" class="form-label">Room Number</label>
                        <input id="room_number" class="form-input" type="text" name="room_number" value="{{ old('room_number', $room->room_number) }}" required>
                        @error('room_number')
                            <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="room_type" class="form-label">Room Type</label>
                        <select id="room_type" name="room_type" class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="single" {{ old('room_type', $room->room_type) === 'single' ? 'selected' : '' }}>Single</option>
                            <option value="double" {{ old('room_type', $room->room_type) === 'double' ? 'selected' : '' }}>Double</option>
                            <option value="suite" {{ old('room_type', $room->room_type) === 'suite' ? 'selected' : '' }}>Suite</option>
                            <option value="deluxe" {{ old('room_type', $room->room_type) === 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                        </select>
                        @error('room_type')
                            <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="price_per_night" class="form-label">Price per Night ($)</label>
                    <input id="price_per_night" class="form-input" type="number" step="0.01" name="price_per_night" value="{{ old('price_per_night', $room->price_per_night) }}" required>
                    @error('price_per_night')
                        <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="available" {{ old('status', $room->status) === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="occupied" {{ old('status', $room->status) === 'occupied' ? 'selected' : '' }}>Occupied</option>
                        <option value="maintenance" {{ old('status', $room->status) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="cleaning" {{ old('status', $room->status) === 'cleaning' ? 'selected' : '' }}>Cleaning</option>
                    </select>
                    @error('status')
                        <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" class="form-textarea" name="description" rows="3">{{ old('description', $room->description) }}</textarea>
                    @error('description')
                        <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex justify-between" style="margin-top: 1.5rem;">
                    <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Room</button>
                </div>
            </form>
        </div>
    </div>
@endsection 
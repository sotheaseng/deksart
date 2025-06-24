@extends('layouts.app')

@section('content')
    <header class="card-header">
        <div class="container">
            <div class="flex justify-between items-center">
                <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">
                    Rooms Management
                </h2>
                @if(auth()->user()->isAdmin() || auth()->user()->isFrontdesk())
                    <a href="{{ route('rooms.create') }}" class="btn btn-primary">
                        Add New Room
                    </a>
                @endif
            </div>
        </div>
    </header>
    
    <div class="card mt-4">
        <div class="card-body">
            @if($rooms->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Room Number</th>
                                <th>Type</th>
                                <th>Price/Night</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $room)
                                <tr>
                                    <td><strong>{{ $room->room_number }}</strong></td>
                                    <td>{{ ucfirst($room->room_type) }}</td>
                                    <td>${{ number_format($room->price_per_night, 2) }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($room->isOccupiedToday()) badge-danger
                                            @elseif($room->status === 'available') badge-success
                                            @elseif($room->status === 'maintenance') badge-warning
                                            @else badge-info @endif">
                                            {{ $room->isOccupiedToday() ? 'Occupied' : ucfirst($room->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('rooms.show', $room) }}" class="btn btn-secondary btn-sm me-2">View</a>
                                        @if(auth()->user()->isAdmin() || auth()->user()->isFrontdesk())
                                            <a href="{{ route('rooms.edit', $room) }}" class="btn btn-primary btn-sm me-2">Edit</a>
                                            @if(auth()->user()->isAdmin())
                                                <form action="{{ route('rooms.destroy', $room) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-delete btn-sm">Delete</button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $rooms->links() }}
                </div>
            @else
                <p class="text-muted text-center py-5">No rooms found.</p>
            @endif
        </div>
    </div>
@endsection

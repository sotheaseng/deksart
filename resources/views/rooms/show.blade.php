@extends('layouts.app')

@section('content')
    <header class="card-header">
        <div class="container">
            <div class="flex justify-between items-center">
                <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">
                    Room Details - {{ $room->room_number }}
                </h2>
                <div>
                    <a href="{{ route('rooms.edit', $room) }}" class="btn btn-primary" style="margin-right: 0.5rem;">Edit</a>
                    <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </header>
    <div class="card">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2" style="gap: 2rem;">
                <div>
                    <div style="margin-bottom: 1rem;"><strong>Room Number:</strong> {{ $room->room_number }}</div>
                    <div style="margin-bottom: 1rem;"><strong>Type:</strong> {{ ucfirst($room->room_type) }}</div>
                    <div style="margin-bottom: 1rem;"><strong>Price per Night:</strong> ${{ number_format($room->price_per_night, 2) }}</div>
                    <div style="margin-bottom: 1rem;"><strong>Status:</strong> 
                        <span class="badge 
                            @if($room->isOccupiedToday()) badge-danger
                            @elseif($room->status === 'available') badge-success
                            @elseif($room->status === 'maintenance') badge-warning
                            @else badge-info @endif">
                            {{ $room->isOccupiedToday() ? 'Occupied' : ucfirst($room->status) }}
                        </span>
                    </div>
                </div>
                <div>
                    <div style="margin-bottom: 1rem;"><strong>Description:</strong></div>
                    <div style="color: #6b7280;">{{ $room->description ?: 'No description provided.' }}</div>
                </div>
            </div>
        </div>
    </div>
    @if(isset($history) && $history->count() > 0)
        <div class="card" style="margin-top: 2rem;">
            <div class="card-header">
                <h3 style="font-size: 1.125rem; font-weight: 600;">Blockchain History</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>User</th>
                                <th>Timestamp</th>
                                <th>Hash</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($history as $record)
                                <tr>
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
            </div>
        </div>
    @endif
@endsection 
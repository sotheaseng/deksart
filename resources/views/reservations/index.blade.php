@extends('layouts.app')

@section('content')
    <header class="card-header">
        <div class="container">
            <div class="flex justify-between items-center">
                <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">
                    Reservations
                </h2>
                <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Back to Rooms</a>
                <a href="{{ route('reservations.create') }}" class="btn btn-primary" style="margin-left: 0.5rem;">Create Reservation</a>
            </div>
        </div>
    </header>
    <div class="card">
        <div class="card-body">
            @if($reservations->count() > 0)
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
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
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
                                    <td>
                                        {{-- Actions: View/Edit (to be implemented) --}}
                                        <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this reservation?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div style="margin-top: 1rem;">
                    {{ $reservations->links() }}
                </div>
            @else
                <p style="color: #6b7280; text-align: center; padding: 2rem;">No reservations found.</p>
            @endif
        </div>
    </div>

    <!-- Reservation Calendar -->
    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <h3 style="font-size: 1.125rem; font-weight: 600;">Reservation Calendar</h3>
        </div>
        <div class="card-body">
            <div id="reservation-calendar" style="overflow-x: auto;">
                @php
                    use Carbon\Carbon;
                    $start = Carbon::today();
                    $days = 30;
                    $dates = collect();
                    for ($i = 0; $i < $days; $i++) {
                        $dates->push($start->copy()->addDays($i));
                    }
                    $reservations = \App\Models\Reservation::with('room')->get();
                @endphp
                <table class="table" style="min-width: 1200px;">
                    <thead>
                        <tr>
                            <th>Room</th>
                            @foreach($dates as $date)
                                <th style="text-align: center; font-size: 0.9rem; white-space: nowrap;">
                                    {{ $date->format('M d') }}<br><span style="font-size: 0.8rem; color: #6b7280;">{{ $date->format('D') }}</span>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations->groupBy('room_id') as $roomId => $roomReservations)
                            @php $room = $roomReservations->first()->room; @endphp
                            <tr>
                                <td><strong>{{ $room->room_number ?? '-' }}</strong></td>
                                @foreach($dates as $date)
                                    <td style="text-align: center; padding: 0.25rem;">
                                        @foreach($roomReservations as $reservation)
                                            @if($date >= $reservation->check_in_date && $date < $reservation->check_out_date)
                                                <span class="badge @if($reservation->status === 'confirmed') badge-info @elseif($reservation->status === 'checked_in') badge-success @elseif($reservation->status === 'checked_out') badge-secondary @else badge-danger @endif" style="display: block; margin-bottom: 2px; font-size: 0.8rem;">
                                                    {{ $reservation->guest_name }}
                                                </span>
                                            @endif
                                        @endforeach
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection 
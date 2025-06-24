<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Services\BlockchainService;
use Carbon\Carbon;

class ReservationController extends Controller
{
    protected $blockchainService;

    public function __construct(BlockchainService $blockchainService)
    {
        $this->blockchainService = $blockchainService;
    }

    public function create(Request $request)
    {
        $roomId = $request->query('room_id');
        $checkIn = $request->query('check_in_date');
        $checkOut = $request->query('check_out_date');
        $roomsQuery = \App\Models\Room::query();
        if ($checkIn && $checkOut) {
            $roomsQuery->whereDoesntHave('reservations', function ($q) use ($checkIn, $checkOut) {
                $q->where(function ($query) use ($checkIn, $checkOut) {
                    $query->where('check_in_date', '<', $checkOut)
                          ->where('check_out_date', '>', $checkIn);
                });
            });
        } else {
            $roomsQuery->where('status', 'available');
        }
        $rooms = $roomsQuery->orderBy('room_number')->get();
        $room = $roomId ? \App\Models\Room::find($roomId) : null;
        return view('reservations.create', compact('room', 'rooms'));
    }

    public function store(Request $request, Room $room)
    {
        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:255',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'guests_count' => 'required|integer|min:1',
            'special_requests' => 'nullable|string',
        ]);
        $checkIn = Carbon::parse($request->input('check_in_date'));
        $checkOut = Carbon::parse($request->input('check_out_date'));
        $nights = $checkIn->diffInDays($checkOut);
        $totalAmount = $room->price_per_night * $nights;
        $reservation = Reservation::create([
            'room_id' => $room->id,
            'guest_name' => $validated['guest_name'],
            'guest_email' => $validated['guest_email'],
            'guest_phone' => $validated['guest_phone'],
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'guests_count' => $validated['guests_count'],
            'total_amount' => $totalAmount,
            'status' => 'confirmed',
            'special_requests' => $validated['special_requests'] ?? null,
            'created_by' => auth()->id(),
        ]);
        $reservation = $reservation->fresh();
        $this->blockchainService->recordTransaction($reservation, 'create');
        return redirect()->route('rooms.show', $room)->with('success', 'Reservation created!');
    }

    public function index()
    {
        $reservations = Reservation::with('room', 'creator')->orderByDesc('check_in_date')->paginate(10);
        return view('reservations.index', compact('reservations'));
    }

    public function availableRooms(Request $request)
    {
        $checkIn = $request->query('check_in_date');
        $checkOut = $request->query('check_out_date');
        if (!$checkIn || !$checkOut) {
            // Show all rooms, regardless of status
            $rooms = \App\Models\Room::orderBy('room_number')->get();
        } else {
            $rooms = \App\Models\Room::whereDoesntHave('reservations', function ($q) use ($checkIn, $checkOut) {
                $q->where(function ($query) use ($checkIn, $checkOut) {
                    $query->where('check_in_date', '<', $checkOut)
                          ->where('check_out_date', '>', $checkIn);
                });
            })->orderBy('room_number')->get();
        }
        $result = $rooms->map(function ($room) {
            return [
                'id' => $room->id,
                'room_number' => $room->room_number,
                'room_type' => $room->room_type,
                'price_per_night' => $room->price_per_night,
                'store_url' => route('reservations.store', $room),
            ];
        });
        return response()->json($result);
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete(); // Soft delete first, so deleted_at is set
        $reservation = $reservation->fresh(); // Get the updated model with deleted_at
        $this->blockchainService->recordTransaction($reservation, 'delete');
        return redirect()->route('reservations.index')->with('success', 'Reservation deleted successfully.');
    }
} 
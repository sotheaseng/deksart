<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Services\BlockchainService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected $blockchainService;

    public function __construct(BlockchainService $blockchainService)
    {
        $this->blockchainService = $blockchainService;
    }

    public function index()
    {
        $rooms = Room::paginate(10);
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|unique:rooms',
            'room_type' => 'required|in:single,double,suite,deluxe',
            'price_per_night' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'amenities' => 'nullable|array',
        ]);

        $room = Room::create($validated);
        
        // Record in blockchain
        $this->blockchainService->recordTransaction($room, 'create');

        return redirect()->route('rooms.index')->with('success', 'Room created successfully!');
    }

    public function show(Room $room)
    {
        $history = $this->blockchainService->getRecordHistory($room);
        $integrityCheck = $this->blockchainService->verifyChainIntegrity($room);
        
        return view('rooms.show', compact('room', 'history', 'integrityCheck'));
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|unique:rooms,room_number,' . $room->id,
            'room_type' => 'required|in:single,double,suite,deluxe',
            'price_per_night' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied,maintenance,cleaning',
            'description' => 'nullable|string',
            'amenities' => 'nullable|array',
        ]);

        $dataBefore = $room->toArray();
        $room->update($validated);
        
        // Record in blockchain
        $this->blockchainService->recordTransaction($room, 'update', $dataBefore);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully!');
    }

    public function destroy(Room $room)
    {
        $dataBefore = $room->toArray();
        
        // Record in blockchain before deletion
        $this->blockchainService->recordTransaction($room, 'delete', $dataBefore);
        
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully!');
    }
}

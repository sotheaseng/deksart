<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\HousekeepingController;
use App\Http\Controllers\BlockchainController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Room Management Routes (Admin and Front Desk only)
    Route::middleware('role:admin,frontdesk')->group(function () {
        Route::resource('rooms', RoomController::class);
        Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
        Route::post('/rooms/{room}/reservations', [ReservationController::class, 'store'])->name('reservations.store');
        Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    });
    
    // Housekeeping Routes (All authenticated users)
    Route::resource('housekeeping', HousekeepingController::class);
    
    // Blockchain Routes (Admin only)
    Route::middleware('role:admin')->group(function () {
        Route::get('/blockchain', [BlockchainController::class, 'index'])->name('blockchain.index');
        Route::get('/blockchain/{record}', [BlockchainController::class, 'show'])->name('blockchain.show');
        Route::get('/blockchain-verify', [BlockchainController::class, 'verify'])->name('blockchain.verify');
        Route::get('/blockchain-verify-all', [BlockchainController::class, 'verifyAllChains'])->name('blockchain.verifyAll');
        Route::post('/blockchain-clear-all', [BlockchainController::class, 'clearAll'])->name('blockchain.clearAll');
    });
});

Route::get('/api/available-rooms', [ReservationController::class, 'availableRooms']);

require __DIR__.'/auth.php';

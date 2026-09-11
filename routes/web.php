<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvitationController;

// Route untuk submit RSVP menggunakan metode POST
Route::post('/{slug}/rsvp', [InvitationController::class, 'storeRsvp'])->name('rsvp.store');

// Route utama untuk melihat undangan (Posisikan paling bawah)
Route::get('/{slug}', [InvitationController::class, 'show'])->name('invitation.show');

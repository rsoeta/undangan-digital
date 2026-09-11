<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;

class InvitationController extends Controller
{
    public function show($slug, Request $request)
    {
        // Ambil data undangan beserta semua relasinya
        $invitation = Invitation::with(['events', 'galleries', 'gifts', 'stories', 'rsvps'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Tangkap nama tamu dari URL (?to=Nama+Tamu)
        $guestName = $request->query('to', 'Tamu Undangan Spesial');

        // Mengarahkan ke file blade template (contoh: resources/views/tema-satu/index.blade.php)
        return view($invitation->theme . '.index', compact('invitation', 'guestName'));
    }

    public function storeRsvp(Request $request, $slug)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        $invitation->rsvps()->create([
            'guest_name' => $request->guest_name,
            'attendance' => $request->attendance,
            'guest_count' => $request->guest_count,
            'message' => $request->message,
        ]);

        // Response JSON ini yang akan ditangkap oleh frontend untuk menampilkan SweetAlert2 proporsional
        return response()->json([
            'status' => 'success',
            'message' => 'Terima kasih atas doa dan konfirmasinya!'
        ]);
    }
}

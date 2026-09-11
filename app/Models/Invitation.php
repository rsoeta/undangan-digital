<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    // Mengizinkan semua kolom diisi kecuali ID
    protected $guarded = ['id'];

    // Relasi One-to-Many ke tabel lain
    public function events()
    {
        return $this->hasMany(Event::class);
    }
    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
    public function gifts()
    {
        return $this->hasMany(Gift::class);
    }
    public function rsvps()
    {
        return $this->hasMany(Rsvp::class);
    }
    public function stories()
    {
        return $this->hasMany(Story::class);
    }
}

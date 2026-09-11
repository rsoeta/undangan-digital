<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            // cascadeOnDelete memastikan jika undangan dihapus, jadwal acara ikut terhapus otomatis
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // Contoh: 'Akad Nikah', 'Resepsi'
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->string('timezone', 10)->default('WIB');
            $table->string('location_name'); // Contoh: 'Masjid Agung', 'Gedung Serbaguna'
            $table->text('location_address');
            $table->text('google_maps_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

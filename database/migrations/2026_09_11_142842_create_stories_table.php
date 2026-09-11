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
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();

            $table->string('title'); // 'Pertama Bertemu', 'Lamaran'
            $table->date('date'); // Tanggal momen
            $table->text('description'); // Isi cerita
            $table->string('image')->nullable(); // Foto momen (opsional)
            $table->integer('sort_order')->default(0); // Urutan cerita

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};

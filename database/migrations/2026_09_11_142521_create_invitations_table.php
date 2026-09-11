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
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // URL unik: domain.com/rian-aqila
            $table->string('theme')->default('tema-satu'); // Nama folder template

            // Mempelai Pria
            $table->string('groom_nickname');
            $table->string('groom_fullname');
            $table->string('groom_father');
            $table->string('groom_mother');
            $table->string('groom_instagram')->nullable();

            // Mempelai Wanita
            $table->string('bride_nickname');
            $table->string('bride_fullname');
            $table->string('bride_father');
            $table->string('bride_mother');
            $table->string('bride_instagram')->nullable();

            // Aset Global
            $table->string('cover_image')->nullable();
            $table->string('background_music')->nullable();
            $table->text('quote')->nullable(); // Kutipan ayat/quotes

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};

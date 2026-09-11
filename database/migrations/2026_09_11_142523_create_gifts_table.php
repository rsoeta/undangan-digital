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
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->string('provider_name'); // Contoh: 'BCA', 'DANA', 'Alamat Rumah'
            $table->string('account_number');
            $table->string('account_name'); // Atas nama siapa
            $table->boolean('is_physical_address')->default(false); // Penanda jika ini alamat kado fisik
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gifts');
    }
};

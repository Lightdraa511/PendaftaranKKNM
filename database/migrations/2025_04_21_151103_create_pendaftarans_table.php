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
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained()->onDelete('cascade');
            $table->foreignId('tempat_kkn_id')->constrained()->onDelete('cascade');
            $table->enum('status_pembayaran', ['belum_lunas', 'lunas'])->default('belum_lunas');
            $table->timestamp('tanggal_pembayaran')->nullable();
            $table->enum('status_pendaftaran', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};

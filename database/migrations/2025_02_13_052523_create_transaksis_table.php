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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('motor_id')->constrained('motor');
            // $table->foreignId('pelanggan_id')->constrained('pelanggan');
            // $table->date('tanggal_sewa');
            // $table->date('tanggal_kembali');
            // $table->integer('total_bayar');
            $table->foreignId('penyewaan_id')->constrained('penyewaan')->onDelete('cascade');
            $table->integer('denda');
            $table->integer('total_bayar');
            $table->date('tanggal_pengembalian');
            $table->enum('status', ['dibatalkan', 'selesai']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};

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
        Schema::create('motor', function (Blueprint $table) {
            $table->id();
            $table->string('nama_motor');
            $table->foreignId('merek_id')->constrained('merek')->restrictOnDelete();
            $table->string('bahan_bakar');
            $table->string('warna');
            $table->string('foto');
            $table->integer('harga_sewa');
            $table->integer('lama_sewa');
            $table->string('nomor_polisi')->unique();
            $table->enum('status', ['tersedia', 'disewa', 'servis'])->default('tersedia');
            $table->enum('tranmisi', ['kopling', 'matic']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motor');
    }
};

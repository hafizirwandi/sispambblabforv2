<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Replikasi persis tabel `barang_bukti` dari assest/sisp4435_sipambblabfor.sql
     * agar data produksi bisa dipakai langsung tanpa proses import.
     */
    public function up(): void
    {
        Schema::create('barang_bukti', function (Blueprint $table) {
            $table->integer('id_bb', true, false);
            $table->primary('id_bb');
            $table->string('nama', 225);
            $table->integer('created_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->integer('updated_by')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_bukti');
    }
};

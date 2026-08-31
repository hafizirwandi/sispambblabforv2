<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Replikasi persis tabel `penanggung_jawab` dari assest/sisp4435_sipambblabfor.sql.
     */
    public function up(): void
    {
        Schema::create('penanggung_jawab', function (Blueprint $table) {
            $table->integer('id_pj', true, false);
            $table->primary('id_pj');
            $table->string('nama', 225);
            $table->string('nrp', 225);
            $table->string('jabatan', 225);
            $table->string('ttd', 225);
            $table->integer('created_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->integer('updated_by')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penanggung_jawab');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Replikasi persis tabel `surat` dari assest/sisp4435_sipambblabfor.sql.
     * status: 0 = draft operator, 1 = terkirim ke admin, 2 = selesai/legacy.
     */
    public function up(): void
    {
        Schema::create('surat', function (Blueprint $table) {
            $table->integer('id_surat', true, false);
            $table->primary('id_surat');
            $table->string('no_surat', 225);
            $table->integer('id_bb');
            $table->integer('id_pj');
            $table->date('tgl_surat');
            $table->string('tersangka', 225);
            $table->string('lokasi_penangkapan', 225);
            $table->time('waktu_penangkapan');
            $table->enum('status', ['0', '1', '2'])->default('0');
            $table->integer('created_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->integer('updated_by')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};

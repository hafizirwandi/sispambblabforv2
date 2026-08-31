<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Replikasi persis tabel `foto_bb` dari assest/sisp4435_sipambblabfor.sql.
     */
    public function up(): void
    {
        Schema::create('foto_bb', function (Blueprint $table) {
            $table->integer('id_fb', true, false);
            $table->primary('id_fb');
            $table->integer('id_surat');
            $table->string('foto', 225);
            $table->integer('created_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->integer('updated_by')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foto_bb');
    }
};

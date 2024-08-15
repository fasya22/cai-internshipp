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
        Schema::create('periode', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid');
            $table->string('judul_periode');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->datetime('batas_pendaftaran');
            $table->timestamps();
            $table->softDeletes();
            $table->index('uid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode');
    }
};

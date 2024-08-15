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
        Schema::create('logbook', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid');
            // $table->unsignedBigInteger('peserta_id');
            $table->date('tanggal');
            $table->unsignedBigInteger('magang_id');
            $table->string('aktivitas');
            $table->integer('status')->comment('1 Disetujui; 2 Perbaikan')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('uid');

            // $table->foreign('peserta_id')->references('id')->on('peserta')->onDelete('cascade');
            $table->foreign('magang_id')->references('id')->on('magang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbook');
    }
};

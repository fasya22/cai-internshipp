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
        Schema::create('lowongan', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid');
            $table->unsignedBigInteger('posisi_id');
            $table->unsignedBigInteger('periode_id');
            $table->integer('metode')->comment('1 remote; 2 onsite; 3 hybrid')->nullable();
            $table->integer('level')->comment('1 Junior; 2 Intermediate; 3 Senior');
            $table->text('deskripsi');
            $table->text('kualifikasi');
            $table->json('keahlian_yang_dibutuhkan');
            // $table->boolean('requires_english')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->index('uid');

            $table->foreign('posisi_id')->references('id')->on('posisi')->onDelete('cascade');
            $table->foreign('periode_id')->references('id')->on('periode')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongan');
    }
};

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
        Schema::create('magang', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid');
            $table->unsignedBigInteger('peserta_id');
            $table->unsignedBigInteger('lowongan_id');
            $table->unsignedBigInteger('mentor_id')->nullable();
            $table->text('surat_lamaran_magang');
            $table->text('cv');
            // $table->integer('jenis_sertifikat_bahasa_inggris');
            $table->unsignedBigInteger('english_certificate_id')->nullable();
            $table->integer('nilai_bahasa_inggris')->nullable();
            $table->text('sertifikat_bahasa_inggris')->nullable();
            $table->json('keahlian_yang_dimiliki');
            $table->boolean('soft_komunikasi')->nullable();
            $table->boolean('soft_tim')->nullable();
            $table->boolean('soft_adaptable')->nullable();
            $table->string('link_portfolio');
            $table->text('catatan')->nullable();
            $table->integer('status_rekomendasi')->comment('1 Direkomendasikan; 2 Tidak Direkomendasikan')->nullable();
            $table->integer('status_penerimaan')->comment('1 Diterima; 2 Ditolak')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('uid');
            $table->foreign('peserta_id')->references('id')->on('peserta')->onDelete('cascade');
            $table->foreign('lowongan_id')->references('id')->on('lowongan')->onDelete('cascade');
            $table->foreign('mentor_id')->references('id')->on('mentor')->onDelete('cascade');
            $table->foreign('english_certificate_id')->references('id')->on('english_certificates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magang');
    }
};

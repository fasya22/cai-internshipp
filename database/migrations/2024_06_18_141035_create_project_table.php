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
        Schema::create('project', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid');
            $table->unsignedBigInteger('magang_id');
            $table->string('nama_project');
            $table->text('deskripsi');
            $table->datetime('deadline');
            $table->datetime('tgl_pengumpulan')->nullable();
            $table->string('link_project')->nullable();
            $table->integer('status')->comment('1 Disetujui; 2 Perbaikan')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('magang_id')->references('id')->on('magang')->onDelete('cascade');
            $table->index('uid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project');
    }
};

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
        Schema::create('peserta', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama')->nullable();
            $table->integer('jenis_kelamin')->comment('1 laki_laki; 2 perempuan')->nullable();
            $table->string('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('institusi_pendidikan_terakhir')->nullable();
            $table->string('prodi')->nullable();
            $table->decimal('ipk', 3, 2)->nullable();
            $table->date('tanggal_mulai_studi')->nullable();
            $table->date('tanggal_berakhir_studi')->nullable();
            $table->text('kartu_identitas_studi')->nullable();
            $table->text('image')->nullable();
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
        Schema::dropIfExists('peserta');
    }
};

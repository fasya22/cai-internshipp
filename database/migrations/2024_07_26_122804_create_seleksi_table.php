<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSeleksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seleksi', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->default(DB::raw('UUID()'));
            $table->unsignedBigInteger('magang_id');
            $table->decimal('relevansi_pekerjaan', 5, 2);
            $table->decimal('keterampilan', 5, 2);
            $table->decimal('culture_fit', 5, 2);
            // Tambahkan kolom nilai kriteria lainnya jika diperlukan
            $table->decimal('nilai_seleksi', 5, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('magang_id')->references('id')->on('magang')->onDelete('cascade');
            $table->index('uid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seleksi');
    }
};


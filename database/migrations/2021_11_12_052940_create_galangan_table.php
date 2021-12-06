<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50);
            $table->string('alamat');
            $table->char('rekening', 16);
            $table->string('judul', 80);
            $table->text('deskripsi');
            $table->unsignedInteger('target');
            $table->dateTime('waktu');
            $table->string('gambar');
            $table->unsignedTinyInteger('id_kategori');
            $table->foreignId('id_penggalang')->constrained('pengguna')->cascadeOnUpdate()->cascadeOnDelete();
            $table->dateTime('tgl_diajukan')->useCurrent();
            $table->dateTime('tgl_diterima')->nullable();

            $table->foreign('id_kategori')->references('id')->on('kategori')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('galangan');
    }
}

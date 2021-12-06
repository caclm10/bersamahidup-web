<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donasi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('id_galangan')->constrained('galangan')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedInteger('nominal');
            $table->dateTime('tgl_donasi')->nullable();
            $table->char('transaksi_ref', 20);
            $table->enum('status', ['selesai', 'menunggu', 'gagal'])->default('menunggu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donasi');
    }
}

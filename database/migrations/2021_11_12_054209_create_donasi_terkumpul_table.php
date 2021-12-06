<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonasiTerkumpulTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donasi_terkumpul', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_galangan')->constrained('galangan')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedInteger('jumlah')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donasi_terkumpul');
    }
}

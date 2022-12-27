<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('film_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('film_id')->references('id')->on('films')->onDelete('cascade');
            $table->string('url_film')->nullable();
            $table->string('tahun');
            $table->date('tanggal_terbit');
            $table->integer('harga');
            $table->integer('kunjungan')->default(0);
            $table->integer('rating')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('film_details');
    }
};

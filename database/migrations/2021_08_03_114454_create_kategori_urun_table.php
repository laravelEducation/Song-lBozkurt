<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriUrunTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori_urun', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('kategori_id')->unsigned();
            $table->integer('urun_id')->unsigned();

            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade');
            $table->foreign('urun_id')->references('id')->on('urun')->onDelete('cascade');


            //$table->unsignedBigInteger('kategori_id');
          //  $table->unsignedBigInteger('urun_id');

          //  $table->foreignId('kategori_id')->constrained();
          //  $table->foreignId('urun_id')->constrained();

//            $table->foreignId('kategori_id')->constrained()->cascadeOnDelete();
          //  $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('casceda');
          //  $table->foreign('urun_id')->references('id')->on('urun')->onDelete('casceda');






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
        Schema::dropIfExists('kategori_urun');
    }
}

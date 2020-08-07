<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeritaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->string("berita_id")->primary();
            $table->string("berita_link")->nullable();
            $table->string("berita_judul")->nullable();
            $table->text("berita_isi")->nullable();
            $table->text("gambar_link")->nullable();
            $table->text("pdf_link")->nullable();
            $table->date('berita_tanggal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('berita');
    }
}

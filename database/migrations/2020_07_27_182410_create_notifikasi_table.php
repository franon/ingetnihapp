<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->string("notifikasi_id")->primary();
            $table->string("message")->nullable();
            $table->string("user_id")->nullable();
            $table->string("event_id")->nullable();
            $table->string("berita_id")->nullable();
            $table->string("group_id")->nullable();
            $table->date("date_notified")->nullable();
            $table->tinyInteger("already_notified")->nullable();
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
        Schema::dropIfExists('notifikasi');
    }
}

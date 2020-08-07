<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJabatanUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jabatan_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("user_id")->references('user_id')->on('pengguna')->onDelete('cascade');
            $table->string("jabatan_id")->references("jabatan_id")->on('jabatan')->onDelete('cascade');
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
        Schema::dropIfExists('jabatan_user');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenggunaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->string('user_id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role_id',5);
            $table->tinyInteger('is_active');
            $table->rememberToken();
            $table->string('device_token')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('gender',1)->nullable();
            $table->string('jabatan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_event');
        Schema::dropIfExists('group_users');
        Schema::dropIfExists('jabatan_user');
        Schema::dropIfExists('pengguna');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcaraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acara', function (Blueprint $table) {
            $table->string('event_id',255)->primary();
            $table->string('user_id');
            $table->string('event_name', 255);
            $table->text('event_detail')->nullable();
            $table->date('event_date');
            $table->date('event_date_end')->nullable();
            $table->time('event_time')->nullable();
            $table->date('remind_to')->nullable();
            $table->string('tag_id')->nullable();
            $table->string('created_by');
            $table->string('views');
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
        Schema::dropIfExists('acara');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('event_reminder', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('event_id',255);
        //     $table->bigInteger('user_id');
        //     $table->dateTime('remind_date');
        //     $table->boolean('repeat')->nullable();
        //     $table->timestamps();

        //     $table->index(['event_id', 'event_date']);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('event_reminders');
    }
}

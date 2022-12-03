<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_conditions', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->date('date');
            $table->foreignId('room_id')->constrained('rooms');
            $table->foreignId('reservation_id')->constrained('reservations');
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
        Schema::dropIfExists('room_conditions');
    }
}

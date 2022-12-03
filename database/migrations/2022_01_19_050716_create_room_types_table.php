<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('channex_room_type_id');
            $table->string('reference_code');
            $table->string('description');
            $table->integer('type_status');
            $table->integer('adults_channex');
            $table->integer('kids_channex');
            $table->integer('infants_channex');
            $table->integer('default_occupancy_channex');
            $table->integer('position');
            $table->integer('cancellation_charge');
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
        Schema::dropIfExists('room_types');
    }
}

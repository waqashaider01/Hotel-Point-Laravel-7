<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ex_reservations', function (Blueprint $table) {
            $table->id();
            $table->integer('indexes');
            $table->string('booking_code');
            $table->date('check_in');
            $table->date('check_out');
            $table->date('booking_date');
            $table->float('total_amount');
            $table->string('status');
            $table->foreignId('booking_agency_id')->constrained('booking_agencies');
            $table->foreignId('country_id')->constrained('countries');
            $table->foreignId('room_type_id')->constrained('room_types');
            $table->foreignId('guest_id')->constrained('guests');
            $table->foreignId('rate_type_id')->constrained('rate_types');
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
        Schema::dropIfExists('ex_reservations');
    }
}

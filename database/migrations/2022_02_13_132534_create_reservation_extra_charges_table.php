<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationExtraChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_extra_charges', function (Blueprint $table) {
            $table->id();
            $table->integer('units');
            $table->float('extra_charge_total');
            $table->string('receipt_number');
            $table->date('date');
            $table->time('time');
            $table->float('extra_charge_discount');
            $table->integer('is_paid')->default(0);
            $table->foreignId('extra_charge_id')->constrained('extra_charges');
            $table->foreignId('reservation_id')->constrained('reservations');
            $table->foreignId('payment_method_id')->nullable();
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
        Schema::dropIfExists('reservation_extra_charges');
    }
}

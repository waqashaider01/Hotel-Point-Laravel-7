<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_deposits', function (Blueprint $table) {
            $table->id();
            $table->integer('has_prepayment');
            $table->float('prepayment_value')->nullable();
            $table->date('prepayment_date_to_pay')->nullable();
            $table->integer('prepayment_is_paid')->nullable();
            $table->date('prepayment_payment_date')->nullable();
            $table->integer('has_first_charge');
            $table->float('first_charge_value')->nullable();
            $table->date('first_charge_date_to_pay')->nullable();
            $table->integer('first_charge_is_paid')->nullable();
            $table->date('first_charge_payment_date')->nullable();
            $table->integer('has_second_charge');
            $table->float('second_charge_value')->nullable();
            $table->date('second_charge_date_to_pay')->nullable();
            $table->integer('second_charge_is_paid')->nullable();
            $table->date('second_charge_payment_date')->nullable();
            $table->foreignId('reservation_id')->nullable()->constrained('reservations');
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
        Schema::dropIfExists('reservation_deposits');
    }
}

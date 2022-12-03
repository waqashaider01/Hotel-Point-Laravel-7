<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestExtrasPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_extras_payments', function (Blueprint $table) {
            $table->id();
            $table->float('value');
            $table->date('date');
            $table->text('comments')->nullable();
            $table->string('transaction_id')->nullable();
            $table->foreignId('reservation_id')->constrained('reservations');
            $table->foreignId('payment_method_id')->constrained('payment_methods');
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
        Schema::dropIfExists('guest_extras_payments');
    }
}

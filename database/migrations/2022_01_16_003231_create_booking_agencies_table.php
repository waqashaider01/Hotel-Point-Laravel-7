<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_agencies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('bg')->nullable();
            $table->string('activity');
            $table->integer('vat_number');
            $table->string('tax_office');
            $table->string('address');
            $table->string('category');
            $table->string('headquarters');
            $table->string('branch');
            $table->string('postal_code');
            $table->string('phone_number');
            $table->string('country');
            $table->string('channex_channel_id');
            $table->foreignId('default_payment_mode_id')->nullable()->constrained('payment_modes');
            $table->string('supports_virtual_card')->nullable();
            $table->foreignId('virtual_card_payment_mode_id')->nullable()->constrained('payment_modes');
            $table->foreignId('default_payment_method_id')->nullable()->constrained('payment_methods');
            $table->string('charge_date_days')->nullable();
            $table->string('channel_code')->nullable();
            $table->string('charge_mode')->nullable();
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
        Schema::dropIfExists('booking_agencies');
    }
}

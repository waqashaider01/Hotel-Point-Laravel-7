<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo');
            $table->string('name');
            $table->string('brand_name');
            $table->string('activity');
            $table->integer('tax_id');
            $table->string('tax_office');
            $table->integer('general_commercial_register');
            $table->string('address');
            $table->integer('postal_code');
            $table->string('city');
            $table->string('phone');
            $table->string('website');
            $table->string('email');
            $table->string('notification_receiver_email');
            $table->integer('vat');
            $table->float('city_tax');
            $table->integer('cancellation_vat');
            $table->float('overnight_tax');
            $table->longText('cookie_value');
            $table->time('ordered_checkin_hour');
            $table->time('ordered_checkout_hour');
            $table->integer('housekeeping');
            $table->foreignId('currency_id')->constrained('currencies');
            $table->date('date');
            $table->string('cashier_pass');
            $table->float('complimentary_rate');
            $table->string('bank_name');
            $table->string('swift_code');
            $table->string('iban');
            $table->boolean('bank_status');
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
        Schema::dropIfExists('hotel_settings');
    }
}

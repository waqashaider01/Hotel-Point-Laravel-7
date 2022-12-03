<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->nullable();
            $table->string('channex_status')->nullable();
            $table->string('status');
            $table->unsignedBigInteger('booking_agency_id');
            $table->foreign('booking_agency_id')->references('id')->on('booking_agencies')->onDelete('cascade');
            $table->string('revenue_amount_accommodation')->nullable();
            $table->string('charge_date')->nullable();
            $table->unsignedBigInteger('payment_method_id');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('cascade');
            $table->unsignedBigInteger('payment_mode_id');
            $table->foreign('payment_mode_id')->references('id')->on('payment_modes')->onDelete('cascade');
            $table->string('discount');
            $table->date('check_in');
            $table->date('check_out');
            $table->date('arrival_date');
            $table->date('departure_date');
            $table->date('actual_checkin')->nullable();
            $table->date('actual_checkout')->nullable();
            $table->String('overnights')->nullable();
            $table->time('arrival_hour')->nullable();
            $table->date('cancellation_date')->nullable();
            $table->date('offer_expire_date')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->integer('adults');
            $table->integer('kids');
            $table->integer('infants');
            $table->date('booking_date');
            $table->string('comment')->nullable();
            $table->unsignedBigInteger('guest_id');
            $table->foreign('guest_id')->references('id')->on('guests')->onDelete('cascade');
            $table->unsignedBigInteger('checkin_guest_id')->nullable();
            $table->foreign('checkin_guest_id')->references('id')->on('guests')->onDelete('cascade');
            $table->unsignedBigInteger('rate_type_id');
            $table->foreign('rate_type_id')->references('id')->on('rate_types')->onDelete('cascade');
            $table->unsignedBigInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->float('reservation_amount')->nullable();
            $table->float('commission_amount')->nullable();
            $table->integer('reservation_revision_id')->nullable();
            $table->integer('system_id')->nullable();
            $table->dateTime('reservation_inserted_at')->nullable();
            $table->integer('reservation_payment_collect')->nullable();
            $table->string('channex_booking_room_id')->nullable();
            $table->string('reservation_unique_id')->nullable();
            $table->string('ota_reservation_code')->nullable();
            $table->integer('virtual_card')->nullable();
            $table->integer('notif_status')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->integer('channex_cards')->nullable();
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
        Schema::dropIfExists('reservations');
    }
}

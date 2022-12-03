<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChannexColumnsToReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('channex_booking_id', 255)->nullable()->after('booking_code');
            $table->string('reservation_revision_id', 255)->nullable()->change();
            $table->string('system_id', 255)->nullable()->change();
            $table->string('reservation_payment_collect', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('channex_booking_id');
            $table->bigInteger('reservation_revision_id')->nullable()->change();
            $table->bigInteger('system_id')->nullable()->change();
            $table->bigInteger('reservation_payment_collect')->nullable()->change();
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOxygenIdColumnToBookingAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_agencies', function (Blueprint $table) {
            $table->string('oxygen_id', 255)->nullable()->after('hotel_settings_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_agencies', function (Blueprint $table) {
            $table->dropColumn('oxygen_id');
        });
    }
}

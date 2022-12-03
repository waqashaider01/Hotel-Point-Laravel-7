<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOxygenApiKeyColumnToHotelSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotel_settings', function (Blueprint $table) {
            $table->string('oxygen_api_key', 255)->nullable()->after('bank_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotel_settings', function (Blueprint $table) {
            $table->dropColumn('oxygen_api_key');
        });
    }
}

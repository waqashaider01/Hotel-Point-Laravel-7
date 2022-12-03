<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysInCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->renameColumn('country', 'country_id');
            
        });

        Schema::table('companies', function (Blueprint $table) {
            //
            // $table->foreignIdFor(HotelSetting::class, 'hotel_settings_id');
            $table->bigInteger('hotel_settings_id')->unsigned()->change();
            $table->foreign('hotel_settings_id')->references('id')->on('hotel_settings');
            $table->bigInteger('country_id')->unsigned()->change();
            $table->foreign('country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            //
        });
    }
}

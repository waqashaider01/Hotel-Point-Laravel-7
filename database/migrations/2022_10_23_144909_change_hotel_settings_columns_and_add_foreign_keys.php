<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeHotelSettingsColumnsAndAddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotel_settings', function (Blueprint $table) {
            $table->renameColumn('overnight_tax', 'overnight_tax_id');
            $table->renameColumn('vat', 'vat_id');
            $table->renameColumn('cancellation_vat', 'cancellation_vat_id');

        });

        Schema::table('hotel_settings', function (Blueprint $table) {
            $table->bigInteger('overnight_tax_id')->unsigned()->nullable()->change();
            $table->bigInteger('vat_id')->unsigned()->nullable()->change();
            $table->bigInteger('cancellation_vat_id')->unsigned()->nullable()->change();
            $table->foreign('overnight_tax_id')->references('id')->on('hotel_tax_categories');
            $table->foreign('vat_id')->references('id')->on('hotel_vats');
            $table->foreign('cancellation_vat_id')->references('id')->on('hotel_vats');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('hotel_settings', function (Blueprint $table) {
        //     $table->renameColumn('overnight_tax', 'overnight_tax_id');
        //     $table->renameColumn('vat', 'vat_id');
        //     $table->renameColumn('cancellation_vat', 'cancellation_vat_id');

        // });
    }
}

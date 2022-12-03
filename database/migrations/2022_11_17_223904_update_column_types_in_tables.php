<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnTypesInTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotel_settings', function (Blueprint $table) {
             $table->string('tax_id')->change();
             $table->string('general_commercial_register')->change();
        });

        Schema::table('rate_types', function (Blueprint $table) {
            $table->integer('parent_rate_plan_id')->nullable()->change();
            
       });

      
       Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign('reservations_room_id_foreign');
            $table->bigInteger('room_id')->unsigned()->nullable()->change();
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('table', function (Blueprint $table) {
            //
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOccupancyPaymentLogicColumnToRateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rate_types', function (Blueprint $table) {
            $table->text('occupancy_logic')->nullable()->after('cascade_select_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rate_types', function (Blueprint $table) {
            $table->dropColumn('occupancy_logic');
        });
    }
}

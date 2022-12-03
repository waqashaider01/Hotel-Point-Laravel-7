<?php

use App\Models\HotelSetting;
use App\Models\Template;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHotelSettingsIdToTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->foreignIdFor(HotelSetting::class, 'hotel_settings_id')->after('id');
            $table->foreign('hotel_settings_id')->references('id')->on('hotel_settings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->dropForeign('templates_hotel_settings_id_foreign');
            $table->dropColumn("hotel_settings_id");
        });
    }
}

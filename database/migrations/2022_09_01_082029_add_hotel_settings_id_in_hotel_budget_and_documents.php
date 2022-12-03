<?php
use App\Models\HotelSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHotelSettingsIdInHotelBudgetAndDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotel_budgets', function (Blueprint $table) {
            $table->foreignIdFor(HotelSetting::class, 'hotel_settings_id')->after('id');
            $table->foreign('hotel_settings_id')->references('id')->on('hotel_settings');
        });

        Schema::table('opex_data', function (Blueprint $table) {
            $table->foreignIdFor(HotelSetting::class, 'hotel_settings_id')->after('id');
            $table->foreign('hotel_settings_id')->references('id')->on('hotel_settings');
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->foreignIdFor(HotelSetting::class, 'hotel_settings_id')->after('id');
            $table->foreign('hotel_settings_id')->references('id')->on('hotel_settings');
        });

        Schema::table('breakfast_percentages', function (Blueprint $table) {
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
        Schema::table('hotel_budgets', function (Blueprint $table) {
            $table->dropForeign('hotel_budgets_hotel_settings_id_foreign');
            $table->dropColumn("hotel_settings_id");
        });

        Schema::table('opex_data', function (Blueprint $table) {
            $table->dropForeign('opex_data_hotel_settings_id_foreign');
            $table->dropColumn("hotel_settings_id");
        });

        Schema::table('breakfast_percentages', function (Blueprint $table) {
            $table->dropForeign('breakfast_percentages_hotel_settings_id_foreign');
            $table->dropColumn("hotel_settings_id");
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropForeign('suppliers_hotel_settings_id_foreign');
            $table->dropColumn("hotel_settings_id");
        });
    }
}

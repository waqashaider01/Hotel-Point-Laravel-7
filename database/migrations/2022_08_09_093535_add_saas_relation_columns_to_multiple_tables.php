<?php

use App\Models\HotelSetting;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSaasRelationColumnsToMultipleTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotel_settings', function (Blueprint $table) {
            $table->foreignIdFor(User::class, 'created_by_id')->after('id');
            $table->foreign('created_by_id')->references('id')->on('users');
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->foreignIdFor(HotelSetting::class, 'hotel_settings_id')->after('id');
            $table->foreign('hotel_settings_id')->references('id')->on('hotel_settings');
        });

        Schema::table('ex_reservations', function (Blueprint $table) {
            $table->foreignIdFor(HotelSetting::class, 'hotel_settings_id')->after('id');
            $table->foreign('hotel_settings_id')->references('id')->on('hotel_settings');
        });

        Schema::table('room_types', function (Blueprint $table) {
            $table->foreignIdFor(HotelSetting::class, 'hotel_settings_id')->after('id');
            $table->foreign('hotel_settings_id')->references('id')->on('hotel_settings');
        });

        Schema::table('rate_types', function (Blueprint $table) {
            $table->foreignIdFor(HotelSetting::class, 'hotel_settings_id')->after('id');
            $table->foreign('hotel_settings_id')->references('id')->on('hotel_settings');
        });

        Schema::table('rate_type_cancellation_policies', function (Blueprint $table) {
            $table->foreignIdFor(HotelSetting::class, 'hotel_settings_id')->after('id');
            $table->foreign('hotel_settings_id')->references('id')->on('hotel_settings');
        });

        Schema::table('rate_type_categories', function (Blueprint $table) {
            $table->foreignIdFor(HotelSetting::class, 'hotel_settings_id')->after('id');
            $table->foreign('hotel_settings_id')->references('id')->on('hotel_settings');
        });

        Schema::table('document_types', function (Blueprint $table) {
            $table->foreignIdFor(HotelSetting::class, 'hotel_settings_id')->after('id');
            $table->foreign('hotel_settings_id')->references('id')->on('hotel_settings');

            $table->unsignedInteger('type')->after('hotel_settings_id');
            $table->string('language', 255)->after('type');
        });

        Schema::table('booking_agencies', function (Blueprint $table) {
            $table->foreignIdFor(HotelSetting::class, 'hotel_settings_id')->after('id');
            $table->foreign('hotel_settings_id')->references('id')->on('hotel_settings');
        });

        Schema::table('payment_modes', function (Blueprint $table) {
            $table->foreignIdFor(HotelSetting::class, 'hotel_settings_id')->after('id');
            $table->foreign('hotel_settings_id')->references('id')->on('hotel_settings');
        });

        Schema::table('payment_methods', function (Blueprint $table) {
            $table->foreignIdFor(HotelSetting::class, 'hotel_settings_id')->after('id');
            $table->foreign('hotel_settings_id')->references('id')->on('hotel_settings');
        });

        Schema::table('extra_charges_categories', function (Blueprint $table) {
            $table->foreignIdFor(HotelSetting::class, 'hotel_settings_id')->after('id');
            $table->foreign('hotel_settings_id')->references('id')->on('hotel_settings');
        });

        Schema::table('extra_charges_types', function (Blueprint $table) {
            $table->foreignIdFor(HotelSetting::class, 'hotel_settings_id')->after('id');
            $table->foreign('hotel_settings_id')->references('id')->on('hotel_settings');
        });

        Schema::table('extra_charges', function (Blueprint $table) {
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
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign('reservations_hotel_settings_id_foreign');
            $table->dropColumn("hotel_settings_id");
        });

        Schema::table('ex_reservations', function (Blueprint $table) {
            $table->dropForeign('ex_reservations_hotel_settings_id_foreign');
            $table->dropColumn("hotel_settings_id");
        });

        Schema::table('room_types', function (Blueprint $table) {
            $table->dropForeign('room_types_hotel_settings_id_foreign');
            $table->dropColumn("hotel_settings_id");
        });

        Schema::table('rate_types', function (Blueprint $table) {
            $table->dropForeign('rate_types_hotel_settings_id_foreign');
            $table->dropColumn("hotel_settings_id");
        });

        Schema::table('rate_type_cancellation_policies', function (Blueprint $table) {
            $table->dropForeign('rate_type_cancellation_policies_hotel_settings_id_foreign');
            $table->dropColumn("hotel_settings_id");
        });

        Schema::table('rate_type_categories', function (Blueprint $table) {
            $table->dropForeign('rate_type_categories_hotel_settings_id_foreign');
            $table->dropColumn("hotel_settings_id");
        });

        Schema::table('document_types', function (Blueprint $table) {
            $table->dropForeign('document_types_hotel_settings_id_foreign');
            $table->dropColumn("hotel_settings_id");
            $table->dropColumn('type')->after('hotel_settings_id');
            $table->dropColumn('language')->after('hotel_settings_id');
        });

        Schema::table('booking_agencies', function (Blueprint $table) {
            $table->dropForeign('booking_agencies_hotel_settings_id_foreign');
            $table->dropColumn("hotel_settings_id");
        });

        Schema::table('payment_modes', function (Blueprint $table) {
            $table->dropForeign('payment_modes_hotel_settings_id_foreign');
            $table->dropColumn("hotel_settings_id");
        });

        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropForeign('payment_methods_hotel_settings_id_foreign');
            $table->dropColumn("hotel_settings_id");
        });

        Schema::table('extra_charges_categories', function (Blueprint $table) {
            $table->dropForeign('extra_charges_categories_hotel_settings_id_foreign');
            $table->dropColumn("hotel_settings_id");
        });

        Schema::table('extra_charges_types', function (Blueprint $table) {
            $table->dropForeign('extra_charges_types_hotel_settings_id_foreign');
            $table->dropColumn("hotel_settings_id");
        });

        Schema::table('extra_charges', function (Blueprint $table) {
            $table->dropForeign('extra_charges_hotel_settings_id_foreign');
            $table->dropColumn("hotel_settings_id");
        });
    }
}

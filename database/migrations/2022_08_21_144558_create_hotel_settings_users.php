<?php

use App\Models\HotelSetting;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelSettingsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_settings_users', function (Blueprint $table) {
            $table->foreignIdFor(HotelSetting::class, 'hotel_settings_id');
            $table->foreign('hotel_settings_id')->references('id')->on('hotel_settings');
            $table->foreignIdFor(User::class, 'user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_settings_users');
    }
}

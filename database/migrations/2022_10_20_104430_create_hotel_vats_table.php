<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\HotelSetting;
use App\Models\VatOption;

class CreateHotelVatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_vats', function (Blueprint $table) {
            $table->id();
            $table->string("oxygen_id")->nullable();
            $table->foreignIdFor(HotelSetting::class, 'hotel_settings_id');
            $table->foreign('hotel_settings_id')->references('id')->on('hotel_settings');
            $table->foreignIdFor(VatOption::class, 'vat_option_id');
            $table->foreign('vat_option_id')->references('id')->on('vat_options');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_vats');
    }
}

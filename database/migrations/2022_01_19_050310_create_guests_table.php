<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('hotel_settings_id');
            $table->string('full_name');
            $table->string('email');
            $table->string('email_2')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('language')->nullable();
            $table->string('phone');
            $table->string('mobile')->nullable();
            $table->string('postal_code')->nullable();
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
        Schema::dropIfExists('guests');
    }
}

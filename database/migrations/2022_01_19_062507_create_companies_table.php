<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('hotel_settings_id');
            $table->string('name');
            $table->string('activity')->nullable();
            $table->integer('vat_number')->nullable();
            $table->string('tax_office')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('category')->nullable();
            $table->string('headquarters')->nullable();
            $table->string('branch')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('country')->nullable();
            $table->double('discount')->nullable();
            $table->boolean('has_community_vat')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
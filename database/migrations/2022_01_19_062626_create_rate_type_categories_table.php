<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRateTypeCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_type_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('charge_percentage');
            $table->string('vat');
            $table->string('desc_to_document');
            $table->string('has_breakfast');
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
        Schema::dropIfExists('rate_type_categories');
    }
}

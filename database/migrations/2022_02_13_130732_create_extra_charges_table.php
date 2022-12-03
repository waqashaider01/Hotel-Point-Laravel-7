<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_charges', function (Blueprint $table) {
            $table->id();
            $table->string('product');
            $table->string('status');
            $table->string('vat');
            $table->float('unit_price');
            $table->foreignId('extra_charge_category_id')->constrained('extra_charges_categories');
            $table->foreignId('extra_charge_type_id')->constrained('extra_charges_types');
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
        Schema::dropIfExists('extra_charges');
    }
}

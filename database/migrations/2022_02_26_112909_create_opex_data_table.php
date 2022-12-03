<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpexDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opex_data', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('invoice_number');
            $table->string('invoice_type');
            $table->string('amount');
            $table->string('vat');
            $table->string('payment');
            $table->string('file');
            $table->string('bill_no');
            $table->foreignId('cos_id')->constrained('cost_of_sales');
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('description_id')->constrained('descriptions');
            $table->foreignId('supplier_id')->constrained('suppliers');
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
        Schema::dropIfExists('opex_data');
    }
}

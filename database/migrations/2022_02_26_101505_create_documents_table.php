<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("hotel_settings_id");
            $table->string('row', 25);
            $table->integer('enumeration');
            $table->date('print_date');
            $table->string('print_path')->nullable();
            $table->string('total');
            $table->text('comments');
            $table->integer('vat');
            $table->float('city_vat')->nullable();
            $table->float('taxable_amount')->nullable();
            $table->float('discount')->nullable();
            $table->float('net_value')->nullable();
            $table->float('discount_net_value')->nullable();
            $table->float('municipal_tax')->nullable();
            $table->float('tax')->nullable();
            $table->float('tax_2')->nullable();
            $table->float('paid');
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->foreignId('document_type_id')->constrained('document_types');
            $table->string("mark_id")->nullable();
            $table->string("uid")->nullable();
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
        Schema::dropIfExists('documents');
    }
}
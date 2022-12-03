<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_budgets', function (Blueprint $table) {
            $table->id();
            $table->integer('type');
            $table->integer('category');
            $table->integer('sub_category');
            $table->integer('budget_year');
            $table->string('january')->default('0');
            $table->string('february')->default('0');
            $table->string('march')->default('0');
            $table->string('april')->default('0');
            $table->string('may')->default('0');
            $table->string('june')->default('0');
            $table->string('july')->default('0');
            $table->string('august')->default('0');
            $table->string('september')->default('0');
            $table->string('october')->default('0');
            $table->string('november')->default('0');
            $table->string('december')->default('0');
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
        Schema::dropIfExists('hotel_budgets');
    }
}

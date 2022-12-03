<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestrictionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restrictions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date');
            $table->string('value');
            $table->foreignId('room_type_id')->constrained('room_types');
            $table->foreignId('rate_type_id')->constrained('rate_types');
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
        Schema::dropIfExists('restrictions');
    }
}

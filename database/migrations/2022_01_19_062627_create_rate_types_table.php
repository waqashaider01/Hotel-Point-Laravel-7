<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('status')->default(0);
            $table->integer('reservation_rate');
            $table->integer('charge');
            $table->integer('charge_type');
            $table->integer('reservation_charge_days');
            $table->integer('charge2');
            $table->integer('reservation_charge_days_2');
            $table->integer('charge_percentage');
            $table->integer('no_show_charge_percentage');
            $table->integer('early_checkout_charge_percentage');
            $table->string('description_to_document')->nullable();
            $table->integer('prepayment')->nullable();
            $table->string('channex_id');
            $table->unsignedBigInteger('room_type_id');
            $table->foreign('room_type_id')->references('id')->on('room_types')->onDelete('cascade');
            $table->unsignedBigInteger('rate_type_category_id');
            $table->foreign('rate_type_category_id')->references('id')->on('rate_type_categories')->onDelete('cascade');
            $table->integer('primary_occupancy');
            $table->integer('parent_rate_plan_id');
            $table->string('sell_mode');
            $table->string('rate_mode');
            $table->integer('cancellation_charge');
            $table->integer('cancellation_charge_days');
            $table->integer('reference_code');
            $table->unsignedBigInteger('rate_type_cancellation_policy_id');
            $table->foreign('rate_type_cancellation_policy_id')->references('id')->on('rate_type_cancellation_policies')->onDelete('cascade');
            $table->string('children_fee')->nullable();
            $table->string('infant_fee')->nullable();
            $table->string('auto_rate_increase_type')->nullable();
            $table->string('auto_rate_increase_vale')->nullable();
            $table->string('auto_rate_decrease_type')->nullable();
            $table->string('auto_rate_decrease_vale')->nullable();
            $table->string('cascade_select_type')->nullable();
            $table->string('cascade_select_value')->nullable();
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
        Schema::dropIfExists('rate_types');
    }
}

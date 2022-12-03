<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class ModifyIndexesAndGuestIdColumnsOfExReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ex_reservations', function($table){
            $table->integer('indexes')->nullable()->change();
            $table->foreignId('guest_id')->nullable()->change();
            $table->string('guests')->nullable()->after('total_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ex_reservations', function($table){
            $table->integer('indexes')->change();
            $table->foreignId('guest_id')->change();
            $table->dropColumn('guests');
        });
    }
}

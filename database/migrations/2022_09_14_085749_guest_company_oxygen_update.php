<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GuestCompanyOxygenUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->string('oxygen_id')->nullable()->after('postal_code');
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->string('oxygen_id')->nullable()->after('has_community_vat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropColumn('oxygen_id');
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('oxygen_id');
        });
    }
}
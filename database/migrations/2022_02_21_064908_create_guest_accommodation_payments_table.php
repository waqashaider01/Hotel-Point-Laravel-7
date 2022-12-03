
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestAccommodationPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_accommodation_payments', function (Blueprint $table) {
            $table->id();
            $table->float('value');
            $table->date('date');
            $table->text('comments')->nullable();
            $table->string('transaction_id')->nullable();
            $table->tinyInteger('is_deposit')->default(0);
            $table->foreignId('reservation_id')->constrained('reservations');
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->foreignId('deposit_type_id')->nullable()->constrained('deposit_types');
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
        Schema::dropIfExists('guest_accommodation_payments');
    }
}

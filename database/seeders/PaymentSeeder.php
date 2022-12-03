<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use App\Models\PaymentMode;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create(['name'=>'Cash','commission_percentage'=>'0','is_card_type'=>0,'channex_id'=>'Cash']);
        PaymentMethod::create(['name'=>'Visa','commission_percentage'=>'10','is_card_type'=>1,'channex_id'=>'VI']);
        PaymentMethod::create(['name'=>'Master Card','commission_percentage'=>'23','is_card_type'=>1,'channex_id'=>'MC']);
        PaymentMethod::create(['name'=>'American Express','commission_percentage'=>'12','is_card_type'=>1,'channex_id'=>'AX']);
        PaymentMethod::create(['name'=>'Maestro','commission_percentage'=>'12','is_card_type'=>1,'channex_id'=>'MA']);
        PaymentMethod::create(['name'=>'Debtor','commission_percentage'=>'12','is_card_type'=>0,'channex_id'=>'Deptor']);
        PaymentMethod::create(['name'=>'Bank Transfer','commission_percentage'=>'12','is_card_type'=>0,'channex_id'=>'Bank']);
        PaymentMethod::create(['name'=>'UnionPay','commission_percentage'=>'12','is_card_type'=>0,'channex_id'=>'UP']);
        PaymentMethod::create(['name'=>'Paypal','commission_percentage'=>'12','is_card_type'=>0,'channex_id'=>'Paypal']);
        PaymentMode::create(['id'=>1,'name'=>'Guests Settles Extras']);
        PaymentMode::create(['id'=>2,'name'=>'Pay Own Account']);
        PaymentMode::create(['id'=>3,'name'=>'Company Full Account ']);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static $types = [
        'American Express' => [
            'name_en' => 'American Express',
            'name_gr' => 'American Express',
            'channex_code' => 'AX',
            'mydata_code' => 6
        ],
        'BC' => [
            'name_en' => 'BC',
            'name_gr' => 'BC',
            'channex_code' => 'BC',
            'mydata_code' => 6
        ],
        'BL' => [
            'name_en' => 'BL',
            'name_gr' => 'BL',
            'channex_code' => 'BL',
            'mydata_code' => 6
        ],
        'Credit Union' => [
            'name_en' => 'Credit Union',
            'name_gr' => 'Credit Union',
            'channex_code' => 'CU',
            'mydata_code' => 6
        ],
        'Dinners Club' => [
            'name_en' => 'Dinners Club',
            'name_gr' => 'Dinners Club',
            'channex_code' => 'DN',
            'mydata_code' => 6
        ],
        'Discover' => [
            'name_en' => 'Discover',
            'name_gr' => 'Discover',
            'channex_code' => 'DS',
            'mydata_code' => 6
        ],
        'ELO' => [
            'name_en' => 'ELO',
            'name_gr' => 'ELO',
            'channex_code' => 'EL',
            'mydata_code' => 6
        ],
        'JS' => [
            'name_en' => 'JS',
            'name_gr' => 'JS',
            'channex_code' => 'JS',
            'mydata_code' => 6
        ],
        'Maestro' => [
            'name_en' => 'Maestro',
            'name_gr' => 'Maestro',
            'channex_code' => 'MA',
            'mydata_code' => 6
        ],
        'Master Card' => [
            'name_en' => 'Master Card',
            'name_gr' => 'Master Card',
            'channex_code' => 'MC',
            'mydata_code' => 6
        ],
        'Mir' => [
            'name_en' => 'Mir',
            'name_gr' => 'Mir',
            'channex_code' => 'MI',
            'mydata_code' => 6
        ],
        'Visa' => [
            'name_en' => 'Visa',
            'name_gr' => 'Visa',
            'channex_code' => 'VI',
            'mydata_code' => 6
        ],
        'Cash' => [
            'name_en' => 'Cash',
            'name_gr' => 'Cash',
            'channex_code' => 'Cash',
            'mydata_code' => 6
        ],
        'Debtor' => [
            'name_en' => 'Debtor',
            'name_gr' => 'Debtor',
            'channex_code' => 'Debtor',
            'mydata_code' => 6
        ],
        'Bank Transfer' => [
            'name_en' => 'Bank Transfer',
            'name_gr' => 'Bank Transfer',
            'channex_code' => 'Bank',
            'mydata_code' => 6
        ],
        'UnionPay' => [
            'name_en' => 'Union Pay',
            'name_gr' => 'Union Pay',
            'channex_code' => 'UP',
            'mydata_code' => 6
        ],
        'PayPal' => [
            'name_en' => 'Paypal',
            'name_gr' => 'Paypal',
            'channex_code' => 'Paypal',
            'mydata_code' => 6
        ],
        'Bank Deposit / Transfer' => [
            'name_en' => 'Bank Deposit / Transfer',
            'name_gr' => 'Bank Deposit / Transfer',
            'channex_code' => 'Bank Deposit/Transfer',
            'mydata_code' => 6
        ],
        'Credit Card' => [
            'name_en' => 'Credit Card',
            'name_gr' => 'Credit Card',
            'channex_code' => 'Credit Card',
            'mydata_code' => 6
        ],
        'Check' => [
            'name_en' => 'Check',
            'name_gr' => 'Check',
            'channex_code' => 'Check',
            'mydata_code' => 6
        ],
    ];

    public static $payment_method_codes=[
          "VI" => "VI",
          "Visa" => "VI",
          "visa" => "VI",
          "master_card" => "MC",
          "MasterCard" => "MC",
          "mastercard"=> "MC",
          "MC" => "MC",
          "american_express" => "AX",
          "AmericanExpress" => "AX",
          "american-express" => "AX",
          "AX" => "AX",
          "BC" => "BC",
          "bc" => "BC",
          "BL" => "BL",
          "bl" => "BL",
          "credit_union" => "CU",
          "CreditUnion" => "CU",
          "CU" => "CU",
          "DinersClub" => "DN",
          "diners_club" => "DN",
          "diners-club" => "DN",
          "DN" => "DN",
          "Discover" => "DS",
          "discover" => "DS",
          "DS" => "DS",
          "ELO" => "EL",
          "elo" => "EL",
          "EL" => "EL",
          "JS" => "JS",
          "Maestro" => "MA",
          "maestro" => "MA",
          "MA" => "MA",
          "MI" => "MI",
          "Mir" => "MI",
          "mir" => "MI",
          "UnionPay" => "UP",
          "union_pay" => "UP",
          "unionpay" => "UP",
          "UP" => "UP",

    ];

    public static function getMethodCode($code)
    {
        return PaymentMethod::$payment_method_codes[$code];
    }

}

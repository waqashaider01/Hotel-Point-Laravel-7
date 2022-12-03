<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Currency::truncate();
        Schema::enableForeignKeyConstraints();


        $currencies = [
            [
                'name' => 'Albania Lek',
                'initials' => 'ALL',
                'symbol' => 'Lek'
            ],
            [
                'name' => 'Afghanistan Afghani',
                'initials' => 'AFN',
                'symbol' => '؋'
            ],
            [
                'name' => 'Argentina Peso',
                'initials' => 'ARS',
                'symbol' => '$'
            ],
            [
                'name' => 'Aruba Guilder',
                'initials' => 'AWG',
                'symbol' => 'ƒ'
            ],
            [
                'name' => 'Australia Dollar',
                'initials' => 'AUD',
                'symbol' => '$'
            ],
            [
                'name' => 'Azerbaijan Manat',
                'initials' => 'AZN',
                'symbol' => '₼'
            ],
            [
                'name' => 'Bahamas Dollar',
                'initials' => 'BSD',
                'symbol' => '$'
            ],
            [
                'name' => 'Barbados Dollar',
                'initials' => 'BBD',
                'symbol' => '$'
            ],
            [
                'name' => 'Belarus Ruble',
                'initials' => 'BYN',
                'symbol' => 'Br'
            ],
            [
                'name' => 'Belize Dollar',
                'initials' => 'BZD',
                'symbol' => 'BZ$'
            ],
            [
                'name' => 'Bermuda Dollar',
                'initials' => 'BMD',
                'symbol' => '$'
            ],
            [
                'name' => 'Bolivia Bolíviano',
                'initials' => 'BOB',
                'symbol' => '$b'
            ],
            [
                'name' => 'Bosnia and Herzegovina Convertible Mark',
                'initials' => 'BAM',
                'symbol' => 'KM'
            ],
            [
                'name' => 'Botswana Pula',
                'initials' => 'BWP',
                'symbol' => 'P'
            ],
            [
                'name' => 'Bulgaria Lev',
                'initials' => 'BGN',
                'symbol' => 'лв'
            ],
            [
                'name' => 'Brazil Real',
                'initials' => 'BRL',
                'symbol' => 'R$'
            ],
            [
                'name' => 'Brunei Darussalam Dollar',
                'initials' => 'BND',
                'symbol' => '$'
            ],
            [
                'name' => 'Cambodia Riel',
                'initials' => 'KHR',
                'symbol' => '៛'
            ],
            [
                'name' => 'Canada Dollar',
                'initials' => 'CAD',
                'symbol' => '$'
            ],
            [
                'name' => 'Cayman Islands Dollar',
                'initials' => 'KYD',
                'symbol' => '$'
            ],
            [
                'name' => 'Chile Peso',
                'initials' => 'CLP',
                'symbol' => '$'
            ],
            [
                'name' => 'China Yuan Renminbi',
                'initials' => 'CNY',
                'symbol' => '¥'
            ],
            [
                'name' => 'Colombia Peso',
                'initials' => 'COP',
                'symbol' => '$'
            ],
            [
                'name' => 'Costa Rica Colon',
                'initials' => 'CRC',
                'symbol' => '₡'
            ],
            [
                'name' => 'Croatia Kuna',
                'initials' => 'HRK',
                'symbol' => 'kn'
            ],
            [
                'name' => 'Cuba Peso',
                'initials' => 'CUP',
                'symbol' => '₱'
            ],
            [
                'name' => 'Czech Republic Koruna',
                'initials' => 'CZK',
                'symbol' => 'Kč'
            ],
            [
                'name' => 'Denmark Krone',
                'initials' => 'DKK',
                'symbol' => 'kr'
            ],
            [
                'name' => 'Dominican Republic Peso',
                'initials' => 'DOP',
                'symbol' => 'RD$'
            ],
            [
                'name' => 'East Caribbean Dollar',
                'initials' => 'XCD',
                'symbol' => '$'
            ],
            [
                'name' => 'Egypt Pound',
                'initials' => 'EGP',
                'symbol' => '£'
            ],
            [
                'name' => 'El Salvador Colon',
                'initials' => 'SVC',
                'symbol' => '$'
            ],
            [
                'name' => 'Euro Member Countries',
                'initials' => 'EUR',
                'symbol' => '€'
            ],
            [
                'name' => 'Falkland Islands (Malvinas) Pound',
                'initials' => 'FKP',
                'symbol' => '£'
            ],
            [
                'name' => 'Fiji Dollar',
                'initials' => 'FJD',
                'symbol' => '$'
            ],
            [
                'name' => 'Ghana Cedi',
                'initials' => 'GHS',
                'symbol' => '¢'
            ],
            [
                'name' => 'Gibraltar Pound',
                'initials' => 'GIP',
                'symbol' => '£'
            ],
            [
                'name' => 'Guatemala Quetzal',
                'initials' => 'GTQ',
                'symbol' => 'Q'
            ],
            [
                'name' => 'Guernsey Pound',
                'initials' => 'GGP',
                'symbol' => '£'
            ],
            [
                'name' => 'Guyana Dollar',
                'initials' => 'GYD',
                'symbol' => '$'
            ],
            [
                'name' => 'Honduras Lempira',
                'initials' => 'HNL',
                'symbol' => 'L'
            ],
            [
                'name' => 'Hong Kong Dollar',
                'initials' => 'HKD',
                'symbol' => '$'
            ],
            [
                'name' => 'Hungary Forint',
                'initials' => 'HUF',
                'symbol' => 'Ft'
            ],
            [
                'name' => 'Iceland Krona',
                'initials' => 'ISK',
                'symbol' => 'kr'
            ],
            [
                'name' => 'India Rupee',
                'initials' => 'INR',
                'symbol' => '₹'
            ],
            [
                'name' => 'Indonesia Rupiah',
                'initials' => 'IDR',
                'symbol' => 'Rp'
            ],
            [
                'name' => 'Iran Rial',
                'initials' => 'IRR',
                'symbol' => '﷼'
            ],
            [
                'name' => 'Isle of Man Pound',
                'initials' => 'IMP',
                'symbol' => '£'
            ],
            [
                'name' => 'Israel Shekel',
                'initials' => 'ILS',
                'symbol' => '₪'
            ],
            [
                'name' => 'Jamaica Dollar',
                'initials' => 'JMD',
                'symbol' => 'J$'
            ],
            [
                'name' => 'Japan Yen',
                'initials' => 'JPY',
                'symbol' => '¥'
            ],
            [
                'name' => 'Jersey Pound',
                'initials' => 'JEP',
                'symbol' => '£'
            ],
            [
                'name' => 'Kazakhstan Tenge',
                'initials' => 'KZT',
                'symbol' => 'лв'
            ],
            [
                'name' => 'Korea (North) Won',
                'initials' => 'KPW',
                'symbol' => '₩'
            ],
            [
                'name' => 'Korea (South) Won',
                'initials' => 'KRW',
                'symbol' => '₩'
            ],
            [
                'name' => 'Kyrgyzstan Som',
                'initials' => 'KGS',
                'symbol' => 'лв'
            ],
            [
                'name' => 'Laos Kip',
                'initials' => 'LAK',
                'symbol' => '₭'
            ],
            [
                'name' => 'Lebanon Pound',
                'initials' => 'LBP',
                'symbol' => '£'
            ],
            [
                'name' => 'Liberia Dollar',
                'initials' => 'LRD',
                'symbol' => '$'
            ],
            [
                'name' => 'Macedonia Denar',
                'initials' => 'MKD',
                'symbol' => 'ден'
            ],
            [
                'name' => 'Malaysia Ringgit',
                'initials' => 'MYR',
                'symbol' => 'RM'
            ],
            [
                'name' => 'Mauritius Rupee',
                'initials' => 'MUR',
                'symbol' => '₨'
            ],
            [
                'name' => 'Mexico Peso',
                'initials' => 'MXN',
                'symbol' => '$'
            ],
            [
                'name' => 'Mongolia Tughrik',
                'initials' => 'MNT',
                'symbol' => '₮'
            ],
            [
                'name' => 'Moroccan-dirham',
                'initials' => 'MNT',
                'symbol' => 'د.إ'
            ],
            [
                'name' => 'Mozambique Metical',
                'initials' => 'MZN',
                'symbol' => 'MT'
            ],
            [
                'name' => 'Namibia Dollar',
                'initials' => 'NAD',
                'symbol' => '$'
            ],
            [
                'name' => 'Nepal Rupee',
                'initials' => 'NPR',
                'symbol' => '₨'
            ],
            [
                'name' => 'Netherlands Antilles Guilder',
                'initials' => 'ANG',
                'symbol' => 'ƒ'
            ],
            [
                'name' => 'New Zealand Dollar',
                'initials' => 'NZD',
                'symbol' => '$'
            ],
            [
                'name' => 'Nicaragua Cordoba',
                'initials' => 'NIO',
                'symbol' => 'C$'
            ],
            [
                'name' => 'Nigeria Naira',
                'initials' => 'NGN',
                'symbol' => '₦'
            ],
            [
                'name' => 'Norway Krone',
                'initials' => 'NOK',
                'symbol' => 'kr'
            ],
            [
                'name' => 'Oman Rial',
                'initials' => 'OMR',
                'symbol' => '﷼'
            ],
            [
                'name' => 'Pakistan Rupee',
                'initials' => 'PKR',
                'symbol' => '₨'
            ],
            [
                'name' => 'Panama Balboa',
                'initials' => 'PAB',
                'symbol' => 'B'
            ],
            [
                'name' => 'Paraguay Guarani',
                'initials' => 'PYG',
                'symbol' => 'Gs'
            ],
            [
                'name' => 'Peru Sol',
                'initials' => 'PEN',
                'symbol' => 'S'
            ],
            [
                'name' => 'Philippines Peso',
                'initials' => 'PHP',
                'symbol' => '₱'
            ],
            [
                'name' => 'Poland Zloty',
                'initials' => 'PLN',
                'symbol' => 'zł'
            ],
            [
                'name' => 'Qatar Riyal',
                'initials' => 'QAR',
                'symbol' => '﷼'
            ],
            [
                'name' => 'Romania Leu',
                'initials' => 'RON',
                'symbol' => 'lei'
            ],
            [
                'name' => 'Russia Ruble',
                'initials' => 'RUB',
                'symbol' => '₽'
            ],
            [
                'name' => 'Saint Helena Pound',
                'initials' => 'SHP',
                'symbol' => '£'
            ],
            [
                'name' => 'Saudi Arabia Riyal',
                'initials' => 'SAR',
                'symbol' => '﷼'
            ],
            [
                'name' => 'Serbia Dinar',
                'initials' => 'RSD',
                'symbol' => 'Дин'
            ],
            [
                'name' => 'Seychelles Rupee',
                'initials' => 'SCR',
                'symbol' => '₨'
            ],
            [
                'name' => 'Singapore Dollar',
                'initials' => 'SGD',
                'symbol' => '$'
            ],
            [
                'name' => 'Solomon Islands Dollar',
                'initials' => 'SBD',
                'symbol' => '$'
            ],
            [
                'name' => 'Somalia Shilling',
                'initials' => 'SOS',
                'symbol' => 'S'
            ],
            [
                'name' => 'South Korean Won',
                'initials' => 'KRW',
                'symbol' => '₩'
            ],
            [
                'name' => 'South Africa Rand',
                'initials' => 'ZAR',
                'symbol' => 'R'
            ],
            [
                'name' => 'Sri Lanka Rupee',
                'initials' => 'LKR',
                'symbol' => '₨'
            ],
            [
                'name' => 'Sweden Krona',
                'initials' => 'SEK',
                'symbol' => 'kr'
            ],
            [
                'name' => 'Switzerland Franc',
                'initials' => 'CHF',
                'symbol' => 'CHF'
            ],
            [
                'name' => 'Suriname Dollar',
                'initials' => 'SRD',
                'symbol' => '$'
            ],
            [
                'name' => 'Syria Pound',
                'initials' => 'SYP',
                'symbol' => '£'
            ],
            [
                'name' => 'Taiwan New Dollar',
                'initials' => 'TWD',
                'symbol' => 'NT$'
            ],
            [
                'name' => 'Thailand Baht',
                'initials' => 'THB',
                'symbol' => '฿'
            ],
            [
                'name' => 'Trinidad and Tobago Dollar',
                'initials' => 'TTD',
                'symbol' => 'TT$'
            ],
            [
                'name' => 'Turkey Lira',
                'initials' => 'TRY',
                'symbol' => '₺'
            ],
            [
                'name' => 'Tuvalu Dollar',
                'initials' => 'TVD',
                'symbol' => '$'
            ],
            [
                'name' => 'Ukraine Hryvnia',
                'initials' => 'UAH',
                'symbol' => '₴'
            ],
            [
                'name' => 'UAE-Dirham',
                'initials' => 'AED',
                'symbol' => 'AED'
            ],
            [
                'name' => 'United Kingdom Pound',
                'initials' => 'GBP',
                'symbol' => '£'
            ],
            [
                'name' => 'United States Dollar',
                'initials' => 'USD',
                'symbol' => '$'
            ],
            [
                'name' => 'Uruguay Peso',
                'initials' => 'UYU',
                'symbol' => '$U'
            ],
            [
                'name' => 'Uzbekistan Som',
                'initials' => 'UZS',
                'symbol' => 'лв'
            ],
            [
                'name' => 'Venezuela Bolívar',
                'initials' => 'VEF',
                'symbol' => 'Bs'
            ],
            [
                'name' => 'Viet Nam Dong',
                'initials' => 'VND',
                'symbol' => '₫'
            ],
            [
                'name' => 'Yemen Rial',
                'initials' => 'YER',
                'symbol' => '﷼'
            ],
            [
                'name' => 'Zimbabwe Dollar',
                'initials' => 'ZWD',
                'symbol' => 'Z$'
            ],
        ];

        Currency::insert($currencies);
    }
}

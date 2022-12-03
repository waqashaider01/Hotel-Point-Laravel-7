<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use App\Models\HotelSetting;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hotel = HotelSetting::first();

        DocumentType::create([
            'id' => 1,
            'hotel_settings_id' => $hotel->id,
            'name' => 'Απόδειξη Παροχής Με Ακυρωτικά',
            'debit' => '+',
            'credit' => '-',
            'turnover' => '+',
            'row' => 'Α',
            'enumeration' => 1,
            'uniform_enumeration' => 1,
            'initials' => 'ΑΠΜΑ',
        ]);
        DocumentType::create([
            'id' => 2,
            'hotel_settings_id' => $hotel->id,
            'name' => 'Ειδικό Ακυρωτικό Δελτίο',
            'debit' => '-',
            'credit' => '+',
            'turnover' => '-',
            'row' => 'Α',
            'enumeration' => '1',
            'uniform_enumeration' => '1',
            'initials' => 'ΕΑΔ',
        ]);
        DocumentType::create([
            'id' => 3,
            'hotel_settings_id' => $hotel->id,
            'name' => 'Απόδειξη Φόρου Διαμονής',
            'debit' => '+',
            'credit' => '-',
            'turnover' => '-',
            'row' => 'Α',
            'enumeration' => 19,
            'uniform_enumeration' => 1,
            'initials' => 'ΑΦΔ',
        ]);
        DocumentType::create([
            'id' => 4,
            'hotel_settings_id' => $hotel->id,
            'name' => 'Τιμολόγιο Παροχής Υπηρεσιών',
            'debit' => '+',
            'credit' => '-',
            'turnover' => '+',
            'row' => 'E',
            'enumeration' => 1,
            'uniform_enumeration' => 10,
            'initials' => 'ΤΠΥ',
        ]);
        DocumentType::create([
            'id' => 5,
            'hotel_settings_id' => $hotel->id,
            'name' => 'Απόδειξη Παροχής Υπηρεσιών',
            'debit' => '+',
            'credit' => '-',
            'turnover' => '+',
            'row' => 'Α',
            'enumeration' => 6,
            'uniform_enumeration' => 1,
            'initials' => 'ΑΠΥ',
        ]);
        DocumentType::create([
            'id' => 6,
            'hotel_settings_id' => $hotel->id,
            'name' => 'Πιστωτικό Τιμολόγιο',
            'debit' => '-',
            'credit' => '+',
            'turnover' => '-',
            'row' => 'Α',
            'enumeration' => 1,
            'uniform_enumeration' => 1,
            'initials' => 'ΠΤ',
        ]);
    }
}

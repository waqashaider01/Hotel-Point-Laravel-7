<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class HotelSetting extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = [];

    public function generate_document_types()
    {
        DocumentType::updateOrCreate([
            'hotel_settings_id' => $this->id,
            'type' => 1,
        ],
            [
                'hotel_settings_id' => $this->id,
                'type' => 1,
                'language' => 'Greece',
                'name' => 'Απόδειξη Παροχής Με Ακυρωτικά',
                'debit' => '+',
                'credit' => '-',
                'turnover' => '+',
                'row' => 'Α',
                'enumeration' => 1,
                'uniform_enumeration' => 1,
                'initials' => 'ΑΠΜΑ',
                'status' => 1,
            ]);
        DocumentType::updateOrCreate([
            'hotel_settings_id' => $this->id,
            'type' => 2,
        ],
            [
                'hotel_settings_id' => $this->id,
                'type' => 2,
                'language' => 'Greece',
                'name' => 'Ειδικό Ακυρωτικό Δελτίο',
                'debit' => '-',
                'credit' => '+',
                'turnover' => '-',
                'row' => 'Α',
                'enumeration' => '1',
                'uniform_enumeration' => '1',
                'initials' => 'ΕΑΔ',
                'status' => 1,
            ]);
        DocumentType::updateOrCreate([
            'hotel_settings_id' => $this->id,
            'type' => 3,
        ],
            [
                'hotel_settings_id' => $this->id,
                'type' => 3,
                'language' => 'Greece',
                'name' => 'Απόδειξη Φόρου Διαμονής',
                'debit' => '+',
                'credit' => '-',
                'turnover' => '-',
                'row' => 'Α',
                'enumeration' => 19,
                'uniform_enumeration' => 1,
                'initials' => 'ΑΦΔ',
                'status' => 1,
            ]);
        DocumentType::updateOrCreate([
            'hotel_settings_id' => $this->id,
            'type' => 4,
        ],
            [
                'hotel_settings_id' => $this->id,
                'type' => 4,
                'language' => 'Greece',
                'name' => 'Τιμολόγιο Παροχής Υπηρεσιών',
                'debit' => '+',
                'credit' => '-',
                'turnover' => '+',
                'row' => 'E',
                'enumeration' => 1,
                'uniform_enumeration' => 10,
                'initials' => 'ΤΠΥ',
                'status' => 1,
            ]);
        DocumentType::updateOrCreate([
            'hotel_settings_id' => $this->id,
            'type' => 5,
        ],
            [
                'hotel_settings_id' => $this->id,
                'type' => 5,
                'language' => 'Greece',
                'name' => 'Απόδειξη Παροχής Υπηρεσιών',
                'debit' => '+',
                'credit' => '-',
                'turnover' => '+',
                'row' => 'Α',
                'enumeration' => 6,
                'uniform_enumeration' => 1,
                'initials' => 'ΑΠΥ',
                'status' => 1,
            ]);
        DocumentType::updateOrCreate([
            'hotel_settings_id' => $this->id,
            'type' => 6,
        ],
            [
                'hotel_settings_id' => $this->id,
                'type' => 6,
                'language' => 'Greece',
                'name' => 'Πιστωτικό Τιμολόγιο',
                'debit' => '-',
                'credit' => '+',
                'turnover' => '-',
                'row' => 'Α',
                'enumeration' => 1,
                'uniform_enumeration' => 1,
                'initials' => 'ΠΤ',
                'status' => 1,
            ]);
    }

    public function generate_payment_modes()
    {
        PaymentMode::updateOrCreate([
            'hotel_settings_id' => $this->id,
            'name' => 'Guests Settles Extras',
        ]);

        PaymentMode::create([
            'hotel_settings_id' => $this->id,
            'name' => 'Pay Own Account',
        ]);

        PaymentMode::create([
            'hotel_settings_id' => $this->id,
            'name' => 'Company Full Account ',
        ]);
    }

    public function generate_payment_methods()
    {
        PaymentMethod::updateOrCreate([
            'hotel_settings_id' => $this->id,
            'name' => 'Cash',
            'channex_id' => 'Cash',
        ],
            [
                'hotel_settings_id' => $this->id,
                'name' => 'Cash',
                'commission_percentage' => '0',
                'is_card_type' => 0,
                'channex_id' => 'Cash',
            ]);
        PaymentMethod::updateOrCreate([
            'hotel_settings_id' => $this->id,
            'name' => 'Visa',
            'channex_id' => 'VI',
        ],
            [
                'hotel_settings_id' => $this->id,
                'name' => 'Visa',
                'commission_percentage' => '0',
                'is_card_type' => 1,
                'channex_id' => 'VI',
            ]);
        PaymentMethod::updateOrCreate([
            'hotel_settings_id' => $this->id,
            'name' => 'Master Card',
            'channex_id' => 'MC',
        ],
            [
                'hotel_settings_id' => $this->id,
                'name' => 'Master Card',
                'commission_percentage' => '0',
                'is_card_type' => 1,
                'channex_id' => 'MC',
            ]);
        PaymentMethod::updateOrCreate([
            'hotel_settings_id' => $this->id,
            'name' => 'American Express',
            'channex_id' => 'AX',
        ],
            [
                'hotel_settings_id' => $this->id,
                'name' => 'American Express',
                'commission_percentage' => '0',
                'is_card_type' => 1,
                'channex_id' => 'AX',
            ]);
        PaymentMethod::updateOrCreate([
            'hotel_settings_id' => $this->id,
            'name' => 'Maestro',
            'channex_id' => 'MA',
        ],
            [
                'hotel_settings_id' => $this->id,
                'name' => 'Maestro',
                'commission_percentage' => '0',
                'is_card_type' => 1,
                'channex_id' => 'MA',
            ]);
        PaymentMethod::updateOrCreate([
            'hotel_settings_id' => $this->id,
            'name' => 'Debtor',
            'channex_id' => 'Deptor',
        ],
            [
                'hotel_settings_id' => $this->id,
                'name' => 'Debtor',
                'commission_percentage' => '0',
                'is_card_type' => 0,
                'channex_id' => 'Deptor',
            ]);
        PaymentMethod::updateOrCreate([
            'hotel_settings_id' => $this->id,
            'name' => 'Bank Transfer',
            'channex_id' => 'Bank',
        ],
            [
                'hotel_settings_id' => $this->id,
                'name' => 'Bank Transfer',
                'commission_percentage' => '0',
                'is_card_type' => 0,
                'channex_id' => 'Bank',
            ]);
        PaymentMethod::updateOrCreate([
            'hotel_settings_id' => $this->id,
            'name' => 'UnionPay',
            'channex_id' => 'UP',
        ],
            [
                'hotel_settings_id' => $this->id,
                'name' => 'UnionPay',
                'commission_percentage' => '0',
                'is_card_type' => 0,
                'channex_id' => 'UP',
            ]);
        PaymentMethod::updateOrCreate([
            'hotel_settings_id' => $this->id,
            'name' => 'Paypal',
            'channex_id' => 'Paypal',
        ],
            [
                'hotel_settings_id' => $this->id,
                'name' => 'Paypal',
                'commission_percentage' => '0',
                'is_card_type' => 0,
                'channex_id' => 'Paypal',
            ]);
    }

    public function generate_booking_agencies()
    {
        BookingAgency::updateOrCreate([
            'hotel_settings_id' => $this->id,
            'name' => 'Booking Engine',
        ],
            [
                'hotel_settings_id' => $this->id,
                'name' => 'Booking Engine',
                'bg' => asset('images/logo/logo.png'),
                'activity' => 'test_activity',
                'vat_number' => 1234,
                'tax_office' => 'test_office',
                'address' => 'test_address',
                'category' => 'test_cat',
                'headquarters' => 'test_headquarters',
                'branch' => 'test_branch',
                'postal_code' => 'test_code',
                'phone_number' => '1234123',
                'country' => 'test_country',
                'channex_channel_id' => $channex_channel_id,
                'default_payment_mode_id' => $this->payment_modes->random()->id,
                'supports_virtual_card' => 'yes',
                'virtual_card_payment_mode_id' => $this->payment_modes->random()->id,
                'default_payment_method_id' => $this->payment_methods->random()->id,
                'charge_date_days' => '12',
                'channel_code' => 'OSA',
                'charge_mode' => '3',
            ]);
    }

    public function generate_rate_type_cancellation_policies()
    {
        RateTypeCancellationPolicy::insert([
            ['hotel_settings_id' => $this->id, 'name' => 'Based At Nights', 'amount' => '0', 'charge_days' => '0'],
            ['hotel_settings_id' => $this->id, 'name' => 'Based At Percent', 'amount' => '0', 'charge_days' => '0'],
            ['hotel_settings_id' => $this->id, 'name' => 'Fixed Amount Per Booking', 'amount' => '0', 'charge_days' => '0'],
            ['hotel_settings_id' => $this->id, 'name' => 'Fixed Amount Per Booking Room', 'amount' => '0', 'charge_days' => '0']
        ]);
    }

    public function generate_hotel_vat()
    {
        $vatOptions = VatOption::all();
        foreach ($vatOptions as $option) {
            HotelVat::updateOrCreate([
                'hotel_settings_id' => $this->id,
                'vat_option_id' => $option->id,
            ]);
        }


    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by_id', 'id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'hotel_settings_id', 'id');
    }

    public function ex_reservations()
    {
        return $this->hasMany(ExReservation::class, 'hotel_settings_id', 'id');
    }

    public function room_types()
    {
        return $this->hasMany(RoomType::class, 'hotel_settings_id', 'id');
    }

    public function active_room_types()
    {
        return $this->hasMany(RoomType::class, 'hotel_settings_id', 'id')->where('type_status', 1);
    }

    public function rate_types()
    {
        return $this->hasMany(RateType::class, 'hotel_settings_id', 'id');
    }

    public function document_types()
    {
        return $this->hasMany(DocumentType::class, 'hotel_settings_id', 'id');
    }

    public function payment_modes()
    {
        return $this->hasMany(PaymentMode::class, 'hotel_settings_id', 'id');
    }

    public function payment_methods()
    {
        return $this->hasMany(PaymentMethod::class, 'hotel_settings_id', 'id');
    }

    public function extra_charges()
    {
        return $this->hasMany(ExtraCharge::class, 'hotel_settings_id', 'id');
    }

    public function extra_charges_types()
    {
        return $this->hasMany(ExtraChargesType::class, 'hotel_settings_id', 'id');
    }

    public function extra_charges_categories()
    {
        return $this->hasMany(ExtraChargesCategory::class, 'hotel_settings_id', 'id');
    }

    public function booking_agencies()
    {
        return $this->hasMany(BookingAgency::class, 'hotel_settings_id', 'id');
    }

    public function connected_users()
    {
        return $this->belongsToMany(User::class, 'hotel_settings_users', 'hotel_settings_id', 'user_id');
    }
    public function documents()
    {
        return $this->hasMany(Document::class, 'hotel_settings_id', 'id');
    }

    /**
     * Get all of the properties for the HotelSetting
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function properties()
    {
        return $this->belongsTo(Property::class, 'id', 'hotel_id');
    }

    public function rate_type_cancellation_policies()
    {
        return $this->hasMany(RateTypeCancellationPolicy::class, "hotel_settings_id", "id");
    }

    public function rate_type_categories()
    {
        return $this->hasMany(RateTypeCategory::class, "hotel_settings_id", "id");
    }

    public function active_property()
    {
        return Property::where('status', 1)->where('hotel_id', $this->id)->first();
    }

    public function companies()
    {
        return $this->hasMany(Company::class, "hotel_settings_id", "id");
    }
    public function guests()
    {
        return $this->hasMany(Guest::class, "hotel_settings_id", "id");
    }
    public function cash_registers()
    {
        return $this->hasMany(CashRegister::class, "hotel_settings_id", "id");
    }

    public function hotel_budgets()
    {
        return $this->hasMany(HotelBudget::class, 'hotel_settings_id', 'id');
    }

    public function opex_data()
    {
        return $this->hasMany(OpexData::class, 'hotel_settings_id', 'id');
    }

    public function supplier()
    {
        return $this->hasMany(Supplier::class, 'hotel_settings_id', 'id');
    }


    public function vat_tax()
    {
        return $this->belongsTo(HotelVat::class, 'vat_id', 'id');
    }
    public function cancellation_vat_tax()
    {
        return $this->belongsTo(HotelVat::class, 'cancellation_vat_id', 'id');
    }

    public function all_vat()
    {
        return $this->hasMany(HotelVat::class, 'hotel_settings_id', 'id');
    }

    public function overnight_tax(){
        return $this->belongsTo(HotelTaxCategory::class, 'overnight_tax_id', 'id');
    }
    
    public function templates(){
        return $this->hasMany(Template::class, 'hotel_settings_id', 'id');
    }


}

<?php

use App\Models\DailyRate;
use App\Models\Document;
use App\Models\GuestAccommodationPayment;
use App\Models\HotelSetting;
use App\Models\PaymentMethod;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Maintenance;
use App\Models\Availability;
use App\Services\OxygenService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

function showPriceWithCurrency($price): string
{
    $currency = getHotelSettings()->currency;
    $symbol = $currency->symbol;
    switch ($symbol) {
        case '$':
            return '$' . number_format((float) $price, 2);
        case '¥':
            return number_format((float) $price, 2) . ' ¥';
        case '₨':
            return '₨. ' . number_format((float) $price, 2);
        case '€':
            return number_format((float) $price, 2) . '€';
        default:
            return number_format((float) $price, 2) . ' ' . $symbol;
    }
}

function formatCurrency($price, $hotel)
{
    $currency = $hotel->currency;
    $symbol = $currency->symbol;
    switch ($symbol) {
        case '$':
            return '$' . number_format((float) $price, 2);
        case '¥':
            return number_format((float) $price, 2) . ' ¥';
        case '₨':
            return '₨. ' . number_format((float) $price, 2);
        case '€':
            return number_format((float) $price, 2) . '€';
        default:
            return number_format((float) $price, 2) . ' ' . $symbol;
    }
}

function getAcronym($str)
{
    $acronym = '';
    foreach (preg_split("/\s+/", $str) as $w) {
        $acronym .= mb_substr($w, 0, 1);
    }
    return $acronym;
}

function getStatusesAndValues($r_id)
{

    $hotel = getHotelSettings();
    $reservation = Reservation::where('id', $r_id)->first();
    $overnightTax = '';
        if(isset($hotel->overnight_tax->tax)){
        $overnightTax = $hotel->overnight_tax->tax;
    }
    // $overnightTax = $hotel->overnight_tax->tax;
    $cityTax = $hotel->city_tax;
    $vat=0;
    if ($hotel->vat_tax) {
        $vat = $hotel->vat_tax->vat_option->value;
    }
    
    $discount =(float) $reservation->discount ?? 0;
    $arrival_date = $reservation->arrival_date;
    $departure_date = $reservation->departure_date;
    $rateTypeEarlyCheckOutCharge = $reservation->rate_type->early_checkout_charge_percentage / 100;
    $noShowCharge = $reservation->rate_type->no_show_charge_percentage / 100;

    //Need to calculate accumodation upto actual_checkout | departue_date
    if (is_null($reservation->actual_checkout)) {
        $actual_checkout = $departure_date ? $departure_date : today();
    } else {
        $actual_checkout = $reservation->actual_checkout;
    }
    if (is_null($reservation->actual_checkin)) {
        $actual_checkin = $arrival_date;
    } else {
        $actual_checkin = $reservation->actual_checkin;
    }

    $overnights = Carbon::parse($actual_checkin)->diffInDays(Carbon::parse($actual_checkout));

    $accom_total = $reservation->daily_rates()->where('date', ">=", $actual_checkin)->where("date", "<", $actual_checkout)->sum('price');
    if ($vat==0) {
        $vat_tax=0;
    }else{
        $vat_tax = 1.0 + ($vat / 100);
    }
    
    $city_tax_calc_1 = 1.0 + ($cityTax / 100);
    $city_tax_calc_2 = $cityTax / 100;
    if ($vat_tax==0) {
        $taxable=0;
    }else{
        $taxable =(float) number_format((float) $accom_total / $vat_tax, 2, '.', '');
    }
    
    $municipalTax =(float) number_format((float) ($taxable / $city_tax_calc_1) * $city_tax_calc_2, 2, '.', '');
    $netValue =(float) number_format((float) $taxable - $municipalTax, 2, '.', '');
    $discountNetValue = $netValue - $discount;
    $tax =(float) number_format((float) $accom_total - $taxable, 2, '.', '');
    if ($discount > 0) {
        $municipalTax = $discountNetValue * $city_tax_calc_2;
        $taxable = $discountNetValue + $municipalTax;
        $tax = $discountNetValue * ($vat / 100);
        $daysStayedAccomTotal = round($discountNetValue + $tax + $municipalTax, 2);
    }
//    check no show
    $no_show = $reservation->daily_rates()->whereDate('date', '<', $arrival_date);
    $is_no_show = $no_show->count() > 0;
    if ($is_no_show) {
        $isNoShowAccomTotal = round($no_show->sum('price') * $noShowCharge, 2);
    } else {
        $isNoShowAccomTotal = 0;
    }
//    Check Left Early
    $earlyCheckoutAccomTotal = 0;
    if ($reservation->actual_checkout && $reservation->departure_date && Carbon::parse($reservation->actual_checkout) < Carbon::parse($reservation->departure_date)) {
        $earlyCheckoutAccomTotal = $reservation->daily_rates()->whereDate('date', '>=', $reservation->actual_checkout)->whereDate('date', '<', $reservation->departure_date)->sum('price');
        $earlyCheckoutAccomTotal = $earlyCheckoutAccomTotal * $rateTypeEarlyCheckOutCharge;
    }

//  Find Accommodation total
    $accom_total = $accom_total + $earlyCheckoutAccomTotal + $isNoShowAccomTotal;
    $accom_total = round($accom_total, 2);
    $accom_paid = round(GuestAccommodationPayment::where('reservation_id', $r_id)->sum('value'), 2);
    $accom_charge = $accom_total - $accom_paid;

//  Find Extras Total
    $extras_total = $reservation->reservation_extra_charges()->sum('extra_charge_total') - $reservation->reservation_extra_charges()->sum('extra_charge_discount');
    $extras_paid = $reservation->guest_extras_payments()->sum('value');
    $extras_charge = $extras_total - $extras_paid;
//    Find Overnights Data
    $overnight_total = $overnightTax * $overnights;
    $overnight_paid = $reservation->guest_overnight_tax_payments()->sum('value');
    $overnight_charge = $overnight_total - $overnight_paid;
//    set statuses
    if ($accom_total == 0 || $accom_charge == 0) {
        $accom_status = "green";
    } else if ($accom_paid != 0) {
        $accom_status = "yellow";
    } else {
        $accom_status = "red";
    }

    if ($extras_charge == 0) {
        $extras_status = "green";
    } else if ($extras_paid != 0) {
        $extras_status = "yellow";
    } else {
        $extras_status = "red";
    }
    if ($overnight_charge == 0) {
        $overnights_status = "green";
    } else if ($overnight_paid != 0) {
        $overnights_status = "yellow";
    } else {
        $overnights_status = "red";
    }
    if ($accom_status == "green" && $extras_status == "green" && $overnights_status == "green") {
        $full_status = "green";
    } else if ($accom_status == "red" && $extras_status == "red" && $overnights_status == "red") {
        $full_status = "red";
    } else {
        $full_status = "yellow";
    }

    return [
        'accom_total' => $accom_total,
        'accom_paid' => $accom_paid,
        'accom_charge' => $accom_charge,
        'extras_total' => $extras_total,
        'extras_paid' => $extras_paid,
        'extras_charge' => $extras_charge,
        'overnight_total' => $overnight_total,
        'overnight_paid' => $overnight_paid,
        'overnight_charge' => $overnight_charge,
        'extras_status' => $extras_status,
        'accom_status' => $accom_status,
        'overnights_status' => $overnights_status,
        'full_status' => $full_status,
        'no_show' => $is_no_show,
    ];
}

function checkNoShow($r_id)
{
    $reservation = Reservation::find($r_id);
    return $reservation->daily_rates()->whereDate('date', '<', $reservation->arrival_date)->count() > 0;
}

function annullingDocumentCreated($r_id)
{
    $documents = Document::query()->with('activities')->where('document_type_id', 2)->get();
    $found = false;
    foreach ($documents as $document) {
        if ($document->activities->first()->reservation_id == $r_id) {
            return true;
        }

    }
    return false;
}

/**
 * @return \App\Models\HotelSetting|null
 */
function getHotelSettings()
{
    /**
     * @var \App\Models\User
     */
    $user = auth()->user();

    if (!$user) {
        return null;
    }

    if (session()->get('selected_hotel')) {
        return HotelSetting::findOrFail(session()->get('selected_hotel'));
    } else if ($user->hasRole('Super Admin')) {
        $hotel = HotelSetting::firstOrFail();
        session()->put('selected_hotel', $hotel->id);
        return $hotel;
    } else if ($user->role == 'Administrator') {
        $hotel = HotelSetting::where('created_by_id', $user->id)->first();
        if(!$hotel){
            return abort(404, "No hotel Connected with your account, Contact System Administrator!");
        }
        session()->put('selected_hotel', $hotel->id);
        return $hotel;
    } else {
        $hotel = HotelSetting::where('created_by_id', $user->created_by_id)->first();
        if(!$hotel){
            return abort(404, "No hotel Connected with your account, Contact System Administrator!");
        }
        session()->put('selected_hotel', $hotel->id);
        return $hotel;
    }

}

function sync_channex_rooms($selected_hotel = null)
{
    /**
     * @var \App\Models\HotelSetting
     */
    $hotel = null;

    if ($selected_hotel != null) {
        $hotel = HotelSetting::findOrFail($selected_hotel);
    } else {
        $hotel = getHotelSettings();
    }

    /**
     * @var \App\Models\Property
     */
    $property = $hotel->properties()->first();

    $endpoint = config('services.channex.api_base') . '/room_types/';

    try {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'user-api-key' => config('services.channex.api_key'),
        ])->get($endpoint, [
            "filter[property_id]" => $property->property_id,
        ]);

        DB::beginTransaction();
        foreach ($response->object()->data as $room_data) {
            $room_type = RoomType::updateOrCreate(
                [
                    'channex_room_type_id' => $room_data->id,
                ],
                [
                    'hotel_settings_id' => $hotel->id,
                    'name' => $room_data->attributes->title,
                    'channex_room_type_id' => $room_data->id,
                    'reference_code' => getAcronym($room_data->attributes->title),
                    'description' => $room_data->attributes->content->description,
                    'type_status' => 1,
                    'adults_channex' => (int) $room_data->attributes->occ_adults,
                    'kids_channex' => (int) $room_data->attributes->occ_children,
                    'infants_channex' => (int) $room_data->attributes->occ_infants,
                    'default_occupancy_channex' => $room_data->attributes->default_occupancy,
                    'position' => 0,
                    'cancellation_charge' => 0,
                ]
            );

            for ($i = 1; $i <= (int) $room_data->attributes->count_of_rooms; $i++) {
                Room::updateOrCreate(
                    [
                        'number' => $room_type->reference_code . "-" . str_pad($i, 3, "0", STR_PAD_LEFT),
                        'room_type_id' => $room_type->id,
                    ],
                    [
                        'number' => $room_type->reference_code . "-" . str_pad($i, 3, "0", STR_PAD_LEFT),
                        'status' => "Enabled",
                        'room_type_id' => $room_type->id,
                        'max_capacity' => $room_type->adults_channex + $room_type->kids_channex + $room_type->infants_channex,
                        'max_adults' => $room_type->adults_channex,
                        'max_kids' => $room_type->kids_channex,
                        'max_infants' => $room_type->infants_channex,
                    ]
                );
            }
        }

        DB::commit();
        return [
            'result' => 'success',
            'message' => "The room types have been updated from Channex!",

        ];
    } catch (\Throwable$e) {
        return [
            'result' => 'error',
            'message' => $e->getMessage(),
        ];
    }
}

function syncOxygenApiPaymentMethods($selected_hotel = null)
{
    /**
     * @var \App\Models\HotelSetting
     */
    $hotel = null;

    if ($selected_hotel != null) {
        $hotel = HotelSetting::findOrFail($selected_hotel);
    } else {
        $hotel = getHotelSettings();
    }

    $methods = $hotel->payment_methods;

    try {
        /**
         * Get All Payment Methods
         */
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $hotel->oxygen_api_key,
        ])->get(config('services.oxygen.api_base') . "/payment-methods");
        $response->throw();

        foreach ($response->object()->data as $method) {
            $found_method = $methods->where('name', $method->title_en)->first();
            if ($found_method) {
                $found_method->oxygen_id = $method->id;
                $found_method->save();
            }
        }

        $methods = $hotel->payment_methods()->get();

        foreach ($methods as $method) {
            if (!$method->oxygen_id) {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $hotel->oxygen_api_key,
                ])->post(config('services.oxygen.api_base') . "/payment-methods", [
                    "title_gr" => PaymentMethod::$types[$method->name]['name_gr'] ?? $method->name,
                    "title_en" => PaymentMethod::$types[$method->name]['name_en'] ?? $method->name,
                    "mydata_code" => (int) $method->is_card_type ? 1 : 3,
                    "status" => true,
                ]);

                $response->throw();

                $method->oxygen_id = $response->json('id');
                $method->save();
            }
        }

        return [
            'status' => 'success',
            'emit_type' => 'dataSaved',
            'message' => "Payment methods synced with Oxygen!",
        ];
    } catch (\Throwable$th) {
        if ($th->getCode() == 401) {
            return [
                'status' => 'error',
                'emit_type' => 'showError',
                'message' => "Your Oxygen API key is invalid!",
            ];
        } else {
            return [
                'status' => 'error',
                'emit_type' => 'showError',
                'message' => $th->getMessage(),
            ];
        }
    }
}

function generateChannexOneTimeToken()
{
    try {

        // Get OTT using the API key
        $response = Http::withHeaders([
            'user-api-key' => config('services.channex.api_key'),
        ])->post(config('services.channex.api_base') . "/auth/one_time_token");
        $response->throw();

        $response->json('data')['token'];

        return [
            'status' => 'success',
            'token' => $response->json('data')['token'],
        ];
    } catch (\Exception$e) {
        return [
            'status' => 'error',
            'message' => $e->getMessage(),
        ];
    }
}

function getPublicPathFromUrl($path)
{
    return public_path(str_replace(env('APP_URL') . "/", "", $path));
}

function generateTaxDocument($doc_id, $r_id)
{
    $logoImage = file_get_contents(getHotelSettings()->logo);
    $data = [
        'reservation' => Reservation::find($r_id),
        'document' => Document::find($doc_id),
        'settings' => getHotelSettings(),
        'logoImage' => $logoImage,
    ];
    $html = view('layouts.document_template', $data)->render();
    $pdf = PDF::loadHTML($html);

    return $pdf;

}

function calculateDocumentFields($r_id, $doc_type_name)
{
    $reservation = Reservation::find($r_id);
    $rate_type = $reservation->rate_type;
    $arrivalDate = $reservation->arrival_date;
    $reservation_actual_checkin = $reservation->actual_checkin ?? $arrivalDate;
    $reservation_actual_checkout = $reservation->actual_checkout ?? $reservation->departure_date;
    $ratePercentage = $rate_type->charge_percentage;
    $percentInDecimal = $ratePercentage / 100;
    $rateCategoryVat = $rate_type->rate_type_category->vat;
    $rateCategoryVatPercentage = 1.0 + ($rateCategoryVat / 100);
    $accom_total = $reservation->daily_rates()->whereDate('date', ">=", $reservation_actual_checkin)->whereDate("date", "<", $reservation_actual_checkout)->sum("price");

    //$rate_total = $accom_total * $ratePercentage;
    $rateChargeType = $rate_type->charge_type;
    $ratePlanCharge = $rate_type->charge_percentage;
    $rateTypeEarlyCheckOutCharge = $rate_type->early_checkout_charge_percentage / 100;
    $rateTypeNoShowCharge = $rate_type->no_show_charge_percentage / 100;
    $daysStayed = Carbon::parse($reservation_actual_checkout)->diffInDays(Carbon::parse($reservation_actual_checkin));

    $settings = getHotelSettings();
    if ($settings->vat_id) {
        $vat = $settings->vat_tax->vat_option->value;
    }else{
        $vat=0;
    }

    if ($settings->cancellation_vat_id) {
        $cancellationVat = $settings->cancellation_vat_tax->vat_option->value;
    }else{
        $cancellationVat=0;
    }


    $cityTax = $settings->city_tax;
    $discount =(float) $reservation->discount;

    $vatt = 1.0 + ($vat / 100);
    $city_tax_calc_1 = 1.0 + ($cityTax / 100);
    $city_tax_calc_2 = $cityTax / 100;
    if ($discount == 0) {
        if ($rateChargeType == 0) { //charged by %
            $rate_total = $accom_total * $percentInDecimal;
        } else { //charged by fixed ammount
            $rate_total = $ratePlanCharge * $daysStayed;
        }
        $reservTotal =(float) number_format((float) $accom_total, 2, '.', '');
        $rateTotal = $rate_total;
        $reservAccomTotal = $reservTotal - $rateTotal;
        $tax =(float) number_format((float) $reservAccomTotal - ($reservAccomTotal / $vatt), 2, '.', '');
        $rateTaxAmount =(float) number_format((float) $rateTotal - ($rateTotal / $rateCategoryVatPercentage), 2, '.', '');
        $vatSum = $tax + $rateTaxAmount;
        $netValue =(float) number_format((float) $reservTotal - $tax - $rateTaxAmount, 2, '.', '');
        $municipalTax =(float) number_format((float) ($netValue - (($reservTotal - $vatSum) / $city_tax_calc_1)), 2, '.', '');
        $accommodationTaxable =(float) number_format((float) $reservTotal - $vatSum - $municipalTax, 2, '.', '');
        $discountNetValue = $netValue - $discount;

    } else {
        $reservTotal =(float) number_format((float) $accom_total, 2, '.', '');
        $discountResevTotal =(float) number_format((float) $reservTotal - $discount, 2, '.', '');

        if ($rateChargeType == 0) {
            $rateTotal = $discountResevTotal * $percentInDecimal;
        } else { //charged by fixed ammount
            $rateTotal = $ratePlanCharge * $daysStayed;
        }

        $reservAccomTotal = $reservTotal - $rateTotal;
        $discountReservAccomTotal = $discountResevTotal - $rateTotal;
        $taxbd =(float) number_format((float) $reservAccomTotal - ($reservAccomTotal / $vatt), 2, '.', '');
        $rateTaxAmount =(float) number_format((float) $rateTotal - ($rateTotal / $rateCategoryVatPercentage), 2, '.', '');
        //$discountAccomPercentage = $discountResevTotal * (1 - $percentInDecimal);
        if ($vatt == $rateCategoryVatPercentage) {
            $netValue =(float) number_format((float) $reservTotal - $taxbd - $rateTaxAmount, 2, '.', '');
            $discountNetValue =(float) number_format((float) $discountResevTotal / $vatt, 2, '.', '');
            $tax =(float) number_format((float) $discountReservAccomTotal - ($discountReservAccomTotal / $vatt), 2, '.', ''); // poso fpa pou antistoixei sto accomm
            $vatSum = $tax + $rateTaxAmount; //prepei na doume kai to synolo twn 2 fpa
        } else {
            $accommPercentage = $reservTotal * (1 - $percentInDecimal);
            $ratePercentage = $reservTotal * $percentInDecimal;
            $accomNetValue =(float) number_format((float) $accommPercentage * $vatt, 2, '.', '');
            $rateNetValue =(float) number_format((float) $ratePercentage * $rateCategoryVatPercentage, 2, '.', '');
            $discountAccommPercentage = $discountResevTotal * (1 - $percentInDecimal);
            $discountRatePercentage = $discountResevTotal * $percentInDecimal;
            $taxbd =(float) number_format((float) $accommPercentage - ($accommPercentage / $vatt), 2, '.', ''); // poso fpa pou antistoixei sto accomm
            $rateTaxAmountbd =(float) number_format((float) $ratePercentage - ($ratePercentage / $rateCategoryVatPercentage), 2, '.', '');
            $vatSumdb = $taxbd + $rateTaxAmountbd; //prepei na doume kai to synolo twn 2 fpa
            $tax =(float) number_format((float) $discountAccommPercentage - ($discountAccommPercentage / $vatt), 2, '.', ''); // poso fpa pou antistoixei sto accomm
            $rateTaxAmount =(float) number_format((float) $discountRatePercentage - ($discountRatePercentage / $rateCategoryVatPercentage), 2, '.', '');
            $vatSum = $tax + $rateTaxAmount; //prepei na doume kai to synolo twn 2 fpa
            $netValue =(float) number_format((float) $reservTotal - $vatSumdb, 2, '.', '');
            $discountNetValue =(float) number_format((float) $discountResevTotal - $vatSum, 2, '.', '');
        }
        $municipalTax =(float) number_format((float) $discountNetValue - ($discountNetValue / $city_tax_calc_1), 2, '.', '');
        $accommodationTaxable =(float) number_format((float) $discountNetValue - $municipalTax, 2, '.', '');
        $reservTotal = $discountResevTotal;
    }

    if ($doc_type_name == "invoice_cancel" || $doc_type_name == "receipt_cancel") {
        $getEarlierDailyRateDatesResultCount = DailyRate::whereDate("date", "<", $arrivalDate)->where("reservation_id", $r_id)->count();

        if ($getEarlierDailyRateDatesResultCount > 0) {
            $isNoShow = 1;
        } else {
            $isNoShow = 0;
        }
        $totalEarlyAndNoShow = 0;

        if ($reservation->actual_checkout < $reservation->departure_date) {

            $accomTotal = $reservation->daily_rates()->whereDate('date', ">=", $reservation->actual_checkout)->whereDate("date", "<", $reservation->departure_date)->sum("price");
            $reservTotal = $accomTotal * $rateTypeEarlyCheckOutCharge;
            $totalEarlyAndNoShow += $reservTotal;
            //dd($reservTotal, $rateTypeEarlyCheckOutCharge, $accomTotal);
        }

        if ($isNoShow == 1) {
            $accomTotal = $reservation->daily_rates()->whereDate('date', "<", $arrivalDate)->sum("price");
            $reservTotal = $accomTotal * $rateTypeNoShowCharge;
            $totalEarlyAndNoShow += $reservTotal;
        }

        $vatt = 1.0 + ($cancellationVat / 100);

        //φορολογητέο (Taxable Amount)
        $taxable =(float) number_format((float) $totalEarlyAndNoShow / $vatt, 2, '.', '');

        //δημοτικός φόρος
        $municipalTax =(float) number_format(0, 2, '.', '');

        //καθαρή αξία (Net Value Amount)
        $netValue = (float) number_format((float) $taxable - $municipalTax, 2, '.', '');

        //ΦΠΑ
        $tax =(float) number_format((float) $totalEarlyAndNoShow - $taxable, 2, '.', '');

        return [
            'discount' => 0,
            'reservTotal' => $totalEarlyAndNoShow,
            'netValue' => $netValue,
            'discountNetValue' => 0,
            'accommodationTaxable' => $taxable,
            'municipalTax' => $municipalTax,
            'tax' => $tax,
            'rateTaxAmount' => 0,
            'vat' => $cancellationVat,
            'rateCategoryVat' => 0,
            'cityTax' => 0,
        ];
    }

    return [
        'discount' => $discount,
        'reservTotal' => $reservTotal,
        'netValue' => $netValue,
        'discountNetValue' => $discountNetValue,
        'accommodationTaxable' => $accommodationTaxable,
        'municipalTax' => $municipalTax,
        'tax' => $tax,
        'rateTaxAmount' => $rateTaxAmount,
        'vat' => $vat,
        'rateCategoryVat' => $rateCategoryVat,
        'cityTax' => $cityTax,
    ];
}

function createOxygenInvoice()
{
    $uri = env("OXYGEN_API_BASE") . "/invoices";
    $client = new Client;
    $response = $client->get($uri, [
        'headers' => ['Content-Type' => 'application/json', 'Authorization' => 'Bearer faee7ef0-5bd9-4751-acd2-ebb0699bd832'],
    ]);

    dd($response->getBody()->getContents());

}

/* @var Guest: $guest */

function create_oxygen_guest(&$guest)
{
    if (getHotelSettings()->oxygen_api_key) {
        $service = new OxygenService;
        $data = $service->createContact($guest, 'guest');
        if ($data["success"]) {
            $guest->oxygen_id = $data["id"];
        }
    }
}
function create_oxygen_company(&$company, $type)
{
    if (getHotelSettings()->oxygen_api_key) {
        $service = new OxygenService;
        $data = $service->createContact($company, $type, true);
        if ($data["success"]) {
            $company->oxygen_id = $data["id"];
        }
    }
}

function create_oxygen_document(&$document, $guest, $country, $reservation, $doctype, $oldDoc)
{
    if (getHotelSettings()->oxygen_api_key) {
        $data = new stdClass;
        $data->document = $document;
        $data->guest = $guest;
        $data->country = $country;
        $data->reservation = $reservation;
        $data->type=$doctype;
        $data->oldDoc=$oldDoc;
        $service = new OxygenService;
        $res = $service->createInvoice($data);
        return $res;
    }
}

function get_oxygen_document_pdf($id){

         $service= new OxygenService;
         $file=$service->getInvoicePdf($id, 'a4');

}

function createOxygenDocumentRow(){
    $documents=getHotelSettings()->document_types()->get();
    if (getHotelSettings()->oxygen_id) {
        $oxygenservice=new OxygenService;
        $getAllSequence=$oxygenservice->getNumberingSequences()->json();
        $sequences=collect($getAllSequence['data']);
        foreach ($documents as $document) {
                if ($document->type==1) {
                    $row=$sequences->where('document_type', 's')->where('name', $document->row)->first();
                    if ($row) {
                    }else{
                        $tax = [
                            'name' => $document->row,
                            'document_type' =>'s',
                            'title'=>'sequence '.$document->row,
                            'is_draft'=>true
                        ];
                        $oxygenservice=new OxygenService;
                        $res = $oxygenservice->createNumberingSequence($tax);
                    }

                    $row=$sequences->where('document_type', 'rs')->where('name', $document->row)->first();
                    if ($row) {
                    }else{
                        $tax = [
                            'name' => $document->row,
                            'document_type' =>'rs',
                            'title'=>'sequence '.$document->row,
                            'is_draft'=>true
                        ];
                        $oxygenservice=new OxygenService;
                        $res = $oxygenservice->createNumberingSequence($tax);
                    }

                }else  if ($document->type==2) {
                    $row=$sequences->where('document_type', 'pistlianiki')->where('name', $document->row)->first();
                    if ($row) {
                    }else{
                        $tax = [
                            'name' => $document->row,
                            'document_type' =>'pistlianiki',
                            'title'=>'sequence '.$document->row,
                            'is_draft'=>true
                        ];
                        $oxygenservice=new OxygenService;
                        $res = $oxygenservice->createNumberingSequence($tax);
                    }


                }else  if ($document->type==3) {
                    $row=$sequences->where('document_type', 'rs')->where('name', $document->row)->first();
                    if ($row) {
                    }else{
                        $tax = [
                            'name' => $document->row,
                            'document_type' =>'rs',
                            'title'=>'sequence '.$document->row,
                            'is_draft'=>true
                        ];
                        $oxygenservice=new OxygenService;
                        $res = $oxygenservice->createNumberingSequence($tax);
                    }


                }else  if ($document->type==4) {
                    $row=$sequences->where('document_type', 's')->where('name', $document->row)->first();
                    if ($row) {
                    }else{
                        $tax = [
                            'name' => $document->row,
                            'document_type' =>'s',
                            'title'=>'sequence '.$document->row,
                            'is_draft'=>true
                        ];
                        $oxygenservice=new OxygenService;
                        $res = $oxygenservice->createNumberingSequence($tax);
                    }


                }else  if ($document->type==5) {
                    $row=$sequences->where('document_type', 'rs')->where('name', $document->row)->first();
                    if ($row) {
                    }else{
                        $tax = [
                            'name' => $document->row,
                            'document_type' =>'rs',
                            'title'=>'sequence '.$document->row,
                            'is_draft'=>true
                        ];
                        $oxygenservice=new OxygenService;
                        $res = $oxygenservice->createNumberingSequence($tax);
                    }


                }else  if ($document->type==6) {
                    $row=$sequences->where('document_type', 'pistotiko')->where('name', $document->row)->first();
                    if ($row) {
                    }else{
                        $tax = [
                            'name' => $document->row,
                            'document_type' =>'pistotiko',
                            'title'=>'sequence '.$document->row,
                            'is_draft'=>true
                        ];
                        $oxygenservice=new OxygenService;
                        $res = $oxygenservice->createNumberingSequence($tax);
                    }


                }else{}


        }
    }
    
}

function getAvailability($room_type, $date)
{
    if ($room_type->type_status==0) {
        $total_availability=0;
    }else{
        $total_availability = $room_type->rooms->where('status', 'Enabled')->count();
        // Decrease count by rooms that are in the availability table
        $total_availability -= Availability::whereIn('room_id', $room_type->rooms->pluck('id'))->whereDate('date', $date)->count();

        // Decrease count for under maintenance rooms
        $total_availability -= Maintenance::whereIn('room_id', $room_type->rooms->pluck('id'))->where(function ($q) use ($date) {
            $q->whereDate('start_date', "<=", $date)
                ->whereDate('end_date', ">=", $date);
        })->count();
    }

    return $total_availability;
}



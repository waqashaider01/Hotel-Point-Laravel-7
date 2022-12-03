<?php

namespace App\Http\Livewire\Finance\Home;

use App\Models\Activity;
use App\Models\Company;
use App\Models\DailyRate;
use App\Models\Document;
use App\Models\DocumentInfo;
use App\Models\DocumentType;
use App\Models\GuestAccommodationPayment;
use App\Models\GuestOvernightTaxPayment;
use App\Models\PaymentMethod;
use App\Models\RateType;
use App\Models\Reservation;
use App\Models\Guest;
use App\Models\Country;
use Dflydev\DotAccessData\Data;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Validation\Validator;
use Livewire\Component;

class ReservationFee extends Component
{
    public Reservation $reservation;
    public Collection $methods;
    public Collection $companies;
    public array $values;
    protected Collection $extrasDetails;

//    accommodation payment modal values
    public string $accom_value = '';
    public string $accom_payment_date = '';
    public string $accom_payment_method = '';
    public string $accom_is_deposit = '';
    public string $accom_comment = '';
//    service payment modal values
    public string $service_value = '';
    public string $service_payment_date = '';
    public string $service_payment_method = '';
    public string $service_receipt_number = '';
    public string $service_comment = '';
//    overnight payment modal values
    public string $overnight_value = '';
    public string $overnight_payment_date = '';
    public string $overnight_payment_method = '';
    public string $overnight_comment = '';

//    receipt Accommodation
    public $receipt_document_name;
    public $receipt_document_type;
    public $receipt_guest_name;
    public $receipt_document_print_date;
    public $receipt_is_paid;
    public $receipt_payment_method;
    public $receipt_total_payment;
    public $receipt_net_value;
    public $receipt_discount;
    public $receipt_discount_net_value;
    public $receipt_taxable;
    public $receipt_municipal_tax;
    public $receipt_document_tax;
    public $receipt_rate_tax;
    public $receipt_checkin_date;
    public $receipt_checkout_date;
    public $receipt_vat;
    public $receipt_vat2;
    public $receipt_city_tax;
    public $receipt_document_comments; 

//    invoice Accommodation
    public $invoice_company;
    public $invoice_document_name;
    public $invoice_document_type;
    public $invoice_is_paid;
    public $invoice_payment_method; 
    public $invoice_document_print_date;
    public $invoice_guest_name;
    public $invoice_checkin_date;
    public $invoice_checkout_date;
    public $invoice_agency_name;
    public $invoice_agency_activity;
    public $invoice_agency_address;
    public $invoice_agency_tax_id;
    public $invoice_agency_tax_office;
    public $invoice_agency_postal;
    public $invoice_agency_phone;
    public $invoice_discount;
    public $invoice_total_payment;
    public $invoice_net_value;
    public $invoice_discount_net_value;
    public $invoice_taxable;
    public $invoice_municipal_tax;
    public $invoice_document_tax;
    public $invoice_rate_tax;
    public $invoice_vat;
    public $invoice_vat2;
    public $invoice_city_tax;
    public $invoice_document_comments;

//    receipt cancel Accommodation
    public $receipt_cancel_document_name;
    public $receipt_cancel_document_type;
    public $receipt_cancel_guest_name;
    public $receipt_cancel_document_print_date;
    public $receipt_cancel_is_paid;
    public $receipt_cancel_payment_method;
    public $receipt_cancel_total_payment;
    public $receipt_cancel_net_value;
    public $receipt_cancel_discount;
    public $receipt_cancel_discount_net_value;
    public $receipt_cancel_taxable;
    public $receipt_cancel_municipal_tax;
    public $receipt_cancel_document_tax;
    public $receipt_cancel_checkin_date;
    public $receipt_cancel_checkout_date;
    public $receipt_cancel_city_tax;
    public $receipt_cancel_cancellation_vat;
    public $receipt_cancel_document_comments;

//    invoice cancel Accommodation
    public $invoice_cancel_company;
    public $invoice_cancel_document_name;
    public $invoice_cancel_document_type;
    public $invoice_cancel_is_paid;
    public $invoice_cancel_payment_method;
    public $invoice_cancel_document_print_date;
    public $invoice_cancel_guest_name;
    public $invoice_cancel_checkin_date;
    public $invoice_cancel_checkout_date;
    public $invoice_cancel_agency_name;
    public $invoice_cancel_agency_activity;
    public $invoice_cancel_agency_address;
    public $invoice_cancel_agency_tax_id;
    public $invoice_cancel_agency_tax_office;
    public $invoice_cancel_agency_postal;
    public $invoice_cancel_agency_phone;
    public $invoice_cancel_total_payment;
    public $invoice_cancel_net_value;
    public $invoice_cancel_taxable;
    public $invoice_cancel_municipal_tax;
    public $invoice_cancel_document_tax;
    public $invoice_cancel_cancellation_tax;
    public $invoice_cancel_document_comments;

//    General
    public bool $accommodation_payable = true;
    public bool $overnight_payable = true;
    public bool $accommodation_printable = true;
    public bool $overnight_printable = true;
    public array $extras;
    public $service_vat = 0;
    public string $type_id = '';
    public string $type_name = '';
    public string $guest = '';
    public string $payment_method_id = '';
    public string $paid = '';
    public string $print_date = '';
    public string $check_in = '';
    public string $check_out = '';
    public $vat = 0;
    public $overnight_tax = 0;
    public $overnight_tax_paid = 0;
    public array $accom_options;
    public string $selected_accom_type = '';
    public $selected_document_original_type;
    public $mark_id;

    /* New gernal errors and warning */
    public string $mynoshow;
    public string $myaccomDoc;
    public string $mycancellationFeesAccomDoc;
    public string $mynote;
    public $cancellationFeesAccomDoc;
    public $accomDoc;
    public $overnightDoc;
    public $myovernightDoc = '';
    public $myaccomDocText='';
    public $rateTypeEarlyCheckOutCharge;
	public $rateTypeNoShowCharge;
    public $pdfContent = "";
    public $accom_refund_value;
    public $isFullNoShow='';


    public function mount(Reservation $reservationId)
    {
        $this->reservation = $reservationId; 
        $this->methods = getHotelSettings()->payment_methods;
        $this->values = getStatusesAndValues($this->reservation->id);
        $this->accommodation_payable = $this->values['accom_charge'] > 0;
        $this->overnight_payable = $this->values['overnight_charge'] > 0;
        $this->accommodation_printable = $this->values['accom_charge'] == 0;
        $this->overnight_printable = $this->values['overnight_charge'] == 0;

        $this->values = getStatusesAndValues($this->reservation->id);
        $this->rateTypeEarlyCheckOutCharge = $this->reservation->rate_type->early_checkout_charge_percentage / 100;
		$this->rateTypeNoShowCharge = $this->reservation->rate_type->no_show_charge_percentage / 100;
        $isFullNoShow = '';
        if ($this->reservation->arrival_date == $this->reservation->departure_date && $this->reservation->status == 'No Show') {
            $isFullNoShow = 1;
            $this->isFullNoShow=1;
        } else {
            $isFullNoShow = 0;
            $this->isFullNoShow=0;
        }
        // dd($this->reservation->departure_date);
        $isNoShow = '';
        $mynoshow = "";
        $getEarlierDailyRateDates = DailyRate::whereDate("date", "<", $this->reservation->arrival_date)->where("reservation_id", $reservationId->id)->count();

        if ($getEarlierDailyRateDates > 0) {
            $isNoShow = 1;

            if ($isFullNoShow == 1) {
                $mynoshow = '
                            <i class="fa fa-2x fa-exclamation-circle" type="button"   data-html="true" type="button" data-toggle="tooltip" data-placement="top" title="This Reservation Is Full No Show"  style="color:orange;" aria-hidden="true"></i>&nbsp;<!--//warning-->
                    ';
                //echo "<p style='background-color:orange; color:#fff; padding:5px;'><b>Notice : This Reservation Is Full No Show </b></p>";	
            } else {
                $mynoshow = '
            <i class="fa fa-2x fa-exclamation-circle" type="button"   data-html="true" type="button" data-toggle="tooltip" data-placement="top" title="This Reservation Was  No Show"  style="color:orange;" aria-hidden="true"></i>&nbsp;<!--//warning-->
                    ';
                // $mynoshow="Was No Show";
                //echo "<p style='background-color:orange; color:#fff; padding:5px;'><b>Notice : This Reservation Was  No Show </b></p>";	
            }
        } else {
            $mynoshow = "";
            //$isNoShowAccomTotal=0;
            $isNoShow = 0;
        }
        $this->mynoshow = $mynoshow;

        //check if receipt or invoice are created

        $accomDoc = '';
        $cancellationFeesAccomDoc = '';
        $mycancellationFeesAccomDoc = '';
        $mynote = "";
        $myaccomDoc = "";

        $checkAccomDocResult = Document::join("document_infos", "document_infos.document_id", "=", "documents.id")
            ->join("activities", "activities.document_id", "=", "documents.id")
            ->join("document_types", "documents.document_type_id", "=", "document_types.id")
            ->where("activities.reservation_id", $reservationId->id)
                ->where(function ($q) {
                    $q->where("document_types.type", 4)
                    ->where("activities.description", "NOT LIKE", "Cancellation Fees")
                    ->orWhere("document_types.type", 5);
                })->count();


        if ($this->reservation->actual_checkin == $this->reservation->actual_checkout) //if guest leaves same day when he arrived
        {
            $myaccomDoc = '<i class="fa fa-2x fa-info-circle" type="button"  data-html="true" type="button" data-toggle="tooltip" data-placement="top" 
		title="Guest Leaves the same day he arrived. Accommodation Document can not be printed"  style="color:blue;" aria-hidden="true"></i>&nbsp;<!--//info-->';

            $accomDoc = 1; //dont let him create invoice or receipt

        } else  //if guest does not leave same day when he arrived
        {
            if ($checkAccomDocResult > 0)  //if a receipt or invoice is already created
            {
                $myaccomDoc = '<i class="fa fa-2x fa-check-circle" type="button"   data-html="true" type="button" data-toggle="tooltip" data-placement="top" 
			title="Accommodation Document is printed "  style="color:green;" aria-hidden="true"></i>&nbsp;<!--//ok-->';

                $accomDoc = 1; //dont allow user to create invoice or receipt again

            } else //else if a receipt or invoice is not already created
            {
                $myaccomDoc = '<i class="fa fa-2x fa-exclamation-circle" type="button"   data-html="true" type="button" data-toggle="tooltip" data-placement="top" 
			title="Accommodation Document is not printed"  style="color:orange;" aria-hidden="true"></i>&nbsp;<!--//warning-->';

                $accomDoc = 0; //allow user to create invoice or receipt 

            }
        }

        if ($this->reservation->actual_checkout < $this->reservation->departure_date || $isNoShow == 1) //if guest came later or left earlier
        {

            $cancellationFeesAccomDocResult = Document::join("document_infos", "document_infos.document_id", "=", "documents.id")
            ->join("activities", "activities.document_id", "=", "documents.id")
            ->join("document_types", "documents.document_type_id", "=", "document_types.id")
            ->where("activities.reservation_id", $reservationId->id)
                ->where("activities.description", "LIKE", "Cancellation Fees")
                ->where(function ($q) {
                    $q->where("document_types.type", 1)
                    ->orWhere("document_types.type", 4);
                })->count();



            if ($cancellationFeesAccomDocResult > 0) //if cancellation fees document is created
            {
                $mycancellationFeesAccomDoc = '<i class="fa fa-2x fa-check-circle" type="button"   data-html="true" type="button" data-toggle="tooltip" data-placement="top" 
			title="Cancellation Fees Accommodation Document is printed"  style="color:green;" aria-hidden="true"></i>&nbsp;<!--//ok-->';

                $cancellationFeesAccomDoc = 1; //dont allow user to create cancellation fees invoice or receipt again

            } else //if no cancellation fees document is created
            {
                $mycancellationFeesAccomDoc = '<i class="fa fa-2x fa-bell" type="button"   data-html="true" type="button" data-toggle="tooltip" data-placement="top" 
			title="Cancellation Fees Accommodation Document is not printed"  style="color:red;" aria-hidden="true"></i><!--//alert-->';

                $cancellationFeesAccomDoc = 0; //allow user to create cancellation fees invoice or receipt 

            }
        }

        if (empty($this->reservation->checkin_guest_id)) {
            $this->accommodation_printable = false;

            $mynote = '<i class="fa fa-2x fa-bell" type="button"   data-html="true" type="button" data-toggle="tooltip" data-placement="top" 
		title="No Guest Is Assigned To The Reservation. You Will Not Be Able To Print Documents."  style="color:red;" aria-hidden="true"></i><!--//alert-->';
        }

        if ($this->reservation->actual_checkout == $this->reservation->departure_date && $isNoShow == 0) {
            $cancellationFeesAccomDoc = 1;
        }

        if ($isFullNoShow == 1) {
            $accomDoc = 1; // if it is full no show dont allow user to create an original accommodation doc

            $myaccomDoc = '<i class="fa fa-2x fa-exclamation-circle" type="button"   data-html="true" type="button" data-toggle="tooltip" data-placement="top" 
			title="Reservation is Full No Show Accommodation Document can not be printed"  style="color:orange;" aria-hidden="true"></i>&nbsp;<!--//warning-->';
        }

        
        $checkOvernightDoc = getHotelSettings()->documents()->join("document_infos", "document_infos.document_id","=", "documents.id")
                    ->join("activities", "activities.document_id", "=", "documents.id")
                    ->join("document_types", "document_types.id", "=", "documents.document_type_id")
                    ->where("activities.reservation_id", $reservationId->id)
                    ->where("document_types.type", 3)
                    ->count();

                    if ($accomDoc== 0) {
                        $myaccomDocText = '<i class="fa fa-2x fa-exclamation-circle" type="button"   data-html="true" type="button" data-toggle="tooltip" data-placement="top" title="To print overnight tax document you need to print all accommodation documents first. "  style="color:orange;" aria-hidden="true"></i>&nbsp;'; //warning
                    }
            if ($this->reservation->actual_checkin == $this->reservation->actual_checkout) {
                $myovernightDoc = '<i class="fa fa-2x fa-info-circle" type="button"  data-html="true" type="button" data-toggle="tooltip" data-placement="top" title="Guest Leaves the same day he arrived. Overnight Tax Document can not be printed"  style="color:blue;" aria-hidden="true"></i>&nbsp;'; //info
                $overnightDoc = 1;
            } else {

                if ($isFullNoShow == 1) {
                    $myovernightDoc = '<i class="fa fa-2x fa-exclamation-circle" type="button"   data-html="true" type="button" data-toggle="tooltip" data-placement="top" title="Reservatin is Full No Show. Overnight Tax Document can not printed"  style="color:orange;" aria-hidden="true"></i>&nbsp;'; //warning
                    $overnightDoc = 1;
                } else {
                    if ($checkOvernightDoc > 0) {
                        $myovernightDoc = '<i class="fa fa-2x fa-check-circle" type="button"   data-html="true" type="button" data-toggle="tooltip" data-placement="top" title="Overnight Tax Document is printed "  style="color:green;" aria-hidden="true"></i>&nbsp;'; //ok
                        //echo "<p style= 'background-color:#7ed97e; color:#fff; padding:5px; font-weight:bold;'> Overnight Tax Document is printed </p>";
                        $overnightDoc = 1;
                    } else {
                        $myovernightDoc = '<i class="fa fa-2x fa-exclamation-circle" type="button"   data-html="true" type="button" data-toggle="tooltip" data-placement="top" title="Overnight Tax Document is not printed "  style="color:orange;" aria-hidden="true"></i>&nbsp;'; //warning
                        //echo "<p style= 'background-color:orange; color:#fff; padding:5px;'> Overnight Tax Document is not printed </p>";
                        $overnightDoc = 0;
                    }
                }
            }

        $this->myaccomDoc = $myaccomDoc;
        $this->mycancellationFeesAccomDoc = $mycancellationFeesAccomDoc;
        $this->mynote = $mynote;
        $this->cancellationFeesAccomDoc = $cancellationFeesAccomDoc;
        $this->accomDoc = $accomDoc;
        $this->overnightDoc = $overnightDoc;
        $this->myovernightDoc = $myovernightDoc;
        $this->myaccomDoc = $myaccomDoc;

        $this->getAccomSelect(); 

    }

    public function render()
    {
        $this->extrasDetails = collect($this->reservation->reservation_extra_charges()->with('extra_charge')->get()->groupBy('receipt_number'));
        return view('livewire.finance.home.reservation-fee')->with([
            'extrasDetails' => $this->extrasDetails
        ]);
    }

    public function refundBtnClick($type="accom") {
        if($type === "overnight"){

            $currentOvernights = Carbon::parse($this->reservation->actual_checkout)->diffInDays(Carbon::parse($this->reservation->actual_checkin));
            $overnight_tax = getHotelSettings()->overnight_tax->tax;
            $overnightsTotalPaid = $this->reservation->guest_overnight_tax_payments()->sum('value');
            $overnightTotal = $overnight_tax * $currentOvernights;
            $balance = ($overnightTotal - $overnightsTotalPaid);

            $this->accom_refund_value = ($balance * -1);
        }else {
            $this->accom_refund_value = ($this->values['accom_charge'] * -1);
        }
        $this->accom_payment_date = today()->toDateString();
    }

    public function refundAccomPayment() {
        $this->validate([
            "accom_refund_value" => "required",
            "accom_payment_method" => "required",
            'accom_payment_date' => 'required|date_format:Y-m-d',
        ]);
        $balance = $this->values['accom_charge'];
        if ($this->values['accom_total'] < $this->values['accom_paid']) {
            
            GuestAccommodationPayment::create([
                'value' => ($this->accom_refund_value * -1),
                'date' => $this->accom_payment_date,
                'transaction_id' => $this->accom_comment,
                'payment_method_id' => $this->accom_payment_method,
                'reservation_id' => $this->reservation->id,
            ]);

            return redirect(request()->header("Referer"));
         } else {
            $this->emit('showWarning', 'Accommodation Balance Is zero. You can not refund any money');

        }
    }

    public function saveAccommodationPayment()
    {
        $balance = $this->values['accom_charge'];
        if ($balance == 0) {
            $this->emit('showWarning', 'Accommodation Balance Is zero. You can not charge any more money');
        } else if ($this->accom_value > $balance) {
            $this->emit('showWarning', 'Guests Balance is less than the given amount.');
        } else {
            $this->validate([
                'accom_payment_method' => 'required',
                'accom_payment_date' => 'required|date_format:Y-m-d',
                'accom_is_deposit' => 'required',
            ]);
            GuestAccommodationPayment::create([
                'value' => $this->accom_value,
                'date' => $this->accom_payment_date,
                'transaction_id' => $this->accom_comment,
                'is_deposit' => $this->accom_is_deposit,
                'payment_method_id' => $this->accom_payment_method,
                'reservation_id' => $this->reservation->id,
            ]);
            $this->emit('dataSaved', 'Payment was made successfully.');
            return redirect(request()->header("Referer"));
        }
    }

    public function refundOvernightPayment() {

        $currentOvernights = Carbon::parse($this->reservation->actual_checkout)->diffInDays(Carbon::parse($this->reservation->actual_checkin));
        $overnight_tax = getHotelSettings()->overnight_tax->tax;
        $overnightsTotalPaid = $this->reservation->guest_overnight_tax_payments()->sum('value');
        $overnightTotal = $overnight_tax * $currentOvernights;
        $balance = ($overnightTotal - $overnightsTotalPaid) * -1;

        $this->validate([
            "accom_refund_value" => "required",
            "accom_payment_method" => "required",
            'accom_payment_date' => 'required|date_format:Y-m-d',
        ]);

        if ($overnightTotal < $overnightsTotalPaid) {
            
            $this->reservation->guest_overnight_tax_payments()->create([
                'value' => ($this->accom_refund_value * -1),
                'date' => $this->accom_payment_date,
                'transaction_id' => $this->accom_comment,
                'payment_method_id' => $this->accom_payment_method,
            ]);

            return redirect(request()->header("Referer"));
         } else {
            $this->emit('showWarning', 'Overnight Tax Balance Is zero. You can not refund any money');

        }
    }

    public function saveOvernightPayment()
    {
        $currentOvernights = Carbon::parse($this->reservation->actual_checkout)->diffInDays(Carbon::parse($this->reservation->actual_checkin));
        $overnight_tax = getHotelSettings()->overnight_tax->tax;
        $overnightsTotalPaid = $this->reservation->guest_overnight_tax_payments()->sum('value');
        $overnightTotal = $overnight_tax * $currentOvernights;
        $balance = $overnightTotal - $overnightsTotalPaid;
        if ($balance == 0) {
            $this->emit('showWarning', 'Overnight Tax Balance Is zero. You can not charge any more money');
        } else if ($this->overnight_value > $balance) {
            $this->emit('showWarning', 'Overnight Tax Balance is less than the given amount.');
        } else {
            $this->validate([
                'overnight_payment_method' => 'required',
                'overnight_payment_date' => 'required|date_format:Y-m-d',
            ]);
            $this->reservation->guest_overnight_tax_payments()->create([
                'value' => $this->overnight_value,
                'date' => $this->overnight_payment_date,
                'transaction_id' => $this->overnight_comment,
                'payment_method_id' => $this->overnight_payment_method,
            ]);
            $this->emit('dataSaved', 'Payment was made successfully.');
            return redirect(request()->header("Referer"));
        }
    }

    public function saveExtrasPayment() 
    {
        $balance = $this->values['extras_charge'];
        if ($balance == 0) {
            $this->emit('showWarning', 'Extra Charge Balance Is zero. You can not charge any more money');
        } else if ($this->service_value > $balance) {
            $this->emit('showWarning', 'Extra Charge Balance is less than the given amount.');
        } else {
            try {
                DB::transaction(function () {
                    $this->reservation->guest_extras_payments()->create([
                        'value' => $this->service_value,
                        'payment_method_id' => $this->service_payment_method,
                        'date' => today()->toDateString(),
                        'transaction_id' => $this->service_comment,
                    ]);
                    $this->reservation->reservation_extra_charges()->where('receipt_number', $this->service_receipt_number)->update([
                        'is_paid' => '1',
                        'payment_method_id' => $this->service_payment_method,
                    ]);
                });
                $this->emit('dataSaved', 'Payment was made successfully.');
                return redirect(request()->header("Referer"));
            } catch (\Exception $e) {
                $this->emit('showWarning', $e->getMessage());
            }
        }
    }

    public function setSelectedType($type_id, $document)
    {
        $this->type_id = $type_id;
        $companies=getHotelSettings()->companies;
        $agencies=getHotelSettings()->booking_agencies;
        $this->companies = $companies;
        $this->selected_accom_type = $document;
        $max_payment_method = $this->reservation->guest_accommodation_payment()->orderBy('value', 'desc')->first()->payment_method_id ?? 2;
        $document_type = getHotelSettings()->document_types()->find($type_id);
        $document_details = calculateDocumentFields($this->reservation->id, $document);
        $check_in = $this->reservation->actual_checkin;
        $check_out = $this->reservation->actual_checkout;
        $guest_name = $this->reservation->checkin_guest->full_name ?? $this->reservation->guest->full_name;
        $this->selected_document_original_type = $document_type->type;

        if ($document == 'invoice_accom') { // type is invoice
            $this->invoice_document_name = $document_type->name;
            $this->invoice_document_type = $type_id;
            $this->invoice_payment_method = $max_payment_method;
            $this->invoice_document_print_date = today()->toDateString();
            $this->invoice_guest_name = $guest_name;
            $this->invoice_checkin_date = $check_in;
            $this->invoice_checkout_date = $check_out;
            $this->invoice_agency_name = $this->reservation->booking_agency->name;
            $this->invoice_agency_activity = $this->reservation->booking_agency->activity;
            $this->invoice_agency_address = $this->reservation->booking_agency->address;
            $this->invoice_agency_tax_id = $this->reservation->booking_agency->vat_number;
            $this->invoice_agency_postal = $this->reservation->booking_agency->postal_code;
            $this->invoice_agency_phone = $this->reservation->booking_agency->phone_number;
            $this->invoice_discount = $document_details['discount'];
            $this->invoice_total_payment = $document_details['reservTotal'];
            $this->invoice_net_value = $document_details['netValue'];
            $this->invoice_discount_net_value = $document_details['discountNetValue'];
            $this->invoice_taxable = $document_details['accommodationTaxable'];
            $this->invoice_municipal_tax = $document_details['municipalTax'];
            $this->invoice_document_tax = $document_details['tax'];
            $this->invoice_rate_tax = $document_details['rateTaxAmount'];
            $this->invoice_vat = $document_details['vat'];
            $this->invoice_vat2 = $document_details['rateCategoryVat'];
            $this->invoice_city_tax = $document_details['cityTax'];
            $this->invoice_document_comments = '';
            $this->invoice_is_paid = "1";
        }
        if ($document == 'invoice_cancel') { // type is invoice
            $this->invoice_cancel_document_name = $document_type->name;
            $this->invoice_cancel_document_type = $type_id;
            $this->invoice_cancel_is_paid = "1";
            $this->invoice_cancel_payment_method = $max_payment_method;
            $this->invoice_cancel_document_print_date = today()->toDateString();
            $this->invoice_cancel_guest_name = $guest_name;
            $this->invoice_cancel_checkin_date = $check_in;
            $this->invoice_cancel_checkout_date = $check_out;
            $this->invoice_cancel_agency_name = $this->reservation->booking_agency->name;
            $this->invoice_cancel_agency_activity = $this->reservation->booking_agency->activity;
            $this->invoice_cancel_agency_address = $this->reservation->booking_agency->address;
            $this->invoice_cancel_agency_tax_id = $this->reservation->booking_agency->vat_number;
            $this->invoice_cancel_agency_tax_office = $this->reservation->booking_agency->tax_office;
            $this->invoice_cancel_agency_postal = $this->reservation->booking_agency->postal_code;
            $this->invoice_cancel_agency_phone = $this->reservation->booking_agency->phone_number;
            $this->invoice_cancel_total_payment = $document_details['reservTotal'];
            $this->invoice_cancel_net_value = $document_details['netValue'];
            $this->invoice_cancel_taxable = $document_details['accommodationTaxable'];
            $this->invoice_cancel_municipal_tax = $document_details['municipalTax'] ?? 0.00;
            $this->invoice_cancel_document_tax = $document_details['tax'];
            $this->invoice_cancel_cancellation_tax = $document_details['vat'];
            $this->invoice_cancel_document_comments = '';

        }
        if ($document == 'receipt_accom') { // type is receipt

            $this->receipt_document_name = $document_type->name;
            $this->receipt_document_type = $type_id;
            $this->receipt_guest_name = $guest_name;
            $this->receipt_document_print_date = today()->toDateString();
            $this->receipt_is_paid = "1";
            $this->receipt_payment_method = $max_payment_method;
            $this->receipt_total_payment = $document_details['reservTotal'];
            $this->receipt_net_value = $document_details['netValue'];
            $this->receipt_discount = $document_details['discount'];
            $this->receipt_discount_net_value = $document_details['discountNetValue'];
            $this->receipt_taxable = $document_details['accommodationTaxable'];
            $this->receipt_municipal_tax = $document_details['municipalTax'];
            $this->receipt_document_tax = $document_details['tax'];
            $this->receipt_rate_tax = $document_details['rateTaxAmount'];
            $this->receipt_checkin_date = $check_in;
            $this->receipt_checkout_date = $check_out;
            $this->receipt_vat = $document_details['vat'];
            $this->receipt_vat2 = $document_details['rateCategoryVat'];
            $this->receipt_city_tax = $document_details['cityTax'];
            $this->receipt_document_comments = '';
        }
        if ($document == 'receipt_cancel') { // type is receipt cancel
            $this->receipt_cancel_document_name = $document_type->name;
            $this->receipt_cancel_document_type = $type_id;
            $this->receipt_cancel_guest_name = $guest_name;
            $this->receipt_cancel_document_print_date = today()->toDateString();
            $this->receipt_cancel_is_paid = "1";
            $this->receipt_cancel_payment_method = $max_payment_method;
            $this->receipt_cancel_discount = $document_details['discount'];
            $this->receipt_cancel_total_payment = $document_details['reservTotal'];
            $this->receipt_cancel_net_value = $document_details['netValue'];
            $this->receipt_cancel_discount_net_value = $document_details['discountNetValue'];
            $this->receipt_cancel_taxable = $document_details['accommodationTaxable'];
            $this->receipt_cancel_municipal_tax = $document_details['municipalTax'];
            $this->receipt_cancel_document_tax = $document_details['tax'];
            $this->receipt_cancel_checkin_date = $check_in;
            $this->receipt_cancel_checkout_date = $check_out;
            $this->receipt_cancel_cancellation_vat = $document_details['vat'];
            $this->receipt_cancel_city_tax = $document_details['cityTax'];
            $this->receipt_cancel_document_comments = '';
        }
    }

    public function getAccomSelect()
    {
        $my_accom_options = [];
        $paymentMode = $this->reservation->payment_mode;
        $isFullNoShow = $this->reservation->actual_checkin == null || $this->reservation->actual_checkin == '';
        $noShow = getStatusesAndValues($this->reservation->id)['no_show'];
        if ($paymentMode->name != 'Pay Own Account') {
            $data = array();
            $doc_type = getHotelSettings()->document_types()->where("type", 4)->first();
            if ($isFullNoShow) {
                if ($this->cancellationFeesAccomDoc == 1) {
                    $data['disabled'] = true;
                }
                $data['name'] = 'Τιμολόγιο Παροχής Υπηρεσιών ( Για Cancellation Fees )';
                $data['document'] = 'invoice_cancel';
                $data['type'] = $doc_type->id;
                $my_accom_options[] = $data;
            } else {

                if ($this->reservation->actual_checkout < $this->reservation->departure_date || $noShow) {
                    $data = array();
                    $data['name'] = $doc_type->name;
                    $data['document'] = 'invoice_accom';
                    $data['type'] = $doc_type->id;
                    if ($this->reservation->actual_checkout == $this->reservation->actual_checkin  || $this->accomDoc == 1) {
                        $data['disabled'] = true;
                    }
                    $my_accom_options[] = $data;
                    $data = array();
                    if ($this->cancellationFeesAccomDoc == 1) {
                        $data['disabled'] = true;
                    }
                    $data['name'] = 'Τιμολόγιο Παροχής Υπηρεσιών ( Για Cancellation Fees )';
                    $data['document'] = 'invoice_cancel';
                    $data['type'] = $doc_type->id;
                    $my_accom_options[] = $data;
                }

                if ($this->reservation->actual_checkout == $this->reservation->departure_date && !$noShow) {
                    $data = array();
                    if ($this->accomDoc == 1) {
                        $data['disabled'] = true;
                    }
                    $data['name'] = $doc_type->name;
                    $data['document'] = 'invoice_accom';
                    $data['type'] = $doc_type->id;

                    $my_accom_options[] = $data;
                }
            }
        } else {

            if ($this->reservation->actual_checkout < $this->reservation->departure_date || $noShow) {
                $doc_types = getHotelSettings()->document_types()->whereIn("type", [5, 4, 1])->orderBy("type", "DESC")->get();
                foreach ($doc_types as $doc) {
                    if ($doc->type == 4) {
                        $data = array();
                        if ($this->reservation->actual_checkout == $this->reservation->actual_checkin || $this->accomDoc == 1) {
                            $data["disabled"] = true;
                        }
                        $data['name'] = $doc->name;
                        $data['type'] = $doc->id;
                        $data['document'] = 'invoice_accom';
                        $my_accom_options[] = $data;
                        $data = array();
                        if ($this->cancellationFeesAccomDoc == 1) {
                            $data["disabled"] = true;
                        }
                        $data['name'] = 'Τιμολόγιο Παροχής Υπηρεσιών (Για Cancellation Fees )';
                        $data['type'] = $doc->id;
                        $data['document'] = 'invoice_cancel';
                        $my_accom_options[] = $data;
                    }
                    if ($doc->type == 5) {
                        $data = array();
                        if ($this->reservation->actual_checkout == $this->reservation->actual_checkin || $this->accomDoc == 1) {
                            $data["disabled"] = true;
                        }
                        $data['name'] = $doc->name . ' ' . '(default)';
                        $data['document'] = 'invoice_accom';
                        $data['type'] = $doc->id;
                        $my_accom_options[] = $data; 
                    }
                    if ($doc->type == 1) {
                        if ($this->reservation->actual_checkout == $this->reservation->actual_checkin) {
                            $data = array();
                            if ($this->cancellationFeesAccomDoc == 1) {
                                $data["disabled"] = true;
                            }
                            $data['name'] = $doc->name . ' ' . '(default)';
                            $data['type'] = $doc->id;
                            $data['document'] = 'receipt_cancel';
                            $my_accom_options[] = $data;
                        } else {
                            $data = array();
                            if ($this->cancellationFeesAccomDoc == 1) {
                                $data["disabled"] = true;
                            }
                            $data['name'] = $doc->name;
                            $data['type'] = $doc->id;
                            $data['document'] = 'receipt_cancel';
                            $my_accom_options[] = $data;
                        }
                    }
                }
            }
            if ($this->reservation->actual_checkout == $this->reservation->departure_date && !$noShow) {
                $doc_types = getHotelSettings()->document_types()->whereIn("type", [5, 4])->orderBy("type", "DESC")->get();
                foreach ($doc_types as $doc) {
                    $data = array();
                    if($this->accomDoc == 1) {
                        $data['disabled'] = true;
                    }
                    if($doc->type == 5) {
                        $data['name'] = $doc->name . ' ' . '(default)';
                    }else {
                        $data['name'] = $doc->name . ' ' . '(Only by guest demand)';
                    }
                    $data['type'] = $doc->id;
                    $data['document'] = 'invoice_accom';
                    $my_accom_options[] = $data;
                }
            }
        }
        $this->accom_options = $my_accom_options;
    }

    public function invoiceAccomRules() {
        return [
            "invoice_document_name" => "required",
            "invoice_document_type" => "required",
            "invoice_is_paid" => "required",
            "invoice_payment_method" => "required", 
            "invoice_document_print_date" => "required",
            "invoice_guest_name" => "required",
            "invoice_checkin_date" => "required",
            "invoice_checkout_date" => "required",
            "invoice_discount" => "required",
            "invoice_total_payment" => "required",
            "invoice_net_value" => "required",
            "invoice_discount_net_value" => "required",
            "invoice_taxable" => "required",
            "invoice_municipal_tax" => "required",
            "invoice_document_tax" => "required",
            "invoice_rate_tax" => "required",
            "invoice_vat" => "required",
            "invoice_city_tax" => "required",
            "invoice_company"=>"required",

        ];
    }
    
    public function invoiceCancelRules() {
        return [
            "invoice_cancel_document_name" => "required",
            "invoice_cancel_document_type" => "required",
            "invoice_cancel_is_paid" => "required",
            "invoice_cancel_payment_method" => "required", 
            "invoice_cancel_document_print_date" => "required",
            "invoice_cancel_guest_name" => "required",
            "invoice_cancel_checkin_date" => "required",
            "invoice_cancel_checkout_date" => "required",
            // "invoice_discount" => "required",
            "invoice_cancel_total_payment" => "required",
            "invoice_cancel_net_value" => "required",
            // "invoice_discount_net_value" => "required",
            "invoice_cancel_taxable" => "required",
            "invoice_cancel_municipal_tax" => "required",
            "invoice_cancel_document_tax" => "required",
            // "invoice_rate_tax" => "required",
            "invoice_cancel_cancellation_tax" => "required",
            // "invoice_city_tax" => "required",
            "invoice_cancel_company"=>"required",

        ];
    }

    public function receiptAccomRules() {
        return [
            "invoice_document_name" => "required",
            "invoice_document_type" => "required",
            "invoice_is_paid" => "required",
            "invoice_payment_method" => "required", 
            "invoice_document_print_date" => "required",
            "invoice_guest_name" => "required",
            "invoice_checkin_date" => "required",
            "invoice_checkout_date" => "required",
            "invoice_discount" => "required",
            "invoice_total_payment" => "required",
            "invoice_net_value" => "required",
            "invoice_discount_net_value" => "required",
            "invoice_taxable" => "required",
            "invoice_municipal_tax" => "required",
            "invoice_document_tax" => "required",
            "invoice_rate_tax" => "required",
            "invoice_vat" => "required",
            "invoice_city_tax" => "required",
            

        ];
    }

    public function overnightDocumentRules() {
        return [
            "mark_id" => "required",
            "type_name" => "required",
            "guest" => "required",
            "payment_method_id" => "required",
            "paid" => "required",
            "vat" => "required",
            "print_date" => "required",
            "check_in" => "required",
            "check_out" => "required",
            "overnight_tax" => "required",
            "overnight_tax_paid" => "required"
        ];
    }

    public function printDocument($value)
    {
        if ($value == 'overnight') { 

            $validator = FacadesValidator::make($this->getDataForValidation($this->overnightDocumentRules()), $this->overnightDocumentRules());

            if($validator->fails()) {
                $this->emit("loading", false);
            }
            $this->validate($this->overnightDocumentRules());
            
            try {
                DB::beginTransaction();
                $doc_type = getHotelSettings()->document_types()->find($this->type_id);
                $enumeration = $doc_type->enumeration;
                $docTypeRow = $doc_type->row;
                $description = 'Overnight Tax';
                $quantity = 1;
                $document = Document::create([
                    'hotel_settings_id' => getHotelSettings()->id,
                    'row' => '' . $docTypeRow,
                    'enumeration' => $enumeration,
                    'print_date' => $this->print_date,
                    'payment_method_id' => $this->payment_method_id,
                    'total' => $this->overnight_tax_paid,
                    'net_value' => $this->overnight_tax_paid,
                    'discount_net_value' => $this->overnight_tax_paid,
                    'comments' => $this->comments,
                    'document_type_id' => $this->type_id,
                    'vat' => $this->vat,
                    'paid' => $this->paid,
                    "mark_id" => $this->mark_id,
                ]);
                $doc_info = DocumentInfo::create([
                    'company_id' => $this->reservation->company_id,
                    'booking_agency_id' => $this->reservation->booking_agency_id,
                    'document_id' => $document->id,
                    'guest_id' => $this->reservation->guest_id,
                ]);
                $from = Carbon::parse($this->check_in);
                $to = Carbon::parse($this->check_out);
                while ($from < $to) {
                    $activity = Activity::create([
                        'description' => $description,
                        'price' => $this->overnight_tax,
                        'quantity' => $quantity,
                        'date' => $from->toDateString(),
                        'vat' => $this->vat,
                        'reservation_id' => $this->reservation->id,
                        'document_id' => $document->id,
                    ]);
                    $from = $from->addDay();
                }
                $doc_type->enumeration = (int)$enumeration + 1;
                $doc_type->save();
                //Save locally or send to oxygen API
                // send document to oxygen........
                if (getHotelSettings()->oxygen_api_key) {
                    $createoxyDoc=create_oxygen_document($document, $this->reservation->guest, $this->reservation->guest->country, $this->reservation, $value, $document);
                    if ($createoxyDoc) {
                        DB::commit();
                        $this->emit('dataSaved', 'Document printed successfully');
                        $this->emit('windowReload');
                    }else{
                        
                        $this->emit('showError', 'An unexpected error has occured. Please try again.');
                        $this->emit('windowReload');
                    }
                }else{
                    $pdf = generateTaxDocument($document->id, $this->reservation->id);
                    $filename = 'document-' . time() . '.pdf';
                    Storage::put('public/invoices/' . $filename, $pdf->output());
                    $document->print_path = $filename;
                    $document->save();
                    DB::commit();
                    $this->emit('dataSaved', 'Document printed successfully');
        
                    $pdfContent = $pdf->output();
                    $this->emit('windowReload');
                    // return response()->streamDownload(
                    //     fn() => print($pdfContent),
                    //     $this->invoice_cancel_guest_name . ".pdf"
                    // );
                
                    
                }
            }catch (\Throwable $th) {
                //throw $th;
                $this->emit('error', $th->getMessage());
                DB::rollBack();
            }
        } elseif ($value == 'invoice_cancel') {
            $validator = FacadesValidator::make($this->getDataForValidation($this->invoiceCancelRules()), $this->invoiceCancelRules());

            if($validator->fails()) {
                $this->emit("loading", false);
            }
            $this->validate($this->invoiceCancelRules());
            try{
                DB::beginTransaction();
            $doc_type = getHotelSettings()->document_types()->find($this->type_id);
            $enumeration = $doc_type->enumeration;
            $docTypeRow = $doc_type->row;
            $description = 'Cancellation Fees';
            $quantity = 1;
            $document = new Document;
            $document->row = '' . $docTypeRow;
            $document->hotel_settings_id = getHotelSettings()->id;
            $document->enumeration = $enumeration;
            $document->print_date = $this->invoice_cancel_document_print_date;
            $document->payment_method_id = $this->invoice_cancel_payment_method;
            $document->total = $this->invoice_cancel_total_payment;
            $document->comments = $this->invoice_cancel_document_comments;
            $document->document_type_id = $this->type_id;
            $document->vat = $this->invoice_cancel_cancellation_tax;
            $document->taxable_amount = $this->invoice_cancel_taxable;
            $document->net_value = $this->invoice_cancel_net_value;
            $document->municipal_tax = $this->invoice_cancel_municipal_tax;
            $document->tax = $this->invoice_cancel_document_tax;
            $document->paid = $this->invoice_cancel_is_paid;
            $document->save();

            $doc_info = new DocumentInfo;

            $doc_info->company_id = $this->invoice_cancel_company ? $this->invoice_cancel_company : $this->reservation->company_id;
            $doc_info->booking_agency_id = $this->reservation->booking_agency_id;
            $doc_info->document_id = $document->id;
            $doc_info->guest_id = $this->reservation->guest_id;
            $doc_info->save();

            $fullNoShow = 0;
            if ($this->reservation->arrival_date == $this->reservation->departure_date && $this->reservation->status=='No Show'){
                $fullNoShow = 1;
            }

            if($this->reservation->channex_status == 'cancelled' || $this->reservation->status == 'Cancelled' || $fullNoShow == 1 ){
                Activity::create([
                    'description' => $description,
                    'price' => $this->invoice_cancel_total_payment,
                    'quantity' => $quantity,
                    'date' => $this->invoice_cancel_document_print_date,
                    'vat' => $this->invoice_cancel_cancellation_tax,
                    'reservation_id' => $this->reservation->id,
                    'document_id' => $document->id,
                ]);
            }else {
                
                $checkIn = $this->reservation->actual_checkin;
                $checkOut = $this->reservation->actual_checkout;
                $arrivalDate = $this->reservation->arrival_date;
                $departureDate = $this->reservation->departure_date;
                $rateTypeId = $this->reservation->rate_type_id;
                $rateTypeEarlyCheckOutCharge=$this->reservation->rate_type->early_checkout_charge_percentage / 100; //get cancellation fees charge according to rate type
				$rateTypeNoShowCharge=$this->reservation->rate_type->no_show_charge_percentage / 100;

                $rowRateType = RateType::where("id", $rateTypeId)->first();

                if ($this->values["no_show"]) {
                    $variable1=$arrivalDate;
                    $variable2=$checkIn;
                    $resultDates = DailyRate::where("date", "<", $variable1)->where("reservation_id", $this->reservation->id)->get();
                    $resultDatesCollection = $resultDates;
                    if(sizeof($resultDatesCollection) > 0) {
                        foreach($resultDatesCollection as $row_dates){
                            // price of date in daily rates
                            $dailyPrice='';

                            $dailyPrice=$row_dates['price'] * $rateTypeNoShowCharge;	//get the daily charge of those dates (No SHow) according to rate type
                            //date of price in daily rates
                            $dailyDate = $row_dates['date'];

                            $dates = date('Y-m-d', strtotime($dailyDate));

                            Activity::create([
                                'description' => $description,
                                'price' => $dailyPrice,
                                'quantity' => $quantity,
                                'date' => $dates,
                                'vat' => $this->invoice_cancel_cancellation_tax,
                                'reservation_id' => $this->reservation->id,
                                'document_id' => $document->id,
                            ]);

                        }

                    }
                }

                if (Carbon::parse($checkOut) < Carbon::parse($departureDate)) {
                    $variable1=$checkOut;
                    $variable2=$departureDate;
                    $resultDates = DailyRate::where("date", ">=", $variable1)->where("date", "<", $variable2)->where("reservation_id", $this->reservation->id)->get();
                    $resultDatesCollection = $resultDates;

                    //get rate type to check what to insert in activities									
                    if(sizeof($resultDatesCollection) > 0) {
                        foreach($resultDatesCollection as $row_dates){
                            // price of date in daily rates
                            $dailyPrice='';

                            //get cancellation fees charge according to rate type
                            $dailyPrice=$row_dates['price'] * $rateTypeEarlyCheckOutCharge; //get the daily charge of those dates according to rate type
                            //date of price in daily rates
                            $dailyDate = $row_dates['date'];

                            $dates = date('Y-m-d', strtotime($dailyDate));

                            Activity::create([
                                'description' => $description,
                                'price' => $dailyPrice,
                                'quantity' => $quantity,
                                'date' => $dates,
                                'vat' => $this->invoice_cancel_cancellation_tax,
                                'reservation_id' => $this->reservation->id,
                                'document_id' => $document->id,
                            ]);

                        }
                    }
                }
                
            }

            $doc_type->enumeration = (int)$enumeration + 1;
            $doc_type->save();
            $guest=Guest::where('id', $this->reservation->guest_id)->first();
            $country=Country::where('id', $this->reservation->country_id)->first();

           // send document to oxygen........
           if (getHotelSettings()->oxygen_api_key) {
            $createoxyDoc=create_oxygen_document($document, $this->reservation->guest, $this->reservation->guest->country, $this->reservation, $value, $document);
                    if ($createoxyDoc) {
                        DB::commit();
                        $this->emit('dataSaved', 'Document printed successfully');
                        $this->emit('windowReload');
                    }else{
                        
                        $this->emit('showError', 'An unexpected error has occured. Please try again.');
                        $this->emit('windowReload');
                    }
            }else{
                $pdf = generateTaxDocument($document->id, $this->reservation->id);
                $filename = 'document-' . time() . '.pdf';
                Storage::put('public/invoices/' . $filename, $pdf->output());
                $document->print_path = $filename;
                $document->save();
                DB::commit();
                $this->emit('dataSaved', 'Document printed successfully');

                $pdfContent = $pdf->output();
                $this->emit('windowReload');
                // return response()->streamDownload(
                //     fn() => print($pdfContent),
                //     $this->invoice_cancel_guest_name . ".pdf"
                // );
            
                
            }
            } catch (\Throwable $th) {
                //throw $th;
                $this->emit('error', $th->getMessage());
                DB::rollBack();
            }
            

            

        } elseif ($value == 'receipt_accom') {
           try {
            DB::beginTransaction();
            $doc_type = getHotelSettings()->document_types()->find($this->type_id);
            $enumeration = $doc_type->enumeration;
            $docTypeRow = $doc_type->row;
            $description = 'Accommodation';
            $quantity = 1;
            $document = new Document;
            $document->row = '' . $docTypeRow;
            $document->hotel_settings_id = getHotelSettings()->id;
            $document->enumeration = $enumeration;
            $document->print_date = $this->receipt_document_print_date;
            $document->payment_method_id = $this->receipt_payment_method;
            $document->total = $this->receipt_total_payment;
            $document->comments = $this->receipt_document_comments;
            $document->document_type_id = $this->type_id;
            $document->vat = $this->receipt_vat;
            $document->city_vat = $this->receipt_city_tax;
            $document->taxable_amount = $this->receipt_taxable;
            $document->discount = $this->receipt_discount;
            $document->discount_net_value = $this->receipt_discount_net_value;
            $document->net_value = $this->receipt_net_value;
            $document->municipal_tax = $this->receipt_municipal_tax;
            $document->tax = $this->receipt_document_tax;
            $document->tax_2 = $this->receipt_rate_tax;
            $document->paid = $this->receipt_is_paid;
            $document->save();

            $doc_info = new DocumentInfo;

            $doc_info->company_id = $this->reservation->company_id;
            $doc_info->booking_agency_id = $this->reservation->booking_agency_id;
            $doc_info->document_id = $document->id;
            $doc_info->guest_id = $this->reservation->guest_id;
            $doc_info->save();

            $checkIn = $this->reservation->actual_checkin;
			$checkOut = $this->reservation->actual_checkout;
			$arrivalDate = $this->reservation->arrival_date;
			$departureDate = $this->reservation->departure_date;
			$rateTypeId = $this->reservation->rate_type_id;

            $resultDates = $this->reservation->daily_rates()->where("date", ">=", $checkIn)->where("date", "<", $checkOut);
            //get rate type to check what to insert in activities									
            $rowRateType = RateType::where("id", $rateTypeId)->first();
            if($resultDates) {
                $resultDates = $resultDates->get();
                foreach($resultDates as $row_dates){
                    // price of date in daily rates
                    $dailyPrice = $row_dates['price'];

                    //date of price in daily rates
                    $dailyDate = $row_dates['date'];

                    $dates = date('Y-m-d', strtotime($dailyDate));

                    //name of rate in document
                    $rateName = $rowRateType['description_to_document'];
                    // rate amount to charge
                    $rateAmount = $rowRateType['charge_percentage'];

                    // type of cherge on rate (value or percentage)
                    $rateChargeType = $rowRateType['charge_type'];

                    $amount = '';

                    if ($rateChargeType == 0) // if in %
                    {
                        $amountInDecimal = ($rateAmount / 100); //turn number to  % from 'rate_type_charge_percentage'
                        //Get the result.
                        $amount =  $dailyPrice - ($dailyPrice * $amountInDecimal); // find the number of percentage

                        $dailyPriceFinal = number_format((float)$amount, 2, '.', ''); //subtruct daily price and rate type percentage value to get final daily value
                        $amountFinal =  number_format((float)$dailyPrice - $amount, 2, '.', ''); // for meal


                    } else {
                        $amountFinal = $rateAmount;
                        $dailyPriceFinal = $dailyPrice - $amountFinal;
                    }

                    Activity::create([
                        'description' => $description,
                        'price' => $dailyPriceFinal,
                        'quantity' => $quantity,
                        'date' => $dates,
                        'vat' => $this->receipt_vat,
                        'reservation_id' => $this->reservation->id,
                        'document_id' => $document->id,
                    ]);

                    Activity::create([
                        'description' => $rateName,
                        'price' => $amountFinal,
                        'quantity' => $quantity,
                        'date' => $dates,
                        'vat' => $this->receipt_vat2,
                        'reservation_id' => $this->reservation->id,
                        'document_id' => $document->id,
                    ]);

                }

            }

            $doc_type->enumeration = (int)$enumeration + 1;
            $doc_type->save();

            // create_oxygen_document($document, $this->reservation->guest, $this->reservation->guest->country, $this->reservation);

             // send document to oxygen........
             if (getHotelSettings()->oxygen_api_key) {
                $createoxyDoc=create_oxygen_document($document, $this->reservation->guest, $this->reservation->guest->country, $this->reservation, $value, $document);
                    if ($createoxyDoc) {
                        DB::commit();
                        $this->emit('dataSaved', 'Document printed successfully');
                        $this->emit('windowReload');
                    }else{
                        
                        $this->emit('showError', 'An unexpected error has occured. Please try again.');
                        $this->emit('windowReload');
                    }
            }else{
                $pdf = generateTaxDocument($document->id, $this->reservation->id);
                $filename = 'document-' . time() . '.pdf';
                Storage::put('public/invoices/' . $filename, $pdf->output());
                $document->print_path = $filename;
                $document->save();
                DB::commit();
                $this->emit('dataSaved', 'Document printed successfully');
    
                $pdfContent = $pdf->output();
                $this->emit('windowReload');
                // return response()->streamDownload(
                //     fn() => print($pdfContent),
                //     $this->invoice_cancel_guest_name . ".pdf"
                // );
               
                
            }
           } catch (\Throwable $th) {
            //throw $th;
            $this->emit('error', $th->getMessage());
            DB::rollBack();
           }
           

        } elseif ($value == 'receipt_cancel') {
            try {
                DB::beginTransaction();
                $doc_type = getHotelSettings()->document_types()->find( $this->type_id);
                $enumeration = $doc_type->enumeration;
                $docTypeRow = $doc_type->row;
                $description = 'Cancellation Fees';
                $quantity = 1;
                $document = new Document;
                $document->row = '' . $docTypeRow;
                $document->hotel_settings_id = getHotelSettings()->id;
                $document->enumeration = $enumeration;
                $document->print_date = $this->receipt_cancel_document_print_date;
                $document->payment_method_id = $this->receipt_cancel_payment_method;
                $document->total = $this->receipt_cancel_total_payment;
                $document->comments = $this->receipt_cancel_document_comments;
                $document->document_type_id = $this->type_id;
                $document->vat = $this->receipt_cancel_cancellation_vat;
                $document->taxable_amount = $this->receipt_cancel_taxable;
                $document->net_value = $this->receipt_cancel_net_value;
                $document->municipal_tax = $this->receipt_cancel_municipal_tax;
                $document->tax = $this->receipt_cancel_document_tax;
                $document->paid = $this->receipt_cancel_is_paid;
                $document->save();
    
                $doc_info = new DocumentInfo;
    
                $doc_info->company_id = $this->reservation->company_id;
                $doc_info->booking_agency_id = $this->reservation->booking_agency_id;
                $doc_info->document_id = $document->id;
                $doc_info->guest_id = $this->reservation->guest_id;
                $doc_info->save();
    
                $fullNoShow = 0;
                if ($this->reservation->arrival_date == $this->reservation->departure_date && $this->reservation->status=='No Show'){
                    $fullNoShow = 1;
                }
    
                if($this->reservation->channex_status == 'cancelled' || $this->reservation->status == 'Cancelled' || $fullNoShow == 1 ){
                    Activity::create([
                        'description' => $description,
                        'price' => $this->receipt_cancel_total_payment,
                        'quantity' => $quantity,
                        'date' => $this->receipt_cancel_document_print_date,
                        'vat' => $this->receipt_cancel_cancellation_vat,
                        'reservation_id' => $this->reservation->id,
                        'document_id' => $document->id,
                    ]);
                }else {
    
                    $checkIn = $this->reservation->actual_checkin;
                    $checkOut = $this->reservation->actual_checkout;
                    $arrivalDate = $this->reservation->arrival_date;
                    $departureDate = $this->reservation->departure_date;
                    $rateTypeId = $this->reservation->rate_type_id;
                    $rateTypeEarlyCheckOutCharge=$this->reservation->rate_type->early_checkout_charge_percentage / 100; //get cancellation fees charge according to rate type
                    $rateTypeNoShowCharge=$this->reservation->rate_type->no_show_charge_percentage / 100;
    
                    $rowRateType = RateType::where("id", $rateTypeId)->first();
    
                    if ($this->values["no_show"]) {
                        $variable1=$arrivalDate;
                        $variable2=$checkIn;
                        $resultDates = DailyRate::where("date", "<", $variable1)->where("reservation_id", $this->reservation->id)->get();
                        $resultDatesCollection = $resultDates;
                        if(sizeof($resultDatesCollection) > 0) {
                            foreach($resultDatesCollection as $row_dates){
                                // price of date in daily rates
                                $dailyPrice='';
    
                                $dailyPrice=$row_dates['price'] * $rateTypeNoShowCharge;	//get the daily charge of those dates (No SHow) according to rate type
                                //date of price in daily rates
                                $dailyDate = $row_dates['date'];
    
                                $dates = date('Y-m-d', strtotime($dailyDate));
    
                                Activity::create([
                                    'description' => $description,
                                    'price' => $dailyPrice,
                                    'quantity' => $quantity,
                                    'date' => $dates,
                                    'vat' => $this->receipt_cancel_cancellation_vat,
                                    'reservation_id' => $this->reservation->id,
                                    'document_id' => $document->id,
                                ]);
    
                            }
                        }
                    }
    
                    if (Carbon::parse($checkOut) < Carbon::parse($departureDate)) {
                        $variable1=$checkOut;
                        $variable2=$departureDate;
                        $resultDates = DailyRate::where("date", ">=", $variable1)->where("date", "<", $variable2)->where("reservation_id", $this->reservation->id)->get();
                        $resultDatesCollection = $resultDates;
    
                        //get rate type to check what to insert in activities									
                        if(sizeof($resultDatesCollection) > 0) {
                            foreach($resultDatesCollection as $row_dates){
                                // price of date in daily rates
                                $dailyPrice='';
    
                                //get cancellation fees charge according to rate type
                                $dailyPrice=$row_dates['price'] * $rateTypeEarlyCheckOutCharge; //get the daily charge of those dates according to rate type
                                //date of price in daily rates
                                $dailyDate = $row_dates['date'];
    
                                $dates = date('Y-m-d', strtotime($dailyDate));
    
                                Activity::create([
                                    'description' => $description,
                                    'price' => $dailyPrice,
                                    'quantity' => $quantity,
                                    'date' => $dates,
                                    'vat' => $this->receipt_cancel_cancellation_vat,
                                    'reservation_id' => $this->reservation->id,
                                    'document_id' => $document->id,
                                ]);
    
                            }
                        }
                    }
    
                }
    
                $doc_type->enumeration = (int)$enumeration + 1;
                $doc_type->save();
    
                 // send document to oxygen........
                 if (getHotelSettings()->oxygen_api_key) {
                    $createoxyDoc=create_oxygen_document($document, $this->reservation->guest, $this->reservation->guest->country, $this->reservation, $value, $document);
                    if ($createoxyDoc) {
                        DB::commit();
                        $this->emit('dataSaved', 'Document printed successfully');
                        $this->emit('windowReload');
                    }else{
                        
                        $this->emit('showError', 'An unexpected error has occured. Please try again.');
                        $this->emit('windowReload');
                    }
                    
                }else{
                    $pdf = generateTaxDocument($document->id, $this->reservation->id);
                    $filename = 'document-' . time() . '.pdf';
                    Storage::put('public/invoices/' . $filename, $pdf->output());
                    $document->print_path = $filename;
                    $document->save();
                    DB::commit();
                    $this->emit('dataSaved', 'Document printed successfully');
        
                    $pdfContent = $pdf->output();
                    $this->emit('windowReload');
                    // return response()->streamDownload(
                    //     fn() => print($pdfContent),
                    //     $this->invoice_cancel_guest_name . ".pdf"
                    // );
                   
                    
                }
            } catch (\Throwable $th) {
                //throw $th;
                $this->emit('error', $th->getMessage());
                DB::rollBack();
            }
           

        } else if ($value == 'invoice_accom') {
            if ($this->type_id==4) {
                $validator = FacadesValidator::make($this->getDataForValidation($this->invoiceAccomRules()), $this->invoiceAccomRules());

                if($validator->fails()) {
                    $this->emit("loading", false);
                }
                $this->validate($this->invoiceAccomRules());
            }else{
            
            $validator = FacadesValidator::make($this->getDataForValidation($this->receiptAccomRules()), $this->receiptAccomRules());

            if($validator->fails()) {
                $this->emit("loading", false);
            }
            $this->validate($this->receiptAccomRules());
            }
            DB::beginTransaction();
            try {
                $doc_type = getHotelSettings()->document_types()->find($this->type_id);
                $enumeration = $doc_type->enumeration;
                $docTypeRow = $doc_type->row;
                $description = 'Accommodation';
                $quantity = 1;
                $document = new Document;
                $document->row = '' . $docTypeRow;
                $document->hotel_settings_id = getHotelSettings()->id;
                $document->enumeration = $enumeration;
                $document->print_date = $this->invoice_document_print_date;
                $document->payment_method_id = $this->invoice_payment_method;
                $document->total = $this->invoice_total_payment;
                $document->comments = $this->invoice_document_comments;
                $document->document_type_id = $this->type_id;
                $document->vat = $this->invoice_vat;
                $document->city_vat = $this->invoice_city_tax;
                $document->taxable_amount = $this->invoice_taxable;
                $document->discount = $this->invoice_discount;
                $document->discount_net_value = $this->invoice_discount_net_value;
                $document->net_value = $this->invoice_net_value;
                $document->municipal_tax = $this->invoice_municipal_tax;
                $document->tax = $this->invoice_document_tax;
                $document->tax_2 = $this->invoice_rate_tax;
                $document->paid = $this->invoice_is_paid;
                $document->save();

                $doc_info = new DocumentInfo;

                $doc_info->company_id = $this->invoice_company ? $this->invoice_company : $this->reservation->company_id;
                $doc_info->booking_agency_id = $this->reservation->booking_agency_id;
                $doc_info->document_id = $document->id;
                $doc_info->guest_id = $this->reservation->guest_id;
                $doc_info->save();

                $checkIn = $this->reservation->actual_checkin;
                $checkOut = $this->reservation->actual_checkout;
                $arrivalDate = $this->reservation->arrival_date;
                $departureDate = $this->reservation->departure_date;
                $rateTypeId = $this->reservation->rate_type_id;

                
                $resultDates = $this->reservation->daily_rates()->whereBetween("date", [$arrivalDate, $departureDate]);
                //get rate type to check what to insert in activities									
                $rowRateType = RateType::where("id", $rateTypeId)->first();
                if($resultDates) {
                    $resultDates = $resultDates->get();
                    foreach($resultDates as $row_dates){
                        // price of date in daily rates
                        $dailyPrice = $row_dates['price'];

                        //date of price in daily rates
                        $dailyDate = $row_dates['date'];

                        $dates = date('Y-m-d', strtotime($dailyDate));

                        //name of rate in document
                        $rateName = $rowRateType['description_to_document'];
                        // rate amount to charge
                        $rateAmount = $rowRateType['charge_percentage'];

                        // type of cherge on rate (value or percentage)
                        $rateChargeType = $rowRateType['charge_type'];

                        $amount = '';

                        if ($rateChargeType == 0) // if in %
                        {
                            $amountInDecimal = ($rateAmount / 100); //turn number to  % from 'rate_type_charge_percentage'
                            //Get the result.
                            $amount =  $dailyPrice - ($dailyPrice * $amountInDecimal); // find the number of percentage

                            $dailyPriceFinal = number_format((float)$amount, 2, '.', ''); //subtruct daily price and rate type percentage value to get final daily value
                            $amountFinal =  number_format(((float)$dailyPrice - (float)$amount), 2, '.', ''); // for meal


                        } else {
                            $amountFinal = $rateAmount;
                            $dailyPriceFinal = $dailyPrice - $amountFinal;
                        }

                        Activity::create([
                            'description' => $description,
                            'price' => $dailyPriceFinal,
                            'quantity' => $quantity,
                            'date' => $dates,
                            'vat' => $this->invoice_vat,
                            'reservation_id' => $this->reservation->id,
                            'document_id' => $document->id,
                        ]);

                        Activity::create([
                            'description' => $rateName,
                            'price' => $amountFinal,
                            'quantity' => $quantity,
                            'date' => $dates,
                            'vat' => $this->invoice_vat2,
                            'reservation_id' => $this->reservation->id,
                            'document_id' => $document->id,
                        ]);

                    }

                }

                $doc_type->enumeration = (int)$enumeration + 1;
                $doc_type->save();

                // send document to oxygen........
                if (getHotelSettings()->oxygen_api_key) {
                    $createoxyDoc=create_oxygen_document($document, $this->reservation->guest, $this->reservation->guest->country, $this->reservation, $value, $document);
                    if ($createoxyDoc) {
                        // DB::commit();
                        $this->emit('dataSaved', 'Document printed successfully');
                        $this->emit('windowReload');
                    }else{
                        
                        $this->emit('showError', 'An unexpected error has occured. Please try again.');
                        $this->emit('windowReload');
                    }
                    
                    
                    
                }else{
                    $pdf = generateTaxDocument($document->id, $this->reservation->id);
                    $filename = 'document-' . time() . '.pdf';
                    Storage::put('public/invoices/' . $filename, $pdf->output());
                    $document->print_path = $filename;
                    $document->save();
                    
                    $this->emit('dataSaved', 'Document printed successfully');
        
                    $pdfContent = $pdf->output();
                    $this->emit('windowReload');
                    // return response()->streamDownload(
                    //     fn() => print($pdfContent),
                    //     $this->invoice_cancel_guest_name . ".pdf"
                    // );
                   
                    
                }
               
            } catch (\Throwable $th) {
                //throw $th;
                $this->emit('error', $th->getMessage());
                DB::rollBack();
            }
            DB::commit();
            


        }
    }

    /* for overnight */
    public function setActive($value)
    {
        $max_payment_method = $this->reservation->guest_overnight_tax_payments()->orderBy('value', 'desc')->first()->payment_method_id ?? $this->reservation->payment_method_id;
        if ($value == 'overnight') {
            $document_type = getHotelSettings()->document_types()->where("type", 3)->first();
            $actual_checkin = $this->reservation->actual_checkin ?? today()->toDateString();
            $actual_checkout = $this->reservation->actual_checkout ?? today()->toDateString();
            $overnight_tax = getHotelSettings()->overnight_tax->tax;
            $getmarkid=Activity::join('documents', 'activities.document_id', '=', 'documents.id')->where('reservation_id', $this->reservation->id)->where('description', 'Accommodation')->first();
            $this->type_id = $document_type->id ?? 0;
            $this->type_name = $document_type->name ?? 0;
            $this->guest = $this->reservation->guest->full_name;
            $this->payment_method_id = $max_payment_method ?? 1;
            $this->mark_id=$getmarkid->mark_id;
            $this->paid = 1;
            $this->print_date = today()->toDateString();
            $this->check_in = $actual_checkin;
            $this->check_out = $actual_checkout;
            $this->vat = 0;
            $this->overnight_tax = $overnight_tax;
            $this->overnight_tax_paid = Carbon::parse($actual_checkout)->diffInDays(Carbon::parse($actual_checkin)) * $overnight_tax;;
            $this->comments = '';
        }
    }

    public function setAccomPayment()
    {
        $this->accom_value = $this->values['accom_charge'];
        $this->accom_payment_date = today()->toDateString();
        $this->accom_is_deposit = 0;
        $this->accom_payment_method = '';
        $this->accom_comment = '';
    }

    public function setServicePayment($receipt)
    {
        $this->service_value = $this->values['extras_charge'];
        $this->service_payment_date = today()->toDateString();
        $this->service_receipt_number = $receipt;
        $this->service_payment_method = '';
        $this->service_comment = '';
    }

    public function setOvernightPayment()
    {
        $this->overnight_value = $this->values['overnight_charge'];
        $this->overnight_payment_date = today()->toDateString();
        $this->overnight_payment_method = '';
        $this->overnight_comment = '';
    }

    public function companyChanged($type) {
        // dd($type);
        if($type == "invoice_company") {
            $company_id = $this->invoice_company;
            $company = $this->companies->first(fn($v) => $v->id == $company_id);
            // dd($company);
            if($company) {
                $this->invoice_agency_name = $company->name;
                $this->invoice_agency_activity = $company->activity;
                $this->invoice_agency_address = $company->address;
                $this->invoice_agency_tax_id = $company->vat_number;
                $this->invoice_agency_tax_office = $company->tax_office;
                $this->invoice_agency_postal = $company->postal_code;
                $this->invoice_agency_phone = $company->phone_number;
            } else {
                $this->invoice_agency_name = $this->reservation->booking_agency->name ?? "";
                $this->invoice_agency_activity = $this->reservation->booking_agency->activity ?? "";
                $this->invoice_agency_address = $this->reservation->booking_agency->address ?? "";
                $this->invoice_agency_tax_id = $this->reservation->booking_agency->vat_number ?? "";
                $this->invoice_agency_postal = $this->reservation->booking_agency->postal_code ?? "";
                $this->invoice_agency_phone = $this->reservation->booking_agency->phone_number ?? "";
            }
        }
        else if($type == "invoice_cancel_company") {
            $company_id = $this->invoice_cancel_company;
            $company = $this->companies->first(fn($v) => $v->id == $company_id);
            if($company) {
                $this->invoice_cancel_agency_name = $company->name;
                $this->invoice_cancel_agency_activity = $company->activity;
                $this->invoice_cancel_agency_address = $company->address;
                $this->invoice_cancel_agency_tax_id = $company->vat_number;
                $this->invoice_cancel_agency_tax_office = $company->tax_office;
                $this->invoice_cancel_agency_postal = $company->postal_code;
                $this->invoice_cancel_agency_phone = $company->phone_number;
            } else {
                $this->invoice_cancel_agency_name = $this->reservation->booking_agency->name ?? "";
                $this->invoice_cancel_agency_activity = $this->reservation->booking_agency->activity ?? "";
                $this->invoice_cancel_agency_address = $this->reservation->booking_agency->address ?? "";
                $this->invoice_cancel_agency_tax_id = $this->reservation->booking_agency->vat_number ?? "";
                $this->invoice_cancel_agency_tax_office = $this->reservation->booking_agency->tax_office ?? "";
                $this->invoice_cancel_agency_postal = $this->reservation->booking_agency->postal_code ?? "";
                $this->invoice_cancel_agency_phone = $this->reservation->booking_agency->phone_number ?? "";
            }
        }
    }

}

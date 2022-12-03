<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\CashRegister;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\GuestAccommodationPayment;
use App\Models\GuestExtrasPayment;
use App\Models\GuestOvernightTaxPayment;
use App\Models\OpexData;
use App\Models\PaymentMethod;
use App\Models\Reservation;
use App\Models\HotelSetting;
use App\Models\Supplier;
use App\Services\OxygenService;
use App\Models\Company;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use stdClass;

class FinanceController extends Controller
{

    public function test(){
        $service = new OxygenService;
        $tax = [
            'name' => 'B',
            'document_type' =>'pistotiko',
            'title'=>'sequence',
            'is_draft'=>true

        ];
        $res = $service->createNumberingSequence($tax);
        dd($res);
    }

    public function test2(){
        $service = new OxygenService;
        $res = $service->getNumberingSequences();
        dd($res->body());
    }

    public function test3(){
        // $service = new OxygenService;
        // $res = $service->getNumberingSequences();
        $pciUrl=config('services.channex.pci_base').'/capture?api_key='.config('services.channex.pci_api_key').'&method=get&profile=channex&url=https://secure-staging.channex.io/api/v1/booking_revisions/feed';
        try {
            $client=new Client();
            $response=$client->post($pciUrl, ['headers'=>['user-api-key' => config('services.channex.api_key')]]);
            $response=json_decode($response->getBody(), true);
            dd($response);
            // return $response;
        }catch (\Throwable $th) {
            echo $th->getMessage();
        }
        
    }
   
    public function receiptList(Request $request)
    {
        $documents = Document::with('activities')->where('hotel_settings_id',getHotelSettings()->id)->whereHas("document_type", function($q) {
            $q->where('type', 5);
        });
        if (isset($request->from_date)) {
            $documents = $documents->whereDate('print_date', '>=', $request->from_date);
        }
        if (isset($request->to_date)) {
            $documents = $documents->whereDate('print_date', '<=', $request->to_date);
        }
        return view('front.Finance.Tax.receipt_list')->with([
            'documents' => $documents->get(),
        ]);
    }

    public function invoiceList(Request $request)
    {
        $documents = Document::query()->with('activities')->where('hotel_settings_id',getHotelSettings()->id)->whereHas("document_type", function($q) {
            $q->where('type', 4);
        });
        if (isset($request->from_date)) {
            $documents = $documents->whereDate('print_date', '>=', $request->from_date);
        }
        if (isset($request->to_date)) {
            $documents = $documents->whereDate('print_date', '<=', $request->to_date);
        }
        return view('front.Finance.Tax.invoice_list')->with([
            'documents' => $documents->get(),
        ]);
    }

    public function cancellationList(Request $request)
    {
        $documents = Document::query()->with('activities')->where('hotel_settings_id',getHotelSettings()->id)->whereHas("document_type", function($q) {
            $q->whereIn('type', [1, 4]);
        })->whereHas('activities', fn($q) => $q->where('description', 'Cancellation Fees'));
        if (isset($request->from_date)) {
            $documents = $documents->whereDate('print_date', '>=', $request->from_date);
        }
        if (isset($request->to_date)) {
            $documents = $documents->whereDate('print_date', '<=', $request->to_date);
        }
        return view('front.Finance.Tax.cancellation_list')->with([
            'documents' => $documents->get(),
        ]);
    }

    public function creditNoteList(Request $request)
    {
        $documents = Document::query()->where('hotel_settings_id',getHotelSettings()->id)->whereHas("document_type", function($q) {
            $q->where('type', 6);
        });
        if (isset($request->from_date)) {
            $documents = $documents->whereDate('print_date', '>=', $request->from_date);
        }
        if (isset($request->to_date)) {
            $documents = $documents->whereDate('print_date', '<=', $request->to_date);
        }
        return view('front.Finance.Tax.credit_note_list')->with([
            'documents' => $documents->get(),
        ]);
    }

    public function specialAnnullingList(Request $request)
    {
        $documents = Document::query()->where('hotel_settings_id',getHotelSettings()->id)->whereHas("document_type", function($q) {
            $q->where('type', 2);
        });
        if (isset($request->from_date)) {
            $documents = $documents->whereDate('print_date', '>=', $request->from_date);
        }
        if (isset($request->to_date)) {
            $documents = $documents->whereDate('print_date', '<=', $request->to_date);
        }
        return view('front.Finance.Tax.annulling_document')->with([
            'documents' => $documents->get(),
        ]);
    }

    public function overnightsList(Request $request)
    {
        $documents = Document::query()->where('hotel_settings_id',getHotelSettings()->id)->whereHas("document_type", function($q) {
            $q->where('type', 3);
        });
        if (isset($request->from_date)) {
            $documents = $documents->whereDate('print_date', '>=', $request->from_date);
        }
        if (isset($request->to_date)) {
            $documents = $documents->whereDate('print_date', '<=', $request->to_date);
        }
        return view('front.Finance.Tax.overnight_tax_list')->with([
            'documents' => $documents->get(),
        ]);
    }

    public function createRefund(Request $request){
        DB::beginTransaction();
        try {
           
                $hotelSetting=getHotelSettings();
                $docInfo=Document::find($request->document_id);
                $newDoc = $docInfo->replicate();
                $doc_type = DocumentType::find($docInfo->document_type_id);
                $reservation=Reservation::find($docInfo->activities->first()->reservation_id);
                $documentTotal=$docInfo->total;
                $refundTotal=(float)$documentTotal-(float)$reservation->discount;
                $overnights=$reservation->overnights;
                $rateplanChargePercentage=$reservation->rate_type->charge_percentage/100;
                $chargeType=$reservation->rate_type->charge_type;
                $rateCategoryVat=$reservation->rate_type->rate_type_category->vat;
                $rateCategoryVatPercent=1.0+($rateCategoryVat/100);
                $vatt=1.00+($hotelSetting->vat_tax->vat_option->value/100);
                $cityTax=1.0+($hotelSetting->city_tax/100);
                $reservDiscountTotal=$documentTotal-$reservation->discount;
                if ($chargeType==0) {
                    $rateTotal=$reservDiscountTotal*$rateplanChargePercentage;
                }else{
                    $rateTotal=$rateplanChargePercentage*$overnights;
                }

                $reservAccommodationTotal=$documentTotal-$rateTotal;
                $discountAccomTotal=$reservDiscountTotal-$rateTotal;
                $taxBeforeDiscount=number_format((float)$reservAccommodationTotal-($reservAccommodationTotal/$vatt), 2, '.', '');
                $rateTaxAmount=number_format((float)$rateTotal-($rateTotal/$rateCategoryVatPercent), 2, '.', '');
                $tax=number_format((float)$discountAccomTotal-($discountAccomTotal/$vatt), 2, '.', '');
                if ($docInfo->tax_2==0) {
                    $netValue=$documentTotal-$taxBeforeDiscount-$rateTaxAmount;
                    $discountNetValue=number_format((float)$reservDiscountTotal/$vatt, 2, '.', '');
                    $documentTax=$tax+$rateTaxAmount;
                    $rateTax='';
                    $vatSum=$documentTax;
                }else{
                    $accomPercentage=$documentTotal*(1-$rateplanChargePercentage);
                    $ratePercentage=$documentTotal*$rateplanChargePercentage;
                    $accomNetValue=$accomPercentage*$vatt;
                    $rateNetValue=$ratePercentage*$rateCategoryVatPercent;
                    $discountAccomPercentage=$reservDiscountTotal*(1-$rateplanChargePercentage);
                    $discountRatePercentage=$reservDiscountTotal*$rateplanChargePercentage;
                    $taxBeforeDiscount=number_format((float)$accomPercentage-($accomPercentage/$vatt), 2, '.', '');
                    $rateTAxBeforeDiscount=number_format((float)$ratePercentage-($ratePercentage/$rateCategoryVatPercent), 2, '.', '');
                    $vatSumBd=$taxBeforeDiscount+$rateTAxBeforeDiscount;
                    $documentTax=$tax;
                    $rateTax=$rateTaxAmount;
                    $vatSum=$documentTax+$rateTax;
                    $netValue=$documentTotal-$vatSumBd;
                    $discountNetValue=$reservDiscountTotal-$vatSum;

                }
                $municipalTax=number_format((float)$discountNetValue-($discountNetValue/$cityTax), 2, '.', '');
                $accommodationTaxable=$discountNetValue-$municipalTax;

                $newDoc->total=$refundTotal;
                $newDoc->taxable_amount=$accommodationTaxable;
                $newDoc->discount=$reservation->discount;
                $newDoc->discount_net_value=$discountNetValue;
                $newDoc->net_value=$netValue;
                $newDoc->municipal_tax=$municipalTax;
                $newDoc->tax=$documentTax;
                $newDoc->tax_2=$rateTax;
                $newDoc->vat=$hotelSetting->vat_tax->vat_option->value;
                $newDoc->city_vat=$hotelSetting->city_tax;
                $newDoc->save();

                $doc_info = $docInfo->document_info;
                $new_doc_info = $doc_info->replicate();
                $new_doc_info->document_id = $newDoc->id;
                $new_doc_info->save();

                $activities = $docInfo->activities;
                foreach ($activities as $activity) {

                    $new_activity = $activity->replicate();
                    $new_activity->document_id = $newDoc->id;
                    $new_activity->save();
                }
                $doc_type->enumeration = (int)$doc_type->enumeration + 1;
                $doc_type->save();
                $typevalue='receipt_invoice';
                
                if (getHotelSettings()->oxygen_api_key) {
                    $createoxyDoc=create_oxygen_document($newDoc, $reservation->guest, $reservation->guest->country, $reservation, $typevalue, $docInfo);
                        if ($createoxyDoc) {
                            DB::commit();
                        }else{
                            $error=2;

                        }
                }else{
                    $pdf = generateTaxDocument($newDoc->id, $docInfo->activities->first()->reservation_id);
                    $filename = 'document-' . time() . '.pdf';
                    Storage::disk('public')->put('invoices/'.$filename, $pdf->output());
                    $newDoc->print_path = $filename;
                    $newDoc->save();
                    DB::commit();
                }
            
            return back()->with('success', "Document saved successfully");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
       
    }

   

    public function addSpecialAnnulling(Request $request)
    {
        DB::beginTransaction();
        try {
            $error=0;
            
                $doc = Document::find($request->document_id);
                $reservation=Reservation::find($doc->activities->first()->reservation_id);
                if ($reservation->reservation_amount<$request->discount) {
                   $error=1; 
                }else{
                    $error=0;
                $reservation->discount=$request->discount;
                $reservation->save();
                $newDoc = $doc->replicate();
                $doc_type = DocumentType::find(2);
                $enumeration = $doc_type->enumeration;
                $docTypeRow = $doc_type->row;
                $newDoc->enumeration = $enumeration;
                $newDoc->row = $docTypeRow;
                $newDoc->document_type_id = 2;
                $newDoc->print_date = today()->toDateString();
                $newDoc->save();

                $doc_info = $doc->document_info;
                $new_doc_info = $doc_info->replicate();
                $new_doc_info->document_id = $newDoc->id;
                $new_doc_info->save();

                $activities = $doc->activities;
                
                foreach ($activities as $activity) {

                    $new_activity = $activity->replicate();
                    $new_activity->document_id = $newDoc->id;
                    $docRowNumber = $doc->row . ' ' . $doc->enumeration;
                    $text = 'Ακύρωση απόδειξης Παροχής Υπηρεσιών';
                    $new_activity->description = $text . ' ' . $docRowNumber;
                    $new_activity->save();
                }
                
                $doc_type->enumeration = (int)$doc_type->enumeration + 1;
                $doc_type->save();
                $typevalue='receipt_invoice';

                if (getHotelSettings()->oxygen_api_key) {
                    $createoxyDoc=create_oxygen_document($newDoc, $reservation->guest, $reservation->guest->country, $reservation, $typevalue, $doc);
                        if ($createoxyDoc) {
                            DB::commit();
                        }else{
                            $error=2;

                        }
                    
                }else{
                    $pdf = generateTaxDocument($newDoc->id, $doc->activities->first()->reservation_id);
                    $filename = 'document-' . time() . '.pdf';
                    Storage::disk('public')->put('invoices/'.$filename, $pdf->output());
                    $newDoc->print_path = $filename;
                    $newDoc->save();
                    DB::commit();
                }
               }
          
            if ($error==1) {
                return back()->with('error', "Discount can not be greater than reservation amount");
            }else{
                return redirect(route('special-annulling-documents'))
            ->with('success', 'Special Annulling saved successfully');
            }
            
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
       
    }
    public function addCreditNote(Request $request)
    {
        DB::beginTransaction();
        try {
            $error=0;
            
            // DB::transaction(function () use ($request, &$error) {
                $doc = Document::find($request->document_id);
                $documentTotal=$doc->total;
                $reservation=Reservation::where('id', $doc->activities->first()->reservation_id)->first();
                if ($reservation->reservation_amount<$request->discount) {
                    $error=1; 
                 }else{
                    $error=0;
                    $newDoc = $doc->replicate();
                    $doc_type = DocumentType::find(6);
                    $hotelSetting=getHotelSettings();
                    $enumeration = $doc_type->enumeration;
                    $docTypeRow = $doc_type->row;
                    $newDoc->enumeration = $enumeration;
                    $newDoc->row = $docTypeRow;
                    $newDoc->document_type_id = 6;
                    $newDoc->discount=0;
                    $newDoc->mark_id='';
                    $newDoc->print_date = today()->toDateString();
                    $newDoc->vat=$hotelSetting->vat_tax->vat_option->value;
                    $newDoc->city_vat=$hotelSetting->city_tax;
                    $newDoc->save();

                    $repayableAmmount=$request->discount;
                    $vatt=1.00+($hotelSetting->vat_tax->vat_option->value/100);
                    $cityTax=1.0+($hotelSetting->city_tax/100);
                    $overnightTax=$hotelSetting->overnight_tax->tax;
                    $creditNoteTotal=0;
                    if ($documentTotal>$repayableAmmount) {
                        $creditNoteTotal=$repayableAmmount;
                    }
                    else if ($documentTotal==$repayableAmmount) {
                        $creditNoteTotal=$documentTotal;
                    }else{}

                    $overnights=$reservation->overnights;
                    $rateplanChargePercentage=$reservation->rate_type->charge_percentage;
                    $chargeType=$reservation->rate_type->charge_type;
                    $rateCategoryVat=$reservation->rate_type->rate_type_category->vat;
                    $rateCategoryVatPercent=1.0+($rateCategoryVat/100);
                    if ($chargeType==1) {
                        $percent=$rateplanChargePercentage*$overnights;
                        $repayableAmmount=$repayableAmmount-$percent;
                    }else{
                        $percent=($rateplanChargePercentage*$repayableAmmount)/100;
                        $repayableAmmount=$repayableAmmount-$percent;
                    }

                    if ($creditNoteTotal==$documentTotal) {
                        $documentTax=$doc->tax;
                        $rateTax=$doc->tax_2;
                        $municipalTax=$doc->municipal_tax;
                        $netValue=$doc->net_value;
                        $taxable=$doc->taxable_amount;
                        $discountNetValue=$netValue;
                    }else{
                        $taxable=number_format((float)$creditNoteTotal/$vatt, 2, '.', '');
                        $tax=number_format((float)$repayableAmmount-($repayableAmmount/$vatt), 2, '.', '');
                        $rateTaxAmount=number_format((float)$percent-($percent/$rateCategoryVatPercent), 2, '.', '');
                        $vatSum=0;
                        if ($rateCategoryVat==$hotelSetting->vat) {
                            $documentTax=$tax+$rateTaxAmount;
                            $rateTax='';
                            $vatSum=$documentTax;
                        }else{
                            $documentTax=$tax;
                            $rateTax=$rateTaxAmount;
                            $vatSum=$documentTax+$rateTax;
                        }

                        $netValue=number_format((float)$creditNoteTotal-$vatSum, 2, '.', '') ;
                        $discountNetValue=$netValue;
                        $municipalTax=number_format((float)($netValue-(($creditNoteTotal-$vatSum)/$cityTax)), 2, '.', '');
                        $accommodationTaxable=number_format((float)$creditNoteTotal-$vatSum-$municipalTax, 2, '.', '');


                    }
                    
                    
                    $newDoc->total=$creditNoteTotal;
                    $newDoc->taxable_amount=$taxable;
                    $newDoc->net_value=$netValue;
                    $newDoc->discount_net_value=$discountNetValue;
                    $newDoc->municipal_tax=$municipalTax;
                    $newDoc->tax=$documentTax;
                    $newDoc->tax_2=$rateTax;
                    $newDoc->save();
                    
                    $doc_info = $doc->document_info;
                    $new_doc_info = $doc_info->replicate();
                    $new_doc_info->document_id = $newDoc->id;
                    $new_doc_info->save();

                    $new_activity = new Activity();
                    $new_activity->document_id = $newDoc->id;
                    $new_activity->description = 'Accommodation';
                    $new_activity->quantity = 1;
                    $new_activity->price = $repayableAmmount;
                    $new_activity->vat = $hotelSetting->vat_tax->vat_option->value;
                    $new_activity->reservation_id=$reservation->id;
                    $new_activity->date = today()->toDateString();
                    $new_activity->save();

                    $new_activity = new Activity();
                    $new_activity->document_id = $newDoc->id;
                    $new_activity->description = $reservation->rate_type->name;;
                    $new_activity->quantity = 1;
                    $new_activity->price = $percent;
                    $new_activity->vat = $rateCategoryVat;
                    $new_activity->reservation_id=$reservation->id;
                    $new_activity->date = today()->toDateString();
                    $new_activity->save();

                    $typevalue='credit_invoice';
                    $doc_type->enumeration = (int)$doc_type->enumeration + 1;
                    $doc_type->save();
                    if (getHotelSettings()->oxygen_api_key) {
                        $createoxyDoc=create_oxygen_document($newDoc, $reservation->guest, $reservation->guest->country, $reservation, $typevalue, $doc);
                        if ($createoxyDoc) {
                            DB::commit();
                        }else{
                            $error=2;

                        }
                        
                    }else{
                        $pdf = generateTaxDocument($newDoc->id, $doc->activities->first()->reservation_id);
                        $filename = 'document-' . time() . '.pdf';
                        Storage::disk('public')->put('invoices/'.$filename, $pdf->output());
                        $newDoc->print_path = $filename;
                        $newDoc->save();
                        DB::commit();
                    }
              }
            // }
            // );
            if ($error==1) {
                return back()->with('error', "Refund can not be greater than reservation amount");
            }else if ($error==2) {
                return back()->with('error', "An unexpected error has occured. Please try again.");
            }else{
                return back()->with('success', "Document saved successfully");
            }
            
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
       
    }

    public function opexForm(Request $request)
    {
        return view('front.Finance.opex.opex_form');
    }

    public function opexList(Request $request)
    {
        $opexes = getHotelSettings()->opex_data();
        if (isset($request->from_date)) {
            $opexes = $opexes->whereDate('date', '>=', $request->from_date);
        }
        if (isset($request->to_date)) {
            $opexes = $opexes->whereDate('date', '<=', $request->to_date);
        }
        $opexes = $opexes->get();
        return view('front.Finance.opex.opex_list')->with([
            'opexes' => $opexes,
            'file' => $opexes->last()->file ?? '',
        ]);
    }

    public function createSupplier(Request $request)
    {
        return view('front.Finance.opex.supplier_create')->with([
            'suppliers' => getHotelSettings()->supplier(),
        ]);
    }

    public function postOpex(Request $request)
    {

        $data = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment' => 'required',
            'bill_file' => 'required_unless:payment,"Debtor"|mimes:pdf,jpg,jpeg|max:5000',
        ]);
        if (isset($request->bill_file)) {
            $file = $request->file('bill_file');
            $filename = 'opex_form-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads', $filename, 'public');
        }
        OpexData::whereId($request->opex_id)->update([
            'amount' => $data['amount'],
            'payment' => $data['payment'],
            'bill_no' => $filename ?? '',
        ]);
        return back()->withSuccess('Opex updated successfully');
    }

    public function dailyCashier(Request $request)
    {
        $date = today()->toDateString();
        if (isset($request->date)) {
            $date = $request->date;
        }
        if (isset($request->cash)) {
            //update or create
            CashRegister::updateOrCreate(
                [
                    'hotel_settings_id' => getHotelSettings()->id,
                    'date' => $date,
                    'reg_cash' => $request->cash,
                    'status' => 'open',
                ]
            );
        }
        $closeDates = getHotelSettings()->cash_registers()->where('status', 'close')->get()->pluck('date')->toArray();
        $notClosedDates = getHotelSettings()->cash_registers()->where('status', 'open')->get()->pluck('date')->toArray();
        return view('front.Finance.daily_cashier')->with([
            'register' => getHotelSettings()->cash_registers()->whereDate('date', $date)->first(),
            'date' => $date,
            'closeDates' => $closeDates,
            'notClosedDates' => $notClosedDates,
        ]);
    }

    public function paymentTracker(Request $request)
    {
        return view('front.Finance.payment_tracker');
    }

    public function paymentStore(Request $request)
    {
        $balance=$request->balance;
        $reservation=$request->reservation_id;
        $selectedDate=$request->payment_date;
        $depositType=$request->deposit_type;
        $payment=$request->payment_ammount;
        $payment_method=$request->payment_method;
        $payment_comments=$request->payment_comments;

        if (empty($selectedDate) || empty($payment) || empty($payment_method)) {
            return back()->withError('To make payment, fill all required fields');
        }else if ($payment>$balance) {
            return back()->withError('Guest balance is less than given amount');
        }elseif ($balance==0) {
            return back()->withError('Guest balance is zero. You can not charge anymore.');
        }else{
            $guestPayment=new GuestAccommodationPayment();
            $guestPayment->value=$payment;
            $guestPayment->date=$selectedDate;
            $guestPayment->payment_method_id=$payment_method;
            $guestPayment->transaction_id=$payment_comments;
            $guestPayment->reservation_id=$reservation;
            $guestPayment->deposit_type_id=$depositType;
            $guestPayment->is_deposit=1;
            $guestPayment->save();
            return back()->withSuccess('Payment inserted successfully');
        }
    }

    public function get_currency(Request $request)
    {
        $settings = getHotelSettings();
        $settings->load(['currency']);
        $cinitial = $settings->currency->initials;
        $cisymbol = $settings->currency->symbol;

        if ($request->valueforformatcurrency != null) {
            $thisvalue = $request->valueforformatcurrency;
            $formated = number_format($thisvalue, 2, ',', '.') . ' ' . $cisymbol;
            header('Content-Type: application/json');
            echo ($formated);
        } else {

            // $cinitial="TRY";
            // $cisymbol="₺";
            //echo '3443'.$cisymbol;
            if ($cinitial == 'EUR') {
                //echo 'we are in euro greek';
                function formatecurrency($thisvalue)
                {
                    // $cisymboll = $GLOBALS['cisymbol'];
                    $formated = number_format($thisvalue, 2, ',', '.') . '€';
                    return $formated;
                }
            } else if ($cinitial == 'USD') {
                //echo 'we are in  usa';
                function formatecurrency($thisvalue)
                {
                    // $cisymboll = $GLOBALS['cisymbol'];
                    $formated = number_format($thisvalue, 2, '.', ',') . '$';
                    return $formated;
                }
            } else if ($cinitial == 'GBP') {
                //echo 'we are in  gbp';
                function formatecurrency($thisvalue)
                {
                    // $cisymboll = $GLOBALS['cisymbol'];
                    $formated = number_format($thisvalue, 2, '.', ',') . '£';
                    return $formated;
                }
            } else if ($cinitial == 'CHF') {
                //echo 'we are in  chf';
                function formatecurrency($thisvalue)
                {
                    // $cisymboll = $GLOBALS['cisymbol'];
                    $formated = number_format($thisvalue, 2, '.', ',') . 'CHF';
                    return $formated;
                }
            } else if ($cinitial == 'DKK') {
                //echo 'we are in  dkk';
                function formatecurrency($thisvalue)
                {
                    // $cisymboll = $GLOBALS['cisymbol'];
                    $formated = number_format($thisvalue, 2, ',', '.') . 'kr';
                    return $formated;
                }
            } else if ($cinitial == 'RUB') {
                //echo 'we are in  rub';
                function formatecurrency($thisvalue)
                {
                    // $cisymboll = $GLOBALS['cisymbol'];
                    $formated = number_format($thisvalue, 2, ',', '.') . '₽';
                    return $formated;
                }
            } else if ($cinitial == 'TRY') {
                //echo 'we are in  turky';
                function formatecurrency($thisvalue)
                {
                    // $cisymboll = $GLOBALS['cisymbol'];
                    $formated = number_format($thisvalue, 2, '.', ',') . '₺';
                    return $formated;
                }
            }

            //formatecurrency('6575');

        }
    }

    public function generate_otp()
    {

        $n = 4;
        $numbers = "1357902468";
        $result = "";

        for ($i = 0; $i < $n; $i++) {
            $result .= substr($numbers, (rand() % (strlen($numbers))), 1);
        }

        // $userid = $_SESSION['userID'];
        // $getPhoneNumber = $db->prepare("SELECT * FROM `users` WHERE `user_id`='$userid'");
        // try {
        //     $getPhoneNumber->execute();
        // } catch (\Throwable $e) {
        //['->']result = 'Error';
        //     ['r']esponse->message = $e->getMessage();
        //     return $response;
        // }
        // $resultPhone = $getPhoneNumber->fetchAll();
        // foreach ($resultPhone as $row) {
        //     $phoneNumber = $row['user_phone'];
        //     $countryid = $row['user_country'];
        // }
        // $getCountry = $db->prepare("SELECT * FROM `countries` WHERE `country_id`='$countryid' ");
        // try {
        //     $getCountry->execute();
        // } catch (\Throwable $e) {
        //['->']result = 'Error';
        //     ['r']esponse->message = $e->getMessage();
        //     return $response;
        // }

        // $resultCountry = $getCountry->fetch();
        // $countrycode = $resultCountry['country_phone_code'];
        // if ($countrycode == "" || $ph
        //['->']result = 'Error';
        //     ['r']esponse->message = 'No phone number found';
        //     return $response;
        // }
        // $response['result'] = 'OK';
        // $response['message'] = $result;
        // return $response;

        $phoneNumber = getHotelSettings()->phone;

        $sms_content = "Use verification code " . $result;
        $url = "https://api.sms.to/sms/send";
        $data = [
            "to" => $phoneNumber,
            "bypass_optout" => true,
            "message" => $sms_content,
            "sender_id" => "HotelPoint",
        ];

        try {
            $client = new Client();
            $request = $client->post($url, [
                "headers" => ['Content-Type' => 'application/json', "Accept" => 'application/json', "Authorization" => "Bearer " . env('SMS_API_KEY')],
                "body" => json_encode($data),
            ]);
            $request_response = json_decode($request->getBody(), true);
            $request_success = $request_response['success'];
            if ($request_success == true) {
                $response['result'] = 'OK';
                $response['message'] = $result;
                return $response;
            } else {
                $response['result'] = 'Error';
                $response['message'] = "An unexpected error has occured. Please try again";
                return $response;
            }
        } catch (\Throwable$e) {
            $response['result'] = 'Error';
            $response['message'] = $e->getMessage();
            return $response;
        }
    }

    public function show_card(Request $request)
    {

        $payment_gateway = "";

        try {
            $reservation = Reservation::find($request->id);

            $value = $reservation->channex_cards;
            if ($value) {
                $session_url = "https://pci.channex.io/api/v1/session_tokens?api_key=" . config('services.channex.pci_api_key');
                $card_session_data = [
                    "session_token" => [
                        "scope" => "card",
                    ],
                ];

                $sc_session_data = [
                    "session_token" => [
                        "scope" => "service_code",
                    ],
                ];

                try {

                    $client = new Client();
                    $card_session_request = $client->post(
                        $session_url,
                        [
                            "headers" => ['Content-Type' => 'application/json'],
                            "body" => json_encode($card_session_data),
                        ]
                    );

                    $card_result = json_decode($card_session_request->getBody(), true);
                    $card_session_key = $card_result['data']['attributes']['session_token'];
                } catch (\Throwable$e) {
                    $response['code'] = '401';
                    $response['message'] = $e->getMessage();
                    return $response;
                }

                try {

                    $client = new Client();
                    $sc_session_request = $client->post(
                        $session_url,
                        [
                            "headers" => ['Content-Type' => 'application/json'],
                            "body" => json_encode($sc_session_data),
                        ]
                    );

                    $sc_result = json_decode($sc_session_request->getBody(), true);
                    $sc_session_key = $sc_result['data']['attributes']['session_token'];

                    $url = "https://pci.channex.io/api/v1/show_card?card_token=$value&session_token=$card_session_key&service_code_token=$sc_session_key";
                    if ($payment_gateway) {
                        $available = "yes";
                    } else {
                        $available = "no";
                    }
                    $response['code'] = '200';
                    $response['message'] = $url;
                    $response['payment'] = $available;
                    return $response;
                } catch (\Throwable$e) {
                    $response['code'] = '401';
                    $response['message'] = $e->getMessage();
                    return $response;
                }
            } else {
                $response['code'] = '404';
                $response['message'] = "This reservation does not have payment card";
                return $response;
            }
        } catch (\Throwable$e) {
            $response['code'] = '401';
            $response['message'] = $e->getMessage();
            return $response;
        }
    }

    public function save_credit_card_payment(Request $request)
    {
        $paidAmount = $_POST['paid'];
        $chargeAmount = $_POST['chargeamount'];
        $totalCharge = $_POST['totalcharge'];
        $reservation_id = $_POST['id'];
        $payment_method = $_POST['paymentmethod'];
        $deposit_type = $_POST['type'];
        $payableAmount = (float) $totalCharge - (float) $paidAmount;
        $today = date('Y-m-d');

        if (empty($chargeAmount) || $chargeAmount <= 0) {
            $response['code'] = '401';
            $response['message'] = "Payment Value has to be more than 0. Please check your input again";
            return $response;
        } else if ($payableAmount == 0) {
            $response['code'] = '401';
            $response['message'] = "Accomodation balance is zero. You cannot charge any more";
            return $response;
        } else if ($chargeAmount > $payableAmount) {
            $response['code'] = '401';
            $response['message'] = "Guest balance is less than the given amount";
            return $response;
        } else {

            try {

                $resultCard = Reservation::find($reservation_id);
                $currentCard = $resultCard->channex_cards;

            } catch (\Throwable$e) {

                $response['code'] = '401';
                $response['message'] = $e->getMessage();
                return $response;
            }

            try {
                GuestAccommodationPayment::insert([
                    'value' => $chargeAmount,
                    'payment_method_id' => $payment_method,
                    'date' => $today,
                    'reservation_id' => $reservation_id,
                    'is_deposit' => '1',
                    'comments' => '',
                    'deposit_type_id' => $deposit_type,
                ]);

            } catch (\Throwable$e) {
                $response['code'] = '401';
                $response['message'] = $e->getMessage();
                return $response;
                exit;
            }

            // $removeCard = $db->prepare("UPDATE `reservations` SET `channex_cards`='' WHERE `reservation_id`='$reservation_id'");

            try {
                Reservation::find($reservation_id)->update(['channex_cards' => '']);
            } catch (\Throwable$e) {

                $response['code'] = '401';
                $response['message'] = $e->getMessage();
                return $response;
            }

            // ...........remove card from storage...............

            $remocardUrl = "https://pci.channex.io/api/v1/cards/$currentCard?api_key=" . config('services.channex.pci_api_key');

            try {
                $request = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'user-api-key' => config('services.channex.api_key'),
                ])->delete($remocardUrl);
                $request->throw();

                $response['code'] = '200';
                $response['message'] = "You have made payment successfully";
                return $response;
            } catch (\Throwable $e) {
                // $db->commit();
                $response['code'] = $e->getCode();
                $response['message'] = $e->getMessage();
                return $response;
            }

        }
    }

    public function comissionList(Request $request)
    {
        $booking_id = $request->input('booking_id');

        $reservations = getHotelSettings()->reservations()->select('reservations.id as reservation_id', 'reservations.*', 'booking_agencies.name as agency_name')
            ->join('booking_agencies', 'reservations.booking_agency_id', '=', 'booking_agencies.id')
            ->where('reservations.status', 'CheckedOut')
            ->where('booking_agencies.name', '!=', 'Individual');

        if ($booking_id) {
            $reservations = $reservations->where('reservations.id', $booking_id);
        }
        $reservations = $reservations->orderBy('reservations.id', 'ASC')->get();
        return view('front.Finance.commission.list', ['reservations' => $reservations]);
    }

    public function creditCardList(Request $request)
    {

        $accomPayments = GuestAccommodationPayment::with(['payment_method', 'reservation'])->whereIn('payment_method_id', [2, 3, 4, 5, 8])
            ->whereHas("reservation", function ($q) {
                $q->where("hotel_settings_id", getHotelSettings()->id);
            });
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
        
        if ($from_date && $to_date) {
            $accomPayments = $accomPayments->whereBetween('date', [$from_date, $to_date]);
        }
        $accomPayments = $accomPayments->orderBy('date', 'DESC')->get();

        //extrasPayments
        $extrasPayments = GuestExtrasPayment::with(['payment_method', 'reservation'])->whereIn('payment_method_id', [2, 3, 4, 5, 8])->whereHas("reservation", function ($q) {
            $q->where("hotel_settings_id", getHotelSettings()->id);
        });
        $from_date_services = $request->input('from_date_services');
        $to_date_services = $request->input('to_date_services');
        
        if ($from_date_services && $to_date_services) {
            $extrasPayments = $extrasPayments->whereBetween('date', [$from_date_services, $to_date_services]);
        }
        $extrasPayments = $extrasPayments->orderBy('date', 'DESC')->get();

        //guest_overnight_tax_payments
        $guest_overnight_tax_payments = GuestOvernightTaxPayment::with(['payment_method', 'reservation'])->whereIn('payment_method_id', [2, 3, 4, 5, 8])->whereHas("reservation", function ($q) {
            $q->where("hotel_settings_id", getHotelSettings()->id);
        });
        $from_date_tax = $request->input('from_date_tax');
        $to_date_tax = $request->input('to_date_tax');
        
        if ($from_date_tax && $to_date_tax) {
            $guest_overnight_tax_payments = $guest_overnight_tax_payments->whereBetween('date', [$from_date_tax, $to_date_tax]);
        }
        $guest_overnight_tax_payments = $guest_overnight_tax_payments->orderBy('date', 'DESC')->get();

        //If search is made on a specific tab
        $showTab = "pills-home";
        if ($request->has("pills-home")) {
            $showTab = "pills-home";
        }
        if ($request->has("pills-profile")) {
            $showTab = "pills-profile";
        }
        if ($request->has("pills-contact")) {
            $showTab = "pills-contact";
        }

        $guestAccPayments = GuestAccommodationPayment::with(['payment_method', 'reservation'])->whereIn('payment_method_id', [2, 3, 4, 5, 8])->whereHas("reservation", function ($q) {
            $q->where("hotel_settings_id", getHotelSettings()->id);
        })->get();
        $cards = array();
        foreach ($guestAccPayments as $payment) {
            $commision = $payment->payment_method->commission_percentage / 100;
            $comAmmount = round($payment->value * $commision, 2);
            if (in_array($payment->payment_method_id, array_keys($cards))) {
                $cards[$payment->payment_method_id]->value += $payment->value;
                $cards[$payment->payment_method_id]->commision_total += $comAmmount;
            } else {
                $cards[$payment->payment_method_id] = new stdClass();
                $cards[$payment->payment_method_id]->name = $payment->payment_method->name;
                $cards[$payment->payment_method_id]->value = $payment->value;
                $cards[$payment->payment_method_id]->commision_total = $comAmmount;
            }
        }


        //extrasPaymentsCards
        $guestExtraPayments = GuestExtrasPayment::with(['payment_method', 'reservation'])->whereIn('payment_method_id', [2, 3, 4, 5, 8])->whereHas("reservation", function ($q) {
            $q->where("hotel_settings_id", getHotelSettings()->id);
        })->get();
        $servicesCards = array();
        foreach ($guestExtraPayments as $payment) {
            $commision = $payment->payment_method->commission_percentage / 100;
            $comAmmount = round($payment->value * $commision, 2);
            if (in_array($payment->payment_method_id, array_keys($servicesCards))) {
                $servicesCards[$payment->payment_method_id]->value += $payment->value;
                $servicesCards[$payment->payment_method_id]->commision_total += $comAmmount;
            } else {
                $servicesCards[$payment->payment_method_id] = new stdClass();
                $servicesCards[$payment->payment_method_id]->name = $payment->payment_method->name;
                $servicesCards[$payment->payment_method_id]->value = $payment->value;
                $servicesCards[$payment->payment_method_id]->commision_total = $comAmmount;
            }
        }

        //guest_overnight_tax_paymentsCards
        $guest_overnight_tax_paymentsCards = GuestOvernightTaxPayment::with(['payment_method', 'reservation'])->whereIn('payment_method_id', [2, 3, 4, 5, 8])
            ->whereHas("reservation", function ($q) {
                $q->where("hotel_settings_id", getHotelSettings()->id);
            })->get();
        $taxCards = array();
        foreach ($guest_overnight_tax_paymentsCards as $payment) {
            $commision = $payment->payment_method->commission_percentage / 100;
            $comAmmount = round($payment->value * $commision, 2);
            if (in_array($payment->payment_method_id, array_keys($taxCards))) {
                $taxCards[$payment->payment_method_id]->value += $payment->value;
                $taxCards[$payment->payment_method_id]->commision_total += $comAmmount;
            } else {
                $taxCards[$payment->payment_method_id] = new stdClass();
                $taxCards[$payment->payment_method_id]->name = $payment->payment_method->name;
                $taxCards[$payment->payment_method_id]->value = $payment->value;
                $taxCards[$payment->payment_method_id]->commision_total = $comAmmount;
            }
        }

        return view('front.Finance.commission.credit-card', ['accomPayments' => $accomPayments, 'showTab' => $showTab, 'cards' => $cards, 'servicesCards' => $servicesCards, 'taxCards' => $taxCards, 'extrasPayments' => $extrasPayments, 'guest_overnight_tax_payments' => $guest_overnight_tax_payments]);
    }

    public function salesLedger(Request $request)
    {
        if ($request->has('agency_name')) {
            $agency_name = $request->input('agency_name');
            $agencies = getHotelSettings()->companies()->where('name', 'LIKE', '%' . $agency_name . '%')->get();
        } else {
            $agencies = getHotelSettings()->companies()->get();
        }


        $allDocs = getHotelSettings()->documents()->join('document_infos', 'documents.id', '=', 'document_infos.document_id')
            ->where('documents.payment_method_id', 6)
            ->where('documents.paid', 0)
            ->groupBy('document_infos.company_id');
        $totalDebtors = $allDocs->count();

        $allDocs = getHotelSettings()->documents()->join('document_infos', 'documents.id', '=', 'document_infos.document_id')
            ->where('documents.payment_method_id', 6)
            ->where('documents.paid', 0);
        $totalInvoices = $allDocs->count();
        $totalBalance = $allDocs->sum('documents.total');

        foreach ($agencies as $agency) {
            $docs = Document::join('document_infos', 'documents.id', '=', 'document_infos.document_id')
                ->where('documents.payment_method_id', 6)
                ->where('documents.paid', 0)
                ->where('document_infos.company_id', $agency->id);

            $total = $docs->sum('total');
            $count = $docs->count();
            $agency->total = $total;
            $agency->count = $count;

        }
        return view('front.Finance.sales_ledger', ['agencies' => $agencies, 'totalDebtors' => $totalDebtors, 'totalInvoices' => $totalInvoices, 'totalBalance' => $totalBalance]);
    }
    

    public function saledLedgerModalShow(Request $request)
    {
        $agency_id = $request->input('agency_id');
        $docs = Document::select('documents.*')
            ->join('document_infos', 'documents.id', '=', 'document_infos.document_id')
            ->join('payment_methods', 'payment_methods.id', '=', 'documents.payment_method_id')
            ->where('documents.payment_method_id', 6)
            ->where('documents.paid', 0)
            ->where('document_infos.company_id', $agency_id)
            ->get();

        $output = "";
        foreach ($docs as $doc) {
            $documentId = $doc->id;
            $documentEnumeration = $doc->enumeration;
            $paymentMethodId = $doc->payment_method_id;
            $documentPrintDate = $doc->print_date;
            $paid = (int) $doc->paid;
            $documentTotal = showPriceWithCurrency($doc->total);
            $activity = Activity::where('document_id', $documentId)->first();
            $getcount = "Null";
            if ($activity) {
                $getcount = $activity->activity_reservation;
            }

            $output .= "<div class='row mytr text-center' >
                            <div class='col'>$documentId</div>
                            <div class='col'>#$getcount</div>
                            <div class='col'>$documentPrintDate</div>
                            <div class='col'>$documentTotal</div>
                            <div class='col'>
                                <button style='transform: translateY(-10px) scale(0.7);display: inline-flex;align-items: center;' onclick='invoiceupdate(this.id, $paymentMethodId, $paid)' data-dismiss='modal' id='$documentId' type='button' class='btn btn-success'>
                                    <i style='font-size: 1rem;' class='fa fa-pencil-alt mr-2'></i> Edit
                                </button>
                            </div>
                        </div>";

        }

        return new JsonResponse(['html' => $output]);

    }

    public function saledLedgerModalUpdate(Request $request)
    {
        $document_id = $request->input('invoice_id');
        $paymentMethodId = $request->input('paymentMethodId');
        $paid = $request->input('paid');

        $paymentMethods = PaymentMethod::all();
        $selectOptionsHtml = "";
        foreach ($paymentMethods as $paymentMethod) {
            if ($paymentMethod->id == $paymentMethodId) {
                $selectOptionsHtml .= '<option name="payment_method" selected value="' . $paymentMethod->id . '">' . $paymentMethod->name . '</option>';
            } else {
                $selectOptionsHtml .= '<option name="payment_method" value="' . $paymentMethod->id . '">' . $paymentMethod->name . '</option>';
            }
        }

        $paidSelectOptionsHtml = "";
        if ($paid == 0) {
            $paidSelectOptionsHtml .= '<option name="paid" selected value="0">No</option>';
            $paidSelectOptionsHtml .= '<option name="paid" value="1">Yes</option>';
        } else {
            $paidSelectOptionsHtml .= '<option name="paid" value="0">No</option>';
            $paidSelectOptionsHtml .= '<option name="paid" selected value="1">Yes</option>';
        }

        $html = "
            <div class='form-holder col-4'>
                <label class='form-row-inner'>
                    <label>Invoice No</label>
                    <input type='text' class='form-control1' value='$document_id' style='width:225px;' name='document_id' required />
                </label>
            </div>
            <div class='form-holder col-4 '>
                <label class='form-row-inner'>
                    <label>Payment Method</label>
                    <select class='form-control1' style='width:225px;' name='payment_method' >
                        $selectOptionsHtml
                    </select>
                </label>
            </div>
            <div class='form-holder col-4'>
                <label class='form-row-inner'>
                    <label>Paid</label>
                    <select class='form-control1' style='width:225px;' name='is_paid' >
                        $paidSelectOptionsHtml
                    </select>
                </label>
            </div>
        ";

        return new JsonResponse(['html' => $html]);

    }

    public function saledLedgerUpdate(Request $request)
    {
        $document_id = $request->input('document_id');
        $payment_method = $request->input('payment_method');
        $is_paid = $request->input('is_paid');
        $document = Document::find($document_id);
        $document->payment_method_id = $payment_method;
        $document->paid = $is_paid;
        $document->save();
        return redirect()->back()->with('success', 'Invoice updated successfully');
    }

    public function hotel_budget(Request $request)
    {
        return view('front.Finance.budget.hotel_budget');
    }
    public function hotel_actual(Request $request)
    {
        return view('front.Finance.budget.actual_budget');
    }

}

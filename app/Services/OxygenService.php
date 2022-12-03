<?php

namespace App\Services;

use App\Models\Country;
use App\Models\Document;
use App\Models\Activity;
use App\Models\VatOption;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class OxygenService
{
    const RETRIES = 1;
    const TIMEOUT = 5 * 1000; // 5 seconds

    const INVOICE_TYPE = [
        1 => 'E3_561_001', // Guests Settles Extras //invoice
        2 => 'E3_561_003', // Pay Own Account
        3 => 'E3_561_002', // Company Full Account //receipt
    ];

    const CONTACT_TYPE = [
        "guest" => 1,
        "company" => 2,
    ];

    private function client()
    {
        return Http::withToken(getHotelSettings()->oxygen_api_key)
            ->accept('application/json')
            ->retry(self::RETRIES, self::TIMEOUT);
    }

    // Contacts
    public function getContacts()
    {
        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . getHotelSettings()->oxygen_api_key,
        ])
            ->get(config('services.oxygen.api_base') . '/contacts?page=' . request('page'));
    }
    public function createContact($data, $type, $isCompany = false)
    {
        if ($isCompany) {
            if ($type=="company") {
                $country_code = $data->country->alpha_two_code;
            }else if ($type=="channel") {
                $country_code = Country::where("id", $data->country)->first()->alpha_two_code;
            }else{}
            
            $data = [
                'type' => self::CONTACT_TYPE["company"],
                'is_client' => true,
                'is_supplier' => false,
                'company_name' => $data->name,
                'profession' => $data->activity,
                'vat_number' => $data->vat_number,
                'tax_office' => $data->tax_office,
                'telephone' => $data->phone_number,
                'mobile' => $data->mobile,
                'email' => $data->email,
                'zip_code' => $data->postal_code,
                'country' => $country_code,
                "street" => $data->address,
                "number" => $data->address,
                "city" => $data->headquarters,
            ];
        } else {
            $name_array = explode(' ', $data->full_name, 2);
            $first_name = "";
            $last_name = "";
            if (sizeof($name_array) >= 1) {
                $first_name = $name_array[0];
            }
            if (sizeof($name_array) >= 2) {
                $last_name = $name_array[1];
            } else {
                $last_name = $first_name;
            }

            $data = [
                'type' => self::CONTACT_TYPE["guest"],
                'is_client' => true,
                'is_supplier' => false,
                'name' => $first_name,
                'surname' => $last_name,
                'telephone' => $data->phone,
                'mobile' => $data->mobile,
                'email' => $data->email,
                'zip_code' => $data->postal_code,
                'country' => $data->country->alpha_two_code,
            ];
        }
        $response = $this->client()
            ->post(config('services.oxygen.api_base') . '/contacts', $data);

        if ($response->successful()) {
            return [
                "success" => true,
                "id" => $response['id'],
            ];
        }

        return [
            "success" => false,
            "message" => $response->toException()->getMessage(),
        ];
    }
    public function getContact(string $id)
    {
        return $this->client()
            ->get(config('services.oxygen.api_base') . '/contacts/' . $id);
    }

    // Invoices
    public function getInvoices()
    {
        return $this->client()
            ->get(config('services.oxygen.api_base') . '/invoices?page=' . request('page'));
    }

    /* @var
    $data: stdClass{
    guest: Guest,
    country: County,
    document: Document
    reservation: Reservation
    }
     */

    public function createInvoice($data)
    {
    //    dd($data);
    // dd($data->oldDoc->mark_id);
        if (is_null($data->guest->oxygen_id)) {
            return [
                "success" => false,
                "message" => "No oxygen id present inside guest",
            ];
        }
        
        // dd($sequenceId);
        $mydataCategory='category1_3';
        $oxygendocumentType='rs';
        $mydataDocumentType='';
        if ($data->type=="receipt_cancel") {
            $mydataDocumentType='11.2';
            $oxygendocumentType='rs';
        }else if ($data->type=="invoice_cancel") {
            $mydataDocumentType='2.1';
            $oxygendocumentType='s';
        }else if ($data->document->document_type->type==2) {
            $mydataDocumentType='11.4';
            $oxygendocumentType='pistlianiki';
        }else if ($data->document->document_type->type==3) {
            $mydataDocumentType='8.2';
            $oxygendocumentType='rs';
            $vat=0;
            $mydataCategory='category1_95';
            
        }else if ($data->document->document_type->type==5) {
            $mydataDocumentType='11.2';
            $oxygendocumentType='rs';
        }else if ($data->document->document_type->type==6) {
            $mydataDocumentType='5.2';
            $oxygendocumentType='pistotiko';
            
            // $mydataType='E3_561_001';
        }else if ($data->document->document_type->type==4) {
            $mydataDocumentType='2.1';
            $oxygendocumentType='s';
        }

        // get tax id
        $taxes = $this->getTaxes()->json();
        $documentRows = $this->getNumberingSequences()->json();
        $documentRows=collect($documentRows['data']);
        $sequenceId='';
        $sequence=$documentRows->where('document_type', $oxygendocumentType)->where('name', $data->document->row)->first();
        if ($sequence) {
            $sequenceId=$sequence['id'];
        }
        // dd($documentRows);
        // foreach ($documentRows as $row) {
        //     if ($row['document_type']==$oxygendocumentType) {
        //         if ($row['name']=$data->document->row) {
        //             $sequenceId=$row['id'];
        //             break;
        //         }
                
        //     }
        // }
       
        // For invoices add company id. For receipts add guest id
        if (in_array($data->document->document_type->type, [4, 6])) {
            $contactId=$data->document->document_info->company->oxygen_id;
            
        }else if($data->type=="invoice_cancel"){
            $contactId=$data->document->document_info->company->oxygen_id;
        }else{
            $contactId=$data->guest->oxygen_id;
            
        }

        $items = [];
        
        $activities=Activity::where('document_id', $data->document->id)->get();
        foreach ($activities as $activity) {
            $d = array();
            $vat_value_to_deduct = ceil(($activity->price / 100) * $activity->vat);
            if ($activity->description=="Overnight Tax") {
                $vat=getHotelSettings()->all_vat->where('vat_option_id', 8)->first()->oxygen_id;
                // dd($vat);
            }else if ($activity->description=="Cancellation Fees") {
                $vat=getHotelSettings()->cancellation_vat_tax->oxygen_id;
            }else{
                $VatOption=VatOption::where('value', $activity->vat)->first();
                $vat=getHotelSettings()->all_vat->where('vat_option_id', $VatOption->id)->first()->oxygen_id;
            }
            $d['description'] = $activity->description;
            $d['quantity'] = $activity->quantity;
            $d['unit_net_value'] = $activity->price - $vat_value_to_deduct;
            $d['tax_id'] = $vat;
            $d['vat_amount'] = $vat_value_to_deduct;
            $d['net_amount'] = $activity->price - $vat_value_to_deduct;
            $d['mydata_classification_category'] =$mydataCategory ;
            $d['mydata_classification_type'] = self::INVOICE_TYPE[$data->reservation->payment_mode->id];
            $items[] = $d;
        }
        

        if ($data->document->document_type->type==3) {
            $invoiceData = [
                'issue_date' => Carbon::now()->format('Y-m-d'),
                'document_type' => $oxygendocumentType,
                "numbering_sequence_id"=>$sequenceId,
                "number"=>$data->document->enumeration,
                'payment_method_id'=>$data->document->payment_method->oxygen_id,
                'language' => $data->country->alpha_two_code,
                'contact_id' => $contactId,
                'tax_category'=>getHotelSettings()->overnight_tax->category,
                'correlated_invoice'=>$data->document->mark_id,
                'items' => $items,
                'mydata_document_type' => $mydataDocumentType,
            ];
            $url=config('services.oxygen.api_base') . '/hotel-tax';
        }else if($data->document->document_type->type==2 || $data->document->document_type->type==6){
           
            $invoiceData = [
                'issue_date' => Carbon::now()->format('Y-m-d'),
                'correlated_invoice'=>$data->oldDoc->mark_id ,
                'document_type' => $oxygendocumentType,
                "numbering_sequence_id"=>$sequenceId,
                "number"=>$data->document->enumeration,
                'payment_method_id'=>$data->document->payment_method->oxygen_id,
                'language' => $data->country->alpha_two_code,
                'contact_id' => $contactId,
                'total_amount' => $data->document->total,
                'net_amount' => $data->document->net_value,
                'vat_amount' => $data->document->tax,
                'amount_to_pay' => $data->document->total,
                'amount_paid' => $data->document->total,
                'amount_pending' => 0,
                'items' => $items,
                'mydata_document_type' => $mydataDocumentType,
            ];
            $url=config('services.oxygen.api_base') . '/credit-notes';
        }else{
            $invoiceData = [
                'issue_date' => Carbon::now()->format('Y-m-d'),
                'document_type' => $oxygendocumentType,
                "numbering_sequence_id"=>$sequenceId,
                "number"=>$data->document->enumeration,
                'payment_method_id'=>$data->document->payment_method->oxygen_id,
                'language' => $data->country->alpha_two_code,
                'contact_id' => $contactId,
                'total_amount' => $data->document->total,
                'net_amount' => $data->document->net_value,
                'vat_amount' => $data->document->tax,
                'amount_to_pay' => $data->document->total,
                'amount_paid' => $data->document->total,
                'amount_pending' => 0,
                'items' => $items,
                'mydata_document_type' => $mydataDocumentType,
            ];
            $url=config('services.oxygen.api_base') . '/invoices';
        }
        

        // dd($invoiceData);
        $response = $this->client()
            ->post($url, $invoiceData);
        // dd($response->body());
        if ($response->successful()) {
            $data->document->mark_id=$response['id'];
            $data->document->save();
            if($data->document->document_type->type==2 || $data->document->document_type->type==6){
                $printDoc=$this->getCreditInvoicePdf($response['id']);
            }else{
                $printDoc=$this->getInvoicePdf($response['id']);
            }
            if ($printDoc) {
                $filename=$response['id'] . '.pdf';
                $data->document->print_path=$filename;
                $data->document->save();
                return true;
                
            }else{
                return false;
            }
           
        }else{
            dd($response->body());
            return false;
      }
    }

    public function getInvoice(string $id)
    {
        return $this->client()
            ->get(config('services.oxygen.api_base') . '/invoices/' . $id);
    }

    public function getInvoicePdf(string $id)
    {
        try {
            $response = $this->client()
                ->accept("application/pdf")
                ->get(config('services.oxygen.api_base') . '/invoices/' . $id . '/pdf?template=a4');

            $fileName = $id . '.pdf';

            $storage=Storage::disk('public')->put('invoices/' . $fileName, $response->body());
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
        
    }

    public function getCreditInvoicePdf(string $id)
    {
        try {
            $response = $this->client()
                ->accept("application/pdf")
                ->get(config('services.oxygen.api_base') . '/credit-note/' . $id . '/pdf?template=a4' );

            $fileName = $id . '.pdf';

            $storage=Storage::disk('public')->put('invoices/' . $fileName, $response->body());
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            // dd($th->getMessage());
            return false;
        }
        
    }

    // Taxes
    public function getTaxes()
    {
        return $this->client()
            ->get(config('services.oxygen.api_base') . '/taxes');
    }

    public function createTax($tax)
    {

        // $tax = [
        //     'title' => '50% Vat',
        //     'mydata_vat_code' => 999,
        //     // 'mydata_vat_exemption_category'=>true,
        //     'rate' => 50,
        // ];

        $response = $this->client()
            ->post(config('services.oxygen.api_base') . '/taxes', $tax);

        if ($response->successful()) {
            return (string) $response['id'];
        } else {
            dd($response->toException()->getMessage());
        }

        return $response->ok();
    }

    public function getTax(string $id)
    {
        return $this->client()
            ->get(config('services.oxygen.api_base') . '/taxes/' . $id);
    }

    // Numbering Sequences
    public function getNumberingSequences()
    {
        return $this->client()
            ->get(config('services.oxygen.api_base') . '/numbering-sequences');
    }

    public function createNumberingSequence($data)
    {
        $response = $this->client()
            ->post(config('services.oxygen.api_base') . '/numbering-sequences', $data);

        if ($response->successful()) {
            return (string) $response['id'];
        }

        return $response->body();
    }

    public function getNumberingSequence(string $id)
    {
        return $this->client()
            ->get(config('services.oxygen.api_base') . '/numbering-sequences/' . $id);
    }

    // Payment Methods - DONE
    public function getPaymentMethods()
    {
        return $this->client()
            ->get(config('services.oxygen.api_base') . '/payment-methods');
    }

    public function createPaymentMethod($data)
    {

        $paymentMethod = [
            'title_gr' => $data->name,
            'title_en' => $data->name,
            'mydata_code' => (int) $data->is_card_type ? 1 : 3,
            'status' => true,
        ];

        $response = $this->client()
            ->post(config('services.oxygen.api_base') . '/payment-methods', $paymentMethod);

        if ($response->successful()) {
            return (string) $response['id'];
        }

        return $response->ok();
    }

    public function getPaymentMethod(string $id)
    {
        return $this->client()
            ->get(config('services.oxygen.api_base') . '/payment-methods/' . $id);
    }
}

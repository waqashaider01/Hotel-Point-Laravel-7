<?php

namespace App\Http\Livewire\Reservations;

use App\Models\Document;
use App\Models\DocumentInfo;
use App\Models\DocumentType;
use App\Models\GuestAccommodationPayment;
use App\Models\HotelSetting;
use App\Models\PaymentMethod;
use App\Models\Reservation;
use App\Models\Activity;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Validation\Validator;

class CancelledReservationPrintDocument extends Component
{
    public $reservation, $payment_methods, $document_types, $hotel_settings;
    public $accommodation_payment_data = [];

    public $reservation_payments;
    public $reserve_total = 0;
    public $cancellation_total = 0;
    public $accommodation_payment = 0;
    public $accom_balance = 0;

    public $selected_document = null;
    public $selected_document_info = null;
    public $company_id;
    public $companies;
    public $selected_type=null;
    public $isdocumentPrinted;

   
    public function mount(Reservation $reservation)
    {
        $reservation->load([
            'booking_agency',
            'company',
            'guest',
            'guest.country',
            'checkin_guest',
            'rate_type',
            'guest_accommodation_payment',
            'guest_extras_payments',
            'guest_overnight_tax_payments',
            'daily_rates',
            'room',
            'room.room_type',
            'country',
            'payment_mode',
            'payment_method',
            'reservation_extra_charges',
        ]);

        $this->payment_methods = getHotelSettings()->payment_methods;
        $this->companies= getHotelSettings()->companies;
        $this->document_types = [["id"=>1, "name"=>"Cancellation Receipt"], ["id"=>2, "name"=>"Cancellation Invoice"]];
        $this->hotel_settings = getHotelSettings();
       
        $this->reservation_payments = [
            'Accommodation Payment' => $this->reservation->guest_accommodation_payment,
            'Extras Payment' => $this->reservation->guest_extras_payments,
            'Overnight Tax' => $this->reservation->guest_overnight_tax_payments,
        ];

        $this->calculateTotals();
        $this->isdocumentPrinted = getHotelSettings()->documents()->join("document_infos", "document_infos.document_id","=", "documents.id")
                    ->join("activities", "activities.document_id", "=", "documents.id")
                    ->join("document_types", "document_types.id", "=", "documents.document_type_id")
                    ->where("activities.reservation_id", $this->reservation->id)
                    ->where("document_types.type", 1)
                    ->count();
    }

    function insert_accommodation_payment(){
        $this->validate([
            'accommodation_payment_data.value' => ['required', 'numeric'],
            'accommodation_payment_data.payment_date' => ['required', 'date'],
            'accommodation_payment_data.payment_method' => ['required', 'numeric', 'exists:payment_methods,id'],
            'accommodation_payment_data.is_deposit' => ['required', 'string', Rule::in(['Yes', 'No'])],
            'accommodation_payment_data.comments' => ['nullable', 'string', 'min:3', 'max:255'],
        ]);

        $data = [
            'reservation_id' => $this->reservation->id,
            'value' => $this->accommodation_payment_data['value'],
            'date' => $this->accommodation_payment_data['payment_date'],
            'comments' => $this->accommodation_payment_data['comments'] ?? "",
            'is_deposit' => $this->accommodation_payment_data['is_deposit'] == "Yes" ? 1:0,
            'payment_method_id' => $this->accommodation_payment_data['payment_method'],
        ];

        try {
            $new_payment = GuestAccommodationPayment::create($data);
            array_push($this->reservation_payments['Accommodation Payment'], $new_payment);
            $this->calculateTotals();
            $this->reset('accommodation_payment_data');
            $this->resetErrorBag();

            $this->emit('success', "Accommodation Payment Added successfully!", "#insertAccommodationPayment");
        } catch (\Exception $e) {
            $this->emit('error', $e->getMessage() ?? "Server encountered an error!", "#insertAccommodationPayment");
        }
    }

    public function calculateTotals()
    {
        $cancellation_charge = $this->reservation->rate_type->cancellation_charge;
        $cancellation_charge_days = $this->reservation->rate_type->cancellation_charge_days;

        $cancelled_days = \Carbon\Carbon::parse($this->reservation->arrival_date)->diffInDays(\Carbon\Carbon::parse($this->reservation->cancellation_date));

        $this->cancellation_total = 0;
        switch ($this->reservation->rate_type->rate_type_cancellation_policy->type) {
            case 1:
                if ($cancelled_days < $cancellation_charge_days) {
                    $daily_rate_days = $this->reservation->daily_rates->count();

                    if ($daily_rate_days > $cancellation_charge_days) {
                        $this->cancellation_total = $this->reservation->daily_rates->sum('price');
                    } else {
                        $this->cancellation_total = $this->reservation->daily_rates
                            ->sortBy('date')
                            ->take($cancellation_charge)
                            ->sum('price');
                    }
                }
                break;
            case 2:
                if ($cancelled_days < $cancellation_charge_days) {
                    $this->cancellation_total = $this->reservation->daily_rates->sum('price');
                    $this->cancellation_total *= $cancellation_charge / 100;
                    
                }
                break;
            case 3:
            case 4:
                if ($cancelled_days < $cancellation_charge_days) {
                    $this->cancellation_total = $cancellation_charge;
                }
                break;

            default:
                throw new \Exception('Error Processing Rate type cancellation policy', 1);
                break;
        }

        $this->reserve_total = $this->reservation
            ->daily_rates()
            ->whereBetween('date', [$this->reservation->arrival_date, $this->reservation->departure_date])
            ->sum('price');
        $this->accommodation_payment = collect($this->reservation_payments['Accommodation Payment'])->sum('value');

        $this->accom_balance = $this->cancellation_total - $this->accommodation_payment;
    }

    public function changeSelectedDocument($id)
    {
        $this->selected_type=$id;
        $this->selected_document = getHotelSettings()->document_types()->where('type', 1)->first();
        $cityTax=1+($this->hotel_settings->city_tax/100);
        $cancellationVat=1+($this->hotel_settings->cancellation_vat_tax->vat_option->value/100);
        $muncipalTax=number_format((float)$this->cancellation_total/$cityTax, 2, '.', ''); 
        $muncipalTax=number_format((float)$this->cancellation_total- $muncipalTax, 2, '.', '') ;
        $cancellationVatAmount= number_format((float)$this->cancellation_total-($this->cancellation_total/$cancellationVat), 2, '.', '') ;
        $this->selected_document_info = [
            'row' => $this->selected_document->row,
            'enumeration' => $this->selected_document->enumeration,
            'print_date' => now()->format('Y-m-d'),
            'hotel_settings_id'=>$this->hotel_settings->id,
            'print_path' => '',
            'total' => $this->cancellation_total,
            'comments' => $this->reservation->comment,
            'vat' => $this->hotel_settings->cancellation_vat_tax->vat_option->value ?? '0',
            'city_vat' => $this->hotel_settings->city_tax,
            'discount' => 0.00,
            'discount_net_value' => 0.00,
            'municipal_tax' => $muncipalTax,
            'tax_2' => null,
            'paid' => 1,
            'payment_method_id' => $this->reservation->payment_method_id,
            'document_type_id' => $this->selected_document->id
        ];
        $this->selected_document_info['taxable_amount'] = number_format((float) $this->cancellation_total-$cancellationVatAmount-$muncipalTax, 2, '.', '');
        $this->selected_document_info['net_value'] = number_format((float)$this->cancellation_total/$cancellationVat, 2, '.', '');
        $this->selected_document_info['tax'] = number_format((float)$this->cancellation_total- $this->selected_document_info['net_value'] , 2, '.', '') ;
        // dd($this->selected_document_info['tax']);
        $this->emit('hideModal', "#printDocumentModal");
        $this->emit('showModal', "#printDocumentInfoModal");
    }

    public function generatePrintDocument()
    {
        
        try {
            DB::beginTransaction();

            $document = Document::create($this->selected_document_info);
            if ($this->selected_type==2) {
                if ($this->company_id) {
                    DocumentInfo::create([
                        'company_id' => $this->company_id,
                        'booking_agency_id' => $this->reservation->booking_agency_id,
                        'document_id' => $document->id,
                        'guest_id' => $this->reservation->guest_id,
                        
                    ]);
                    
                }else{
                    $this->emit('error', 'Company is required ', "#printDocumentInfoModal");
                    return;
                }

                
                
            }else{
                DocumentInfo::create([
                    'company_id' => null,
                    'booking_agency_id' => $this->reservation->booking_agency_id,
                    'document_id' => $document->id,
                    'guest_id' => $this->reservation->guest_id,
                ]);
            }

            Activity::create([
                'description' => 'Cancellation Fees',
                'price' => $document->total,
                'quantity' => 1,
                'date' => $document->print_date,
                'vat' => $document->vat,
                'reservation_id' => $this->reservation->id,
                'document_id' => $document->id,
            ]);

            $this->selected_document->enumeration=(int)$document->enumeration + 1;
            $this->selected_document->save();

            $pdf = generateTaxDocument($document->id, $this->reservation->id);
            $filename = 'document-' . time() . '.pdf';
            Storage::put('public/invoices/' . $filename, $pdf->output());
            $document->print_path = $filename;
            $document->save();
            DB::commit();
            $this->emit('dataSaved', 'Document printed successfully');
             $this->emit('windowReload');

           
        } catch (\Exception $e){
            $this->emit('error', $e->getMessage(), "#printDocumentInfoModal");
            return;
        }

        
    }

    public function render()
    {
        return view('livewire.reservations.cancelled-reservation-print-document');
    }
}

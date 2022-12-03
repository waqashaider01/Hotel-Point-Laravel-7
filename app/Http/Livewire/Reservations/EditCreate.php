<?php

namespace App\Http\Livewire\Reservations;

use App\Mail\NotifyReservationGuest;
use App\Mail\NotifyReservationOffer;
use App\Models\Availability;
use App\Models\BookingAgency;
use App\Models\Company;
use App\Models\Country;
use App\Models\DailyRate;
use App\Models\Guest;
use App\Models\GuestAccommodationPayment;
use App\Models\PaymentMethod;
use App\Models\PaymentMode;
use App\Models\RateType;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Template;
use App\Models\Maintenance;
use App\Models\Property;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditCreate extends Component
{
    use withFileUploads;

    public Collection $countries;
    public Collection $companies;
    public BookingAgency $agency;
    public Collection $room_types;
    public Collection $templates;
    public $rooms;
    public Collection $rates;
    public Collection $methods;
    public Collection $modes;
    public array $daily_rates = [];
    public Reservation $org_reservation;
    public Reservation $reservation;
    public Guest $guest;
    public $selected_room_type;
    public $room_type;
    public float $reservation_amount = 0.0;
    public bool $editing;
    public bool $modeSelected = false;
    public bool $complimentary = false;
    public float $complimentary_rate = 5;
    //    email modal
    public string $selected_template = '';
    public string $email_body = '';
    public string $guest_email = '';
    public $attachment = [];
    public $attachments = [];
    public string $email_subject = '';
    //    accommodation payment modal values
    public string $accom_value = '';
    public string $accom_payment_date = '';
    public string $accom_payment_method = '';
    public string $accom_is_deposit = '';
    public string $transaction_id = '';

    protected array $rules = [
        'reservation.booking_agency_id' => 'required',
        'reservation.booking_code' => 'required',
        'reservation.booking_date' => 'required',
        'reservation.check_in' => 'required',
        'reservation.check_out' => 'required',
        'reservation.arrival_hour' => 'required',
        'reservation.country_id' => 'required',
        'reservation.company_id' => 'required',
        'reservation.channex_status' => 'required',
        'reservation.adults' => 'required',
        'reservation.kids' => 'required',
        'reservation.infants' => 'required',
        'reservation.room_id' => 'required',
        'reservation.rate_type_id' => 'required',
        'reservation.charge_date' => 'required',
        'reservation.payment_method_id' => 'required',
        'reservation.payment_mode_id' => 'required',
        'reservation.arrival_date' => 'required',
        'reservation.departure_date' => 'required',
        'reservation.status' => 'required',
        'reservation.comment' => 'required',
        'reservation.offer_expire_date' => 'required',
        'guest.full_name' => 'required',
        'guest.email' => 'required',
        'guest.phone' => 'required',
    ];


    public function mount($reservation_id)
    {
        $this->countries = Country::all();
        $this->companies = getHotelSettings()->companies;
        $this->templates = Template::email()->get();
        $agency =getHotelSettings()->booking_agencies()->individual()->first();
        if(!$agency){
            session()->flash('error', "You need to have a single channel with code 'CBE' for the new reservation to work");
            return $this->redirectRoute('channel-list');
        } else {
            $this->agency = $agency;
        }
        $this->room_types = getHotelSettings()->room_types;
        $this->rooms = collect();
        $this->rates = collect();
        $this->methods = getHotelSettings()->payment_methods;
        $this->modes = getHotelSettings()->payment_modes;
        $this->editing = $reservation_id != 0;
        $this->reservation = ($this->editing) ? Reservation::findOrFail($reservation_id) : new Reservation();
        $this->org_reservation = $this->reservation;
        $this->guest = ($this->editing) ? $this->reservation->guest : new Guest();
        if ($this->editing) {
            foreach ($this->reservation->daily_rates as $rate) {
                $this->reservation_amount += $rate['price'];
                $this->daily_rates[] = ['date' => $rate['date'], 'price' => $rate['price']];
            }
            $this->selected_room_type = $this->reservation->room->room_type_id;
            $this->getRooms($this->reservation->room->room_type_id);
            $this->getCode();
            $this->guest_email = $this->reservation->guest->email;

             $this->agency=$this->reservation->booking_agency;

        } else {
            $this->reservation->status = 'New';
            $this->reservation->channex_status = 'new';
            $this->reservation->booking_date = today()->toDateString();
        }
        $this->org_reservation = $this->reservation;
        $this->complimentary_rate = getHotelSettings()->complimentary_rate;
    }

    public function render()
    {
        return view('livewire.reservations.edit-create');
    }

    public function updatedSelectedRoomType()
    {
        $this->getRooms($this->selected_room_type);
    }

    public function updatedReservation()
    {
        if ($this->reservation->rate_type_id) {
            $this->getChargeDate($this->reservation->rate_type_id);
            $this->setDailyRates();
        }
    }

    public function submitDailyRates()
    {
        if ($this->editing) {
            $this->reservation_amount = 0;
            foreach ($this->daily_rates as $rate) {
                $this->reservation_amount += $rate['price'];
            }
        }
        $this->emit('dataSaved', 'Daily Rates Added Successfully');
    }

    public function getCode()
    {
        if ($this->reservation->booking_agency && $this->reservation->booking_agency->name == 'Individual') {
            $this->modeSelected = true;
            $paymentmode=getHotelSettings()->payment_modes->where('name', 'Pay Own Account' )->first();
            
            $this->reservation->payment_mode_id = $paymentmode->id;
        } else {
            $this->modeSelected = false;
        }
        if (!$this->editing) {
            $data = Reservation::where('booking_agency_id', $this->reservation->booking_agency_id)
                ->where('booking_code', 'regexp', '^[0-9]+$')->max('booking_code');
            if ($data) {
                $code = (int)$data;
                if ($code >= 9000000001) {
                    $code = $code + 1;
                } else {
                    $code = "9000000001";
                }
            } else {
                $code = "9000000001";
            }
            $this->reservation->booking_code = $code;
        }
    }

    public function getRooms($value)
    {
        $this->room_type = getHotelSettings()->room_types()->with(['rate_types'])->find($value);
        $this->rates = $this->room_type->rate_types ?? collect();
        $this->updateRooms();
        if ($this->room_type->rate_types->count() < 1) {
            $this->emit('showError', "There are no rate types associated with this room!");
        }
    }

    public function getChargeDate($value)
    {
        $rate_type = getHotelSettings()->rate_types()->find($value);
        if (!$rate_type) {
            $this->emit('showError', "Unknown rate type selected!");
        }
        $bookingDate = $this->reservation->booking_date;
        $arrivalDate = $this->reservation->check_in;
        $daysDiff = Carbon::parse($bookingDate)->diffInDays(Carbon::parse($arrivalDate));
        if ($rate_type->prepayment > 0) {
            $chargeDate = $this->reservation->booking_date;
        } else {
            if ($rate_type->charge > 0) {
                if ($daysDiff >= $rate_type->reservation_charge_days) {
                    $chargeDate = Carbon::parse($arrivalDate)->subDays($rate_type->reservation_charge_days)->toDateString();
                } else {
                    $chargeDate = $bookingDate;
                }
            } else {
                if ($daysDiff >= $rate_type->reservation_charge_days_2) {
                    $chargeDate = Carbon::parse($arrivalDate)->subDays($rate_type->reservation_charge_days_2)->toDateString();
                } else {
                    $chargeDate = $bookingDate;
                }
            }
        }
        $this->reservation->charge_date = $chargeDate;
    }

    public function checkoutChanged()
    {
        $this->daily_rates = [];
        $this->addError('daily_rates', 'The Daily Rates field is invalid.');
        $this->validate([
            'reservation.check_in' => 'required|before_or_equal:' . $this->reservation->check_out,
        ]);
        $check_in = Carbon::parse($this->reservation->check_in);
        $check_out = Carbon::parse($this->reservation->check_out);
        $this->reservation->nights = $check_out->diff($check_in)->days;
        while ($check_in < $check_out) {
            $this->daily_rates[] = ['date' => $check_in->toDateString(), 'price' => null];
            $check_in = $check_in->addDay();
        }
        $this->updateRooms();
    }

   
    public function storeReservation()
    {
        $this->validate([
            'reservation.booking_agency_id' => 'required',
            'reservation.booking_code' => 'required',
            'reservation.booking_date' => 'required',
            'reservation.check_in' => 'required|date|after_or_equal:reservation.booking_date',
            'reservation.check_out' => 'required',
            'reservation.country_id' => 'required',
            'reservation.company_id' => 'nullable',
            'reservation.channex_status' => 'required',
            'reservation.adults' => 'required',
            'reservation.kids' => 'required',
            'reservation.infants' => 'required',
            'reservation.room_id' => 'required',
            'reservation.rate_type_id' => 'required',
            'reservation.charge_date' => 'required',
            'reservation.payment_method_id' => 'required',
            'reservation.payment_mode_id' => 'required',
            'reservation.status' => 'required',
            'reservation.comment' => 'nullable',
            'guest.full_name' => 'required',
            'guest.email' => 'required',
            'guest.phone' => 'required',
        ]);

        $available = Availability::whereBetween('date', [$this->reservation->check_in, Carbon::parse($this->reservation->check_out)->subDay()->format('Y-m-d')])
            ->where('room_id', $this->reservation->room_id);
        if ($this->editing) {
            $available = $available->where('reservation_id', '!=', $this->reservation->id);
        }
        if ($available->count() > 0) {
            $this->emit('showWarning', 'This reservation overlaps with an existing reservation');
        } else {
            try {
                DB::beginTransaction();
                $fulldata=[];
                $property=getHotelSettings()->active_property();
                $getExistingReservation=Reservation::where('id', $this->reservation)->first();
                if ($getExistingReservation && $property) {
                    $starts=$getExistingReservation->arrival_date;
                    while ($starts<$getExistingReservation->departure_date) {
                        // add channel manager availability
                        $availability=getAvailability($getExistingReservation->room->room_type, $starts);
                    
                        $innerdata=[
                    
                            "property_id"=> $property->property_id,
                            "room_type_id"=> $getExistingReservation->room->room_type->channex_room_type_id,
                            "date"=> $starts,
                            "availability"=> (int) $availability
                            
                            ];
                            array_unshift($fulldata, $innerdata);

                            $starts=Carbon::parse($starts)->addDay()->toDateString();
                    }
                }
                

                $this->guest->hotel_settings_id = getHotelSettings()->id;
                $this->guest->country_id = $this->reservation->country_id;
                $this->guest->save();
                $this->reservation->hotel_settings_id = getHotelSettings()->id;
                $this->reservation->arrival_date = $this->reservation->check_in;
                $this->reservation->departure_date = $this->reservation->check_out;
                $this->reservation->discount = 0;
                $this->reservation->overnights = Carbon::parse($this->reservation->check_out)->diffInDays($this->reservation->check_in);
                if($this->reservation->status == "Arrived") {
                    $this->reservation->actual_checkin = $this->reservation->check_in;
                }
                if($this->reservation->status == "CheckedOut") {
                    $this->reservation->actual_checkin = $this->reservation->check_in;
                    $this->reservation->actual_checkout = $this->reservation->check_out;
                }
                if($this->reservation->status == "Cancelled") {
                    $this->reservation->cancellation_date = today()->toDateString();
                }
                $this->reservation->guest_id = $this->guest->id;
                $this->reservation->reservation_amount = collect($this->daily_rates)->sum('price');
                $this->reservation->save();


                foreach ($this->daily_rates as $rate) {
                    DailyRate::updateOrCreate([
                        'reservation_id' => $this->reservation->id,
                        'date' => $rate['date'],
                    ], [
                        'reservation_id' => $this->reservation->id,
                        'date' => $rate['date'],
                        'price' => $rate['price'],
                    ]);
                }

                $check_in = $this->reservation->check_in;
                $check_out = $this->reservation->check_out;
                $this->reservation->availabilities()->delete();
                $totalRooms=Room::where('status', 'Enabled')->where('room_type_id', $this->reservation->room->room_type->id)->count();
                if($this->reservation->status !== "Cancelled"){
                    while ($check_in < $check_out) {
                            Availability::create([
                            'reservation_id' => $this->reservation->id,
                            'room_type_id' => $this->room_type->id,
                            'room_id' => $this->reservation->room_id,
                            'date' => $check_in,
                        ]);

                        
                        $check_in = Carbon::parse($check_in)->addDay()->toDateString();
                    }
                }
                DB::commit();

                $check_in = $this->reservation->check_in;
                $check_out = $this->reservation->check_out;
                
                while ($check_in < $check_out) {
                   
                 // add channel manager availability
                 if ($property) {
                    $availability=getAvailability($this->reservation->room->room_type, $check_in);
            
                    $innerdata=[
                
                        "property_id"=> $property->property_id,
                        "room_type_id"=> $this->reservation->room->room_type->channex_room_type_id,
                        "date"=> $check_in,
                        "availability"=> (int) $availability
                        
                        ];
                        array_unshift($fulldata, $innerdata);
                 }
                
                $check_in = Carbon::parse($check_in)->addDay()->toDateString();
            }

                try {
                    // send availability to channex............
                    $availabilityUrl = config('services.channex.api_base') . "/availability";
                    $availData=["values"=>$fulldata];
                    $client=new Client();
                    $client->post($availabilityUrl, [
                        'headers' => ['Content-Type' => 'application/json', 'user-api-key' => config('services.channex.api_key')],
                        'body' => json_encode($availData),
                    ]);
                } catch (\Throwable $th) {
                    // dd($th->getMessage());
                }

                
                if($this->reservation->status == 'Offer'){
                    $today=now();
                    $expiredate=Carbon::parse($this->reservation->offer_expire_date." 24:00:00");
                    $timeDifference=$today->diffInHours($expiredate);
                    if($timeDifference>72){
                        $expiredays=$this->reservation->offer_expire_date;
                      }else{
                        $expiredays=$timeDifference." hours";
                      }
                    $getStatusesAndValues = getStatusesAndValues($this->reservation->id);
                    $r_type = RoomType::where('id', $this->selected_room_type)->first();
                    $hotel_vat = DB::table('hotel_vats')->where('hotel_settings_id', getHotelSettings()->id)->first();
                    $hotel_vat_option = DB::table('vat_options')->where('id', $hotel_vat->vat_option_id)->first();
                    $RateType_n = RateType::where('room_type_id', $this->selected_room_type)->first();
                    $data_array['reservation'] = $this->reservation;
                    $data_array['guest'] = $this->reservation->guest;
                    $data_array['nights'] = Carbon::parse($this->reservation->check_out)->diffInDays($this->reservation->check_in);
                    $data_array['hotel_details'] = getHotelSettings();
                    $data_array['accept_url'] = url('/guest_confirmation/accept/'.$this->reservation->id);
                    $data_array['reject_url'] = url('/guest_confirmation/reject/'.$this->reservation->id);
                    $data_array['total_price'] = showPriceWithCurrency($getStatusesAndValues['accom_total']);
                    $data_array['room_type'] = $r_type->name;
                    $data_array['vat'] = getHotelSettings()->vat_tax->vat_option->value;
                    $data_array['rateType'] = $RateType_n;
                    $data_array['expire']=$expiredays;

                      Mail::to($this->reservation->guest->email)->send(new NotifyReservationOffer($data_array));
                 }

                session()->flash('success', 'Reservation stored successfully!');
                $this->redirectRoute('calendar');
            } catch (\Exception $e) {
                $this->emit('showWarning', $e->getMessage());
            }
        }
    }

    public function setDailyRates()
    {
        if ($this->reservation->status == 'Complimentary') {
            $this->complimentary = true;
            for ($i = 0; $i < count($this->daily_rates); $i++) {
                $this->daily_rates[$i]['price'] = $this->complimentary_rate;
            }
        } else {
            $this->complimentary = false;
        }
    }

    public function submitOffer()
    {
        $this->validate(['reservation.offer_expire_date' => 'required']);
        $this->emit('dataSaved', 'Offer Expiry date added successfully');
    }

    public function saveAccommodationPayment()
    {
        $balance = getStatusesAndValues($this->reservation->id)['accom_charge'];
        $this->validate([
            "accom_value" => "required|min:1|gt:0|lte:".$balance,
            "accom_payment_date" => "required",
            "accom_payment_method" => "required",
            "transaction_id" => "required",
        ],[
            'accom_value.required'=>'Payment amount is required',
            'accom_value.gt'=>'Payment amount must be greater than zero',
            'accom_value.lt'=>"You can't charge more than guest balance",
        ]);
        // $balance = getStatusesAndValues($this->reservation->id)['accom_charge'];
        // if ($balance == 0) {
        //     $this->emit('showWarning', 'Accommodation Balance Is zero. You can not charge any more money');
        // } else if ($this->accom_value > $balance) {
        //     $this->emit('showWarning', 'Guests Balance is less than the given amount.');
        // } else {
            GuestAccommodationPayment::create([
                'value' => $this->accom_value,
                'date' => $this->accom_payment_date,
                'transaction_id' => $this->transaction_id,
                'is_deposit' => $this->accom_is_deposit,
                'payment_method_id' => $this->accom_payment_method,
                'reservation_id' => $this->reservation->id,
            ]);
            $this->emit('dataSaved', 'Payment was made successfully.');
        // }
    }

    public function updateRooms()
    {
        $this->rooms = Room::query();
        if ($this->reservation->check_in && $this->reservation->check_out) {
            $taken_rooms = Availability::whereBetween('date', [$this->reservation->check_in, $this->reservation->check_out])->pluck('room_id')->unique();

            if($this->editing){
                $new_checkin = Carbon::parse($this->reservation->check_in)->setTimeFromTimeString("00:00:00");
                $new_checkout = Carbon::parse($this->reservation->check_out)->setTimeFromTimeString("23:59:59");
                $org_checkin = Carbon::parse($this->org_reservation->check_in)->setTimeFromTimeString("00:00:00");
                $org_checkout = Carbon::parse($this->org_reservation->check_out)->setTimeFromTimeString("23:59:59");

                if($org_checkin->gte($new_checkin) && $new_checkout->lte($org_checkout)){
                    $taken_rooms = $taken_rooms->filter(fn($value, $key) => $this->reservation->room_id != $value);
                }
            }
            $this->rooms = $this->rooms->whereNotIn('id', $taken_rooms);
        }
        if ($this->room_type) {
            $this->rooms = $this->rooms->where('room_type_id', $this->room_type->id);
        }
        $this->rooms = $this->rooms->get();
    }

    public function updatedSelectedTemplate()
    {
        $this->email_body = Template::find($this->selected_template)->fillTemplateContentBody($this->reservation->id);
    }

    public function updatedAttachment()
    {
        $this->validate([
            'attachment' => 'max:2048' //max 2mb file
        ]);
        $this->attachments += $this->attachment;
    }

    public function setAccomPayment()
    {
        $this->accom_value = getStatusesAndValues($this->reservation->id)['accom_charge'];
        $this->accom_payment_date = today()->toDateString();
        $this->accom_is_deposit = 0;
        $this->accom_payment_method = '';
        $this->transaction_id = '';
    }
    public function sendEmail()
    {
        $this->validate([
            'email_subject' => 'required',
            'selected_template' => 'required'
        ]);
        $file_paths = [];
        $index = 0;
        foreach ($this->attachments as $attachment) {
            $filename = 'email_attachment-' . $index . '-' . time() . '.' . $attachment->getClientOriginalExtension();
            $attachment->storeAs('uploads', $filename, 'public');
            $file_paths[] = asset('storage/uploads/' . $filename);
            $index++;
        }
        Mail::to($this->guest_email)->send(new NotifyReservationGuest($this->email_subject, $this->email_body, $file_paths));
        $this->emit('dataSaved', 'Email sent successfully');
    }
}

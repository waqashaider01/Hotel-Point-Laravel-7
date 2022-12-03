<?php

namespace App\Http\Livewire\Reservations;

use App\Models\Availability;
use App\Models\BookingAgency;
use App\Models\DailyRate;
use App\Models\Guest;
use App\Models\HotelSetting;
use App\Models\Maintenance;
use App\Models\RateType;
use App\Models\Reservation;
use App\Models\Restriction;
use App\Models\Room;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use GuzzleHttp\Client;
use Livewire\Component;

class Calendar extends Component
{
    protected $reservation_statuses = [
        'New',
        'Confirm',
        'Confirmed',
        'No Show',
        'Arrived',
        'CheckedOut',
        'Checked Out',
        'Complimentary',
        'Offer'
    ];
    public Carbon $start;
    public Carbon $end;
    public $text_dates = ['start' => '', 'end' => ''];
    public HotelSetting $hotel;
    public Collection $room_types;
    public array $months = [];
    public array $calendar_objects = [];

    // Reservation Modal Properties
    public string $active_tab = 'info';
    public Reservation $selected_reservation;
    public array $reservation_split = [
        'guest' => [
            'name' => '',
            'email' => '',
            'phone' => '',
        ],
        'new_room' => [
            'type' => '',
            'number' => '',
            'rate' => '',
            'checkin' => '',
        ],
        'rates' => [],
    ];
    public array $reservation_move = [
        'room' => '',
        'rate' => '',
        'rates' => [],
    ];
    public array $reservation_resize = [
        'checkin' => '',
        'checkout' => '',
        'rates' => [],
    ];

    // Out of Order Modal properties
    public bool $editingOutOfOrder = false;
    public Maintenance $selected_out_of_order;

    // Restriction Modal properties
    public $restriction_types = [
        "stop_sell" => "Stop Sell",
        "min_stay_arrival" => "Min Stay Arrival",
        "min_stay_through" => "Min Stay Through",
        "max_stay" => "Max Stay",
        "closed_to_arrival" => "Closed to Arrival",
        "closed_to_departure" => "Closed to Departure",
        "max_sell" => "Max Sell",
        "max_availability" => "Max Availability",
    ];
    public bool $editingRestriction = false;
    public Restriction $selected_restriction;

    // Room Info
    public array $room_info = [
        'room_number' => "00",
        'room_type' => 'NA',
        'occupancy_rate' => 0,
        'adr' => 0,
        'out_of_order' => 0,
        'accommodation_revenue' => 0,
        'extra_revenue' => 0,
        'overnight_tax_revenue' => 0,
        'commission' => 0,
        'guest_count' => [
            'adult' => 0,
            'kids' => 0,
            'infants' => 0
        ],
        'channel' => [
            'min' => 0,
            'max' => 0,
            'total'=>''
        ],
        'vat' => [
            'accommodation' => 0.00,
            'extra' => 0,
        ]
    ];

    protected $messages = [
        'text_dates.start.before_or_equal' => "The start date must be a date before or equal to end date.",
        'text_dates.end.after_or_equal' => "The end date must be a date after or equal to start date.",
    ];

    protected function rules()
    {
        return [
            'text_dates.start' => ['required', 'date', 'before_or_equal:text_dates.end'],
            'text_dates.end' => ['required', 'date', 'after_or_equal:text_dates.start'],
            'reservation_split.guest.name' => ['required', 'string', 'min:3', 'max:255'],
            'reservation_split.guest.email' => ['required', 'email', 'min:3', 'max:255'],
            'reservation_split.guest.phone' => ['required', 'string', 'min:3', 'max:255'],
            'reservation_split.new_room.type' => ['required', 'exists:room_types,id'],
            'reservation_split.new_room.number' => ['required', 'exists:rooms,id'],
            'reservation_split.new_room.rate' => ['required', 'exists:rate_types,id'],
            'reservation_split.new_room.checkin' => [
                'required',
                'date',
                'after:selected_reservation.checkin',
                'before:selected_reservation.check_out',
            ],
            'reservation_split.rates' => ['required', 'array', 'min:1'],
            'reservation_split.rates.*' => ['required', 'numeric', 'min:0'],
            'reservation_move.room' => ['required', 'exists:rooms,id'],
            'reservation_move.rate' => ['required', 'exists:rate_types,id'],
            'reservation_move.rates' => ['required', 'array', 'min:1'],
            'reservation_move.rates.*' => ['required', 'numeric', 'min:0'],
            'reservation_resize.checkin' => ['required', 'date', 'before_or_equal:reservation_resize.checkout'],
            'reservation_resize.checkout' => ['required', 'date', 'after_or_equal:reservation_resize.checkin'],
            'reservation_resize.rates' => ['required', 'array', 'min:1'],
            'reservation_resize.rates.*' => ['required', 'numeric', 'min:0'],
            'selected_out_of_order.room_id' => ['required', 'exists:rooms,id'],
            'selected_out_of_order.reason' => ['required', 'string', 'min:3', 'max:255'],
            'selected_out_of_order.start_date' => ['required', 'date', 'before_or_equal:selected_out_of_order.end_date'],
            'selected_out_of_order.end_date' => ['required', 'date', 'after_or_equal:selected_out_of_order.end_date'],
            'selected_out_of_order.status' => ['required', 'string', 'min:3', 'max:255'],
//             'selected_restriction.room_type_id' => ['required', 'exists:room_types,id'],
//             'selected_restriction.rate_type_id' => ['required', 'exists:rate_types,id'],
//             'selected_restriction.name' => ['required', 'string', Rule::in(array_keys($this->restriction_types))],
//             'selected_restriction.date' => ['required', 'date'],
        ];
    }

    public function mount()
    {
        $this->start = now()->setTimeFromTimeString("00:00:00");
        $this->end = now()->addMonth()->setTimeFromTimeString("23:59:59");
        $this->text_dates['start'] = $this->start->format('F j, Y');
        $this->text_dates['end'] = $this->end->format('F j, Y');
        $this->hotel = getHotelSettings();
        $this->room_types = $this->hotel->active_room_types()->with(['rooms', 'rate_types'])->orderBy('name')->get();
        $this->generateMonthsInfo();
        $this->generateCalendarObjects();

        // Reservation Modal property initialization
        $this->selected_reservation = new Reservation();

        // Out of Order Modal property initialization
        $this->selected_out_of_order = new Maintenance();

        // Restriction Modal property initialization
        $this->selected_restriction = new Restriction();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedTextDates()
    {
        $this->validateOnly('text_dates.start');
        $this->validateOnly('text_dates.end');
        $new_start = Carbon::parse($this->text_dates['start'])->setTimeFromTimeString("00:00:00");
        $new_end = Carbon::parse($this->text_dates['end'])->setTimeFromTimeString("23:59:59");
        if ($new_end->gte($new_start)) {
            $this->start = $new_start;
            $this->end = $new_end;
            $this->loadCalendar();
        }
    }


    public function render()
    {
        return view('livewire.reservations.calendar');
    }

    public function prev()
    {
        if ($this->end->lt($this->start)) {
            $temp = $this->end->copy();
            $this->end == $this->start->copy()->setTimeFromTimeString("00:00:00");
            $this->start == $temp->setTimeFromTimeString("23:59:59");
            $this->resetValidation();
        }
        $this->end = $this->start->copy()->setTimeFromTimeString("23:59:59");
        $this->start = $this->end->copy()->subMonth()->setTimeFromTimeString("00:00:00");
        $this->text_dates['start'] = $this->start->format('F j, Y');
        $this->text_dates['end'] = $this->end->format('F j, Y');
        $this->emit('updateFlatPicker', ".date-inputs.start-date", $this->text_dates['start'], "F j, Y");
        $this->emit('updateFlatPicker', ".date-inputs.end-date", $this->text_dates['end'], "F j, Y");
        $this->loadCalendar();
    }

    public function next()
    {
        if ($this->end->lt($this->start)) {
            $temp = $this->end->copy();
            $this->end == $this->start->copy()->setTimeFromTimeString("23:59:59");
            $this->start == $temp->setTimeFromTimeString("00:00:00");
            $this->resetValidation();
        }
        $this->start = $this->end->copy()->setTimeFromTimeString("00:00:00");
        $this->end = $this->start->copy()->addMonth()->setTimeFromTimeString("23:59:59");
        $this->text_dates['start'] = $this->start->format('F j, Y');
        $this->text_dates['end'] = $this->end->format('F j, Y');
        $this->emit('updateFlatPicker', ".date-inputs.start-date", $this->text_dates['start'], "F j, Y");
        $this->emit('updateFlatPicker', ".date-inputs.end-date", $this->text_dates['end'], "F j, Y");
        $this->loadCalendar();
    }

    public function loadCalendar()
    {
        $this->generateMonthsInfo();
        $this->generateCalendarObjects();
    }

    public function generateMonthsInfo()
    {
        $this->months = [];
        $period_date = $this->start->copy();
        while ($period_date->lte($this->end)) {
            $period_end = $period_date->copy()->endOfMonth();
            if ($this->end->lt($period_end)) {
                $period_end = $this->end->copy();
            }

            $this->months[] = [
                'name' => $period_date->format('F Y'),
                'start' => $period_date->copy(),
                'end' => $period_end->copy(),
                'span' => $period_end->diffInDays($period_date) + 1,
            ];

            $period_date->endOfMonth()->addDay();
        }
        $this->months[count($this->months) - 1]['span'] += 1;
    }

    public function generateCalendarObjects()
    {
        $this->calendar_objects = [];
        foreach ($this->room_types as $room_type) {
            // Calculates the availability for the room type
            for ($calendar_date = $this->start->copy(); $calendar_date->lte($this->end); $calendar_date->addDay()) {
                $this->calendar_objects[$room_type->id]['availability'][$calendar_date->format('Y-m-d')] = getAvailability($room_type, $calendar_date);
                $this->calendar_objects[$room_type->id]['restriction'][$calendar_date->format('Y-m-d')] = Restriction::with('rate_type')
                    ->where('room_type_id', $room_type->id)
                    ->whereDate('date', $calendar_date->format("Y-m-d"))
                    ->get();
            }

        //    dd($room_type->active_rooms);
            // Organization Reservations & Maintenance records
            foreach ($room_type->active_rooms as $room) {
                for ($calendar_date = $this->start->copy(); $calendar_date->lte($this->end); $calendar_date->addDay()) {

                    // Fetch Maintenance Record
                    $maintenance = Maintenance::where('room_id', $room->id)->whereDate('start_date', $calendar_date)->first();
                    if ($maintenance) {
                        $period = CarbonPeriod::since($maintenance->start_date, false)->days()->until($maintenance->end_date);
                        foreach ($period as $date) {
                            $this->calendar_objects[$room_type->id]['skip'][$room->id][$date->format('Y-m-d')] = true;
                        }
                        $this->calendar_objects[$room_type->id]['maintenance'][$room->id][$calendar_date->format('Y-m-d')] = $maintenance;
                    }

                    // Fetch Reservation Record
                    $reservation = Reservation::with(['guest'])->where('room_id', $room->id)
                        ->whereDate('check_in', $calendar_date)
                        ->whereIn('status', $this->reservation_statuses)
                        
                        ->first();

                    // Add the reservation into the system if it matches the date
                    if ($reservation) {
                        if ($reservation->arrival_date==$reservation->departure_date) {
                        
                        }else{
                        $period = CarbonPeriod::since($reservation->check_in, false)->days()->until($reservation->check_out, false);
                        foreach ($period as $date) {
                            $this->calendar_objects[$room_type->id]['skip'][$room->id][$date->format('Y-m-d')] = true;
                        }
                        $this->calendar_objects[$room_type->id]['reservations'][$room->id][$calendar_date->format('Y-m-d')] = $reservation;
                        }
                    } else {
                        // Only proceed if there is no reservation set for the current date
                        if(!isset($this->calendar_objects[$room_type->id]['reservations'][$room->id][$calendar_date->format('Y-m-d')])){
                            // Only proceed if the skip date is not set for the current date
                            if(!isset($this->calendar_objects[$room_type->id]['skip'][$room->id][$calendar_date->format('Y-m-d')])){
                                // Fetch a partial reservation for the record if the end date is before the start date of the calendar
                                $reservation = Reservation::with(['guest'])->where('room_id', $room->id)
                                ->whereDate('check_in', "<=", $calendar_date->format("Y-m-d"))
                                ->whereDate('check_out', ">", $calendar_date->format("Y-m-d"))
                                ->whereIn('status', $this->reservation_statuses)
                                ->first();

                                if($reservation){
                                    if ($reservation->arrival_date==$reservation->departure_date) {
                        
                                    }else{
                                    $period = CarbonPeriod::since($calendar_date, false)->days()->until($reservation->check_out, false);
                                    foreach ($period as $date) {
                                        $this->calendar_objects[$room_type->id]['skip'][$room->id][$date->format('Y-m-d')] = true;
                                    }
                                    $this->calendar_objects[$room_type->id]['reservations'][$room->id][$calendar_date->format('Y-m-d')] = $reservation;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

   

    public function changeReservationTab($tab = 'info', $selector = "#reservationInfo")
    {
        try {

            $this->active_tab = $tab;
            if($this->active_tab == 'split'){
                $this->fillReservationSplitArray();
            } else {
                $this->reset('reservation_split');
            }

            if($this->active_tab == 'move'){
                $this->fillReservationMoveArray();
            } else {
                $this->reset('reservation_move');
            }

            if($this->active_tab == 'resize'){
                $this->fillReservationResizeArray();
            } else {
                $this->reset('reservation_resize');
            }

            $this->emit('changeCollapse', $selector, 'show');
        } catch (\Exception $e){
            $this->emit('showSwal', "Error", $e->getMessage(), 'error');
        }
    }

    public function showReservation($id)
    {
        try {
            $this->selected_reservation = Reservation::with([
                'availabilities',
                'booking_agency',
                'daily_rates',
                'room',
                'guest',
                'checkin_guest',
                'rate_type',
                'payment_mode',
                'payment_method'
            ])->findOrFail($id);

            $this->changeReservationTab();
            $this->emit('showModal', "#reservationModal");
        } catch (\Exception $e) {
            $this->emit('showSwal', "Error", $e->getMessage(), 'error');
        }
    }

    public function fillReservationSplitArray()
    {
        $guest = $this->selected_reservation->checkin_guest ?? $this->selected_reservation->guest;
        if(!$guest){
            throw new \Exception("Guest information error for the reservation!", 1);
        }

        // Add reservation split array starting info
        $this->reservation_split['guest']['name'] = $guest->full_name;
        $this->reservation_split['guest']['email'] = $guest->email;
        $this->reservation_split['guest']['phone'] = $guest->phone;

        $this->reservation_split['new_room']['type'] = $this->selected_reservation->room->room_type_id;
        $this->reservation_split['new_room']['number'] = $this->selected_reservation->room_id;
        $this->reservation_split['new_room']['rate'] = $this->selected_reservation->rate_type_id;

        $checkin = Carbon::parse($this->selected_reservation->check_in);
        $checkout = Carbon::parse($this->selected_reservation->check_out);
        $days = $checkout->diffInDays($checkin);
        if($days < 2){
            $this->changeReservationTab();
            throw new \Exception("Reservation cannot be split!", 1);
        }
        $new_checkin = $checkin->addDays((int)$days/2);

        foreach ($this->selected_reservation->daily_rates as $rate) {
            if($new_checkin->lte(Carbon::parse($rate->date))){
                $this->reservation_split['rates'][$rate->date] = $rate->price;
            }
        }

        $this->reservation_split['new_room']['checkin'] = $checkin->format("F j, Y");
        $this->emit('updateFlatPicker', "#newRoomCheckin", $this->reservation_split['new_room']['checkin'], "F j, Y");
    }

    public function handleReservationSplit()
    {
        $this->validateOnly('reservation_split.*');
        try {
            DB::beginTransaction();
            $arrival_date = Carbon::parse($this->reservation_split['new_room']['checkin']);
            $departure_date = Carbon::parse($this->selected_reservation->check_out);

            // Validate Reservation
            $available = true;
            $availabilities = Availability::whereBetween('date', [$arrival_date, $departure_date])
                                ->where('room_id', $this->reservation_split['new_room']['number'])
                                ->where('room_id', '!=', $this->selected_reservation->room_id)
                                ->count();
            if ($availabilities > 0) {
                $available = false;
            }

            $maintenances = 0;
            if ($available) {
                $maintenances = Maintenance::where('room_id', $this->reservation_split['new_room']['number'])
                    ->where(function ($query) use ($arrival_date, $departure_date) {
                        $query->orWhere(function ($q1) use ($arrival_date, $departure_date) {
                            $q1->where('start_date', '>=', $arrival_date)
                                ->where('start_date', '<=', $departure_date);
                        })
                            ->orWhere(function ($q2) use ($arrival_date, $departure_date) {
                                $q2->where('start_date', '<=', $arrival_date)
                                    ->where('end_date', '>=', $arrival_date);
                            });
                    })
                    ->count();

                if ($maintenances > 0) {
                    $available = false;
                }
            }
            if(!$available){
                throw new \Exception("The selected Room is not available!", 1);

            }

            // Carbon Dates
            $new_checkin = Carbon::parse($this->reservation_split['new_room']['checkin']);

            // Clean Previous reservation Rates
            foreach ($this->selected_reservation->daily_rates as $rate) {
                if($new_checkin->lt(Carbon::parse($rate->date))){
                    $rate->delete();
                }
            }

            // Clean previous reservation availabilities
            foreach ($this->selected_reservation->availabilities as $availability) {
                if($new_checkin->lte(Carbon::parse($availability->date))){
                    $availability->delete();
                }
            }

            // Update the dates, amount & overnights for previous reservation
            $this->selected_reservation->reservation_amount = $this->selected_reservation->daily_rates()->sum('price');
            $this->selected_reservation->check_out = $new_checkin->format('Y-m-d');
            $this->selected_reservation->departure_date = $new_checkin->format('Y-m-d');
            $this->selected_reservation->overnights = $new_checkin->diffInDays(Carbon::parse($this->selected_reservation->check_in)) + 1;
            $this->selected_reservation->save();

            // Create new guest
            $guest = Guest::create([
                'hotel_settings_id' => $this->hotel->id,
                'full_name' => $this->reservation_split['guest']['name'],
                'email' => $this->reservation_split['guest']['email'],
                'phone' => $this->reservation_split['guest']['phone'],
                'country_id' => $this->selected_reservation->guest->country_id,
            ]);

            // Generate booking code
            $data = Reservation::where('booking_agency_id', $this->selected_reservation->booking_agency_id)
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

            // Create New Reservation
            $new_reservation = new Reservation();
            $new_reservation->hotel_settings_id = $this->hotel->id;
            $new_reservation->guest_id = $guest->id;
            $new_reservation->booking_code = $code;
            $new_reservation->channex_booking_id = $this->selected_reservation->channex_booking_id;
            $new_reservation->channex_status = $this->selected_reservation->channex_status;
            $new_reservation->status = $this->selected_reservation->status;
            $new_reservation->booking_agency_id = $this->selected_reservation->booking_agency_id;
            $new_reservation->charge_date = $this->selected_reservation->charge_date;
            $new_reservation->payment_method_id = $this->selected_reservation->payment_method_id;
            $new_reservation->payment_mode_id = $this->selected_reservation->payment_mode_id;
            $new_reservation->discount = $this->selected_reservation->discount;
            $new_reservation->check_in = $arrival_date->format('Y-m-d');
            $new_reservation->check_out = $departure_date->format('Y-m-d');
            $new_reservation->arrival_date = $arrival_date->format('Y-m-d');
            $new_reservation->departure_date = $departure_date->format('Y-m-d');
            $new_reservation->overnights = $departure_date->diffInDays($arrival_date) + 1;
            $new_reservation->arrival_hour = $this->selected_reservation->arrival_hour;
            $new_reservation->country_id = $this->selected_reservation->country_id;
            $new_reservation->adults = $this->selected_reservation->adults;
            $new_reservation->kids = $this->selected_reservation->kids;
            $new_reservation->infants = $this->selected_reservation->infants;
            $new_reservation->booking_date = $this->selected_reservation->booking_date;
            $new_reservation->comment = $this->selected_reservation->comment;
            $new_reservation->rate_type_id = $this->reservation_split['new_room']['rate'];
            $new_reservation->room_id = $this->reservation_split['new_room']['number'];
            $new_reservation->reservation_amount = collect(array_values($this->reservation_split['rates']))->sum();
            $new_reservation->reservation_inserted_at = $this->selected_reservation->reservation_inserted_at;
            $new_reservation->reservation_payment_collect = $this->selected_reservation->reservation_payment_collect;
            $new_reservation->save();

            foreach ($this->reservation_split['rates'] as $date => $cost) {
                DailyRate::create([
                    'reservation_id' => $new_reservation->id,
                    'date' => $date,
                    'price' => $cost
                ]);

                Availability::create([
                    'date' => $date,
                    'room_id' => $this->reservation_split['new_room']['number'],
                    'room_type_id' => $this->reservation_split['new_room']['type'],
                    'reservation_id' => $new_reservation->id,
                ]);
            }

            DB::commit();

            // update availability on channex.........
            if (getHotelSettings()->active_property()) {
                $fulldata=[];
                $start=$this->selected_reservation->check_in;
                while ($start<=$this->selected_reservation->check_out) {
                    $availability=getAvailability($this->selected_reservation->room->room_type, $start);
                    $innerdata=[
                        
                        "property_id"=> getHotelSettings()->active_property()->property_id,
                        "room_type_id"=> $this->selected_reservation->room->room_type->channex_room_type_id,
                        "date"=> $start,
                        "availability"=> (int) $availability
                        
                        ];
                        array_unshift($fulldata, $innerdata);

                        $start=Carbon::parse($start)->addDay()->toDateString();
                }

                $start=$new_reservation->check_in;
                while ($start<=$new_reservation->check_out) {
                    $availability=getAvailability($new_reservation->room->room_type, $start);
                    $innerdata=[
                        
                        "property_id"=> getHotelSettings()->active_property()->property_id,
                        "room_type_id"=> $new_reservation->room->room_type->channex_room_type_id,
                        "date"=> $start,
                        "availability"=> (int) $availability
                        
                        ];
                        array_unshift($fulldata, $innerdata);

                        $start=Carbon::parse($start)->addDay()->toDateString();
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
            }
           
            $this->loadCalendar();
            $this->changeReservationTab();
            $this->emit('hideModal', '#reservationModal');
            $this->emit('showSwal', "Success", "The reservation has been splitted successfully!", 'success');
        } catch (\Exception $e){
            $this->selected_reservation = Reservation::find($this->selected_reservation->id);
            $this->changeReservationTab('split', '#reservationSplit');
            $this->emit('showSwal', "Error", $e->getMessage(), 'error');
        }
    }

    public function fillReservationMoveArray()
    {
        $this->reservation_move['room'] = $this->selected_reservation->room_id;
        $this->reservation_move['rate'] = $this->selected_reservation->rate_type_id;

        foreach ($this->selected_reservation->daily_rates as $rate) {
            $this->reservation_move['rates'][$rate->date] = $rate->price;
        }
    }

    public function handleReservationMove()
    {
        $this->validateOnly('reservation_move.*');
        try {
            DB::beginTransaction();
            $room = Room::findOrFail($this->reservation_move['room']);
            $previosRoomType=$this->selected_reservation->room->room_type;

            $arrival_date = Carbon::parse($this->selected_reservation->check_in);
            $departure_date = Carbon::parse($this->selected_reservation->check_out);

            // Validate Reservation
            $available = true;
            $availabilities = Availability::whereBetween('date', [$arrival_date, $departure_date])
                                ->where('room_id', $room->id)
                                ->where('room_id', '!=', $this->selected_reservation->room_id)
                                ->count();
            if ($availabilities > 0) {
                $available = false;
            }

            $maintenances = 0;
            if ($available) {
                $maintenances = Maintenance::where('room_id', $room->id)
                    ->where(function ($query) use ($arrival_date, $departure_date) {
                        $query->orWhere(function ($q1) use ($arrival_date, $departure_date) {
                            $q1->where('start_date', '>=', $arrival_date)
                                ->where('start_date', '<=', $departure_date);
                        })
                            ->orWhere(function ($q2) use ($arrival_date, $departure_date) {
                                $q2->where('start_date', '<=', $arrival_date)
                                    ->where('end_date', '>=', $arrival_date);
                            });
                    })
                    ->count();

                if ($maintenances > 0) {
                    $available = false;
                }
            }
            if(!$available){
                throw new \Exception("The selected Room is not available!", 1);
            }
            
            // Update the room, rate & amount of reservation
            $this->selected_reservation->room_id = $this->reservation_move['room'];
            $this->selected_reservation->rate_type_id = $this->reservation_move['rate'];
            $this->selected_reservation->reservation_amount = collect(array_values($this->reservation_move['rates']))->sum();
            $this->selected_reservation->save();

            foreach($this->selected_reservation->daily_rates as $rate){
                $rate->update([
                    'price' => $this->reservation_move['rates'][$rate->date],
                ]);
            }

            foreach($this->selected_reservation->availabilities as $availability){
                $availability->update([
                    'room_id' => $this->reservation_move['room'],
                    'room_type_id' => $room->room_type_id,
                ]);
            }

            DB::commit();
            $room = Room::with(['room_type'])->findOrFail($this->reservation_move['room']);
            // update availability on channex.........
            if (getHotelSettings()->active_property()) {
                $fulldata=[];
                $start=$this->selected_reservation->check_in;
                while ($start<=$this->selected_reservation->check_out) {
                    $availability=getAvailability($room->room_type, $start);
                    $innerdata=[
                        
                        "property_id"=> getHotelSettings()->active_property()->property_id,
                        "room_type_id"=> $room->room_type->channex_room_type_id,
                        "date"=> $start,
                        "availability"=> (int) $availability
                        
                        ];
                        array_unshift($fulldata, $innerdata);
                    $preAvailability=getAvailability($previosRoomType, $start);
                    $innerdata=[
                            
                            "property_id"=> getHotelSettings()->active_property()->property_id,
                            "room_type_id"=> $previosRoomType->channex_room_type_id,
                            "date"=> $start,
                            "availability"=> (int) $preAvailability
                            
                            ];
                            array_unshift($fulldata, $innerdata);

                        $start=Carbon::parse($start)->addDay()->toDateString();
                }

                try {
                    // send availability to channex............
                    $availabilityUrl = config('services.channex.api_base') . "/availability";
                    $availData=["values"=>$fulldata];
                    // dd($availData);
                    $client=new Client();
                    $client->post($availabilityUrl, [
                        'headers' => ['Content-Type' => 'application/json', 'user-api-key' => config('services.channex.api_key')],
                        'body' => json_encode($availData),
                    ]);
                } catch (\Throwable $th) {
                    dd($th->getMessage());
                }
            }
            $this->loadCalendar();
            $this->changeReservationTab();
            $this->emit('hideModal', '#reservationModal');
            $this->emit('showSwal', "Success", "The reservation has been moved successfully!", 'success');
        } catch (\Exception $e){
            $this->selected_reservation = Reservation::find($this->selected_reservation->id);
            $this->changeReservationTab('move', '#reservationMove');
            $this->emit('showSwal', "Error", $e->getMessage(), 'error');
        }
    }

    public function fillReservationResizeArray()
    {
        $this->reservation_resize['checkin'] = Carbon::parse($this->selected_reservation->check_in)->format('F j, Y');
        $this->reservation_resize['checkout'] = Carbon::parse($this->selected_reservation->check_out)->format('F j, Y');
        $this->emit('updateFlatPicker', "#resizeCheckin", $this->reservation_resize['checkin'], "F j, Y");
        $this->emit('updateFlatPicker', "#resizeCheckout", $this->reservation_resize['checkout'], "F j, Y");

        foreach ($this->selected_reservation->daily_rates as $rate) {
            $this->reservation_resize['rates'][$rate->date] = $rate->price;
        }
    }

    public function handleReservationResize()
    {
        
        $this->validateOnly('reservation_resize.*');
        try {
            DB::beginTransaction();
            $arrival_date = Carbon::parse($this->selected_reservation->check_in);
            $departure_date = Carbon::parse($this->reservation_resize['checkout']);
            $newDeparture=$departure_date->copy()->toDateString();
            if ($newDeparture>$this->selected_reservation->check_out) {
                $newcheckout=$newDeparture;
            }else{
                $newcheckout=$this->selected_reservation->check_out;
            }

            // Validate Reservation
            $available = true;
            $availabilities = Availability::whereBetween('date', [$arrival_date, $departure_date])
                                ->where('room_id', $this->selected_reservation->room_id)
                                ->where('room_id', '!=', $this->selected_reservation->room_id)
                                ->count();
            if ($availabilities > 0) {
                $available = false;
            }

            $maintenances = 0;
            if ($available) {
                $maintenances = Maintenance::where('room_id', $this->selected_reservation->room_id)
                    ->where(function ($query) use ($arrival_date, $departure_date) {
                        $query->orWhere(function ($q1) use ($arrival_date, $departure_date) {
                            $q1->where('start_date', '>=', $arrival_date)
                                ->where('start_date', '<=', $departure_date);
                        })
                            ->orWhere(function ($q2) use ($arrival_date, $departure_date) {
                                $q2->where('start_date', '<=', $arrival_date)
                                    ->where('end_date', '>=', $arrival_date);
                            });
                    })
                    ->count();

                if ($maintenances > 0) {
                    $available = false;
                }
            }
            if(!$available){
                throw new \Exception("The selected Room is not available for extension!", 1);
            }

            $rates = [];
            // clear reservation rate
            for ($loop_date = $arrival_date->copy(); $departure_date->gt($loop_date); $loop_date->addDay()) {
                $rates[$loop_date->format('Y-m-d')] = $this->reservation_resize['rates'][$loop_date->format('Y-m-d')];
            }
            $this->reservation_resize['rates'] = $rates;

            // Update the rates
            $this->selected_reservation->check_out = $departure_date->format('Y-m-d');
            $this->selected_reservation->departure_date = $departure_date->format('Y-m-d');
            $this->selected_reservation->overnights = $departure_date->addDay()->diffInDays($arrival_date);
            $this->selected_reservation->reservation_amount = collect(array_values($this->reservation_resize['rates']))->sum();
            $this->selected_reservation->save();

            foreach($this->reservation_resize['rates'] as $date => $rate){
                DailyRate::updateOrCreate([
                    'reservation_id' => $this->selected_reservation->id,
                    'date' => $date,
                ],[
                    'reservation_id' => $this->selected_reservation->id,
                    'date' => $date,
                    'price' => $rate,
                ]);

                Availability::updateOrCreate([
                    'reservation_id' => $this->selected_reservation->id,
                    'date' => $date,
                ],[
                    'reservation_id' => $this->selected_reservation->id,
                    'date' => $date,
                    'room_id' => $this->selected_reservation->room_id,
                    'room_type_id' => $this->selected_reservation->room->room_type_id,
                ]);
            }

            $this->selected_reservation->daily_rates()->whereNotIn('date', array_keys($this->reservation_resize['rates']))->delete();
            $this->selected_reservation->availabilities()->whereNotIn('date', array_keys($this->reservation_resize['rates']))->delete();

            DB::commit();
             // update availability on channex.........
             if (getHotelSettings()->active_property()) {
                $fulldata=[];
                $start=$this->selected_reservation->check_in;
                while ($start<=$newcheckout) {
                    $availability=getAvailability($this->selected_reservation->room->room_type, $start);
                    $innerdata=[
                        
                        "property_id"=> getHotelSettings()->active_property()->property_id,
                        "room_type_id"=> $this->selected_reservation->room->room_type->channex_room_type_id,
                        "date"=> $start,
                        "availability"=> (int) $availability
                        
                        ];
                        array_unshift($fulldata, $innerdata);

                        $start=Carbon::parse($start)->addDay()->toDateString();
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
            }
            // dd($newcheckout);
            $this->loadCalendar();
            $this->changeReservationTab();
            $this->emit('hideModal', '#reservationModal');
            $this->emit('showSwal', "Success", "The reservation has been resized successfully!", 'success');
        } catch (\Exception $e){
            $this->selected_reservation = Reservation::find($this->selected_reservation->id);
            $this->changeReservationTab('resize', '#reservationResize');
            $this->emit('showSwal', "Error", $e->getMessage(), 'error');
        }
    }

    public function showRoomInfo($id)
    {
        try {
            $start_date = $this->start->copy();
            $end_date = $this->end->copy();

            $room = Room::with(['room_type'])->findOrFail($id);


            $occupied = Availability::where('room_id', $room->id)->whereBetween('date', [$start_date, $end_date])->count();
            $reservations = Reservation::where('room_id', $room->id)
            ->where('status', '!=', 'Cancelled')
                ->where(function ($query) use ($start_date, $end_date) {
                    $query->orWhere(function ($q1) use ($start_date, $end_date) {
                        $q1->where('check_in', '>=', $start_date)
                            ->where('check_in', '<=', $end_date);
                    })
                        ->orWhere(function ($q2) use ($start_date, $end_date) {
                            $q2->where('check_in', '<=', $start_date)
                                ->where('check_out', '>=', $start_date);
                        });
                })->get();

            $daily_rates = DailyRate::whereIn('reservation_id', $reservations->pluck('id'))->whereBetween('date', [$start_date, $end_date]);
            $total_daily_rates = $daily_rates->sum('price');
            $adr_occupied = $daily_rates->count();
            if ($adr_occupied < 1) {
                $adr_occupied = 1;
            }

            $this->room_info['room_number'] = $room->number;
            $this->room_info['room_type'] = $room->room_type->name;
            $this->room_info['occupancy_rate'] = ($occupied / ($end_date->diffInDays($start_date) + 1)) * 100;
            $this->room_info['adr'] = $total_daily_rates / $adr_occupied;
            $this->room_info['out_of_order'] = Maintenance::where('room_id', $room->id)
                ->where(function ($query) use ($start_date, $end_date) {
                    $query->orWhere(function ($q1) use ($start_date, $end_date) {
                        $q1->where('start_date', '>=', $start_date)
                            ->where('start_date', '<=', $end_date);
                    })
                        ->orWhere(function ($q2) use ($start_date, $end_date) {
                            $q2->where('start_date', '<=', $start_date)
                                ->where('end_date', '>=', $start_date);
                        });
                })->get(['start_date', 'end_date'])->map(function ($item) {
                    $start = Carbon::parse($item->start_date);
                    $end = Carbon::parse($item->end_date);
                    return $end->diffInDays($start) + 1;
                })->sum();
            $hotelvat=$this->hotel->vat_tax->vat_option->value/100;
            $this->room_info['accommodation_revenue'] = $total_daily_rates / (1 +$hotelvat );
            $this->room_info['commission'] = $reservations->sum('commission_amount');
            $this->room_info['guest_count'] = [
                'adult' => $reservations->sum('adults'),
                'kids' => $reservations->sum('kids'),
                'infants' => $reservations->sum('infants')
            ];

            $totalNetExtraRevenue=0;
            $totalExtraVAt=0;
            $getEtras=getHotelSettings()->reservations()->join('reservation_extra_charges', 'reservation_extra_charges.reservation_id', '=', 'reservations.id')
                                                         ->join('extra_charges', 'reservation_extra_charges.extra_charge_id', '=', 'extra_charges.id')
                                                         ->selectRaw('SUM(reservation_extra_charges.extra_charge_total) as totalAmount, extra_charges.vat as chargeVat, extra_charges.id')->where('reservations.room_id', $room->id)->whereBetween('reservation_extra_charges.date', [$start_date, $end_date])->groupBy(['extra_charges.id', 'extra_charges.vat'])->get();
            foreach ($getEtras as $extras) {
                $grossAmount=$extras['totalAmount'];
                $servicevat=$extras['chargeVat'];
                $netAmount=(float)$grossAmount/(1+($servicevat/100));
                $netAmount=number_format($netAmount, 2);
                $extraVAt=$grossAmount-$netAmount;
                $totalNetExtraRevenue+=$netAmount;
                $totalExtraVAt+=$extraVAt;
            }
                                                         
            $this->room_info['extra_revenue'] = $totalNetExtraRevenue;
            $maxdata='';
            $getBookingMax=Availability::join('reservations', 'reservations.id', '=', 'availabilities.reservation_id')->join('booking_agencies', 'booking_agencies.id', '=', 'reservations.booking_agency_id')->where('availabilities.room_id', $room->id)->whereBetween('availabilities.date', [$start_date, $end_date])->selectRaw('booking_agencies.id, booking_agencies.name, count(*) as total')->groupBy(['booking_agencies.id', 'booking_agencies.name'])->get();
            if (count($getBookingMax)>0) {
                foreach ($getBookingMax as $max) {
                    $maxdata.="<div><span class='mr-5'>".$max['name']." </span> <span class='mr-5'>".$max['total']."/".$occupied.
                    "</span></div>";
                }
            }else{
                $maxdata="0/".$occupied;
            }
            
            // dd($getBooking);
            $this->room_info['channel'] = [
                'min' => $reservations->pluck('booking_agency_id')->unique()->count(),
                'max' => BookingAgency::where('hotel_settings_id', $room->room_type->hotel_settings_id)->count(),
                'total'=>$maxdata,
            ];
            $this->room_info['vat'] = [
                'accommodation' => $total_daily_rates - $this->room_info['accommodation_revenue'],
                'extra' => $totalExtraVAt,
            ];

            // overnight tax revenue
            $overnightTaxRevenue=$occupied*$this->hotel->overnight_tax->tax;
            $this->room_info['overnight_tax_revenue']=$overnightTaxRevenue;

            $this->emit('showModal', '#roomInfoModal');
        } catch (\Exception $e) {
            $this->emit('showSwal', "Error", $e->getMessage(), 'error');
        }
    }

    public function newOutOfOrder()
    {
        $this->editingOutOfOrder = false;
        $this->selected_out_of_order = new Maintenance(['start_date' => now()->format('F j, Y'), 'end_date' => now()->addDay()->format('F j, Y')]);
        $this->emit('updateFlatPicker', "#outOfOrderStartDate", $this->selected_out_of_order->start_date, "F j, Y");
        $this->emit('updateFlatPicker', "#outOfOrderEndDate", $this->selected_out_of_order->end_date, "F j, Y");
        $this->emit('showModal', '#outOfOrderModal');
    }

    public function modifyOutOfOrder($id)
    {
        try {
            $this->selected_out_of_order = Maintenance::findOrFail($id);
            $this->selected_out_of_order->start_date = Carbon::parse($this->selected_out_of_order->start_date)->format('F j, Y');
            $this->selected_out_of_order->end_date = Carbon::parse($this->selected_out_of_order->end_date)->format('F j, Y');
            $this->editingOutOfOrder = true;

            $this->emit('updateFlatPicker', "#outOfOrderStartDate", $this->selected_out_of_order->start_date, "F j, Y");
            $this->emit('updateFlatPicker', "#outOfOrderEndDate", $this->selected_out_of_order->end_date, "F j, Y");
            $this->emit('showModal', '#outOfOrderModal');
        } catch (\Exception $e) {
            $this->emit('showError', $e->getMessage());
        }
    }

    public function deleteOutOfOrder($id)
    {
        try {
            $outofOrder=Maintenance::findOrFail($id);
            $outofOrder->delete();
            // update availability on channex.........
            if (getHotelSettings()->active_property()) {
                $fulldata=[];
                $room=Room::where('id', $outofOrder->room_id)->first();
                $start=$outofOrder->start_date;
                while ($start<=$outofOrder->end_date) {
                    $availability=getAvailability($room->room_type, $start);
                    $innerdata=[
                        
                        "property_id"=> getHotelSettings()->active_property()->property_id,
                        "room_type_id"=> $room->room_type->channex_room_type_id,
                        "date"=> $start,
                        "availability"=> (int) $availability
                        
                        ];
                        array_unshift($fulldata, $innerdata);
                        $start=Carbon::parse($start)->addDay()->toDateString();
                    
                }
                
                try {
                    // send availability to channex............
                    $availabilityUrl = config('services.channex.api_base') . "/availability";
                    $availData=["values"=>$fulldata];
                    // dd($availData);
                    $client=new Client();
                    $client->post($availabilityUrl, [
                        'headers' => ['Content-Type' => 'application/json', 'user-api-key' => config('services.channex.api_key')],
                        'body' => json_encode($availData),
                    ]);
                } catch (\Throwable $th) {
                   $this->emit('error', "Couldn't update availability on Channel Manager");
                }
            }

            
            
            $this->selected_out_of_order = new Maintenance(['start_date' => now()->format('F j, Y'), 'end_date' => now()->addDay()->format('F j, Y')]);
            $this->editingOutOfOrder = false;
            $this->loadCalendar();
            $this->emit('hideModal', "#outOfOrderModal");
            $this->emit('showSwal', "Success", "Out of Order deleted successfully!", 'success');
        } catch (\Exception $e) {
            $this->emit('showSwal', "Error", $e->getMessage(), 'error');
        }
    }

    public function saveOutOfOrder()
    {
        try {
            $this->validateOnly('selected_out_of_order');
            $start_date = Carbon::parse($this->selected_out_of_order->start_date);
            $end_date = Carbon::parse($this->selected_out_of_order->end_date);

            // Check Availability
            $availability = Availability::whereBetween('date', [$start_date, $end_date])
                ->where('room_id', $this->selected_out_of_order->room_id)->count();
            if ($availability > 0) {
                throw new \Exception("The out of order overlaps with a reservation on this room!", 1);
            }

            // Check Overlap with another out of order
            $maintenance = Maintenance::where('room_id', $this->selected_out_of_order->room_id)
                ->where(function ($query) use ($start_date, $end_date) {
                    $query->orWhere(function ($q1) use ($start_date, $end_date) {
                        $q1->where('start_date', '>=', $start_date)
                            ->where('start_date', '<=', $end_date);
                    })
                        ->orWhere(function ($q2) use ($start_date, $end_date) {
                            $q2->where('start_date', '<=', $start_date)
                                ->where('end_date', '>=', $start_date);
                        });
                });
            if ($this->editingOutOfOrder) {
                $maintenance = $maintenance->where('id', '!=', $this->selected_out_of_order->id);
            }

            $maintenance = $maintenance->count();

            if ($maintenance > 0) {
                throw new \Exception("The out of order overlaps with another out of order record!", 1);
            }

                $previosOutOfOrder=Maintenance::where('id', $this->selected_out_of_order->id)->first();
            
            $this->selected_out_of_order->start_date = $start_date->format('Y-m-d');
            $this->selected_out_of_order->end_date = $end_date->format('Y-m-d');
            $this->selected_out_of_order->ids = 'a1';
            $this->selected_out_of_order->status = 'true';
            $this->selected_out_of_order->save();
            $message = "Out of Order saved successfully!";
            if ($this->editingOutOfOrder) {
                $message = "Out of Order updated successfully!";
            }
            // update availability on channex.........
            if (getHotelSettings()->active_property()) {
                $fulldata=[];
                $room=Room::where('id', $this->selected_out_of_order->room_id)->first();
                $start=$this->selected_out_of_order->start_date;
                while ($start<=$this->selected_out_of_order->end_date) {
                    $availability=getAvailability($room->room_type, $start);
                    $innerdata=[
                        
                        "property_id"=> getHotelSettings()->active_property()->property_id,
                        "room_type_id"=> $room->room_type->channex_room_type_id,
                        "date"=> $start,
                        "availability"=> (int) $availability
                        
                        ];
                        array_unshift($fulldata, $innerdata);
                        $start=Carbon::parse($start)->addDay()->toDateString();
                    
                }
                if ($this->editingOutOfOrder && $previosOutOfOrder) {
                    $previosRoom=Room::where('id', $previosOutOfOrder->room_id)->first();
                    $start=$previosOutOfOrder->start_date;
                    while ($start <= $previosOutOfOrder->end_date) {
                        $preAvailability=getAvailability($previosRoom->room_type, $start);
                        $innerdata=[
                                
                                "property_id"=> getHotelSettings()->active_property()->property_id,
                                "room_type_id"=> $previosRoom->room_type->channex_room_type_id,
                                "date"=> $start,
                                "availability"=> (int) $preAvailability
                                
                                ];
                                array_unshift($fulldata, $innerdata);

                            $start=Carbon::parse($start)->addDay()->toDateString();
                    }
                }
                

                try {
                    // send availability to channex............
                    $availabilityUrl = config('services.channex.api_base') . "/availability";
                    $availData=["values"=>$fulldata];
                    // dd($availData);
                    $client=new Client();
                    $client->post($availabilityUrl, [
                        'headers' => ['Content-Type' => 'application/json', 'user-api-key' => config('services.channex.api_key')],
                        'body' => json_encode($availData),
                    ]);
                } catch (\Throwable $th) {
                    dd($th->getMessage());
                }
            }

            $this->editingOutOfOrder = false;
            $this->loadCalendar();
            $this->emit('hideModal', "#outOfOrderModal");
            $this->emit('showSwal', "Success", $message, 'success');
        } catch (\Exception $e) {
            $this->emit('showSwal', "Error", $e->getMessage(), 'error');
        }
    }

    public function newRestriction()
    {
        $this->editingRestriction = false;
        $this->selected_restriction = new Restriction(['date' => now()->format('F j, Y')]);
        $this->emit('updateFlatPicker', "#restrictionDate", $this->selected_restriction->date, "F j, Y");
        $this->emit('showModal', '#restrictionModal');
    }

    public function modifyRestriction($id)
    {
        try {
            $this->selected_restriction = Restriction::findOrFail($id);
            $this->selected_restriction->date = Carbon::parse($this->selected_restriction->date)->format('F j, Y');
            $this->editingRestriction = true;

            $this->emit('updateFlatPicker', "#restrictionDate", $this->selected_restriction->date, "F j, Y");
            $this->emit('showModal', '#restrictionModal');
        } catch (\Exception $e) {
            $this->emit('showError', $e->getMessage());
        }
    }

    public function deleteRestriction($id)
    {
        try {
            Restriction::findOrFail($id)->delete();
            $this->selected_restriction = new Restriction(['date' => now()->format('F j, Y')]);
            $this->editingRestriction = false;
            $this->loadCalendar();
            $this->emit('hideModal', "#restrictionModal");
            $this->emit('showSwal', "Success", "Restriction deleted successfully!", 'success');
        } catch (\Exception $e) {
            $this->emit('showSwal', "Error", $e->getMessage(), 'error');
        }
    }

    public function saveRestriction()
    {
        try {
            $this->validateOnly('selected_restriction');
            $start_date = Carbon::parse($this->selected_restriction->date);

            // Validate Restriction
            $restriction = Restriction::where('name', $this->selected_restriction->name)
                ->where('room_type_id', $this->selected_restriction->room_type_id)
                ->where('rate_type_id', $this->selected_restriction->rate_type_id)
                ->whereDate('date', $this->selected_restriction->date);

            if ($this->editingRestriction) {
                $restriction = $restriction->where('id', '!=', $this->selected_restriction->id);
            }
            $restriction = $restriction->count();

            if ($restriction > 0) {
                throw new \Exception("The restriction overlaps with another restriction record!", 1);
            }

            $this->selected_restriction->date = $start_date->format('Y-m-d');
            $this->selected_restriction->value = $this->restriction_types[$this->selected_restriction->name];
            $this->selected_restriction->save();
            $message = "Restriction saved successfully!";
            if ($this->editingRestriction) {
                $message = "Restriction updated successfully!";
            }

            $this->editingRestriction = false;
            $this->loadCalendar();
            $this->emit('initTooltip');
            $this->emit('hideModal', "#restrictionModal");
            $this->emit('showSwal', "Success", $message, 'success');
        } catch (\Exception $e) {
            $this->emit('showSwal', "Error", $e->getMessage(), 'error');
        }
    }
}

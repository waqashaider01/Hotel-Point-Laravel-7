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
use App\Models\RoomType;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class SuperCalendar extends Component
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
    public array $hotels;
    public Collection $room_types;
    public array $months = [];
    public array $calendar_objects = [];

    // Modal Properties
    public Reservation $selected_reservation;
    public Maintenance $selected_out_of_order;
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
            
        ];
    }

    public function mount()
    {
        $this->start = now()->setTimeFromTimeString("00:00:00");
        $this->end = now()->addMonth()->setTimeFromTimeString("23:59:59");
        $this->text_dates['start'] = $this->start->format('F j, Y');
        $this->text_dates['end'] = $this->end->format('F j, Y');

        /**
         * @var App\Models\User
         */
        $user = auth()->user();

        if($user->hasRole('Super Admin')){
            $this->hotels = HotelSetting::with(['owner'])
                                ->orderBy('name')
                                ->pluck('id')->toArray();
        } else if($user->role == 'Administrator'){
            $this->hotels = HotelSetting::with(['owner'])
                                ->where('created_by_id', $user->id)
                                ->orderBy('name')
                                ->pluck('id')->toArray();
        } else {
            $this->hotels = HotelSetting::with(['owner'])
                                ->where('created_by_id', $user->created_by_id->id)
                                ->orderBy('name')
                                ->pluck('id')->toArray();
        }

        $this->room_types = RoomType::with(['hotel_setting', 'rooms', 'rate_types'])->whereIn('hotel_settings_id', $this->hotels)->where('type_status', 1)->orderBy('hotel_settings_id')->orderBy('name')->get();
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
        return view('livewire.reservations.super-calendar');
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
                        $period = CarbonPeriod::since($reservation->check_in, false)->days()->until($reservation->check_out, false);
                        foreach ($period as $date) {
                            $this->calendar_objects[$room_type->id]['skip'][$room->id][$date->format('Y-m-d')] = true;
                        }
                        $this->calendar_objects[$room_type->id]['reservations'][$room->id][$calendar_date->format('Y-m-d')] = $reservation;
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

            $this->emit('showModal', "#reservationModal");
        } catch (\Exception $e) {
            $this->emit('showSwal', "Error", $e->getMessage(), 'error');
        }
    }

    public function showRoomInfo($id)
    {
        try {
            $start_date = $this->start->copy();
            $end_date = $this->end->copy();

            $room = Room::with(['room_type'])->findOrFail($id);
            $hotel=HotelSetting::where('id', $room->room_type->hotel_settings_id)->first();


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
            $hotelvat=$hotel->vat_tax->vat_option->value/100;
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
            $overnightTaxRevenue=$occupied*$hotel->overnight_tax->tax;
            $this->room_info['overnight_tax_revenue']=$overnightTaxRevenue;

            $this->emit('showModal', '#roomInfoModal');
        } catch (\Exception $e) {
            $this->emit('showSwal', "Error", $e->getMessage(), 'error');
        }
    }

    public function showOutOfOrder($id)
    {
        try {
            $this->selected_out_of_order = Maintenance::with(['room', 'room.room_type'])->findOrFail($id);
            $this->selected_out_of_order->start_date = Carbon::parse($this->selected_out_of_order->start_date)->format('F j, Y');
            $this->selected_out_of_order->end_date = Carbon::parse($this->selected_out_of_order->end_date)->format('F j, Y');

            $this->emit('showModal', '#outOfOrderModal');
        } catch (\Exception $e) {
            $this->emit('showError', $e->getMessage());
        }
    }

    public function showRestriction($id)
    {
        try {
            $this->selected_restriction = Restriction::with(['room_type', 'rate_type'])->findOrFail($id);
            $this->selected_restriction->date = Carbon::parse($this->selected_restriction->date)->format('F j, Y');

            $this->emit('showModal', '#restrictionModal');
        } catch (\Exception $e) {
            $this->emit('showError', $e->getMessage());
        }
    }
}

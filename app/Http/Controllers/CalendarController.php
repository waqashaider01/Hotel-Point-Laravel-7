<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\BookingAgency;
use App\Models\Company;
use App\Models\Country;
use App\Models\DailyRate;
use App\Models\HotelSetting;
use App\Models\Maintenance;
use App\Models\PaymentMethod;
use App\Models\PaymentMode;
use App\Models\RateType;
use App\Models\Reservation;
use App\Models\Restriction;
use App\Models\Room;
use App\Models\RoomCondition;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CalendarController extends Controller
{
    public function index()
    {
        return view('front.calendar.index');
    }

    public function super_calendar()
    {
        return view('front.calendar.index', ['calendar' => 'super']);
    }

    public function old_calendar(Request $request)
    {
        $settings = getHotelSettings();

        $data  = [
            'room_types' => getHotelSettings()->room_types()->where('type_status', 1)->get()
        ];
        $room_type_ids = $data['room_types']->pluck('id')->toArray();

        $data['active_rooms'] = Room::active()->whereIn('room_type_id', $room_type_ids)->get();
        $data['rooms'] = Room::whereIn('room_type_id', $room_type_ids)->get();

        try {
            $data['date'] = Carbon::parse($request->get('date'));
        } catch(\Exception $e){
            $data['date'] = now()->startOfMonth();
        }

        return view('front.calendar.old')->with($data);
    }

    public function getTimelineRooms()
    {
        $room_types = getHotelSettings()->room_types()->with('rooms')->where('type_status', 1)->get();
        $result = array();
        foreach ($room_types as $type) {
            $result[] = collect(['type' => collect(['type' => $type->name, 'id' => $type->id])]);
            foreach ($type->rooms as $room) {
                $result[] = collect(['room' => collect(['name' => $room->number, 'id' => "room" . $room->number, 'roomid' => $room->id])]);
            }
        }
        return $result;
    }

    public function checkRoomAvailable(Request $request)
    {
        $start = Carbon::parse($request->start);
        $end = Carbon::parse($request->end);
        $endNew = $start->endOfMinute();
        $result = array();
        $types = getHotelSettings()->room_types()->where('type_status', 1)->get();
        foreach ($types as $type) {
            $dataRoom = array();
            $data = collect();
            $data['typeid'] = $type->id;
            $data['typename'] = $type->name;
            $restrictions = Restriction::where('room_type_id', $type->id)->where('name', 'stop_availability')->whereBetween('date', [$start, $endNew])->count();
            if ($restrictions > 0) continue;
            $dataRoom[] = $data;
            $rooms = Room::where('room_type_id', $type->id)->active()->get();
            foreach ($rooms as $room) {
                $roomid = $room->id;
                $roomNumber = $room->number;
                $ifNotAvailable = Availability::where('room_id', $room->id)->whereBetween('date', [$start, $endNew])->count();
                if ($ifNotAvailable < 1) {
                    $data = collect();
                    $data['roomid'] = $roomid;
                    $data['roomnumber'] = $roomNumber;
                    $dataRoom[] = $data;
                }
            }
            $result[] = $dataRoom;
        }
        return $result;
    }

    public function getRoomForSplit(Request $request)
    {
        $reservation = Reservation::find($request->id);
        $data = collect();
        $data['id'] = $reservation->id;
        $data['bcode'] = $reservation->booking_code;
        $data['rstatus'] = $reservation->reservation_status;
        $data['cstatus'] = $reservation->channex_status;
        $data['chargedate'] = $reservation->charge_date;
        $data['methodid'] = $reservation->payment_method_id;
        $data['pmethods'] = $reservation->payment_method->name;
        $data['pmode'] = $reservation->payments_mode_id;
        $data['arrivalhour'] = $reservation->arrival_hour;
        $data['checkin'] = $reservation->check_in;
        $data['checkout'] = $reservation->check_out;
        $data['adults'] = $reservation->adults;
        $data['kids'] = $reservation->kids;
        $data['infants'] = $reservation->infants;
        $data['country'] = $reservation->country_id;
        $data['comments'] = $reservation->comment;
        $data['bookingdate'] = $reservation->booking_date;
        $data['guestname'] = $reservation->guest->full_name;
        $data['guestphone'] = $reservation->guest->phone;
        $data['ratetype'] = $reservation->rate_type_id;
        $data['guestemail'] = $reservation->guest->email;
        $data['roomid'] = $reservation->room_id;
        $data['virtual'] = $reservation->virtual_card;
        $rates = $reservation->daily_rates;
        $myrate = "";
        foreach ($rates as $rate) {
            $myrate = $rate['daily_rate_price'];
        }
        $data['roomtypeid'] = $reservation->room->room_type_id;
        $data['dailyrate'] = $myrate;
        return [$data];
    }

    public function loadRatesInfo()
    {
        $room_types = getHotelSettings()->room_types()->with('rooms')->where('type_status', 1)->orderBy('position')->get();
        $result = collect();
        foreach ($room_types as $type) {
            $bubbleHtml = "";
            foreach ($type->rate_types as $rate) {
                $bubbleHtml .= "<div class='ratecontainers'><p>" . $rate->reference_code . "</p></div>";
            }
            $result->push(collect(['id' => $type->id, 'tooltip' => $bubbleHtml]));
        }
        return $result;
    }

    public function getRoomStats(Request $request)
    {
        $room_id = $request->id;
        $date = Carbon::parse($request->date);
        $month = $date->month;
        $year = $date->year;
        $days_in_month = $date->daysInMonth;
        $date = $year . "-" . $month . "-01";
        $end = $year . "-" . $month . "-" . $days_in_month;
        $maxagency = "0";
        $maxagencyname = "";
        $occupied = 0;
        $adr = 0;
        $roomrevenue = 0;
        $mincapacity = 0;
        $maxcapacity = 2;
        $totaldailyrate = 0;
        $agenciesarray = array();
        $totaladults = 0;
        $totalkids = 0;
        $totalinfants = 0;
        $totalcommission = 0;
        $maxdata = "";
        $room = Room::find($room_id);
        $roomtypeName = $room->room_type->name;
        $roomno = $room->number;
        $outoforder = Availability::where('room_id', $room_id)->whereBetween('date', [$date, $end])->count();
        $availabledays = $days_in_month - $outoforder;
        $reservations = Reservation::where('room_id', $room_id)->get();
        foreach ($reservations as $reservation) {
            $totalcommission += $reservation->commission_amount;
        }
        $rates = DailyRate::whereHas('reservation', function ($q) use ($room_id) {
            $q->where('room_id', $room_id);
        })->whereBetween('date', [$date, $end])->get();
        foreach ($rates as $rate) {
            $totaldailyrate += $rate->price;
            $occupied++;
        }
        $occupancy = (int)$occupied / (int)$availabledays * 100;
        $occupancy = number_format($occupancy, 0);
        if ($totaldailyrate !== 0) {
            $adr = $totaldailyrate / $occupied;
        }
        $grossRevenue = $totaldailyrate;
        $totaldailyrate = number_format($totaldailyrate, 2);
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $results = DB::select("SELECT availabilities.reservation_id as id, booking_agencies.name as agency, COUNT(*) as count, SUM(reservations.adults) as sumadults, SUM(reservations.kids) as sumkids, SUM(reservations.infants) as infantsum FROM `reservations` INNER JOIN `availabilities` ON reservations.id=availabilities.reservation_id
    INNER JOIN `booking_agencies` ON reservations.booking_agency_id=booking_agencies.id WHERE availabilities.room_id='$room_id' AND availabilities.date BETWEEN '$date' AND '$end' GROUP BY agency ORDER BY count DESC;");
        if (count($results) > 0) {
            foreach ($results as $row) {
                $maxagency = $row['count'];
                $maxagencyname = $row['agency'];
                $maxdata .= "<div><span class='mr-5'>" . $maxagencyname . " </span> <span class='mr-5'>" . $maxagency . "/" . $occupied .
                    "</span></div>";
                // array_push($agenciesarray, $maxdata);
                $totaladults += $row['sumadults'];
                $totalkids += $row['sumkids'];
                $totalinfants += $row['infantsum'];
            }
        } else {
            $maxdata = $maxagencyname . " " . $maxagency . "/" . $occupied;
        }
        $hotel_settings = getHotelSettings();
        $vat = $hotel_settings->vat;
        $vat = $vat / 100;
        $overnightTaxValue = $hotel_settings->overnight_tax;
        $accomodationNetRevenue = 0;
        $accomodationVat = 0;
        if ($grossRevenue > 0) {
            $accomodationNetRevenue = (float)$grossRevenue / (1 + $vat);
            $accomodationVat = $grossRevenue - $accomodationNetRevenue;
        }
        $totalNetExtraRevenue = 0;
        $totalExtraVAt = 0;
//        $getServiceCharges=DB::select("SELECT SUM(reservation_extra_charges.extra_charge_total) as totalAmount, extra_charges.extra_charge_vat as chargeVat FROM `reservations` INNER JOIN `reservation_extra_charges`
//                                      ON reservations.reservation_id=reservation_extra_charges.extra_charge_reservation_id
//                                      INNER JOIN `extra_charges`
//                                       ON reservation_extra_charges.reservation_extra_charge_id=extra_charges.extra_charge_id
//                                       WHERE reservations.room_id='$room_id'
//                                       AND reservation_extra_charges.date1 BETWEEN '$date' AND '$end'
//                                       GROUP BY extra_charges.extra_charge_id");
//        $getServiceCharges->execute();
//        $resultServiceCharges=$getServiceCharges->fetchAll();
//        foreach ($resultServiceCharges as $row) {
//
//            $grossAmount=$row['totalAmount'];
//            $servicevat=$row['chargeVat'];
//            $netAmount=(float)$grossAmount/(1+($servicevat/100));
//            $netAmount=number_format($netAmount, 2);
//            $extraVAt=$grossAmount-$netAmount;
//            // $netAmount=number_format($netAmount, 2);
//            // $extraVAt=number_format($extraVAt, 2);
//            $totalNetExtraRevenue+=$netAmount;
//            $totalExtraVAt+=$extraVAt;
//        }
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        $overnightTax = $occupied * $overnightTaxValue;
        return [
            "roomno" => $roomno,
            "roomtype" => $roomtypeName,
            "occupancy" => $occupancy,
            "adr" => $adr,
            "outoforder" => $outoforder,
            "adults" => $totaladults,
            "kids" => $totalkids,
            "infants" => $totalinfants,
            "accomodationRevenue" => $accomodationNetRevenue,
            "extraRevenue" => $totalNetExtraRevenue,
            "overnightTaxRevenue" => $overnightTax,
            "channels" => $maxdata,
            "commission" => $totalcommission,
            "accommodationVat" => $accomodationVat,
            "extraVat" => $totalExtraVAt
        ];
    }

    public function loadResizeData(Request $request)
    {
        $reservation = Reservation::find($request->id);
        $data = collect();
        $result = array();
        $result['id'] = $reservation->id;
        $result['bcode'] = $reservation->booking_code;
        $result['rstatus'] = $reservation->status;
        $result['cstatus'] = $reservation->channex_status;
        $result['chargedate'] = $reservation->charge_date;
        $result['methodid'] = $reservation->payment_method_id;
        $result['pmethods'] = $reservation->payment_method->name;
        $result['pmode'] = $reservation->payment_mode_id;
        $result['checkin'] = $reservation->check_in;
        $result['checkout'] = $reservation->check_out;
        $result['arrivalhour'] = $reservation->arrival_hour;
        $result['country'] = $reservation->country_id;
        $result['adults'] = $reservation->adults;
        $result['kids'] = $reservation->kids;
        $result['infants'] = $reservation->infants;
        $result['bookingdate'] = $reservation->booking_date;
        $result['comments'] = $reservation->comment;
        $result['guestname'] = $reservation->guest->name;
        $result['guestphone'] = $reservation->guest->phone;
        $result['guestemail'] = $reservation->guest->email;
        $result['ratetype'] = $reservation->rate_type_id;
        $result['roomid'] = $reservation->room_id;
        $result['virtual'] = $reservation->virtual_card;
        $my_rate = "";
        foreach ($reservation->daily_rates as $rate) {
            $my_rate = $rate->price;
        }
        $result['roomtypeid'] = $reservation->room_id;
        $result['dailyrate'] = $my_rate;
        return $data->push($result);
    }

    public function getDailyRates(Request $request)
    {
        $checkin = Carbon::parse($request->checkin);
        $checkout = Carbon::parse($request->checkout);
        $resid = $request->resid;
        $text = "";
        $count = 0;
        while ($checkin < $checkout) {
            $daily_rates = DailyRate::where('reservation_id', $resid)->whereDate('date', $checkin);
            if ($daily_rates->count() > 0) {
                foreach ($daily_rates->get() as $rate) {
                    $text .= '<div class="row"><div class="col"><label for="dailyrate' . $count . '" class="" id="label' . $count . '" style="">' .
                        $checkin .
                        '</label><input id="dailyrate' . $count . '"  type="text" value="' . $rate->price .
                        '" placeholder="Add daily rate" style="" /></div></div>';
                }

            } else {
                $text .= '<div class="row"><div class="col"><label for="dailyrate' . $count . '" class="" id="label' .
                    $count . '" style="">' .
                    $checkin . '</label><input class=""  id="dailyrate' . $count .
                    '"  type="text" value="" placeholder="Add daily rate" style="" /></div></div>';
            }
            $checkin = $checkin->addDay();
            $count++;
        }
        return collect(["inputs" => $text, "count" => $count]);
    }

    public function getRateTypes(Request $request)
    {
        $result = array();
        $result[] = "<option >Choose...</option>";
        $rates = getHotelSettings()->rate_types()->where('room_type_id', $request->id)->get();
        foreach ($rates as $rate)
//            $result[] = "<option value='" . $rate['id'] . "' data-occupancy='" . $rate['primary_occupancy'] . "' data-infantfee='" . $rate['infant_fee'] . "' data-childrenfee='" . $rate['children_fee'] . "' >" . $rate['rate_type_name'] . "</option>";
            $result[] = "<option value='" . $rate['id'] . "' data-occupancy='" . $rate['primary_occupancy'] . "'>" . $rate['name'] . "</option>";
        return $result;
    }

    public function getCountries(Request $request)
    {
        $countries = Country::all();
        $result = collect();
        foreach ($countries as $country) {
            $result->push(collect(['id' => $country->id, 'name' => $country->name]));
        }
        return $result;
    }

    public function getAgencies(Request $request)
    {
        $agencies = getHotelSettings()->booking_agencies;
        $result = collect();
        foreach ($agencies as $agency) {
            $result->push(collect(['id' => $agency->id, 'name' => $agency->name]));
        }
        return $result;
    }

    public function getPaymentModes(Request $request)
    {
        $modes = getHotelSettings()->payment_modes;
        $result = collect();
        foreach ($modes as $mode) {
            $result->push(collect(['id' => $mode->id, 'name' => $mode->name]));
        }
        return $result;
    }

    public function getAvailabilityThisRoom(Request $request)
    {
        $start = Carbon::parse($request->start);
        $end = Carbon::parse($request->end);
        $id = $request->id;
        $rooms = Availability::where('room_id', $id)->get();
        $start1 = $start;
        $response = collect();
        $datecount = 0;
        foreach ($rooms as $room) {
            $start = $start1;
            while ($start < $end) {
                $mybookeddate = $room->date;
                if ($mybookeddate == $start) {
                    $datecount = $datecount + 1;
                }
                $start = $start->addDay();
            }
        }
        $response['roomid'] = ($datecount == 0) ? "yes" : "not";
        return $response;
    }

    public function getAvailabilityRoomType(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $type = $request->roomtype;
        $exists = Restriction::where('room_type_id', $type)->where('name', 'stop_availability')->whereBetween('date', [$start, $end])->count();
        $response = collect();
        if ($exists > 0) {
            $response['status'] = "Error";
            $response['message'] = "not_available";
        } else {
            $response['status'] = "OK";
            $response['message'] = "available";
        }
        return $response;
    }

    public function postResizeReservation(Request $request)
    {
        $reservationId = $request->id;
        $dailyrateArray = $request->drate;
        $newStart = Carbon::parse($request->newStart);
        $newEnd = Carbon::parse($request->newEnd);
        $currentCheckout = Carbon::parse($request->current_checkout);
        $hotelSettings = getHotelSettings();
        $hotelSettings->load(['currency']);
        $property = $hotelSettings->property_id;
        $housekeeping = $hotelSettings->housekeeping;
        $currencyInitial = $hotelSettings->currency->currency_initials;
        $nights = 0;
        $start1 = $newStart;
        while ($start1 < $newEnd) {
            $nights = $nights + 1;
            $start1 = $start1->addDay();
        }
        $checkIn = $newStart;
        $checkOut = $currentCheckout;
        $reservation = Reservation::with('room')->where('id', $reservationId)->first();
        $reservation->arrival_date = $request->newStart;
        $reservation->departure_date = $request->newEnd;
        $reservation->overnights = $nights;
        $reservation->check_in = $request->newStart;
        $reservation->check_out = $request->newEnd;
        $reservation->notif_status = '1';
        $reservation->save();

        DailyRate::where('reservation_id', $reservationId)->delete();
        Availability::where('reservation_id', $reservationId)->delete();
        RoomCondition::where('reservation_id', $reservationId)->delete();

        $start = $reservation->check_in;
        $end = $reservation->check_out;
        $id = $reservation->reservation_id;
        $starts = Carbon::parse($start);
        $name = $reservation->guest->full_name;
        $bookingcode = $reservation->booking_code;
        $nights = $reservation->overnights;
        $chargedate = $reservation->charge_date;
        $arrival_hour1 = $reservation->arrival_hour;
        $adults = $reservation->adults;
        $kids = $reservation->kids;
        $infants = $reservation->infants;
        $comment = $reservation->comment;
        $pieces = explode(" ", $name, 2);
        $firstname = $pieces[0];
        $secondname = "";
        if (isset($pieces[1])) {
            $secondname = $pieces[1];
        }
        $phone = $reservation->guest->phone;
        $email = $reservation->guest->email;
        $roomid = $reservation->room_id;
        $otacode = $reservation->ota_reservation_code;
        $bookingagency = $reservation->booking_agency->name;
        $channel = $reservation->channex_channel_id;
        $country = $reservation->country->alpha_two_code;
        $rateplanid = $reservation->rate_type_id;
        $roomtype = $reservation->room->room_type_id;
        $roomtypeid = $reservation->room->room_type->channex_room_type_id;
        $arrival_hour = substr($arrival_hour1, 0, 5);
        $checkin = Carbon::parse($start);
        $checkout = Carbon::parse($end);
        $roomsidc = RoomCondition::whereDate('date', $checkin)->where('room_id', $roomid)->get();
        if ($roomsidc->count() > 0) {
            foreach ($roomsidc as $condition) {
                $status = $condition->status;
            }
            $wasdeparture = "yes";
        } else {
            $wasdeparture = "no";
        }
        $cleandays = $housekeeping;
        $dirtyafter = $housekeeping;
        $cleandays = (int)$cleandays;
        $dirtyafter = (int)$dirtyafter;
        $countclean = 1;
        $daycounter = 0;
        $roomstatus = "Dirty";
        while ($checkin <= $checkout) {
            $daycounter = $daycounter + 1;
            if ($daycounter < 3) {
                if ($wasdeparture == "yes" && $daycounter == 1) {
                    $roomstatus = "Dirty";
                } else {
                    $roomstatus = "Clean";
                }
            } else {
                if ($countclean == 1) {
                    $roomstatus = "Dirty";
                    $countclean = $countclean + 1;
                } else if ($countclean < $cleandays) {
                    $roomstatus = "Clean";
                    $countclean = $countclean + 1;
                } else if ($countclean == $cleandays) {
                    $roomstatus = "Clean";
                    $countclean = 1;
                }
            }
            $condition = RoomCondition::create([
                'room_id' => $roomid,
                'date' => $checkin,
                'status' => $roomstatus,
                'reservation_id' => $reservationId,
            ]);
            $checkin = $checkin->addDay();
        }
        $days = array();
        if (count($dailyrateArray) > 0) {
            $ratedata = "";
            $totalAccom = 0;
            for ($i = 0; $i < count($dailyrateArray); $i++) {
                $dailyRate = $dailyrateArray[$i]['rate'];
                $totalAccom += (float)$dailyRate;
                $dailyRate = number_format((float)$dailyRate, 2, '.', '');
                $ratedate = $dailyrateArray[$i]['date'];
                $ratedata .= "('" . $ratedate . "','" . $dailyRate . "','" . $reservationId . "'),";

                sscanf($dailyRate, '%d.%d', $whole, $fraction);
                $convertwholeToSmallUnit = (int)$whole * 100;
                $val = $convertwholeToSmallUnit + $fraction;
                $days[$ratedate] = $val;
            }
            $ratedata = substr($ratedata, 0, strlen($ratedata) - 1);
            $query = DB::insert("INSERT INTO daily_rates(date,price,reservation_id) VALUES " . $ratedata);
        }
        $totalRooms = Room::where('room_type_id', $roomtype)->where('status', 'Enabled')->count();
        $queryavaildata = "";
        while ($starts < $end) {
            $queryavaildata .= "('" . $roomtype . "','" . $roomid . "','" . $starts . "','" . $reservationId . "'),";
            $starts = $starts->addDay();
        }
        if ($queryavaildata != "") {
            $queryavaildata = substr($queryavaildata, 0, strlen($queryavaildata) - 1);
            $availquery = DB::insert("INSERT INTO availabilities (room_type_id, room_id, date, reservation_id) VALUES " . $queryavaildata);
        }
        $starts = Carbon::parse($start);
        $availabilityUrl = config('services.channex.api_base')."/availability";
        $fulldata = array();
        while ($checkIn < $checkOut) {
            $occupied = Availability::with(['room' => function ($q) {
                $q->where('status', 'Enabled');
            }])->where('room_type_id', $roomtype)->where('date', $checkin)->count();
            $availableRooms = $totalRooms - $occupied;
            $innerdata = [
                "property_id" => $property,
                "room_type_id" => $roomtypeid,
                "date" => $checkIn,
                "availability" => $availableRooms
            ];
            array_push($fulldata, $innerdata);
            $checkIn = $checkIn->addDay();
        }
        while ($starts < $end) {
            $occupied = Availability::with(['room' => function ($q) {
                $q->where('status', 'Enabled');
            }])->where('room_type_id', $roomtype)->where('date', $checkin)->count();
            $availableRooms = $totalRooms - $occupied;
            $innerdata =
                [
                    "property_id" => $property,
                    "room_type_id" => $roomtypeid,
                    "date" => $starts,
                    "availability" => $availableRooms
                ];
            array_push($fulldata, $innerdata);
            $starts = $starts->addDay();
        }
        $dataav = [
            "values" => $fulldata
        ];
//        try {
//            $client = new Client();
//            $request = $client->post($availabilityUrl, [
//                'headers' => ['Content-Type' => 'application/json', 'Authorization' => 'Bearer ' . $token],
//                'body' => json_encode($dataav)
//            ]);
//            $result = json_decode($request->getBody(), true);
//        } catch (\Exception $e) {
//        }
        $datas = [
            "booking" => [
                "status" => "modified",
                "channel_id" => $channel,
                "reservation_id" => $bookingcode,
                "rooms" => [
                    [
                        "checkin_date" => $start,
                        "checkout_date" => $end,
                        "occupancy" => [
                            "adults" => (int)$adults,
                            "children" => (int)$kids,
                            "infants" => (int)$infants
                        ],
                        "room_type_id" => $roomtypeid,
                        "rate_plan_id" => $rateplanid,
                    ]
                ],
                "customer" => [
                    "surname" => $secondname,
                    "phone" => $phone,
                    "name" => $firstname,
                    "mail" => $email,
                    "country" => $country
                ],
                "arrival_date" => $start,
                "departure_date" => $end,
                "arrival_hour" => $arrival_hour,
                "currency" => $currencyInitial
            ]
        ];
        $datas['booking']['rooms'][0]['days'] = $days;
        $bookingurl = "/bookings/push";
//        try {
//            $client = new Client();
//            $request = $client->post($bookingurl, [
//                'headers' => ['Content-Type' => 'application/json', 'Authorization' => 'Bearer ' . $token],
//                'body' => json_encode($datas)
//            ]);
//            $result = json_decode($request->getBody(), true);
//            $otacode = $result['data']['attributes']['ota_reservation_code'];
//            $systemid = $result['data']['attributes']['system_id'];
//            $uniqueid = $result['data']['attributes']['unique_id'];
//            $revisionid = $result['data']['attributes']['revision_id'];
//            $reservation->system_id = $systemid;
//            $reservation->reservation_unique_id = $uniqueid;
//            $reservation->ota_reservation_code = $otacode;
//            $reservation->reservation_revision_id = $revisionid;
//            $reservation->reservation_amount = $totalAccom ?? 0;
//            $reservation->channex_status = 'modified';
//            $response = new Result();
//            $response->result = 'OK';
//            $response->message = 'Reservation updated successfully';
//            $ackurl = "/booking_revisions/" . $revisionid . "/ack";
//            try {
//                $client = new Client();
//                $request = $client->request('POST', $ackurl, [
//                    'headers' => ['Authorization' => 'Bearer ' . $token, 'Content_Type' => 'application/json']
//                ]);
//                header('Content-Type: application/json');
//                echo json_encode($response);
//                exit;
//            } catch (\Exception $e) {
//            }
//        } catch (\Exception $e) {
//        }
    }

    public function getReservations(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        $date = Carbon::parse($year . '-' . $month . '-1');
        $start_date = $date->startOfMonth();
        $date = Carbon::parse($year . '-' . $month . '-1');
        $end_date = $date->endOfMonth();
        $reservations = Reservation::where('hotel_settings_id', getHotelSettings()->id)->whereDate('check_in', '>=', $start_date)->whereDate('check_out', '<=', $end_date)->get();
        $out_of_order_rooms = Maintenance::whereDate('start_date', '>=', $start_date)->whereDate('end_date', '<=', $end_date)->get();
        $result = collect();
        foreach ($out_of_order_rooms as $ooo_room) {
            $data = [
                'id' => $ooo_room->ids . '' . $ooo_room->id,
                'text' => null,
                'email' => null,
                'start' => $ooo_room->start_date,
                'end' => $ooo_room->end_date,
                'checkoutorg' => null,
                'resource' => $ooo_room->room->id,
                'resource1' => $ooo_room->room->number,
                'code' => null,
                'bgncyid' => null,
                'paidmode' => null,
                'paidmodeid' => null,
                'scountry' => null,
                'adults' => null,
                'children' => null,
                'infants' => null,
                'bdate' => null,
                'ahour' => null,
                'comments' => $ooo_room->reason,
                'phone' => null,
                'ratetype' => null,
                'ratetypeReferenceCode' => null,
                'ratetypeid' => null,
                'scid' => null,
                'roomtype' => null,
                'status' => "Out Of Order",
                'bgncy' => 'Out of Order',
                'bstatus' => null,
            ];
            $data['bubbleHtml'] = "<div class='tipcontainer'><p class='textclass'>Start </p><p><b> " . $data['start'] .
                "</b></p></div><div class='tipcontainer'><p class='textclass'>End </p><p><b>" . $data['end'] .
                "</b></p></div><div class='tipcontainer'><p class='textclass'>Room No </p><p><b>" . $data['resource1'] .
                "</p></div><div class='tipcontainer'><p class='textclass'>Reason </p><p><b>" . $data['comments'] .
                "</p></div>";
            $result->push($data);
        }
        foreach ($reservations as $reservation) {
            $methodName = $reservation->payment_method->name;
            $data = [
                'id' => $reservation->id,
                'text' => $reservation->guest->full_name,
                'email' => $reservation->guest->email,
                'start' => $reservation->check_in,
                'end' => $reservation->check_out,
                'checkoutorg' => $reservation->check_out,
                'resource' => $reservation->room_id,
                'resource1' => $reservation->room->number,
                'code' => $reservation->booking_code,
                'bgncyid' => $reservation->booking_agency_id,
                'paidmode' => $reservation->payment_mode->name,
                'paidmodeid' => $reservation->payment_mode_id,
                'scountry' => $reservation->country->name,
                'adults' => $reservation->adults,
                'children' => $reservation->children,
                'infants' => $reservation->infants,
                'bdate' => $reservation->booking_date,
                'ahour' => $reservation->arrival_hour,
                'comments' => $reservation->comment,
                'phone' => $reservation->guest->phone,
                'ratetype' => $reservation->rate_type->name,
                'ratetypeReferenceCode' => $reservation->rate_type->reference_code,
                'ratetypeid' => $reservation->rate_type_id,
                'scid' => $reservation->country_id,
                'roomtype' => $reservation->room->room_type->name,
                'status' => $reservation->status,
                'bgncy' => $reservation->booking_agency->name,
                'bstatus' => $reservation->channex_status
            ];
            $data['bubbleHtml'] = "<div class='tipcontainer'><p class='textclass'>Name </p><p><b>" . $data['text'] .
                "</b></p></div><div class='tipcontainer'><p class='textclass'>Booking ID </p><p><b>" . $data['id'] .
                "</b></p></div><div class='tipcontainer'><p class='textclass'>Payment by </p><p> <b>" . $methodName .
                "</b></p></div><div class='tipcontainer'><p class='textclass'>Check In </p><p><b>" . $data['start'] .
                "</b></p></div><div class='tipcontainer'><p class='textclass'>Check out </p><p><b>" . $data['end'] .
                "</b></p></div><div class='tipcontainer'><p class='textclass'> Agency </p><p><b>" . $data['bgncy'] .
                "</b></p></div><div class='tipcontainer'><p class='textclass'>Mode </p><p><b>" . $data['paidmode'] .
                "</b></p></div><div class='tipcontainer'><p class='textclass'>Rate type </p><p> <b>" .
                $data['ratetypeReferenceCode'] .
                "</b></p></div><div class='tipcontainer'><p class='textclass'> Status </p><p><b>" . $data['status'] .
                "</p></div>";
            $result->push($data);
        }
        return $result;
    }

    public function splitReservation(Request $request)
    {
        DB::transaction(function () use ($request) {
            $reservationId = $request->id;
            $dailyrateArray = $request->drate;
            $newratetype = $request->ratetype;
            $oldRoom = $request->resource;
            $newRoom = $request->resource1;
            $guestName = $request->text;
            $oldCheckin = Carbon::parse($request->start);
            $oldCheckout = Carbon::parse($request->end);
            $newCheckin = Carbon::parse($request->start1);
            $newCheckout = Carbon::parse($request->end1);
            $settings = getHotelSettings();
            $property = $settings->active_property()->property_id;
            $housekeeping = $settings->housekeeping;
            RoomCondition::where('reservation_id', $reservationId)->delete();
            Availability::where('reservation_id', $reservationId)->whereDate('date', '>', $oldCheckout)->delete();
            $oldroomtyperesult = Room::find($oldRoom);
            $oldroomtype = $oldroomtyperesult->room_type->id;
            $oldroomtypeId = $oldroomtyperesult->room_type->channex_room_type_id;
            $totalRooms = Room::active()->where('room_type_id', $oldroomtype)->count();
            $fulldata = array();
            $starts = $oldCheckin;
            while ($starts < $newCheckout) {
                $occupied = Availability::whereHas('room', fn($q) => $q->active())->count();
                $availableRooms = $totalRooms - $occupied;
                $innerdata = [
                    "property_id" => $property,
                    "room_type_id" => $oldroomtypeId,
                    "date" => $starts,
                    "availability" => $availableRooms
                ];
                array_push($fulldata, $innerdata);
                $starts = $starts->addDay();
            }
            $nights = $oldCheckin->diff($oldCheckout)->days;;
            $start = $oldCheckin;
            $reservation = Reservation::find($reservationId);
            $guest = $reservation->guest;
            $guest->full_name = $guestName;
            $reservation->check_in = $request->start;
            $reservation->check_out = $request->end;
            $reservation->arrival_date = $request->start;
            $reservation->departure_date = $request->end;
            $reservation->overnights = $nights;
            $reservation->room_id = $oldRoom;
            $this->populateRoomCondition($oldRoom, $oldCheckin, $oldCheckout, $housekeeping, $housekeeping, $reservationId);
            $newReservation = $reservation->replicate();
            $reservation->save();
            $newReservation->check_in = $request->start1;
            $newReservation->check_out = $request->end1;
            $newReservation->overnights = $newCheckin->diff($newCheckout)->days;
            $newReservation->arrival_date = $request->start1;
            $newReservation->departure_date = $request->end1;
            $newReservation->rate_type_id = is_numeric($newratetype) ? $newratetype : 0;
            $newReservation->room_id = $newRoom;
            $newReservation->save();
            $newResId = $newReservation->id;
            if (count($dailyrateArray) > 0) {
                DailyRate::where('reservation_id', $reservationId)->whereDate('date', $oldCheckout)->delete();
                for ($i = 0; $i < count($dailyrateArray); $i++) {
                    DailyRate::create([
                        'date' => $dailyrateArray[$i]['date'],
                        'price' => $dailyrateArray[$i]['rate'],
                        'reservation_id' => $newResId,
                    ]);
                }
            }
            $this->populateRoomCondition($newRoom, $newCheckin, $newCheckout, $housekeeping, $housekeeping, $newResId);
            $getNewRoom = Room::find($newRoom);
            $newRoomType = $getNewRoom->room_type->id;
            $newRoomTypeId = $getNewRoom->room_type->channex_room_type_id;
            $starts = $newCheckin;
            while ($starts < $newCheckout) {
                Availability::create([
                    'room_type_id' => $newRoomType,
                    'room_id' => $newRoom,
                    'date' => $starts,
                    'reservation_id' => $reservationId,
                ]);
                $starts = $starts->addDay();
            }
            $totalRooms = Room::active()->where('room_type_id', $newRoomType)->count();
            $availabilityUrl = "/availability";
            $starts = $oldCheckin;
            $occupied = 0;
            while ($starts < $newCheckout) {
                $occupied = Availability::whereHas('room', fn($q) => $q->active())->where('room_type_id', $newRoomType)
                    ->whereDate('date', $starts)->count();
                $availableRooms = $totalRooms - $occupied;
                $innerdata = [
                    "property_id" => $property,
                    "room_type_id" => $newRoomTypeId,
                    "date" => $starts,
                    "availability" => $availableRooms
                ];
                array_push($fulldata, $innerdata);
                $starts = $starts->addDay();
            }
            $dataav = [
                "values" => $fulldata
            ];
//            $client = new Client();
//            $request = $client->post($availabilityUrl, [
//                'headers' => ['Content-Type' => 'application/json', 'Authorization' => 'Bearer ' . $token],
//                'body' => json_encode($dataav)
//            ]);
        });
        $response = collect();
        $response['result'] = 'OK';
        $response['message'] = 'Reservation splat successfully';
        return $response;
    }

    public function getAvailableRooms(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        $data = array();
        $date = Carbon::parse($year . '-' . $month . '-1');
        $start_date = $date->copy()->startOfMonth();
        $days = $date->daysInMonth;
        $startDay = 1;
        $room_types = getHotelSettings()->room_types;
        foreach ($room_types as $type) {
            $daysData = array();
            $roomTypeId = $type->id;
            $totalRoomsDay = $type->rooms()->count();
            while ($startDay <= $days) {
                $existsStopAvail = Restriction::where('date', $start_date)->where('room_type_id', $type->id)
                    ->where('name', 'stop_availability')->count();
                if ($existsStopAvail > 0) {
                    $availableDay = '0';
                } else {
                    $occupiedDay = Availability::with([
                        'room' => function ($query) {
                            $query->where('status', 'Enabled');
                        }])
                        ->where('room_type_id', $type->id)
                        ->where('date', $start_date)->count();
                    $availableDay = $totalRoomsDay - $occupiedDay;
                }
                $restrict = 0;
                $popupData = "";
                $getRestriction = Restriction::where('date', $start_date)->where('room_type_id', $type->id);
                if ($getRestriction->count() > 0) {
                    $restrict = 1;
                    $results = $getRestriction->get();
                    foreach ($results as $result) {
                        $restrictValue = $result->value;
                        if ($restrictValue == "true") {
                            $restrictValue = "Active";
                        }
                        $restrictName = $result->name;
                        $restrictName = str_replace('_', '', ucwords($restrictName, '_'));
                        if ($restrictName != "StopAvailability") {
                            $rateType = $result->rate_type->name;
                            $popupData .= "<div class='restcontainers'><p class='textclass'><b>" . $restrictName .
                                "</b> </p><p class='textclass'><b>" . $rateType . "</b> </p><p class='textclass'><b>" .
                                $restrictValue . "</b> </p></div>";
                        }
                    }
                }
                $out_of_order_rooms = Maintenance::whereDate('start_date', '<=', $start_date)->whereDate('end_date', '>=', $start_date)->count();
                $availableDay -= $out_of_order_rooms;
                $day = $start_date->day;
                $daysData[] = collect(['day' => $day, 'empty' => $availableDay, 'restrict' => $restrict, 'popupdata' => $popupData]);
                $start_date = $start_date->addDay();
                $startDay++;
            }
            $startDay = 1;
            $start_date = $date->copy()->startOfMonth();
            $data[] = ["type" => $roomTypeId, "empty" => $daysData];
        }
        return $data;
    }

    public function postMoveReservation(Request $request)
    {
        DB::transaction(function () use ($request) {
            $reservationId = $request->id;
            $dailyrateArray = $request->drate;
            $newStart = $request->newStart;
            $newEnd = $request->newEnd;
            $newRoom = $request->newResource;
            $roomtypechanged = $request->roomtypechanged;
            $oldRoom = $request->oldroom;
            $newratetype = $request->ratetype;
            $settings = getHotelSettings();
            if ($settings) {
                $property = $settings->active_property()->property_id;
                $housekeeping = $settings->housekeeping;
                $currencyInitial = $settings->currency->initials;
            }
            $fulldata = array();
            $reservation = Reservation::find($reservationId);
            $reservation->check_in = $newStart;
            $reservation->check_out = $newEnd;
            $reservation->arrival_date = $newStart;
            $reservation->departure_date = $newEnd;
            $reservation->room_id = $newRoom;
            $reservation->rate_type_id = $newratetype;
            $reservation->save();
            DailyRate::where('reservation_id', $reservationId)->delete();
            Availability::where('reservation_id', $reservationId)->delete();
            RoomCondition::where('reservation_id', $reservationId)->delete();
            $oldroomtyperesult = Room::find($oldRoom);
            $roomtype = $oldroomtyperesult->room_type->id;
            $roomtypeId = $oldroomtyperesult->room_type->channex_room_type_id;
            $totalRooms = Room::active()->where('room_type_id', $roomtype)->count();
            $checkIn = Carbon::parse($newStart);
            $checkOut = Carbon::parse($newEnd);
            while ($checkIn < $checkOut) {
                $occupied = Availability::whereHas('room', fn($q) => $q->active())->where('room_type_id', $roomtype)->whereDate('date', $checkIn)->count();
                $availableRooms = $totalRooms - $occupied;
                $innerdata = [
                    "property_id" => $property ?? '',
                    "room_type_id" => $roomtypeId,
                    "date" => $checkIn,
                    "availability" => $availableRooms
                ];
                array_push($fulldata, $innerdata);
                $checkIn = $checkIn->addDay();
            }
            $start = $reservation->check_in;
            $end = $reservation->check_out;
            $id = $reservation->id;
            $starts = $start;
            $name = $reservation->guest->name;
            $nights = $reservation->overnights;
            $bookingcode = $reservation->booking_code;
            $arrival_hour1 = $reservation->arrival_hour;
            $chargedate = $reservation->charge_date;
            $kids = $reservation->kids;
            $adults = $reservation->adults;
            $comment = $reservation->comment;
            $infants = $reservation->infants;
            $pieces = explode(" ", $name, 2);
            $phone = $reservation->guest->phone;
            $firstname = $pieces[0];
            $secondname = "";
            if (isset($pieces[1])) {
                $secondname = $pieces[1];
            }
            $email = $reservation->guest->email;
            $roomid = $reservation->room_id;
            $otacode = $reservation->ota_reservation_code;
            $bookingagency = $reservation->booking_agency->name;
            $channel = $reservation->channex_channel_id;
            $country = $reservation->country->alpha_two_code;
            $rateplanid = $reservation->rate_type->rate_type_channex_id;
            $newroomtype = $reservation->room->room_type_id;
            $newroomtypeid = $reservation->room->room_type->channex_room_type_id;
            $arrival_hour = substr($arrival_hour1, 0, 5);
            $checkin = Carbon::parse($start);
            $checkout = Carbon::parse($end);
            $this->populateRoomCondition($roomid, $checkIn, $checkout, $housekeeping ?? 0, $housekeeping ?? 0, $reservation->id);
            $ratedata = "";
            $days = array();
            $totalAccom = 0;
            if (count($dailyrateArray) > 0) {
                for ($i = 0; $i < count($dailyrateArray); $i++) {
                    $dailyRate = $dailyrateArray[$i]['rate'];
                    $dailyRate = number_format((float)$dailyRate, 2, '.', '');
                    $totalAccom += (float)$dailyRate;
                    DailyRate::create([
                        'date' => $dailyrateArray[$i]['date'],
                        'price' => $dailyRate,
                        'reservation_id' => $reservation->id,
                    ]);
                }
            }
            $totalRooms = Room::active()->where('room_type_id', $newroomtype)->count();
            $availabilityUrl = "/availability";
            $queryavaildata = "";
            $starts = $checkin;
            while ($starts < $checkout) {
                Availability::create([
                    'room_type_id' => $newroomtype,
                    'room_id' => $roomid,
                    'date' => $starts,
                    'reservation_id' => $reservation->id,
                ]);
                $starts = $starts->addDay();
            }
            $starts = Carbon::parse($start);
            $end = Carbon::parse($end);
            while ($starts < $end) {
                $occupied = Availability::whereHas('room', fn($q) => $q->active())->where('room_type_id', $newroomtype)
                    ->whereDate('date', $starts)->count();
                $availableRooms = $totalRooms - $occupied;
                $innerdata = [
                    "property_id" => $property ?? '',
                    "room_type_id" => $newroomtypeid,
                    "date" => $starts,
                    "availability" => $availableRooms
                ];
                array_push($fulldata, $innerdata);
                $starts = $starts->addDay();
            }
            $dataav = [
                "values" => $fulldata
            ];
//            $client=new Client();
//            $request=$client->post($availabilityUrl,[
//                'headers'=>['Content-Type'=>'application/json','Authorization'=>'Bearer '.$token],
//                'body'=>json_encode($dataav)
//            ]);
//            $datas = [
//                "booking" => [
//                    "status" => "modified",
//                    "channel_id" => $channel,
//                    "reservation_id" => $otacode,
//                    "rooms" => [
//                        [
//                            "checkin_date" => $start,
//                            "checkout_date" => $end,
//                            "occupancy" => [
//                                "adults" => (int)$adults,
//                                "children" => (int)$kids,
//                                "infants" => (int)$infants
//                            ],
//                            "room_type_id" => $newroomtypeid,
//                            "rate_plan_id" => $rateplanid,
//                        ]
//                    ],
//                    "customer" => [
//                        "surname" => $secondname,
//                        "phone" => $phone,
//                        "name" => $firstname,
//                        "mail" => $email,
//                        "country" => $country
//                    ],
//                    "arrival_date" => $start,
//                    "departure_date" => $end,
//                    "arrival_hour" => $arrival_hour,
//                    "currency" => $currencyInitial,
//                ]
//            ];
//            $datas['booking']['rooms'][0]['days'] = $days;
//            $url = "/bookings/push";
//            $client = new Client();
//
//            $request = $client->post($url, [
//                'headers' => ['Content-Type' => 'application/json', 'Authorization' => 'Bearer ' . $token],
//                'body' => json_encode($datas)
//            ]);
//
//            $result = json_decode($request->getBody(), true);
//
//            $otacode = $result['data']['attributes']['ota_reservation_code'];
//            $systemid = $result['data']['attributes']['system_id'];
//            $uniqueid = $result['data']['attributes']['unique_id'];
//            $revisionid = $result['data']['attributes']['revision_id'];
//            $stmt = $db->prepare("UPDATE reservations SET
//				system_id = '$systemid',
//				reservation_unique_id= '$uniqueid',
//				ota_reservation_code = '$otacode',
//				reservation_revision_id= '$revisionid',
//				reservation_amount='$totalAccom',
//				channex_status='modified'
//				 WHERE reservation_id = '$id'");
//            $ackurl = "/booking_revisions/" . $revisionid . "/ack";
//            $client = new Client();
//            $request = $client->request('POST', $ackurl, [
//                'headers' => ['Authorization' => 'Bearer ' . $token, 'Content_Type' => 'application/json']
//            ]);
        });
        $response = collect();
        $response['result'] = 'OK';
        $response['message'] = 'Reservation Moved successfully';
        return $response;
    }

    public function postMaintenance(Request $request)
    {
        $start = Carbon::parse($request->start);
        $end = Carbon::parse($request->end);
        $resource = $request->resource;
        $reason = $request->reason;
        $available = Availability::where('room_id', $resource)->whereBetween('date', [$start, $end])->count();
        $response = collect();
        if ($available > 0) {
            $response['result'] = 'Error';
            $response['message'] = 'This overlaps with an existing reservation.';
            return $response;
        }
        $maintenance = Maintenance::create([
            'ids' => 'a',
            'room_id' => $resource,
            'start_date' => $start,
            'end_date' => $end,
            'status' => 'OOO',
            'reason' => $reason
        ]);
        if ($maintenance) {
            $response['message'] = 'Successfully created';
        } else {
            $response['result'] = 'Error';
            $response['message'] = 'This overlaps with an existing reservation.';
        }
        return $response;
    }

    public function postStopSellOfRateType(Request $request)
    {
        $ratetypeid = $request->ratetypeid;
        $restriction = $request->restriction;
        $status = $request->status;
        $restrictValue = "";
        if ($restriction !== "stop_availability" && $ratetypeid === "") {
            $response = collect();
            $response['result'] = 'Error';
            $response['message'] = "Rate type cannot be empty";
            return $response;
        } else {
            if ($restriction === "stop_sell" || $restriction === "closed_to_arrival" || $restriction === "closed_to_departure" || $restriction === "stop_availability") {
                $restrictValue = $status;
                if ($status == "true") {
                    $status = true;
                } else {
                    $status = false;
                }
            } else {
                DB::transaction(function () use ($status, $request) {
                    $restrictValue = $request->value;
                    $minstayValue = $restrictValue;
                    $startdate = Carbon::parse($request->start);
                    $enddate = Carbon::parse($request->end);
                    $roomtypeid = $request->roomtypeid;
                    $ratetypeid = $request->ratetypeid;
                    $restriction = $request->restriction;
                    if ($restriction == "min_stay_arrival" && $restrictValue == "1") {
                        Restriction::where('name', $restriction)->where('room_type_id', $roomtypeid)
                            ->where('rate_type_id', $ratetypeid)->whereBetween('date', [$startdate, $enddate])->delete();
                    } else {
                        $start = $startdate;
                        $restrictdata = "";
                        while ($start <= $enddate) {
                            $getexists = Restriction::where('name', $restriction)->where('room_type_id', $roomtypeid)
                                ->where('rate_type_id', $ratetypeid)->whereDate('date', $start)->count();
                            if ($getexists > 0) {
                                $restriction = Restriction::where('name', $restriction)->where('room_type_id', $roomtypeid)
                                    ->where('rate_type_id', $ratetypeid)->whereDate('date', $start)->update([
                                        'value' => $restrictValue
                                    ]);
                            } else {
                                Restriction::create([
                                    'name' => $restriction,
                                    'date' => $start,
                                    'value' => $restrictValue,
                                    'room_type_id' => $roomtypeid,
                                    'rate_type_id' => $ratetypeid,
                                ]);
                            }
                            $start = $start->addDay();
                        }
                    }
                    $url = "/restrictions";
                    $property = "";
                    $properties = getHotelSettings();
                    $property = $properties->property_id;
                    if ($ratetypeid !== "") {
                        $channexRatetypeid = getHotelSettings()->rate_types()->find($ratetypeid)->channex_id;
                    }
                    if ($roomtypeid !== "") {
                        $channexRoomtypeid = getHotelSettings()->room_types()->find($roomtypeid)->channex_room_type_id;
                    }
                    $fulldata = array();
                    if ($restriction === "stop_availability" && $restrictValue == "true") {
                        $url = "/availability";
                        if ($restrictValue === "true") {
                            $innerdata = ["property_id" => $property,
                                "room_type_id" => $channexRoomtypeid,
                                "date_from" => $startdate,
                                "date_to" => $enddate,
                                "availability" => 0];
                            array_push($fulldata, $innerdata);
                        }
                    } else if ($restriction === "stop_availability" && $restrictValue == "false") {
                        $url = "/availability";
                        $totalRooms = Room::where('room_type_id', $roomtypeid)->active()->count();
                        $starts = $startdate;
                        while ($starts <= $enddate) {
                            $occupied = Availability::whereHas('room', fn($q) => $q->active())->where('room_type_id', $roomtypeid)
                                ->whereDate('date', $starts)->count();
                            $availableRooms = $totalRooms - $occupied;
                            $innerdata = [
                                "property_id" => $property,
                                "room_type_id" => $channexRoomtypeid,
                                "date" => $starts,
                                "availability" => $availableRooms
                            ];
                            array_push($fulldata, $innerdata);
                            $starts = date('Y-m-d', strtotime($starts . '+ 1 days'));
                        }
                    } else {
                        if ($restriction === "stop_sell" || $restriction === "closed_to_arrival" || $restriction === "closed_to_departure") {
                            $innerdata = [
                                "property_id" => $property,
                                "rate_plan_id" => $channexRatetypeid,
                                "date_from" => $startdate,
                                "date_to" => $enddate,
                                $restriction => $status
                            ];
                            array_push($fulldata, $innerdata);
                        } else {
                            $innerdata = [
                                "property_id" => $property,
                                "rate_plan_id" => $channexRatetypeid,
                                "date_from" => $startdate,
                                "date_to" => $enddate,
                                $restriction => $minstayValue
                            ];
                            array_push($fulldata, $innerdata);
                        }
                    }
                    $data = [
                        "values" => $fulldata
                    ];

                    // $request = Http::withHeaders([
                    //     'Content-Type' => 'application/json',
                    //     'user-api-key' => config('services.channex.api_key'),
                    // ])->post($url, $data);
                    // $request->throw();
                });
                $response = collect();
                $response['result'] = 'OK';
                $response['message'] = 'Successfully Updated';
                return $response;
            }
        }
    }

    public function postResizeOutOfOrder(Request $request)
    {
        $maintenance = Maintenance::find($request->id);
        $thisroom = $maintenance->room_id;
        $hotel_settings = getHotelSettings();
        $property = $hotel_settings->property_id;
        $roomId = $maintenance->rooms_id;
        $checkIn = Carbon::parse($maintenance->start_date);
        $checkOut = Carbon::parse($maintenance->end_date);
        $maintenance->start_date = $request->newStart;
        $maintenance->end_date = $request->newEnd;
        $maintenance->save();
        $roomtype = $maintenance->room->room_type_id;
        $roomtypeId = $maintenance->room->room_type->channex_room_type_id;
        $totalRooms = Room::active()->where('room_type_id', $roomtype)->count();
        Availability::where('reservation_id', "a" . $maintenance->id)->delete();
        while ($checkIn < $checkOut) {
            $occupied = Availability::whereHas('room', fn($q) => $q->active())->where('room_type_id', $roomtype)->whereDate('date', $checkIn)->count();
            $availableRooms = $totalRooms - $occupied;
            $availabilityUrl = "/availability";
            $dataav = [
                "values" => [
                    [
                        "property_id" => $property,
                        "room_type_id" => $roomtypeId,
                        "date" => $checkIn,
                        "availability" => $availableRooms
                    ],
                ]
            ];
                // $request = Http::withHeaders([
                //     'Content-Type' => 'application/json',
                //     'user-api-key' => config('services.channex.api_key'),
                // ])->post($availabilityUrl, $dataav);
                // $request->throw();
            $checkIn = $checkIn->addDay();
        }
        $start = $maintenance->start_date;
        $end = Carbon::parse($maintenance->end_date);
        $roomid = $maintenance->room_id;
        $id = $maintenance->id;
        $starts = Carbon::parse($start);
        while ($starts < $end) {
            Availability::create([
                'room_type_id' => $roomtype,
                'room_id' => $roomid,
                'date' => $starts,
                'reservation_id' => $id,
            ]);
            $starts = $starts->addDay();
        }
        $starts = Carbon::parse($start);
        while ($starts < $end) {
            $occupied = Availability::whereHas('room', fn($q) => $q->active())->where('room_type_id', $roomtype)->whereDate('date', $starts)->count();
            $availableRooms = $totalRooms - $occupied;
            $availabilityUrl = "/availability";
            $dataav = [
                "values" => [
                    [
                        "property_id" => $property,
                        "room_type_id" => $roomtypeId,
                        "date" => $starts,
                        "availability" => $availableRooms
                    ],
                ]
            ];
//                $client=new Client();
//                $request=$client->post($availabilityUrl,[
//                    'headers'=>['Content-Type'=>'application/json','Authorization'=>'Bearer '.$token],
//                    'body'=>json_encode($dataav)
//                ]);
//                $result=json_decode($request->getBody(),true);
            $starts = $starts->addDay();
        }
        $response = collect();
        $response['result'] = 'OK';
        $response['message'] = 'Successfully resized out of order';
        return $response;
    }

    public function getOutOfOrderForResize(Request $request)
    {
        $maintenance = Maintenance::find($request->id);
        $result = array();
        $data = collect();
        $data['id'] = $maintenance->id;
        $data['checkin'] = $maintenance->start_date;
        $data['checkout'] = $maintenance->end_date;
        $data['roomid'] = $maintenance->rooms_id;
        $data['roomtypeid'] = $maintenance->room->room_type_id;
        $data['roomno'] = $maintenance->room->number;
        $result[] = $data;
        return $result;
    }

    public function deleteOutOfOrder(Request $request)
    {
        $maintenance = Maintenance::find($request->id);
        $start = $maintenance->start_date;
        $starts = Carbon::parse($start);
        $end = Carbon::parse($maintenance->end_date);
        $roomid = $maintenance->rooms_id;
        $roomtype = $maintenance->room->room_type_id;
        $roomtypeid = $maintenance->room->room_type->channex_room_type_id;
        $hotel_settings = getHotelSettings();
        $property = $hotel_settings->property_id;
        $totalRooms = Room::where('room_type_id', $roomtype)->where('status', 'Enabled')->count();
        Availability::where('reservation_id', $maintenance->id)->delete();
        while ($starts < $end) {
            $occupied = Availability::whereHas('room', fn($q) => $q->active())->where('room_type_id', $roomtype)->whereDate('date', $starts)->count();
            $availableRooms = $totalRooms - $occupied;
            $availabilityUrl = "/availability";
            $dataav = [
                "values" => [
                    [
                        "property_id" => $property,
                        "room_type_id" => $roomtypeid,
                        "date" => $starts,
                        "availability" => $availableRooms
                    ],
                ]
            ];
//            $client = new Client();
//            $request = $client->post($availabilityUrl, [
//                'headers' => ['Content-Type' => 'application/json', 'Authorization' => 'Bearer ' . $token],
//                'body' => json_encode($dataav)
//            ]);
            $starts = $starts->addDay();
        }
        ;
        $response = collect();
        if ($maintenance->delete()) {
            $response['status'] = "Success";
            $response['message'] = "Out of order room deleted";
        } else {
            $response['status'] = "Error";
            $response['message'] = "Something went wrong";
        }
    }

    public function test()
    {
        $request = new Request([
            'year' => '2022',
            'month' => '2',
        ]);
        dd($this->getAvailableRooms($request));
    }

    private function populateRoomCondition($room_id, $checkin, $checkout, $cleanDays, $dirtyAfter, $reservation_id)
    {
        $condition = RoomCondition::whereDate('date', $checkin)->where('room_id', $room_id)->first();
        $wasdeparture = ($condition) ? "yes" : "no";
        $cleandays = (int)$cleanDays;
        $dirtyafter = (int)$dirtyAfter;
        $countclean = 1;
        $daycounter = 0;
        $roomstatus = "Dirty";
        while ($checkin <= $checkout) {
            $daycounter = $daycounter + 1;
            if ($daycounter < 3) {
                if ($wasdeparture == "yes" && $daycounter == 1) {
                    $roomstatus = "Dirty";
                } else {
                    $roomstatus = "Clean";
                }
            } else {
                if ($countclean == 1) {
                    $roomstatus = "Dirty";
                    $countclean = $countclean + 1;
                } else if ($countclean < $cleandays) {
                    $roomstatus = "Clean";
                    $countclean = $countclean + 1;
                } else if ($countclean == $cleandays) {
                    $roomstatus = "Clean";
                    $countclean = 1;
                }
            }
            RoomCondition::create([
                'room_id' => $room_id,
                'date' => $checkin,
                'status' => $roomstatus,
                'reservation_id' => $reservation_id,
            ]);
            $checkin = $checkin->addDay();
        }
    }
}

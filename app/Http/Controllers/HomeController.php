<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\BookingAgency;
use App\Models\Company;
use App\Models\DailyRate;
use App\Models\Guest;
use App\Models\GuestAccommodationPayment;
use App\Models\GuestExtrasPayment;
use App\Models\OpexData;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomeController extends Controller
{

    public function index()
    {
        //Carbon::setTestNow(Carbon::createFromDate(2022, 9, 14));

        $today = now()->format('Y-m-d');
        $checkInCount = getHotelSettings()->reservations()->where('status', '!=', 'Cancelled')->where('channex_status', '!=', 'Cancelled')
            ->whereDate('arrival_date', $today)
            ->where("reservations.arrival_date", "!=", DB::raw("reservations.departure_date"))
            ->whereNull('actual_checkin')->count();

        $checkOutCount = getHotelSettings()->reservations()->where(function ($mainQuery) {
            $mainQuery->where(function ($query) {
                $query->where("reservations.arrival_date", "=", DB::raw("reservations.departure_date"))
                    ->where("reservations.status", "=", "No Show");
            });
            $mainQuery->orWhere(function ($query) {
                $query->whereBetween("reservations.departure_date", [Carbon::today()->subDays(30)->format('Y-m-d'), Carbon::today()->format('Y-m-d')])
                    ->where("reservations.status", "=", "Arrived");
            });
            $mainQuery->orWhere(function ($query) {
                $query->whereNotNull("actual_checkout")
                    ->where("reservations.status", "=", "Arrived");
            });
        })->count();

        $inHouseCount = getHotelSettings()->reservations()->where('status', 'Arrived')->count();

        $getRevenue = DailyRate::selectRaw('SUM(price) AS totalPrice, COUNT(*) AS totalRows')
            ->join('reservations', 'daily_rates.reservation_id', '=', 'reservations.id')
            ->join('rooms', 'reservations.room_id', '=', 'rooms.id')
            ->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
            ->where('reservations.hotel_settings_id', getHotelSettings()->id)
            ->whereDate('daily_rates.date', $today)
            ->whereDate('daily_rates.date', '>=', DB::raw('reservations.actual_checkin'))
            ->where(function ($query) {
                $query->whereDate('daily_rates.date', '<=', DB::raw('reservations.actual_checkout'))
                    ->orWhereNull('reservations.actual_checkout');
            })->where('reservations.status', '!=', 'Cancelled')
            ->where('rooms.status', 'Enabled')
            ->where('room_types.type_status', '1')
            ->first();
        $totalRevenue = $getRevenue->totalPrice;
        $average = 0;
        if ($getRevenue->totalRows > 0) {
            $average = (float) $totalRevenue / (int) $getRevenue->totalRows;
            $average = number_format((float) $average, 2, '.', '');
        }

        $totalRoomsDay = Room::join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
            ->where('rooms.status', 'Enabled')
            ->where('room_types.type_status', '1')
            ->where('room_types.hotel_settings_id', getHotelSettings()->id)
            ->count();

        $dailyooorooms = Availability::join('rooms', 'rooms.id', '=', 'availabilities.room_id')
            ->join('room_types', 'room_types.id', '=', 'availabilities.room_type_id')
            ->where('availabilities.reservation_id', 'LIKE', 'a%')
            ->where('availabilities.date', '=', today()->format('Y-m-d'))
            ->where('rooms.status', 'Enabled')
            ->where('room_types.type_status', '1')
            ->where('room_types.hotel_settings_id', getHotelSettings()->id)
            ->count();

        $availableRoomsday = $totalRoomsDay - $dailyooorooms;

        $revpar = 0;
        if ($totalRevenue == 0 || $availableRoomsday == 0) {
            $revpar = 0;
        } else {
            $revpar = $totalRevenue / $availableRoomsday;
            $revpar = number_format((float) $revpar, 2, '.', '');
        }

        $countOccupiedRooms = Availability::join('rooms', 'rooms.id', '=', 'availabilities.room_id')
            ->join('room_types', 'room_types.id', '=', 'availabilities.room_type_id')
            ->where('availabilities.reservation_id', 'NOT LIKE', 'a%')
            ->where('availabilities.date', '=', today()->format('Y-m-d'))
            ->where('rooms.status', 'Enabled')
            ->where('room_types.type_status', '1')
            ->where('room_types.hotel_settings_id', getHotelSettings()->id)
            ->count();

        // calculate today occupancy
        if ($countOccupiedRooms == 0 || $availableRoomsday == 0) {
            $occupancy = 0;
        } else {
            $occupancy = (int) $countOccupiedRooms / (int) $availableRoomsday * 100;
        }
        $occupancy = number_format((float) $occupancy, 0, '.', '');

        $sumEmptyRooms = $availableRoomsday - $countOccupiedRooms;
        /* $date = date('Y-m-d');
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        $endday = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $startmonth = $year . "-" . $month . "-01";
        $endmonth = $year . "-" . $month . "-" . $endday;
        $startyear = $year . "-01-01";
        $endyear = $year . "-12-31"; */
        $startyear = today()->startOfYear()->toDateString();
        $endyear = today()->endOfYear()->toDateString();
        $startmonth = today()->startOfMonth()->toDateString();
        $endmonth = today()->endOfMonth()->toDateString();
        $startday = today()->startOfDay()->toDateString();
        $endday = today()->endOfDay()->toDateString();
        $occupiedMonthRooms = Availability::join('rooms', 'rooms.id', '=', 'availabilities.room_id')
            ->join('room_types', 'room_types.id', '=', 'availabilities.room_type_id')
            ->where('availabilities.reservation_id', 'NOT LIKE', 'a%')
            ->whereDate('availabilities.date', '>=', $startmonth)
            ->whereDate('availabilities.date', '<=', $endmonth)
            ->where('rooms.status', 'Enabled')
            ->where('room_types.type_status', '1')
            ->where('room_types.hotel_settings_id', getHotelSettings()->id)
            ->count();
        $monthlyooorooms = Availability::join('rooms', 'rooms.id', '=', 'availabilities.room_id')
            ->join('room_types', 'room_types.id', '=', 'availabilities.room_type_id')
            ->where('availabilities.reservation_id', 'LIKE', 'a%')
            ->whereDate('availabilities.date', '>=', $startmonth)
            ->whereDate('availabilities.date', '<=', $endmonth)
            ->where('rooms.status', 'Enabled')
            ->where('room_types.type_status', '1')
            ->where('room_types.hotel_settings_id', getHotelSettings()->id)
            ->count();
        $daysinmonth = Carbon::parse($startmonth)->diffInDays(Carbon::parse($endmonth));
        $totalRoomsmonth = (int) $totalRoomsDay * (int) $daysinmonth;
        $availableRoomsMonth = $totalRoomsmonth - $monthlyooorooms;
        if ($availableRoomsMonth == 0 || $occupiedMonthRooms == 0) {
            $monthlyoccupancy = 0;
        } else {
            $monthlyoccupancy = ((int) $occupiedMonthRooms / (int) $availableRoomsMonth) * 100;
        }
        $monthlyoccupancy = number_format((float) $monthlyoccupancy, 0, '.', '');

        $occupiedYearRooms = Availability::join('rooms', 'rooms.id', '=', 'availabilities.room_id')
            ->join('room_types', 'room_types.id', '=', 'availabilities.room_type_id')
            ->where('availabilities.reservation_id', 'NOT LIKE', 'a%')
            ->whereDate('availabilities.date', '>=', $startyear)
            ->whereDate('availabilities.date', '<=', $endyear)
            ->where('rooms.status', 'Enabled')
            ->where('room_types.type_status', '1')
            ->where('room_types.hotel_settings_id', getHotelSettings()->id)
            ->count();
        $yearlyooorooms = Availability::join('rooms', 'rooms.id', '=', 'availabilities.room_id')
            ->join('room_types', 'room_types.id', '=', 'availabilities.room_type_id')
            ->where('availabilities.reservation_id', 'LIKE', 'a%')
            ->whereDate('availabilities.date', '>=', $startyear)
            ->whereDate('availabilities.date', '<=', $endyear)
            ->where('rooms.status', 'Enabled')
            ->where('room_types.type_status', '1')
            ->where('room_types.hotel_settings_id', getHotelSettings()->id)
            ->count();
        $daysinyear = Carbon::parse($startyear)->diffInDays(Carbon::parse($endyear));
        $totalRoomsyear = (int) $totalRoomsDay * (int) $daysinyear;
        $availableRoomsYear = $totalRoomsyear - $yearlyooorooms;
        if ($availableRoomsYear == 0 || $occupiedYearRooms == 0) {
            $yearlyoccupancy = 0;
        } else {
            $yearlyoccupancy = ((int) $occupiedYearRooms / (int) $availableRoomsYear) * 100;
        }
        $yearlyoccupancy = number_format((float) $yearlyoccupancy, 0, '.', '');
        $totalRoomRevenue = OpexData::where('cos_id', '=', 1)->where('date', '=', today()->toDateString())->sum('amount');
        if ($countOccupiedRooms == 0 || $totalRoomRevenue == 0) {
            $cpor = 0;
        } else {
            $cpor = (float) ($totalRoomRevenue / $countOccupiedRooms);
            $cpor = number_format((float) $cpor, 2, '.', '');
        }

        $monthlyRoomRevenue = OpexData::where('cos_id', '=', 1)->whereDate('date', '>=', $startmonth)->whereDate('date', '<=', $endmonth)->sum('amount');
        $reservmonth = 0;
        $nightsmonth = 0;

        /* SELECT COUNT(*) as total FROM `availability` a INNER JOIN `reservations` s
        ON a.reservation_id=s.reservation_id
        INNER JOIN `rooms` ON rooms.room_id=a.room_id
        INNER JOIN `room_types` ON room_types.room_type_id=rooms.room_type_id
        WHERE a.date BETWEEN '$startmonth' AND '$endmonth'
        AND rooms.room_status='Enabled' AND room_types.type_status='1' GROUP BY a.reservation_id */
        $reservmonthQuery = Reservation::selectRaw('count(*) as total')
            ->join('availabilities', 'availabilities.reservation_id', '=', 'reservations.id')
            ->join('rooms', 'rooms.id', '=', 'availabilities.room_id')
            ->join('room_types', 'room_types.id', '=', 'availabilities.room_type_id')
            ->where('reservations.hotel_settings_id', getHotelSettings()->id)
            ->whereDate('availabilities.date', '>=', $startmonth)
            ->whereDate('availabilities.date', '<=', $endmonth)
            ->where('rooms.status', 'Enabled')
            ->where('room_types.type_status', '1')
            ->groupBy('availabilities.reservation_id')
            ->get();
        foreach ($reservmonthQuery as $reserv) {
            $nightsmonth += (int) $reserv['total'];
            $reservmonth++;
        }
        if ($reservmonth == 0 || $monthlyRoomRevenue == 0) {
            $cosperb = 0;
        } else {
            $cosperb = (int) $monthlyRoomRevenue / (int) $reservmonth;
            $cosperb = number_format($cosperb, 2, '.', '');
        }

        if ($nightsmonth == 0 || $reservmonth == 0) {
            $los = 0;
        } else {
            $los = (int) $nightsmonth / (int) $reservmonth;
        }
        $los = number_format((float) $los, 2, '.', '');

        /* SELECT SUM(daily_rate_price) AS totalmonthrevenue FROM daily_rates
        INNER JOIN reservations ON daily_rates.daily_rate_reservation=reservations.reservation_id
        INNER JOIN `rooms` ON reservations.room_id=rooms.room_id
        INNER JOIN `room_types` ON rooms.room_type_id=room_types.room_type_id
        WHERE daily_rates.daily_rate_date BETWEEN '$startmonth' AND '$endmonth'
        AND reservations.reservation_status!='Cancelled'
        AND rooms.room_status='Enabled' AND room_types.type_status='1' ; */
        $accomRevenue = DailyRate::join('reservations', 'reservations.id', '=', 'daily_rates.reservation_id')
            ->join('rooms', 'rooms.id', '=', 'reservations.room_id')
            ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
            ->where('reservations.hotel_settings_id', getHotelSettings()->id)
            ->where('daily_rates.date', '>=', $startmonth)
            ->where('daily_rates.date', '<=', $endmonth)
            ->where('reservations.status', '!=', 'Cancelled')
            ->where('rooms.status', 'Enabled')
            ->where('room_types.type_status', '1')
            ->sum("price");

        /* SELECT * FROM `daily_rates` INNER JOIN `reservations`
        ON daily_rates.daily_rate_reservation=reservations.reservation_id
        INNER JOIN `rooms` ON reservations.room_id=rooms.room_id
        INNER JOIN `room_types` ON rooms.room_type_id=room_types.room_type_id
        INNER JOIN `rate_types` ON reservations.rate_type_id=rate_types.rate_type_id
        INNER JOIN `rate_type_categories` ON rate_types.rate_type_category=rate_type_categories.rate_type_category_id
        WHERE daily_rates.daily_rate_date BETWEEN '$startmonth' AND '$endmonth'
        AND (reservations.reservation_status!='Cancelled'
        OR reservations.channex_status!='cancelled')
        AND rooms.room_status='Enabled' AND room_types.type_status='1'
        AND rate_type_categories.has_breakfast='1'   */
        $queryResult = DailyRate::select("rate_types.charge_type", "reservations.check_in", "daily_rates.date", "daily_rates.price", "rate_types.charge_percentage")
            ->join('reservations', 'reservations.id', '=', 'daily_rates.reservation_id')
            ->join('rooms', 'rooms.id', '=', 'reservations.room_id')
            ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
            ->join('rate_types', 'rate_types.id', '=', 'reservations.rate_type_id')
            ->join('rate_type_categories', 'rate_type_categories.id', '=', 'rate_types.rate_type_category_id')
            ->where('reservations.hotel_settings_id', getHotelSettings()->id)
            ->whereDate('daily_rates.date', '>=', $startmonth)
            ->whereDate('daily_rates.date', '<=', $endmonth)
            ->where(function ($query) {
                $query->where('reservations.status', '!=', 'Cancelled')
                    ->orWhere('reservations.channex_status', '!=', 'cancelled');
            })
            ->where('rooms.status', 'Enabled')
            ->where('room_types.type_status', '1')
            ->where('rate_type_categories.has_breakfast', 'yes')
            ->get();


        $monthlyBreakfast = 0;
        foreach ($queryResult as $row) {
            $derivedValue = $row['charge_type'];
            $actualCheckin = $row['check_in'];
            $dailyrateDate = $row['date'];
            $dailyrate = $row['price'];
            if ($dailyrateDate < $actualCheckin) {
                continue;
            } else {

                if ($derivedValue == 0) {
                    $derivedpercentage = $row['charge_percentage'];
                    $reservationBreakfast = ((float) $dailyrate * (float) $derivedpercentage) / 100;

                } else {
                    $reservationBreakfast = $row['charge_percentage'];
                }
                $reservationBreakfast = number_format((float) $reservationBreakfast, 2, '.', '');
                $monthlyBreakfast += (float) $reservationBreakfast;
            }
        }

        $monthlyaccomrevenue = GuestAccommodationPayment::whereDate('date', '>=', $startmonth)
            ->whereDate('date', '<=', $endmonth)
            ->whereHas("reservation", function ($q) {
                $q->where("hotel_settings_id", getHotelSettings()->id);
            })
            ->sum('value');
        $monthlyextras = GuestExtrasPayment::whereDate('date', '>=', $startmonth)
            ->whereDate('date', '<=', $endmonth)
            ->whereHas("reservation", function ($q) {
                $q->where("hotel_settings_id", getHotelSettings()->id);
            })
            ->sum('value');

        $hotelRevenue = $monthlyaccomrevenue + $monthlyextras;

        /* SELECT SUM(document_total) AS creditNoteTotal
        FROM documents
        WHERE document_type= 6
        AND document_print_date BETWEEN '$startmonth' AND '$endmonth' ; */
        $totalCreditNoteRefundables = getHotelSettings()->documents()->where('document_type_id', '6')
            ->whereBetween('print_date', [$startmonth, $endmonth])
            ->sum('total');

        /* SELECT SUM(document_total) AS specialAnnulingTotal
        FROM documents
        WHERE document_type= 2
        AND document_print_date BETWEEN '$startmonth' AND '$endmonth' ; */
        $totalSpeciaAnnulingRefundables = getHotelSettings()->documents()->where('document_type_id', '2')
            ->whereBetween('print_date', [$startmonth, $endmonth])
            ->sum('total');
        $refundablesTotal = $totalCreditNoteRefundables + $totalSpeciaAnnulingRefundables;
        //Get Hotel Revenue Total
        $hotelRevenueTotal = $hotelRevenue - $refundablesTotal;

        /* Cashier checks */
        $showCashier = false;
        $getCashRegResult = getHotelSettings()->cash_registers()->where("status", "open")->orderBy("date", "DESC")->first();
        if ($getCashRegResult && isset($getCashRegResult->date) && $getCashRegResult->date) {
            $showCashier = true;
            $registerDate = Carbon::parse($getCashRegResult->date);
            $registerDate->setHour(23);
            $registerDate->setMinute(59);
            $getCashRegResult->date = $registerDate;
        }

        return view('home', [
            'checkInCount' => $checkInCount,
            'checkOutCount' => $checkOutCount,
            'inHouseCount' => $inHouseCount,
            'sumEmptyRooms' => $sumEmptyRooms,
            'occupancy' => $occupancy,
            'monthlyoccupancy' => $monthlyoccupancy,
            'yearlyoccupancy' => $yearlyoccupancy,
            'average' => $average,
            "revpar" => $revpar,
            "cpor" => $cpor,
            "cosperb" => $cosperb,
            "los" => $los,
            "hotelRevenueTotal" => $hotelRevenueTotal,
            "accomRevenue" => $accomRevenue,
            "monthlyBreakfast" => $monthlyBreakfast,
            'showCashier' => $showCashier,
            // 'cashRegisterDate' => $getCashRegResult?->date ?? "",
        ]);
    }

    public function comments()
    {
        return view('front.comments.comments');
    }

    public function getAvailableRoomsByDate(Request $request)
    {
        $dateselected = $request->input('date');

        $totalRoomsDay = Room::join('room_types', 'room_types.id', '=', 'rooms.room_type_id')->where('rooms.status', 'Enabled')
            ->where('room_types.type_status', '1')
            ->where('room_types.hotel_settings_id', getHotelSettings()->id)
            ->count();

        $dailyooorooms = Availability::join('rooms', 'rooms.id', '=', 'availabilities.room_id')
            ->join('room_types', 'room_types.id', '=', 'availabilities.room_type_id')
            ->where('availabilities.reservation_id', 'LIKE', 'a%')
            ->whereDate('availabilities.date', '=', $dateselected)
            ->where('rooms.status', 'Enabled')
            ->where('room_types.type_status', '1')
            ->where('room_types.hotel_settings_id', getHotelSettings()->id)
            ->count();

        $availableRoomsday = $totalRoomsDay - $dailyooorooms;
        $countOccupiedRooms = Availability::join('rooms', 'rooms.id', '=', 'availabilities.room_id')
            ->join('room_types', 'room_types.id', '=', 'availabilities.room_type_id')
            ->where('availabilities.reservation_id', 'NOT LIKE', 'a%')
            ->whereDate('availabilities.date', '=', $dateselected)
            ->where('rooms.status', 'Enabled')
            ->where('room_types.type_status', '1')
            ->where('room_types.hotel_settings_id', getHotelSettings()->id)
            ->count();
        $sumEmptyRooms = $availableRoomsday - $countOccupiedRooms;
        return new JsonResponse([
            'sumEmptyRooms' => $sumEmptyRooms,
        ]);
    }

    public function addTestReservation($checkIn = null, $checkOut = null, $status = "New", $discount = 0)
    {
        if (is_null($checkIn)) {
            $checkIn = Carbon::now()->subDays(random_int(1, 10));
        }
        if (is_null($checkOut)) {
            $checkOut = Carbon::now()->addDays(random_int(1, 10));
        }
        //faker
        $faker = Factory::create();
        $guest = new Guest;
        $guest->full_name = $faker->name;
        $guest->email = $faker->email;
        $guest->email_2 = $faker->email;
        $guest->country_id = $faker->numberBetween(1, 230);
        $guest->city = $faker->city;
        $guest->address = $faker->address;
        $guest->language = $faker->languageCode;
        $guest->phone = $faker->phoneNumber;
        $guest->mobile = $faker->phoneNumber;
        $guest->postal_code = $faker->postcode;
        $guest->save();

        $r = new Reservation;
        $r->hotel_settings_id = "1";
        $r->booking_code = "dfx-test-" . Str::random(5);
        $r->channex_status = "new";
        $r->status = $status;
        $r->booking_agency_id = BookingAgency::first()->id;
        $r->company_id = Company::first()->id;
        $r->payment_method_id = 2;
        $r->payment_mode_id = 2;
        $r->discount = $discount;
        $r->check_in = $checkIn;
        $r->check_out = $checkOut;
        $r->arrival_date = $r->check_in;
        $r->departure_date = $r->check_out;
        $r->country_id = $faker->numberBetween(1, 230);
        $r->adults = random_int(1, 5);
        $r->kids = random_int(0, 5);
        $r->infants = random_int(0, 5);
        $r->booking_date = Carbon::parse($r->check_in)->subDay();
        $r->guest_id = $guest->id;
        $r->rate_type_id = "1";
        $r->room_id = random_int(1, 7);
        $r->overnights = Carbon::parse($r->check_in)->diffInDays(Carbon::parse($r->check_out));
        if ($status == "Arrived") {
            $r->actual_checkin = $checkIn;
        }
        $r->reservation_amount = Carbon::parse($r->check_in)->diffInDays(Carbon::parse($r->check_out)) * 100;

        $r->save();

        //for loop from '2022-08-15' to '2022-08-22'
        $start = Carbon::parse($r->check_in);
        $end = Carbon::parse($r->check_out);
        $days = $start->diffInDays($end);
        for ($i = 0; $i < $days; $i++) {
            $d = new Availability;
            $d->reservation_id = $r->id;
            $d->date = $start->format('Y-m-d');
            $d->room_id = $r->room_id;
            $d->room_type_id = 1;
            $d->save();

            $d = new DailyRate;
            $d->reservation_id = $r->id;
            $d->date = $start->format('Y-m-d');
            $d->price = 100;
            $d->save();

            $start->addDay();
        }

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Country;
use App\Models\Document;
use App\Models\ExReservation;
use App\Models\Guest;
use App\Models\GuestAccommodationPayment;
use App\Models\GuestOvernightTaxPayment;
use App\Models\Reservation;
use App\Models\ReservationExtraCharge;
use App\Models\Template;
use App\Models\Availability;
use App\Models\RoomCondition;
use App\Models\Room;
use App\Models\Property;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Rap2hpoutre\FastExcel\FastExcel;
use RealRashid\SweetAlert\Facades\Alert;

class ReservationController extends Controller
{
    function list(Request $request) {
        $request->validate([
            'from_date' => ['nullable', 'date'],
            'to_date' => ['nullable', 'date', 'after:from_date'],
            'status' => ['nullable', 'string', Rule::in(["New", "Confirmed", "Modified", "Arrived", "Cancelled", "CheckedOut"])],
        ]);

        $reservations = getHotelSettings()->reservations();
        $view = 'front.Reservation.reservation_list';
        if (isset($request->status)) {
            if ($request->status == 'Modified') {
                $reservations = $reservations->where('channex_status', 'Modified');
                // $view = 'front.Reservation.modified_reservation_list';
            } else {
                $reservations = $reservations->where('status', $request->query('status'));
            }
        }
        if (isset($request->from_date)) {
            $reservations = $reservations->whereDate('check_in', '>=', $request->from_date);
        }
        if (isset($request->to_date)) {
            $reservations = $reservations->whereDate('check_in', '<=', $request->to_date);
        }
        return view($view)->with([
            'reservations' => $reservations->get(),
            'countries' => Country::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function makeCheckout($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->status = "CheckedOut";
        $reservation->save();

        //delete availabilities as $reservation->actual_checkin and $reservation->actual_checkout
        /* $reservation->availabilities()->where(function ($query) use ($reservation) {
        $query->whereDate('date', "<", $reservation->actual_checkin)->orWhereDate('date', ">", $reservation->actual_checkout);
        })->delete(); */

        return redirect()->route("home");
    }

    public function ex_reservation_list(Request $request)
    {
        $ex_reservations = getHotelSettings()->ex_reservations();

        $data = [
            'ex_reservations' => $ex_reservations->get(),
            'countries' => Country::orderBy('name')->get(['id', 'name']),
            'room_types' => getHotelSettings()->room_types()->orderBy('name')->get(['id', 'name']),
            'booking_agencies' => getHotelSettings()->booking_agencies()->orderBy('name')->get(['id', 'name']),
            'rate_types' => getHotelSettings()->rate_types()->orderBy('name')->get(['id', 'name', 'room_type_id']),
        ];

        return view('front.Reservation.ex_reservation_list')->with($data);
    }

    public function no_show_list(Request $request)
    {
        $request->validate([
            'from_date' => ['nullable', 'date'],
            'to_date' => ['nullable', 'date', 'after:from_date'],
        ]);

        $reservations = Reservation::whereNull('actual_checkin')->whereRelation('daily_rates', 'date', "<=", now()->format("Y-m-d"));

        if (isset($request->from_date)) {
            $reservations = $reservations->whereDate('check_in', '>=', $request->from_date);
        }
        if (isset($request->to_date)) {
            $reservations = $reservations->whereDate('check_in', '<=', $request->to_date);
        }

        $data = [
            'reservations' => $reservations->get(),
            'chart_data' => [
                "Jan" => 0,
                "Feb" => 0,
                "Mar" => 0,
                "Apr" => 0,
                "May" => 0,
                "Jun" => 0,
                "Jul" => 0,
                "Aug" => 0,
                "Sep" => 0,
                "Oct" => 0,
                "Nov" => 0,
                "Dec" => 0,
            ],
        ];
        $reservation_data = $data['reservations']->map(function ($reservation) {
            $reservation->arrival_month = Carbon::parse($reservation->arrival_date)->format('M');
            return $reservation;
        })->groupBy('arrival_month');

        foreach ($reservation_data as $key => $value) {
            $data['chart_data'][$key] = $value->count();
        }

        return view('front.Reservation.no_show_list')->with($data);
    }

    public function show(Reservation $reservation)
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

        $data = [
            'reservation' => $reservation,
            'templates' => Template::orderBy('name')->get(),
        ];

        return view('front.Reservation.reservation-show')->with($data);
    }

    public function ex_reservation_import_list(Request $request)
    {
        $request->validate([
            'reservations' => ['required', 'file', 'mimes:xls,xlsx'],
        ]);

        $reservations = (new FastExcel)->import($request->file('reservations'));
        $reservations = $reservations->map(function ($item) {
            $arr = [];
            foreach ($item as $key => $value) {
                $arr[str_replace(" ", "_", strtolower(trim($key)))] = trim($value);
            }
            return $arr;
        });

        try {

            $prev_reservations = ExReservation::pluck('booking_code');

            $db_reservations = collect([]);
            foreach ($reservations as $reservation) {
                if ($prev_reservations->where('booking_code', $reservation['reservation_code'])->count() == 0) {
                    $ex_reservation_data = [
                        'hotel_settings_id' => getHotelSettings()->id,
                        'indexes' => $reservation['a/a'],
                        'booking_code' => $reservation['reservation_code'],
                        'check_in' => Carbon::createFromFormat("m-d-Y", str_replace("/", "-", $reservation['checkin_date']))->format('Y-m-d'),
                        'check_out' => Carbon::createFromFormat("m-d-Y", str_replace("/", "-", $reservation['checkout_date']))->format('Y-m-d'),
                        'booking_date' => Carbon::createFromFormat("m-d-Y", str_replace("/", "-", $reservation['booking_date']))->format('Y-m-d'),
                        'total_amount' => $reservation['total_amount'],
                        'status' => $reservation['status'],
                        'guests' => $reservation['guests'],
                    ];

                    $booking_agency = getHotelSettings()->booking_agencies()->where('name', $reservation['source'])->first();
                    if ($booking_agency) {
                        $ex_reservation_data['booking_agency_id'] = $booking_agency->id;
                    } else {
                        throw new \Exception("Couldn't find the booking_agency with name " . $reservation['source'], 1);
                    }

                    $country = Country::where('name', $reservation['nationality'])->first();
                    if ($country) {
                        $ex_reservation_data['country_id'] = $country->id;
                    } else {
                        throw new \Exception("Couldn't find the country with name " . $reservation['nationality'], 1);
                    }

                    $room_type = getHotelSettings()->room_types()->where('name', $reservation['room_type'])->first();
                    if ($room_type) {
                        $ex_reservation_data['room_type_id'] = $room_type->id;
                    } else {
                        throw new \Exception("Couldn't find the room type with name " . $reservation['room_type'], 1);
                    }

                    $rate_type = getHotelSettings()->rate_types()->where('name', $reservation['rate'])->first();
                    if ($rate_type) {
                        $ex_reservation_data['rate_type_id'] = $rate_type->id;
                    } else {
                        throw new \Exception("Couldn't find the rate type with name " . $reservation['rate'], 1);
                    }

                    $db_reservations->push(ExReservation::create($ex_reservation_data));
                }
            }

            session()->flash('success', $db_reservations->count() . " Records Imported successfully and " . $reservations->count() - $db_reservations->count() . " Records skipped!");
            return redirect()->back(302, [], route('ex-reservations-list'));
        } catch (\Exception$e) {
            session()->flash('error', $e->getMessage() . " " . $db_reservations->count() . " Records inserted!");
            return redirect()->back(302, [], route('ex-reservations-list'));
        }
    }

    public function create()
    {
        return view('front.calendar.edit_create_reservation')->with([
            'id' => 0,
        ]);
    }

    public function ex_reservation_store(Request $request)
    {
        $request->validate([
            'booking_code' => ['required', 'string', 'min:1', 'max:255'],
            'checkin_date' => ['required', 'date'],
            'checkout_date' => ['required', 'date', 'after_or_equal:checkin_date'],
            'country' => ['required', 'numeric', 'exists:countries,id'],
            'guests' => ['required', 'string'],
            'reservation_amount' => ['required', 'numeric', 'min:0'],
            'room_type' => ['required', 'numeric', 'exists:room_types,id'],
            'booking_agency' => ['required', 'numeric', 'exists:booking_agencies,id'],
            'booking_status' => ['required', 'string', Rule::in(['Confirmed', "Cancelled"])],
            'booking_date' => ['required', 'date'],
            'rate_type' => ['required', 'numeric', 'exists:rate_types,id'],
        ]);

        $ex_reservation_data = [
            'hotel_settings_id' => getHotelSettings()->id,
            'indexes' => 0,
            'booking_code' => $request->booking_code,
            'check_in' => $request->checkin_date,
            'check_out' => $request->checkout_date,
            'booking_date' => $request->booking_date,
            'total_amount' => $request->reservation_amount,
            'status' => $request->booking_status,
            'booking_agency_id' => $request->booking_agency,
            'country_id' => $request->country,
            'room_type_id' => $request->room_type,
            'guests' => $request->guests,
            'rate_type_id' => $request->rate_type,
        ];

        $ex_reservation = ExReservation::create($ex_reservation_data);

        if (!$ex_reservation) {
            session()->flash('error', "Server error while trying to create the ex-reservation.");
        } else {
            session()->flash('success', "The ex-reservation has been created successfully!");
        }

        return redirect()->back(302, [], route('ex-reservations-list'));
    }

    public function add_reservation_guest(Request $request)
    {
        $request->validate([
            'reservation_id' => ['required', 'numeric', 'exists:reservations,id'],
            'guest_id' => ['required', 'numeric', 'exists:guests,id'],
            'matched_guest_id' => ['nullable', 'numeric', 'exists:guests,id'],
            'guest_full_name' => ['required', 'string', 'min:1', 'max:255'],
            'guest_email_1' => ['required', 'email'],
            'guest_email_2' => ['nullable', 'email'],
            'guest_country' => ['nullable', 'exists:countries,id'],
            'guest_phone' => ['required', 'string', 'min:3', 'max:125'],
            'guest_mobile' => ['nullable', 'string', 'min:3', 'max:125'],
            'guest_postal_code' => ['nullable', 'string', 'min:3', 'max:125'],
            'operation' => ['required', 'string', Rule::in(['update_and_attach_guest', 'create_new_guest', 'skip_guest_check', 'update_guest'])],
            'guest_info_match' => ['required', function ($attribute, $value, $fail) use ($request) {
                if (in_array($request->operation, ['update_and_attach_guest', 'skip_guest_check', 'update_guest'])) {
                    return;
                }

                $matched_guest = Guest::where(function ($q) use ($request) {
                    $q->whereNull('full_name')
                        ->orWhere('full_name', $request->guest_full_name);
                })->where(function ($q) use ($request) {
                    $q->whereNull('email')
                        ->orWhere('email', $request->guest_email_1);
                })->where(function ($q) use ($request) {
                    $q->whereNull('email_2')
                        ->orWhere('email_2', $request->guest_email_2);
                })->where(function ($q) use ($request) {
                    $q->whereNull('country_id')
                        ->orWhere('country_id', $request->guest_country);
                })->where(function ($q) use ($request) {
                    $q->whereNull('phone')
                        ->orWhere('phone', $request->guest_phone);
                })->where(function ($q) use ($request) {
                    $q->whereNull('mobile')
                        ->orWhere('mobile', $request->guest_mobile);
                })->where(function ($q) use ($request) {
                    $q->whereNull('postal_code')
                        ->orWhere('postal_code', $request->guest_postal_code);
                })
                    ->first();
                if ($matched_guest) {
                    $fail($matched_guest->id);
                }
            }],
        ]);

        $reservation = Reservation::where('id', $request->reservation_id)->first();
        if (!$reservation) {
            abort(404);
        }

        $data = [
            'hotel_settings_id' => getHotelSettings()->id,
            'full_name' => $request->guest_full_name,
            'email' => $request->guest_email_1,
            'email_2' => $request->guest_email_2,
            'country_id' => $request->guest_country,
            'phone' => $request->guest_phone,
            'mobile' => $request->guest_mobile,
            'postal_code' => $request->guest_postal_code,
        ];

        try {
            if ($request->operation == 'update_guest') {
                Guest::where('id', $request->guest_id)->update($data);
            } else if ($request->operation == 'update_and_attach_guest') {
                Guest::where('id', $request->matched_guest_id)->update($data);
                $reservation->update(['guest_id' => $request->matched_guest_id]);
            } else if (in_array($request->operation, ['skip_guest_check', 'skip_guest_check'])) {
                $guest = Guest::create($data);
                $reservation->update(['guest_id' => $guest->id]);
            } else {
                throw new \Exception("Error Processing Request", 1);
            }

            session()->flash('success', "Guest Information updated successfully!");
            return redirect()->route('reservations-list');

        } catch (\Exception$e) {
            session()->flash('error', $e->getMessage() ?? "Server encountered an error!");
            return redirect()->back(302, [], route('reservations-list'))->withInput($request->all());
        }
    }

    public function cancelled_reservation_print(Reservation $reservation)
    {
        $data = [
            'reservation' => $reservation,
        ];

        return view('front.Reservation.cancelled_reservation_print', $data);
    }

    public function editReservation($id)
    {
        return view('front.calendar.edit_create_reservation')->with([
            'id' => $id,
        ]);
    }

    public function companiesList(Request $request)
    {
        $companies = Company::query();
        return view('front.Company.company_list')->with([
            'companies' => $companies->get(),
        ]);
    }
    public function companyFolio(Request $request)
    {
        $company_id = $request->id;

        $docs = Document::select("documents.id as document_id", "documents.paid", "document_types.type")
            ->join('document_infos', 'document_infos.document_id', '=', 'documents.id')
            ->join('document_types', 'document_types.id', '=', 'documents.document_type_id')
            ->join('payment_methods', 'payment_methods.id', '=', 'documents.payment_method_id')
            ->whereIn('document_types.type', [4, 6])
            ->where('document_infos.company_id', $company_id)
            ->get();

        $tbodyTrs = "";
        foreach ($docs as $doc) {
            $documentId = $doc['document_id'];
            $documentStatus = $doc['paid'] == 0 ? "Unpaid" : "Paid";
            $reservation = Reservation::select("reservations.id as booking_id", "guests.full_name as guest_name", "reservations.reservation_amount", "booking_agencies.name as agency_name")
                ->join('booking_agencies', 'booking_agencies.id', '=', 'reservations.booking_agency_id')
                ->join('activities', 'activities.reservation_id', '=', 'reservations.id')
                ->join('guests', 'guests.id', '=', 'reservations.guest_id')
                ->where('activities.document_id', $documentId)
                ->first();
            if ($reservation) {
                $tbodyTrs .= "<tr>";
                $tbodyTrs .= "<td>" . $documentId . "</td>";
                $tbodyTrs .= "<td>" . $reservation['booking_id'] . "</td>";
                $tbodyTrs .= "<td>" . $reservation['guest_name'] . "</td>";
                $tbodyTrs .= "<td>" . $reservation['agency_name'] . "</td>";
                if ($doc['type']==4) {
                    $tbodyTrs .= "<td> " . showPriceWithCurrency($reservation['reservation_amount']) . "</td>";
                }else{
                    $tbodyTrs .= "<td> -" . showPriceWithCurrency($reservation['reservation_amount']) . "</td>";
                
                }
                $tbodyTrs .= "<td>" . $documentStatus . "</td>";
                $tbodyTrs .= "</tr>";
            }

        }

        return new JsonResponse(['html' => $tbodyTrs]);
    }

    public function guestProfiles(Request $request)
    {
        $guests = getHotelSettings()->guests();
        $countries = Country::all();
        return view('front.Guest.guest_profiles')->with([
            'guests' => $guests->get(),
            'countries' => $countries,
        ]);
    }
    public function guestUpdate(Request $request, $id)
    {
        $guest = Guest::where('id', $id)->first();
        if (!$guest) {
            return redirect()->back()->with('error', 'Guest unot found!');
        }
        $request->validate([
            'full_name' => 'required',
            'email' => 'required|email',
            'country_id' => 'required',
            'phone' => 'required',
        ]);
        /* full_name;email;email_2;country_id;city;address;language;phone;mobile;postal_code */
        $data = [
            'full_name' => $request->full_name,
            'email' => $request->email,
            'email_2' => $request->email_2,
            'country_id' => $request->country_id,
            'city' => $request->city,
            'address' => $request->address,
            'language' => $request->language,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'postal_code' => $request->postal_code,
        ];

        $guest->update($data);

        return redirect()->back()->with('success', 'Guest updated successfully!');
    }

    public function guestReservations($id)
    {
        $reservations = Guest::find($id)->reservations;
        return view('front.Guest.guest_reservations')->with([
            'reservations' => $reservations,
        ]);
    }

    public function guestPaymentFolio($id)
    {
        $reservation = Reservation::find($id);

        $values = getStatusesAndValues($id);

        $result = [];
        $result[] = [
            'title' => 'Accommodation',
            'total' => $values['accom_total'],
            'paid' => $values['accom_paid'],
            'balance' => $values['accom_charge'],
        ];

        $result[] = [
            'title' => 'Services',
            'total' => $values['extras_total'],
            'paid' => $values['extras_paid'],
            'balance' => $values['extras_charge'],
        ];

        $result[] = [
            'title' => 'Overnight Tax',
            'total' => $values['overnight_total'],
            'paid' => $values['overnight_paid'],
            'balance' => $values['overnight_charge'],
        ];
//        modal data
        $overnights = $reservation->guest_overnight_tax_payments;
        $services = $reservation->reservation_extra_charges;
        $daily_rates = $reservation->accom_daily_rates;
        return view('front.Guest.guest_payment_folio')->with([
            'reservation' => $reservation,
            'data' => $result,
            'overnights' => $overnights,
            'services' => $services,
            'daily_rates' => $daily_rates,
        ]);
    }

    public function guestReservationFee($reservationId)
    {
        return view('front.Reservation.guest_reservation_fee')->with([
            'reservationId' => $reservationId,
        ]);
    }

    public function reservationPayments($reservationId)
    {
        $reservation = Reservation::find($reservationId);
        $methods = getHotelSettings()->payment_methods;
        $extrasDetails = $reservation->reservation_extra_charges()->with('extra_charge')->get()->groupBy('receipt_number');
        $values = getStatusesAndValues($reservationId);
        $accomStatus = "";
        if ($values["accom_charge"] == 0) {
            $accomStatus = "Accommodation Balance Is zero. You can not charge any more money";
        }
        $overnightStatus = "";
        if ($values["overnight_charge"] == 0) {
            $overnightStatus = "Overnight Balance Is zero. You can not charge any more money";
        }
        return view('front.Reservation.reservation_payments')->with([
            'reservation' => $reservation,
            'extrasDetails' => $extrasDetails,
            'methods' => $methods,
            'values' => $values,
            "status" => $accomStatus,
            "overnight_status" => $overnightStatus,
        ]);
    }

    public function postPayment(Request $request)
    {
        $request->validate([
            'reservationId' => ['required'],
            'value' => ['required', 'numeric', 'min:0'],
            'payment_method_id' => ['required'],
        ]);
        $reservation = Reservation::find($request->reservationId);
        $value = $request->value;
        $date = $request->payment_date;
        $method = $request->payment_method_id;
        $is_deposit = $request->deposit;
        $comments = $request->payment_comments;

        if ($request->has("extra_charge_id") && $request->extra_charge_id) {
            $value = $request->value;
            $balance = getStatusesAndValues($reservation->id)['extras_charge'];
            if ($balance == 0) {
                return back()->withErrors(["extra_status" => "Extra Balance Is zero. You can not charge any more money"])->withInput();
            } else if ($value > $balance) {
                return back()->withErrors(["extra_status" => "Extra Balance is less than the given amount."])->withInput();
            }

            $receipt_number = $request->extra_charge_id;
            $date = $request->service_payment_date;
            $method = $request->payment_method_id;
            $comments = $request->service_comment;

            $reservation->guest_extras_payments()->create([
                'value' => $value,
                'payment_method_id' => $method,
                'date' => $date,
                'comments' => $this->comments ?? "",
            ]);
            $reservation->reservation_extra_charges()->where('receipt_number', $receipt_number)->update([
                'is_paid' => '1',
                'payment_method_id' => $method,
            ]);

            return back()->with("success", "Service payment made successfully");

        } else if (isset($request->overnight)) {
            $balance = getStatusesAndValues($reservation->id)['overnight_charge'];
            if ($balance == 0) {
                return back()->withErrors(["overnight-status" => "Overnight Tax Balance Is zero. You can not charge any more money"])->withInput();
            } else if ($value > $balance) {
                return back()->withErrors(["overnight-status" => "Overnight Tax Balance is less than the given amount."])->withInput();
            }
            GuestOvernightTaxPayment::create([
                'value' => $value,
                'date' => $date,
                'payment_method_id' => $method,
                'comments' => $comments ?? "",
                'reservation_id' => $reservation->id,
            ]);
            $balance = getStatusesAndValues($reservation->id)['overnight_charge'];
            if ($balance == 0) {
                return back()->withErrors(["overnight-status" => "Overnight Tax Balance Is zero. You can not charge any more money"])->withInput();
            } else if ($value > $balance) {
                return back()->withErrors(["overnight-status" => "Overnight Tax Balance is less than the given amount."])->withInput();
            } else {
                Alert::success('Success', 'Payment was successful.');
                return back();
            }
        } else {
            $balance = getStatusesAndValues($reservation->id)['accom_charge'];
            if ($balance == 0) {
                return back()->withErrors(["status" => "Accommodation Balance Is zero. You can not charge any more money"])->withInput();
            } else if ($value > $balance) {
                return back()->withErrors(["status" => "Guests Balance is less than the given amount."])->withInput();
            }
            GuestAccommodationPayment::create([
                'value' => $value,
                'date' => $date,
                'payment_method_id' => $method,
                'is_deposit' => $is_deposit,
                'comments' => $comments ?? "",
                'reservation_id' => $reservation->id,
            ]);
            $balance = getStatusesAndValues($reservation->id)['accom_charge'];
            if ($balance == 0) {
                return back()->withErrors(["status" => "Accommodation Balance Is zero. You can not charge any more money"])->withInput();
            } else if ($value > $balance) {
                return back()->withErrors(["status" => "Guests Balance is less than the given amount."])->withInput();
            } else {
                Alert::success('Success', 'Payment was successful.');
                return back();
            }
        }

    }

    public function reservationExtraCharges($reservation_id)
    {
        $reservation = Reservation::find($reservation_id);
        $data = [
            'reservation_id' => $reservation_id,
            'extras' => $reservation->reservation_extra_charges()->with('extra_charge')->get()->groupBy('receipt_number'),
        ];
        return view('front.Reservation.reservation_extra_charge')->with($data);

    }

    public function createReservationExtraCharges($reservation_id, $receipt = false)
    {
        return view('front.Reservation.create_reservation_extra_charge')->with([
            'reservation_id' => $reservation_id,
            'receipt_number' => $receipt,
        ]);
    }

    public function deleteReservationExtraCharge($receipt)
    {
        ReservationExtraCharge::query()->where('receipt_number', $receipt)->delete();
        return redirect()->back();
    }

    public function guest_confirmation($confirmation, $id){
      $reservation = Reservation::where('status', 'Offer')->where('id', $id)->first();
      $message = '';
      $status = '';
      $reservationid='';
      if($reservation){
        $today=today()->toDateString();
        $reservationid=$reservation->id;
        if ($today>$reservation->offer_expire_date) {
            $success=0;
            $showform=0;
            $head="Sorry!!!";
            $message="This offer has been expired. Please request a new offer.";
        }elseif ($reservation->status=="Offer") {
            if($confirmation == 'accept'){
                $success=2;
                $showform=1;
                $offerstatus='Confirm';
                $head="Thank you!";
                $link="add_payment_transaction";
                $message="We will be pleased to provide you our best services. Please send us Transaction details . ";
                $myform='<div class="d-flex flex-column">
                            <div class="container-fluid">
                            <div class="row  mt-3">
                            <div class="col">
                            <div class="infocard shadow-sm bg-white">
                            <div class="form-style-6" style="text-align: left !important;">
                            <fieldset style="border:1px solid #43D1AF; border-radius:5px;padding:15px;margin:0px;margin-bottom:-20px !important;" >
                            <legend style="width:auto; margin-bottom: 0px; font-size: 18px; font-weight: bold; color: #3D3D3D;">Transaction Detail</legend>
                            <form method="POST" action="/guest_confirmation/add_transaction">
                              @csrf
                                <div class="row" >
                                <div class="col">
                                    <label>Transaction Id</label>
                                    <input type="text" name="transaction_number" id="transactionid" placeholder="Add your transaction id here" required>
                                    <input type="hidden" name="id" value="'.$reservation->id.'">

                                    
                                </div>
                                </div>
                                <div class="row">
                                <div class="col">
                                    <label>Comments</label>
                                    <textarea class="" name="comments" id="editcomments" style="min-height:80px;" rows="3" value=""></textarea>
                                    
                                </div>
                                </div>
                                <div class="row">
                                <div class="col" style="text-align: right;">
                                    <button type="submit"  id="submit" name="submit_transaction" class="infbtn"  style="background-color:white;color:#43D1AF;">Submit</button>
                                    
                                </div>
                                </div>
                            </form>
                                </fieldset>
                            
                            </div>
                            </div>
                        </div>
                        </div>
                            

                            </div>

                    </div>';
               $reservation->update(['status'=>'Confirmed', 'offer_expire_date'=>null]);
              }else{
                 Availability::where('reservation_id', $reservation->id)->delete();
                 RoomCondition::where('reservation_id', $reservation->id)->delete();
                 $totalRooms=Room::where('status', 'Enabled')->where('room_type_id', $reservation->room->room_type->id)->count();
                 $checkin=$reservation->check_in;
                 $checkout=$reservation->check_out;
                 $fulldata=[];
                 $hotel=Property::where('hotel_id', $reservation->hotel_settings_id)->where('name', 'Channex')->first();
                 while ($checkin<$checkout) {
                     // add channel manager availability
                        if ($reservation->room->room_type->type_status==0) {
                            $availableRooms=0;
                        }else{
                            $occupiedRooms=Availability::join('rooms', 'rooms.id', '=', 'availabilities.room_id')->where('availabilities.room_type_id', $reservation->room->room_type_id)->where('rooms.status', 'Enabled')->where('date', $checkin)->count();
                            $availableRooms=$totalRooms-$occupiedRooms;
                        }
                        $innerdata=[
                    
                            "property_id"=> $hotel->property_id,
                            "room_type_id"=> $reservation->room->room_type->channex_room_type_id,
                            "date"=> $checkin,
                            "availability"=> $availableRooms
                            
                            ];
                            array_unshift($fulldata, $innerdata);

                            $checkin=Carbon::parse($checkin)->addDay()->toDateString();
                 }
                 // send availability to channex............
                $availData=["values"=>$fulldata];
                $availabilityUrl = config('services.channex.api_base') . "/availability";
                $client=new Client();
                $client->post($availabilityUrl, [
                    'headers' => ['Content-Type' => 'application/json', 'user-api-key' => config('services.channex.api_key')],
                    'body' => json_encode($availData),
                ]);
                
                $success=1;
                $showform=0;
                
                $head="Thank you for your response";
                $message="Stay in contact for more offers. ";
                $reservation->update(['status'=>'Cancelled', 'channex_status'=>'cancelled', 'offer_expire_date'=>null]);
              }
            
        }else if ($reservation->status=="Cancelled") {
            $success=0;
            $showform=0;
            $head="Sorry!";
            $message="You have already rejected this offer. Please request a new offer.";
        }else{
            $success=0;
            $showform=0;
            $head="Sorry!";
            $message="You have already accepted this offer.";
        }

        
        
      }else{
        $success=0;
        $showform=0;
        $head="Sorry!";
        $message="Offer not found in our system.";
      }
      return view('user_confirmation', compact('message', 'head', 'showform', 'success', 'reservationid'));
       
    }

    public function add_transaction(Request $request){
        $comment=$request->transaction_number." ".$request->comments;
        Reservation::where('id', $request->id)->update(['comment'=>$comment]);
        $reservationid='';
        $success=1;
        $showform=0;
        $head="Thank you for your response ";
        $message="For any further queries stay in contact with us";
        return view('user_confirmation', compact('message', 'head', 'showform', 'success', 'reservationid'));
    }
}

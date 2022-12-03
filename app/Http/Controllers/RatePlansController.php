<?php

namespace App\Http\Controllers;

use Throwable;
use GuzzleHttp\Client;
use App\Models\RateType;
use App\Models\RoomType;
use App\Models\Reservation;
use App\Models\Restriction;
use App\Models\HotelSetting;
use Illuminate\Http\Request;
use App\Models\RateTypeCategory;
use App\Models\RateTypeCancellationPolicy;
use App\Http\Controllers\ChannexApiController;
use App\Http\Livewire\Rooms\RoomsTypeAndRooms;
use Illuminate\Support\Facades\Http;

class RatePlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ratetypes = getHotelSettings()->rate_types()->select(
            'rate_types.*',
            'rate_types.status as rate_status',
            'rate_types.id as rate_id',
            'rate_types.name as rate_type_name',
            'rate_type_categories.*',
            'rate_type_categories.name as meal_category_name',
            'room_types.*',
            'room_types.name as room_type_name',
            'rate_type_cancellation_policies.*',
            'rate_type_cancellation_policies.name as policy_name',
        )
            ->leftJoin('rate_type_categories', 'rate_types.rate_type_category_id', 'rate_type_categories.id')
            ->leftJoin('room_types', 'rate_types.room_type_id', 'room_types.id')
            ->leftJoin('rate_type_cancellation_policies', 'rate_types.rate_type_cancellation_policy_id', 'rate_type_cancellation_policies.id')
            ->get();
        // dd($ratetypes);
        return view('front.RatePlans.index', compact('ratetypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rate_types = getHotelSettings()->room_types;
        $rate_types_categories = getHotelSettings()->rate_type_categories;
        $rate_type_policies = getHotelSettings()->rate_type_cancellation_policies;
        $settings = getHotelSettings();
        return view('front.RatePlans.create', compact('rate_types', 'rate_types_categories', 'rate_type_policies', 'settings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rate_types = getHotelSettings()->rate_types()->select('id', 'primary_occupancy', 'infant_fee', 'children_fee', 'name')->where('room_type_id', $id)->get();
        return $rate_types;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rate_plan = getHotelSettings()->rate_types()->find($id);
        return view('front.RatePlans.edit', compact('rate_plan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rate_type = getHotelSettings()->rate_types()->find($id);
        $roomtype = getHotelSettings()->room_types()->find($request->roomtypeid);

        if(is_string($request->derivedrateslogics)){
            $request->derivedrateslogics = json_decode($request->derivedrateslogics);
        }

        $insertion_data = [
            "name" => $request->ratename,
            "reservation_rate" => $request->dailyrate,
            "charge" => $request->ratetypeFirstchargePercent,
            "reservation_charge_days" => $request->ratetypefirstchargedays,
            "charge2" => $request->ratetypeSecondChargePercent,
            "reservation_charge_days_2" => $request->ratetypeSecondChargedays,
            "charge_percentage" => $request->rateplanchargePercent,
            "charge_type" => $request->ratetypechargetype,
            "early_checkout_charge_percentage" => $request->earlycheckoutcharge,
            "description_to_document" => $request->desctoDocument,
            "prepayment" => $request->rateprepayment,
            "room_type_id" => (int)$request->roomtypeid,
            "rate_type_category_id" => $request->mealcategory,
            "reference_code" => $request->referencecode,
            "rate_type_cancellation_policy_id" => $request->cancellationpolicy,
            "no_show_charge_percentage" => $request->noshow,
            "cancellation_charge" => $request->cancelPercent,
            "cancellation_charge_days" => $request->cancelledDays,
            "channex_id" => 0,
            "parent_rate_plan_id" => (int)$request->parent_rateplan_id ?? 0,
        ];
        if ($request->channex_id) {
            $endpoint = config('services.channex.api_base') . '/rate_plans/' . $rate_type->channex_id;
            $insertion_data = array_merge($insertion_data, [
                "channex_id" => $request->channex_id,
                "primary_occupancy" => $request->primaryOccupancy,
                "parent_rate_plan_id" => (int)$request->parent_rateplan_id ?? 0,
                "rate_mode" => $request->rate_mode,
                "sell_mode" => $request->sell_mode,
                "children_fee" => $request->childrenfee,
                "infant_fee" => $request->infantfee,
                "cascade_select_type" => $request->cascadeSelect,
                "cascade_select_value" => $request->cascadevalue,
            ]);
            $updated = $rate_type->update($insertion_data);

            $settings = getHotelSettings();

            if ($request->parent_rateplan_id) {
                $data = '';
                $parent_rate = getHotelSettings()->rate_types()->find($request->parent_rateplan_id);


                if ($request->rate_mode == "derived" && $request->sell_mode == "per_person") {

                    $optionsArray = array();
                    $option = [
                        "occupancy" => (int)$request->primaryOccupancy,
                        "is_primary" => true,
                        "rate" => $request->dailyrate
                    ];
                    array_push($optionsArray, $option);
                    for ($i = 0; $i < count($request->derivedrateslogics); $i++) {

                        $option = [
                            "occupancy" => $request->derivedrateslogics[$i][0],
                            "is_primary" => false,
                            "rate" => $request->dailyrate,
                            "derived_option" => [
                                "rate" => [
                                    [
                                        $request->derivedrateslogics[$i][1], $request->derivedrateslogics[$i][2]
                                    ]

                                ]

                            ]


                        ];
                        array_push($optionsArray, $option);
                    }

                    $data = [
                        "rate_plan" => [
                            "title" => $request->ratename,
                            "property_id" => $settings->active_property()->property_id,
                            "room_type_id" => $roomtype->channex_room_type_id,
                            "parent_rate_plan_id" => (int)$parent_rate->id,
                            "children_fee" => $request->childrenfee,
                            "infant_fee" => $request->infantfee,
                            "options" => $optionsArray,
                            "inherit_rate" => true,
                            "inherit_closed_to_arrival" => true,
                            "inherit_closed_to_departure" => true,
                            "inherit_stop_sell" => true,
                            "inherit_min_stay_arrival" => true,
                            "inherit_min_stay_through" => true,
                            "inherit_max_stay" => true,
                            "currency" => $request->currency,
                            "sell_mode" => $request->sell_mode,
                            "rate_mode" => $request->rate_mode
                        ]

                    ];
                } else if ($request->rate_mode == "derived" && $request->sell_mode == "per_room") {
                    $data = [
                        "rate_plan" => [
                            "title" => $request->ratename,
                            "property_id" => $settings->active_property()->property_id,
                            "room_type_id" => $roomtype->channex_room_type_id,
                            "parent_rate_plan_id" => (int)$parent_rate->id,
                            "options" => [
                                [
                                    "occupancy" => (int)$request->maxoccupancy,
                                    "is_primary" => true,
                                    "rate" => $request->dailyrate
                                ]

                            ],
                            "inherit_rate" => true,
                            "inherit_closed_to_arrival" => true,
                            "inherit_closed_to_departure" => true,
                            "inherit_stop_sell" => true,
                            "inherit_min_stay_arrival" => true,
                            "inherit_min_stay_through" => true,
                            "inherit_max_stay" => true,
                            "currency" => $request->currency,
                            "sell_mode" => $request->sell_mode,
                            "rate_mode" => $request->rate_mode
                        ]

                    ];
                } else if ($request->rate_mode == "auto" && $request->sell_mode == "per_person") {
                    $autoratesarray = array();

                    for ($i = 1; $i <= $request->maxoccupancy; $i++) {
                        if ($i == $request->primaryOccupancy) {
                            $option = [
                                "occupancy" => $i,
                                "is_primary" => true,
                                "rate" => $request->dailyrate

                            ];
                            array_push($autoratesarray, $option);
                        } else {
                            $option = [
                                "occupancy" => $i,
                                "is_primary" => false,
                                "rate" => $request->dailyrate

                            ];
                            array_push($autoratesarray, $option);
                        }
                    }



                    $data = [
                        "rate_plan" => [
                            "title" => $request->ratename,
                            "property_id" => $settings->active_property()->property_id,
                            "room_type_id" => $roomtype->channex_room_type_id,
                            "parent_rate_plan_id" => (int)$parent_rate->id,
                            "children_fee" => $request->childrenfee,
                            "infant_fee" => $request->infantfee,
                            "options" => $autoratesarray,
                            "inherit_rate" => true,
                            "inherit_closed_to_arrival" => true,
                            "inherit_closed_to_departure" => true,
                            "inherit_stop_sell" => true,
                            "inherit_min_stay_arrival" => true,
                            "inherit_min_stay_through" => true,
                            "inherit_max_stay" => true,
                            "currency" => $request->currency,
                            "sell_mode" => $request->sell_mode,
                            "rate_mode" => $request->rate_mode
                        ]

                    ];
                } else if ($request->rate_mode == "cascade" && $request->sell_mode == "per_person") {
                    $optionsArray = array();
                    for ($i = 1; $i <= $request->maxoccupancy; $i++) {
                        if ($i == $request->primaryOccupancy) {
                            $option = [
                                "occupancy" => (int)$request->primaryOccupancy,
                                "is_primary" => true,
                                "rate" => $request->dailyrate,
                                "derived_option" => [
                                    "rate" => [
                                        [
                                            $request->cascadeSelect, $request->cascadevalue
                                        ]

                                    ]

                                ]
                            ];
                            array_push($optionsArray, $option);
                        } else {
                            $option = [
                                "occupancy" => $i,
                                "is_primary" => false,
                                "rate" => $request->dailyrate,
                                "derived_option" => [
                                    "rate" => [
                                        [
                                            $request->cascadeSelect, $request->cascadevalue
                                        ]

                                    ]

                                ]

                            ];
                            array_push($optionsArray, $option);
                        }
                    }

                    $data = [
                        "rate_plan" => [
                            "title" => $request->ratename,
                            "property_id" => $settings->active_property()->property_id,
                            "room_type_id" => $roomtype->channex_room_type_id,
                            "parent_rate_plan_id" => (int)$parent_rate->id,
                            "children_fee" => $request->childrenfee,
                            "infant_fee" => $request->infantfee,
                            "options" => $optionsArray,
                            "inherit_rate" => true,
                            "inherit_closed_to_arrival" => true,
                            "inherit_closed_to_departure" => true,
                            "inherit_stop_sell" => true,
                            "inherit_min_stay_arrival" => true,
                            "inherit_min_stay_through" => true,
                            "inherit_max_stay" => true,
                            "currency" => $request->currency,
                            "sell_mode" => $request->sell_mode,
                            "rate_mode" => $request->rate_mode
                        ]

                    ];
                } else {
                }
            } else {
                $optionsArray = array();
                for ($i = 1; $i <= $request->maxoccupancy; $i++) {
                    if ($i == $request->primaryOccupancy) {
                        $option = [
                            "occupancy" => (int)$request->primaryOccupancy,
                            "is_primary" => true,
                            "rate" => $request->dailyrate
                        ];
                        array_push($optionsArray, $option);
                    } else {
                        $option = [
                            "occupancy" => $i,
                            "is_primary" => false,
                            "rate" => $request->dailyrate,

                        ];
                        array_push($optionsArray, $option);
                    }
                }



                if ($request->rate_mode == "manual" && $request->sell_mode == "per_person") {
                    $data = [
                        "rate_plan" => [
                            "title" => $request->ratename,
                            "property_id" => $settings->active_property()->property_id,
                            "room_type_id" => $roomtype->channex_room_type_id,
                            "parent_rate_plan_id" => (int)null,
                            "options" => $optionsArray,
                            "currency" => $request->currency,
                            "sell_mode" => $request->sell_mode,
                            "rate_mode" => $request->rate_mode,
                            "children_fee" => $request->childrenfee,
                            "infant_fee" => $request->infantfee
                        ]

                    ];
                } else if ($request->rate_mode == "manual" && $request->sell_mode == "per_room") {
                    $data = [
                        "rate_plan" => [
                            "title" => $request->ratename,
                            "property_id" => $settings->active_property()->property_id,
                            "room_type_id" => $roomtype->channex_room_type_id,
                            "parent_rate_plan_id" => (int)null,
                            "options" => [
                                [
                                    "occupancy" => (int)$request->maxoccupancy,
                                    "is_primary" => true,
                                    "rate" => $request->dailyrate
                                ]

                            ],
                            "currency" => $request->currency,
                            "sell_mode" => $request->sell_mode,
                            "rate_mode" => $request->rate_mode

                        ]

                    ];
                } else if ($request->rate_mode == "auto" && $request->sell_mode == "per_person") {
                    $autoratesarray = array();
                    $autorateoptions = [
                        "occupancy" => (int)$request->primaryOccupancy,
                        "is_primary" => true,
                        "rate" => $request->dailyrate,
                    ];
                    array_push($autoratesarray, $autorateoptions);
                    // $increaserate=$increasevalue;
                    // $increaseStart=$request->primaryOccupancy+1;
                    // $decreaseStart=$request->primaryOccupancy-1;
                    // $decreaserate=$decreasevalue;
                    for ($i = 1; $i <= $request->maxoccupancy; $i++) {
                        if ($i == $request->primaryOccupancy) {
                            $option = [
                                "occupancy" => $i,
                                "is_primary" => true,
                                "rate" => $request->dailyrate



                            ];
                            array_push($autoratesarray, $option);
                        } else {

                            $option = [
                                "occupancy" => $i,
                                "is_primary" => false,
                                "rate" => $request->dailyrate,



                            ];
                            array_push($autoratesarray, $option);
                        }
                    }

                    $data = [
                        "rate_plan" => [
                            "title" => $request->ratename,
                            "property_id" => $settings->active_property()->property_id,
                            "room_type_id" => $roomtype->channex_room_type_id,
                            "parent_rate_plan_id" => (int)null,
                            "options" => $autoratesarray,
                            "currency" => $request->currency,
                            "sell_mode" => $request->sell_mode,
                            "rate_mode" => $request->rate_mode,
                            "children_fee" => $request->childrenfee,
                            "infant_fee" => $request->infantfee
                        ]

                    ];
                } else if ($request->rate_mode == "derived" && $request->sell_mode == "per_person") {
                    $optionsArray = array();
                    $option = [
                        "occupancy" => (int)$request->primaryOccupancy,
                        "is_primary" => true,
                        "rate" => $request->dailyrate
                    ];
                    array_push($optionsArray, $option);

                    for ($i = 0; $i < count($request->derivedrateslogics); $i++) {

                        $option = [
                            "occupancy" => $request->derivedrateslogics[$i][0],
                            "is_primary" => false,
                            "rate" => $request->dailyrate,
                            "derived_option" => [
                                "rate" => [
                                    [
                                        $request->derivedrateslogics[$i][1], $request->derivedrateslogics[$i][2]
                                    ]

                                ]

                            ]


                        ];
                        array_push($optionsArray, $option);
                    }

                    $data = [
                        "rate_plan" => [
                            "title" => $request->ratename,
                            "property_id" => $settings->active_property()->property_id,
                            "room_type_id" => $roomtype->channex_room_type_id,
                            "parent_rate_plan_id" => null,
                            "options" => $optionsArray,
                            "currency" => $request->currency,
                            "sell_mode" => $request->sell_mode,
                            "rate_mode" => $request->rate_mode,
                            "children_fee" => $request->childrenfee,
                            "infant_fee" => $request->infantfee
                        ]

                    ];
                } else if ($request->rate_mode == "derived" && $request->sell_mode == "per_room") {
                    $data = [
                        "rate_plan" => [
                            "title" => $request->ratename,
                            "property_id" => $settings->active_property()->property_id,
                            "room_type_id" => $roomtype->channex_room_type_id,
                            "parent_rate_plan_id" => (int)null,
                            "options" => [
                                [
                                    "occupancy" => (int)$request->maxoccupancy,
                                    "is_primary" => true,
                                    "rate" => $request->dailyrate
                                ]

                            ],
                            "currency" => $request->currency,
                            "sell_mode" => $request->sell_mode,
                            "rate_mode" => $request->rate_mode

                        ]

                    ];
                } else {
                }
            }

            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'user-api-key' => config('services.channex.api_key'),
                ])->put($endpoint, $data);

                $response->throw();

                return [
                    'result' => 'OK',
                    'message' => 'Rate Plan updated successfully',
                ];
            } catch (Throwable $e) {
                return [
                    'result' => 'Error',
                    'message' => $e->getMessage()
                ];
            }
        } else {
            $updated = $rate_type->update($insertion_data);
        }
        if ($updated)
            return [
                'result' => 'OK',
                'message' => 'Rate Plan updated successfully'
            ];
        else
            return [
                'result' => 'error',
                'message' => 'Rate Plan updating failed'
            ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $today = date('Y-m-d');

        $parentCount = getHotelSettings()->rate_types()->where('parent_rate_plan_id', $id)->get()->count();
        if ($parentCount > 0) {
            $response = [
                'result' => 'Error',
                'message' => "Can't delete the rate type because it has parity rates"
            ];
            return $response;
        }

        $reservations = Reservation::where([
            ['rate_type_id', '=', $id],
            ['status', '!=', 'cancelled'],
            ['channex_status', '!=', 'cancelled']
        ])->where(function ($q) use ($today) {
            $q->where('check_in', '>=', $today)
                ->orWhere('check_out', '>=', $today)
                ->orWhere('booking_date', '>=', $today)
                ->orWhere('actual_checkin', '>=', $today)
                ->orWhere('actual_checkout', '>=', $today)
                ->orWhere('arrival_date', '>=', $today)
                ->orWhere('departure_date', '>=', $today);
        })
            ->get()->count();
        if ($reservations > 0) {
            $response = [
                'result' => 'Error',
                'message' => "Can't delete the rate type. This rate type has associated reservations"
            ];
            return $response;
        }

        $rate_type = getHotelSettings()->rate_types()->find($id);
        $channex_id = $rate_type->channex_id;

        $endpoint = config('services.channex.api_base') . '/rate_plans/' . $channex_id;
        if ($channex_id) {
            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'user-api-key' => config('services.channex.api_key'),
                ])->delete($endpoint);

                $response->throw();

                $rate_type->delete();

                return [
                    'result' => 'OK',
                    'message' => 'Rate type deleted successfully'
                ];
            } catch (\Throwable $th) {
                if($th->getCode() == 404){

                    $rate_type->delete();
                }

                return [
                    'result' => 'Error',
                    'message' => $th->getMessage()
                ];
            }
        }
        $rate_type->delete();
        return [
            'result' => 'OK',
            'message' => 'Rate type deleted successfully'
        ];
    }

    public function status_update(Request $request)
    {
        $date = date('Y-m-d');
        $rate_type = getHotelSettings()->rate_types()->find($request->id);
        $rate_type->update([
            'status' => 1
        ]);

        $channex_id = $rate_type->channex_id;
        if ($channex_id) {
            $endpoint = config('services.channex.api_base') . '/restrictions';
            $settings = getHotelSettings();

            $ndate = date('Y-m-d', strtotime($date . "+ 499 days"));
            $dataAvail = array();

            if ($rate_type->status) {
                $status = 0;
                $dataAvail = [
                    "values" => [
                        [
                            "property_id" => $settings->active_property()->property_id,
                            "rate_plan_id" => $channex_id,
                            "date_from" => $date,
                            "date_to" => $ndate,
                            "stop_sell" => $status
                        ]
                    ]
                ];
            } else {
                $status = 1;
                $fulldata = array();

                while ($date <= $ndate) {
                    $restrictions  = Restriction::where('name', 'stop_sell')->where('date', $date)->where('rate_type_id', $rate_type->id)->get()->count();
                    if ($restrictions > 0) {
                        $innerdata = [
                            "property_id" => $settings->active_property()->property_id,
                            "rate_plan_id" => $channex_id,
                            "date" => $date,
                            "stop_sell" => true
                        ];
                        array_push($fulldata, $innerdata);
                    } else {
                        $innerdata = [
                            "property_id" => $settings->active_property()->property_id,
                            "rate_plan_id" => $channex_id,
                            "date" => $date,
                            "stop_sell" => false
                        ];
                        array_push($fulldata, $innerdata);
                    }

                    $date = date('Y-m-d', strtotime($date . ' + 1 days'));
                }

                $dataAvail = [
                    "values" => $fulldata
                ];
            }

            try {

                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'user-api-key' => config('services.channex.api_key'),
                ])->post($endpoint, $dataAvail);
                $response->throw();


                return [
                    'result' => 'OK',
                    'message' => "Rate Plan status updated successfully!"
                ];
            } catch (Throwable $e) {
                $response = [
                    'result' => 'Error',
                    'message' => $e->getMessage()
                ];
                return $response;
            }
        }
    }

    public function meal_category_to_rate_plan_match(Request $request)
    {
        $meal_category = RateTypeCategory::find($request->id);
        return [
            'charge_percent' => $meal_category->charge_percentage,
            'desc_to_document' => $meal_category->desc_to_document
        ];
    }
}

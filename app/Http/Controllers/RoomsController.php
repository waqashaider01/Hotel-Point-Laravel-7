<?php

namespace App\Http\Controllers;

use Throwable;
use Carbon\Carbon;
use App\Models\Room;
use GuzzleHttp\Client;
use App\Models\RoomType;
use App\Models\Restriction;
use App\Models\Availability;
use App\Models\HotelSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Livewire\Rooms\RoomsTypeAndRooms;
use Illuminate\Support\Facades\Http;

class RoomsController extends Controller
{
    public function roomTypeAndRoomShow()
    {
        return view('front.Rooms.rooms_types_and_rooms');
    }

    public function syncRoomsWithChannex()
    {
        $result = sync_channex_rooms(getHotelSettings()->id);

        if($result['result'] == 'success'){
            session()->flash('success', $result['message']);
        } else {
            session()->flash('error', $result['message']);
        }
        return redirect()->route('room-type-and-room.show');
    }

    public function roomTypeStatusUpdate(Request $request)
    {
        $availability_endpoint = config('services.channex.api_base') . '/availability';
        $roomtype = getHotelSettings()->room_types()->find($request->id);
        $fulldata = array();

        $status_update = $roomtype->update(['type_status' => $request->status]);
        if (!$status_update) {
            return [
                'result' => 'Error',
                'message' => "Room Type status update failed!"
            ];
        }

        $roomtype_channex_id = $roomtype->channex_room_type_id;

        if ($roomtype_channex_id) {
            $settings = getHotelSettings();
            $date = date('Y-m-d');
            $ndate = date('Y-m-d', strtotime($date . "+ 499 days"));

            if ($roomtype->status == 0) {
                $innerdata = [
                    "property_id" => $settings->active_property()->property_id,
                    "room_type_id" => $roomtype_channex_id,
                    "date_from" => $date,
                    "date_to" => $ndate,
                    "availability" => 0
                ];
                array_push($fulldata, $innerdata);
            } else {
                $totalRooms = Room::where('room_type_id', $roomtype->id)->get()->count();
                $start = $date;
                $end = $ndate;

                while ($start <= $end) {
                    $availability_restriction  = Restriction::where('name', 'stop_availability')->where('date', $start)->get()->count();
                    if ($availability_restriction > 0) {
                        $available = 0;
                    } else {
                        $occupiedrooms = Availability::join('rooms', 'rooms.id', 'room_id')->get()->count();
                        $available = $totalRooms - $occupiedrooms;
                    }

                    $innerdata = [
                        "property_id" => $settings->active_property()->property_id,
                        "room_type_id" => $roomtype_channex_id,
                        "date" => $start,
                        "availability" => $available
                    ];
                    array_push($fulldata, $innerdata);
                    $start = date('Y-m-d', strtotime($start . ' + 1 days'));
                }
            }

            $dataAvail = [
                "values" => $fulldata
            ];

            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'user-api-key' => config('services.channex.api_key'),
                ])->post($availability_endpoint, $dataAvail);
                $response->throw();

                return [
                    'result' => 'OK',
                    'message' => "Room Type status updated successfully!"
                ];
            } catch (Throwable $e) {
                $response = [
                    'result' => 'Error',
                    'message' => $e->getMessage()
                ];
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }
        }
        return [
            'result' => 'Error',
            'message' => "Room Type status update failed!"
        ];
    }

    public function showRoomTypesData(Request $request)
    {
        return getHotelSettings()->room_types()->find($request->id)->toArray();
    }

    public function roomTypeUpdate(Request $request)
    {
        $data = json_decode($request->data, true);
        $roomtype = getHotelSettings()->room_types()->find($data['id']);
        $update_data = [
            "name" => $data['name'],
            "description" => $data['description'],
            "reference_code" => $data['reference_code']
        ];

        if ($data['channex_room_type_id'] == 'Yes') {
            $endpoint = config('services.channex.api_base') . '/room_types/' . $roomtype->channex_room_type_id;

            $update_data["adults_channex"] = $data['adults_channex'];
            $update_data["kids_channex"] = $data['kids_channex'];
            $update_data["infants_channex"] = $data['infants_channex'];
            $update_data["default_occupancy_channex"] = $data['default_occupancy_channex'];

            $totalRooms = Room::where('room_type_id', $roomtype->id)->get()->count();
            $settings = getHotelSettings();
            $dataCreate = [
                "room_type" => [
                    "property_id" => $settings->active_property()->property_id,
                    "title" => $data['name'],
                    "count_of_rooms" => (int)$totalRooms,
                    "occ_adults" => (int)$data['adults_channex'],
                    "occ_children" => (int)$data['kids_channex'],
                    "occ_infants" => (int)$data['infants_channex'],
                    "default_occupancy" => (int)$data['default_occupancy_channex'],
                    "kind" => "room",
                    "content" => [
                        "description" => $data['description']
                    ]

                ]
            ];

            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'user-api-key' => config('services.channex.api_key'),
                ])->put($endpoint, $dataCreate);
                $response->throw();

                $roomtype->update($update_data);
            } catch (\Throwable $e) {
                return [
                    'result' => 'error',
                    'message' => $e->getMessage()
                ];
            }
        }

        return [
            'result' => 'OK',
            'message' => "Room Type updated successfully!"
        ];
    }

    public function roomTypeDestroy(Request $request)
    {
        $roomtype = getHotelSettings()->room_types()->find($request->id);

        if ($roomtype->channex_room_type_id) {

            try {
                $endpoint = config('services.channex.api_base')."/room_types/" . $roomtype->channex_room_type_id;

                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'user-api-key' => config('services.channex.api_key'),
                ])->delete($endpoint);

                $response->throw();

                $roomtype->rooms()->delete();
                $roomtype->delete();

                return [
                    'result' => 'OK',
                    'message' => "Room type deleted successfully!"
                ];
            } catch (Throwable $e) {
                if ($e->getCode() == 401) {
                    return [
                        'result' => 'Error',
                        'message' => "Channex Authentication Error!"
                    ];
                }
                if ($e->getCode() == 422) {
                    $roomtype->rooms()->delete();
                    $roomtype->delete();
                    return [
                        'result' => 'OK',
                        'message' => "Room type deleted successfully!"
                    ];
                }
                if ($e->getCode() == 404) {

                    $roomtype->rooms()->delete();
                    $roomtype->delete();
                    return [
                        'result' => 'OK',
                        'message' => "Room type deleted successfully!"
                    ];
                }

                return [
                    'result' => 'Error',
                    'message' => $e->getMessage()
                ];
            }
        } else {

            $roomtype->rooms()->delete();
            $roomtype->delete();
            return [
                'result' => 'OK',
                'message' => "Room type deleted successfully!"
            ];
        }
    }

    public function updateRoomTypesPosition(Request $request)
    {
        $roomtype = getHotelSettings()->room_types()->find($request->id);
        if ($roomtype->update(['position' => $request->position]))
            return [
                'result' => 'OK',
                'message' => "Room type position updated successfully!"
            ];
        return [
            'result' => 'error',
            'message' => "Room type position updation Failed!"
        ];
    }

    public function roomsForRoomtype(Request $request)
    {
        $rooms = Room::where('room_type_id', $request->id)->get()->toArray();
        return [
            'rooms' => $rooms,
            'roomtype' => getHotelSettings()->room_types()->find($request->id)->name
        ];
    }

    public function create(Request $request)
    {
        $endpoint = config('services.channex.api_base') . '/availability';
        $data = [
            'room_type_id' => json_decode($request->data)->rid,
            'number' => json_decode($request->data)->rno,
            'status' => 'Enabled',
            'max_capacity' => json_decode($request->data)->occupancy,
            'max_adults' => json_decode($request->data)->adults,
            'max_kids' => json_decode($request->data)->kids,
            'max_infants' => json_decode($request->data)->infants
        ];
        $room = Room::create($data);
        $settings = getHotelSettings();

        $date = date('Y-m-d');
        $ndate = date('Y-m-d', strtotime($date . "+ 499 days"));
        $fulldata = array();

        $roomtype = getHotelSettings()->room_types()->find(json_decode($request->data)->rid);
        if ($roomtype->channex_room_type_id) {
            $rooms = Room::where('room_type_id', json_decode($request->data)->rid)->where('status', 'Enabled');
            $totalRooms = $rooms->count();

            $start = $date;
            $end = $ndate;
            while ($start <= $end) {
                $restrictions = Restriction::where('name', 'stop_availability')->where('date', $start)->count();
                if ($restrictions) {
                    $available = 0;
                } else {
                    $occupiedrooms = Availability::join('rooms', 'rooms.id', 'room_id')->get()->count();
                    $available = $totalRooms - $occupiedrooms;
                }
                $innerdata = [
                    "property_id" => $settings->active_property()->property_id,
                    "room_type_id" => $roomtype->channex_room_type_id,
                    "date" => $start,
                    "availability" => $available
                ];
                array_push($fulldata, $innerdata);


                $start = date('Y-m-d', strtotime($start . ' + 1 days'));
            }

            $dataAvail = [
                "values" => $fulldata
            ];

            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'user-api-key' => config('services.channex.api_key'),
                ])->post($endpoint, $dataAvail);
                $response->throw();

            } catch (\Throwable $th) {
                return [
                    'result' => 'error',
                    'message' => $th->getMessage()
                ];
            }
            return [
                'result' => 'OK',
                'message' => "Room created!"
            ];
        }
        if ($room)
            return [
                'result' => 'OK',
                'message' => "Room created!"
            ];
        return [
            'result' => 'error',
            'message' => "Room creation Failed!"
        ];
    }

    public function showRoom(Request $request)
    {
        return Room::find($request->id);
    }

    public function updateRoom(Request $request)
    {
        $data = json_decode($request->data);
        $update_data = [
            "id" => $data->rid,
            "number" => $data->roomno,
            "max_capacity" => $data->occupancy,
            "max_adults" => $data->adults,
            "max_kids" => $data->kids,
            "max_infants" => $data->infants
        ];

        $updated = Room::find($data->rid)->update($update_data);
        if ($updated)
            return [
                'result' => 'OK',
                'message' => "Room updated Successfully!"
            ];
        return [
            'result' => 'error',
            'message' => "Room Updation Failed!"
        ];
    }


    public function destroy(Request $request)
    {
        $endpoint = config('services.channex.api_base') . '/availability';

        $deleted = Room::find($request->roomid)->delete();
        $settings = getHotelSettings();

        $date = date('Y-m-d');
        $ndate = date('Y-m-d', strtotime($date . "+ 499 days"));
        $fulldata = array();

        $roomtype = getHotelSettings()->room_types()->find($request->roomtypeid);
        if ($roomtype->channex_room_type_id) {
            $rooms = Room::where('room_type_id', $request->roomtypeid)->where('status', 'Enabled');
            $totalRooms = $rooms->count();

            $start = $date;
            $end = $ndate;
            while ($start <= $end) {
                $restrictions = Restriction::where('name', 'stop_availability')->where('date', $start)->count();
                if ($restrictions) {
                    $available = 0;
                } else {
                    $occupiedrooms = Availability::join('rooms', 'rooms.id', 'room_id')->get()->count();
                    $available = $totalRooms - $occupiedrooms;
                }
                $innerdata = [
                    "property_id" => $settings->active_property()->property_id,
                    "room_type_id" => $roomtype->channex_room_type_id,
                    "date" => $start,
                    "availability" => $available
                ];
                array_push($fulldata, $innerdata);


                $start = date('Y-m-d', strtotime($start . ' + 1 days'));
            }

            $dataAvail = [
                "values" => $fulldata
            ];

            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'user-api-key' => config('services.channex.api_key'),
                ])->post($endpoint, $dataAvail);
                $response->throw();
            } catch (\Throwable $th) {
                return [
                    'result' => 'error',
                    'message' => $th->getMessage()
                ];
            }
            return [
                'result' => 'OK',
                'message' => "Room deleted successfully!"
            ];
        }
        if ($deleted)
            return [
                'result' => 'OK',
                'message' => "Room deleted successfully!"
            ];
        return [
            'result' => 'error',
            'message' => "Room deletion Failed!"
        ];
    }

    public function roomStatusUpdate(Request $request)
    {
        $endpoint = config('services.channex.api_base') . '/availability';
        $req_data = json_decode($request->data);

        $deleted = Room::find($req_data->roomid)->update(['status' => $req_data->status]);
        $settings = getHotelSettings();

        $date = date('Y-m-d');
        $ndate = date('Y-m-d', strtotime($date . "+ 499 days"));
        $fulldata = array();

        $roomtype = getHotelSettings()->room_types()->find($req_data->roomtypeid);
        if ($roomtype->channex_room_type_id) {
            $rooms = Room::where('room_type_id', $req_data->roomtypeid)->where('status', 'Enabled');
            $totalRooms = $rooms->count();

            $start = $date;
            $end = $ndate;
            while ($start <= $end) {
                $restrictions = Restriction::where('name', 'stop_availability')->where('date', $start)->count();
                if ($restrictions) {
                    $available = 0;
                } else {
                    $occupiedrooms = Availability::join('rooms', 'rooms.id', 'room_id')->get()->count();
                    $available = $totalRooms - $occupiedrooms;
                }
                $innerdata = [
                    "property_id" => $settings->active_property()->property_id,
                    "room_type_id" => $roomtype->channex_room_type_id,
                    "date" => $start,
                    "availability" => $available
                ];
                array_push($fulldata, $innerdata);


                $start = date('Y-m-d', strtotime($start . ' + 1 days'));
            }

            $dataAvail = [
                "values" => $fulldata
            ];

            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'user-api-key' => config('services.channex.api_key'),
                ])->post($endpoint, $dataAvail);
                $response->throw();
            } catch (\Throwable $th) {
                return [
                    'result' => 'error',
                    'message' => $th->getMessage()
                ];
            }
            return [
                'result' => 'OK',
                'message' => "Room status updated successfully!"
            ];
        }
        if ($deleted)
            return [
                'result' => 'OK',
                'message' => "Room status updated successfully!"
            ];
        return [
            'result' => 'error',
            'message' => "Room status updation Failed!"
        ];
    }




    public function roomTypeCreate(Request $request)
    {
        $data = [
            "name" => $request->typename,
            "description" => $request->description,
            "type_status" => 1,
            "channex_room_type_id" => '',
            "adults_channex" => 0,
            "kids_channex" => 0,
            "infants_channex" => 0,
            "default_occupancy_channex" => 0,
            "position" => 0,
            "cancellation_charge" => 0,
            "reference_code" => $request->referencecode
        ];

        if ($request->connect_to_channex == 'yes') {

            $data["adults_channex"] = (int)$request->adults;
            $data["kids_channex"] = (int)$request->kids;
            $data["infants_channex"] = (int)$request->infants;
            $data["default_occupancy_channex"] = (int)$request->default_occupancy;
        }

        $room_type = getHotelSettings()->room_types()->create($data);
        $roomno = 1;
        $roomsdata = [];
        $totalrooms = $request->totalrooms;
        for ($roomno = 1; $roomno <= $totalrooms; $roomno++) {
            $roomsdata[] = [
                "number" => $request->referencecode . '-00' . $roomno,
                "status" => "Enabled",
                "room_type_id" => $room_type->id,
                "max_adults" => (int)$request->adults,
                "max_infants" => (int)$request->kids,
                "max_kids" => (int)$request->infants,
                "max_capacity" => (int)$request->default_occupancy
            ];
        }

        $rooms = DB::table('rooms')->insert(json_decode(json_encode($roomsdata), true));

        if ($request->connect_to_channex == 'yes') {

            $endpoint = config('services.channex.api_base') . '/room_types';

            $settings = getHotelSettings();
            $dataCreate = [
                "room_type" => [
                    "property_id" => $settings->active_property()->property_id,
                    "title" => $request->typename,
                    "count_of_rooms" => (int)$request->totalrooms,
                    "occ_adults" => (int)$request->adults,
                    "occ_children" => (int)$request->kids,
                    "occ_infants" => (int)$request->infants,
                    "default_occupancy" => (int)$request->default_occupancy,
                    "kind" => "room",
                    "content" => [
                        "description" => $request->description
                    ]

                ]
            ];
            $channex_roomtypeid = '';
            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'user-api-key' => config('services.channex.api_key'),
                ])->post($endpoint, $dataCreate);

                $response->throw();

                $channex_roomtypeid = $response->json('data')['id'];
            } catch (\Throwable $e) {
                if ($e->getCode() == 401) {
                    return [
                        'result' => 'Error',
                        'message' => "Channex Authentication Error!",
                    ];
                }

                $room_type->rooms()->delete();
                $room_type->delete();
                $response = [
                    'result' => 'error',
                    'message' => $e->getMessage()
                ];
                return $response;
            }

            $date = date('Y-m-d');
            $ndate = date('Y-m-d', strtotime($date . "+ 499 days"));

            $fulldata = [
                "values" => [
                    [
                        "property_id" => $settings->active_property()->property_id,
                        "room_type_id" => $channex_roomtypeid,
                        "date_from" => $date,
                        "date_to" => $ndate,
                        "availability" => (int)$totalrooms
                    ],
                ]
            ];

            try {

                $availabilityUrl =  config('services.channex.api_base') . "/availability";
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'user-api-key' => config('services.channex.api_key'),
                ])->post($availabilityUrl, $fulldata);
                $response->throw();

                $room_type->update(['channex_room_type_id' => $channex_roomtypeid]);
            } catch (Throwable $e) {
                $room_type->rooms()->delete();
                $room_type->delete();
                $response = [
                    'result' => 'error',
                    'message' => $e->getMessage()
                ];
            }
        }


        $response = [
            'result' => 'OK',
            'message' => "Room Type Created successfully!"
        ];
        return $response;
    }
}

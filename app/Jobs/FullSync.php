<?php

namespace App\Jobs;

use App\Models\RoomType;
use App\Models\Room;
use App\Models\Availability;
use App\Models\Restriction;
use App\Models\Property;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class FullSync 
{
    public function run()
    {
       
        $roomtypes=RoomType::where('type_status', 1)->get();
    $currentdate=today();
    $endDate=$currentdate->copy()->addDays(500)->toDateString();
    $currentdate=$currentdate->toDateString();
    $fulldata=array();
    $availabilityUrl = config('services.channex.api_base') . "/availability";
    foreach ($roomtypes as $roomtype) {
        
        if ($roomtype->channex_room_type_id) {
            $property=Property::where('hotel_id', $roomtype->hotel_settings_id)->first();
            $totalRooms=Room::where('room_type_id', $roomtype->id)->where('status', 'Enabled')->count();
            $startdate=$currentdate;
            while ($startdate<=$endDate) {
                $stopAvailability=Restriction::where('name', 'stop_availability')->whereDate('date', $startdate)->count();
                if ($stopAvailability>0) {
                    $available=0;
                }else{
                    $occupiedRooms = Availability::join("rooms", "availabilities.room_id", "=", "rooms.id")
                        ->where("availabilities.room_type_id", $roomtype->id)
                        ->whereDate("availabilities.date", $startdate)
                        ->where("rooms.status", "Enabled")
                        ->count();
                    $available=$totalRooms-$occupiedRooms;
                    
                }
                $innerdata=[
                    "property_id"=>$property->property_id,
                    "room_type_id"=>$roomtype->channex_room_type_id,
                    "date"=>$startdate,
                    "availability"=>$available
                ];
                array_push($fulldata, $innerdata);
                $startdate=Carbon::parse($startdate)->addDay()->toDateString();
            }

        }

        if ($fulldata) {
            
            $availdata=[
                "values"=>$fulldata
            ];
            try {
                $client=new Client;
                $client->post($availabilityUrl, [
                    'headers' => ['Content-Type' => 'application/json', 'user-api-key' => config('services.channex.api_key')],
                    'body' => json_encode($availdata),
                ]);
    
               
            } catch (\Throwable $th) {
                //throw $th;
                echo "false";
               
            }
        }
    }

   

       
    }

    public function sync_property(){
        $roomtypes=RoomType::where('type_status', 1)->where('hotel_settings_id', getHotelSettings()->id)->get();
        $currentdate=today();
        $endDate=$currentdate->copy()->addDays(500)->toDateString();
        $currentdate=$currentdate->toDateString();
        $fulldata=array();
        $availabilityUrl = config('services.channex.api_base') . "/availability";
        foreach ($roomtypes as $roomtype) {
            
            if ($roomtype->channex_room_type_id) {
                $property=Property::where('hotel_id', $roomtype->hotel_settings_id)->first();
                $totalRooms=Room::where('room_type_id', $roomtype->id)->where('status', 'Enabled')->count();
                $startdate=$currentdate;
                while ($startdate<=$endDate) {
                    $stopAvailability=Restriction::where('name', 'stop_availability')->whereDate('date', $startdate)->count();
                    if ($stopAvailability>0) {
                        $available=0;
                    }else{
                        $occupiedRooms = Availability::join("rooms", "availabilities.room_id", "=", "rooms.id")
                            ->where("availabilities.room_type_id", $roomtype->id)
                            ->whereDate("availabilities.date", $startdate)
                            ->where("rooms.status", "Enabled")
                            ->count();
                        $available=$totalRooms-$occupiedRooms;
                        
                    }
                    $innerdata=[
                        "property_id"=>$property->property_id,
                        "room_type_id"=>$roomtype->channex_room_type_id,
                        "date"=>$startdate,
                        "availability"=>$available
                    ];
                    array_push($fulldata, $innerdata);
                    $startdate=Carbon::parse($startdate)->addDay()->toDateString();
                }

            }

            if ($fulldata) {
                
                $availdata=[
                    "values"=>$fulldata
                ];
                try {
                    $client=new Client;
                    $client->post($availabilityUrl, [
                        'headers' => ['Content-Type' => 'application/json', 'user-api-key' => config('services.channex.api_key')],
                        'body' => json_encode($availdata),
                    ]);
        
                
                } catch (\Throwable $th) {
                    //throw $th;
                    echo "false";
                
                }
            }
        }
    }
}

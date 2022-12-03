<?php

namespace App\Jobs;

use App\Models\Availability;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\DailyRate;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class AutoNoShow 
{
    // use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __invoke()
    {
        $reservations=Reservation::where(function($query){
            $query->where('status', '!=', 'Cancelled')
                  ->orWhere('channex_status', '!=', 'cancelled');
        })->whereNull('actual_checkin')->where('arrival_date', '<=', today()->toDateString())->get();

        foreach ($reservations as $selected_reservation) {
           
            try {
                
                DB::beginTransaction();
                    
                    $hotel = $selected_reservation->hotel();
                    $propertyId = $hotel->active_property()->property_id;

                    $checkin = $selected_reservation->arrival_date;
                    $checkindate = $checkin;
                    $roomtypeid = $selected_reservation->room->room_type_id;
                    $channexroomtypeid = $selected_reservation->room->room_type->channex_room_type_id;
                    $checkout = Carbon::parse($selected_reservation->departure_date);
                    $checkin = Carbon::parse($checkin)->addDay();
                    $nights = $checkout->diffInDays($checkin);

                    $selected_reservation->arrival_date = $checkin->toDateString();
                    $selected_reservation->status = 'No Show';
                    $selected_reservation->overnights = $nights;
                    $selected_reservation->reservation_amount = $selected_reservation->daily_rates()->where("date", ">=", $checkin->toDateString())->where("date", "<", $checkout->toDateString())->sum('price');
                    $selected_reservation->save();

                    Availability::where("reservation_id", $selected_reservation->id)->where("date", $checkindate)->delete();
                    DB::commit();

                    if ($selected_reservation->room->room_type->channex_room_type_id) {
                        // update availability
                        $availabilityUrl = config('services.channex.api_base') . "/availability";

                        $availableRooms = getAvailability($selected_reservation->room->room_type, $checkindate);
                        $availdata = ["values" => [
                            [
                                "property_id" => $propertyId,
                                "room_type_id" => $channexroomtypeid,
                                "date" => $checkindate,
                                "availability" => $availableRooms,
                            ],
                        ]];

                        try {
                            $client = new Client;
                            $client->post($availabilityUrl, [
                                'headers' => ['Content-Type' => 'application/json', 'user-api-key' => config('services.channex.api_key')],
                                'body' => json_encode($availdata),
                            ]);
                        } catch (\Throwable $th) {
                            //throw $th;
                        }

                        
                    }
                    
                    if ($selected_reservation->booking_agency->channel_code=="BDC")
                     {
                        // mark as noshow to channex
                        $payload=[
                            "no_show_report"=>[
                                "waived_fees"=>false
                            ]
                         ];

                         try {
                            
                            $client = new Client;

                            $client->post(config('services.channex.api_base') . "/"."bookings/". $selected_reservation->channex_booking_id."/no_show", [
                                'headers' => ['Content-Type' => 'application/json', 'user-api-key' => config('services.channex.api_key')],
                                'body' => json_encode($payload),
                            ]);

                         } catch (\Throwable $th) {
                            //throw $th;
                         }
                       
                    }
                    


                   echo "updated  successfully";
               
                
            } catch (\Exception$e) {
                echo "eror occured";
            }
      }
    }

}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Availability;
use App\Models\Property;
use App\Models\RateType;
use App\Models\Country;
use App\Models\Guest;
use App\Models\HotelSetting;
use App\Models\PaymentMethod;
use App\Models\Reservation;
use App\Models\DailyRate;
use App\Models\ReservationDeposit;
use App\Models\RoomCondition;
use App\Models\BookingAgency;
use Illuminate\Support\Collection;
use App\Mail\NotifyReceiveReservation;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChannexReservationController extends Controller
{
    public $revisionId, $amount, $totalamount, $arrivalDate, $address, $city, $language, $zip, $departureDate, $name, $email, $country, $phone, $insertedAt, $notes, $adults, $infants, $children, $otaName, $otaReservationCode, $paymentCollect, $statuss, $reservationStatus, $arrivalHour, $uniqueId, $systemId, $totalchargedays, $chargeMode;
    public $rateTypeId, $rateTypePrepayment, $firstChargeDays, $secondchargeDays, $firstChargePercentage, $secondChargePercentage, $bookingDate, $hotel, $cardToken, $commission, $checkIn, $checkOut, $bookingAgencyId, $paymentMethodId, $nights, $days, $fulldata, $newReservation, $paymentModeId, $roomTypeId, $bookingid, $isCardType, $propertyId;
    
    public function store(Request $request)
    {
        try {
            $revision_id = $request->payload['revision_id'];
            $pciUrl=config('services.channex.pci_base').'/capture?api_key='.config('services.channex.pci_api_key').'&method=get&profile=channex_entity&url='.config('services.channex.pci_revision_base').'booking_revisions/'.$revision_id;
        

            /**
             * Get the revision reservation information
             */
            $client=new Client();
            $response=$client->post($pciUrl, ['headers'=>['user-api-key' => config('services.channex.api_key')]]);
            $response=json_decode($response->getBody(), true);
            $result=$response['data']['attributes'];
            // return response()->json($result);
            // dd($result);

            /**
             * @var \App\Models\Property
             *
             * The property that will be associated with the reservation
             */
            $property = Property::with(['hotel_setting'])->where('property_id', $result['property_id'])->firstOrFail();

            /**
             * @var \App\Models\HotelSetting
             *
             * The hotel settings that will be associated with the reservation
             */
            $this->hotel = $property->hotel_setting;

            $this->email='';
            $this->revisionId=$result['id'];
            $this->arrivalDate=$result['arrival_date'];
            $this->address=$result['customer']['address'];
            $this->city=$result['customer']['city'];
            $this->language=$result['customer']['language'];
            $this->zip=$result['customer']['zip'];
            $this->departureDate=$result['departure_date'];
            $fname=$result['customer']['name'];
            $surname=$result['customer']['surname'];
            $this->name=$fname." ".$surname;
            $this->email=$result['customer']['mail'];
            $countryCode=$result['customer']['country'];
            $this->phone=$result['customer']['phone'];
            $this->insertedAt=$result['inserted_at'];
            $this->notes=$result['notes'];
            $this->adults=intval($result['occupancy']['adults']);
            $this->infants=intval($result['occupancy']['infants']);
            $this->children=intval($result['occupancy']['children']);
            $otaName=$result['ota_name'];
            $this->otaReservationCode=$result['unique_id'];
            $this->paymentCollect=$result['payment_collect'];
            $paymentType=$result['payment_type'];
            $this->totalamount=$result['amount'];
            $this->statuss=$result['status'];
            $this->reservationStatus="Confirmed";
            $this->arrivalHour=$result['arrival_hour'];
            $this->uniqueId=$result['unique_id'];
            $this->systemId=$result['system_id'];
            $channelId=$result['channel_id'];
            $this->propertyId=$result['property_id'];
            $this->bookingid=$result["booking_id"];
            $rooms=$result['rooms'];
            $this->virtual_card=0;
            $parentratePlanId='';
            $paymentMethod='';
            $this->commission=0;
            $this->cardToken='';
            $decimals='';
            $totalRoomsForMail=0;
            $totalguests=0;
            
            
            if (isset($result['guarantee']['is_virtual'])) {

                    $this->virtual_card=$result['guarantee']['is_virtual'];
                }

            if (isset($result['guarantee']['token'])) {

                    $this->cardToken=$result['guarantee']['token'];
                }

            if (isset($result['raw_message']['ResGlobalInfo']['TotalCommissions']['CommissionPayableAmount']['amount'])) {

                    $this->commission=$result['raw_message']['ResGlobalInfo']['TotalCommissions']['CommissionPayableAmount']['amount'];
                }

            if (isset($result['raw_message']['ResGlobalInfo']['TotalCommissions']['CommissionPayableAmount']['decimal_places'])) {

                $decimals=$result['raw_message']['ResGlobalInfo']['TotalCommissions']['CommissionPayableAmount']['decimal_places'];
                }
            if (isset($result['guarantee']['card_type'])) {

                    $paymentMethod=$result['guarantee']['card_type'];
                }
            if ($this->commission) {

                $this->commission=(float)$this->commission/100;
                $this->commission=number_format((float)$this->commission, 2,'.','');

                }
            if ($this->statuss==="cancelled") {
                $this->reservationStatus="Cancelled"; 
            }
            $this->country=Country::where('alpha_two_code', $countryCode)->first();
            $getOtaCode=explode('-', $this->uniqueId);
            $otaCode=$getOtaCode[0];

             /**
             * @var \App\Models\BookingAgency
             *
             * The booking agency that will be associated with the reservation
             */
            
            $bookingAgency=BookingAgency::where('channex_channel_id', $channelId)->first();
            if ($bookingAgency) {
                    $this->bookingAgencyId=$bookingAgency->id;
                    $agencyname=$bookingAgency->name;
                    $this->paymentMethodId=$bookingAgency->default_payment_method_id;

                    if ((int)$this->virtual_card==1) {
                        $this->paymentModeId=$bookingAgency->virtual_card_payment_mode_id;
                        $this->totalchargedays=$bookingAgency->charge_date_days;
                        $this->chargeMode=$bookingAgency->charge_mode;

                    }else{

                        $this->paymentModeId=$bookingAgency->default_payment_mode_id;
                        
                    }
            }else{
                // $bookingAgency=BookingAgency::first();
                throw new \Exception("Couldn't locate an appropriate booking agency!", 500);
            }
                
                 /**
                 * @var \App\Models\PaymentMethod
                 *
                 * The payment method that will be associated with the reservation
                 */     
                
                if ($paymentMethod) {
                    // echo "payment method is available ";
                    $paymentCode=PaymentMethod::getMethodCode($paymentMethod);
                    $paymentMethods=PaymentMethod::where('channex_id', $paymentCode)->where('hotel_settings_id', $bookingAgency->hotel_settings_id)->first();
                    if ($paymentMethods) {
                        $this->paymentMethodId=$paymentMethods->id;
                        $this->isCardType=$paymentMethods->is_card_type;
                    }else{
                        $paymentMethods=$this->hotel->payment_methods->first();
                        $this->paymentMethodId=$paymentMethods->id;
                        $this->isCardType=$paymentMethods->is_card_type;
                    
                    }
                    
                }else{
                    // echo "payment method is absent";
                    $paymentMethods=PaymentMethod::where('id', $this->paymentMethodId)->first();
                    $this->isCardType=$paymentMethods->is_card_type;
                    
                }
            $availabilityUrl = config('services.channex.api_base') . "/availability";
            $this->fulldata=[];
            $roomtypesArray=[];
            $totalRoomsForMail=0;
            $totalAdults=0;
            $totalKids=0;
            $totalInfants=0;
            $combinedrateLevel='';

            // check if this booking code exists already
            $ifAlreadyExists=Reservation::where('booking_code', $this->otaReservationCode)->get();
            if (count($ifAlreadyExists)>0) {
                // echo "I am already in system ";
                if ($this->statuss=="new") {
                    // echo " do not add new bcz already in system";
                    # ...do nothing
                }else if ($this->statuss=="cancelled") {
                    // // echo "cancelled already";
                    # ...... delete availability and room condition
                    foreach ($ifAlreadyExists as $reservation) {
                        Availability::where('reservation_id', $reservation->id)->delete();
                        RoomCondition::where('reservation_id', $reservation->id)->delete();
                        foreach ($rooms as $currentRoom) {
                            $totalRoomsForMail++;
                            $ratePlanId=$currentRoom['rate_plan_id'];
                            
                            $days=$currentRoom['days'];
                            $totalAdults+=$currentRoom['occupancy']['adults'];
                            $totalKids+=$currentRoom['occupancy']['children'];
                            $totalInfants+=$currentRoom['occupancy']['infants'];
                            
                            $ratetype=RateType::where('channex_id', $ratePlanId)->first();
                            if (!$ratetype) {
                                if (isset($currentRoom['meta']['parent_rate_plan_id']) && $currentRoom['meta']['parent_rate_plan_id']) {
                                    $ratetype=RateType::where('channex_id', $currentRoom['meta']['parent_rate_plan_id'])->first();
                                }
                            }
                            if (!$ratetype) {
                                throw new \Exception("Couldn't locate an appropriate rate_type!", 500);
                            }
                            $ratetypeCode=$ratetype->reference_code;
                            $roomtypeName=$ratetype->room_type->name;
                            $roomtypesArray[]=$roomtypeName;
                            $starts=$this->checkIn;
                            $ends=$this->checkOut;
                            $ratelevel1="<tr><td><b>Rate Levels: </b></td> <td>[Rate Type,";
                            $ratelevel2="<tr class='tr-bg'><td></td><td class='td-column'>[".$ratetypeCode."";
                            while ($starts<$ends) {
                                $ndate=Carbon::parse($starts)->format('y/m/d');
                                $ratelevel1.="</td><td>".$ndate.",";
                                $crate=$days[$starts];
                                // echo "rate added ";
                                $ratelevel2.="</td><td class='td-column'>".$crate." ";
                                $starts= Carbon::parse($starts)->addDay()->toDateString();
                            }

                            $ratelevel1=$ratelevel1=substr($ratelevel1, 0, strlen($ratelevel1)-1);
                            $ratelevel2=$ratelevel2=substr($ratelevel2, 0, strlen($ratelevel2)-1);
                            $ratelevel1.="]</td></tr>";
                            $ratelevel2.="]</td></tr>";
                            $combinedrateLevel.=$ratelevel2;
                            
                    }
                    $ratelevels=$ratelevel1.$combinedrateLevel;
                    }
                    
                }else{
                    if (count($rooms)>1) {
                       // echo  "existing multiroom";
                            Availability::where('reservation_id', $ifAlreadyExists->id)->delete();
                            DailyRate::where('reservation_id', $ifAlreadyExists->id)->delete();
                            ReservationDeposit::where('reservation_id', $ifAlreadyExists->id)->delete();
                            RoomCondition::where('reservation_id', $ifAlreadyExists->id)->delete();
                            foreach ($ifAlreadyExists as $reservation) {
                                $starts=$reservation->arrival_date;
                                while ($starts<$reservation->departure_date) {
                                    // add channel manager availability
                                    $availability=getAvailability($reservation->room->room_type, $starts);
                                    $innerdata=[
                                
                                        "property_id"=> $this->propertyId,
                                        "room_type_id"=> $reservation->room->room_type->channex_room_type_id,
                                        "date"=> $starts,
                                        "availability"=> (int) $availability
                                        
                                        ];
                                        array_unshift($this->fulldata, $innerdata);

                                        $starts=Carbon::parse($starts)->addDay()->toDateString();
                                }
                                  $reservation->delete();
                            }
                            
                            foreach ($rooms as $currentRoom) {
                                    $totalRoomsForMail++;
                                    $this->channexBookingRoomId=$currentRoom['booking_room_id'];
                                    $this->checkIn=$currentRoom['checkin_date'];
                                    $this->checkOut=$currentRoom['checkout_date'];
                                    $ratePlanId=$currentRoom['rate_plan_id'];
                                    $this->roomTypeId=$currentRoom['room_type_id'];
                                    
                                    $this->days=$currentRoom['days'];
                                    $this->adults=$currentRoom['occupancy']['adults'];
                                    $this->children=$currentRoom['occupancy']['children'];
                                    $this->infants=$currentRoom['occupancy']['infants'];
                                    $this->amount=$currentRoom['amount'];
                                    $totalAdults+=$this->adults;
                                    $totalKids+=$this->children;
                                    $totalInfants+=$this->infants;
                                    
                                    
                                    $this->bookingDate=Carbon::parse($this->insertedAt)->toDateString();
                                    $ratetype=RateType::where('channex_id', $ratePlanId)->first();
                                    if (!$ratetype) {
                                        if (isset($currentRoom['meta']['parent_rate_plan_id']) && $currentRoom['meta']['parent_rate_plan_id']) {
                                            $ratetype=RateType::where('channex_id', $currentRoom['meta']['parent_rate_plan_id'])->first();
                                        }
                                    }
                                    if (!$ratetype) {
                                        throw new \Exception("Couldn't locate an appropriate rate_type!", 500);
                                    }
                                    $this->rateTypeId=$ratetype->id;
                                    $ratetypeName=$ratetype->name;
                                    $ratetypeCode=$ratetype->reference_code;
                                    $roomtypeName=$ratetype->room_type->name;
                                    $roomtypesArray[]=$roomtypeName;
                                    $this->rateTypePrepayment=$ratetype->prepayment;
                                    $this->firstChargeDays=$ratetype->reservation_charge_days;
                                    $this->secondchargeDays=$ratetype->reservation_charge_days_2;
                                    $this->firstChargePercentage=$ratetype->charge;
                                    $this->secondChargePercentage=$ratetype->charge2;

                                    $revenueaccom=1;
                                    $this->nights=0;
                                    $starts=$this->checkIn;
                                    $ends=$this->checkOut;
                                    $ratelevel1="<tr><td><b>Rate Levels: </b></td> <td>[Rate Type,";
                                    $ratelevel2="<tr class='tr-bg'><td></td><td class='td-column'>[".$ratetypeCode."";
                                    while ($starts<$ends) {
                                        $ndate=Carbon::parse($starts)->format('y/m/d');
                                        $ratelevel1.="</td><td>".$ndate.",";
                                        $crate=$this->days[$starts];
                                        $ratelevel2.="</td><td class='td-column'>".$crate." ";
                                        $this->nights++;
                                        $starts= Carbon::parse($starts)->addDay()->toDateString();
                                    }

                                    $ratelevel1=$ratelevel1=substr($ratelevel1, 0, strlen($ratelevel1)-1);
                                    $ratelevel2=$ratelevel2=substr($ratelevel2, 0, strlen($ratelevel2)-1);
                                    $ratelevel1.="]</td></tr>";
                                    $ratelevel2.="]</td></tr>";
                                    $combinedrateLevel.=$ratelevel2;
                                    $this->addNewReservation();
                            }
                            $ratelevels=$ratelevel1.$combinedrateLevel;
                            
                    }else{
                        // echo "single room booking ";
                        $totalRoomsForMail=1;
                        $this->channexBookingRoomId=$rooms[0]['booking_room_id'];
                        $this->checkIn=$rooms[0]['checkin_date'];
                        $this->checkOut=$rooms[0]['checkout_date'];
                        $ratePlanId=$rooms[0]['rate_plan_id'];
                        $this->roomTypeId=$rooms[0]['room_type_id'];
                        
                        $this->days=$rooms[0]['days'];
                        $this->adults=$rooms[0]['occupancy']['adults'];
                        $this->children=$rooms[0]['occupancy']['children'];
                        $this->infants=$rooms[0]['occupancy']['infants'];
                        $this->amount=$rooms[0]['amount'];
                        $totalAdults+=$this->adults;
                        $totalKids+=$this->children;
                        $totalInfants+=$this->infants;
                        $totalguests=(int)$this->adults+(int)$this->children+(int)$this->infants;
                        
                        $this->bookingDate=Carbon::parse($this->insertedAt)->toDateString();
                        $ratetype=RateType::where('channex_id', $ratePlanId)->first();
                        if (!$ratetype) {
                            if (isset($rooms[0]['meta']['parent_rate_plan_id']) && $rooms[0]['meta']['parent_rate_plan_id']) {
                                $ratetype=RateType::where('channex_id', $rooms[0]['meta']['parent_rate_plan_id'])->first();
                            }
                        }
                        if (!$ratetype) {
                            throw new \Exception("Couldn't locate an appropriate rate_type!", 500);
                        }
                        $this->rateTypeId=$ratetype->id;
                        $ratetypeName=$ratetype->name;
                        $ratetypeCode=$ratetype->reference_code;
                        $roomtypeName=$ratetype->room_type->name;
                        
                        $roomtypesArray[]=$roomtypeName;
                        $this->rateTypePrepayment=$ratetype->prepayment;
                        $this->firstChargeDays=$ratetype->reservation_charge_days;
                        $this->secondchargeDays=$ratetype->reservation_charge_days_2;
                        $this->firstChargePercentage=$ratetype->charge;
                        $this->secondChargePercentage=$ratetype->charge2;
                        $revenueaccom=1;
                        $this->nights=0;
                        $starts=$this->checkIn;
                        $ends=$this->checkOut;
                        $ratelevel1="<tr><td><b>Rate Levels: </b></td> <td>[Rate Type,";
                        $ratelevel2="<tr class='tr-bg'><td></td><td class='td-column'>[".$ratetypeCode."";
                        while ($starts<$ends) {
                            $ndate=Carbon::parse($starts)->format('y/m/d');
                            $ratelevel1.="</td><td>".$ndate.",";
                            $crate=$this->days[$starts];
                            $ratelevel2.="</td><td class='td-column'>".$crate." ";
                            $this->nights++;
                            $starts= Carbon::parse($starts)->addDay()->toDateString();
                        }

                        $ratelevel1=$ratelevel1=substr($ratelevel1, 0, strlen($ratelevel1)-1);
                        $ratelevel2=$ratelevel2=substr($ratelevel2, 0, strlen($ratelevel2)-1);
                        $ratelevel1.="]</td></tr>";
                        $ratelevel2.="]</td></tr>";
                        $ratelevels=$ratelevel1.$ratelevel2;
                       
                        $ifExistsWithSameDates=Reservation::join('rooms', 'rooms.id', 'reservations.room_id')->join('room_types', 'rooms.room_type_id', 'room_types.id')->join('rate_types', 'rate_types.id', 'reservations.rate_type_id')->where('booking_code', $this->otaReservationCode)->where('arrival_date', $this->checkIn)->where('departure_date', $this->checkOut)->where('channex_room_type_id', $this->roomTypeId)->where('channex_id', $ratePlanId)->get(['reservations.id', 'channex_cards'])->first();
                        
                        if ($ifExistsWithSameDates) {
                            // echo "update same dates";
                            DailyRate::where('reservation_id', $ifExistsWithSameDates->id)->delete();
                            // echo "daily rate deleted";
                            $this->newReservation=Reservation::where('id', $ifExistsWithSameDates->id)->first();
                             Reservation::where('id', $ifExistsWithSameDates->id)->update([
                                "booking_code"=>$this->otaReservationCode,
                                "channex_status"=>$this->statuss,
                                "country_id"=>$this->country->id,
                                "adults"=>$this->adults,
                                "kids"=>$this->children,
                                "infants"=>$this->infants,
                                "comment"=>$this->notes,
                                "rate_type_id"=>$this->rateTypeId,
                                "reservation_amount"=>$this->totalamount,
                                "commission_amount"=>$this->commission,
                                "reservation_revision_id"=>$this->revisionId,
                                "system_id"=>$this->systemId,
                                "reservation_inserted_at"=>$this->insertedAt,
                                "reservation_payment_collect"=>$this->paymentCollect,
                                "channex_booking_room_id"=>$this->channexBookingRoomId,
                                "reservation_unique_id"=>$this->uniqueId,
                                "ota_reservation_code"=>$this->otaReservationCode,
                                "virtual_card"=>$this->virtual_card,
                                "notif_status"=>0,
                                "channex_cards"=>$this->cardToken,
                                 
                            ]);
                           
                            $starts=$this->checkIn;
                            while ($starts<$this->checkOut) {
                            DailyRate::create([
                                "date"=>$starts,
                                "price"=>$this->days[$starts],
                                "reservation_id"=>$ifExistsWithSameDates->id
                            ]);
                            // echo "daily rate updated";
                            $starts=Carbon::parse($starts)->addDay()->toDateString();
                            }
                            // if ($ifExistsWithSameDates->channex_cards!==$this->cardToken) {
                            //     $deleteCardUrl=env("PCI_BASE")."/"."cards/".$ifExistsWithSameDates->channex_cards."?api_key=".config('services.channex.pci_api_key');
                            //     $client=new Client();
                            //     $client->delete($deleteCardUrl, ['headers'=>['user-api-key' => config('services.channex.api_key')]]);
                            // }
                            
                            

                        }else{
                            // echo "update different dates";
                            $ifAlreadyExists=$ifAlreadyExists->first();
                            Availability::where('reservation_id', $ifAlreadyExists->id)->delete();
                            DailyRate::where('reservation_id', $ifAlreadyExists->id)->delete();
                            ReservationDeposit::where('reservation_id', $ifAlreadyExists->id)->delete();
                            RoomCondition::where('reservation_id', $ifAlreadyExists->id)->delete();
                            // echo " deleted availability ";
                            $starts=$ifAlreadyExists->arrival_date;
                            $totalRooms=Room::where('status', 'Enabled')->where('room_type_id',$ifAlreadyExists->room->room_type->id)->count();
                            while ($starts<$ifAlreadyExists->departure_date) {
                                 // add channel manager availability
                                $availability=getAvailability($ifAlreadyExists->room->room_type, $starts);
                                $innerdata=[
                            
                                    "property_id"=> $this->propertyId,
                                    "room_type_id"=> $ifAlreadyExists->room->room_type->channex_room_type_id,
                                    "date"=> $starts,
                                    "availability"=> (int) $availability
                                    
                                    ];
                                    array_unshift($this->fulldata, $innerdata);

                                    $starts=Carbon::parse($starts)->addDay()->toDateString();
                            }
                            $this->updateReservation($ifAlreadyExists);

                        }
                    }
                }
            }else{
                // echo " booking do not exists already ";
                            foreach ($rooms as $currentRoom) {
                                    $totalRoomsForMail++;
                                    $this->channexBookingRoomId=$currentRoom['booking_room_id'];
                                    $this->checkIn=$currentRoom['checkin_date'];
                                    $this->checkOut=$currentRoom['checkout_date'];
                                    $ratePlanId=$currentRoom['rate_plan_id'];
                                    $this->roomTypeId=$currentRoom['room_type_id'];
                                    
                                    $this->days=$currentRoom['days'];
                                    $this->adults=$currentRoom['occupancy']['adults'];
                                    $this->children=$currentRoom['occupancy']['children'];
                                    $this->infants=$currentRoom['occupancy']['infants'];
                                    $this->amount=$currentRoom['amount'];
                                    $totalAdults+=$this->adults;
                                    $totalKids+=$this->children;
                                    $totalInfants+=$this->infants;
                                    
                                    $this->bookingDate=Carbon::parse($this->insertedAt)->toDateString();
                                    $ratetype=RateType::where('channex_id', $ratePlanId)->first();
                                    if (!$ratetype) {
                                        if (isset($currentRoom['meta']['parent_rate_plan_id']) && $currentRoom['meta']['parent_rate_plan_id']) {
                                            $ratetype=RateType::where('channex_id', $currentRoom['meta']['parent_rate_plan_id'])->first();
                                        }
                                    }
                                    if (!$ratetype) {
                                        throw new \Exception("Couldn't locate an appropriate rate_type!", 500);
                                    }
                                    $this->rateTypeId=$ratetype->id;
                                    $ratetypeName=$ratetype->name;
                                    $ratetypeCode=$ratetype->reference_code;
                                    $roomtypeName=$ratetype->room_type->name;
                                    $roomtypesArray[]=$roomtypeName;
                                    $this->rateTypePrepayment=$ratetype->prepayment;
                                    $this->firstChargeDays=$ratetype->reservation_charge_days;
                                    $this->secondchargeDays=$ratetype->reservation_charge_days_2;
                                    $this->firstChargePercentage=$ratetype->charge;
                                    $this->secondChargePercentage=$ratetype->charge2;

                                    $revenueaccom=1;
                                    $this->nights=0;
                                    $starts=$this->checkIn;
                                    $ends=$this->checkOut;
                                    $ratelevel1="<tr><td><b>Rate Levels: </b></td> <td>[Rate Type,";
                                    $ratelevel2="<tr class='tr-bg'><td></td><td class='td-column'>[".$ratetypeCode."";
                                    while ($starts<$ends) {
                                        $ndate=Carbon::parse($starts)->format('y/m/d');
                                        $ratelevel1.="</td><td>".$ndate.",";
                                        $crate=$this->days[$starts];
                                        // echo "rate added ";
                                        $ratelevel2.="</td><td class='td-column'>".$crate." ";
                                        $this->nights++;
                                        $starts= Carbon::parse($starts)->addDay()->toDateString();
                                    }

                                    $ratelevel1=$ratelevel1=substr($ratelevel1, 0, strlen($ratelevel1)-1);
                                    $ratelevel2=$ratelevel2=substr($ratelevel2, 0, strlen($ratelevel2)-1);
                                    $ratelevel1.="]</td></tr>";
                                    $ratelevel2.="]</td></tr>";
                                    $combinedrateLevel.=$ratelevel2;
                                    $this->addNewReservation();
                            }
                            $ratelevels=$ratelevel1.$combinedrateLevel;


            }
            // send email...........
            if ($this->newReservation) {
                $roomscount=array_count_values($roomtypesArray);
                $roomtypeString='';
                foreach ($roomscount as $key => $value) {
                    $roomtypeString.=$value." ".$key.",";
                }
                $totalguests=(int)$totalAdults+(int)$totalKids+(int)$totalInfants;
                $roomtypeString=substr($roomtypeString, 0, strlen($roomtypeString)-1);
                $adults=$totalAdults>1? ' adults':' adult ';
                $kids=$totalKids>1? ' kids ':' kid ';
                $infants=$totalInfants>1? ' infants ':' infant ';
                $guestinfo=$totalAdults.$adults. $totalKids.$kids. $totalInfants.$infants;
                $persons=$totalguests>1? ' persons ':' person ';
                $rooms=$totalRoomsForMail>1? ' rooms ':' room ';
                $pax= $totalRoomsForMail.$rooms. $totalguests.$persons;
                Mail::to($this->hotel->notification_receiver_email)->send(new NotifyReceiveReservation($this->newReservation, $this->hotel, $ratelevels, $guestinfo, $roomtypeString, $pax));
                // // echo "email sent successfully to ".$this->hotel->notification_receiver_email;

            }
            // send availability to channex............
            $availData=["values"=>$this->fulldata];
            $client=new Client();
            $client->post($availabilityUrl, [
                'headers' => ['Content-Type' => 'application/json', 'user-api-key' => config('services.channex.api_key')],
                'body' => json_encode($availData),
            ]);
            // ack booking..........
            // $client = new Client;

            // $acknowledge=$client->post(config('services.channex.api_base') . "/"."booking_revisions/". $this->revisionId."/ack", [
            //     'headers' => ['Content-Type' => 'application/json', 'user-api-key' => config('services.channex.api_key')],
                
            // ]);
            return response()->json(['status' => 'success', 'message' => "Reservation successfully updated!"],);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);
        }
    }

    public function getRoom($checkIn, $checkOut, $roomTypeId){
        $checkIn=$checkIn;
        $checkOut=$checkOut;
        $roomTypeId=$roomTypeId;
       
            $getAvailableRoom=Room::join('room_types','rooms.room_type_id', '=', 'room_types.id')->whereNotIn('rooms.id',function($query) use ($checkIn, $checkOut, $roomTypeId){
                $query->select('room_id')->from('availabilities')
                ->join('room_types', 'availabilities.room_type_id', 'room_types.id')
                ->whereBetween('availabilities.date', [$checkIn, $checkOut ])
                ->where('channex_room_type_id', $roomTypeId)->get();

            })->where('channex_room_type_id', $roomTypeId)->where('rooms.status', 'Enabled');
            
            $getAvailableRoom=$getAvailableRoom->whereNotIn('rooms.id', function($query) use ($checkIn, $checkOut, $roomTypeId){
                $query->select('room_id')->from('maintenances')
                ->join('rooms', 'rooms.id', '=', 'maintenances.room_id')
                ->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
                ->whereBetween('start_date', [$checkIn, $checkOut])
                ->orWhereBetween('end_date', [$checkIn, $checkOut])
                ->where('channex_room_type_id', $roomTypeId)->get();
            })->selectRaw('rooms.id as id, rooms.room_type_id as room_type_id')->first();
            return $getAvailableRoom;
    }

    public function getChargeDate(){
            $bdate=Carbon::parse($this->bookingDate)->setTime(0,0);
            $cdate=Carbon::parse($this->checkIn)->setTime(0,0);
            $daysdiff=(int) $bdate->diffInDays($cdate);
            if ($this->rateTypePrepayment>0) {
                $chargeDate=$this->bookingDate;
            }else{

                if ($this->firstChargePercentage>0) {

                if ($daysdiff>=$this->firstChargeDays) {
                    $chargeDate=$cdate->copy()->subDays($this->firstChargeDays)->toDateString();
                }else{
                    $chargeDate=$this->bookingDate;
                }
                }else{

                if ($daysdiff>=$this->secondchargeDays) {
                        $chargeDate=$cdate->copy()->subDays($this->secondchargeDays)->toDateString();
                }else{
                        $chargeDate=$this->bookingDate;
                }
                }
            }
            
            return $chargeDate;
    }

    public function addNewReservation(){
        $checkIn=$this->checkIn;
        $checkOut=Carbon::parse($this->checkOut)->subDay()->toDateString();
        $roomTypeId=$this->roomTypeId;
        $getAvailableRoom=$this->getRoom($checkIn, $checkOut, $roomTypeId);
        $chargeDate=$this->getChargeDate();
           
            
            DB::beginTransaction();
            try {
                $guest=Guest::create([
                    "hotel_settings_id"=>$this->hotel->id,
                    "full_name"=>$this->name,
                    "email"=>$this->email? $this->email:'',
                    "country_id"=>$this->country->id,
                    "city"=>$this->city? $this->city:'',
                    "address"=>$this->address? $this->address:'',
                    "language"=>$this->language? $this->language:'',
                    "phone"=>$this->phone? $this->phone:'',
                    "postal_code"=>$this->zip? $this->zip:''
    
                ]);
                // echo " guest added";
                if ($getAvailableRoom) {
                    $this->newReservation= Reservation::create([
                        "booking_code"=>$this->otaReservationCode,
                        "channex_status"=>$this->statuss,
                        "status"=>$this->reservationStatus,
                        "booking_agency_id"=>$this->bookingAgencyId,
                        "revenue_amount_accommodation"=>1,
                        "charge_date"=>$chargeDate,
                        "payment_method_id"=>$this->paymentMethodId,
                        "payment_mode_id"=>$this->paymentModeId,
                        "check_in"=>$this->arrivalDate,
                        "check_out"=>$this->departureDate,
                        "arrival_date"=>$this->checkIn,
                        "departure_date"=>$this->checkOut,
                        "overnights"=>$this->nights,
                        "arrival_hour"=>$this->arrivalHour,
                        "country_id"=>$this->country->id,
                        "adults"=>$this->adults,
                        "kids"=>$this->children,
                        "infants"=>$this->infants,
                        "booking_date"=>$this->bookingDate,
                        "comment"=>$this->notes,
                        "rate_type_id"=>$this->rateTypeId,
                        "room_id"=>$getAvailableRoom->id,
                        "guest_id"=>$guest->id,
                        "reservation_amount"=>$this->totalamount,
                        "commission_amount"=>$this->commission,
                        "reservation_revision_id"=>$this->revisionId,
                        "system_id"=>$this->systemId,
                        "reservation_inserted_at"=>$this->insertedAt,
                        "reservation_payment_collect"=>$this->paymentCollect,
                        "channex_booking_room_id"=>$this->channexBookingRoomId,
                        "reservation_unique_id"=>$this->uniqueId,
                        "ota_reservation_code"=>$this->otaReservationCode,
                        "virtual_card"=>$this->virtual_card,
                        "notif_status"=>0,
                        "discount"=>0,
                        "channex_cards"=>$this->cardToken,
                        "channex_booking_id"=>$this->bookingid,
                        "hotel_settings_id"=>$this->hotel->id
    
                    ]);
                    
                    if ($this->statuss!='cancelled') {
                        $this->addAvailability($getAvailableRoom, $this->newReservation, $this->checkIn, $this->checkOut);
                    }
                    
    
                }else{
                    $this->newReservation= Reservation::create([
                        "booking_code"=>$this->otaReservationCode,
                        "channex_status"=>$this->statuss,
                        "status"=>$this->reservationStatus,
                        "booking_agency_id"=>$this->bookingAgencyId,
                        "revenue_amount_accommodation"=>1,
                        "charge_date"=>$chargeDate,
                        "payment_method_id"=>$this->paymentMethodId,
                        "payment_mode_id"=>$this->paymentModeId,
                        "check_in"=>$this->arrivalDate,
                        "check_out"=>$this->departureDate,
                        "arrival_date"=>$this->checkIn,
                        "departure_date"=>$this->checkOut,
                        "overnights"=>$this->nights,
                        "arrival_hour"=>$this->arrivalHour,
                        "country_id"=>$this->country->id,
                        "adults"=>$this->adults,
                        "kids"=>$this->children,
                        "infants"=>$this->infants,
                        "booking_date"=>$this->bookingDate,
                        "comment"=>$this->notes,
                        "rate_type_id"=>$this->rateTypeId,
                        "guest_id"=>$guest->id,
                        "reservation_amount"=>$this->totalamount,
                        "commission_amount"=>$this->commission,
                        "reservation_revision_id"=>$this->revisionId,
                        "system_id"=>$this->systemId,
                        "reservation_inserted_at"=>$this->insertedAt,
                        "reservation_payment_collect"=>$this->paymentCollect,
                        "channex_booking_room_id"=>$this->channexBookingRoomId,
                        "reservation_unique_id"=>$this->uniqueId,
                        "ota_reservation_code"=>$this->otaReservationCode,
                        "virtual_card"=>$this->virtual_card,
                        "notif_status"=>0,
                        "discount"=>0,
                        "room_id"=>null,
                        "channex_cards"=>$this->cardToken,
                        "channex_booking_id"=>$this->bookingid,
                        "hotel_settings_id"=>$this->hotel->id
    
                    ]);
                }
    
                if ($this->statuss!='cancelled') {
                    // echo " adding charge plan ";
                    $this->addChargeReservationPlan($chargeDate);
                }
                    
                        $starts=$this->checkIn;
                        while ($starts<$this->checkOut) {
                        DailyRate::create([
                            "date"=>$starts,
                            "price"=>$this->days[$starts],
                            "reservation_id"=>$this->newReservation->id
                        ]);
                        $starts=Carbon::parse($starts)->addDay()->toDateString();
                        }
            } catch (\Throwable $th) {
                DB::rollback();
                throw new \Exception($th->getMessage(), 500);
            }
            
            DB::commit();

            $this->addChannexAvailability();
    }

    public function addAvailability($room, $reservation, $checkin, $checkout){
        $getRoomCondition=RoomCondition::where('date', $checkin)->where('room_id', $room->id)->first();
        if ($getRoomCondition) {
            $wasDeparture="yes";
        }else{
            $wasDeparture="no";
        }
        $cleanDays=(int)$this->hotel->housekeeping;
        $countclean=1;
        $daycounter=0;

        while ($checkin<$checkout) {
        // add availability
            Availability::create([
            "date"=>$checkin,
            "room_id"=>$room->id,
            "room_type_id"=>$room->room_type_id,
            "reservation_id"=>$reservation->id
            ]);
        //  add room condition
        $daycounter=$daycounter+1;
        if($daycounter<3){
            if($wasDeparture=="yes" && $daycounter==1){
            $roomstatus="Dirty";
            }else{
            $roomstatus="Clean";
            }
        }else{
            if($countclean==1 && $daycounter>2){
            $roomstatus="Dirty";
            $countclean=$countclean+1;  
            }
            else if($countclean!=1 && $countclean<$cleandays){
            
            $roomstatus="Clean";
            $countclean=$countclean+1;      
            }
            else if($countclean!=1 && $countclean==$cleandays){
            
            $roomstatus="Clean";
            $countclean=1;      
            }else{}
        }
        RoomCondition::create([
            "status"=>$roomstatus,
            "date"=>$checkin,
            "room_id"=>$room->id,
            "reservation_id"=>$reservation->id
        ]);

            $checkin=Carbon::parse($checkin)->addDay()->toDateString();
        }
    }

    public function addChannexAvailability(){
        $room_type=RoomType::where('channex_room_type_id', $this->roomTypeId)->first();
        $checkin=$this->checkIn;
        $checkout=$this->checkOut;
        while ($checkin<$checkout) {
        $availability=getAvailability($room_type, $checkin);
        $innerdata=[
    
            "property_id"=> $this->propertyId,
            "room_type_id"=> $room_type->channex_room_type_id,
            "date"=> $checkin,
            "availability"=> (int) $availability
            
            ];
            array_unshift($this->fulldata, $innerdata);

            $checkin=Carbon::parse($checkin)->addDay()->toDateString();
        }
    }

    public function addChargeReservationPlan($chargeDate){
        $chrgDate=Carbon::parse($chargeDate);
            if ((int)$this->isCardType==1) {
                
                if ((int)$this->virtual_card==1) {

                    if ((int)$this->totalchargedays==0) {

                        $firstChargeDate=$this->arrivalDate;

                    }else{

                        if ($this->chargeMode=="beforearrival") {
                            $firstChargeDate=Carbon::parse($this->arrivalDate)->subDays($this->totalchargedays)->toDateString();
                        }else if ($this->chargeMode=="afterarrival") {
                            $firstChargeDate=Carbon::parse($this->arrivalDate)->addDays($this->totalchargedays)->toDateString();
                        }else{
                            $firstChargeDate=Carbon::parse($this->arrivalDate)->addDays($this->totalchargedays)->toDateString();
                        }

                        
                    }
                    ReservationDeposit::create([
                        "has_prepayment"=>0,
                        "prepayment_value"=>0,
                        "prepayment_date_to_pay"=>NULL,
                        "prepayment_is_paid"=>0,
                        "prepayment_payment_date"=>NULL,
                        "has_first_charge"=>1,
                        "first_charge_value"=>$this->amount,
                        "first_charge_date_to_pay"=>$firstChargeDate,
                        "first_charge_is_paid"=>0,
                        "first_charge_payment_date"=>NULL,
                        "has_second_charge"=>0,
                        "second_charge_value"=>0,
                        "second_charge_date_to_pay"=>NULL,
                        "second_charge_is_paid"=>0,
                        "second_charge_payment_date"=>NULL,
                        "reservation_id"=>$this->newReservation->id
                    ]);

                }else{
                    $adate=Carbon::parse($this->arrivalDate);
                    $daysbetween=$chrgDate->diffInDays($adate);
                    $firstChargeDate=NULL;
                    $secondChargeDate=NULL;
                    $prepaymentDate=NULL;
                    $hasPrepayment=0;
                    $hasFirstCharge=0;
                    $hasSecondCharge=0;
                    $prepaymentValue=0;
                    $firstChargeValue=0;
                    $secondChargeValue=0;
                    if ($this->rateTypePrepayment>0) {

                        $hasPrepayment=1;
                        $prepaymentValue= (float)$this->amount*(float)$this->rateTypePrepayment/100;
                        $prepaymentValue=number_format((float)$prepaymentValue, 2, '.', '');

                        if ($daysbetween>$this->firstChargeDays) {
                            $prepaymentDate=$chargeDate;

                        }

                        if ($daysbetween==$this->firstChargeDays) {

                            $prepaymentDate=Carbon::parse($this->arrivalDate)->subDays($this->firstChargeDays)->toDateString();
                        }

                        if ($daysbetween>=$this->secondchargeDays && $daysbetween<$this->firstChargeDays) {

                            $prepaymentDate=Carbon::parse($this->arrivalDate)->subDays($this->secondchargeDays)->toDateString();
                            
                        }

                        if ($daysbetween<$this->secondchargeDays) {

                            $prepaymentDate=$this->arrivalDate;
                        }
                    }

                    if ($this->firstChargePercentage>0) {

                        $hasFirstCharge=1;
                        $firstChargeValue=(float) $this->amount*(float)$this->firstChargePercentage/100;
                        $firstChargeValue=number_format((float)$firstChargeValue,2, '.', '');

                        if ($daysbetween>=$this->firstChargeDays) {

                            $firstChargeDate=Carbon::parse($this->arrivalDate)->subDays($this->firstChargeDays)->toDateString();
                        }

                        if ($daysbetween>=$this->secondchargeDays && $daysbetween<$this->firstChargeDays) {

                            $firstChargeDate=Carbon::parse($this->arrivalDate)->subDays($this->secondchargeDays)->toDateString();
                        }

                        if ($daysbetween<$this->secondchargeDays) {

                            $firstChargeDate=$this->arrivalDate;
                        }
                    }

                    if ($this->secondChargePercentage>0) {

                        $hasSecondCharge=1;
                        $secondChargeValue=(float)$this->amount* (float)$this->secondChargePercentage/100;
                        $secondChargeValue=number_format((float)$secondChargeValue, 2, '.', '');

                        if ($daysbetween>=$this->secondchargeDays) {

                            $secondChargeDate=Carbon::parse($this->arrivalDate)->subDays($this->secondchargeDays)->toDateString();
                        }

                        if ($daysbetween<$this->secondchargeDays) {

                            $secondChargeDate=$this->arrivalDate;
                        }
                    }
                    // echo "adding reservation deposit ";
                    ReservationDeposit::create([
                        "has_prepayment"=>$hasPrepayment,
                        "prepayment_value"=>$prepaymentValue,
                        "prepayment_date_to_pay"=>$prepaymentDate,
                        "prepayment_is_paid"=>0,
                        "prepayment_payment_date"=>NULL,
                        "has_first_charge"=>$hasFirstCharge,
                        "first_charge_value"=>$firstChargeValue,
                        "first_charge_date_to_pay"=>$firstChargeDate,
                        "first_charge_is_paid"=>0,
                        "first_charge_payment_date"=>NULL,
                        "has_second_charge"=>$hasSecondCharge,
                        "second_charge_value"=>$secondChargeValue,
                        "second_charge_date_to_pay"=>$secondChargeDate,
                        "second_charge_is_paid"=>0,
                        "second_charge_payment_date"=>NULL,
                        "reservation_id"=>$this->newReservation->id
                    ]);
                   
                }
                
                }
    }

    public function updateReservation($previosReservation){
        $checkIn=$this->checkIn;
        $checkOut=Carbon::parse($this->checkOut)->subDay()->toDateString();
        $roomTypeId=$this->roomTypeId;
        $chargeDate=$this->getChargeDate();
        DB::beginTransaction();
        try {
            
            $guest=Guest::where('id', $previosReservation->guest_id)->first();
                $guest->hotel_settings_id=$this->hotel->id;
                $guest->full_name=$this->name;
                $guest->email=$this->email? $this->email:'';
                $guest->country_id=$this->country->id;
                $guest->city=$this->city? $this->city:'';
                $guest->address=$this->address? $this->address:'';
                $guest->language=$this->language? $this->language:'';
                $guest->phone=$this->phone? $this->phone:'';
                $guest->postal_code=$this->zip? $this->zip:'';
                $guest->save();
    
          
            $getAvailableRoom=$this->getRoom($checkIn, $checkOut, $roomTypeId);
            
            if ($getAvailableRoom) {
                $this->newReservation=Reservation::where('id', $previosReservation->id)->first();
                 Reservation::where('id', $previosReservation->id)->update([
                    "booking_code"=>$this->otaReservationCode,
                    "channex_status"=>$this->statuss,
                    "status"=>$this->reservationStatus,
                    "booking_agency_id"=>$this->bookingAgencyId,
                    "revenue_amount_accommodation"=>1,
                    "charge_date"=>$chargeDate,
                    "payment_method_id"=>$this->paymentMethodId,
                    "payment_mode_id"=>$this->paymentModeId,
                    "check_in"=>$this->arrivalDate,
                    "check_out"=>$this->departureDate,
                    "arrival_date"=>$this->checkIn,
                    "departure_date"=>$this->checkOut,
                    "overnights"=>$this->nights,
                    "arrival_hour"=>$this->arrivalHour,
                    "country_id"=>$this->country->id,
                    "adults"=>$this->adults,
                    "kids"=>$this->children,
                    "infants"=>$this->infants,
                    "booking_date"=>$this->bookingDate,
                    "comment"=>$this->notes,
                    "rate_type_id"=>$this->rateTypeId,
                    "room_id"=>$getAvailableRoom->id,
                    "guest_id"=>$guest->id,
                    "reservation_amount"=>$this->totalamount,
                    "commission_amount"=>$this->commission,
                    "reservation_revision_id"=>$this->revisionId,
                    "system_id"=>$this->systemId,
                    "reservation_inserted_at"=>$this->insertedAt,
                    "reservation_payment_collect"=>$this->paymentCollect,
                    "channex_booking_room_id"=>$this->channexBookingRoomId,
                    "reservation_unique_id"=>$this->uniqueId,
                    "ota_reservation_code"=>$this->otaReservationCode,
                    "virtual_card"=>$this->virtual_card,
                    "notif_status"=>0,
                    "channex_cards"=>$this->cardToken,
                    "channex_booking_id"=>$this->bookingid,
                    "hotel_settings_id"=>$this->hotel->id
    
                ]);
                if ($this->statuss!='cancelled') {
                    $this->addAvailability($getAvailableRoom, $this->newReservation, $this->checkIn, $this->checkOut);
                }
                 
            }else{
                $this->newReservation=Reservation::where('id', $previosReservation->id)->first();
                 Reservation::where('id', $previosReservation->id)->update([
                    "booking_code"=>$this->otaReservationCode,
                    "channex_status"=>$this->statuss,
                    "status"=>$this->reservationStatus,
                    "booking_agency_id"=>$this->bookingAgencyId,
                    "revenue_amount_accommodation"=>1,
                    "charge_date"=>$chargeDate,
                    "payment_method_id"=>$this->paymentMethodId,
                    "payment_mode_id"=>$this->paymentModeId,
                    "check_in"=>$this->arrivalDate,
                    "check_out"=>$this->departureDate,
                    "arrival_date"=>$this->checkIn,
                    "departure_date"=>$this->checkOut,
                    "overnights"=>$this->nights,
                    "arrival_hour"=>$this->arrivalHour,
                    "country_id"=>$this->country->id,
                    "adults"=>$this->adults,
                    "kids"=>$this->children,
                    "infants"=>$this->infants,
                    "booking_date"=>$this->bookingDate,
                    "comment"=>$this->notes,
                    "rate_type_id"=>$this->rateTypeId,
                    "guest_id"=>$guest->id,
                    "reservation_amount"=>$this->totalamount,
                    "commission_amount"=>$this->commission,
                    "reservation_revision_id"=>$this->revisionId,
                    "system_id"=>$this->systemId,
                    "reservation_inserted_at"=>$this->insertedAt,
                    "reservation_payment_collect"=>$this->paymentCollect,
                    "channex_booking_room_id"=>$this->channexBookingRoomId,
                    "reservation_unique_id"=>$this->uniqueId,
                    "ota_reservation_code"=>$this->otaReservationCode,
                    "virtual_card"=>$this->virtual_card,
                    "notif_status"=>0,
                    "room_id"=>null,
                    "channex_cards"=>$this->cardToken,
                    "channex_booking_id"=>$this->bookingid,
                    "hotel_settings_id"=>$this->hotel->id
    
                ]);
            }
                if ($this->statuss!='cancelled') {
                    // echo " add charge plan ";
                    $this->addChargeReservationPlan($chargeDate);
                }
                
                    $starts=$this->checkIn;
                    while ($starts<$this->checkOut) {
                    DailyRate::create([
                        "date"=>$starts,
                        "price"=>$this->days[$starts],
                        "reservation_id"=>$this->newReservation->id
                    ]);
                    $starts=Carbon::parse($starts)->addDay()->toDateString();
                    }
        } catch (\Throwable $th) {
            DB::rollback();
            throw new \Exception($e->getMessage(), 500);
        }

        DB::commit();
        $this->addChannexAvailability();
        
   }
}

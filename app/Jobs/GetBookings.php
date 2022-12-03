<?php

namespace App\Jobs;

use App\Models\RoomType;
use App\Models\Room;
use App\Models\Availability;
use Ap\Models\Property;
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

class GetBookings 
{
    public $revisionId, $amount, $totalamount, $arrivalDate, $address, $city, $language, $zip, $departureDate, $name, $email, $country, $phone, $insertedAt, $notes, $adults, $infants, $children, $otaName, $otaReservationCode, $paymentCollect, $statuss, $reservationStatus, $arrivalHour, $uniqueId, $systemId, $totalchargedays, $chargeMode;
    public $rateTypeId, $rateTypePrepayment, $firstChargeDays, $secondchargeDays, $firstChargePercentage, $secondChargePercentage, $bookingDate, $hotel, $cardToken, $commission, $checkIn, $checkOut, $bookingAgencyId, $paymentMethodId, $nights, $days, $fulldata, $newReservation, $paymentModeId, $roomTypeId, $bookingid, $isCardType, $propertyId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     //
    // }

    // /**
    //  * Execute the job.
    //  *
    //  * @return void
    //  */
    // public function handle()
    // {
    //     //
    // }

    public function __invoke(){
        $pciUrl=config('services.channex.pci_base').'/capture?api_key='.config('services.channex.pci_api_key').'&method=get&profile=channex&url=https://secure-staging.channex.io/api/v1/booking_revisions/feed';
        try {
            $client=new Client();
            $response=$client->post($pciUrl, ['headers'=>['user-api-key' => config('services.channex.api_key')]]);
            $response=json_decode($response->getBody(), true);
            $response=$response['data'];
            foreach ($response as $result) {
                $this->email='';
                $this->revisionId=$result['attributes']['id'];
                $this->arrivalDate=$result['attributes']['arrival_date'];
                $this->address=$result['attributes']['customer']['address'];
                $this->city=$result['attributes']['customer']['city'];
                $this->language=$result['attributes']['customer']['language'];
                $this->zip=$result['attributes']['customer']['zip'];
                $this->departureDate=$result['attributes']['departure_date'];
                $fname=$result['attributes']['customer']['name'];
                $surname=$result['attributes']['customer']['surname'];
                $this->name=$fname." ".$surname;
                $this->email=$result['attributes']['customer']['mail'];
                $countryCode=$result['attributes']['customer']['country'];
                $this->phone=$result['attributes']['customer']['phone'];
                $this->insertedAt=$result['attributes']['inserted_at'];
                $this->notes=$result['attributes']['notes'];
                $this->adults=intval($result['attributes']['occupancy']['adults']);
                $this->infants=intval($result['attributes']['occupancy']['infants']);
                $this->children=intval($result['attributes']['occupancy']['children']);
                $otaName=$result['attributes']['ota_name'];
                $this->otaReservationCode=$result['attributes']['ota_reservation_code'];
                $this->paymentCollect=$result['attributes']['payment_collect'];
                $paymentType=$result['attributes']['payment_type'];
                $this->totalamount=$result['attributes']['amount'];
                $this->statuss=$result['attributes']['status'];
                $this->reservationStatus="Confirmed";
                $this->arrivalHour=$result['attributes']['arrival_hour'];
                $this->uniqueId=$result['attributes']['unique_id'];
                $this->systemId=$result['attributes']['system_id'];
                $channelId=$result['attributes']['channel_id'];
                $this->propertyId=$result['attributes']['property_id'];
                $this->bookingid=$result["relationships"]["data"]["booking"]["id"];
                $rooms=$result['attributes']['rooms'];
                $this->virtual_card=0;
                $parentratePlanId='';
                $paymentMethod='';
                $this->commission=0;
                $this->cardToken='';
                $decimals='';
                $totalRoomsForMail=0;
                $totalguests=0;
                
                
                if (isset($result['attributes']['guarantee']['is_virtual'])) {

                        $this->virtual_card=$result['attributes']['guarantee']['is_virtual'];
                    }

                if (isset($result['attributes']['guarantee']['token'])) {

                        $this->cardToken=$result['attributes']['guarantee']['token'];
                    }

                if (isset($result['attributes']['raw_message']['ResGlobalInfo']['TotalCommissions']['CommissionPayableAmount']['amount'])) {

                        $this->commission=$result['attributes']['raw_message']['ResGlobalInfo']['TotalCommissions']['CommissionPayableAmount']['amount'];
                    }

                if (isset($result['attributes']['raw_message']['ResGlobalInfo']['TotalCommissions']['CommissionPayableAmount']['decimal_places'])) {

                    $decimals=$result['attributes']['raw_message']['ResGlobalInfo']['TotalCommissions']['CommissionPayableAmount']['decimal_places'];
                    }
                if (isset($result['attributes']['guarantee']['card_type'])) {

                        $paymentMethod=$result['attributes']['guarantee']['card_type'];
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
                $bookingAgency=BookingAgency::where('channex_channel_id', $channelId)->first();
                if ($bookingAgency) {
                    # code...
                }else{
                    $bookingAgency=BookingAgency::first();
                }
                    
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
                    
                    if ($paymentMethod) {
                        echo "payment method is available ";
                        $paymentMethods=PaymentMethod::where('channex_id', $paymentMethod)->where('hotel_settings_id', $bookingAgency->hotel_settings_id)->first();
                        if ($paymentMethods) {
                            $this->paymentMethodId=$paymentMethods->id;
                            $this->isCardType=$paymentMethods->is_card_type;
                        }else{
                            $paymentMethods=PaymentMethod::first();
                            $this->paymentMethodId=$paymentMethods->id;
                            $this->isCardType=$paymentMethods->is_card_type;
                        
                        }
                        
                    }else{
                        echo "payment method is absent";
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
                    echo "I am already in system ";
                    if ($this->statuss=="new") {
                        echo " do not add new bcz already in system";
                        # ...do nothing
                    }else if ($this->statuss=="cancelled") {
                        echo "cancelled already";
                        # ...... delete availability and room condition
                        foreach ($ifAlreadyExists as $reservation) {
                            Availability::where('reservation_id', $reservation->id)->delete();
                            RoomCondition::where('reservation_id', $reservation->id)->delete();
                            foreach ($rooms as $currentRoom) {
                                $totalRoomsForMail++;
                                $ratePlanId=$currentRoom['rate_plan_id'];
                                $parentratePlanId='';
                                
                                if (isset($currentRoom['meta']['parent_rate_plan_id'])) {

                                    $parentratePlanId=$currentRoom['meta']['parent_rate_plan_id'];
                                }
                                if ($parentratePlanId) {

                                    $ratePlanId=$parentratePlanId;
                                }
                                
                                $days=$currentRoom['days'];
                                $totalAdults+=$currentRoom['occupancy']['adults'];
                                $totalKids+=$currentRoom['occupancy']['children'];
                                $totalInfants+=$currentRoom['occupancy']['infants'];
                                echo " after adding adults etc";
                                
                                
                                $ratetype=RateType::where('channex_id', $ratePlanId)->first();
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
                                    echo "rate added ";
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
                            "existing multiroom";
                                Availability::where('reservation_id', $ifAlreadyExists->id)->delete();
                                DailyRate::where('reservation_id', $ifAlreadyExists->id)->delete();
                                ReservationDeposit::where('reservation_id', $ifAlreadyExists->id)->delete();
                                RoomCondition::where('reservation_id', $ifAlreadyExists->id)->delete();
                                foreach ($ifAlreadyExists as $reservation) {
                                    $starts=$reservation->arrival_date;
                                    while ($starts<$reservation->departure_date) {
                                        // add channel manager availability
                                        if ($reservation->room->room_type->type_status==0) {
                                            $availableRooms=0;
                                        }else{
                                            $occupiedRooms=Availability::has('room')->where('availabilities.room_type_id', $reservation->room->room_type_id)->where('rooms.status', 'Enabled')->where('date', $starts)->count();
                                            $availableRooms=$totalRooms-$occupiedRooms;
                                        }
                                        $innerdata=[
                                    
                                            "property_id"=> $this->propertyId,
                                            "room_type_id"=> $reservation->room->room_type->channex_room_type_id,
                                            "date"=> $starts,
                                            "availability"=> $availableRooms
                                            
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
                                        $parentratePlanId='';
                                        
                                        if (isset($currentRoom['meta']['parent_rate_plan_id'])) {

                                            $parentratePlanId=$currentRoom['meta']['parent_rate_plan_id'];
                                        }
                                        if ($parentratePlanId) {

                                            $ratePlanId=$parentratePlanId;
                                        }
                                        
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
                                        // $ratetype=$ratetype[0];
                                        // echo $ratetype->id;
                                        $this->hotel=HotelSetting::where('id', $ratetype->hotel_settings_id)->first();
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
                            echo "single room booking ";
                            $totalRoomsForMail=1;
                            $this->channexBookingRoomId=$rooms[0]['booking_room_id'];
                            $this->checkIn=$rooms[0]['checkin_date'];
                            $this->checkOut=$rooms[0]['checkout_date'];
                            $ratePlanId=$rooms[0]['rate_plan_id'];
                            $this->roomTypeId=$rooms[0]['room_type_id'];
                            $parentratePlanId='';
                            
                            if (isset($rooms[0]['meta']['parent_rate_plan_id'])) {

                                $parentratePlanId=$rooms[0]['meta']['parent_rate_plan_id'];
                            }
                            if ($parentratePlanId) {

                                $ratePlanId=$parentratePlanId;
                            }
                            
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
                            $this->hotel=HotelSetting::where('id', $ratetype->hotel_settings_id)->first();
                            $this->rateTypeId=$ratetype->id;
                            $ratetypeName=$ratetype->name;
                            $ratetypeCode=$ratetype->reference_code;
                            $roomtypeName=$ratetype->room_type->name;
                            // $roomtypeString="1 ". $roomtypeName;
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
                            // $roomtypeString="1 ".$roomtypeName;
                            $ifExistsWithSameDates=Reservation::join('rooms', 'rooms.id', 'reservations.room_id')->join('room_types', 'rooms.room_type_id', 'room_types.id')->join('rate_types', 'rate_types.id', 'reservations.rate_type_id')->where('booking_code', $this->otaReservationCode)->where('arrival_date', $this->checkIn)->where('departure_date', $this->checkOut)->where('channex_room_type_id', $this->roomTypeId)->where('channex_id', $ratePlanId)->get(['reservations.id', 'channex_cards'])->first();
                            // print_r($ifExistsWithSameDates);
                            if ($ifExistsWithSameDates) {
                                echo "update same dates";
                                DailyRate::where('reservation_id', $ifExistsWithSameDates->id)->delete();
                                echo "daily rate deleted";
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
                                // print_r($updateReservation);
                                $starts=$this->checkIn;
                                while ($starts<$this->checkOut) {
                                DailyRate::create([
                                    "date"=>$starts,
                                    "price"=>$this->days[$starts],
                                    "reservation_id"=>$ifExistsWithSameDates->id
                                ]);
                                echo "daily rate updated";
                                $starts=Carbon::parse($starts)->addDay()->toDateString();
                                }
                                if ($ifExistsWithSameDates->channex_cards!==$this->cardToken) {
                                    $deleteCardUrl=env("PCI_BASE")."/"."cards/".$ifExistsWithSameDates->channex_cards."?api_key=".config('services.channex.pci_api_key');
                                    $client=new Client();
                                    $client->delete($deleteCardUrl, ['headers'=>['user-api-key' => config('services.channex.api_key')]]);
                                }
                                
                                

                            }else{
                                echo "update different dates";
                                $ifAlreadyExists=$ifAlreadyExists->first();
                                Availability::where('reservation_id', $ifAlreadyExists->id)->delete();
                                DailyRate::where('reservation_id', $ifAlreadyExists->id)->delete();
                                ReservationDeposit::where('reservation_id', $ifAlreadyExists->id)->delete();
                                RoomCondition::where('reservation_id', $ifAlreadyExists->id)->delete();
                                echo " deleted availability ";
                                $starts=$ifAlreadyExists->arrival_date;
                                $totalRooms=Room::where('status', 'Enabled')->where('room_type_id',$ifAlreadyExists->room->room_type->id)->count();
                                while ($starts<$ifAlreadyExists->departure_date) {
                                     // add channel manager availability
                                    if ($ifAlreadyExists->room->room_type->type_status==0) {
                                        $availableRooms=0;
                                    }else{
                                        $occupiedRooms=Availability::join('rooms', 'rooms.id', '=', 'availabilities.room_id')->where('availabilities.room_type_id', $ifAlreadyExists->room->room_type_id)->where('rooms.status', 'Enabled')->where('date', $starts)->count();
                                        $availableRooms=$totalRooms-$occupiedRooms;
                                    }
                                    echo " available room ";
                                    $innerdata=[
                                
                                        "property_id"=> $this->propertyId,
                                        "room_type_id"=> $ifAlreadyExists->room->room_type->channex_room_type_id,
                                        "date"=> $starts,
                                        "availability"=> $availableRooms
                                        
                                        ];
                                        array_unshift($this->fulldata, $innerdata);

                                        $starts=Carbon::parse($starts)->addDay()->toDateString();
                                }
                                $this->updateReservation($ifAlreadyExists);

                            }
                        }
                    }
                }else{
                    echo " booking do not exists already ";
                                foreach ($rooms as $currentRoom) {
                                        $totalRoomsForMail++;
                                        $this->channexBookingRoomId=$currentRoom['booking_room_id'];
                                        $this->checkIn=$currentRoom['checkin_date'];
                                        $this->checkOut=$currentRoom['checkout_date'];
                                        $ratePlanId=$currentRoom['rate_plan_id'];
                                        $this->roomTypeId=$currentRoom['room_type_id'];
                                        $parentratePlanId='';
                                        
                                        if (isset($currentRoom['meta']['parent_rate_plan_id'])) {

                                            $parentratePlanId=$currentRoom['meta']['parent_rate_plan_id'];
                                        }
                                        if ($parentratePlanId) {

                                            $ratePlanId=$parentratePlanId;
                                        }
                                        
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
                                        // $ratetype=$ratetype[0];
                                        // echo $ratetype->id;
                                        $this->hotel=HotelSetting::where('id', $ratetype->hotel_settings_id)->first();
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
                                            echo "rate added ";
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
                    echo "email sent successfully to ".$this->hotel->notification_receiver_email;

                }
                // send availability to channex............
                $availData=["values"=>$this->fulldata];
                $client=new Client();
                $client->post($availabilityUrl, [
                    'headers' => ['Content-Type' => 'application/json', 'user-api-key' => config('services.channex.api_key')],
                    'body' => json_encode($availData),
                ]);
                // ack booking..........
                $client = new Client;

                $acknowledge=$client->post(config('services.channex.api_base') . "/"."booking_revisions/". $this->revisionId."/ack", [
                    'headers' => ['Content-Type' => 'application/json', 'user-api-key' => config('services.channex.api_key')],
                    
                ]);
                 

            } // end of foreach properties
            

        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function addNewReservation(){
        $checkIn=$this->checkIn;
        $checkOut=Carbon::parse($this->checkOut)->subDay()->toDateString();
        $roomTypeId=$this->roomTypeId;
            $getAvailableRoom=Room::join('room_types','rooms.room_type_id', '=', 'room_types.id')->selectRaw('rooms.id as id, rooms.room_type_id as room_type_id')->whereNotIn('rooms.id',function($query) use ($checkIn, $checkOut, $roomTypeId){
                $query->select('room_id')->from('availabilities')
                ->join('room_types', 'availabilities.room_type_id', 'room_types.id')
                ->whereBetween('availabilities.date', [$checkIn, $checkOut ])
                ->where('channex_room_type_id', $roomTypeId)->get();

            })->where('channex_room_type_id', $roomTypeId)->where('rooms.status', 'Enabled')->first();
            $bdate=Carbon::parse($this->bookingDate)->addDay()->setTime(0,0);
            $cdate=Carbon::parse($this->checkIn)->setTime(0,0);
            $daysdiff=(int)$cdate->diff($bdate)->format("%a")+1;
            if ($this->rateTypePrepayment>0) {
                $chargeDate=$this->bookingDate;
            }else{

                if ($this->firstChargePercentage>0) {

                if ($daysdiff>=$this->firstChargeDays) {
                    $chargeDate=date('Y-m-d', strtotime($this->checkIn.' - '.$this->firstChargeDays.' days'));
                }else{
                    $chargeDate=$this->bookingDate;
                }
                }else{

                if ($daysdiff>=$this->secondchargeDays) {
                        $chargeDate=date('Y-m-d', strtotime($this->checkIn.' - '.$this->secondchargeDays.' days'));
                }else{
                        $chargeDate=$this->bookingDate;
                }
                }
            }
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
                        "room_id"=>'',
                        "channex_cards"=>$this->cardToken,
                        "channex_booking_id"=>$this->bookingid,
                        "hotel_settings_id"=>$this->hotel->id
    
                    ]);
                }
    
                if ($this->statuss!='cancelled') {
                    echo " adding charge plan ";
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
                echo $th->getMessage();
                DB::rollback();
            }
            
            DB::commit();
    }

    public function addAvailability($room, $reservation, $checkin, $checkout){
        $getRoomCondition=RoomCondition::where('date', $checkin)->where('room_id', $room->id)->get();
        if ($getRoomCondition) {
            $wasDeparture="yes";
        }else{
            $wasDeparture="no";
        }
        $cleanDays=(int)$this->hotel->housekeeping;
        $countClean=1;
        $daycounter=0;

        $totalRooms=Room::where('status', 'Enabled')->where('room_type_id', $room->room_type->id)->count();
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

        // add channel manager availability
        if ($room->room_type->type_status==0) {
            $availableRooms=0;
        }else{
            $occupiedRooms=Availability::join('rooms', 'rooms.id', '=', 'availabilities.room_id')->where('availabilities.room_type_id', $room->room_type_id)->where('rooms.status', 'Enabled')->where('date', $checkin)->count();
            $availableRooms=$totalRooms-$occupiedRooms;
        }
        $innerdata=[
    
            "property_id"=> $this->propertyId,
            "room_type_id"=> $room->room_type->channex_room_type_id,
            "date"=> $checkin,
            "availability"=> $availableRooms
            
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

                        $sign='';
                        if ($this->chargeMode=="beforearrival") {
                            $sign='-';
                        }else if ($this->chargeMode=="afterarrival") {
                            $sign="+";
                        }else{
                            $sign='+';
                        }

                        $firstChargeDate=date('Y-m-d', strtotime($this->arrivalDate.' '.$sign.' '.$this->totalchargedays.' days'));
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
                    $datesdiff=$chrgDate->diffInDays($adate);
                    $daysbetween=$datesdiff;
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

                            $prepaymentDate=date('Y-m-d', strtotime($this->arrivalDate.' - '.$this->firstChargeDays.' days'));
                        }

                        if ($daysbetween>=$this->secondchargeDays && $daysbetween<$this->firstChargeDays) {

                            $secondCDate=date('Y-m-d', strtotime($this->arrivalDate.'- '.$this->secondchargeDays.' days'));
                            $prepaymentDate=$secondCDate;
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

                            $firstChargeDate=date('Y-m-d', strtotime($this->arrivalDate.' - '.$this->firstChargeDays.' days'));
                        }

                        if ($daysbetween>=$this->secondchargeDays && $daysbetween<$this->firstChargeDays) {

                            $firstChargeDate=date('Y-m-d', strtotime($this->arrivalDate.'- '.$this->secondchargeDays.' days'));
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

                            $secondChargeDate=date('Y-m-d', strtotime($this->arrivalDate.'- '.$this->secondchargeDays.' days'));
                        }

                        if ($daysbetween<$this->secondchargeDays) {

                            $secondChargeDate=$this->arrivalDate;
                        }
                    }
                    echo "adding reservation deposit ";
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
        $bdate=Carbon::parse($this->bookingDate)->addDay()->setTime(0,0);
        $cdate=Carbon::parse($this->checkIn)->setTime(0,0);
        $daysdiff=(int)$cdate->diff($bdate)->format("%a")+1;
        if ($this->rateTypePrepayment>0) {
            $chargeDate=$this->bookingDate;
        }else{

            if ($this->firstChargePercentage>0) {

            if ($daysdiff>=$this->firstChargeDays) {
                $chargeDate=date('Y-m-d', strtotime($this->checkIn.' - '.$this->firstChargeDays.' days'));
            }else{
                $chargeDate=$this->bookingDate;
            }
            }else{

            if ($daysdiff>=$this->secondchargeDays) {
                    $chargeDate=date('Y-m-d', strtotime($this->checkIn.' - '.$this->secondchargeDays.' days'));
            }else{
                    $chargeDate=$this->bookingDate;
            }
            }
        }
        DB::beginTransaction();
        try {
            
            $guest=Guest::where('id', $previosReservation->guest_id)->first();//->update([
                // print_r($guest);
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
    
            // ]);
            
           
            $getAvailableRoom=Room::join('room_types','rooms.room_type_id', '=', 'room_types.id')->selectRaw('rooms.id as id, rooms.room_type_id as room_type_id')->whereNotIn('rooms.id',function($query) use ($checkIn, $checkOut, $roomTypeId){
                $query->select('room_id')->from('availabilities')
                ->join('room_types', 'availabilities.room_type_id', 'room_types.id')
                ->whereBetween('availabilities.date', [$checkIn, $checkOut ])
                ->where('channex_room_type_id', $roomTypeId)->get();
    
            })->where('channex_room_type_id', $roomTypeId)->where('rooms.status', 'Enabled')->first();
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
                    "channex_cards"=>$this->cardToken,
                    "channex_booking_id"=>$this->bookingid,
                    "hotel_settings_id"=>$this->hotel->id
    
                ]);
            }
                if ($this->statuss!='cancelled') {
                    echo " add charge plan ";
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
        }

        DB::commit();
        
}



}

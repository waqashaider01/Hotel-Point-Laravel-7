<?php

namespace App\Http\Livewire\Finance\Budget;
use App\Models\HotelBudget;
use App\Models\DailyRate;
use App\Models\Document;
use App\Models\Description;
use App\Models\OpexData;
use App\Models\ReservationExtraCharge;
use Carbon\Carbon;

use Livewire\Component;

class HotelActual extends Component
{
    public $statistics;
    public $cxlFees;
    public $year;
    public $fbdept;
    public $formattedValue;
    public $breakfastPercentage;
    public $roomDeptData;
    public $oodData;
    public $opexData;

    public function mount(){
        $this->year=today()->year;
        
    }

    public function setyear($year){
        $this->year=$year;
        $this->dispatchBrowserEvent('contentChanged');
        
    }
   
    public function render()
    {
        // Statistics
        $operatingdayssum=0;
        $availableroomssum=0;
        $availroomnightssum=0;
        $occupyroomnightsum=0;
        $averageoccupancysum=0;
        $avgdroomratesum=0;
        $revparsum=0;
        $guestinhousesum=0;
        $doccfactorsum=0;
        $operatingdays=['Operating Days',0,0,0,0,0,0,0,0,0,0,0,0,0];
        $availablerooms=['Available Rooms',0,0,0,0,0,0,0,0,0,0,0,0,0];
        $occupyroomnight=['Occupied Room Nights'];
        $availroomnights=['Available Room Nights'];
        $averageoccupancy=['Average Occupancy %'];
        $avgdroomrate=['Average Daily Rate'];
        $revpar=['RevPar'];
        $guestinhouse=['Guest in House'];
        $doccfactor=['Double Occupancy Factor'];
        // ............Rooms Department Revenue.............
        $accomodationRevnueSum=0;
        $otherroomrevenuesum=0;
        $cxlfeesum=0;
        $accomodationrevenue=['Accommodation Revenue'];
        $otherroomrevenue=['Other Room Revenue'];
        $cxlfee=['CXL Fees %'];

        // ............F&B Department Revenue..............
        $foodrevenuesum=0;
        $breakfastrevenuesum=0;
        $servicesrevenuesum=0;
        $beveragerevenuesum=0;
        $foodrevenue=['Food Revenue'];
        $breakfastrevenue=['Breakfast'];
        $servicerevenue=['Services'];
        $beveragerevenue=['Beverage Revenue'];
        $breakfastPercentage=0;

        // ..........Other Operated Department.............
        $spaandtherapies=['Spa & Therapies'];
        $otherincome=['Other Income'];
        $telephoneAndFax=['Telephones and Fax'];
        $guestLaundryAndDryCleaning=['Guests Laundary and Dry Cleaning'];
        $guestsTransfers=['Guests Transfers'];
        $excursions=['Excursions'];
        $cigars=['Cigars'];
        $newspapersMegazines=['Newspapers/ Megazines'];
        $guestSundries=['Guests Sundries/ Sounenirs'];
        $rentalAndOtherRevenue=['Rentals & Other Revenue '];
        $spaandtherapiessum=0;
        $otherincomesum=0;
        $telephoneAndFaxSum=0;
        $guestLaundryAndDryCleaningSum=0;
        $guestsTransfersSum=0;
        $excursionsSum=0;
        $cigarsSum=0;
        $newspapersMegazinesSum=0;
        $guestSundriesSum=0;
        $rentalAndOtherRevenueSum=0;
        $miscellaneous=['Miscellaneous'];
        $miscellaneoussum=0;


        $getBudget=HotelBudget::where('hotel_settings_id',getHotelSettings()->id)->where('budget_year', $this->year)->where('type', 1)->whereIn('category', [1,2])->get();
        foreach ($getBudget as $budget) {
                if ($budget['category']==1) {
                    $operatingdays[1]=(int)$budget['january'];
                    $operatingdays[2]=(int)$budget['february'];
                    $operatingdays[3]=(int)$budget['march'];
                    $operatingdays[4]=(int)$budget['april'];
                    $operatingdays[5]=(int)$budget['may'];
                    $operatingdays[6]=(int)$budget['june'];
                    $operatingdays[7]=(int)$budget['july'];
                    $operatingdays[8]=(int)$budget['august'];
                    $operatingdays[9]=(int)$budget['september'];
                    $operatingdays[10]=(int)$budget['october'];
                    $operatingdays[11]=(int)$budget['november'];
                    $operatingdays[12]=(int)$budget['december'];
                    $totaldays=(int)$budget['january']+(int)$budget['february']+(int)$budget['march']+(int)$budget['april']+(int)$budget['may']+(int)$budget['june']+(int)$budget['july']+(int)$budget['august']+(int)$budget['september']+(int)$budget['october']+(int)$budget['november']+(int)$budget['december'];
                    $operatingdays[13]=(int)$totaldays;
                }elseif ($budget['category']==2) {
                    $availablerooms[1]=(int)$budget['january'];
                    $availablerooms[2]=(int)$budget['february'];
                    $availablerooms[3]=(int)$budget['march'];
                    $availablerooms[4]=(int)$budget['april'];
                    $availablerooms[5]=(int)$budget['may'];
                    $availablerooms[6]=(int)$budget['june'];
                    $availablerooms[7]=(int)$budget['july'];
                    $availablerooms[8]=(int)$budget['august'];
                    $availablerooms[9]=(int)$budget['september'];
                    $availablerooms[10]=(int)$budget['october'];
                    $availablerooms[11]=(int)$budget['november'];
                    $availablerooms[12]=(int)$budget['december'];
                    $totaldays=max((int)$budget['january'],(int)$budget['february'],(int)$budget['march'], (int)$budget['april'], (int)$budget['may'], (int)$budget['june'], (int)$budget['july'], (int)$budget['august'], (int)$budget['september'], (int)$budget['october'], (int)$budget['november'], (int)$budget['december']);
                    $availablerooms[13]=(int)$totaldays;
                }else{}
        }
        for ($i=1; $i <=12 ; $i++) { 
            $monthStart=Carbon::parse($this->year."-".$i."-01")->toDateString();
            $monthEnd=Carbon::parse($monthStart)->endOfMonth()->toDateString();
            // ..........available room nights...........
            $availableRoomnights=0;
            if ($operatingdays[$i]==0 || $availablerooms[$i]==0) {
                $availableRoomnights=0;
            }else{

                $availableRoomnights=(int)$operatingdays[$i]*(int)$availablerooms[$i];
            }
            array_push($availroomnights, $availableRoomnights);
            $availroomnightssum+=(int)$availableRoomnights;

            $thisMonthAverageDailyRates=0;
            $thisMonthDailyRates=0;
            $thisMonthoccupiedroomNights=0;
            $thisMonthGuestinHouse=0;
            $thisMonthBreakfastRevenue=0;
            $getDailyRate=DailyRate::join('reservations', 'reservations.id', '=', 'daily_rates.reservation_id')
                                     ->join('rooms', 'reservations.room_id', '=', 'rooms.id')
                                     ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
                                     ->join('rate_types', 'reservations.rate_type_id', '=', 'rate_types.id')
                                     ->join('rate_type_categories', 'rate_types.rate_type_category_id', '=', 'rate_type_categories.id')
                                     ->whereBetween('daily_rates.date', [$monthStart, $monthEnd])
                                     ->where(function($query){
                                        $query->where('reservations.status','!=', 'Cancelled')
                                              ->orWhere('channex_status', 'NOT LIKE', 'cancel%');
                                     })
                                     ->where('reservations.hotel_settings_id',getHotelSettings()->id)
                                     ->where('room_types.type_status', 1)
                                     ->where('rooms.status', 'Enabled')->get(['rate_types.charge_percentage', 'charge_type', 'has_breakfast','price','daily_rates.date', 'arrival_date', 'reservations.status', 'no_show_charge_percentage', 'adults', 'kids', 'infants']);
            foreach ($getDailyRate as $rate) {
                if ($rate['date']<=today()->toDateString()) {
                    if ($rate['date']<$rate['arrival_date']) {
                        $noshowRate=((float)$rate['price']*(float)$rate['no_show_charge_percentage'])/100;
                        $thisMonthDailyRates+=number_format((float)$noshowRate, 2, '.', '');
                    }elseif ($rate['status']=="Arrived" || $rate['status']=="CheckedOut") {
                        $thisMonthDailyRates+=(float)$rate['price'];
                        $totalguest=(int)$rate['adults']+(int)$rate['kids']+(int)$rate['infants'];
                        $thisMonthoccupiedroomNights++;
                        $occupyroomnightsum++;
                        $thisMonthGuestinHouse+=$totalguest;
                        $guestinhousesum+=$totalguest;
                        if ($rate['has_breakfast']==1) {
                            if ($rate['charge_type']==0) {
                                $grossPercent=1.00+($rate['charge_percentage']/100);
                                $grossValue=(float)$rate['price']/(float)$grossPercent;
                                $reservationBreakfast=$rate['rate']-$grossValue;
                            }else{
                                $reservationBreakfast=$rate['charge_percentage'];
                            }
                            $thisMonthBreakfastRevenue+=number_format((float)$reservationBreakfast, 2, '.', '');
                        }
                    }else{}
                }else {
                    if ($rate['status']!='Cancelled') {
                        $thisMonthDailyRates+=(float)$rate['price'];
                        $totalguest=(int)$rate['adults']+(int)$rate['kids']+(int)$rate['infants'];
                        $thisMonthoccupiedroomNights++;
                        $occupyroomnightsum++;
                        $thisMonthGuestinHouse+=$totalguest;
                        $guestinhousesum+=$totalguest;
                        if ($rate['has_breakfast']==1) {
                            if ($rate['charge_type']==0) {
                                $grossPercent=1.00+($rate['charge_percentage']/100);
                                $grossValue=(float)$rate['price']/(float)$grossPercent;
                                $reservationBreakfast=$rate['rate']-$grossValue;
                            }else{
                                $reservationBreakfast=$rate['charge_percentage'];
                            }
                            $thisMonthBreakfastRevenue+=number_format((float)$reservationBreakfast, 2, '.', '');
                        }
                    }
                }
            }
            
            if ($thisMonthDailyRates==0 || $thisMonthoccupiedroomNights==0) {
                $thisMonthAverageDailyRates=0;
            }else{
                $thisMonthAverageDailyRates=(float)$thisMonthDailyRates/(int)$thisMonthoccupiedroomNights;
            }
            $thisMonthAverageDailyRates=number_format((float)$thisMonthAverageDailyRates, 2, '.', '');
            array_push($avgdroomrate, $thisMonthAverageDailyRates);
            $avgdroomratesum+=$thisMonthAverageDailyRates;
            // occupied room nights
            array_push($occupyroomnight, $thisMonthoccupiedroomNights);
            // guest in house
            array_push($guestinhouse, $thisMonthGuestinHouse);
            // average occupancy
            $monthOccupancy=0;
            if ($thisMonthoccupiedroomNights==0 || $availableRoomnights==0) {
                $monthOccupancy=0;
            }else{
                $monthOccupancy=((int)$thisMonthoccupiedroomNights/(int)$availableRoomnights)*100;
            }
            $monthOccupancy=number_format((float)$monthOccupancy, 2, '.', '');
            array_push($averageoccupancy, $monthOccupancy);
            $averageoccupancysum+=$monthOccupancy;
            // revpar
            if ($availableRoomnights==0 || $thisMonthDailyRates==0) {
                $monthRevpar=0;
            }else{
                $monthRevpar=(float)$thisMonthDailyRates/(int)$availableRoomnights;
            }
            $monthRevpar=number_format((float)$monthRevpar, 2, '.', '');
            array_push($revpar, $monthRevpar);
            $revparsum+=$monthRevpar;
            // dof
            if ($thisMonthGuestinHouse==0 || $thisMonthoccupiedroomNights==0) {
                $dof=0;
            }else{
                $dof=(int)$thisMonthGuestinHouse/(int)$thisMonthGuestinHouse;
            }
            $dof=number_format((float)$dof, 2, '.', '');
            array_push($doccfactor, $dof);
            $doccfactorsum+=$dof;
            // accommodation revenue
            $thisMonthDailyRates=number_format((float)$thisMonthDailyRates, 2, '.', '');
            array_push($accomodationrevenue,  $thisMonthDailyRates);
            $accomodationRevnueSum+=$thisMonthDailyRates;
            // breakfast revenue
            array_push($breakfastrevenue, number_format((float)$thisMonthBreakfastRevenue, 2, '.', '') );
            $breakfastrevenuesum+=$thisMonthBreakfastRevenue;
            // other room revenue
            $thisMonthOtherRoomRevenue=Document::join('document_types', 'document_types.id', '=', 'documents.document_type_id')
                                                 ->join('activities', 'activities.document_id', '=', 'documents.id')
                                                 ->join('reservations', 'reservations.id', '=', 'activities.reservation_id')
                                                 ->whereIn('document_types.id', [1,4])
                                                 ->where('activities.description', 'Cancellation Fees')
                                                 ->where('reservations.status', 'Cancelled')
                                                 ->where('documents.hotel_settings_id',getHotelSettings()->id)
                                                 ->whereBetween('documents.print_date', [$monthStart, $monthEnd])
                                                 ->sum('total');
            $thisMonthOtherRoomRevenue=number_format((float)$thisMonthOtherRoomRevenue, 2, '.', '');
            array_push($otherroomrevenue, $thisMonthOtherRoomRevenue);
            $otherroomrevenuesum+=$thisMonthOtherRoomRevenue;
            // cxl fee
            $thisMonthCXL=0;
            if ($thisMonthDailyRates==0 || $thisMonthOtherRoomRevenue==0) {
                $thisMonthCXL=0;
            }else{
                $thisMonthCXL=((float)$thisMonthOtherRoomRevenue/(float)$thisMonthDailyRates)*100;
            }
            $thisMonthCXL=number_format((float)$thisMonthCXL, 2, '.', '');
            array_push($cxlfee, $thisMonthCXL);
            $cxlfeesum+=$thisMonthCXL;
            // .........All service types revenue.........
            $thisMonthServicerevenue=0;
            $thisMonthBeveragerevenue=0;
            $thisMonthSparevenue=0;
            $thisMonthOtherincome=0;
            $thisMonthtelephoneAndFax=0;
            $thisMonthguestLaundryAndDryCleaning=0;
            $thisMonthguestsTransfers=0;
            $thisMonthexcursions=0;
            $thisMonthcigars=0;
            $thisMonthnewspapersMegazines=0;
            $thisMonthguestSundries=0;
            $thisMonthrentalAndOtherRevenue=0;
            $thisMonthMiscellaneous=0;
            $getServiceRevenue=ReservationExtraCharge::join('extra_charges', 'extra_charges.id', '=', 'reservation_extra_charges.extra_charge_id')
                                                       ->join('extra_charges_types', 'extra_charges_types.id', '=', 'extra_charges.extra_charge_type_id')
                                                       ->join('reservations', 'reservations.id', '=', 'reservation_extra_charges.reservation_id')
                                                       ->join('rooms', 'rooms.id', '=', 'reservations.room_id')
                                                       ->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
                                                       ->where('reservations.hotel_settings_id',getHotelSettings()->id)
                                                       ->whereBetween('reservation_extra_charges.date', [$monthStart, $monthEnd])
                                                       ->get(['extra_charges_types.id', 'extra_charge_total', 'extra_charges.product']);
            foreach ($getServiceRevenue as $service) {
                $chargetypeId=$service['id'];
                $chargeTotal=$service['extra_charge_total'];
                if ($chargetypeId==1) {
                    $thisMonthServicerevenue+=(float)$chargeTotal;
                    $servicesrevenuesum+=(float)$chargeTotal;
                }elseif ($chargetypeId==2) {
                    $thisMonthBeveragerevenue+=(float)$chargeTotal;
                    $beveragerevenuesum+=(float)$chargeTotal;
                }elseif ($chargetypeId==3) {
                    $thisMonthSparevenue+=(float)$chargeTotal;
                    $spaandtherapiessum+=(float)$chargeTotal;
                }elseif ($chargetypeId==4) {
                    $thisMonthOtherincome+=(float)$chargeTotal;
                    $otherincomesum+=(float)$chargeTotal;
                    $product=$service['product'];
                    if ($product=="Telephones and Fax") {
                        $thisMonthtelephoneAndFax+=(float)$chargeTotal;
                        $telephoneAndFaxSum+=(float)$chargeTotal;
                    }
                    if ($product=="Guests Laundary and Dry Cleaning") {
                        $thisMonthguestLaundryAndDryCleaning+=(float)$chargeTotal;
                        $guestLaundryAndDryCleaningSum+=(float)$chargeTotal;
                    }
                    if ($product=="Guests Transfers") {
                        $thisMonthguestsTransfers+=(float)$chargeTotal;
                        $guestsTransfersSum+=(float)$chargeTotal;
                    }
                    if ($product=="Excursions") {
                        $thisMonthexcursions+=(float)$chargeTotal;
                        $excursionsSum+=(float)$chargeTotal;
                    }
                    if ($product=="Cigars") {
                        $thisMonthcigars+=(float)$chargeTotal;
                        $cigarsSum+=(float)$chargeTotal;
                    }
                    if ($product=="Newspapers/Megazines") {
                        $thisMonthnewspapersMegazines+=(float)$chargeTotal;
                        $newspapersMegazinesSum+=(float)$chargeTotal;
                    }
                    if ($product=="Guests Sundries/Sounenirs") {
                        $thisMonthguestSundries+=(float)$chargeTotal;
                        $guestSundriesSum+=(float)$chargeTotal;
                    }
                    if ($product=="Rentals & Other Revenue") {
                        $thisMonthrentalAndOtherRevenue+=(float)$chargeTotal;
                        $rentalAndOtherRevenueSum+=(float)$chargeTotal;
                    }
                }elseif ($chargetypeId=='5') {
                    $thisMonthMiscellaneous+=(float)$chargeTotal;
                    $miscellaneoussum+=(float)$chargeTotal;
                }
                
            }
            // service revenue
            array_push($servicerevenue, number_format((float)$thisMonthServicerevenue, 2, '.', '') );
            // food revenue
            $thisMonthFoodrevenue=(float)$thisMonthBreakfastRevenue+(float)$thisMonthServicerevenue;
            $foodrevenuesum+=(float)$thisMonthFoodrevenue;
            array_push($foodrevenue, number_format((float)$thisMonthFoodrevenue, 2, '.', '') );
            // breakfast percentage
            if ($thisMonthBreakfastRevenue==0 || $thisMonthFoodrevenue==0) {
                $thisMonthBreakfastPercentage=0;
            }else{
                $thisMonthBreakfastPercentage=((float)$thisMonthBreakfastRevenue/(float)$thisMonthFoodrevenue)*100;
            }
            $thisMonthBreakfastPercentage=number_format((float)$thisMonthBreakfastPercentage, 2, '.', '');
		    $breakfastPercentage+=(float)$thisMonthBreakfastPercentage;
		    
            //'beverage revenue
            array_push($beveragerevenue, number_format((float)$thisMonthBeveragerevenue, 2, '.', '') );
            // spa revenue
            array_push($spaandtherapies, number_format((float)$thisMonthSparevenue, 2, '.', '')  );
            // miscellaneous
            array_push($miscellaneous, number_format((float)$thisMonthMiscellaneous, 2, '.', '')  );
            // other income
            array_push($otherincome, number_format((float)$thisMonthOtherincome, 2, '.', '')  );
            array_push($telephoneAndFax, number_format((float)$thisMonthtelephoneAndFax, 2, '.', '')  );
            array_push($guestLaundryAndDryCleaning, number_format((float)$thisMonthguestLaundryAndDryCleaning, 2, '.', '')  );
            array_push($guestsTransfers, number_format((float)$thisMonthguestsTransfers, 2, '.', '')  );
            array_push($excursions, number_format((float)$thisMonthexcursions, 2, '.', '')  );
            array_push($cigars, number_format((float)$thisMonthcigars, 2, '.', '')  );
            array_push($newspapersMegazines, number_format((float)$thisMonthnewspapersMegazines, 2, '.', '')  );
            array_push($guestSundries, number_format((float)$thisMonthguestSundries, 2, '.', '')  );
            array_push($rentalAndOtherRevenue, number_format((float)$thisMonthrentalAndOtherRevenue, 2, '.', '')  );
            
            
        }
        $avgdroomratesum= number_format((float)$avgdroomratesum/12 , 2, '.', '');
        array_push($avgdroomrate, $avgdroomratesum);
        $doccfactorsum=number_format((float)$doccfactorsum/12, 2, '.', '');
        array_push($doccfactor, $doccfactorsum);
        $averageoccupancysum=number_format((float)$averageoccupancysum/12, 2, '.', '');
        array_push($averageoccupancy, $averageoccupancysum);
        $revparsum=number_format((float)$revparsum/12, 2, '.', '');
        array_push($revpar, $revparsum);
        array_push($occupyroomnight, $occupyroomnightsum);
        array_push($availroomnights, $availroomnightssum);
        array_push($guestinhouse, $guestinhousesum);

        $cxlfeesum=number_format((float)$cxlfeesum/12, 2, '.', '');
        array_push($cxlfee, $cxlfeesum);
        $breakfastPercentage=number_format((float)$breakfastPercentage/12, 2, '.', '');
        array_push($accomodationrevenue, number_format((float)$accomodationRevnueSum, 2, '.', '') );
        array_push($otherroomrevenue, number_format((float)$otherroomrevenuesum, 2, '.', '') );
        array_push($breakfastrevenue, number_format((float)$breakfastrevenuesum, 2, '.', '') );
        array_push($servicerevenue, number_format((float)$servicesrevenuesum, 2, '.', ''));
        array_push($foodrevenue, number_format((float)$foodrevenuesum, 2, '.', ''));
        array_push($beveragerevenue, number_format((float)$beveragerevenuesum, 2, '.', ''));
        array_push($otherincome, number_format((float)$otherincomesum, 2, '.', ''));
        array_push($spaandtherapies, number_format((float)$spaandtherapiessum, 2, '.', ''));
        array_push($miscellaneous, number_format((float)$miscellaneoussum, 2, '.', ''));
        array_push($telephoneAndFax, number_format((float)$telephoneAndFaxSum, 2, '.', ''));
        array_push($guestLaundryAndDryCleaning, number_format((float)$guestLaundryAndDryCleaningSum, 2, '.', ''));
        array_push($guestsTransfers, number_format((float)$guestsTransfersSum, 2, '.', ''));
        array_push($excursions, number_format((float)$excursionsSum, 2, '.', ''));
        array_push($cigars, number_format((float)$cigarsSum, 2, '.', ''));
        array_push($newspapersMegazines, number_format((float)$newspapersMegazinesSum, 2, '.', ''));
        array_push($guestSundries, number_format((float)$guestSundriesSum, 2, '.', ''));
        array_push($rentalAndOtherRevenue, number_format((float)$rentalAndOtherRevenueSum, 2, '.', ''));

        // opex
        $opexTypes=['', 'R & D', 'F & B', 'OOD', 'A & G', 'S & M', 'R & M', 'Management Fee', 'Non Operating Expenses', 'Management Fee' ];
        $cos=[];
    for ($i=9; $i >=1 ; $i--) { 
        $subcatJanuary=0;
        $subcatFebruary=0;
        $subcatMarch=0;
        $subcatApril=0;
        $subcatMay=0;
        $subcatJune=0;
        $subcatJuly=0;
        $subcatAugust=0;
        $subcatSeptember=0;
        $subcatOctober=0;
        $subcatNovember=0;
        $subcatDecember=0;
        $subcatTotal=0;
        $subcategories=Description::join('categories', 'descriptions.category_id', '=', 'categories.id')->join('cost_of_sales', 'cost_of_sales.id', '=', 'categories.cost_of_sale_id')->where('cost_of_sale_id', $i)->orderBy('descriptions.id')->get(['descriptions.id', 'descriptions.name']);
        foreach ($subcategories as $row) {
            $january=0;
            $february=0;
            $march=0;
            $april=0;
            $may=0;
            $june=0;
            $july=0;
            $august=0;
            $september=0;
            $october=0;
            $november=0;
            $december=0;
            $total=0;
            for ($month=1; $month <=12 ; $month++) { 
                $startDate=Carbon::parse($this->year."-".$month."-01")->toDateString();
                $endDate=Carbon::parse($startDate)->endOfMonth()->toDateString();
                $getopexBudget=OpexData::where('hotel_settings_id',getHotelSettings()->id)->where('description_id', $row->id)->whereBetween('date', [$startDate, $endDate])->sum('amount');
                $getopexBudget=number_format((float)$getopexBudget, 2, '.', '');
                if ($month==1) {
                    $january=$getopexBudget;
                    $subcatJanuary+=(float)$january;
                }elseif ($month==2) {
                    $february=$getopexBudget;
                    $subcatFebruary+=(float)$getopexBudget;
                }elseif ($month==3) {
                    $march=$getopexBudget;
                    $subcatMarch+=(float)$getopexBudget;
                }elseif ($month==4) {
                    $april=$getopexBudget;
                    $subcatApril+=(float)$getopexBudget;
                }elseif ($month==5) {
                    $may=$getopexBudget;
                    $subcatMay+=(float)$getopexBudget;
                }elseif ($month==6) {
                    $june=$getopexBudget;
                    $subcatJune+=(float)$getopexBudget;
                }elseif ($month==7) {
                    $july=$getopexBudget;
                    $subcatJuly+=(float)$getopexBudget;
                }elseif ($month==8) {
                    $august=$getopexBudget;
                    $subcatAugust+=(float)$getopexBudget;
                }elseif ($month==9) {
                    $september=$getopexBudget;
                    $subcatSeptember+=(float)$getopexBudget;
                }elseif ($month==10) {
                    $october=$getopexBudget;
                    $subcatOctober+=(float)$getopexBudget;
                }elseif ($month==11) {
                    $november=$getopexBudget;
                    $subcatNovember+=(float)$getopexBudget;
                }elseif ($month==12) {
                    $december=$getopexBudget;
                    $subcatDecember+=(float)$getopexBudget;
                }else{}
            }
            $total=(float)$january+(float)$february+(float)$march+(float)$april+(float)$may+(float)$june+(float)$july+(float)$august+(float)$september+(float)$october+(float)$november+(float)$december;
            $total=number_format((float)$total, 2, '.', '');
            $subcatTotal+=(float)$total;
            
             array_unshift($cos, array("name"=>$row->name, "class"=>"opex".$i, "january"=>$january, "february"=>$february, "march"=>$march, "april"=>$april, "may"=>$may, "june"=>$june, "july"=>$july, "august"=>$august, "september"=>$september, "october"=>$october, "november"=>$november, "december"=>$december, "total"=>$total));

        }
        array_unshift($cos, array("class"=>"mainType", "name"=>$opexTypes[$i], "id"=>"opex".$i, "january"=>number_format((float)$subcatJanuary, 2, '.', ''), "february"=>number_format((float)$subcatFebruary, 2, '.', ''), "march"=>number_format((float)$subcatMarch, 2, '.', ''), "april"=>number_format((float)$subcatApril, 2, '.', ''), "may"=>number_format((float)$subcatMay, 2, '.', ''), "june"=>number_format((float)$subcatJune, 2, '.', ''), "july"=>number_format((float)$subcatJuly, 2, '.', ''), "august"=>number_format((float)$subcatAugust, 2, '.', ''), "september"=>number_format((float)$subcatSeptember, 2, '.', ''), "october"=>number_format((float)$subcatOctober, 2, '.', ''), "november"=>number_format((float)$subcatNovember, 2, '.', ''), "december"=>number_format((float)$subcatDecember, 2, '.', ''), "total"=>number_format((float)$subcatTotal, 2, '.', '')));


    }


        $this->statistics=[$operatingdays, $availablerooms, $availroomnights, $occupyroomnight, $averageoccupancy, $avgdroomrate, $revpar, $guestinhouse, $doccfactor];
        $this->roomDeptData=[$accomodationrevenue, $otherroomrevenue, $cxlfee];
        $this->fbdept=[$foodrevenue, $breakfastrevenue, $servicerevenue, $beveragerevenue];
        $this->breakfastPercentage=$breakfastPercentage;
        $this->oodData=[$spaandtherapies, $otherincome, $telephoneAndFax, $guestLaundryAndDryCleaning, $guestsTransfers, $excursions, $cigars, $newspapersMegazines, $guestSundries, $rentalAndOtherRevenue, $miscellaneous];
        $this->opexData=$cos;

        return view('livewire.finance.budget.hotel-actual');
    }
}

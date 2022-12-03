<?php

namespace App\Http\Livewire\Finance\Budget;
use App\Models\HotelBudget;
use App\Models\Description;
use App\Models\BreakfastPercentage;
use App\Models\ExReservation;
use Illuminate\Support\Collection;
use Carbon\Carbon;



use Livewire\Component;

class HotelMain extends Component
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
    protected $listeners=['setyear'=>'setYear'];
    
    public function mount(){
        $this->year=today()->year;
        
    }
    public function render()
    {
        $this->computeBudget();
        $this->dispatchBrowserEvent('contentChanged');
        return view('livewire.finance.budget.hotel-main');
    }

    public function formatValue($value){
        return showPriceWithCurrency($value);
       
        
    }

    public function setyears($year){
        $this->year=$year;
    }

    public function setYear(){
        $this->year=$this->year;
    }

    public function setBreakfastPercentage($percentage){
           BreakfastPercentage::updateOrCreate([
            'year'=>$this->year,
            'value'=>$percentage,
            'hotel_settings_id'=>getHotelSettings()->id
           ],[
            'year'=>$this->year,
            'hotel_settings_id'=>getHotelSettings()->id
           ]);

           $this->breakfastPercentage=$percentage;
    }

    public function formatFloatValues($value){
        return number_format((float)$value, 2, '.', '');
    }

    public function calculateExValues($start, $end, $i, $j){
        $nights=0;
        $totalGuests=0;
        $amount=0;
        $getExData=ExReservation::where(function($query) use($start, $end){
                                    $query->whereBetween('check_in', [$start, $end])
                                        ->orWhereBetween('check_out', [$start, $end]);
                              })
                              ->where('hotel_settings_id',getHotelSettings()->id)
                              ->get();
        foreach ($getExData as $row) {
            $cnight=0;
            $monthValue=0;
            $startDate=$row['check_in'];
            $endDate=$row['check_out'];
            $guest=$row['guests'];
            $amount=$row['total_amount'];
            if ($startDate<$start && $endDate<=$end ) {
                $startDate=$start;
            }
            if ($endDate>$end && $startDate>=$start) {
                $endDate=Carbon::parse($start)->addMonth()->toDateString();
            }
            while ($startDate<$endDate) {
                 $cnight++;
                 $nights++;
                 $startDate=Carbon::parse($startDate)->addDay()->toDateString();
            }
            $guest=(int)$cnight*(int)$guest;
            $totalGuests+=$guest;
        }
        if ($i==1 && $j==3) {
            $monthValue=$nights;
        }else if ($i==1 && $j==5) {
            if ($totalGuests==0 || $nights==0) {
                $monthValue=0;
            }else{
                $dof=(int)$totalGuests/(int)$nights;
                $monthValue=number_format((float)$dof, 2, '.', '');
            }

        }else if ($i==1 && $j==4) {
            if ($amount==0 || $nights==0) {
                $monthValue=0;
            }else{
                $adr=(float)$amount/(int)$nights;
                $monthValue=number_format((float)$adr, 2, '.', '');
            }
        }else{

        }
        return $monthValue;

    }

    public function computeBudget(){
        $getPercentage=BreakfastPercentage::where('hotel_settings_id',getHotelSettings()->id)->where('year', $this->year)->get();
        if ($getPercentage->isEmpty()) {
            $this->breakfastPercentage=0;
        }else{
            $this->breakfastPercentage=$getPercentage[0]->value;
        }
        
        $types=4;
        $category=0;
        $alldata=[];
        $statisticData=[];
        $roomDeptData=[];
        $fbData=[];
        $otherData=[];
        $cos=[];
        $operatingDays=[];
        $availableRooms=[];
        $OccupiedRoomNights=[];
        $adr=[];
        $dof=[];
        $cxl=[];
        $services=[];

        
        for ($i=1; $i <=$types ; $i++) { 

            if ($i==1) {
                $category=5;
            }else if ($i==2) {
                $category=1;
            }else if ($i==3) {
                $category=2;
            }else if ($i==4) {
                $category=10;
            }else if ($i==5) {
                $category=9;
            }else{}
                   $oijanuary=0;
                   $oifebruary=0;
                   $oimarch=0;
                   $oiapril=0;
                   $oimay=0;
                   $oijune=0;
                   $oijuly=0;
                   $oiaugust=0;
                   $oiseptember=0;
                   $oioctober=0;
                   $oinovember=0;
                   $oidecember=0;
                   $oitotal=0;
        
            for ($j=1; $j <=$category ; $j++) { 
        
                   $subcategory=0;
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
        
        
                   if ($subcategory==0) {
                    $getData=HotelBudget::where('hotel_settings_id',getHotelSettings()->id)->where('type', $i)->where('category',$j)->where('budget_year', $this->year)->get();
                    
                    if ($getData->isEmpty()) {
                        
                    }else{
                        $getData=$getData[0];
                        $january=$getData['january'];
                        $february=$getData['february'];
                        $march=$getData['march'];
                        $april=$getData['april'];
                        $may=$getData['may'];
                        $june=$getData['june'];
                        $july=$getData['july'];
                        $august=$getData['august'];
                        $september=$getData['september'];
                        $october=$getData['october'];
                        $november=$getData['november'];
                        $december=$getData['december'];
                    }
                    if ($i==1 && ($j==3 || $j==4 || $j==5)) {
                        if ($january=="" || $january==0) {
                            $start=$this->year."-01-01";
                            $end=Carbon::parse($start)->endOfMonth()->toDateString();
                            $january=$this->calculateExValues($start, $end, $i, $j);
                        }
                        if ($february=="" || $february==0) {
                            $start=$this->year."-02-01";
                            $end=Carbon::parse($start)->endOfMonth()->toDateString();
                            $february=$this->calculateExValues($start, $end, $i, $j);
                        }
                        if ($march=="" || $march==0) {
                            $start=$this->year."-03-01";
                            $end=Carbon::parse($start)->endOfMonth()->toDateString();
                            $march=$this->calculateExValues($start, $end, $i, $j);
                        }
                        if ($april=="" || $april==0) {
                            $start=$this->year."-04-01";
                            $end=Carbon::parse($start)->endOfMonth()->toDateString();
                            $april=$this->calculateExValues($start, $end, $i, $j);
                        }
                        if ($may=="" || $may==0) {
                            $start=$this->year."-05-01";
                            $end=Carbon::parse($start)->endOfMonth()->toDateString();
                            $may=$this->calculateExValues($start, $end, $i, $j);
                        }
                        if ($june=="" || $june==0) {
                            $start=$this->year."-06-01";
                            $end=Carbon::parse($start)->endOfMonth()->toDateString();
                            $june=$this->calculateExValues($start, $end, $i, $j);
                        }
                        if ($july=="" || $july==0) {
                            $start=$this->year."-07-01";
                            $end=Carbon::parse($start)->endOfMonth()->toDateString();
                            $july=$this->calculateExValues($start, $end, $i, $j);
                        }
                        if ($august=="" || $august==0) {
                            $start=$this->year."-08-01";
                            $end=Carbon::parse($start)->endOfMonth()->toDateString();
                            $august=$this->calculateExValues($start, $end, $i, $j);
                        }
                        if ($september=="" || $september==0) {
                            $start=$this->year."-09-01";
                            $end=Carbon::parse($start)->endOfMonth()->toDateString();
                            $september=$this->calculateExValues($start, $end, $i, $j);
                        }
                        if ($october=="" || $october==0) {
                            $start=$this->year."-10-01";
                            $end=Carbon::parse($start)->endOfMonth()->toDateString();
                            $october=$this->calculateExValues($start, $end, $i, $j);
                        }
                        if ($november=="" || $november==0) {
                            $start=$this->year."-11-01";
                            $end=Carbon::parse($start)->endOfMonth()->toDateString();
                            $november=$this->calculateExValues($start, $end, $i, $j);
                        }
                        if ($december=="" || $december==0) {
                            $start=$this->year."-12-01";
                            $end=Carbon::parse($start)->endOfMonth()->toDateString();
                            $december=$this->calculateExValues($start, $end, $i, $j);
                        }
                    }
                    

                    $total=(float)$january+(float)$february+(float)$march+(float)$april+(float)$may+(float)$june+(float)$july+(float)$august+(float)$september+(float)$october+(float)$november+(float)$december;
                    $rowid=$i.$j.$subcategory;
                    if ($i==1 && $j==1) {
                        $operatingDays=[$january, $february, $march, $april, $may, $june, $july, $august, $september, $october, $november, $december];
                     }elseif ($i==1 && $j==2) {
                        $availableRooms=[$january, $february, $march, $april, $may, $june, $july, $august, $september, $october, $november, $december];
                     }elseif ($i==1 && $j==3) {
                        $OccupiedRoomNights=[$january, $february, $march, $april, $may, $june, $july, $august, $september, $october, $november, $december];
                     }elseif ($i==1 && $j==4) {
                        $adr=[$january, $february, $march, $april, $may, $june, $july, $august, $september, $october, $november, $december];
                     }elseif ($i==1 && $j==5) {
                        $dof=[$january, $february, $march, $april, $may, $june, $july, $august, $september, $october, $november, $december];
                     }elseif ($i==2 && $j==1) {
                        $cxl=[$january, $february, $march, $april, $may, $june, $july, $august, $september, $october, $november, $december];
                     }elseif ($i==3 && $j==1) {
                        $services=[$january, $february, $march, $april, $may, $june, $july, $august, $september, $october, $november, $december];
                     }else{}

                    if ($i==1) {
                        if ($j==4 || $j==5) {
                            if ($total==0) {
                                $total=number_format((float)$total, 2, '.', '');
                            }else{
                                $total=number_format((float)$total/12, 2, '.', '');

                            }
                            
                        }else if($j==2){
                            $total=max($availableRooms);
                        }else{}
                        array_push($statisticData, array("type"=>$i, "catg"=>$j, "subcatg"=>0, "rowid"=>$rowid, "january"=>$january, "february"=>$february, "march"=>$march, "april"=>$april, "may"=>$may, "june"=>$june, "july"=>$july, "august"=>$august, "september"=>$september, "october"=>$october, "november"=>$november, "december"=>$december, "total"=>$total));

                    }elseif($i==2){
                        array_unshift($roomDeptData, array("type"=>$i, "catg"=>$j, "subcatg"=>0, "rowid"=>$rowid, "january"=>$january, "february"=>$february, "march"=>$march, "april"=>$april, "may"=>$may, "june"=>$june, "july"=>$july, "august"=>$august, "september"=>$september, "october"=>$october, "november"=>$november, "december"=>$december, "total"=>$total));

                    }elseif ($i==3) {
                        if ($j==1) {
                            array_unshift($fbData, array("type"=>$i, "catg"=>$j, "subcatg"=>0, "rowid"=>$rowid, "january"=>$january, "february"=>$february, "march"=>$march, "april"=>$april, "may"=>$may, "june"=>$june, "july"=>$july, "august"=>$august, "september"=>$september, "october"=>$october, "november"=>$november, "december"=>$december, "total"=>$total));
                        }else if ($j==2) {
                            array_push($fbData, array("type"=>$i, "catg"=>$j, "subcatg"=>0, "rowid"=>$rowid, "january"=>$january, "february"=>$february, "march"=>$march, "april"=>$april, "may"=>$may, "june"=>$june, "july"=>$july, "august"=>$august, "september"=>$september, "october"=>$october, "november"=>$november, "december"=>$december, "total"=>$total));
                        }else{}
                        
                    }elseif ($i==4) {
                        if ($j==1 || $j==10) {
                            
                        }else{
                            $oijanuary+=(float)$january;
                            $oifebruary+=(float)$february;
                            $oimarch+=(float)$march;
                            $oiapril+=(float)$april;
                            $oimay+=(float)$may;
                            $oijune+=(float)$june;
                            $oijuly+=(float)$july;
                            $oiaugust+=(float)$august;
                            $oiseptember+=(float)$september;
                            $oioctober+=(float)$october;
                            $oinovember+=(float)$november;
                            $oidecember+=(float)$december;
                            $oitotal+=(float)$total;

                        }
                        array_unshift($otherData, array("type"=>$i, "catg"=>$j, "subcatg"=>0, "rowid"=>$rowid, "january"=>$january, "february"=>$february, "march"=>$march, "april"=>$april, "may"=>$may, "june"=>$june, "july"=>$july, "august"=>$august, "september"=>$september, "october"=>$october, "november"=>$november, "december"=>$december, "total"=>$total));
                        if ($j==9) {
                            array_unshift($otherData, array("rowid"=>"otherincome", "january"=>$oijanuary, "february"=>$oifebruary, "march"=>$oimarch, "april"=>$oiapril, "may"=>$oimay, "june"=>$oijune, "july"=>$oijuly, "august"=>$oiaugust, "september"=>$oiseptember, "october"=>$oioctober, "november"=>$oinovember, "december"=>$oidecember, "total"=>$oitotal));
                        
                        }
                    }elseif ($i==5) {
                        array_push($cos, array("type"=>$i, "catg"=>$j, "subcatg"=>0, "rowid"=>$rowid, "january"=>$january, "february"=>$february, "march"=>$march, "april"=>$april, "may"=>$may, "june"=>$june, "july"=>$july, "august"=>$august, "september"=>$september, "october"=>$october, "november"=>$november, "december"=>$december, "total"=>$total));

                    }
                    
                  }
               
                }
        
    }
    $opexTypes=['', 'R & D', 'F & B', 'OOD', 'A & G', 'S & M', 'R & M', 'Management Fee', 'Non Operating Expenses', 'Management Fee' ];
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
             $getHotelBudget=HotelBudget::where('hotel_settings_id',getHotelSettings()->id)->where('type', 5)->where('category',$i)->where('sub_category', $row->id)->where('budget_year', $this->year)->get();
             if ($getHotelBudget->isEmpty()) {
                
             }else{
                    $hotelbudget=$getHotelBudget[0];
                    $january=$hotelbudget['january'];
                    $february=$hotelbudget['february'];
                    $march=$hotelbudget['march'];
                    $april=$hotelbudget['april'];
                    $may=$hotelbudget['may'];
                    $june=$hotelbudget['june'];
                    $july=$hotelbudget['july'];
                    $august=$hotelbudget['august'];
                    $september=$hotelbudget['september'];
                    $october=$hotelbudget['october'];
                    $november=$hotelbudget['november'];
                    $december=$hotelbudget['december'];
                    $total=(float)$january+(float)$february+(float)$march+(float)$april+(float)$may+(float)$june+(float)$july+(float)$august+(float)$september+(float)$october+(float)$november+(float)$december;
                    
                    // for main type
                    $subcatJanuary+=(float)$january;
                    $subcatFebruary+=(float)$february;
                    $subcatMarch+=(float)$march;
                    $subcatApril+=(float)$april;
                    $subcatMay+=(float)$may;
                    $subcatJune+=(float)$june;
                    $subcatJuly+=(float)$july;
                    $subcatAugust+=(float)$august;
                    $subcatSeptember+=(float)$september;
                    $subcatOctober+=(float)$october;
                    $subcatNovember+=(float)$november;
                    $subcatDecember+=(float)$december;
                    $subcatTotal+=(float)$total;
                    
             }
             array_unshift($cos, array("type"=>5, "catg"=>$i, "subcatg"=>$row->id, "name"=>$row->name, "class"=>"opex".$i, "january"=>$january, "february"=>$february, "march"=>$march, "april"=>$april, "may"=>$may, "june"=>$june, "july"=>$july, "august"=>$august, "september"=>$september, "october"=>$october, "november"=>$november, "december"=>$december, "total"=>$total));

        }
        array_unshift($cos, array("type"=>5, "class"=>"mainType", "name"=>$opexTypes[$i], "id"=>"opex".$i, "january"=>$subcatJanuary, "february"=>$subcatFebruary, "march"=>$subcatMarch, "april"=>$subcatApril, "may"=>$subcatMay, "june"=>$subcatJune, "july"=>$subcatJuly, "august"=>$subcatAugust, "september"=>$subcatSeptember, "october"=>$subcatOctober, "november"=>$subcatNovember, "december"=>$subcatDecember, "total"=>$subcatTotal));


    }

    $months=["january", "february", "march", "april", "may", "june", "july", "august", "september", "october", "november", "december"];
    $availableRoomNights=[];
    $averageOccupancy=[];
    $guestinHouse=[];
    $roomsRevenue=[];
    $oodRevenue=[];
    $revparRevenue=[];
    $breakfastRevenue=[];
    $foodRevenue=[];
    $guestinhouseSum=0;
    $availableNightsSum=0;
    $averageOccSum=0;
    $roomRevenueSum=0;
    $oodRevenueSum=0;
    $breakfastSum=0;
    $revparSum=0;
    $foodrevenueSum=0;

    for ($index=0; $index <count($operatingDays) ; $index++) { 
        // calculate available room nights
        $availableRoomNight=(int)$operatingDays[$index]*(int)$availableRooms[$index];
        $availableNightsSum+=(int)$availableRoomNight;
        $availableRoomNights[$months[$index]]=$availableRoomNight;
        // calculate occupancy
        if ($OccupiedRoomNights[$index]==0 || $availableRoomNight==0) {
            $averageOcc=0;
        }else{
            $averageOcc=(int)$OccupiedRoomNights[$index]/(int)$availableRoomNight*100;
        }
        $averageOcc=number_format((float)$averageOcc, 2, '.', '');
        $averageOccSum+=(float)$averageOcc;
        $averageOccupancy[$months[$index]]=$averageOcc;
        // calculate guest in house
        $gih=(int)$OccupiedRoomNights[$index]*(float)$dof[$index];
        $guestinHouse[$months[$index]]=(int)$gih;
        $guestinhouseSum+=(int)$gih;
        // calculate rooms revenue
        $roomrevenue=(int)$OccupiedRoomNights[$index]*$adr[$index];
        $roomrevenue=number_format((float)$roomrevenue, 2, '.', '');
        $roomRevenueSum+=$roomrevenue;
        $roomsRevenue[$months[$index]]=$roomrevenue;
        // calculate revpar
        if ($roomrevenue==0 || $availableRoomNight==0) {
            $revpar=0;
        }else{
            $revpar=(float)$roomrevenue/(int)$availableRoomNight;
        }
        $revpar=number_format((float)$revpar, 2, '.', '');
        $revparSum+=(float)$revpar;
        $revparRevenue[$months[$index]]=$revpar;

        // calculate ood revenue
        if ($cxl[$index]==0 || $roomrevenue==0) {
            $ood=0;
        }else{
            $ood=((float)$roomrevenue*(float)$cxl[$index])/100;
        }
        $ood=number_format((float)$ood, 2, '.', '');
        $oodRevenueSum+=$ood;
        $oodRevenue[$months[$index]]=$ood;
        // calculate breakfast
        $breakfast=((float)$roomrevenue*(float)$this->breakfastPercentage)/100;
        $breakfast=number_format((float)$breakfast, 2, '.', '');
        $breakfastSum+=$breakfast;
        $breakfastRevenue[$months[$index]]=$breakfast;
        // calculate food revenue
        $food=(float)$breakfast+(float)$services[$index];
        $foodrevenueSum+=$food;
        $foodRevenue[$months[$index]]=$food;

    }
    $availableRoomNights["rowid"]="arn";
    $availableRoomNights["total"]=$availableNightsSum;
    $averageOccupancy["rowid"]="avgOcc";
    $averageOccSum=number_format((float)$averageOccSum/12, 2, '.', '');
    $averageOccupancy["total"]=$averageOccSum;
    $guestinHouse["rowid"]="gih";
    $guestinHouse["total"]=$guestinhouseSum;
    $revparRevenue["rowid"]="revpar";
    $revparRevenue["total"]=number_format((float)$revparSum/12, 2, '.', '');
    $roomsRevenue["rowid"]="230";
    $roomsRevenue["total"]=number_format((float)$roomRevenueSum, 2, '.', '');
    $oodRevenue["rowid"]="220";
    $oodRevenue["total"]=number_format((float)$oodRevenueSum, 2, '.', '');
    $breakfastRevenue["rowid"]="breakfastrevenue";
    $breakfastRevenue["total"]=$breakfastSum;
    $foodRevenue["rowid"]="foodrevenue";
    $foodRevenue["total"]=$foodrevenueSum;
    array_push($statisticData, $availableRoomNights);
    array_push($statisticData, $averageOccupancy);
    array_push($statisticData, $guestinHouse);
    array_push($statisticData, $revparRevenue);
    array_unshift($roomDeptData, $oodRevenue);
    array_unshift($roomDeptData, $roomsRevenue);
    array_unshift($fbData, $breakfastRevenue);
    array_unshift($fbData, $foodRevenue);
    
    
//    dd($fbData);
    // $roomDeptData=collect($roomDeptData)->sortBy('rowid');

    $this->statistics=$statisticData;
    $this->roomDeptData=$roomDeptData;
    $this->fbdept=$fbData;
    $this->oodData=$otherData;
    $this->opexData=$cos;
}
}

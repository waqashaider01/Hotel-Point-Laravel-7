<?php

namespace App\Http\Livewire\Reports\Revenue;

use App\Models\RoomType;
use App\Models\Reservation;
use App\Models\DailyRate;
use App\Models\HotelBudget;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class Accommodation extends Component
{
    public $date;
    public $year;
    public $pastyear;
    public collection $roomtypes;
    public $chartdata;
    public $cRoomTypes;
    public $pRoomTypes;
    public $pastDate;
    public $pastMonthFirstDay;
    public $pastYearFirstDay;
    public $monthFirstDay;
    public $yearFirstDay;
    public $columnChartData;
    public $pieChartData;
    public $totalYearRevenue;
    public $totalForecastRevenue;
    public $diffPercentage;
    public $difference;
    public $activeClass;
   
    public function mount(){
        $this->roomtypes=getHotelSettings()->room_types;
        $this->date=today();
        $this->monthFirstDay=$this->date->copy()->startOfMonth('Y-m-d');
        $this->yearFirstDay=$this->date->copy()->startOfYear('Y-m-d');
        $this->pastDate=$this->date->copy()->subYear();
        $this->pastMonthFirstDay=$this->pastDate->copy()->startOfMonth('Y-m-d');
        $this->pastYearFirstDay=$this->pastDate->copy()->startOfYear('Y-m-d');
        $this->year=$this->date->copy()->year;
        $this->pastyear=$this->pastDate->copy()->year;
        $this->date=$this->date->toDateString();
        $this->pastDate=$this->pastDate->toDateString();



    }
    public function render()
    {


        $this->generateData();

        $this->dispatchBrowserEvent('accomChanged');
        return view('livewire.reports.revenue.accommodation');
    }

    public function setdate($date){
        $this->date=Carbon::parse($date);
        $this->monthFirstDay=$this->date->copy()->startOfMonth('Y-m-d');
        $this->yearFirstDay=$this->date->copy()->startOfYear('Y-m-d');
        $this->pastDate=$this->date->copy()->subYear();
        $this->pastMonthFirstDay=$this->pastDate->copy()->startOfMonth('Y-m-d');
        $this->pastYearFirstDay=$this->pastDate->copy()->startOfYear('Y-m-d');
        $this->year=$this->date->copy()->year;
        $this->pastyear=$this->pastDate->copy()->year;
        $this->date=$this->date->toDateString();
        $this->pastDate=$this->pastDate->toDateString();

    }

    public function setyear($year){
        $date=Carbon::parse($this->date);
        $month=$date->month;
        $day=$date->day;
        $this->date=Carbon::create($year, $month, $day);
        $this->monthFirstDay=$this->date->copy()->startOfMonth('Y-m-d');
        $this->yearFirstDay=$this->date->copy()->startOfYear('Y-m-d');
        $this->year=$this->date->copy()->year;
        $this->date=$this->date->toDateString();

    }
    public function setyear2($year){
        $date=Carbon::parse($this->date);
        $month=$date->month;
        $day=$date->day;
        $this->pastDate=Carbon::create($year, $month, $day);
        $this->pastMonthFirstDay=$this->pastDate->copy()->startOfMonth('Y-m-d');
        $this->pastYearFirstDay=$this->pastDate->copy()->startOfYear('Y-m-d');
        $this->pastyear=$this->pastDate->copy()->year;
        $this->pastDate=$this->pastDate->toDateString();

    }

    public function generateData(){
        $pastDataArray=[];
        $dataArray=[];
        $totalToday=0;
        $totalMonth=0;
        $totalYyear=0;
        $pastTotalToday=0;
        $pastTotalMonth=0;
        $pastTotalYear=0;
        $forecast=0;
        $difference=0;
        $percentage=0;
        $columnChart=[['Year', 'Day', 'MTD', 'YTD']];
        $pieChart=[];
        foreach($this->roomtypes as $roomtype){

            $roomtypeName=$roomtype['name'];
            $roomtypeId=$roomtype['id'];

            $dailyAccom=DailyRate::join('reservations', 'reservations.id','=', 'daily_rates.reservation_id')
                                   ->join('rooms', 'rooms.id', '=', 'reservations.room_id')
                                   ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
                                   ->where('daily_rates.date', '=', $this->date)
                                   ->where('reservations.status', '!=', 'Cancelled')
                                   ->where('channex_status', '!=', 'cancelled')
                                   ->where('room_type_id', '=', $roomtypeId)
                                   ->where('rooms.status', '=', 'Enabled')
                                   ->sum('price');
          $monthlyAccom=DailyRate::join('reservations', 'reservations.id','=', 'daily_rates.reservation_id')
                                   ->join('rooms', 'rooms.id', '=', 'reservations.room_id')
                                   ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
                                   ->whereBetween('date', [$this->monthFirstDay, $this->date])
                                   ->where('reservations.status', '!=', 'Cancelled')
                                   ->where('channex_status', '!=', 'cancelled')
                                   ->where('room_type_id', '=', $roomtypeId)
                                   ->where('rooms.status', '=', 'Enabled')
                                   ->sum('price');

           $yearlyAccom=DailyRate::join('reservations', 'reservations.id','=', 'daily_rates.reservation_id')
                                   ->join('rooms', 'rooms.id', '=', 'reservations.room_id')
                                   ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
                                   ->whereBetween('date', [$this->yearFirstDay, $this->date])
                                   ->where('reservations.status', '!=', 'Cancelled')
                                   ->where('channex_status', '!=', 'cancelled')
                                   ->where('room_type_id', '=', $roomtypeId)
                                   ->where('rooms.status', '=', 'Enabled')
                                   ->sum('price');
            $pastdailyAccom=DailyRate::join('reservations', 'reservations.id','=', 'daily_rates.reservation_id')
                                   ->join('rooms', 'rooms.id', '=', 'reservations.room_id')
                                   ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
                                   ->where('date', '=', $this->pastDate)
                                   ->where('reservations.status', '!=', 'Cancelled')
                                   ->where('channex_status', '!=', 'cancelled')
                                   ->where('room_type_id', '=', $roomtypeId)
                                   ->where('rooms.status', '=', 'Enabled')
                                   ->sum('price');
          $pastmonthlyAccom=DailyRate::join('reservations', 'reservations.id','=', 'daily_rates.reservation_id')
                                   ->join('rooms', 'rooms.id', '=', 'reservations.room_id')
                                   ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
                                   ->whereBetween('date', [$this->pastMonthFirstDay, $this->pastDate])
                                   ->where('reservations.status', '!=', 'Cancelled')
                                   ->where('channex_status', '!=', 'cancelled')
                                   ->where('room_type_id', '=', $roomtypeId)
                                   ->where('rooms.status', '=', 'Enabled')
                                   ->sum('price');

           $pastyearlyAccom=DailyRate::join('reservations', 'reservations.id','=', 'daily_rates.reservation_id')
                                   ->join('rooms', 'rooms.id', '=', 'reservations.room_id')
                                   ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
                                   ->whereBetween('date', [$this->pastYearFirstDay, $this->pastDate])
                                   ->where('reservations.status', '!=', 'Cancelled')
                                   ->where('channex_status', '!=', 'cancelled')
                                   ->where('room_type_id', '=', $roomtypeId)
                                   ->where('rooms.status', '=', 'Enabled')
                                   ->sum('price');
            $item=[];
            $item['roomtype']=$roomtypeName;
            $item['today']=showPriceWithCurrency($dailyAccom);
            $item['mtd']=showPriceWithCurrency($monthlyAccom);
            $item['ytd']=showPriceWithCurrency($yearlyAccom);
            array_push($dataArray, $item);

            $pastitem=[];

            $pastitem['roomtype'] =$roomtypeName;
            $pastitem['today']=showPriceWithCurrency($pastdailyAccom);
            $pastitem['mtd']= showPriceWithCurrency($pastmonthlyAccom);
            $pastitem['ytd']= showPriceWithCurrency($pastyearlyAccom);
            array_push($pastDataArray, $pastitem);

            // .......calculate total of day, month and year
            $totalToday+=(float)$dailyAccom;
            $totalMonth+=(float)$monthlyAccom;
            $totalYyear+=(float)$yearlyAccom;
            $pastTotalToday+=(float)$pastdailyAccom;
            $pastTotalMonth+=(float)$pastmonthlyAccom;
            $pastTotalYear+=(float)$pastyearlyAccom;
            // .....pie chart data
            $pieitem=[$roomtypeName];
            array_push($pieitem, ['v'=>(float)$yearlyAccom, 'f'=>showPriceWithCurrency($yearlyAccom)]);
            array_push($pieChart, $pieitem);

        }
        // .... column chart data
        $columnitem=[];
        array_push($columnitem, (string)$this->year);
        $subitem1=['v'=>(float)$totalToday, 'f'=>showPriceWithCurrency($totalToday)];
        array_push($columnitem, $subitem1);
        $subitem2=['v'=>(float)$totalMonth, 'f'=>showPriceWithCurrency($totalMonth)];
        array_push($columnitem, $subitem2);
        $subitem3=['v'=>(float)$totalYyear, 'f'=>showPriceWithCurrency($totalYyear)];
        array_push($columnitem, $subitem3);
        $columnChart[]=$columnitem;
        $columnitem=[];
        array_push($columnitem, (string)$this->pastyear);
        $subitem1=['v'=>(float)$pastTotalToday, 'f'=>showPriceWithCurrency($pastTotalToday)];
        array_push($columnitem, $subitem1);
        $subitem2=['v'=>(float)$pastTotalMonth, 'f'=>showPriceWithCurrency($pastTotalMonth)];
        array_push($columnitem, $subitem2);
        $subitem3=['v'=>(float)$pastTotalYear, 'f'=>showPriceWithCurrency($pastTotalYear)];
        array_push($columnitem, $subitem3);
        $columnChart[]=$columnitem;

        // ....add total row
        $item=[];
        $item['roomtype']='Total';
        $item['today']=showPriceWithCurrency($totalToday);
        $item['mtd']=showPriceWithCurrency($totalMonth);
        $item['ytd']=showPriceWithCurrency($totalYyear);
        array_push($dataArray, $item);
        $this->totalYearRevenue=showPriceWithCurrency($totalYyear);

        $pastitem=[];
        $pastitem['roomtype'] ='Total';
        $pastitem['today']=showPriceWithCurrency($pastTotalToday);
        $pastitem['mtd']= showPriceWithCurrency($pastTotalMonth);
        $pastitem['ytd']= showPriceWithCurrency($pastTotalYear);
        array_push($pastDataArray, $pastitem);

        // ........calculate forecast.........
        $getForecastNights=HotelBudget::where('hotel_settings_id',getHotelSettings()->id)->where('budget_year', '=', $this->year)->where('type', 1)->where('category', 3)->get();
        $getForecastAdr=HotelBudget::where('hotel_settings_id',getHotelSettings()->id)->where('budget_year', '=', $this->year)->where('type', '1')->where('category', 4)->get();
        if ($getForecastNights->isEmpty() || $getForecastAdr->isEmpty()) {

        }else{
            $getForecastAdr=$getForecastAdr[0];
            $getForecastNights=$getForecastNights[0];
            $jan=(int)$getForecastNights['january']*(float)$getForecastAdr['january'];
            $feb=(int)$getForecastNights['february']*(float)$getForecastAdr['february'];
            $march=(int)$getForecastNights['march']*(float)$getForecastAdr['march'];
            $april=(int)$getForecastNights['april']*(float)$getForecastAdr['april'];
            $may=(int)$getForecastNights['may']*(float)$getForecastAdr['may'];
            $june=(int)$getForecastNights['june']*(float)$getForecastAdr['june'];
            $july=(int)$getForecastNights['july']*(float)$getForecastAdr['july'];
            $aug=(int)$getForecastNights['august']*(float)$getForecastAdr['august'];
            $sep=(int)$getForecastNights['september']*(float)$getForecastAdr['september'];
            $oct=(int)$getForecastNights['october']*(float)$getForecastAdr['october'];
            $nov=(int)$getForecastNights['november']*(float)$getForecastAdr['november'];
            $dec=(int)$getForecastNights['december']*(float)$getForecastAdr['december'];

            $forecast=(float)$jan+(float)$feb+(float)$march+(float)$april+(float)$may+(float)$june+(float)$july+(float)$aug+(float)$sep+(float)$oct+(float)$nov+(float)$dec;
            if ($totalYyear==0 || $forecast==0) {
                $percentage=0;
            }else{
                $percentage=$totalYyear/$forecast*100;
            }

        }
            $difference=$totalYyear-$forecast;
            if ($difference<0) {
                $this->activeClass='triangle-down-red';
            }else{
                $this->activeClass='triangle-up-green';
            }
            $this->difference=showPriceWithCurrency($difference);
            $this->diffPercentage=number_format((float)$percentage, 2, '.', '');
            $this->totalForecastRevenue=showPriceWithCurrency($forecast);
            $this->cRoomTypes=$dataArray;
            $this->pRoomTypes=$pastDataArray;
            $this->columnChartData=$columnChart;
            $this->pieChartData=$pieChart;


    }


}

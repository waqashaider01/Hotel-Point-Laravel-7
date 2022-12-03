<?php

namespace App\Http\Livewire\Reports\Accounting;
use App\Models\HotelSetting;
use App\Models\DailyRate;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


use Livewire\Component;

class City extends Component
{
    public $date;
    public $year;
    public $chartdata;
    public $mode='current';
    public $cityData;
    public $accomVat;
    public $cityTax;


    public function mount(){
        $hotelsetting = getHotelSettings();
        $accomVat=$hotelsetting->vat;
        $accomVat=1+((float)$accomVat/100);
        $this->accomVat=$accomVat;
        $cityTax=$hotelsetting->city_tax;
        $cityTax=1+((float)$cityTax/100);
        $this->cityTax=$cityTax;
        $this->date=today();
        $this->mode="current";
    }

    public function render()
    {
        $this->computeData();
        $this->dispatchBrowserEvent('cityChanged');
        return view('livewire.reports.accounting.city');
    }

    public function setdate($date){
        $this->date= Carbon::parse($date);
        $this->mode="current";
      }


     public function setyear($year){
       $date=$year."-01-01";
       $this->date= Carbon::parse($date);
       $this->mode="full";
    }
    public function computeData(){
        $this->year=$this->date->year;
        $cdate=$this->date->day;
        $dataArray=[];
        $chartdata=[['Month', 'City Tax', 'City Tax']];
        $monthArray=['Month','Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        for ($i=1; $i <=12 ; $i++) {
            $monthlytotal=0;
            $startDate=$this->year.'-'.$i."-01";
            $startDate=Carbon::parse($startDate)->toDateString();
            if ($this->mode=="current") {
                $endDate=$this->year."-".$i."-".$cdate;
                $endDate=Carbon::parse($endDate)->toDateString();
            }else{
                $endDate=Carbon::parse($startDate)->endOfMonth();
            }
              $accomRevenue=DailyRate::join('reservations', 'daily_rates.reservation_id', '=', 'reservations.id')->where('reservations.hotel_settings_id', getHotelSettings()->id)->where('reservations.status', 'Arrived')->whereBetween('date', [$startDate,$endDate])->sum('price');

              if ($accomRevenue==0 || $this->accomVat==0) {
                  $netAccommodationRevenue=0;
              }else{
                  $netAccommodationRevenue=(float)$accomRevenue/(float)$this->accomVat;
              }
              $netAccommodationRevenue=number_format((float)$netAccommodationRevenue, 2, '.', '');

              if ($netAccommodationRevenue==0 || $this->cityTax==0) {
                  $cityTaxValue=0;
              }else{
                  $cityTaxValue=(float)$netAccommodationRevenue/(float)$this->cityTax;
              }
              $cityTaxValue=number_format((float)$cityTaxValue, 2, '.', '');

              $cityTaxAmount=$netAccommodationRevenue-$cityTaxValue;
              $cityTaxAmount1=showPriceWithCurrency($cityTaxAmount);
              array_push($dataArray, $cityTaxAmount1);
              array_push($chartdata, [$monthArray[$i], ['v'=>$cityTaxAmount, 'f'=>$cityTaxAmount1], ['v'=>$cityTaxAmount, 'f'=>$cityTaxAmount1]]);


        }
          $this->chartdata=$chartdata;
          $this->cityData=$dataArray;
          $this->date=$this->date->toDateString();

    }
}

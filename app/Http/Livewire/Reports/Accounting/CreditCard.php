<?php

namespace App\Http\Livewire\Reports\Accounting;
use App\Models\PaymentMethod;
use App\Models\GuestAccommodationPayment;
use App\Models\GuestExtrasPayment;
use App\Models\GuestOvernightTaxPayment;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

use Livewire\Component;

class CreditCard extends Component
{
    public $date;
    public $year;
    public $pastyear;
    public collection $creditCards;
    public $chartdata;
    public $cCards;
    public $pCards;
    public $pastDate;
    public $pastMonthFirstDay;
    public $pastYearFirstDay;
    public $monthFirstDay;
    public $yearFirstDay;
    public $createChart=1;
    public $selectedYear;

    public function mount(){
        $this->creditCards=PaymentMethod::where('payment_methods.hotel_settings_id', getHotelSettings()->id)->where('is_card_type', 1)->get();
        $this->date=today();
        $this->monthFirstDay=$this->date->copy()->startOfMonth('Y-m-d');
        $this->yearFirstDay=$this->date->copy()->startOfYear('Y-m-d');
        $this->pastDate=$this->date->copy()->subYear();
        $this->pastMonthFirstDay=$this->pastDate->copy()->startOfMonth('Y-m-d');
        $this->pastYearFirstDay=$this->pastDate->copy()->startOfYear('Y-m-d');
        $this->year=$this->date->copy()->year;
        $this->selectedYear=$this->date->copy()->year;
        $this->pastyear=$this->pastDate->copy()->year;
        $this->date=$this->date->toDateString();
        $this->pastDate=$this->pastDate->toDateString();
       
    }

    public function render()
    {
        $this->calculateValues();
        $this->dispatchBrowserEvent('creditChanged');
        return view('livewire.reports.accounting.credit-card');
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
        $this->selectedYear=$this->date->copy()->year;
        $this->date=$this->date->toDateString();
        $this->pastDate=$this->pastDate->toDateString();
        $this->createChart=1;
        
        
    }

    public function setyear($year){
        $date=Carbon::parse($this->date);
        $month=$date->month;
        $day=$date->day;
        $this->date=Carbon::create($year, $month, $day);
        $this->monthFirstDay=$this->date->copy()->startOfMonth('Y-m-d');
        $this->yearFirstDay=$this->date->copy()->startOfYear('Y-m-d');
        $this->year=$this->date->copy()->year;
        $this->selectedYear=$this->date->copy()->year;
        $this->date=$this->date->toDateString();
        $this->createChart=1;
        
    }
    public function setyear2($year){
        $date=Carbon::parse($this->date);
        $month=$date->month;
        $day=$date->day;
        $this->pastDate=Carbon::create($year, $month, $day);
        $this->pastMonthFirstDay=$this->pastDate->copy()->startOfMonth('Y-m-d');
        $this->pastYearFirstDay=$this->pastDate->copy()->startOfYear('Y-m-d');
        $this->pastyear=$this->pastDate->copy()->year;
        $this->selectedYear=$this->pastDate->copy()->year;
        $this->pastDate=$this->pastDate->toDateString();
        $this->createChart=2;
        
        
    }

    public function calculateValues(){
        $pastDataArray=[];
        $dataArray=[];
        $chartdata=[['Credit Card', 'Day', 'MTD', 'YTD']];

        foreach($this->creditCards as $card){
              $paymentmethodid=$card['id'];
              $paymentmethodName=$card['name'];
              $pastDayAccomRevenue=GuestAccommodationPayment::where('payment_method_id', $paymentmethodid)->where('date', $this->pastDate)->sum('value');
              $pastDayOvernightRevenue=GuestOvernightTaxPayment::where('payment_method_id', $paymentmethodid)->where('date', $this->pastDate)->sum('value');
              $pastDayExtrasRevenue=GuestExtrasPayment::where('payment_method_id', $paymentmethodid)->where('date', $this->pastDate)->sum('value');
              $firstDayAccomRevenue=GuestAccommodationPayment::where('payment_method_id', $paymentmethodid)->where('date', $this->date)->sum('value');
              $firstDayOvernightRevenue=GuestOvernightTaxPayment::where('payment_method_id', $paymentmethodid)->where('date', $this->date)->sum('value');
              $firstDayExtrasRevenue=GuestExtrasPayment::where('payment_method_id', $paymentmethodid)->where('date', $this->date)->sum('value');
              $pastDayTotalRevenue=(float)$pastDayAccomRevenue+(float)$pastDayExtrasRevenue+(float)$pastDayOvernightRevenue;
              $pastDayTotalRevenue1=showPriceWithCurrency($pastDayTotalRevenue);
              $dayRevenue=(float)$firstDayAccomRevenue+(float)$firstDayExtrasRevenue+(float)$firstDayOvernightRevenue;
              $dayRevenue1=showPriceWithCurrency($dayRevenue);

              $pastMonthAccomRevenue=GuestAccommodationPayment::where('payment_method_id', $paymentmethodid)->whereBetween('date', [$this->pastMonthFirstDay,$this->pastDate])->sum('value');
              $pastMonthOvernightRevenue=GuestOvernightTaxPayment::where('payment_method_id', $paymentmethodid)->whereBetween('date', [$this->pastMonthFirstDay,$this->pastDate])->sum('value');
              $pastMonthExtrasRevenue=GuestExtrasPayment::where('payment_method_id', $paymentmethodid)->whereBetween('date', [$this->pastMonthFirstDay,$this->pastDate])->sum('value');
              $firstMonthAccomRevenue=GuestAccommodationPayment::where('payment_method_id', $paymentmethodid)->whereBetween('date', [$this->monthFirstDay,$this->date])->sum('value');
              $firstMonthOvernightRevenue=GuestOvernightTaxPayment::where('payment_method_id', $paymentmethodid)->whereBetween('date', [$this->monthFirstDay, $this->date])->sum('value');
              $firstMonthExtrasRevenue=GuestExtrasPayment::where('payment_method_id', $paymentmethodid)->whereBetween('date', [$this->monthFirstDay, $this->date])->sum('value');
              $pastMonthTotalRevenue=(float)$pastMonthAccomRevenue+(float)$pastMonthExtrasRevenue+(float)$pastMonthOvernightRevenue;
              $pastMonthTotalRevenue1=showPriceWithCurrency($pastMonthTotalRevenue);
              $monthTotalRevenue=(float)$firstMonthAccomRevenue+(float)$firstMonthExtrasRevenue+(float)$firstMonthOvernightRevenue;
              $monthTotalRevenue1=showPriceWithCurrency($monthTotalRevenue);

              $pastYearAccomRevenue=GuestAccommodationPayment::where('payment_method_id', $paymentmethodid)->whereBetween('date', [$this->pastYearFirstDay,$this->pastDate])->sum('value');
              $pastYearOvernightRevenue=GuestOvernightTaxPayment::where('payment_method_id', $paymentmethodid)->whereBetween('date', [$this->pastYearFirstDay,$this->pastDate])->sum('value');
              $pastYearExtrasRevenue=GuestExtrasPayment::where('payment_method_id', $paymentmethodid)->whereBetween('date', [$this->pastYearFirstDay,$this->pastDate])->sum('value');
              $firstYearAccomRevenue=GuestAccommodationPayment::where('payment_method_id', $paymentmethodid)->whereBetween('date', [$this->yearFirstDay,$this->date])->sum('value');
              $firstYearOvernightRevenue=GuestOvernightTaxPayment::where('payment_method_id', $paymentmethodid)->whereBetween('date', [$this->yearFirstDay, $this->date])->sum('value');
              $firstYearExtrasRevenue=GuestExtrasPayment::where('payment_method_id', $paymentmethodid)->whereBetween('date', [$this->yearFirstDay, $this->date])->sum('value');
              $pastYearTotalRevenue=(float)$pastYearAccomRevenue+(float)$pastYearExtrasRevenue+(float)$pastYearOvernightRevenue;
              $pastYearTotalRevenue1=showPriceWithCurrency($pastYearTotalRevenue);
              $yearTotalRevenue=(float)$firstYearAccomRevenue+(float)$firstDayExtrasRevenue+(float)$firstDayOvernightRevenue;
              $yearTotalRevenue1=showPriceWithCurrency($yearTotalRevenue);

              array_push($dataArray, [$paymentmethodName, $dayRevenue1, $monthTotalRevenue1, $yearTotalRevenue1]);
              array_push($pastDataArray, [$paymentmethodName, $pastDayTotalRevenue1, $pastMonthTotalRevenue1, $pastYearTotalRevenue1]);
              
              if ($this->createChart==1) {
                 array_push($chartdata, [$paymentmethodName, ['v'=>(float)$dayRevenue, 'f'=>$dayRevenue1], ['v'=>$monthTotalRevenue, 'f'=>$monthTotalRevenue1], ['v'=>$yearTotalRevenue, 'f'=>$yearTotalRevenue1] ]);
              }else{
                array_push($chartdata, [$paymentmethodName, ['v'=>(float)$pastDayTotalRevenue1, 'f'=>$pastDayTotalRevenue], ['v'=>$pastMonthTotalRevenue, 'f'=>$pastMonthTotalRevenue1], ['v'=>$pastYearTotalRevenue, 'f'=>$pastYearTotalRevenue1] ]);
              }

        }

        $this->cCards=$dataArray;
        $this->pCards=$pastDataArray;
        $this->chartdata=$chartdata;
        
    }

    
}

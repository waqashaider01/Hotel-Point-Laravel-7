<?php

namespace App\Http\Livewire\Reports\Accounting;
use App\Models\GuestAccommodationPayment;
use App\Models\GuestExtrasPayment;
use App\Models\GuestOvernightTaxPayment;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

use Livewire\Component;

class Cash extends Component
{
    public $date;
    public $year;
    public $chartdata;
    public $mode='current';
    public $cashData;

    public function mount(){
        $this->date=today();
        $this->mode="current";
      
    }

    public function render()
    {
        $this->computeData();
        $this->dispatchBrowserEvent('cashChanged');
        return view('livewire.reports.accounting.cash');
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
        $chartdata=[['Month', 'Cash', 'Cash']];
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
              $accomRevenue=GuestAccommodationPayment::join('payment_methods', 'guest_accommodation_payments.payment_method_id', '=', 'payment_methods.id')->where('payment_methods.hotel_settings_id', getHotelSettings()->id)->where('channex_id', 'Cash')->whereBetween('date', [$startDate,$endDate])->sum('value');
              $overnightRevenue=GuestOvernightTaxPayment::join('payment_methods', 'guest_overnight_tax_payments.payment_method_id', '=', 'payment_methods.id')->where('payment_methods.hotel_settings_id', getHotelSettings()->id)->where('channex_id', 'Cash')->whereBetween('date', [$startDate, $endDate])->sum('value');
              $extrasRevenue=GuestExtrasPayment::join('payment_methods', 'guest_extras_payments.payment_method_id', '=', 'payment_methods.id')->where('payment_methods.hotel_settings_id', getHotelSettings()->id)->where('channex_id', 'Cash')->whereBetween('date', [$startDate, $endDate])->sum('value');
              $monthlytotal=(float)$accomRevenue+(float)$overnightRevenue+(float)$extrasRevenue;
              $monthlytotal1=showPriceWithCurrency($monthlytotal);
              array_push($dataArray, $monthlytotal1);
              array_push($chartdata, [$monthArray[$i], ['v'=>$monthlytotal, 'f'=>$monthlytotal1], ['v'=>$monthlytotal, 'f'=>$monthlytotal1]]);

              
        }
          $this->chartdata=$chartdata;
          $this->cashData=$dataArray;
          $this->date=$this->date->toDateString();

    }
}

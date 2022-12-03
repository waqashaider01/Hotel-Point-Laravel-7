<?php

namespace App\Http\Livewire\Reports\Accounting;
use App\Models\PaymentMethod;
use App\Models\GuestOvernightTaxPayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

use Livewire\Component;

class Overnight extends Component
{
    public $selectedDate; 
    public $mode='current';
    public  $chartdata;
    public $year;
    public $cardsData;
    public collection $paymentMethods;
    public $total;

    public function mount(){
        $this->selectedDate=today();
        $this->mode="current";
        $this->paymentMethods=PaymentMethod::where('hotel_settings_id', getHotelSettings()->id)->where('is_card_type', 0)->get();
      }
    public function render()
    {
        $this->createData();
        $this->dispatchBrowserEvent('overnightChanged');
        return view('livewire.reports.accounting.overnight');
    }

    public function set_date($date){
        $this->selectedDate= Carbon::parse($date);
        $this->mode="current";
      }
    
 
     public function set_year($year){
       $date=$year."-01-01";
       $this->selectedDate= Carbon::parse($date);
       $this->mode="full";
    }
    
 
    public function createData(){
         $this->year=$this->selectedDate->year;
         $cdate=$this->selectedDate->day;
         $dataArray=[];
         [$jan, $feb, $march, $apr, $may, $june, $july, $aug, $sep, $oct, $nov, $dec]=0;
         $firstRow=["Month"];
         $jandata=["Jan" ];
         $febdata=["Feb" ];
         $marchData=["Mar" ];
         $aprData=["Apr" ];
         $mayData=["May" ];
         $juneData=["Jun" ];
         $julyData=["Jul" ];
         $augData=["Aug" ];
         $sepData=["Sep" ];
         $octData=["Oct" ];
         $novData=["Nov" ];
         $decData=["Dec" ];
         foreach ($this->paymentMethods as $method){
             $result=[];
             $paymentMethodId=$method->id;
             $paymentMethodName=$method->name;
             $result['card']=$paymentMethodName;
             $firstRow[]=$paymentMethodName;
         
             for ($i=1; $i <=12 ; $i++) { 
                 $startDate=$this->year.'-'.$i."-01";
                 $startDate=Carbon::parse($startDate)->toDateString();
                 if ($this->mode=="current") {
                     $endDate=$this->year."-".$i."-".$cdate;
                     $endDate=Carbon::parse($endDate)->toDateString();
                 }else{
                     $endDate=Carbon::parse($startDate)->endOfMonth();
                 }
                 
                 $monthRevenueTotal=GuestOvernightTaxPayment::where('payment_method_id', $paymentMethodId)->whereBetween('date', [$startDate, $endDate])->sum('value');
                 $monthRevenueTotal1=showPriceWithCurrency($monthRevenueTotal);
                 $result[$i]=$monthRevenueTotal1;
                 if ($i==1) {
                     array_push($jandata, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                     $jan+=(float)$monthRevenueTotal;
                   }else if ($i==2) {
                     array_push($febdata, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                     $feb+=(float)$monthRevenueTotal;
                   }else if ($i==3) {
                      array_push($marchData, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                      $march+=(float)$monthRevenueTotal;
                   }else if ($i==4) {
                      array_push($aprData, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                      $apr+=(float)$monthRevenueTotal;
                   }else if ($i==5) {
                      array_push($mayData, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                      $may+=(float)$monthRevenueTotal;
                   }else if ($i==6) {
                      array_push($juneData, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                      $june+=(float)$monthRevenueTotal;
                   }else if ($i==7) {
                      array_push($julyData, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                      $july+=(float)$monthRevenueTotal;
                   }else if ($i==8) {
                      array_push($augData, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                      $aug+=(float)$monthRevenueTotal;
                   }else if ($i==9) {
                      array_push($sepData, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                      $sep+=(float)$monthRevenueTotal;
                   }else if ($i==10) {
                      array_push($octData, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                      $oct+=(float)$monthRevenueTotal;
                   }else if ($i==11) {
                      array_push($novData, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                      $nov+=(float)$monthRevenueTotal;
                   }else if ($i==12) {
                      array_push($decData, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                      $dec+=(float)$monthRevenueTotal;
                   }
                 
             }
             $dataArray[]=$result;
             
         }

         $result=[];
         $result['card']='Credit Card';
         $firstRow[]='Credit Card';
             
         for ($i=1; $i <=12 ; $i++) { 
            $startDate=$this->year.'-'.$i."-01";
            $startDate=Carbon::parse($startDate)->toDateString();
            if ($this->mode=="current") {
                $endDate=$this->year."-".$i."-".$cdate;
                $endDate=Carbon::parse($endDate)->toDateString();
            }else{
                $endDate=Carbon::parse($startDate)->endOfMonth();
            }
            
            $monthRevenueTotal=GuestOvernightTaxPayment::join('payment_methods', 'guest_overnight_tax_payments.payment_method_id', '=', 'payment_methods.id')->where('is_card_type', 1)->whereBetween('date', [$startDate, $endDate])->sum('value');
            $monthRevenueTotal1=showPriceWithCurrency($monthRevenueTotal);
            $result[$i]=$monthRevenueTotal1;
            if ($i==1) {
                array_push($jandata, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                $jan+=(float)$monthRevenueTotal;
              }else if ($i==2) {
                array_push($febdata, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                $feb+=(float)$monthRevenueTotal;
              }else if ($i==3) {
                 array_push($marchData, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                 $march+=(float)$monthRevenueTotal;
              }else if ($i==4) {
                 array_push($aprData, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                 $apr+=(float)$monthRevenueTotal;
              }else if ($i==5) {
                 array_push($mayData, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                 $may+=(float)$monthRevenueTotal;
              }else if ($i==6) {
                 array_push($juneData, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                 $june+=(float)$monthRevenueTotal;
              }else if ($i==7) {
                 array_push($julyData, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                 $july+=(float)$monthRevenueTotal;
              }else if ($i==8) {
                 array_push($augData, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                 $aug+=(float)$monthRevenueTotal;
              }else if ($i==9) {
                 array_push($sepData, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                 $sep+=(float)$monthRevenueTotal;
              }else if ($i==10) {
                 array_push($octData, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                 $oct+=(float)$monthRevenueTotal;
              }else if ($i==11) {
                 array_push($novData, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                 $nov+=(float)$monthRevenueTotal;
              }else if ($i==12) {
                 array_push($decData, ['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1]);
                 $dec+=(float)$monthRevenueTotal;
              }
            
        }
             $dataArray[]=$result;
             $this->total=[$jan, $feb, $march, $apr, $may, $june, $july, $aug, $sep, $oct, $nov, $dec];
             $chartdata=[$firstRow, $jandata, $febdata, $marchData, $aprData, $mayData, $juneData, $julyData, $augData, $sepData, $octData, $novData, $decData];
             $this->selectedDate=$this->selectedDate->toDateString();
             $this->cardsData=$dataArray;
             $this->chartdata=$chartdata;
             
    }
}

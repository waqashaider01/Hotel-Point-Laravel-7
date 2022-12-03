<?php

namespace App\Http\Livewire\Reports\Opex;
use App\Models\Description;
use App\Models\OpexData;
use App\Models\HotelBudget;
use Carbon\Carbon;

use Livewire\Component;

class Rd extends Component
{
    public $selectedDate;
    public $operatingExpenseMTD;
    public $operatingExpenseYTD;
    public $totalMtdActualOE, $totalMtdBudgetOE, $totalYtdActualOE, $totalYtdBudgetOE;
    public $totalOEmtdVAlue, $totalOEmtdColor, $totalOEytdVAlue, $totalOEytdColor;

    public function mount(){
        $this->selectedDate=today();
    }
    public function render()
    {
        $month=$this->selectedDate->month;
        $year=$this->selectedDate->year;
        $startOfMonth=$this->selectedDate->copy()->startOfMonth('Y-m-d');
        $startOfYear=$this->selectedDate->copy()->startOfYear('Y-m-d');
        $operatingExpenseMTD=[];
        $operatingExpenseYTD=[];
        $totalMtdActualOE=0;
        $totalMtdBudgetOE=0;
        $totalYtdActualOE=0;
        $totalYtdBudgetOE=0;
        $getOEDescription=Description::where('category_id', 1)->get();
        foreach ($getOEDescription as $description) {
             $opexMonth=OpexData::where('hotel_settings_id', getHotelSettings()->id)->where('description_id', $description->id)->whereBetween('date', [$startOfMonth, $this->selectedDate])->sum('amount');
             $opexYear=OpexData::where('hotel_settings_id', getHotelSettings()->id)->where('description_id', $description->id)->whereBetween('date', [$startOfYear, $this->selectedDate])->sum('amount');
             $getBudget=HotelBudget::where('hotel_settings_id', getHotelSettings()->id)->where('budget_year', $year)->where('sub_category', $description->id)->get();
             if ($getBudget->isEmpty()) {
                $budgetMonth=0;
                $budgetYear=0;
             }else{
                $getBudget=$getBudget[0];
                if ($month==1) {
                    $budgetMonth=$getBudget['january'];
                }else if ($month==2) {
                    $budgetMonth=$getBudget['february'];
                }else if ($month==3) {
                    $budgetMonth=$getBudget['march'];
                }else if ($month==4) {
                    $budgetMonth=$getBudget['april'];
                }else if ($month==5) {
                    $budgetMonth=$getBudget['may'];
                }else if ($month==6) {
                    $budgetMonth=$getBudget['june'];
                }else if ($month==7) {
                    $budgetMonth=$getBudget['july'];
                }else if ($month==8) {
                    $budgetMonth=$getBudget['august'];
                }else if ($month==9) {
                    $budgetMonth=$getBudget['september'];
                }else if ($month==10) {
                    $budgetMonth=$getBudget['october'];
                }else if ($month==11) {
                    $budgetMonth=$getBudget['november'];
                }else if ($month==12) {
                    $budgetMonth=$getBudget['december'];
                }else{}
                $budgetYear=(float)$getBudget['january']+(float)$getBudget['february']+(float)$getBudget['march']+(float)$getBudget['april']+(float)$getBudget['may']+(float)$getBudget['june']+(float)$getBudget['july']+(float)$getBudget['august']+(float)$getBudget['september']+(float)$getBudget['october']+(float)$getBudget['november']+(float)$getBudget['december'];
                $totalMtdBudgetOE+=(float)$budgetMonth;
                $totalYtdBudgetOE+=(float)$budgetYear;

             }
             $monthdifference=$this->calculateDiff($budgetMonth, $opexMonth);
             $monthdifferenceValue=$monthdifference['difference'];
             $monthcolor=$monthdifference['color'];
             $yeardifference=$this->calculateDiff($budgetYear, $opexYear);
             $yeardifferenceValue=$yeardifference['difference'];
             $yearcolor=$yeardifference['color'];
             array_push($operatingExpenseMTD, [$description->name, $opexMonth, $budgetMonth, [$monthdifferenceValue, $monthcolor] ]);
             array_push($operatingExpenseYTD, [$description->name, $opexYear, $budgetYear, [$yeardifferenceValue, $yearcolor]]);
             $totalMtdActualOE+=(float)$opexMonth;
             $totalYtdActualOE+=(float)$opexYear;
        }

        $totalOEmtdDifference=$this->calculateDiff($totalMtdBudgetOE, $totalMtdActualOE);
        $this->totalOEmtdVAlue=$totalOEmtdDifference['difference'];
        $this->totalOEmtdColor=$totalOEmtdDifference['color'];
        $totalOEytdDifference=$this->calculateDiff($totalYtdBudgetOE, $totalYtdActualOE);
        $this->totalOEytdVAlue=$totalOEytdDifference['difference'];
        $this->totalOEytdColor=$totalOEytdDifference['color'];

         

          $this->operatingExpenseMTD=$operatingExpenseMTD;
          $this->operatingExpenseYTD=$operatingExpenseYTD;
          $this->totalMtdActualOE=$totalMtdActualOE;
          $this->totalMtdBudgetOE=$totalMtdBudgetOE;
          $this->totalYtdActualOE=$totalYtdActualOE;
          $this->totalYtdBudgetOE=$totalYtdBudgetOE;
          $this->selectedDate=$this->selectedDate->toDateString();
          
          $this->dispatchBrowserEvent('rdChanged');
        return view('livewire.reports.opex.rd');
    }

    public function setdate($date){
        $this->selectedDate= Carbon::parse($date);
      }

      private function calculateDiff($forecast, $actual){
        $monthdifference=0;
        if($forecast==0 && $actual==0){
                $monthdifference=0;
                $color='green';
        }else if($forecast==0 && $actual!=0){
                $monthdifference=100;
                $color='green';
        }else if($forecast!==0 && $actual==0){
                $monthdifference=100;
                $color='red';
        }else{

                $monthdifference=$actual/$forecast;
                $monthdifference=($monthdifference*100)-100;
                if ($monthdifference<0) {
                    $color='red';
                }else{
                    $color='green';
                }
                abs($monthdifference);
                
        }
        $monthdifference=number_format((float)$monthdifference, 2, '.', '');

        return array("color"=>$color, "difference"=>$monthdifference);
    }
}

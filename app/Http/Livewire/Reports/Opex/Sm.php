<?php

namespace App\Http\Livewire\Reports\Opex;
use App\Models\Description;
use App\Models\OpexData;
use App\Models\HotelBudget;
use Carbon\Carbon;

use Livewire\Component;

class Sm extends Component
{
    public $selectedDate;
    public $salesOperatingExpenseMTD;
    public $salesOperatingExpenseYTD;
    public $marketingMtd;
    public $marketingYtd;
    public $totalMtdActualMOE, $totalMtdBudgetMOE, $totalMtdActualSOE, $totalMtdBudgetSOE, $totalYtdActualMOE, $totalYtdBudgetMOE, $totalYtdActualSOE, $totalYtdBudgetSOE;
    public $totalmtdSOEValue, $totalmtdSOEColor, $totalytdSOEValue, $totalytdSOEColor, $totalMoeMtdValue, $totalMoeMtdColor, $totalMoeYtdValue, $totalMoeYtdColor;

    public function mount(){
        $this->selectedDate=today();
    }

    public function render()
    {
        $month=$this->selectedDate->month;
        $year=$this->selectedDate->year;
        $startOfMonth=$this->selectedDate->copy()->startOfMonth('Y-m-d');
        $startOfYear=$this->selectedDate->copy()->startOfYear('Y-m-d');
        $salesOperatingExpenseMTD=[];
        $salesOperatingExpenseYTD=[];
        $marketingMtd=[];
        $marketingYtd=[];
        $totalMtdActualMOE=0;
        $totalMtdBudgetMOE=0;
        $totalYtdActualMOE=0;
        $totalYtdBudgetMOE=0;
        $totalMtdActualSOE=0;
        $totalMtdBudgetSOE=0;
        $totalYtdActualSOE=0;
        $totalYtdBudgetSOE=0;
        $getSOEDescription=Description::where('category_id', 7)->get();
        foreach ($getSOEDescription as $description) {
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
                $totalMtdBudgetSOE+=(float)$budgetMonth;
                $totalYtdBudgetSOE+=(float)$budgetYear;

             }
             $monthdifference=$this->calculateDiff($budgetMonth, $opexMonth);
             $monthdifferenceValue=$monthdifference['difference'];
             $monthcolor=$monthdifference['color'];
             $yeardifference=$this->calculateDiff($budgetYear, $opexYear);
             $yeardifferenceValue=$yeardifference['difference'];
             $yearcolor=$yeardifference['color'];
             array_push($salesOperatingExpenseMTD, [$description->name, $opexMonth, $budgetMonth, [$monthdifferenceValue, $monthcolor] ]);
             array_push($salesOperatingExpenseYTD, [$description->name, $opexYear, $budgetYear, [$yeardifferenceValue, $yearcolor]]);
             $totalMtdActualSOE+=(float)$opexMonth;
             $totalYtdActualSOE+=(float)$opexYear;
        }

        $totalSOEmtdDifference=$this->calculateDiff($totalMtdBudgetSOE, $totalMtdActualSOE);
        $this->totalmtdSOEValue=$totalSOEmtdDifference['difference'];
        $this->totalmtdSOEColor=$totalSOEmtdDifference['color'];
        $totalSOEytdDifference=$this->calculateDiff($totalYtdBudgetSOE, $totalYtdActualSOE);
        $this->totalytdSOEValue=$totalSOEytdDifference['difference'];
        $this->totalytdSOEColor=$totalSOEytdDifference['color'];


        $getMOEDescription=Description::where('category_id', 8)->get();
        foreach ($getMOEDescription as $description) {
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
                $totalMtdBudgetMOE+=(float)$budgetMonth;
                $totalYtdBudgetMOE+=(float)$budgetYear;

                
            }
             $totalMtdActualMOE+=(float)$opexMonth;
             $totalYtdActualMOE+=(float)$opexYear;
             $monthdifference=$this->calculateDiff($budgetMonth, $opexMonth);
             $monthdifferenceValue=$monthdifference['difference'];
             $monthcolor=$monthdifference['color'];
             $yeardifference=$this->calculateDiff($budgetYear, $opexYear);
             $yeardifferenceValue=$yeardifference['difference'];
             $yearcolor=$yeardifference['color'];
             array_push($marketingMtd, [$description->name, $opexMonth, $budgetMonth, [$monthdifferenceValue, $monthcolor] ]);
             array_push($marketingYtd, [$description->name, $opexYear, $budgetYear, [$yeardifferenceValue, $yearcolor]]);
             
        }

          $totalMOEmtdDifference=$this->calculateDiff($totalMtdBudgetSOE, $totalMtdActualSOE);
          $this->totalMoeMtdValue=$totalMOEmtdDifference['difference'];
          $this->totalMoeMtdColor=$totalMOEmtdDifference['color'];
          $totalMOEytdDifference=$this->calculateDiff($totalYtdBudgetSOE, $totalYtdActualSOE);
          $this->totalMoeYtdValue=$totalMOEytdDifference['difference'];
          $this->totalMoeYtdColor=$totalMOEytdDifference['color'];
         

          $this->salesOperatingExpenseMTD=$salesOperatingExpenseMTD;
          $this->salesOperatingExpenseYTD=$salesOperatingExpenseYTD;
          $this->marketingMtd=$marketingMtd;
          $this->marketingYtd=$marketingYtd;
          $this->totalMtdActualMOE=$totalMtdActualMOE;
          $this->totalMtdBudgetMOE=$totalMtdBudgetMOE;
          $this->totalYtdActualMOE=$totalYtdActualMOE;
          $this->totalYtdBudgetMOE=$totalYtdBudgetMOE;
          $this->totalMtdActualSOE=$totalMtdActualSOE;
          $this->totalMtdBudgetSOE=$totalMtdBudgetSOE;
          $this->totalYtdActualSOE=$totalYtdActualSOE;
          $this->totalYtdBudgetSOE=$totalYtdBudgetSOE;
          $this->selectedDate=$this->selectedDate->toDateString();
          $this->dispatchBrowserEvent('smChanged');
        return view('livewire.reports.opex.sm');
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

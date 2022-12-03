<?php

namespace App\Http\Livewire\Reports\Opex;
use App\Models\Description;
use App\Models\OpexData;
use App\Models\HotelBudget;
use Carbon\Carbon;

use Livewire\Component;

class Ood extends Component
{
    public $selectedDate;
    public $spaOperatingExpenseMTD;
    public $spaOperatingExpenseYTD;
    public $otherIncomeExpenseMTD;
    public $otherIncomeExpenseYTD;
    public $totalMtdActualSOE, $totalMtdBudgetSOE, $totalMtdActualOIE, $totalMtdBudgetOIE, $totalYtdActualSOE, $totalYtdBudgetSOE, $totalYtdActualOIE, $totalYtdBudgetOIE;
    public $totalmtdValue, $totalmtdColor, $totalytdValue, $totalytdColor, $totalSOEmtdVAlue, $totalSOEmtdColor, $totalSOEytdVAlue, $totalSOEytdColor;

    public function mount(){
        $this->selectedDate=today();
    }

    public function render()
    {
        $month=$this->selectedDate->month;
        $year=$this->selectedDate->year;
        $startOfMonth=$this->selectedDate->copy()->startOfMonth('Y-m-d');
        $startOfYear=$this->selectedDate->copy()->startOfYear('Y-m-d');
        $spaOperatingExpenseMTD=[];
        $spaOperatingExpenseYTD=[];
        $otherIncomeExpenseMTD=[];
        $otherIncomeExpenseYTD=[];
        $totalMtdActualSOE=0;
        $totalMtdBudgetSOE=0;
        $totalYtdActualSOE=0;
        $totalYtdBudgetSOE=0;
        $totalMtdActualOIE=0;
        $totalMtdBudgetOIE=0;
        $totalYtdActualOIE=0;
        $totalYtdBudgetOIE=0;
        $getSOEDescription=Description::where('category_id', 4)->get();
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
             array_push($spaOperatingExpenseMTD, [$description->name, $opexMonth, $budgetMonth, [$monthdifferenceValue, $monthcolor] ]);
             array_push($spaOperatingExpenseYTD, [$description->name, $opexYear, $budgetYear, [$yeardifferenceValue, $yearcolor]]);
             $totalMtdActualSOE+=(float)$opexMonth;
             $totalYtdActualSOE+=(float)$opexYear;
        }

        $totalSOEmtdDifference=$this->calculateDiff($totalMtdBudgetSOE, $totalMtdActualSOE);
        $this->totalSOEmtdVAlue=$totalSOEmtdDifference['difference'];
        $this->totalSOEmtdColor=$totalSOEmtdDifference['color'];
        $totalSOEytdDifference=$this->calculateDiff($totalYtdBudgetSOE, $totalYtdActualSOE);
        $this->totalSOEytdVAlue=$totalSOEytdDifference['difference'];
        $this->totalSOEytdColor=$totalSOEytdDifference['color'];


        $getOIEDescription=Description::where('category_id', 5)->get();
        foreach ($getOIEDescription as $description) {
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
                $totalMtdBudgetOIE+=(float)$budgetMonth;
                $totalYtdBudgetOIE+=(float)$budgetYear;

                
            }
             $totalMtdActualOIE+=(float)$opexMonth;
             $totalYtdActualOIE+=(float)$opexYear;
             $monthdifference=$this->calculateDiff($budgetMonth, $opexMonth);
             $monthdifferenceValue=$monthdifference['difference'];
             $monthcolor=$monthdifference['color'];
             $yeardifference=$this->calculateDiff($budgetYear, $opexYear);
             $yeardifferenceValue=$yeardifference['difference'];
             $yearcolor=$yeardifference['color'];
             array_push($otherIncomeExpenseMTD, [$description->name, $opexMonth, $budgetMonth, [$monthdifferenceValue, $monthcolor] ]);
             array_push($otherIncomeExpenseYTD, [$description->name, $opexYear, $budgetYear, [$yeardifferenceValue, $yearcolor]]);
             
        }

          $totalOIEmtdDifference=$this->calculateDiff($totalMtdBudgetOIE, $totalMtdActualOIE);
          $this->totalmtdValue=$totalOIEmtdDifference['difference'];
          $this->totalmtdColor=$totalOIEmtdDifference['color'];
          $totalOIEytdDifference=$this->calculateDiff($totalYtdBudgetOIE, $totalYtdActualOIE);
          $this->totalytdValue=$totalOIEytdDifference['difference'];
          $this->totalytdColor=$totalOIEytdDifference['color'];
         

          $this->spaOperatingExpenseMTD=$spaOperatingExpenseMTD;
          $this->spaOperatingExpenseYTD=$spaOperatingExpenseYTD;
          $this->otherIncomeExpenseMTD=$otherIncomeExpenseMTD;
          $this->otherIncomeExpenseYTD=$otherIncomeExpenseYTD;
          $this->totalMtdActualSOE=$totalMtdActualSOE;
          $this->totalMtdBudgetSOE=$totalMtdBudgetSOE;
          $this->totalYtdActualSOE=$totalYtdActualSOE;
          $this->totalYtdBudgetSOE=$totalYtdBudgetSOE;
          $this->totalMtdActualOIE=$totalMtdActualOIE;
          $this->totalMtdBudgetOIE=$totalMtdBudgetOIE;
          $this->totalYtdActualOIE=$totalYtdActualOIE;
          $this->totalYtdBudgetOIE=$totalYtdBudgetOIE;
          $this->selectedDate=$this->selectedDate->toDateString();
          $this->dispatchBrowserEvent('oodChanged');

        return view('livewire.reports.opex.ood');
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

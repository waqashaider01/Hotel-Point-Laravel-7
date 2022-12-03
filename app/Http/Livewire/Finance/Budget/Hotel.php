<?php

namespace App\Http\Livewire\Finance\Budget;

use App\Models\HotelBudget;

use Livewire\Component;

class Hotel extends Component
{
    public $key;
    public $copyvalue;
    public $month;
    public $year;
    public $type;
    public $category;
    public $subcategory;
    public $min;
    public $max;
    public $step;
    public $convert;
    public $newValue; 
    public $tempValue;
    public $isName; // determines whether to display it in bold text

    public function mount($type, $catg, $subcatg, $min, $max, $value, $month, $year, $step, $convert)
    {
        $this->newValue = $value;
        $this->tempValue=$value;
        $this->month=$month;
        $this->year=$year;
        $this->type=$type;
        $this->category=$catg;
        $this->subcategory=$subcatg;
        $this->min=$min;
        $this->max=$max;
        $this->step=$step;
        $this->convert=$convert;
        $this->init();
        
    }

    public function render()
    {
        
        return view('livewire.finance.budget.hotel');
    }

    public function save()
    {
       
       $newRecord=HotelBudget::updateOrCreate([
         'budget_year'=>$this->year,
         'type'=>$this->type,
         'category'=>$this->category,
         'sub_category'=>$this->subcategory,
         'hotel_settings_id'=>getHotelSettings()->id

       ],[
          'budget_year'=>$this->year,
           $this->month=>$this->newValue,
           'hotel_settings_id'=>getHotelSettings()->id
       ]);

       $this->init();
       $this->emitUp('setyear');
   
       
    }

    public function cancel(){
        $this->newValue=$this->tempValue;
    }

    private function init()
    {
        if ($this->convert==0) {
            $this->copyvalue=number_format((int)$this->newValue, 0, '','') ;
        }else if($this->convert==2){
            $this->copyvalue=number_format((float)$this->newValue, 2, '.','')."%";
        }else{
            $this->copyvalue=number_format((float)$this->newValue, 2, '.','') ;
        }
        $this->tempValue=$this->newValue;

    }


}

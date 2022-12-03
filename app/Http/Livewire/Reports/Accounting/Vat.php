<?php

namespace App\Http\Livewire\Reports\Accounting;
use App\Models\OpexData;
use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

use Livewire\Component;

class Vat extends Component
{
    public $chartdata;
    public $year;
    public $vatin;
    public $vatout;
    public $vatin1;
    public $vatout1;
    public $balances;

    public function mount(){
        $this->year=today()->year;
    }
    public function render()
    {
        $vatinArray=[];
        $vatOutArray=[];
        $vatin1Array=[];
        $vatout1Array=[];
        $balanceArray=[];
        for ($i=1; $i <=12 ; $i++) { 

            $plusDoctype=Document::join('document_types', 'document_types.id', '=', 'documents.document_type_id')
                                ->where('documents.hotel_settings_id', getHotelSettings()->id)
                                ->whereMonth('print_date', $i)
                                ->whereYear('print_date', $this->year)
                                ->where('debit', '+')
                                ->sum('tax');
            $minusDoctype=Document::join('document_types', 'document_types.id', '=', 'documents.document_type_id')
                                    ->where('documents.hotel_settings_id', getHotelSettings()->id)
                                    ->whereMonth('print_date', $i)
                                    ->whereYear('print_date', $this->year)
                                    ->where('debit', '-')
                                    ->sum('tax');
            $vatIn=(float)$plusDoctype-(float)$minusDoctype;
            $vatIn1=showPriceWithCurrency($vatIn);
            $vatOut=OpexData::where('hotel_settings_id', getHotelSettings()->id)->whereMonth('date', $i)->whereYear('date', $this->year)->sum('vat');
            $vatOut1=showPriceWithCurrency($vatOut);
            $balance=(float)$vatIn-(float)$vatOut;
            $balance=showPriceWithCurrency($balance);
            array_push($vatinArray, $vatIn);
            array_push($vatOutArray, $vatOut);
            array_push($balanceArray, $balance);
            array_push($vatin1Array, $vatIn1);
            array_push($vatout1Array, $vatOut1);


        }
        
        $this->vatin=$vatinArray;
        $this->vatin1=$vatin1Array;
        $this->vatout=$vatOutArray;
        $this->vatout1=$vatout1Array;
        $this->balances=$balanceArray;

        $this->dispatchBrowserEvent('vatChanged');
        return view('livewire.reports.accounting.vat');
    }

    public function set_year($year){
        $this->year=$year;
    }
}

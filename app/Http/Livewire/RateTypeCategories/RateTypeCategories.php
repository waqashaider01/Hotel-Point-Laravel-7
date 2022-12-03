<?php

namespace App\Http\Livewire\RateTypeCategories;

use Livewire\Component;
use App\Models\RateTypeCategory;

class RateTypeCategories extends Component
{
    public function render()
    {
        $rowno1 = '';
        $mymaxrowno1 = 0;
        if (isset($_GET['rownosrvs'])) {
            $rowno1 = $_GET['rownosrvs'];
            $rowno1 = (int) $rowno1;
            $mymaxrowno1 = $rowno1 + 9;
        } else {
            $rowno1 = 1;
            $mymaxrowno1 = $rowno1 + 9;
        }

        $crl1 = 0;
        $ctrl1 = 0;
        $lsr1 = 0;
        $rateTypeCategories = getHotelSettings()->rate_type_categories;
        return view('livewire.rate-type-categories.rate-type-categories',compact('rateTypeCategories'));
    }
}

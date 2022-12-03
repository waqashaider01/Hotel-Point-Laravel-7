<?php

namespace App\Http\Livewire\Reports\Housekeeping;

use Livewire\Component;

class Main extends Component
{
    public String $tab = 'daily';

    public function render()
    {
        return view('livewire.reports.housekeeping.main');
    }
}

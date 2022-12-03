<?php

namespace App\Http\Livewire\Reports\Opex;

use Livewire\Component;

class Main extends Component
{
    public String $tab="fb";
    
    public function render()
    {
        return view('livewire.reports.opex.main');
    }
}

<?php

namespace App\Http\Livewire\Reports\Kpi;

use Livewire\Component;

class Main extends Component
{
    public String $tab = 'adr';
    public function render()
    {
        return view('livewire.reports.kpi.main');
    }
}

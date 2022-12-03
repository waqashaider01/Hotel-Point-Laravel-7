<?php

namespace App\Http\Livewire\Reports\Roomdivision;

use Livewire\Component;

class Main extends Component
{
    public string $tab="arrival";
    public function render()
    {
        return view('livewire.reports.roomdivision.main');
    }
}

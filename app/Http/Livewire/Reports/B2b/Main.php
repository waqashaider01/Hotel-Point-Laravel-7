<?php

namespace App\Http\Livewire\Reports\B2b;

use Livewire\Component;

class Main extends Component
{
    public String $tab = 'commission';
    public function render()
    {
        return view('livewire.reports.b2b.main');
    }
}

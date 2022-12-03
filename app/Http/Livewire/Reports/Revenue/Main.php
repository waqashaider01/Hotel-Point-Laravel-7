<?php

namespace App\Http\Livewire\Reports\Revenue;

use Livewire\Component;

class Main extends Component
{
    public String $tab = 'channel';

    public function render()
    {
        return view('livewire.reports.revenue.main');
    }
}

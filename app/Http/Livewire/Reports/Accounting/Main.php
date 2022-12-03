<?php

namespace App\Http\Livewire\Reports\Accounting;

use Livewire\Component;

class Main extends Component
{
    public string $tab="vat";
    public function render()
    {
        return view('livewire.reports.accounting.main');
    }
}

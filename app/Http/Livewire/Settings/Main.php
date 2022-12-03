<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;

class Main extends Component
{
    public String $tab = 'general';

    public function render()
    {
        return view('livewire.settings.main');
    }
}

<?php

namespace App\Http\Livewire\Settings;

use App\Models\RateTypeCancellationPolicy;
use Illuminate\Support\Collection;
use Livewire\Component;

class Cancel extends Component
{
    public RateTypeCancellationPolicy $selected_policy;
    protected array $rules = [
        'selected_policy.amount' => 'required',
        'selected_policy.charge_days' => 'required'
    ];

    public function setPolicy(RateTypeCancellationPolicy $policy)
    {
        $this->selected_policy = $policy;
    }
    public function savePolicy()
    {
        $this->validate();
        $this->selected_policy->save();
        $this->emit('dataSaved','Cancellation Policy Saved');
    }

    public function render()
    {
        return view('livewire.settings.cancel')->with([
            'policies' => RateTypeCancellationPolicy::all()
        ]);
    }
}

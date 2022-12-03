<?php

namespace App\Http\Livewire;

use App\Models\HotelSetting;
use Illuminate\Validation\Rule;
use Livewire\Component;

class HotelSwitcher extends Component
{
    public $selectable_hotels = [];
    public $selected_hotel;

    public function mount()
    {
        $this->selected_hotel = getHotelSettings()->id;

        /**
         * @var App\Models\User
         */
        $user = auth()->user();

        if($user->hasRole('Super Admin')){
            $this->selectable_hotels = HotelSetting::with(['owner'])
                                                        ->orderBy('name')
                                                        ->get(['id', 'created_by_id', 'logo', 'name']);
        } else {
            $this->selectable_hotels = $user->connected_hotels()->with(['owner'])
                                                        ->orderBy('name')
                                                        ->get(['id', 'created_by_id', 'logo', 'name']);
        }
    }

    public function updatingSelectedHotel($value)
    {
        $this->validateOnly('selected_hotel', [
            'selectable_hotels' => ['required', 'numeric', Rule::in(collect($this->selectable_hotels)->pluck('id')->toArray())]
        ]);
        session()->put('selected_hotel', $value);

        if(str_contains(request()->header("REFERER"), 'hotel-settings')){
            return $this->redirect(route('hotel-settings', $value));
        }
        $this->redirect(request()->header("REFERER"));
    }

    public function render()
    {
        return view('livewire.hotel-switcher');
    }
}

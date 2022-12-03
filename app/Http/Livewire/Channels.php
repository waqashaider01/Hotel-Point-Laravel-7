<?php

namespace App\Http\Livewire;

use App\Models\BookingAgency;
use App\Models\Channel;
use App\Models\Country;
use App\Models\PaymentMethod;
use App\Models\PaymentMode;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class Channels extends Component
{
    public $countries;
    public $payment_modes;
    public $payment_methods;
    public $editing_channel;
    public BookingAgency $selected_channel;
    public BookingAgency $potentialDelete;
    public $has_vc_card = "no";
    protected $listeners = ['deleteItem'];

    protected function getRules()
    {
        return [
            'selected_channel.name' => 'required',
            'selected_channel.channel_code' => 'required',
            'selected_channel.vat_number' => 'required|integer',
            'selected_channel.activity' => 'required',
            'selected_channel.tax_office' => 'required',
            'selected_channel.address' => 'required',
            'selected_channel.country' => 'required',
            'selected_channel.default_payment_mode_id' => 'required',
            'selected_channel.default_payment_method_id' => 'required',
            'selected_channel.category' => 'required',
            'selected_channel.headquarters' => 'required',
            'selected_channel.postal_code' => 'required',
            'selected_channel.supports_virtual_card' => 'required',
            'selected_channel.phone_number' => 'required',
            'selected_channel.charge_mode' => 'required_if:selected_channel.supports_virtual_card,yes',
            'selected_channel.charge_date_days' => '',
            'selected_channel.virtual_card_payment_mode_id' => 'required_if:selected_channel.supports_virtual_card,yes',
            'selected_channel.channex_channel_id' => 'required'
        ];
    }

    public function mount()
    {
        $this->countries = Country::all();
       $this->payment_modes = getHotelSettings()->payment_modes;
        $this->payment_methods = getHotelSettings()->payment_methods;
    }

    public function render()
    {
        return view('livewire.channels')->with([
            'channels' => getHotelSettings()->booking_agencies
        ]);
    }

    function setChannel(BookingAgency $channel)
    {
        $this->editing_channel = true;
        $this->selected_channel = $channel;
        if($this->selected_channel->supports_virtual_card == "yes") {
            $this->has_vc_card = "yes";
        }else {
            $this->has_vc_card = "no";
        }
        //clear all errors
        $this->resetErrorBag();
    }

    function newChannel()
    {
        $this->editing_channel = false;
        $this->has_vc_card = "no";
        $this->selected_channel = new BookingAgency();
    }

    function saveChannel()
    {
        $this->selected_channel->hotel_settings_id = getHotelSettings()->id;
        if(!$this->selected_channel->bg){
            $this->selected_channel->bg = getHotelSettings()->logo;
        }
        if($this->has_vc_card == "yes") {
            $this->selected_channel->supports_virtual_card = "yes";
        } else {
            $this->selected_channel->supports_virtual_card = "no";
            $this->selected_channel->charge_mode = null;
            $this->selected_channel->charge_date_days = null;
        }
        $this->validate();
        if(is_null($this->selected_channel->oxygen_id)){
            create_oxygen_company($this->selected_channel, 'channel');
        }
        $this->selected_channel->save();
        $this->emit('closeModal');
        $this->emit('dataSaved','Channel saved');
        return redirect(request()->header('Referer'));
    }

    function deleteChannel(BookingAgency $channel)
    {
        $this->potentialDelete = $channel;
        $this->emit('confirmDelete');

    }
    public function deleteItem()
    {
        $this->potentialDelete->delete();
        return redirect(request()->header('Referer'));
    }

    function resetModal()
    {
        $this->reset('first_name', 'last_name', 'country', 'address', 'email', 'phone', 'selected_channel');
    }
}

<?php

namespace App\Http\Livewire\Settings;

use App\Models\BookingAgency;
use App\Models\Currency;
use App\Models\HotelSetting;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;

class General extends Component
{
    use WithFileUploads;

    public HotelSetting $setting;
    public BookingAgency $agency;
    public $cashier_pass;
    public $logo;
    public $bg;

    protected array $rules = [
        'setting.name' => 'required|string|min:6',
        'setting.brand_name' => 'required|string',
        'setting.activity' => 'required|string',
        'setting.tax_id' => 'required|string',
        'setting.tax_office' => 'required|string',
        'setting.general_commercial_register' => 'required|string',
        'setting.address' => 'required|string',
        'setting.postal_code' => 'required|numeric',
        'setting.city' => 'required|string',
        'setting.phone' => 'required|string',
        'setting.website' => 'required|string',
        'setting.currency_id' => 'required|numeric',
        'setting.date' => 'required|date',
        'setting.complimentary_rate' => 'required',
        'cashier_pass' => ['nullable']
    ];

    public function mount()
    {
        $this->setting = getHotelSettings();
        $this->setting->complimentary_rate = number_format($this->setting->complimentary_rate, 2);
        $this->agency = $this->setting->booking_agencies()->where('channel_code', 'OSA')->first() ?? new BookingAgency(['bg' => config('app.url') . "/images/logo/logo.png"]);
        if(!$this->agency->name){
            session()->flash('error', "No booking engine agency available, please create one!\nYour background will no be saved!");
        }
    }

    public function saveSettings()
    {
        $this->validate();
        if (is_object($this->logo)) {
            $filename = 'logo-' . time() . '.' . $this->logo->getClientOriginalExtension();
            $this->logo->storeAs('uploads', $filename, 'public');
            $this->setting->logo = asset('storage/uploads/' . $filename);
        }
        if (is_object($this->bg)) {
            $filename = 'bg-' . time() . '.' . $this->bg->getClientOriginalExtension();
            if ($this->agency->name) {
                $this->bg->storeAs('uploads', $filename, 'public');
                $this->agency->bg = 'storage/uploads/' . $filename;
            }

        }
        if($this->setting->cashier_pass){
            $this->setting->cashier_pass = bcrypt($this->cashier_pass);
        }
        $this->agency->save();
        $this->setting->save();
        $this->emit('dataSaved', 'Hotel Settings Saved');
        return redirect()->to('/hotel-settings');
    }

    public function render()
    {
        return view('livewire.settings.general')->with([
            'currencies' => Currency::all()
        ]);
    }
    public function updatedLogo()
    {
        $this->validate([
            'logo' => 'image|max:1024', // 1MB Max
        ]);
    }
    public function updatedBg()
    {
        $this->validate([
            'bg' => 'image|max:1024', // 1MB Max
        ]);
    }
}

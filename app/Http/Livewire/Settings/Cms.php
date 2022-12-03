<?php

namespace App\Http\Livewire\Settings;

use App\Models\HotelSetting;
use App\Models\Property;
use App\Models\VatOption;
use App\Services\OxygenService;
use App\Models\RoomType;
use App\Models\Restriction;
use App\Models\Availability;
use App\Models\Room;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Jobs\FullSync;
use Livewire\Component;

class Cms extends Component
{
    public HotelSetting $cms;
    public $properties;
    public $name = '';
    public $property_id = '';
    public $hotel_id = '';
    public $_id = '';
    public $status = 0;
    public $oxygen_api_key = '';

    protected array $rules = [
        'cms.property_id' => 'required',
        'property_id' => 'required',
        '_id' => 'required',
    ];
    protected $listeners = ['activateProperty', 'editProperty','removeProperty'];

    public function mount()
    {
        $this->cms = getHotelSettings();
        $this->oxygen_api_key = $this->cms->oxygen_api_key;
        $this->hotel_id = $this->cms->id;
        $this->properties = Property::where('hotel_id', $this->cms->id)->get();
    }

    public function render()
    {
        return view('livewire.settings.cms');
    }

    public function saveCMS()
    {
        $this->validate();
        $this->cms->save();
        $this->emit('dataSaved', 'Channel Manager saved');
    }

    public function editPropertyStore()
    {
        Property::find($this->_id)->update([
            'name' => $this->name,
            'property_id' => $this->property_id
        ]);
        $this->emit('dataSaved', 'Channel Manager created');
        $this->reset('property_id', 'name', '_id');
        return redirect()->to('/hotel-settings');
    }

    public function editOxygenApiKeyStore()
    {
        $this->validateOnly('oxygen_api_key', [
            'oxygen_api_key' => ['string', 'min:1', 'max:255'],
        ]);

        $this->cms->update(['oxygen_api_key' => $this->oxygen_api_key]);
        if ($this->oxygen_api_key) {
            $this->addVatOxygen();
        }
        

        $this->emit('success', "Oxygen API key has been updated successfully!");
        $this->reset('oxygen_api_key');
        return redirect()->to('/hotel-settings');

    }

    public function saveNewProperty()
    {

        $validatedData = $this->validate();
        Property::create($validatedData);
        $this->emit('dataSaved', 'Channel Manager created');
        $this->reset('property_id', 'name');
        return redirect()->to('/hotel-settings');
    }


    public function activateProperty($id)
    {
        $property = Property::find($id);
        $properties = $this->cms->properties()->where('status', 1)->get();
        foreach ($properties as $val) {
            $val->update(['status' => 0]);
        }
        if ($property)
            $property->update(['status' => 1]);
        $this->emit('dataSaved', 'Status Updated Successfully');
        return redirect()->to('/hotel-settings');
    }

    public function editProperty(Property $property)
    {
        $this->_id = $property->id;
        $this->name = $property->name;
        $this->property_id = $property->property_id;
        $this->emit('openModel');
    }

    public function removeProperty(Property $property)
    {
        $property->delete();
        return redirect()->to('/hotel-settings');
    }
    protected function rules()
    {
        return [
            'property_id' => 'required',
            'name' => 'required',
            'hotel_id' => 'required',
            'status' => 'required'
        ];
    }

    public function addVatOxygen(){
        $vatOptions=getHotelSettings()->all_vat;
        $oxygenservice=new OxygenService;
        $getAllVat=$oxygenservice->getTaxes()->json();
        foreach ($vatOptions as $vat) {
                $oxygenid="";
                foreach ($getAllVat["data"] as $tax) {
                    if ((int) $tax["rate"] == (int)$vat->vat_option->value ) {
                        $oxygenid = $tax["id"];
                        break;
                    }
                }
                if ($oxygenid) {
                    $vat->oxygen_id=$oxygenid;
                    $vat->save();
                }else{
                    $tax = [
                        'title' => $vat->value.'% Vat',
                        'mydata_vat_code' =>$vat->id
                    ];
                    $oxygenid=$oxygenservice->createTax($tax);
                    $vat->oxygen_id=$oxygenid;
                    $vat->save();
                }
               
        }

        createOxygenDocumentRow();
        syncOxygenApiPaymentMethods();
  }

  public function full_sync(){
    $job=new FullSync;
    $job=$job->sync_property();
    if ($job) {
        $this->emit('error', 'Could not sync all room types');
    }else{
        $this->emit('dataSaved', 'Room types synced successfully');
    }
    
  }
}

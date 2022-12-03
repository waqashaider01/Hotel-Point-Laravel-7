<?php

namespace App\Http\Livewire\Settings;

use App\Models\ExtraCharge;
use App\Models\ExtraChargesCategory;
use App\Models\ExtraChargesType;
use Livewire\Component;

class ServiceSettings extends Component
{
    public ExtraCharge $selected_service;
    public ExtraChargesCategory $selected_category;
    public array $rules = [
        'selected_service.product' => 'required',
        'selected_service.vat' => 'required',
        'selected_service.unit_price' => 'required',
        'selected_service.extra_charge_category_id' => 'required',
        'selected_service.extra_charge_type_id' => 'required',
        'selected_category.name' => 'required',
    ];

    public function render()
    {
        return view('livewire.settings.service-settings')->with([
            'services' => getHotelSettings()->extra_charges,
            'service_types' => ExtraChargesType::all(),
            'service_categories' => getHotelSettings()->extra_charges_categories,
        ]);
    }

    public function changeStatus($service_id)
    {
        $service = ExtraCharge::find($service_id);
        $service->status = ($service->status == 'Enabled' ? 'Disabled' : 'Enabled');
        $service->save();
        $this->emit('dataSaved', 'Service status changed successfully');
        return redirect(request()->header('Referer'));
    }

    public function setService($service_id = null)
    {
        if ($service_id) {
            $this->selected_service = ExtraCharge::find($service_id);
        } else {
            $this->selected_service = new ExtraCharge();
            $this->selected_service->hotel_settings_id = getHotelSettings()->id;
        }
    }

    public function setCategory($cat_id = null)
    {
        if ($cat_id) {
            $this->selected_category = ExtraChargesCategory::find($cat_id);
        } else {
            $this->selected_category = new ExtraChargesCategory();
            $this->selected_category->hotel_settings_id = getHotelSettings()->id;
        }
    }

    public function saveService()
    {
        $this->validate([
            'selected_service.product' => 'required',
            'selected_service.vat' => 'required',
            'selected_service.unit_price' => 'required',
            'selected_service.extra_charge_category_id' => 'required',
            'selected_service.extra_charge_type_id' => 'required',
        ]);
        $this->selected_service->status = 'Enabled';
        $this->selected_service->hotel_settings_id=getHotelSettings()->id;
        $this->selected_service->save();
        $this->emit('dataSaved', 'Service added successfully');
        return redirect(request()->header('Referer'));
    }

    public function saveServiceCategory()
    {
        $this->validate([
            'selected_category.name' => 'required'
        ]);
        $this->selected_category->hotel_settings_id=getHotelSettings()->id;
        $this->selected_category->save();
        $this->emit('dataSaved', 'Service Category added successfully');
        return redirect(request()->header('Referer'));
    }

}

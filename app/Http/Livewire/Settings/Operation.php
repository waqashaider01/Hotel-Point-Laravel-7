<?php

namespace App\Http\Livewire\Settings;

use App\Models\HotelSetting;
use App\Models\Template as ModelsTemplate;
use Illuminate\Validation\Validator;
use Livewire\Component;

class Operation extends Component
{
    public string $template_name="";
    public string $template_content="";
    public HotelSetting $operation;
    protected array $rules = [
        'operation.ordered_checkin_hour' => 'required',
        'operation.ordered_checkout_hour' => 'required',
        'operation.housekeeping' => '',
    ];

    public function mount()
    {
        $this->operation = getHotelSettings();
    }

    public function render()
    {
        return view('livewire.settings.operation');
    }

    public function saveOperation()
    {
        $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                $this->emit('initQuill', "#template", $this->template_content);
            });
        })->validate([
            'operation.ordered_checkin_hour' => 'required',
            'operation.ordered_checkout_hour' => 'required',
        ]);

        $this->operation->save();
        $this->emit('showSwal', 'Success', "Operation Information saved successfully!", 'success');
    }

    public function saveTemplate()
    {
        $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                $this->emit('initQuill', "#template", $this->template_content);
            });
        })->validate([
            'template_name' => 'required|unique:templates,name', 
            'template_content' => 'required',
        ]);

        ModelsTemplate::create([
            'hotel_settings_id' => $this->operation->id,
            'name' => $this->template_name,
            'template' => $this->template_content,
            'type' => 'checkin'
        ]);
        $this->emit('showSwal', 'Success', "Template saved successfully!", 'success');
    }
}

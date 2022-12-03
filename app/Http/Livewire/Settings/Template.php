<?php

namespace App\Http\Livewire\Settings;

use App\Models\HotelSetting;
use App\Models\Template as ModelsTemplate;
use Illuminate\Support\Collection;
use Illuminate\Validation\Validator;
use Livewire\Component;

class Template extends Component
{
    public string $type = "";
    public string $select_template = "";
    public ModelsTemplate $selected_template;
    public Collection $templates;
    public HotelSetting $hotel;

    // protected array $rules = [
    //     'selected_template.name' => 'required',
    //     'selected_template.template' => 'required',
    // ];

    public function rules(){
        $temp_id = 0;
        if(isset($this->selected_template)){
            $temp_id = $this->selected_template->id;
        }
        return [
            'selected_template.name' => "required|unique:templates,name,".$temp_id,
            'selected_template.template' => 'required',
        ];
    }

    protected $listeners = ['deleteItem'];

    public function mount()
    {
        $this->hotel = getHotelSettings();
        $this->templates = collect();
    }

    public function render()
    {
        return view('livewire.settings.template');
    }

    public function updatedType()
    {
        $this->templates = ModelsTemplate::where('type', $this->type)->where('hotel_settings_id', $this->hotel->id)->get();
        $this->emit('initQuillReadOnly', "#template");
        $this->select_template = '';
    }

    public function updatedSelectTemplate()
    {
        $this->selected_template = ModelsTemplate::find($this->select_template);
        $this->emit('initQuill', "#template", $this->selected_template->template);
    }

    public function saveTemplate()
    {
        $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                $this->emit('initQuill', "#template", $this->selected_template->template ?? '');
            });
        })->validate();

        $this->selected_template->save();
        $this->templates = ModelsTemplate::where('type', $this->type)->get();
        $this->emit('showSwal', 'Success', 'Template has been saved!', 'success');
    }

    public function deleteTemplate()
    {
        $this->emit('confirmDelete');
        $this->emit('initQuill', "#template", $this->selected_template->template);
    }

    public function deleteItem()
    {
        if (isset($this->selected_template)) {
            $this->selected_template->delete();
            $this->selected_template = new ModelsTemplate();
            $this->templates = ModelsTemplate::where('type', $this->type)->get();
            $this->emit('showSwal', 'Success', 'Template has been deleted!', 'success');
        } else{
            $this->emit('showWarning','No Template Selected');
        }
        $this->emit('initQuillReadOnly', "#template");
    }
}

<?php

namespace App\Http\Livewire\Settings;

use App\Models\HotelSetting;
use Illuminate\Validation\Validator;
use Livewire\Component;

class Email extends Component
{
    public string $template_name="";
    public string $template_content="";
    public HotelSetting $email;
    protected array $rules = [
        'email.email' => 'required|email',
        'email.notification_receiver_email' => 'required|email',
    ];

    public function mount()
    {
        $this->email = getHotelSettings();
    }

    public function render()
    {
        return view('livewire.settings.email');
    }

    public function saveEmail()
    {
        $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                $this->emit('initQuill', "#template", $this->template_content);
            });
        })->validate([
            'email.email' => 'required|email',
            'email.notification_receiver_email' => 'required|email',
        ]);

        $this->email->save();
        $this->emit('dataSaved','Email changes saved');
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

        \App\Models\Template::create([
            'hotel_settings_id' => $this->email->id,
            'name' => $this->template_name,
            'template' => $this->template_content,
            'type' => 'email'
        ]);

        $this->emit('showSwal', 'Success', "Email template saved successfully!", 'success');
    }
}

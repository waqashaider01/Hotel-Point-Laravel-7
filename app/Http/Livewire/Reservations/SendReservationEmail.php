<?php

namespace App\Http\Livewire\Reservations;

use App\Mail\NotifyReservationGuest;
use App\Models\Reservation;
use App\Models\Template;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;

class SendReservationEmail extends Component
{
    use withFileUploads;

    public $reservation, $templates;
    public string $selected_template = '';
    public string $email_body = '';
    public string $guest_email = '';
    public $attachment = [];
    public $attachments = [];
    public string $email_subject = '';

    public function mount(Reservation $reservation)
    {
        $this->guest_email = $reservation->guest->email;
        $this->reservation = $reservation;
        $this->templates = Template::email()->get();
    }

    public function render()
    {
        return view('livewire.reservations.send-reservation-email');
    }

    public function updatedSelectedTemplate()
    {
        $this->email_body = $this->templates->where('id', $this->selected_template)->first()->fillTemplateContentBody($this->reservation->id);
    }

    public function updatedAttachment()
    {
        $this->validate([
            'attachment' => 'max:2048' //max 2mb file
        ]);
        $this->attachments += $this->attachment;
    }

    public function sendEmail()
    {
        $this->validate([
            'selected_template' => ['required', 'exists:templates,id'],
            'email_subject' => ['required', 'string', 'min:3'],
            'guest_email' => ['required', 'email'],
        ]);

        $file_paths = [];
        $index = 0;
        foreach ($this->attachments as $attachment) {
            $filename = 'email_attachment-' . $index . '-' . time() . '.' . $attachment->getClientOriginalExtension();
            $path = $attachment->storeAs('uploads', $filename, 'public');
            $file_paths[] = 'public/'.$path;
            $index++;
        }
        Mail::to($this->guest_email)->send(new NotifyReservationGuest($this->email_subject, $this->email_body, $file_paths));

        $this->reset('selected_template', 'guest_email', 'attachment', 'attachments', 'email_subject', 'email_body');
        $this->emit('closeModal');
        $this->emit('emailSent', "Email Sent successfully!");
    }
}

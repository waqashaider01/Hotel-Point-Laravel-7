<?php

namespace App\Http\Livewire\Home;

use App\Models\HotelSetting;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Notification extends Component
{
    public HotelSetting $hotel;
    public Collection $notificationBookings;
    public int $notification_count;

    public function mount()
    {
        $this->hotel = getHotelSettings();

        $query = $this->hotel->reservations()
            ->with("room", "booking_agency", "rate_type")
            ->select("reservations.*")
            ->join('rate_types', 'reservations.rate_type_id', '=', 'rate_types.id')
            ->join('booking_agencies', 'reservations.booking_agency_id', '=', 'booking_agencies.id')
            ->where("booking_agencies.channel_code", "!=", "CBE")
            ->where(function($q) {
                $q->where('reservations.notif_status', '0');
                $q->orWhereNull('reservations.notif_status');
            });

        $this->notificationBookings = $query->latest()
            ->limit(5)
            ->get();
        $this->notification_count = $query->count();
    }

    public function render()
    {
       return view('livewire.home.notification');
    }

    public function updateNotification($id) {
        getHotelSettings()->reservations()->find($id)->update([
            "notif_status" => "1"
        ]);
        return redirect("/edit-reservation/$id");
    }
}

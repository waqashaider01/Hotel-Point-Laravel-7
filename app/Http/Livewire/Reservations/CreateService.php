<?php

namespace App\Http\Livewire\Reservations;

use App\Models\ExtraCharge;
use App\Models\ExtraChargesCategory;
use App\Models\ExtraChargesType;
use App\Models\Guest;
use App\Models\PaymentMethod;
use App\Models\Reservation;
use App\Models\ReservationExtraCharge;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateService extends Component
{
    public Reservation $reservation;
    public Guest $guest;
    public Collection $categories;
    public Collection $types;
    public Collection $methods;
    public string $category = '';
    public string $type = '';
    public string $invoice_number = '';
    public string $balance = '';
    public string $card_payment = '';
    public float $total = 0;
    public float $discount = 0;
    public float $calculated_discount = 0;
    public float $grand_total = 0;
    public string $type_name;
    public array $selected_services = [];

    public function render()
    {
        $data = [
            'services' => $this->getServices()
        ];
        $this->total = 0;
        foreach ($this->selected_services as $service) {
            $this->total += $service['price'] * $service['count'];
        }
        $this->calculated_discount = ($this->total * $this->discount) / 100.0;
        $this->grand_total = $this->total - $this->calculated_discount;
        return view('livewire.reservations.create-service')->with($data);
    }

    public function mount($r_id,$receipt_number)
    {
        $this->reservation = Reservation::find($r_id);
        $this->methods = getHotelSettings()->payment_methods()->where('is_card_type', 1)->get();
        $this->guest = $this->reservation->checkin_guest ?? $this->reservation->guest;
        $this->categories = getHotelSettings()->extra_charges_categories;
        $this->types = getHotelSettings()->extra_charges_types;
        $this->balance = getStatusesAndValues($r_id)['extras_paid'];
//       If  Editing
        if($receipt_number){
            $this->invoice_number = $receipt_number;
            $extras = ReservationExtraCharge::where('receipt_number', $receipt_number)->get();
            foreach ($extras as $extra){
                $service = ExtraCharge::find($extra->extra_charge_id);
                $this->category = $service->extra_charge_category_id;
                $this->type = $service->extra_charge_type_id;
                $data = [];
                $data['id'] = $extra->extra_charge_id;
                $data['name'] = $service->product;
                $data['price'] = $service->unit_price;
                $data['count'] = $extra->units;
                $this->selected_services[$extra->extra_charge_id] = $data;
            }
        }
    }

    public function addService($id)
    {
        if (array_key_exists($id, $this->selected_services)) {
            $this->selected_services[$id]['count'] += 1;
        } else {
            $service = ExtraCharge::find($id);
            $data = [];
            $data['id'] = $id;
            $data['name'] = $service->product;
            $data['price'] = $service->unit_price;
            $data['count'] = 1;
            $this->selected_services[$id] = $data;
        }
    }

    public function removeItem($id)
    {
        if ($this->selected_services[$id]['count'] > 1) {
            $this->selected_services[$id]['count'] -= 1;
        } else {
            unset($this->selected_services[$id]);
        }
    }

    public function addItem($id)
    {
        if (array_key_exists($id, $this->selected_services)) {
            $this->selected_services[$id]['count'] += 1;
        }
    }

    private function getServices()
    {
        $services = collect();
        if ($this->category && $this->category != '' && $this->type && $this->type != '') {
            $services = ExtraCharge::query()->where('extra_charge_category_id', $this->category)
                ->where('extra_charge_type_id', $this->type)->get();
            $this->type_name = $this->types->where('id', $this->type)->first()->name;
        }
        return $services;
    }

    public function addDiscount()
    {
        $this->validate([
            'discount' => 'required|numeric|min:0|max:100'
        ]);
        $this->emit('dataSaved', 'Discount Applied');
    }

    public function setPayment()
    {
        $this->validate([
            'invoice_number' => 'required|numeric'
        ]);
        $this->emit('showPaymentModal');
    }

    public function makePayment($method, $is_card = false)
    {
        if ($method == 'room_charge') {
            foreach ($this->selected_services as $service) {
                $this->reservation->reservation_extra_charges()->updateOrCreate([
                    'receipt_number' => $this->invoice_number,
                    'extra_charge_id' => $service['id'],
                ], [
                    'units' => $service['count'],
                    'extra_charge_total' => $service['price'] * $service['count'],
                    'date' => today()->toDateString(),
                    'time' => now()->toTimeString(),
                    'extra_charge_discount' => ($service['price'] * $service['count'] * $this->discount)/100,
                    'is_paid' => 0,
                ]);
            }
        }
        else{
            foreach ($this->selected_services as $service) {
                $this->reservation->reservation_extra_charges()->updateOrCreate([
                    'receipt_number' => $this->invoice_number,
                    'extra_charge_id' => $service['id'],
                ], [
                    'units' => $service['count'],
                    'extra_charge_total' => $service['price'] * $service['count'],
                    'receipt_number' => $this->invoice_number,
                    'date' => today()->toDateString(),
                    'time' => now()->toTimeString(),
                    'extra_charge_discount' => ($service['price'] * $service['count'] * $this->discount)/100,
                    'is_paid' => 1,
                    'extra_charge_id' => $service['id'],
                    'payment_method_id' => ($method == 'cash') ? 1 : $this->card_payment,
                ]);
            }
            $this->reservation->guest_extras_payments()->create([
                'value' => $this->grand_total,
                'payment_method_id' => ($method == 'cash') ? 1 : $this->card_payment,
                'date' => today()->toDateString(),
                'comments' => 'Added from create service',
            ]);
        }
        $this->emit('dataSaved', 'Extras added successfully');
        $this->redirect(route('home'));
    }

    public function updatedCardPayment()
    {
        $this->makePayment($this->card_payment, true);
    }
}

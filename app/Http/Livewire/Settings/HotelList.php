<?php

namespace App\Http\Livewire\Settings;

use App\Models\Currency;
use App\Models\HotelSetting;
use App\Models\Property;
use App\Models\User;
use App\Models\HotelTaxCategory;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HotelList extends Component
{
    protected $listeners = [
        "deleteItem" => "delete_hotel",
        'refreshComponent' => '$refresh',
    ];
    public $hotels = [];
    public $users = [];
    public $hotel = [];
    public $selected_hotel_for_delete;

    public function mount()
    {
        /**
         * @var App\Models\User
         */
        $user = auth()->user();

        if($user->hasRole('Super Admin')){
            $this->hotels = HotelSetting::with(['owner'])
                                                        ->orderBy('name')
                                                        ->get();


        $this->users = User::doesntHave('roles')->where('role', 'Administrator')->get();
        } else if($user->role == 'Administrator'){
            $this->hotels = HotelSetting::with(['owner'])
                                                        ->where('created_by_id', $user->id)
                                                        ->orderBy('name')
                                                        ->get();
        } else {
            $this->hotels = HotelSetting::with(['owner'])
                                                        ->where('created_by_id', $user->created_by_id->id)
                                                        ->orderBy('name')
                                                        ->get();
        }
    }

    public function saveHotel()
    {
        $this->validate([
            'hotel.user' => ['required', 'numeric', 'exists:users,id'],
            'hotel.name' => ['required', 'string', 'min:3', 'max:125'],
            'hotel.channex_id' => ['required', 'string', 'min:3', 'max:255'],
        ]);
        try {
            DB::beginTransaction();

            /**
             * @var \App\Models\HotelSetting
             */
            $new_hotel = HotelSetting::create([
                'logo' => asset('images/logo/logo.png'),
                'created_by_id' => $this->hotel['user'],
                'name' => $this->hotel['name'],
                'brand_name' => 'Test Brand',
                'activity' => 'Test Activity',
                'tax_id' => 123455,
                'tax_office' => 'Islamabad',
                'general_commercial_register' => 4321,
                'address' => 'test address',
                'postal_code' => 1234,
                'city' => 'Quetta',
                'phone' => '123456789123',
                'website' => 'test.com',
                'email' => 'test@test.com',
                'notification_receiver_email' => 'test@test.com',
                'vat_id' => NULL,
                'city_tax' => 5.00,
                'cancellation_vat_id' => NULL,
                'overnight_tax_id' =>NULL ,
                'cookie_value' => 'none yet',
                'ordered_checkin_hour' => date('H:m:s'),
                'ordered_checkout_hour' => date('H:m:s'),
                'housekeeping' => 1,
                'currency_id' => Currency::where('initials', "EUR")->first()->id,
                'date' => date('Y-m-d'),
                'cashier_pass' => '123456',
                'complimentary_rate' => '5',
                'bank_name' => 'ABC',
                'swift_code' => '32421',
                'iban' => 'aej33r4',
                'overnight_tax_id'=>HotelTaxCategory::first()->id,
                'bank_status' => 1,
            ]);

            $new_property = Property::create([
                'hotel_id' => $new_hotel->id,
                'name' => 'Channex',
                'property_id' => $this->hotel['channex_id'],
                'status' => 1
            ]);

            $new_hotel->connected_users()->attach($this->hotel['user']);

            $new_hotel->generate_payment_modes();
            // $new_hotel->generate_payment_methods();
            $new_hotel->generate_document_types();
            $new_hotel->generate_rate_type_cancellation_policies();
            $new_hotel->generate_hotel_vat();


            DB::commit();
            session()->flash('success', 'New Hotel Created!');
            return redirect()->route('hotels.index');
        } catch (\Exception $e){
            $this->emit('showError', $e->getMessage());
        }
    }

    function confirm_delete_hotel(HotelSetting $hotel){
        if(HotelSetting::count() <= 1){
            $this->selected_hotel_for_delete = null;
            $this->emit('showWarning', "You cannot delete the last hotel!");
            return;
        }

        $this->emit('confirmDelete');
        $this->selected_hotel_for_delete = $hotel;
    }

    function delete_hotel()
    {
        try{
            DB::beginTransaction();
            $this->selected_hotel_for_delete->properties()->delete();
            $this->selected_hotel_for_delete->reservations()->delete();
            $this->selected_hotel_for_delete->ex_reservations()->delete();
            $this->selected_hotel_for_delete->room_types()->delete();
            $this->selected_hotel_for_delete->rate_types()->delete();
            $this->selected_hotel_for_delete->document_types()->delete();
            $this->selected_hotel_for_delete->payment_modes()->delete();
            $this->selected_hotel_for_delete->payment_methods()->delete();
            $this->selected_hotel_for_delete->extra_charges()->delete();
            $this->selected_hotel_for_delete->extra_charges_types()->delete();
            $this->selected_hotel_for_delete->extra_charges_categories()->delete();
            $this->selected_hotel_for_delete->booking_agencies()->delete();
            $this->selected_hotel_for_delete->documents()->delete();
            $this->selected_hotel_for_delete->rate_type_cancellation_policies()->delete();
            $this->selected_hotel_for_delete->rate_type_categories()->delete();
            $this->selected_hotel_for_delete->companies()->delete();
            $this->selected_hotel_for_delete->guests()->delete();
            $this->selected_hotel_for_delete->cash_registers()->delete();
            $this->selected_hotel_for_delete->hotel_budgets()->delete();
            $this->selected_hotel_for_delete->opex_data()->delete();
            $this->selected_hotel_for_delete->supplier()->delete();
            $this->selected_hotel_for_delete->all_vat()->delete();
            $this->selected_hotel_for_delete->cancellation_vat_tax()->delete();
            $this->selected_hotel_for_delete->connected_users()->sync([]);
            $this->selected_hotel_for_delete->delete();

            DB::commit();
            session()->flash('success', "Hotel deleted successfully!");
            return redirect(request()->header('Referer'));
        } catch (\Exception $e) {
            $this->emit('showError', config('app.debug') ? $e->getMessage() : "The server encountered an error while trying to delete this record!");
        }
    }

    public function render()
    {
        return view('livewire.settings.hotel-list');
    }
}

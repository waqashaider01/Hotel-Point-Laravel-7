<?php

namespace App\Http\Livewire;

use App\Models\Country;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class Users extends Component
{
    protected $listeners = ["deleteItem" => "deleteUser", 'refreshComponent' => '$refresh', 'resetModalEvent' => 'resetModal'];
    public $permissions;
    public $hotel;
    public $countries;
    public $users;
    public $selected_user;
    public $first_name;
    public $last_name;
    public $country;
    public $address;
    public $email;
    public $country_code;
    public $phone;
    public $role;
    public $password;
    public $curr_password;
    public $password_confirmation;
    public $selected_permissions = [];
    public $editing_user = false;
    public $selected_for_delete_user;
    public $user_roles = [
        'Administrator',
        'Manager',
        'User',
    ];

    protected function getRules()
    {
        $phone_number = $this->country_code . $this->phone;
        if($this->editing_user && $this->selected_user){
            return [
                'first_name' => 'required',
                'last_name' => 'required',
                'country' => 'required',
                'address' => 'required',
                'email' => ['required', Rule::unique('users', 'email')->ignore($this->selected_user->id)],
                'password' => ['nullable', 'string', 'min:8', 'confirmed', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/'],
                'curr_password' => ['nullable', 'current_password'],
                'phone' => ['required', function($attribute, $value, $fail) use($phone_number){
                    $response = Http::withOptions(['verify' => !config('app.debug')])->withHeaders([
                                            "Content-Type" => "application/json",
                                            "Accept" => "application/json",
                                            "Authorization" => "Bearer ".config('services.phone_verify.key'),
                                        ])
                                        ->post(config('services.phone_verify.url'), ['to' => $phone_number]);
                    if($response->json('success') === false){
                        $fail('The entered phone number is invalid');
                    }
                }],
                'role' => ['required', 'string', Rule::in($this->user_roles)],
                'selected_permissions' => ['required', 'array', 'min:1'],
            ];
        }
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'country' => 'required',
            'address' => 'required',
            'email' => ['required', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/'],
            'curr_password' => ['nullable', 'current_password'],
            'phone' => ['required', function($attribute, $value, $fail) use($phone_number){
                $response = Http::withOptions(['verify' => !config('app.debug')])->withHeaders([
                                        "Content-Type" => "application/json",
                                        "Accept" => "application/json",
                                        "Authorization" => "Bearer ".config('services.phone_verify.key'),
                                    ])
                                    ->post(config('services.phone_verify.url'), ['to' => $phone_number]);
                if($response->json('success') === false){
                    $fail('The entered phone number is invalid');
                }
            }],
            'role' => ['required', 'string', Rule::in($this->user_roles)],
            'selected_permissions' => ['required', 'array', 'min:1'],
        ];
    }

    public function mount()
    {
        $this->countries = Country::all();
        $this->permissions = \Spatie\Permission\Models\Permission::orderBy('name')->get();
        $this->hotel = getHotelSettings();

        /**
         * @var \App\Models\User
         */
        $auth_user = auth()->user();

        if($auth_user->hasRole('Super Admin')){
            $this->users = $auth_user->created_users()->orderBy('first_name')->orderBy('last_name')->get();
        } else {
            $this->users = $this->hotel->connected_users()->orderBy('first_name')->orderBy('last_name')->get();
        }
    }

    public function render()
    {
        return view('livewire.users');
    }

    function setUser(User $user)
    {
        $this->editing_user = true;
        $this->selected_user = $user;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->country = $user->country_id;
        $this->country_code = $user->country->phone_code;
        $this->address = $user->address;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->role = $user->role;
        $this->selected_permissions = $user->permissions()->get()->map(function($permission){return $permission->id;})->toArray();
        $this->emit('showModal', '#addEditUser');
    }

    function saveUser()
    {
        $data = $this->validate();
        if ($this->editing_user) {
            $user = $this->selected_user;
        } else {
            $user = new User();
        }
        $user->created_by_id = auth()->user()->id;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->country_id = $this->country;
        $user->address = $this->address;
        if($this->editing_user && $this->email != $user->email){
            $user->email_verified_at = null;
        }
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->role = $this->role;
        if(!$this->editing_user){
            $user->password = bcrypt($this->password);
        }
        if($this->editing_user && $this->password){
            $user->password = bcrypt($this->password);
        }
        $user->save();

        if (!$this->editing_user) {
            $user->connected_hotels()->attach([$this->hotel->id]);
        }

        $user->syncPermissions($this->selected_permissions);
        $this->emit('closeModal');

        if ($this->editing_user) {
            session()->flash('success', "User updated successfully!");
        } else {
            session()->flash('success', "User created successfully!");
            event(new Registered($user));
        }

        return redirect(request()->header('Referer'));
    }

    function updatedCountry()
    {
        $this->country_code = Country::find($this->country)->phone_code;
    }

    public function selectAllPermission()
    {
        $this->selected_permissions = $this->permissions->pluck('id');
    }

    function confirmDeleteUser(User $user){
        if($user->id === auth()->user()->id){
            $this->emit('showWarning', "You cannot deleted your own record!");
            return;
        }
        $this->emit('confirmDelete');
        $this->selected_for_delete_user = $user;
    }

    function deleteUser()
    {
        try{
            $this->selected_for_delete_user->created_users()->delete();
            $this->selected_for_delete_user->connected_hotels()->detach();
            $this->selected_for_delete_user->delete();
            session()->flash('success', "User deleted successfully!");
            return redirect(request()->header('Referer'));
        } catch (\Exception $e) {
            $this->emit('showError', config('app.debug') ? $e->getMessage() : "The server encountered an error while trying to delete this record!");
        }
    }

    function resetModal()
    {
        $this->resetErrorBag();
        $this->reset('first_name', 'last_name', 'password', 'password_confirmation', 'selected_permissions', 'country', 'country_code', 'address', 'email', 'phone');
        $this->editing_user = false;
    }
}

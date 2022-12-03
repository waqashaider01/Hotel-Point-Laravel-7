<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\Country;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CompanyList extends Component
{
    public bool $editing_company = false;
    public Company $selected_company;
    public Company $potentialDelete;
    protected $listeners = ['deleteItem'];
    public Collection $companies;
    public Collection $countries;
    public Company $info_company;
    public $showModal = '';

    protected function getRules()
    {
        return [
            'selected_company.name' => 'required',
            'selected_company.activity' => 'required',
            'selected_company.vat_number' => 'required|integer',
            'selected_company.tax_office' => 'required',
            'selected_company.country_id' => 'required',
            'selected_company.address' => 'required',
            'selected_company.category' => 'required',
            'selected_company.headquarters' => 'required',
            'selected_company.email' => 'required',
            'selected_company.postal_code' => 'required',
            'selected_company.phone_number' => 'required',
            'selected_company.has_community_vat' => 'min:0|max:1',
            'selected_company.discount' => 'min:0|max:100',
        ];
    }

    public function mount()
    {
        $this->companies = getHotelSettings()->companies;
        $this->countries = Country::select('id', 'name', 'alpha_two_code')->get();
    }

    public function render()
    {
        return view('livewire.company-list');
    }

    function setCompany(Company $company)
    {
        $this->editing_company = true;
        $this->selected_company = $company;
        $this->emit('showModal', '#addEditModal', true);
        $this->showModal = 'addEditModal';

    }

    function setInfoCompany(Company $company) {
        $this->info_company = $company;
        $this->showModal = 'infoModal';
        $this->emit('showModal', '#infoModal');
    }

    function newCompany()
    {
        $this->editing_company = false;
        $this->selected_company = new Company();
        //data-toggle="modal" data-target="#addEditModal"
        $this->showModal = 'addEditModal';
        $this->emit('showModal', '#addEditModal', true);
    }

    function saveCompany()
    {
        // $validation = Validator::make($this->getDataForValidation($this->getRules()), $this->getRules());
        // if ($validation->fails()) {
        //     $errorString = '';
        //     $s = sizeof($validation->errors()->all()) > 4 ? 4 : sizeof($validation->errors()->all());
        //     for($i = 0; $i < $s; $i++) {
        //         $errorString .= $validation->errors()->all()[$i] . '<br>';
        //     }
        //     $this->emit('error', $errorString, "#addEditModal");
        //     return;
        // }
        $this->validate($this->getRules());
        $this->selected_company->hotel_settings_id = getHotelSettings()->id;
        if(is_null($this->selected_company->oxygen_id)){
            create_oxygen_company($this->selected_company, 'company');
        }
        $this->selected_company->save();
        $this->emit('hideModal', '#addEditModal');
        $this->emit('dataSaved', 'Company saved');
        $this->showModal = '';
        //refresh component

        return redirect(request()->header('Referer'));
    }

    function deleteCompany(Company $company)
    {
        $this->potentialDelete = $company;
        $this->emit('confirmDelete');
    }

    public function deleteItem()
    {
        $this->potentialDelete->delete();

        return redirect(request()->header('Referer'));
    }

    function resetModal()
    {
        $this->reset('first_name', 'last_name', 'country_id', 'address', 'email', 'phone', 'selected_company');
    }
}

<?php

namespace App\Http\Livewire\Finance\Opex;

use App\Models\Supplier;
use Livewire\Component;

class CreateEditSupplier extends Component
{
    public Supplier $selected_supplier;
    public bool $editing_supplier = false;
    public Supplier $potentialDelete;
    protected $listeners = ['deleteItem'];

    protected function getRules()
    {
        return [
            'selected_supplier.name' => 'required',
            'selected_supplier.tax_number' => 'required',
            'selected_supplier.category' => 'required',
            'selected_supplier.address' => 'required',
            'selected_supplier.email' => 'required|email',
            'selected_supplier.phone' => 'required',
        ];
    }

    public function render()
    {
        return view('livewire.finance.opex.create-edit-supplier')->with([
            'suppliers' => getHotelSettings()->supplier()->get()
        ]);
    }
    function setSupplier(Supplier $supplier)
    {
        $this->editing_supplier = true;
        $this->selected_supplier = $supplier;
    }

    function newSupplier()
    {
        $this->editing_supplier = false;
        $this->selected_supplier = new Supplier();
    }

    function saveSupplier()
    {
        $this->validate();
        $this->selected_supplier->hotel_settings_id=getHotelSettings()->id;
        $this->selected_supplier->save();
        $this->emit('dataSaved','Supplier saved');
        return redirect(request()->header('Referer'));
    }

    function deleteSupplier(Supplier $supplier)
    {
        $this->potentialDelete = $supplier;
        $this->emit('confirmDelete');

    }
    public function deleteItem()
    {
        try {
            if ($this->potentialDelete->opex->count()>0) {
                $this->emit('error', 'This supplier is associated with OPEX');
            }else{
                $this->potentialDelete->delete();
                $this->emit('success', 'Supplier deleted');
                return redirect(request()->header('Referer'));
            }
            
        } catch (\Throwable $th) {
             $this->emit('error', $th->getMessage());
        }
        
        
    }

}

<?php

namespace App\Http\Livewire\Finance\Opex;

use App\Models\Category;
use App\Models\CostOfSale;
use App\Models\Description;
use App\Models\OpexData;
use App\Models\Supplier;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;

class OpexForm extends Component
{
    use withFileUploads;

    public array $cos_array = [];
    public int $totalAmount = 0;
    public int $totalVat = 0;
    public int $cosAmount = 0;
    public int $cosVat = 0;
    public $file;
    public $date;
    public $invoice_number;
    public $invoice_type;
    public $cos;
    public $category;
    public $description;
    public $amount;
    public $vat;
    public $payment;
    public $supplier;
    public Collection $categories;
    public Collection $descriptions;

    public function mount()
    {
        $this->categories = collect();
        $this->descriptions = collect();
    }

    public function render()
    {
        return view('livewire.finance.opex.opex-form')->with([
            'suppliers' => getHotelSettings()->supplier()->get(),//Supplier::all(),
            'coses' => CostOfSale::all()
        ]);
    }

    public function save()
    {
        $this->validate([
            'cos' => 'required',
            'category' => 'required',
            'date' => 'required',
            'invoice_number' => 'required',
            'invoice_type' => 'required',
            'amount' => 'required',
            'vat' => 'required',
            'payment' => 'required',
            'file' => 'required',
            'description' => 'required',
            'supplier' => 'required',
            'cos_array.*.cos' => 'required',
            'cos_array.*.category' => 'required',
            'cos_array.*.description' => 'required',
            'cos_array.*.amount' => 'required',
            'cos_array.*.vat' => 'required',
        ], [
            'cos.required' => 'Cost of sale is required',
            'cos_array.*.cos.required' => 'Cost of sale is required',
            'cos_array.*.category.required' => 'Category is required',
            'cos_array.*.description.required' => 'Description is required',
            'cos_array.*.amount.required' => 'Amount is required',
            'cos_array.*.vat.required' => 'Vat is required',
        ]);
        $filename = '';
        if (is_object($this->file)) {
            $filename = 'opex_form-' . time() . '.' . $this->file->getClientOriginalExtension();
            $this->file->storeAs('uploads', $filename, 'public');
        }
        OpexData::create([
            'date' => $this->date,
            'invoice_number' => $this->invoice_number,
            'invoice_type' => $this->invoice_type,
            'amount' => $this->amount,
            'vat' => $this->vat,
            'payment' => $this->payment,
            'file' => $filename,
            'bill_no' => '',
            'cos_id'=>$this->cos,
            'category_id'=>$this->category,
            'description_id' => $this->description,
            'supplier_id' => $this->supplier,
            'hotel_settings_id'=>getHotelSettings()->id
        ]);
        foreach ($this->cos_array as $cos) {
            OpexData::create([
                'date' => $this->date,
                'invoice_number' => $this->invoice_number,
                'invoice_type' => $this->invoice_type,
                'amount' => $cos['amount'],
                'vat' => $cos['vat'],
                'payment' => $this->payment,
                'file' => $filename,
                'bill_no' => '',
                'cos_id'=>$cos['cos'],
                'category_id'=>$cos['category'],
                'description_id' => $cos['description'],
                'supplier_id' => $this->supplier,
                'hotel_settings_id'=>getHotelSettings()->id
            ]);
        }
        $this->emit('dataSaved', 'Opex Data Stored successfully');
        sleep(2);
        $this->redirect(route('opex-list'));
    }

    public function updatedCos()
    {
        $this->categories = Category::where('cost_of_sale_id', $this->cos)->get();
    }

    public function updatedCategory()
    {
        $this->descriptions = Description::where('category_id', $this->category)->get();
    }

    public function updatedAmount()
    {
        $this->cosAmount = (float)$this->amount;
    }

    public function updatedVat()
    {
        $this->cosVat = (float)$this->vat;
    }

    public function addCos()
    {
        if (count($this->cos_array) > 0) {
            $this->validate([
                'cos_array.*.cos' => 'required',
                'cos_array.*.category' => 'required',
                'cos_array.*.description' => 'required',
                'cos_array.*.amount' => 'required',
                'cos_array.*.vat' => 'required',
            ], [
                'cos_array.*.cos.required' => 'Cost of sale is required',
                'cos_array.*.category.required' => 'Category is required',
                'cos_array.*.description.required' => 'Description is required',
                'cos_array.*.amount.required' => 'Amount is required',
                'cos_array.*.vat.required' => 'Vat is required',
            ]);
        }
        $this->cos_array[] = [
            'cos' => null,
            'category' => null,
            'description' => null,
            'amount' => null,
            'vat' => null,
            'cats' => [],
            'desc' => [],
        ];
    }

    public function updatedCosArray($value, $name)
    {
        $attr = explode(".", $name);
        if ($attr[1] == 'cos') {
            $this->cos_array[$attr[0]]['cats'] = Category::where('cost_of_sale_id', $value)->get()->toArray();
        }
        if ($attr[1] == 'category') {
            $this->cos_array[$attr[0]]['desc'] = Description::where('category_id', $value)->get()->toArray();
        }
        if ($attr[1] == 'amount') {
            $this->totalAmount = array_sum(array_column($this->cos_array, 'amount'));
        }
        if ($attr[1] == 'vat') {
            $this->totalVat = array_sum(array_column($this->cos_array, 'vat'));
        }
    }
}

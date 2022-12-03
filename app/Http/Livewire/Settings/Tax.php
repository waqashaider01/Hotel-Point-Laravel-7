<?php

namespace App\Http\Livewire\Settings;

use App\Models\DocumentType;
use App\Models\HotelSetting;
use App\Models\HotelTaxCategory;
use App\Models\HotelVat;
use Livewire\Component;

class Tax extends Component
{
    public HotelSetting $tax;
    public DocumentType $selected_document;
    public $vat_options;
    public $overnightTaxOptions;
    protected $listeners = ['updateStatus'];

    protected array $rules = [
        'tax.vat_id' => 'required',
        'tax.city_tax' => 'required|numeric|min:0',
        'tax.cancellation_vat_id' => 'required',
        'tax.overnight_tax_id' => 'required',
        'selected_document.row' => 'required',
        'selected_document.enumeration' => 'required',
        'selected_document.initials' => 'required',
    ];

    public function mount()
    {
        $this->tax = getHotelSettings();
        // dd($this->tax);
        $this->vat_options= getHotelSettings()->all_vat()->get();
        $this->overnightTaxOptions = HotelTaxCategory::all();
        // dd($this->overnightTaxOptions);
        // $this->tax->vat_id=HotelVat::where('hotel_settings_id', $this->tax->id)->where('id', $this->tax->vat_id)->first()->vat_option_id;
        // $this->tax->cancellation_vat_id=HotelVat::where('hotel_settings_id', $this->tax->id)->where('id', $this->tax->cancellation_vat_id)->first()->vat_option_id;


    }

    public function saveTax()
    {
        $this->validate([
            'tax.vat_id' => 'required',
            'tax.city_tax' => 'required|numeric|min:0',
            'tax.cancellation_vat_id' => 'required',
            'tax.overnight_tax_id' => 'required',
        ]);
        // dd();
        // $this->tax->vat_id=HotelVat::where('hotel_settings_id', $this->tax->id)->where('vat_option_id', $this->tax->vat_id)->first()->id;
        // $this->tax->cancellation_vat_id=HotelVat::where('hotel_settings_id', $this->tax->id)->where('vat_option_id', $this->tax->cancellation_vat_id)->first()->id;
        $this->tax->save();
        $this->emit('dataSaved','Tax Saved Successfully!');
    }

    public function setDocument(DocumentType $document)
    {
        $this->selected_document = $document;
    }

    public function saveDocument()
    {
        $this->validate([
            'selected_document.row' => 'required',
            'selected_document.enumeration' => 'required',
            'selected_document.initials' => 'required',
        ]);
        $this->selected_document->save();
        createOxygenDocumentRow();
        $this->emit('dataSaved','Document Saved Successfully!');
    }

    public function render()
    {
        return view('livewire.settings.tax')->with([
            'documents' => getHotelSettings()->document_types
        ]);
    }

    public function updateStatus(DocumentType $document, $status)
    {
        $document->update(['status'=> $status]);
        $this->emit('dataSaved','Status Updated Successfully');
    }
}

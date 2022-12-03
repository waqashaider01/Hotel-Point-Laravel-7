<div>
    <x-table title='Companies List'>
        <x-slot name="header">
            <a href="#" type="button" wire:click="newCompany" class="btn btn-primary float-right">
                <i class="link-icon" data-feather="plus"></i>New Company
            </a>
        </x-slot>
        <x-slot name="heading">
            <td>Name</td>
            <td>Country</td>
            <td>Email</td>
            <td>Phone</td>
            <th data-orderable="false">Actions</th>
        </x-slot>
        @foreach ($companies as $item)
            <tr wire:key="{{ $item->id }}">
                <td>{{ $item->name }}</td>
                <td>{{ $item->country->name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{$item->phone_number}}</td>
                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="#" type="button" id="{{ $item->id }}" class="btn info-model-show btn-outline-primary btn-xs">
                            <i class="fas fa-folder-open" style="font-size: 1.1rem;"></i>
                        </a>
                        <a href="#" type="button" wire:click="setCompany({{ $item->id }})" class="btn btn-outline-info btn-xs">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button type="button" wire:click="deleteCompany({{ $item->id }})" class="btn btn-outline-danger btn-xs">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-table>
    <div class="modal fade @if($showModal == 'addEditModal') show @endif" @if($showModal == 'addEditModal') style="display: block;" @endif id="addEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light" id="exampleModalLabel"> {{ $editing_company ? 'Update' : 'New' }} Company</h5>
                </div>
                <div class="modal-body" style="z-index:1004;position:relative;background-color:#F5F7F9;">
                    <div class="container">
                        <div class="mt-0">
                            <div class="form-style-6">
                                <div class="row">
                                    <div class="col">
                                        <label class="">Company Name</label>
                                        <input type="text" class="form-control1" placeholder='Company Name' wire:model.defer='selected_company.name'>
                                        <x-error field="selected_company.name" />
                                    </div>
                                    <div class="col">
                                        <label class="">Company Activity</label>
                                        <input class="form-control1" placeholder="Company Activity" wire:model.defer='selected_company.activity' type="text">
                                        <x-error field="selected_company.activity" />
                                    </div>
                                    <div class="col">
                                        <label class="">VAT No</label>
                                        <input class="form-control1" placeholder="VAT No" wire:model.defer='selected_company.vat_number' type="text" />
                                        <x-error field="selected_company.vat_number" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label class="">Country</label>
                                        <div>
                                            @if ($editing_company)
                                                <select style="width: 225px;" name="selected_company.country_id" wire:model.defer='selected_company.country_id' id="companyCountry" disabled aria-readonly="true">
                                                    <option value="" selected>Select Country</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}"> {{ $country->alpha_two_code }}: {{ $country->name }} </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <select style="width: 225px;" name="selected_company.country_id" wire:model.defer='selected_company.country_id' id="companyCountry">
                                                    <option value="" selected>Select Country</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}"> {{ $country->alpha_two_code }}: {{ $country->name }} </option>
                                                    @endforeach
                                                </select>
                                            @endif

                                        </div>

                                        <x-error field="selected_company.country_id" />
                                    </div>
                                    <div class="col">
                                        <label class="">TAX Office</label>
                                        <input class="form-control1" wire:model.defer='selected_company.tax_office' type="text" placeholder='TAX Office'>
                                        <x-error field="selected_company.tax_office" />
                                    </div>
                                    <div class="col">
                                        <label class="">Company Address</label>
                                        <input class="form-control1" wire:model.defer='selected_company.address' placeholder="Company Address" type="text">
                                        <x-error field="selected_company.address" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label class="">Company Category</label>
                                        <input class="form-control1" placeholder="Company Category" wire:model.defer='selected_company.category' type="text" />
                                        <x-error field="selected_company.category" />
                                    </div>

                                    <div class="col">
                                        <label class="">Company Headquarters</label>
                                        <input class="form-control1" wire:model.defer='selected_company.headquarters' placeholder="Company Headquarters" type="text">
                                        <x-error field="selected_company.headquarters" />
                                    </div>
                                    <div class="col">
                                        <label class="">Company Branc</label>
                                        <input class="form-control1" wire:model.defer='selected_company.branch' placeholder="Company Branc" type="text">
                                        <x-error field="selected_company.branch" />
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col">
                                        <label class="">Postal Code</label>
                                        <input class="form-control1" wire:model.defer='selected_company.postal_code' placeholder="Postal Code" type="text">
                                        <x-error field="selected_company.postal_code" />
                                    </div>
                                    <div class="col">
                                        <label class="">Phone Number</label>
                                        <input class="form-control1" wire:model.defer='selected_company.phone_number' placeholder="Phone Number" type="text">
                                        <x-error field="selected_company.phone_number" />
                                    </div>
                                    <div class="col">
                                        <label class="">Email Address</label>
                                        <input class="form-control1" wire:model.defer='selected_company.email' placeholder="Email" type="text">
                                        <x-error field="selected_company.email" />
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label class="">Discount</label>
                                        <input class="form-control1" wire:model.defer='selected_company.discount' placeholder="Discount" type="number">
                                        <x-error field="selected_company.discount" />
                                    </div>
                                    <div class="col">
                                        <label class="">Intra-Comuunity VAT</label>
                                        <select class="form-control1" id="com-vat" wire:model.defer='selected_company.has_community_vat'>
                                            <option value="">Select Option</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <x-error field="selected_company.has_community_vat" />
                                    </div>
                                    <div class="col">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color:#F5F7F9;">
                        <button type="button" id="submitButton" class="float-right" wire:click="saveCompany" style='background-color:#48BBBE;padding:2px 12px;color:white;border-radius:2px;border:none;'>
                            {{ $editing_company ? 'Save' : 'Insert' }}
                        </button>
                        <button type="button" class="" data-dismiss="modal" style='background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'>
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade @if($showModal == 'infoModal') show @endif" @if($showModal == 'infoModal') style="display: block;" @endif id="infoModal" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light" id="exampleModalLabel2">Company Folio</h5>
                </div>
                <div class="modal-body" style="z-index:1004;position:relative;background-color:#F5F7F9;">
                    <div class="container" id="infoModalTable">

                    </div>
                    <div class="modal-footer" style="background-color:#F5F7F9;">
                        <button type="button" class="" data-dismiss="modal" style='background-color:red;border:none !important;padding:5px 12px;color:white;border-radius:2px;margin-bottom:5px;'>
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script defer>
        $(document).ready(function() {
            $(".modal").on('hide.bs.modal', function(){
                @this.set('showModal', '');
            });

            $('.info-model-show').on('click', function() {
                ///companie-folio
                $.ajax({
                    url: '/companie-folio',
                    type: 'GET',
                    data: {
                        id: $(this).attr('id')
                    },
                    success: function(data) {
                        console.log(data);

                        const tableInfo = document.createElement('table');
                        tableInfo.className = 'table table-striped';
                        tableInfo.innerHTML = `
                            <table id="myTable" class="table">
                                <thead>
                                    <th>Invoice No.</th>
                                    <th>Booking ID</th>
                                    <th>Guest Name</th>
                                    <th>Channel</th>
                                    <th>Reservation Amount</th>
                                    <th>Payment Status</th>
                                </thead>
                                <tbody>
                                    ${data.html}
                                </tbody>
                            </table>
                        `;
                        $('#infoModalTable').html(tableInfo);
                        $(tableInfo).DataTable();
                        $('#infoModal').modal('show');
                    }
                })
            })
        });
    </script>
</div>

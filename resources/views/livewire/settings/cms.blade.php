<div>
    <div class="d-flex flex-column-fluid mt-5 ">
        <div class="container-fluid">
            <div class="row mb-10 m-0" style="margin-bottom:50%;">
                <div class="col p-0">
                    <div class="infocard shadow-sm bg-white">
                        <h1 class="text-center">Channel Manager Settings</h1>
                        <hr>
                        <div class="row">

                            <div class="col-md form-style-6 m-0 text-right">
                                <div class="row">
                                    <div class="col-md-7 text-right">
                                        <select title="Select channel manager to activate it."
                                            wire:change="$emit('updateStatusSwal', $event.target.value )"
                                            style="max-width:200px" class="form-control1 mb-0">
                                            <option selected value="">-- Select --</option>
                                            @foreach ($properties as $property)
                                                <option {{ $property->status ? 'selected' : '' }}
                                                    value="{{ $property->id }}">{{ $property->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-5 ">
                                        <span type="button" style="max-width:100px"
                                            class="infbtn d-flex h-100 align-items-center float-right" wire:click="full_sync()">
                                            Full Sync</span>
                                         <span type="button" style="max-width:200px"
                                            class="infbtn d-flex h-100 align-items-center float-right"
                                            data-toggle="modal" data-target="#addProperty">
                                            <i class="fa fa-refresh" ria-hidden="true"></i>&nbsp;Add New Channel
                                            Manager</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        {{-- <div class="row">
                    <div class="col-5"></div>
                    <div class="col-6 pl-15">
                        <div class="row mt-8">
                            <div class="col">
                                <label>Property ID</label></br>
                                <span class="font-weight-bold">{{ $cms->property_id }}</span>
                            </div>
                        </div>
                    </div>
                    @if (is_null($cms->property_id) || $cms->property_id == '')
                        <div class="col-1">
                            <i class="fas fa-edit fa-2x" data-toggle="modal" data-target="#editChannel"></i>
                        </div>
                    @endif
                </div> --}}

                        <div class="tabel-responsive" wire:ignore>
                            <x-table class="table mt-10 text-center " id='dataTableExample'
                                style="background-color:white !important;">
                                <x-slot name="heading">
                                    <th>Sr#</th>
                                    <th>Logo</th>
                                    <th>Channel Manager</th>
                                    <th>Property Id</th>
                                    <th></th>
                                </x-slot>
                                @foreach ($properties as $property)
                                    <tr
                                        style="{{ $property->status ? 'background-color: #cfffd1;border: 1px solid lime;' : '' }}">
                                        <td class='idcolor align-middle'>{{ $property->id }}</td>
                                        <td class="align-middle"><img style="width:80px" src="{{ $cms->logo }}"
                                                alt=""></td>
                                        <td class="align-middle">{{ $property->name }}</td>
                                        <td class="align-middle">{{ $property->property_id }}</td>
                                        <td class="align-middle">
                                            <div class="row">
                                                <div class="col-md text-right"><button class="btn btn-success"
                                                        wire:click="$emit('editPropertySwal',{{ $property->id }})"><i
                                                            class="fa fa-edit mr-2"></i>Edit</button></div>
                                                <div class="col-md text-left"><button class="btn btn-danger"
                                                        wire:click="$emit('removePropertySwal',{{ $property->id }})"><i
                                                            class="fa fa-trash mr-2"></i>Remove</button></div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-table>
                        </div>
                        {{-- <div class="row">
                            @foreach ($properties as $property)
                                <div class="col-4">
                                    <div class="row">
                                        <div class="mainboxdiv">
                                            <div class="text-center h-95"
                                                style="max-height:auto !important;min-height:auto !important;">
                                                <img style="width:209px;height:65px;" alt="logo"
                                                    src='{{ $cms->logo }}' />
                                            </div>
                                            <hr class="hr">
                                            <div class="row">

                                                <div class="col-3 align-self-center text-center mb-0">
                                                    <div class="col">
                                                        <div style="float:left;">
                                                            <span type="button" class="infbtn ml-1 mt-1" id=""
                                                                data-toggle="modal" data-target="#editChannel"><i
                                                                    class="fa fa-refresh" aria-hidden="true"
                                                                    id="full_sync"></i>&nbsp;Full Sync</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col"><label>Property ID: </label></br>
                                                    <span class="font-weight-bold">{{ $property->property_id }}</span>
                                                </div>
                                                <div class="col-1 align-self-center">
                                                    @if ($property->status)
                                                        <div class="rounded-circle"
                                                            style="background-color:#00ff0a ;width:20px;height:20px">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class=' col '>
                                            <div class=' body' style="float:right;margin-top:2%;">

                                                <Button class='btn '>
                                                    <input
                                                        wire:click="$emit('updateStatusSwal',{{ $property->id }},{{ $property->status == 1 ? 0 : 1 }})"
                                                        type='checkbox' class='checkbox ratetypeStatus'
                                                        data-ratetype='{{ $property->id }}'
                                                        id='type.{{ $property->id }}'
                                                        {{ $property->status ? 'checked' : '' }} />
                                                    <label class='label' for='type.{{ $property->id }}'>
                                                        <div class='ball'></div>
                                                    </label>
                                                </Button>

                    </div>
                </div>

            </div>
        </div>
        @endforeach

    </div> --}}
                    </div>
                </div>
            </div>

            <div class="row mb-10" style="margin-bottom:50%;">
                <div class="col p-0">
                    <div class="infocard shadow-sm bg-white border-1">
                        <div class="row">
                            <div class="col-10">
                                <h1 style="margin-left:20%;">Booking Engine Settings</h1>
                            </div>
                            <div class="col-2">
                                <!--span type="button" class="infbtn ml-8" id=""  data-toggle="modal" data-target="#bookingenginmodal" >&nbsp;pop up</span-->
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-4">
                                <div class="mainboxdiv">
                                    <div class="text-center"
                                        style="max-height:auto !important;min-height:auto !important;">
                                        <img style="width:209px;height:65px;" alt="logo"
                                            src='{{ $cms['logo']; }}' />
                                    </div>
                                    <hr class="hr">
                                    <div class="text-center my-3">
                                        <span type="button" class="infbtn" id="" data-toggle="modal"
                                            data-target="#bookingenginmodal">&nbsp;Login</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mainboxdiv">
                                    <div class="text-center"
                                        style="max-height:auto !important;min-height:auto !important;">
                                        <img style="width:209px;" alt="logo" class="img-fluid"
                                            src='{{ asset('images/logo/oxygen.png') }}' />
                                    </div>
                                    <hr class="hr">
                                    <div class="text-center my-3">
                                        <span type="button" class="infbtn" id="" data-toggle="modal"
                                        data-target="#editOxygenApiKey">
                                        @if($cms->oxygen_api_key)
                                            Update API key
                                        @else
                                            Add API key
                                        @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">

                            </div>
                            <div class="col-2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Modals --}}
            <div class="modal fade" id="editChannel" style="border-radius:0px !important;" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content rounded-0">
                        <div class="modal-header shadow-sm " style="border-radius:0px !important;z-index:10;">
                            <h5 style="margin-left:22%;margin-right:23%;" class="modal-title text-dark">
                                Channel Manager Settings</h5>
                            <button type="submit" class="float-right btn btn-outline-primary"
                                wire:click="saveCMS">Update
                            </button>
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal"
                                style=''>Close
                            </button>
                        </div>
                        <div class="modal-body" style="position:relative;background-color:#fff;">
                            <div class="form-style-6">
                                <div class="row mt-4">
                                    <div class="col">
                                        <label>Property ID</label>
                                        <input type="text" wire:model.defer="cms.property_id"
                                            placeholder="Property Id" />
                                        </x-error field="cms.property_id">
                                    </div>
                                    <div class="col">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="bookingenginmodal" style="border-radius:0px !important;" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content rounded-0 m-auto" style="width: 650px !important;">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            <div class="modal-header shadow-sm " style="border-radius:0px !important;z-index:10;">
                                <h5 style="margin-left:30%;margin-right:23%;" class="modal-title text-dark"
                                    id="exampleModalLabel">
                                    Booking Engine Settings</h5>

                                <button type="button" class="btn btn-outline-danger" data-dismiss="modal"
                                    style=''>Close</button>

                            </div>


                            <div class="modal-body" style="position:relative;background-color:#fff;">
                                <div id="iframecontainer" style="width: 100%; height: 70vh;">

                                    <iframe id="settingframe" frameBorder="0" hspace="0" vspace="0"
                                        style="min-width: 100% !important; height: auto !important; min-height: 100%;  border: none;  padding: 0px !important;"
                                        src="">

                                    </iframe>
                                </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addProperty" style="border-radius:0px !important;" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-0">
            <div class="modal-header shadow-sm " style="border-radius:0px !important;z-index:10;">
                <h5 style="margin-left:22%;margin-right:23%;" class="modal-title text-dark">
                    Add New Channel Manager</h5>
                <button type="submit" class="float-right btn btn-outline-primary" wire:click="saveNewProperty">Save
                </button>
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal" style=''>Close
                </button>
            </div>
            <div class="modal-body" style="position:relative;background-color:#fff;">
                <div class="form-style-6">
                    <div class="row mt-4">
                        <div class="col">
                            <label>Channel Manager</label>
                            <select type="text" wire:model.defer="name">
                                <option value="" selected disabled>-- Select --</option>
                                <option value="Channex">Channex</option>
                            </select>
                            </x-error field="name">
                        </div>
                        <div class="col">
                            <label>Property ID</label>
                            <input type="text" wire:model.defer="property_id" placeholder="Property Id" />
                            </x-error field="property_id">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editProperty" style="border-radius:0px !important;" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-0">
            <div class="modal-header shadow-sm " style="border-radius:0px !important;z-index:10;">
                <h5 style="margin-left:22%;margin-right:23%;" class="modal-title text-dark">
                    Edit Channel Manager</h5>
                <button type="submit" class="float-right btn btn-outline-primary"
                    wire:click="editPropertyStore">Save
                </button>
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal" style=''>Close
                </button>
            </div>
            <div class="modal-body" style="position:relative;background-color:#fff;">
                <div class="form-style-6">
                    <div class="row mt-4">
                        <div class="col">
                            <label>Channel Manager</label>
                            <select type="text" wire:model.defer="name">
                                <option value="" selected disabled>-- Select --</option>
                                <option value="Channex">Channex</option>
                            </select>
                            </x-error field="name">
                        </div>
                        <div class="col">
                            <label>Property ID</label>
                            <input type="text" wire:model.defer="property_id" placeholder="Property Id" />
                            </x-error field="property_id">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editOxygenApiKey" style="border-radius:0px !important;" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-0">
            <div class="modal-header shadow-sm d-flex justify-content-between align-items-center" style="border-radius:0px !important;z-index:10;">
                <h5 class="modal-title text-dark">
                    @if ($cms->oxygen_api_key)
                        Update Oxygen API key
                    @else
                        Add Oxygen API key
                    @endif
                </h5>
                <div>
                    <button type="submit" class="btn btn-outline-primary mr-2"
                        wire:click="editOxygenApiKeyStore">Save
                    </button>
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal" style=''>Close
                    </button>
                </div>
            </div>
            <div class="modal-body" style="position:relative;background-color:#fff;">
                <div class="d-none justify-content-center align-items-center" wire:loading.class="d-flex" wire:target="editOxygenApiKeyStore">
                    <x-loader color="#333"/>
                </div>
                <div class="form-style-6" wire:loading.remove wire:target="editOxygenApiKeyStore">
                    <div class="row mt-4">
                        <div class="col">
                            <label>Oxygen API Key</label>
                            <input type="text" wire:model.defer="oxygen_api_key" placeholder="Enter Oxygen Api Key" />
                            </x-error field="oxygen_api_key">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#dataTableExample').DataTable({
            "aLengthMenu": [
                [10, 30, 50, -1],
                [10, 30, 50, "All"]
            ],
            "iDisplayLength": 10,
            "language": {
                search: ""
            }
        });
        $('#dataTableExample').each(function() {
            var datatable = $(this);
            // SEARCH - Add the placeholder for Search and Turn this into in-line form control
            var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
            search_input.attr('placeholder', 'Search');
            search_input.removeClass('form-control-sm');
            // LENGTH - Inline-Form control
            var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
            length_sel.removeClass('form-control-sm');
        });

        $('#editgeneral').on('click', function() {
            $('#editmodal').modal("show");
        });
        $.ajax({
            url: "/channex-otp",
            type: "get",
            success: function(args) {

                var propertyid = args.propertyid;
                var accesstoken = args.onetimeToken;
                var iframeRef = "https://staging.channex.io/auth/exchange?oauth_session_key=" +
                    accesstoken +
                    "&app_mode=headless&redirect_to=/properties/" + propertyid +
                    "/edit&property_id=" + propertyid;

                $("#settingframe").prop("src", iframeRef);

            }
        })

        window.livewire.on('updateStatusSwal', (id) => {
            let text = 'Do you want to activate this property';
            if (id == '')
                text = 'Do you want to de-activate all properties';
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure?',
                text: text,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    window.livewire.emit('activateProperty', id == '' ? 0 : id)
                } else {
                    Swal.fire({
                        icon: 'error',
                        text: 'Operation Cancelled!'
                    }).then((result) => {
                        window.location.reload()
                    });
                }
            });
        });
        window.livewire.on('editPropertySwal', (id) => {
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure?',
                text: 'Do you want to edit this property?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    window.livewire.emit('editProperty', id);
                    window.livewire.on('openModel', () => {
                        $('#editProperty').modal("show")
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        text: 'Operation Cancelled!'
                    }).then((result) => {

                    });
                }
            });
        });
        window.livewire.on('removePropertySwal', (id) => {
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure?',
                text: 'Do you want to remove this property?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    window.livewire.emit('removeProperty', id);
                } else {
                    Swal.fire({
                        icon: 'error',
                        text: 'Operation Cancelled!'
                    }).then((result) => {

                    });
                }
            });
        });
    })
</script>

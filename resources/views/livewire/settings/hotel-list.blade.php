<div>
    <div class="full-page-loader" wire:loading.class="d-flex">
        <x-loader color="#333"/>
    </div>
    <x-table title='Hotel List' tableClasses="table table-striped">
        <x-slot name="header">
            @role('Super Admin')
            <a href="#" type="button" data-toggle="modal" data-target="#createNewHotel"
                class="btn btn-primary  float-right">
                <i class="link-icon" data-feather="plus"></i>Ceate New Hotel
            </a>
            @endrole
        </x-slot>
        <x-slot name="heading">
            <td>Logo</td>
            <td>Name</td>
            <td>Owner Name</td>
            <th data-orderable="false">Actions</th>
        </x-slot>
        @foreach ($hotels as $hotel)
            <tr id="tr_{{ $hotel->id }}">
                <td><img src="{{ $hotel->logo }}" style="max-width: 125px;" /></td>
                <td>{{ $hotel->name }}</td>
                <td>{{ ucwords($hotel->owner->name) }}</td>
                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="{{ route('hotel-settings', $hotel) }}" class="btn btn-outline-info btn-xs">
                            <i class="fa fa-edit"></i></a>
                        <button type="button" class="btn btn-xs btn-outline-danger" wire:click="confirm_delete_hotel({{$hotel->id}})"><i class="fa fa-trash"></i></button>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-table>
    @role('Super Admin')
    <div class="modal fade @error('hotel.*') show @enderror" id="createNewHotel" style="border-radius:0px !important;" tabindex="-1"
        data-backdrop="static" data-keyboard="false" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content rounded-0">
                <div class="modal-header shadow-sm d-flex" style="border-radius:0px !important;z-index:10;">
                    <h5 class="modal-title text-dark">
                        Create new Hotel</h5>
                    <button type="button" class="ml-auto mr-2 btn btn-outline-primary" wire:click="saveHotel"
                        wire:loading.attr="disabled" wire:target="saveHotel">
                        Submit
                    </button>
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal" style=''>Close
                    </button>
                </div>
                <div class="modal-body" style="position:relative;background-color:#fff;">
                    <div class="d-none justify-content-center align-items-center" wire:loading.class="d-flex"
                        wire:target="saveHotel">
                        <x-loader color="#333" />
                    </div>
                    <form action="" method="POST" wire:loading.remove wire:target="saveHotel">
                        <div>
                            <div class="form-group">
                                <label for="">User</label>
                                <select class="form-control" wire:model.defer="hotel.user">
                                    <option value="">Select a user</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ ucwords($user->name) }}</option>
                                    @endforeach
                                </select>
                                @error('hotel.user')
                                    <span class="invalid-input-data"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Hotel Name</label>
                                <input type="text" class="form-control" placeholder="Hotel Name"
                                    wire:model.defer='hotel.name' required>
                                    @error('hotel.name')
                                        <span class="invalid-input-data"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Channex Property ID</label>
                                <input class="form-control" placeholder="Channex Property ID" wire:model.defer='hotel.channex_id'
                                    type="text" required="">
                                    @error('hotel.channex_id')
                                        <span class="invalid-input-data"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endrole
</div>

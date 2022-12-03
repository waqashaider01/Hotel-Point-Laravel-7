<div>
    <div class=" mt-5 ">
        <div class="">
            <div class=" tab-container">
                <ul class="nav nav-pills justify-content-center flex-column flex-sm-row d-print-none mt-5 w-100"
                    id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link flex-sm-fill text-sm-center {{ $tab == 'general' ? 'active' : '' }}" href="#"
                            wire:click="$set('tab', 'general')">General Settings</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link flex-sm-fill text-sm-center {{ $tab == 'tax' ? 'active' : '' }}" href="#"
                            wire:click="$set('tab', 'tax')">Tax
                            Settings</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link flex-sm-fill text-sm-center {{ $tab == 'payment' ? 'active' : '' }}" href="#"
                            wire:click="$set('tab', 'payment')">Payment Settings</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link flex-sm-fill text-sm-center {{ $tab == 'operation' ? 'active' : '' }}" href="#"
                            wire:click="$set('tab', 'operation')">Operation Settings</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link flex-sm-fill text-sm-center {{ $tab == 'email' ? 'active' : '' }}" href="#"
                            wire:click="$set('tab', 'email')">Email Settings</a>
                    </li>
                    {{-- <li class="nav-item" role="presentation">
                        <a class="nav-link flex-sm-fill text-sm-center {{ $tab == 'cancel' ? 'active' : '' }}" href="#"
                            wire:click="$set('tab', 'cancel')">Cancellation Policy</a>
                    </li> --}}
                    <li class="nav-item" role="presentation">
                        <a class="nav-link flex-sm-fill text-sm-center {{ $tab == 'cms' ? 'active' : '' }}" href="#"
                            wire:click="$set('tab', 'cms')">Connectivity Settings</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link flex-sm-fill text-sm-center {{ $tab == 'template' ? 'active' : '' }}" href="#"
                            wire:click="$set('tab', 'template')">Template Settings</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                @if ($tab == 'general')
                    @livewire('settings.general')
                @elseif($tab == 'tax')
                    @livewire('settings.tax')
                @elseif($tab == 'payment')
                    @livewire('settings.payment')
                @elseif($tab == 'operation')
                    @livewire('settings.operation')
                @elseif($tab == 'email')
                    @livewire('settings.email')
                {{-- @elseif($tab == 'cancel')
                    @livewire('settings.cancel') --}}
                @elseif($tab == 'cms')
                    @livewire('settings.cms')
                @elseif($tab == 'template')
                    @livewire('settings.template')
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="shortCodeModal" tabindex="-1" data-backdrop="static" data-keyboard="false"
        wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light font-weight-bolder" style="font-size:20px;">
                        Short Codes
                    </h5>
                </div>
                <div class="modal-body" wire:loading>
                    <div class="d-flex justify-content-center align-items-center">
                        <x-loader color="#333" />
                    </div>
                </div>
                <div class="modal-body p-0" style="overflow-x: hidden;" wire:loading.remove>
                    <div class="px-2 py-3">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                @foreach (\App\Models\Template::SHORT_CODE_LIST as $key => $code)
                                    <tr scope="row">
                                        <th>{{ $key }}</th>
                                        <td>{{ $code }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div style="max-width: 100%">
                            <hr style="border-top: 3px solid #dfdfdf;">
                            <div class="mb-2 mt-5 d-flex justify-content-end align-items-center">
                                <button type="button" class=" btn btn-secondary btn-sm" data-dismiss="modal">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

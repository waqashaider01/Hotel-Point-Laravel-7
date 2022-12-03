@extends('layouts.master')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .flatpickr-current-month .flatpickr-monthDropdown-months {
            width: 70% !important;
        }

        .flatpickr-current-month .numInputWrapper {
            top: -27px;
            left: 38%;
        }

        .nav-link-tab.active:hover {
            background-color: #3c9fa2;
            color: white !important;
        }

        .nav-link-tab.active {
            color: #fff;
            background-color: #48BBBE;
        }

        div[data-tag].tab-pane.active {
            animation: slide-left 300ms ease-out;
        }

        @keyframes slide-left {
            0% {
                opacity: 0;
                transform: translateX(100%);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* print */
        @media print {
            .dataTables_wrapper.dt-bootstrap4.no-footer>div.row:nth-of-type(2n-1) {
                display: none;
            }
        }
    </style>
@endpush

@section('content')
    <ul class="nav nav-tabs justify-content-center flex-column flex-sm-row d-print-none w-100 mt-5" style="background-color: transparent;" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link @if ($showTab === 'pills-home') active @endif" id="pills-home-tab" data-toggle="tab" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Accommodation

            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link @if ($showTab === 'pills-profile') active @endif" id="pills-profile-tab" data-toggle="tab" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Services</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link @if ($showTab === 'pills-contact') active @endif" id="pills-contact-tab" data-toggle="tab" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Overnight Tax</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent" style="overflow-x: hidden">
        <div class="tab-pane fade @if ($showTab === 'pills-home') show active @endif" id="pills-home" role="tabpanel" data-tag data-pos="1" aria-labelledby="pills-home-tab">
            <div style="margin-top: -30px;">
                <x-table title='Accommodation'>
                    <x-slot name="header">
                        <div class="row">
                            <div class="col-md-10">
                                <form method="get" class="d-flex m-0">
                                    <input type="hidden" name="pills-home" value="pills-home" class="d-none">
                                    <div class="d-flex flex-column form-style-6">
                                        <label for="">From Date</label>
                                        <input type="text" class="datepicker-dateinput" style="width: 307px;" placeholder="Choose from date" name="from_date" value="{{ request()->get('from_date') }}" id="from_date">
                                    </div>
                                    <div class="d-flex flex-column form-style-6">
                                        <label for="">To Date</label>
                                        <input type="text" class="datepicker-dateinput" style="width: 307px;" placeholder="Choose to date" name="to_date" value="{{ request()->get('to_date') }}" id="to_date">
                                    </div>
                                   
                                    <div class="d-flex d-print-none align-items-end" style="margin-bottom: 27px;">
                                        <button type="submit" style="background-color:#48BD91;border:none !important;padding: 5px 12px;color:white;border-radius:2px;">Search</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-2 d-flex d-print-none justify-content-end align-items-end">
                                <a href="javascript:if(window.print)window.print()" class="hover-opacity-70" style='background-color:black;padding:2px 12px;color:white;border-radius:2px;margin-bottom: 27px;'>
                                    <span class="navi-icon">
                                        <i class="fa fa-print" style="color:white !important;"></i>
                                    </span>
                                    <span style="color: white">Print</span>
                                </a>
                            </div>
                        </div>

                    </x-slot>
                    @if (sizeof($cards) > 0)
                        <x-slot name="cardsHeader2">
                            <div class="row">
                                @foreach ($cards as $key => $card)
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body p-2">
                                                <div class="d-flex justify-content-between align-items-center" style="padding-inline: 1rem">
                                                    @if ($card->name == 'American Express')
                                                        <img src='/images/logo/AE.png' style="max-height: 45px;" alt='' />
                                                    @elseif($card->name == 'Maestro')
                                                        <img src='/images/logo/Maestro.png' style="max-height: 45px;" alt='' />
                                                    @elseif($card->name == 'Master Card')
                                                        <img src='/images/logo/MasterCard.png' style="max-height: 45px;" alt='' />
                                                    @elseif($card->name == 'Visa')
                                                        <img src='/images/logo/VISA.png' style="max-height: 45px;" alt='' />
                                                    @elseif($card->name == 'UnionPay')
                                                        <img src='/images/logo/UnionPay.png' style="max-height: 45px;" alt='' />
                                                    @else
                                                        <img src='/images/logo/money-green.png' style="max-height: 45px;" alt='' />
                                                    @endif

                                                    <p style="font-weight: bolder">
                                                        {{ showPriceWithCurrency($card->value) }}
                                                    </p>
                                                </div>
                                                <div class="mt-3">
                                                    <p class="m-0 text-right" style="font-weight: bolder; color: red">{{ showPriceWithCurrency($card->commision_total) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </x-slot>
                    @endif

                    <x-slot name="heading">
                        <td>Booking ID</td>
                        <td>Credit Card Type</td>
                        <td>Guest Name</td>
                        <td>Reservation Amount</td>
                        <td>Commision Amount</td>

                    </x-slot>

                    @foreach ($accomPayments as $item)
                    <!-- {{$item}} -->
                        <tr>
                            <td><a href="{{ route('reservation-show', $item->reservation) }}">
                                    #{{ str_pad($item->reservation_id, 5, '0', STR_PAD_LEFT) }}
                                </a>
                            </td>
                            <td>{{ $item->payment_method->name }}</td>
                            <td>{{ $item->reservation->guest->full_name}}
                            <td>{{ $item->value ? showPriceWithCurrency($item->value) : 0 }}</td>
                            <td>{{ $item->payment_method->commission_percentage ? showPriceWithCurrency($item->value * ($item->payment_method->commission_percentage / 100)) : 0 }}</td>
                        </tr>
                    @endforeach
                </x-table>
            </div>

        </div>
        <div class="tab-pane fade @if ($showTab === 'pills-profile') show active @endif" id="pills-profile" role="tabpanel" data-tag data-pos="2" aria-labelledby="pills-profile-tab">

            <div style="margin-top: -30px;">
                <x-table title='Services' id="dataTableExample2">
                    <x-slot name="header">
                        <div class="row">
                            <div class="col-md-10">
                                <form method="get" class="d-flex m-0">
                                    <input type="hidden" name="pills-profile" value="pills-profile" class="d-none">
                                    <div class="d-flex flex-column form-style-6">
                                        <label for="">From Date</label>
                                        <input type="text" class="datepicker-dateinput" style="width: 307px;" placeholder="Choose from date" name="from_date_services" value="{{ request()->get('from_date_services') }}"
                                               id="from_date_services">
                                    </div>
                                    <div class="d-flex flex-column form-style-6">
                                        <label for="">To Date</label>
                                        <input type="text" class="datepicker-dateinput" style="width: 307px;" placeholder="Choose to date" name="to_date_services" value="{{ request()->get('to_date_services') }}"
                                               id="to_date_services">
                                    </div>
                                    
                                    <div class="d-flex d-print-none align-items-end" style="margin-bottom: 27px;">
                                        <button type="submit" style="background-color:#48BD91;border:none !important;padding: 5px 12px;color:white;border-radius:2px;">Search</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-2 d-print-none d-flex justify-content-end align-items-end">
                                <a href="javascript:if(window.print)window.print()" class="hover-opacity-70" style='background-color:black;padding:2px 12px;color:white;border-radius:2px;margin-bottom: 27px;'>
                                    <span class="navi-icon">
                                        <i class="fa fa-print" style="color:white !important;"></i>
                                    </span>
                                    <span style="color: white">Print</span>
                                </a>
                            </div>
                        </div>

                    </x-slot>

                    @if (sizeof($servicesCards) > 0)
                        <x-slot name="cardsHeader2">
                            <div class="row">
                                @foreach ($servicesCards as $card)
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body p-2">
                                                <div class="d-flex justify-content-between align-items-center" style="padding-inline: 1rem">
                                                    @if ($card->name == 'American Express')
                                                        <img src='/images/logo/AE.png' style="max-height: 45px;" alt='' />
                                                    @elseif($card->name == 'Maestro')
                                                        <img src='/images/logo/Maestro.png' style="max-height: 45px;" alt='' />
                                                    @elseif($card->name == 'Master Card')
                                                        <img src='/images/logo/MasterCard.png' style="max-height: 45px;" alt='' />
                                                    @elseif($card->name == 'Visa')
                                                        <img src='/images/logo/VISA.png' style="max-height: 45px;" alt='' />
                                                    @elseif($card->name == 'UnionPay')
                                                        <img src='/images/logo/UnionPay.png' style="max-height: 45px;" alt='' />
                                                    @else
                                                        <img src='/images/logo/money-green.png' style="max-height: 45px;" alt='' />
                                                    @endif

                                                    <p style="font-weight: bolder">
                                                        {{ showPriceWithCurrency($card->value) }}
                                                    </p>
                                                </div>
                                                <div class="mt-3">
                                                    <p class="m-0 text-right" style="font-weight: bolder; color: red">{{ showPriceWithCurrency($card->commision_total) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </x-slot>
                    @endif
                    <x-slot name="heading">
                        <td>Booking ID</td>
                        <td>Credit Card Type</td>
                        <td>Guest Name</td>
                        <td>Reservation Amount</td>
                        <td>Commision Amount</td>

                    </x-slot>

                    @foreach ($extrasPayments as $item)
                        <tr>
                            <td><a href="{{ route('reservation-show', $item->reservation) }}">
                                    #{{ str_pad($item->reservation_id, 5, '0', STR_PAD_LEFT) }}
                                </a>
                            </td>
                            <td>{{ $item->payment_method->name }}</td>
                            <td>{{$item->reservation->guest->name}}</td>
                            <td>{{ $item->value ? showPriceWithCurrency($item->value) : 0 }}</td>
                            <td>{{ $item->payment_method->commission_percentage ? showPriceWithCurrency($item->value * ($item->payment_method->commission_percentage / 100)) : 0 }}</td>
                        </tr>
                    @endforeach
                </x-table>
            </div>

        </div>
        <div class="tab-pane fade @if ($showTab === 'pills-contact') show active @endif" id="pills-contact" role="tabpanel" data-tag data-pos="3" aria-labelledby="pills-contact-tab">
            <div style="margin-top: -30px;">
                <x-table title='Overnight Tax' id="dataTableExample3">
                    <x-slot name="header">
                        <div class="row">
                            <div class="col-md-10">
                                <form method="get" class="d-flex m-0">
                                    <input type="hidden" name="pills-contact" value="pills-contact" class="d-none">
                                    <div class="d-flex flex-column form-style-6">
                                        <label for="">From Date</label>
                                        <input type="text" class="datepicker-dateinput" style="width: 307px;" placeholder="Choose from date" name="from_date_tax" value="{{ request()->get('from_date_tax') }}" id="from_date_tax">
                                    </div>
                                    <div class="d-flex flex-column form-style-6">
                                        <label for="">To Date</label>
                                        <input type="text" class="datepicker-dateinput" style="width: 307px;" placeholder="Choose to date" name="to_date_tax" value="{{ request()->get('to_date_tax') }}" id="to_date_tax">
                                    </div>
                                    
                                    <div class="d-flex d-print-none align-items-end" style="margin-bottom: 27px;">
                                        <button type="submit" style="background-color:#48BD91;border:none !important;padding: 5px 12px;color:white;border-radius:2px;">Search</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-2 d-flex d-print-none justify-content-end align-items-end">
                                <a href="javascript:if(window.print)window.print()" class="hover-opacity-70" style='background-color:black;padding:2px 12px;color:white;border-radius:2px;margin-bottom: 27px;'>
                                    <span class="navi-icon">
                                        <i class="fa fa-print" style="color:white !important;"></i>
                                    </span>
                                    <span style="color: white">Print</span>
                                </a>
                            </div>
                        </div>

                    </x-slot>

                    @if (sizeof($taxCards) > 0)
                        <x-slot name="cardsHeader2">
                            <div class="row">
                                @foreach ($taxCards as $key => $card)
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body p-2">
                                                <div class="d-flex justify-content-between align-items-center" style="padding-inline: 1rem">
                                                    @if ($card->name == 'American Express')
                                                        <img src='/images/logo/AE.png' style="max-height: 45px;" alt='' />
                                                    @elseif($card->name == 'Maestro')
                                                        <img src='/images/logo/Maestro.png' style="max-height: 45px;" alt='' />
                                                    @elseif($card->name == 'Master Card')
                                                        <img src='/images/logo/MasterCard.png' style="max-height: 45px;" alt='' />
                                                    @elseif($card->name == 'Visa')
                                                        <img src='/images/logo/VISA.png' style="max-height: 45px;" alt='' />
                                                    @elseif($card->name == 'UnionPay')
                                                        <img src='/images/logo/UnionPay.png' style="max-height: 45px;" alt='' />
                                                    @else
                                                        <img src='/images/logo/money-green.png' style="max-height: 45px;" alt='' />
                                                    @endif

                                                    <p style="font-weight: bolder">
                                                        {{ showPriceWithCurrency($card->value) }}
                                                    </p>
                                                </div>
                                                <div class="mt-3">
                                                    <p class="m-0 text-right" style="font-weight: bolder; color: red">{{ showPriceWithCurrency($card->commision_total) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </x-slot>
                    @endif

                    <x-slot name="heading">
                        <td>Booking ID</td>
                        <td>Credit Card Type</td>
                        <td>Guest Name</td>
                        <td>Reservation Amount</td>
                        <td>Commision Amount</td>
                    </x-slot>

                    @foreach ($guest_overnight_tax_payments as $item)
                        <tr>
                            <td><a href="{{ route('reservation-show', $item->reservation) }}">
                                    #{{ str_pad($item->reservation_id, 5, '0', STR_PAD_LEFT) }}
                                </a>
                            </td>
                            <td>{{ $item->payment_method->name }}</td>
                            <td>{{$item->reservation->guest->name}}</td>
                            <td>{{ $item->value ? showPriceWithCurrency($item->value) : 0 }}</td>
                            <td>{{ $item->payment_method->commission_percentage ? showPriceWithCurrency($item->value * ($item->payment_method->commission_percentage / 100)) : 0 }}</td>
                        </tr>
                    @endforeach
                </x-table>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        $(document).ready(function() {
            $(".datepicker-dateinput").flatpickr();
        });
    </script>
@endpush

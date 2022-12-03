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

        @media print {
            .dataTables_wrapper.dt-bootstrap4.no-footer>div.row:nth-of-type(2n-1) {
                display: none;
            }
        }
    </style>
@endpush
@section('content')
    <div>
        <x-table title='Commision List'>
            <x-slot name="header">
                <div class="row">
                    <div class="col-md-10">
                        <form method="get" class="d-flex m-0">
                            <div class="d-flex flex-column form-style-6">
                                <label for="">From Date</label>
                                <input type="text" placeholder="Choose from date" style="width: 307px;" name="from_date" value="{{ request()->get('from_date') }}" id="from_date">
                            </div>
                            <div class="d-flex flex-column form-style-6">
                                <label for="">To Date</label>
                                <input type="text" placeholder="Choose to date" style="width: 307px;" name="to_date" value="{{ request()->get('to_date') }}" id="to_date">
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
            <x-slot name="heading">
                <td>Booking ID</td>
                <td>Check out Date</td>
                <td>Source</td>
                <td>Guest Name</td>
                <td>Reservation Amount</td>
                <td>Channel Commission</td>

            </x-slot>
            @foreach ($reservations as $item)
                <tr>
                    <td><a href="{{ route('reservation-show', $item) }}">
                            #{{ str_pad($item->reservation_id, 5, '0', STR_PAD_LEFT) }}
                        </a>
                        </td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->agency_name }}</td>
                    <td>{{$item->guest->full_name}}</td>
                    <td>{{ $item->reservation_amount ? showPriceWithCurrency($item->reservation_amount) : 0 }}</td>
                    <td>{{ $item->commission_amount ? showPriceWithCurrency($item->reservation_amount) : 0 }}</td>
                </tr>
            @endforeach
        </x-table>
    </div>
    <!-- Modals -->
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        function setId(id) {
            $('#document_id').val(id);
        }

        $(document).ready(function() {
            $("#from_date").flatpickr();
            $("#to_date").flatpickr();
        })
    </script>
@endpush

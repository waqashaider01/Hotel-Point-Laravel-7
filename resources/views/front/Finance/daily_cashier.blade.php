@extends('layouts.master')
@push('styles')
    <style>
        .dataTables_wrapper .dataTable th,
        .dataTables_wrapper .dataTable td {
            padding: 0.5rem !important;
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months {
            width: 70% !important;
        }

        .flatpickr-current-month .numInputWrapper {
            top: -27px;
            left: 38%;
        }

        .flatpickr-day.is-closed-date {
            background-color: #e6e6e6 !important;
            color: black !important;
        }

        .flatpickr-day.is-open-date {
            background-color: red !important;
            color: black !important;
        }

        .flatpickr-day.has-action {
            background-color: rgb(226, 248, 28) !important;
            color: black !important;
        }

        .flatpickr-day.has-action.today {
            background-color: rgb(176, 196, 2) !important;
        }

        .flatpickr-day.has-action.flatpickr-disabled {
            opacity: 0.5;
        }

        .flatpickr-day.selected {
            outline: 2px solid #569ff7 !important;
        }

        body#kt_body {
            padding-bottom: 10px !important;
        }

        /* show .only-print when prinitng */

        .only-print {
            display: none;
        }

        @media print {
            .only-print {
                display: block !important;
            }
        }

        hr {
            margin-left: -1% !important;
            margin-right: -1% !important;
        }
    </style>
@endpush
@section('content')
    <script>
        const simpleTableJqueryIds = [];
    </script>
    <div class="d-flex flex-column-fluid mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="cashier-infoCard bg-white shadow-sm" style="padding:1%;">
                        <div class="row">
                            <div class="col-3 d-flex align-items-center">
                                <h1 class="m-0 p-0">Daily Cashier</h1>
                            </div>
                            <div class="col-7 d-flex align-items-center">

                                <form class="d-flex align-items-center d-print-none m-0" method="GET">
                                    <div class="d-print-none">
                                        <input id="my-date-picker" style="width: 307px" class="form-control1 py-2" name='date' type="text" value="{{ $date }}" max="{{ today()->toDateString() }}">
                                    </div>
                                    @if (!$register)
                                        <div class="ml-10">
                                            <input style="width: 200px" class="form-control1 py-2" type='text' value="{{ $register ? $register->reg_cash : request()->get('cash') }}" name="cash" placeholder='Cash Register' />
                                        </div>

                                        <div class="d-print-none ml-10">
                                            <button type="submit" style='background-color:#48BD91;border:none !important;padding:5px 12px;color:white;border-radius:2px;'>Open</button>
                                        </div>
                                    @endif

                                </form>
                            </div>

                            <div class="col-md-2 d-flex justify-content-end align-items-center">
                                <div class="only-print">
                                    <span>{{ $date }}</span>
                                </div>
                                <a href="javascript:if(window.print)window.print()" class="hover-opacity-70 d-print-none" style='background-color:black;padding:4px 12px;color:white;border-radius:2px;'>
                                    <span class="navi-icon">
                                        <i class="fa fa-print" style="color:white !important;"></i>
                                    </span>
                                    <span style="color: white">Print</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @livewire('finance.daily-cashier.front-desk', ['date' => $date])
            @livewire('finance.daily-cashier.services', ['date' => $date])
            @livewire('finance.daily-cashier.overnight-tax', ['date' => $date])
            @livewire('finance.daily-cashier.summary', ['date' => $date, 'register' => $register])
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <script>
        const closeDates = @json($closeDates);
        const notClosedDates = @json($notClosedDates);
    </script>

    <script>
        $('#my-date-picker').flatpickr({
            maxDate: "today",
            onDayCreate: function(dObj, dStr, fp, dayElem) {
                //convert dayElem.dateObj into format yyyy-mm-dd add 0 if less than 10
                var date = dayElem.dateObj.getFullYear() + '-' + (dayElem.dateObj.getMonth() + 1 < 10 ? '0' + (dayElem.dateObj.getMonth() + 1) : dayElem.dateObj.getMonth() + 1) + '-' + (dayElem.dateObj.getDate() < 10 ? '0' + dayElem
                    .dateObj.getDate() : dayElem.dateObj.getDate());

                if (closeDates.includes(date)) {
                    dayElem.classList.add('is-closed-date');
                    return;
                }
                if (notClosedDates.includes(date)) {
                    dayElem.classList.add('is-open-date');
                    return;
                }
                dayElem.classList.add('has-action');
            }
        });

        $(document).ready(function() {
            $('#my-date-picker').change(function() {
                var date = $(this).val();
                window.location.href = window.location.origin + "/daily-cashier?date=" + date;
            });
        });

        window.livewire.on('dataSaved', (message) => {
            window.location.reload();
        });
    </script>
    <script>
        $(document).ready(function() {
            simpleTableJqueryIds.forEach(element => {
                let id = element.id;
                let inputId = element.searchInputId;
                document.getElementById(inputId).value = "";

                let myDoc = $(`#${id}`).DataTable({
                    "paging": false,
                    "searching": true,
                    "ordering": true,
                    "responsive": true,
                    dom: 'lrt',
                    "columnDefs": [{
                        "targets": 'no-sort',
                        "orderable": false,
                    }]
                });

                document.getElementById(inputId).addEventListener('keyup', function() {
                    myDoc.search(this.value).draw();
                });

            });

        });
    </script>
@endpush

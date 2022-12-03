@extends('layouts.master')
@push('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet" type="text/css" />
    <style>
        body#kt_body {
            padding-bottom: 50px !important;
            height: inherit !important;
        }

        .hor-card-row .card {
            padding-inline: 1.5rem;
            padding-block: 3rem;
            align-items: center;
            gap: 1rem;
        }

        .hor-card-row .card i {
            font-size: 4rem;
            color: #f64e60;
        }

        .hor-card-row .card span {
            font-size: 2rem;
        }

        .hor-card-row .card p {
            margin: 0;
            text-align: center;
        }

        .hor-card-row .card {
            height: 370px;
            justify-content: center;
        }

        .nav.nav-tabs {
            background: none;
        }

        .nav.nav-tabs>a {
            padding-block: 0.4rem !important;
            box-shadow: none !important;
            border-color: transparent !important;
        }

        .nav.nav-tabs>a>span {
            background-color: #7e8299;
            color: white;
            margin-left: 10px;
        }

        .nav.nav-tabs>a.active>span {
            background-color: #ffa800 !important;
        }

        .custom-select.custom-select-sm.form-control.form-control-sm {
            width: 60px !important;
            max-width: 60px !important;
            height: auto;
        }

        .dataTables_wrapper .dataTable td {
            padding-inline: 0.3rem !important;
            text-align: center;
        }

        .dataTables_wrapper .dataTable th:nth-last-of-type(),
        .dataTables_wrapper .dataTable td:nth-last-of-type() {
            width: 150px !important;
        }

        .dataTables_scrollHeadInner {
            width: 100% !important;
        }

        .accordion .collapse-icon i {
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            font-size: 1.5rem;
            color: hsl(222deg 71% 66%);
        }

        .accordion .collapse-icon i::before {
            content: "\f35b";
        }

        .accordion button.collapsed+.collapse-icon i::before {
            content: "\f358";
        }

        .custom-input-box>* {
            margin: 0;
            padding: 10px 15px
        }

        .custom-input-box>input {
            width: 250px;
            border: 1px solid black;
            box-shadow: none;
        }

        .notification-card-body-div {
            font-size: 10px;
        }

        .notification-card-body-div span {
            font-size: inherit !important;
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months {
            min-width: 100px !important;
        }

        .flatpickr-current-month .numInputWrapper {
            display: inline-block;
            top: -30px;
            left: 30px;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid my-10">
        <div class="mb-5">
            @livewire('home.stats')
        </div>
        <div class="mb-5" wire:ignore>
            <div class="row mt-8">
                <div class="col-12 col-md-3 col-sm-6 mb-2">
                    <div type="button" class="dashboardsmallcards shadow">
                        <div class="row justify-content-between align-items-stretch mb-8">
                           
                            <div class="col">
                                <div style="float:left;">
                                    <h4 style="margin-left:-3%;">Occupancy</h4>
                                </div>
                                <div style="float:right;">
                                    <i class="fa fa-2x fa-bars" data-toggle="modal" data-target="#occupancy_modal" aria-hidden="true"></i>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row justify-content-between align-items-stretch">
                             <div class="col-3">
                                <div id="chart-holder">
                                        <div id="chart">
                                        </div>
                                    </div>
                             </div>
                             <div class="col">

                             </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3 col-sm-6 mb-2">
                    <div type="button" class="dashboardsmallcards shadow">
                        <div class="row justify-content-between align-items-stretch">
                            <div class="col">
                                <div class="row justify-content-between align-items-stretch mb-10">
                                    <div class="col">
                                        <h4 id="adrtitle">ADR</h4>
                                    </div>
                                    <div class="col">
                                        <div style="float:right;">
                                            <i class="fa fa-2x fa-bars" data-toggle="modal" data-target="#adr-modal" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-between align-items-stretch">
                                    <div class="col" id="moneybox">
                                        <i class="fa fa-3x fa-chart-line rounded-circle border border-2 p-2" style="border-color:#1BC5BD !important;color:#1BC5BD;" aria-hidden="true"></i>
                                    </div>
                                    <div class="col align-self-end">
                                        <span id="adrblock" class=" font-weight-bolder text-dark font-size-h2 d-block text-right">
                                            {{ showPriceWithCurrency($average) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3 col-sm-6 mb-2">
                    <div type="button" class="dashboardsmallcards shadow">
                        <div class="row">
                            <div class="col">
                                <div class="row justify-content-between align-items-stretch mb-5">
                                    <div class="col">
                                        <h4 style="margin-left:-2%;" id="revenueTitle">Hotel Revenue</h4>
                                    </div>
                                    <div class="col">
                                        <div style="float:right;">
                                            <i class="fa fa-2x fa-bars" data-toggle="modal" data-target="#revenue-modal" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-between align-items-stretch">
                                    <div class="col" id="moneybox">
                                        <i class="fa fa-coins la-3x rounded-circle border border-2 p-2" style="border-color:#1BC5BD !important;color:#1BC5BD;"></i>
                                    </div>
                                    <div class="col align-self-end">
                                        <span id="revenueValue" class=" font-weight-bolder text-dark font-size-h2 d-block text-right">
                                            {{ showPriceWithCurrency($hotelRevenueTotal) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3 col-sm-6 mb-2">
                    <div type="button" class="dashboardsmallcards shadow">
                        <div class="row">
                            <div class="col">
                                <div class="row justify-content-between align-items-stretch mb-14">
                                    <div class="col">
                                        <h4 style="margin-left:-2%;display: inline-block !important;white-space: nowrap;">
                                            Available
                                            Rooms</h4>
                                    </div>
                                    <div class="col">
                                        {{-- <div class="form-style-6 float-right">
                                            <input type="date" class="filter-date" onchange="getNewEmptyRooms(this)" value="{{ today()->toDateString() }}" />
                                        </div> --}}
                                        <div style="float:right;">
                                            <i class="fa fa-2x fa-bars" data-toggle="modal" data-target="#rooms-availability-date-model" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-between align-items-stretch">
                                    <div class="col" id="moneybox">
                                        <i class="fas fa-door-open la-3x rounded-circle border border-2 p-2" style="border-color:#1BC5BD !important;color:#1BC5BD;margin-top:-30px;"></i>
                                    </div>
                                    <div class="col">
                                        <span class=" font-weight-bolder text-dark font-size-h2 d-block mt-1 text-right" id="new-empty-rooms">
                                            {{ $sumEmptyRooms }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Modals --}}
                <div class="modal fade" id="occupancy_modal" style="border-radius:0px !important;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" style="max-width:300px !important;min-width:300px !important;">
                        <div class="modal-content rounded-0">
                            <div class="modal-header shadow-sm" style="border-radius:0px !important;z-index:10;">
                                <h5 style="text-align:center;margin-left:25%;" class="modal-title text-dark text-center" id="adrmodaltitle">Occupancy Index</h5>
                            </div>
                            <div class="modal-body" style="position:relative;background-color:#fff;">
                                <div class="form-style-61" id="">
                                    <select class="infbtn" id="dropdownocc" style="background-color:rgba(0,0,0,0);">
                                        <option value="Daily">Daily</option>
                                        <option value="Monthly">Monthly</option>
                                        <option value="Yearly">Yearly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer" style="background-color:#fff;">
                                <span type="button" id="occupancy-model-ok-btn" class="infbtn close" style="color:green;max-width:100px !important;min-width:100px !important" data-dismiss="modal" style=''>OK</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="adr-modal" style="border-radius:0px !important;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" style="max-width:300px !important;min-width:300px !important;">
                        <div class="modal-content rounded-0">
                            <div class="modal-header shadow-sm" style="border-radius:0px !important;z-index:10;">
                                <h5 style="text-align:center;margin-left:37%;" class="modal-title text-dark text-center" id="adrmodaltitle">KPI
                                    Index</h5>
                            </div>
                            <div class="modal-body" style="position:relative;background-color:#fff;">
                                <div class="form-style-61" id="">
                                    <select class="infbtn" id="dropdown1" style="background-color:rgba(0,0,0,0);">
                                        <option value="ADR">ADR</option>
                                        <option value="RevPar">RevPar</option>
                                        <option value="CPOR">CPOR</option>
                                        <option value="CosPerB">CosPerB</option>
                                        <option value="LOS">LOS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer" style="background-color:#fff;">
                                <span type="button" class="infbtn close" style="color:green;max-width:100px !important;min-width:100px !important" data-dismiss="modal" style=''>OK</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="revenue-modal" style="border-radius:0px !important;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" style="max-width:300px !important;min-width:300px !important;">
                        <div class="modal-content rounded-0">
                            <div class="modal-header shadow-sm" style="border-radius:0px !important;z-index:10;">
                                <h5 style="text-align:center;margin-left:25%;" class="modal-title text-dark text-center" id="adrmodaltitle">
                                    Revenue Index</h5>
                            </div>
                            <div class="modal-body" style="position:relative;background-color:#fff;">
                                <div class="form-style-61" id="">
                                    <select class="infbtn" id="dropdownRevenue" style="background-color:rgba(0,0,0,0);margin-left:0%;">
                                        <option value="Hotel Revenue">Hotel Revenue</option>
                                        <option value="Accommodation">Accommodation</option>
                                        <option value="F&B Breakfast">F&B Breakfast</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer" style="background-color:#fff;">
                                <span type="button" class="infbtn close" style="color:green;max-width:100px !important;min-width:100px !important" data-dismiss="modal" style=''>OK</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="rooms-availability-date-model" style="border-radius:0px !important;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
                    <div class="modal-dialog modal-dialog-scrollable" style="max-width:300px !important;min-width:300px !important;">
                        <div class="modal-content rounded-0">

                            <input type="date" value="{{ today()->format('Y-m-d') }}" style="display: none;" id="rooms-availability-date-model-date-picker-date"></input>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-lg-8">
                <div class="row hor-card-row">
                    <div class="col-md-3">
                        <div class="card">
                            <i class="far fa-bell"></i>
                            <span>2</span>
                            <p>Number of reservation created today</p>
                            <a href="#" class="btn btn-info">Newly Created Today</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <i class="far fa-bell"></i>
                            <span>2</span>
                            <p>Number of reservation created today</p>
                            <a href="#" class="btn btn-info">Newly Created Today</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <i class="far fa-bell"></i>
                            <span>2</span>
                            <p>Number of reservation created today</p>
                            <a href="#" class="btn btn-info">Newly Created Today</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <i class="far fa-bell"></i>
                            <span>2</span>
                            <p>Number of reservation created today</p>
                            <a href="#" class="btn btn-info">Newly Created Today</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="" style="display: grid;grid-template-rows: 1fr 1fr 1fr;row-gap: 1rem;height: 370px;">
                    <a href="#" class="card w-100 flex-row px-8" style="background-color: #ffa800;gap: 1rem;color: white;align-items: center;">
                        <i class="fas fa-folder-open" style="font-size: 4rem;color: white;"></i>
                        <div class="d-flex flex-column">
                            <h5>Create Reservation</h5>
                            <span>Add a new reservation for new booking</span>
                        </div>
                    </a>
                    <a href="#" class="card w-100 flex-row px-8" style="background-color: #ffa800;gap: 1rem;color: white;align-items: center;">
                        <i class="fas fa-bed" style="font-size: 4rem;color: white;"></i>
                        <div class="d-flex flex-column">
                            <h5>Room Status</h5>
                            <span>Add a new reservation for new booking</span>
                        </div>
                        <div class="m-auto">
                            <div class="card" style="color: #00ffff; text-align:center">
                                79/80 available
                            </div>
                        </div>
                    </a>
                    <a href="#" class="card w-100 flex-row px-8" style="background-color: #00ffff;gap: 1rem;color: white;align-items: center;">
                        <i class="fas fa-folder-open" style="font-size: 4rem;color: white;"></i>
                        <div class="d-flex flex-column">
                            <h5>Create Reservation</h5>
                            <span>Add a new reservation for new booking</span>
                        </div>
                    </a>

                </div>
            </div>
        </div> --}}

        <div class="row mt-5">
            <div class="col-lg-7">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Arrivals
                            <span class="badge badge-offer">{{ $checkInCount }}</span>
                        </a>
                        <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Departures
                            <span class="badge badge-offer">{{ $checkOutCount }}</span>
                        </a>
                        <a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">In-House
                            <span class="badge badge-offer">{{ $inHouseCount }}</span>
                        </a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="w-100 bg-white p-5">
                            @livewire('home.check-in-today')
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="w-100 bg-white p-5">
                            @livewire('home.check-out-today')
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <div class="w-100 bg-white p-5">
                            @livewire('home.in-house')
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="w-100 bg-white">
                    @livewire('home.notification')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <script>
        $(document).ready(function() {


            $("#dropdown1").change(function(e) {
                var selectedValue = $('#dropdown1').val();
                $("#adrtitle").html(selectedValue);
                if (selectedValue == 'RevPar') {
                    $("#adrblock").html('{{ showPriceWithCurrency($revpar) }}');
                }
                if (selectedValue == 'ADR') {
                    $("#adrblock").html('{{ showPriceWithCurrency($average) }}');
                }
                if (selectedValue == 'CPOR') {
                    $("#adrblock").html('{{ showPriceWithCurrency($cpor) }}');
                }
                if (selectedValue == 'CosPerB') {
                    $("#adrblock").html('{{ showPriceWithCurrency($cosperb) }}');
                }
                if (selectedValue == 'LOS') {
                    $("#adrblock").html('{{ $los }}');
                }
                if (selectedValue == 'LOS') {
                    $("#moneybox").hide();
                } else {
                    $("#moneybox").show();
                }
            });

            $("#dropdownRevenue").change(function(e) {
                var selectedValue = $("#dropdownRevenue").val();
                $("#revenueTitle").html(selectedValue);
                if (selectedValue == 'Hotel Revenue') {
                    $("#revenueValue").html('{{ showPriceWithCurrency($hotelRevenueTotal) }}');
                }
                if (selectedValue == 'Accommodation') {
                    $("#revenueValue").html('{{ showPriceWithCurrency($accomRevenue) }}');
                }
                if (selectedValue == 'F&B Breakfast') {
                    $("#revenueValue").html('{{ showPriceWithCurrency($monthlyBreakfast) }}');
                }
            });
        })
    </script>
    <script>
        document.getElementById("occupancy-model-ok-btn").addEventListener("click", e => {
            let index = document.getElementById("dropdownocc").value;
            if (index == "Daily") {
                makeOccupancyChart({{ $occupancy }})
            } else if (index == "Monthly") {
                makeOccupancyChart({{ $monthlyoccupancy }})
            } else if (index == "Yearly") {
                makeOccupancyChart({{ $yearlyoccupancy }})
            }
        });

        function makeOccupancyChart(value) {
            console.log(value);
            document.querySelector("#chart-holder").innerHTML = `
                <div id="chart"></div>
            `;

            var options = {
                chart: {
                    height: 100,
                    type: "radialBar",
                },
                series: [value],
                colors: ["#87D4F9"],
                plotOptions: {
                    radialBar: {
                        hollow: {
                            margin: 0,
                            size: "60%",
                            background: "rgba(0,0,0,0)"
                        },
                        track: {
                            dropShadow: {
                                enabled: true,
                                top: 2,
                                left: 0,
                                blur: 4,
                                opacity: 0.15
                            }
                        },
                        dataLabels: {
                            name: {
                                offsetY: -10,
                                color: "#A9A3A3",
                                fontSize: "12px"
                            },
                            value: {
                                offsetY: -6,
                                color: "#A9A3A3",
                                fontSize: "20px",
                                fontWeight: "bold",
                                show: true
                            }
                        }
                    }
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        shade: "dark",
                        type: "vertical",
                        gradientToColors: ["#005C97"],
                        stops: [0, 100]
                    }
                },
                stroke: {
                    lineCap: "round"
                },
                labels: [""]
            };
            chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        }

        makeOccupancyChart({{ $occupancy }});

        function getNewEmptyRooms(input, val = false) {
            let date;
            if (val) {
                date = input;
            } else {
                date = input.value;
            }
            $.ajax({
                url: "/getAvailableRoomsByDate",
                type: "GET",
                data: {
                    date: date
                },
                success: function(data) {
                    document.getElementById("new-empty-rooms").textContent = data.sumEmptyRooms;
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $(".modify").click(function() {
                let reservationId = $(this).attr("data-ref");
                if (reservationId) {
                    window.location.href = "/edit-reservation/" + reservationId;
                }
            })

            $("#rooms-availability-date-model-date-picker-date").flatpickr({
                inline: true,
                onChange: function(selectedDates, dateStr, instance) {
                    $("#rooms-availability-date-model").modal('hide');
                    getNewEmptyRooms(dateStr, true);
                },
            });
        })
    </script>
    @if ($showCashier)
        <script>
            /*  $("#closeCashier").modal('show');
                                                                                                                                                                                                                            $("#closeCashierHead").text(`Close {{ $cashRegisterDate }} Cashier`); */

            const registerDate = `{{ $cashRegisterDate }}`;
            if ((new Date(registerDate)) < (new Date())) {
                $("#closeCashier").modal('show');
                $("#closeCashierHead").text(`Close ${registerDate.split(" ")[0]} Cashier`);
                $("#closeCashier-a-tag-href").attr("href", `daily-cashier?date=${registerDate.split(" ")[0]}`);
            }
        </script>
    @endif

    {{-- Tooltips --}}
    <script>
        let tippyInstances = [];
        $(document).on("mouseenter", ".tippy-tooltip", function() {
            tippyInstances = tippy('.tippy-tooltip', {
                content(reference) {
                    const htmlData = reference.getAttribute('data-title');
                    return htmlData;
                },
                allowHTML: true,
            });
        });
        $(document).on("mouseleave", ".tippy-tooltip", function() {
            for (let i = 0; i < tippyInstances.length; i++) {
                const element = tippyInstances[i];
                if (element && typeof element.destroy === "function") {
                    element.destroy();
                }
            }
        });
    </script>
@endpush


{{-- <div class="container-fluid">
    @livewire('home.stats')
    <div class="row mb-30 mt-10">
        <div class="col-md-6">
            @livewire('home.check-in-today')
        </div>
        <div class="col-md-6">
            @livewire('home.check-out-today')
        </div>
        <div class="col-md-6">
            @livewire('home.in-house')
        </div>
        <div class="col-md-6">
            @livewire('home.notification')
        </div>
    </div>
</div> --}}

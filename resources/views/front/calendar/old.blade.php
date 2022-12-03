@extends('layouts.master')
@push('styles')
    <link href="{{ asset('css/calendar.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .mycstm {
            width: unset !important;
            height: unset !important;
            padding: .1em 1em;
        }
    </style>
@endpush
@section('content')
    <div class="d-flex flex-column-fluid mt-10 d-print-none">
        <div class="container-fluid">
            <div class="card card-custom">
                <div class="container-fluid">
                    <div class="row ">
                        <div class="col-12 d-flex flex-column justify-content-center align-self-center">
                            <div class="row" style="margin-top:-40px !important;">
                                <div id="calendarPicker" style="display:none;" class="col-3 forcalendar"></div>
                                <div class="col-12">
                                    <div class="row"
                                        style="margin-top:65px;margin-left:15px; margin-right:15px !important;">
                                        <div class="col-4">
                                            <button class="mycstm text-light gradient-bg shadow editBtn" onclick="location.href='{{ route('calendar', ['date' => $date->copy()->subMonth()->startOfMonth()->format('Y-m-d')]) }}';"
                                                title="Previous">
                                                <i style="color:white;" class="fas fa-chevron-circle-left"></i>
                                            </button>
                                            <button class="mycstm1 text-light gradient-bg shadow editBtn"
                                                id="btntext">{{ $date->format("F Y") }}</button>
                                            <button class="mycstm text-light gradient-bg shadow editBtn" onclick="location.href='{{ route('calendar', ['date' => $date->copy()->addMonth()->startOfMonth()->format('Y-m-d')]) }}';"
                                                title="Next">
                                                <i style="color:white;" class="fas fa-chevron-circle-right"></i>
                                            </button>
                                        </div>
                                        <div class="col-8">
                                            <div class="float-right">
                                                <button onclick="location.href='{{ route('new-reservation') }}'"
                                                    class="mycstm text-light gradient-bg shadow editBtn"
                                                    title="Create New Reservation">
                                                    <i style="color:white; width: 10px;" class="fas fa-plus"></i>
                                                </button>
                                                <button id="editreservation"
                                                    class="mycstm text-light gradient-bg shadow editBtn modalbtn33"
                                                    title="Edit Reservation" style=""><i style="color:white;"
                                                        class="fas fa-pen"></i>
                                                </button>
                                                <button id="splitreservation"
                                                    class="mycstm text-light gradient-bg shadow editBtn" style=""
                                                    title="Split Reservation"><i style="color:white;"
                                                        class="fas fa-cut"></i>
                                                </button>
                                                <button id="movereservation"
                                                    class="mycstm text-light gradient-bg shadow editBtn modalbtn33"
                                                    style="" title="Move Reservation"><i style="color:white;"
                                                        class="fas fa-arrows-alt"></i>
                                                </button>
                                                <button id="resizereservation"
                                                    class="mycstm text-light gradient-bg shadow editBtn" style=""
                                                    title="Resize Reservation"><i style="color:white;"
                                                        class="fas fa-arrows-alt-h"></i>
                                                </button>
                                                {{-- <div class="col"> --}}
                                                {{-- <button id="deletereservation" --}}
                                                {{-- class="mycstm text-light gradient-bg shadow editBtn" --}}
                                                {{-- style="" title="Delete Reservation"> --}}
                                                {{-- <i style="color:white;" class="fa fa-trash"></i> --}}
                                                {{-- </button> --}}
                                                {{-- </div> --}}
                                                <button id="ooroom" class="mycstm text-light gradient-bg shadow editBtn"
                                                    style="" title="Create New Out Of Order Room"><i
                                                        style="color:white;" class="fas fa-user-slash"></i></button>
                                                <button id="" class="mycstm text-light gradient-bg shadow editBtn"
                                                    style="" title="Restrictions" onclick="showStopsell()"><i
                                                        style="color:white;" class="fas fa-exclamation"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card-body">
                                <table class="table table-bordered  shadow" id="calendar" data-date="{{ $date }}"
                                    style="max-width: 100% !important;">
                                    <thead style="max-width: 100% !important;">
                                        <tr class="header_row bg-primary text-light">
                                            <th colspan="100%" class="text-center" style="height:10px !important;">
                                                <h1 class="month_title" id="tabtitle">{{ $date->format('F Y') }}</h1>
                                            </th>
                                        </tr>
                                        <tr class="header_row bg-primary text-light headr" id="tabhead">
                                        </tr>
                                    </thead>
                                    <tbody id="tabbody" style="max-width: 100% !important;">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- load modals --}}
    @include('front.calendar.modals.resize_modal')
    @include('front.calendar.modals.room_modals')
    @include('front.calendar.modals.split_modal')
    @include('front.calendar.modals.move_modal')
    @include('front.calendar.modals.stop_sell_modal')
    @include('front.calendar.modals.daily_rate_modal')
    @include('front.calendar.modals.delete_modal')
    {{-- @foreach (glob(base_path() . '/resources/views/front/calendar/modals/*.blade.php') as $file) --}}
    {{-- @include('front.calendar.modals.' . basename(str_replace('.blade.php', '', $file))) --}}
    {{-- @endforeach --}}
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            var date = new Date("{{ $date }}");
            var currentMonthString = date.toLocaleString('default', {
                month: 'long'
            });
            var year = date.getFullYear();
            var month = date.getMonth();
            month = month + 1;
            // var nb = document.getElementById("nextbtn");
            // nb.value = month + "-" + year;
            // var pb = document.getElementById("pastbtn");
            // pb.value = month + "-" + year;
            // var btnTitle = document.getElementById("btntext");
            // btnTitle.innerHTML = currentMonthString + " " + year;
        });

        // $("#nextbtn").click(function() {
        //     var myv = $(this).val();
        //     var res = myv.split("-");
        //     var mymonth = res[0];
        //     var myyear = res[1];
        //     mymonth = parseInt(mymonth);
        //     myyear = parseInt(myyear);
        //     if (mymonth == 12) {
        //         mymonth = 1;
        //         myyear = myyear + 1;

        //         var myd = myyear + "-" + mymonth + "-01";
        //         var newval = mymonth + "-" + myyear;
        //         this.value = newval;

        //         var pb = document.getElementById("pastbtn");
        //         pb.value = mymonth + "-" + myyear;
        //         $("#calendarPicker").datepicker('setDate', new Date(myd));
        //     } else {
        //         mymonth = mymonth + 1;
        //         var myd = myyear + "-" + mymonth + "-01";
        //         var newval = mymonth + "-" + myyear;
        //         this.value = newval;
        //         var pb = document.getElementById("pastbtn");
        //         pb.value = mymonth + "-" + myyear;
        //         $("#calendarPicker").datepicker('setDate', new Date(myd));
        //     }

        // });
        // $("#pastbtn").click(function() {
        //     var myv = $(this).val();
        //     var res = myv.split("-");
        //     var mymonth = res[0];
        //     var myyear = res[1];
        //     mymonth = parseInt(mymonth);
        //     myyear = parseInt(myyear);
        //     if (mymonth == 1) {
        //         mymonth = 12;
        //         myyear = myyear - 1;

        //         var myd = myyear + "-" + mymonth + "-01";
        //         var newval = mymonth + "-" + myyear;
        //         this.value = newval;

        //         var nb = document.getElementById("nextbtn");
        //         nb.value = mymonth + "-" + myyear;
        //         $("#calendarPicker").datepicker('setDate', new Date(myd));
        //     } else {
        //         mymonth = mymonth - 1;
        //         var myd = myyear + "-" + mymonth + "-01";
        //         var newval = mymonth + "-" + myyear;
        //         this.value = newval;
        //         var nb = document.getElementById("nextbtn");
        //         nb.value = mymonth + "-" + myyear;
        //         $("#calendarPicker").datepicker('setDate', new Date(myd));
        //     }

        // });
        var KTBootstrapDatepicker = function() {
            var arrows;
            if (KTUtil.isRTL()) {
                arrows = {
                    leftArrow: '<i class="la la-angle-right"></i>',
                    rightArrow: '<i class="la la-angle-left"></i>'
                }
            } else {
                arrows = {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            }

            // Private functions
            var demos = function() {
                // minimum setup
                $('#kt_datepicker_1').datepicker({
                    format: 'yyyy-mm-dd',
                    rtl: KTUtil.isRTL(),
                    todayHighlight: true,
                    orientation: "bottom left",
                    templates: arrows
                });

                // minimum setup for modal demo
                $('#kt_datepicker_1_modal').datepicker({
                    format: 'yyyy-mm-dd',
                    rtl: KTUtil.isRTL(),
                    todayHighlight: true,
                    orientation: "bottom left",
                    templates: arrows
                });

                // input group layout
                $('#kt_datepicker_2').datepicker({
                    format: 'yyyy-mm-dd',
                    rtl: KTUtil.isRTL(),
                    todayHighlight: true,
                    orientation: "bottom left",
                    templates: arrows
                });

                // input group layout for modal demo
                $('#kt_datepicker_2_modal').datepicker({
                    format: 'yyyy-mm-dd',
                    rtl: KTUtil.isRTL(),
                    todayHighlight: true,
                    orientation: "bottom left",
                    templates: arrows
                });

                // enable clear button
                $('#kt_datepicker_3, #kt_datepicker_3_validate').datepicker({
                    format: 'yyyy-mm-dd',
                    rtl: KTUtil.isRTL(),
                    todayBtn: "linked",
                    clearBtn: true,
                    todayHighlight: true,
                    templates: arrows
                });

                // enable clear button for modal demo
                $('#kt_datepicker_3_modal').datepicker({
                    format: 'yyyy-mm-dd',
                    rtl: KTUtil.isRTL(),
                    todayBtn: "linked",
                    clearBtn: true,
                    todayHighlight: true,
                    templates: arrows
                });


                // range picker
                $('#kt_datepicker_5').datepicker({
                    format: 'yyyy-mm-dd',
                    rtl: KTUtil.isRTL(),
                    todayHighlight: true,
                    templates: arrows
                });

                // inline picker
                $('#kt_datepicker_6').datepicker({
                    format: 'yyyy-mm-dd',
                    rtl: KTUtil.isRTL(),
                    todayHighlight: true,
                    templates: arrows
                });
                $('#kt_datepicker_7').datepicker({
                    format: 'yyyy-mm-dd',
                    rtl: KTUtil.isRTL(),
                    todayHighlight: true,
                    templates: arrows
                });
                $('#kt_datepicker_8').datepicker({
                    format: 'yyyy-mm-dd',
                    rtl: KTUtil.isRTL(),
                    todayHighlight: true,
                    templates: arrows
                });
                $('#kt_datepicker_9').datepicker({
                    format: 'yyyy-mm-dd',
                    rtl: KTUtil.isRTL(),
                    todayHighlight: true,
                    templates: arrows
                });
                $('#kt_datepicker_10').datepicker({
                    format: 'yyyy-mm-dd',
                    rtl: KTUtil.isRTL(),
                    todayHighlight: true,
                    templates: arrows
                });
            }

            return {
                // public functions
                init: function() {
                    demos();
                }
            };
        }();
        var KTBootstrapTimepicker = function() {
            var demos = function() {
                $('#kt_timepicker_1, #kt_timepicker_1_modal').timepicker();
                $('#kt_timepicker_2, #kt_timepicker_2_modal').timepicker({
                    minuteStep: 1,
                    defaultTime: '',
                    showSeconds: true,
                    showMeridian: false,
                    snapToStep: true
                });

                // default time
                $('#kt_timepicker_3, #kt_timepicker_3_modal').timepicker({
                    defaultTime: '11:45:20 AM',
                    minuteStep: 1,
                    showSeconds: true,
                    showMeridian: true
                });

                // default time
                $('#kt_timepicker_4, #kt_timepicker_4_modal').timepicker({
                    defaultTime: '10:30:20 AM',
                    minuteStep: 1,
                    showSeconds: true,
                    showMeridian: true
                });
            }
            return {
                init: function() {
                    demos();
                }
            };
        }();
        jQuery(document).ready(function() {
            KTBootstrapTimepicker.init();
        });
        jQuery(document).ready(function() {
            KTBootstrapDatepicker.init();
        });
        $('#calendarPicker').datepicker({
            language: "nl",
            calendarWeeks: true,
            todayHighlight: true
        });
        $("#newreserv").click(function() {
            window.location.replace("newform.php");
        });
    </script>
    <script type="text/javascript">
        var date = new Date("{{ $date }}");
        var currentMonthString = date.toLocaleString('default', {
            month: 'long'
        });
        var year = date.getFullYear();
        var month = date.getMonth();
        var cday = date.getDate();
        var daysinMonth = new Date(year, month + 1, 0).getDate();
        var calendarTitle = document.getElementById("tabtitle");
        calendarTitle.innerHTML = currentMonthString + " " + year;
        loadTimeline(daysinMonth, year, month);

        function loadTimeline(daysinMonth, year, month) {
            $("#calendar").css('border-collapse', 'separate');
            var days = daysinMonth;
            var year = year;
            var cmonth = month;
            var month = cmonth + 1;
            var tabhead = document.getElementById("tabhead");
            tabhead.innerHTML = "";
            var data = ' <th scope="col"  style="" class="sticky_col"><b><h6>Rooms</h6></b></th>';
            tabhead.innerHTML += data;
            var elmnts = ""
            var typeelmnts = ""
            for (var i = 1; i <= days; i++) {
                var day = new Date(year + "-" + month + "-" + i).toLocaleDateString('default', {
                    weekday: 'short'
                });
                var data = '<th scope="col text-center" style="">' + day + '<br><span class="text-center" > ' + i +
                    '</span></th>';
                if (day == 'S') {
                    var cols = "<td  class='weekend'></td>";
                    var typecols =
                        "<td class='weekend justify-content-center' data-custom='roomtype'><span class='typespan'></span>" +
                        "<span class='restrictspan' data-toggle='tooltip' data-placement='top' data-html='true' title='' ></span></td>";
                } else {
                    var cols = "<td  ></td>";
                    var typecols =
                        "<td data-custom='roomtype' class='justify-content-center'><span class='typespan'></span>" +
                        "<span class='restrictspan' data-toggle='tooltip' data-placement='top' data-html='true' title='' ></span></td>";
                }
                tabhead.innerHTML += data;
                elmnts += cols;
                typeelmnts += typecols;
            }
            loadRooms(days, cmonth, year, elmnts, typeelmnts);
        }

        function loadRooms(daysinMonth, cmonth, year, elmnts, typeelmnts) {
            var days = daysinMonth;
            var cmonth = cmonth;
            var cyear = year;
            var elmnts = elmnts;
            var ccm = ('0' + (cmonth + 1)).slice(-2);
            var typeelmnts = typeelmnts;
            $.ajax({
                type: "POST",
                url: "{{ route('getTimelineRooms') }}",
                data: {
                    year: cyear,
                    month: ccm
                },
                success: function(args) {
                    var verticalLine = document.getElementById("tabbody");
                    verticalLine.innerHTML = "";
                    for (var i = 0; i < args.length; i++) {
                        var key = Object.keys(args[i]);
                        if (key == "type") {
                            var data = "<tr id='" + args[i][key]["id"] +
                                "' class='type'><th class='sticky_col' style=' border:1px solid white !important;'><span class='stick'>" +
                                args[i][key]["type"].charAt(0).toUpperCase() + args[i][key]["type"].slice(1) +
                                "</span><span style='float:right;'><i class='bi bi-link-45deg showrates' style='font-size:16px;' data-toggle='tooltip' data-placement='right' data-html='true' ></i></span></th>" +
                                typeelmnts + "</tr>";
                            verticalLine.innerHTML += data;
                        }
                        if (key == "room") {
                            var data = "<tr id='rom" + args[i][key]['name'] +
                                "'class='room'><td class='rooms sticky_col'><span class='stick'>" + args[i][key]
                                ['name'] +
                                "</span><span style='float:right;'><i class='bi bi-info-circle roominfo' data-value='" +
                                args[i][key]['roomid'] + "'></i></span></td>" + elmnts + "</tr>";
                            verticalLine.innerHTML += data;
                        }
                    }
                    var cc = new Date("{{ $date }}");
                    var month = cc.getMonth();
                    var ccyer = cc.getFullYear();
                    var cday = cc.getDate();
                    if (ccyer == cyear) {
                        if (month == cmonth) {
                            $("#calendar thead>tr").each(function(index, td) {
                                if ($(this).hasClass("headr")) {
                                    var td = $(this).find("th:eq(" + cday + ")");
                                    td.css('backgroundColor', "grey");
                                    $(this).find('th:contains("S")').css('backgroundColor', "#2874A6");
                                }
                            });
                            $("#tabbody tr").each(function(index, td) {
                                if ($(this).hasClass("type")) {
                                    var day = cday - 1;
                                    var td = $(this).find("td:eq(" + day + ")");
                                    td.css('backgroundColor', "grey");
                                } else {
                                    var td = $(this).find("td:eq(" + cday + ")");
                                    td.css('backgroundColor', "grey");
                                }
                            });
                        }
                    } else {}
                    $("#calendar thead>tr").each(function(index, td) {
                        if ($(this).hasClass("headr")) {
                            $(this).find('th:contains("S")').css('backgroundColor', "#2874A6");
                        }
                    });
                    var cc = new Date("{{ $date }}");
                    var month = cc.getMonth();
                    var ccyer = cc.getFullYear();
                    var cday = cc.getDate();
                    // var indexarray=[];
                    if (ccyer == cyear) {
                        if (month == cmonth) {
                            $("#calendar thead>tr").each(function(index, td) {
                                if ($(this).hasClass("headr")) {
                                    var td = $(this).find("th:eq(" + cday + ")");
                                    td.css('backgroundColor', "grey");
                                    $(this).find('th:contains("S")').css('backgroundColor', "#2874A6");
                                }
                            });
                            $("#tabbody tr").each(function(index, td) {
                                if ($(this).hasClass("type")) {
                                    var day = cday - 1;
                                    var td = $(this).find("td:eq(" + day + ")");
                                    td.css('backgroundColor', "grey");
                                } else {
                                    var td = $(this).find("td:eq(" + cday + ")");
                                    td.css('backgroundColor', "grey");
                                }
                            });
                        }
                    } else {}
                    $("#calendar thead>tr").each(function(index, td) {
                        if ($(this).hasClass("headr")) {
                            $(this).find('th:contains("S")').css('backgroundColor', "#2874A6");
                        }
                    });
                    loadRatesInfo();
                    loadReservation(cyear, cmonth);
                }
            });
        }

        function loadRatesInfo() {
            $.ajax({
                url: "{{ route('loadRatesInfo') }}",
                type: "POST",
                success: function(data) {
                    for (var i = 0; i < data.length; i++) {
                        $("#tabbody #" + data[i]["id"] + " .showrates").attr('data-original-title', data[i][
                            "tooltip"
                        ]);
                    }
                }

            })
        }

        function loadReservation(year, month) {
            $.ajax({
                type: "POST",
                url: "{{ route('getReservations') }}",
                data: {
                    "year": year,
                    "month": month + 1
                },
                success: function(args) {
                    for (var i = 0; i < args.length; i++) {
                        var name = args[i]['text'];
                        var texts = args[i]['bubbleHtml'];
                        var checkin = args[i]['start'];
                        var checkout = args[i]['end'];
                        var room = args[i]['resource1'];
                        var status = args[i]['status'];
                        var id = args[i]['id'];
                        var orgcheckout = args[i]['checkoutorg'];
                        var orgdate = new Date(orgcheckout);
                        var orgmonth = orgdate.getMonth();
                        var date = new Date(checkin);
                        var day = date.getDate();
                        var chckinmonth = date.getMonth();
                        var edate = new Date(checkout);
                        var eday = edate.getDate();
                        var event = eday - day;
                        var row = $("#rom" + room).children();
                        var div = document.createElement("div");
                        div.className = "reservdiv";
                        var labelDiv = document.createElement("span");
                        labelDiv.className = "reservation-label";
                        labelDiv.setAttribute("data-toggle", "tooltip");
                        labelDiv.setAttribute("data-placement", "top");
                        labelDiv.setAttribute("data-html", "true");
                        labelDiv.setAttribute("title", "");
                        var nameSpan = document.createElement("span");
                        nameSpan.className = "reservation-text";
                        if (orgmonth == chckinmonth) {
                            var width = 0;
                            var height = 0;
                            for (var j = day; j < eday; j++) {
                                var tds = row.eq(j);
                                if (j == day) {
                                    width += tds.outerWidth();
                                    height = tds.innerHeight();
                                    $(tds).append(div);
                                    div.appendChild(nameSpan);
                                    div.appendChild(labelDiv);
                                    if (status == "Out Of Order") {
                                        $(nameSpan).text(status);
                                        $(div).css({
                                            "background-color": "#000",
                                            "color": "#fff"
                                        });
                                    } else {
                                        $(nameSpan).text(name);
                                        if (status == "CheckedOut") {
                                            $(div).css({
                                                "background-color": "#2F4F4F",
                                                "color": "#fff"
                                            });
                                        } else if (status == "Offer") {
                                            $(div).css({
                                                "background-color": "#800080",
                                                "color": "#fff"
                                            });
                                        } else if (status == "Arrived") {
                                            $(div).css({
                                                "background-color": "#fbc312"
                                            });
                                        } else {
                                            $(div).css({
                                                "background-color": "#0b6623",
                                                "color": "#fff"
                                            });
                                        }
                                    }
                                } else if (j == (eday - 1)) {
                                    width += tds.outerWidth();
                                } else {
                                    width += tds.outerWidth();
                                }
                                $(labelDiv).attr('data-original-title', texts);
                                $(tds).val(id);
                                $(tds).addClass("event");
                            }
                            width = width - 4;
                            height = height - 5;
                            $(div).css({
                                "width": width + "px",
                                "height": height + "px",
                                "line-height": height + "px"
                            });
                        } else {
                            var width = 0;
                            var height = 0;
                            var div = document.createElement("div");
                            div.className = "reservdiv";
                            for (var j = day; j <= eday; j++) {
                                var tds = row.eq(j);
                                if (status == "Out Of Order") {
                                    $(div).css({
                                        "background-color": "#000",
                                        "color": "#fff"
                                    });
                                } else if (status == "Offer") {
                                    $(div).css({
                                        "background-color": "#800080",
                                        "color": "#fff"
                                    });
                                } else if (status == "CheckedOut") {
                                    $(div).css({
                                        "background-color": "#2F4F4F",
                                        "color": "#fff"
                                    });
                                } else if (status == "Arrived") {
                                    $(div).css({
                                        "background-color": "#fbc312"
                                    });
                                } else {
                                    $(div).css({
                                        "background-color": "#0b6623",
                                        "color": "#fff"
                                    });
                                }
                                if (j == day) {
                                    width += tds.outerWidth();
                                    height = tds.innerHeight();
                                    $(tds).append(div);
                                    div.appendChild(nameSpan);
                                    div.appendChild(labelDiv);
                                    if (status == "Out Of Order") {

                                        $(nameSpan).text(status);
                                    } else {

                                        $(nameSpan).text(name);
                                    }
                                } else if (j == eday) {

                                    width += tds.outerWidth();
                                } else {
                                    width += tds.outerWidth();

                                }
                                $(labelDiv).attr('data-original-title', texts);

                                $(tds).val(id);
                                $(tds).addClass("event");

                            }
                            width = width - 2;
                            height = height - 5;

                            $(div).css({
                                "width": width + "px",
                                "height": height + "px",
                                "line-height": height + "px"
                            });

                        }
                    }
                    loadEmptyData(month, year);
                }
            });
        }

        var totaldaysofBooking = 0;
        $("#ooroom").click(function() {
            var edroommodal = document.getElementById("Roomoutoforder");
            edroommodal.style.display = "block";
        });
        $("#closeoooroom").click(function() {
            var edroommodal = document.getElementById("Roomoutoforder");
            edroommodal.style.display = "none";
        });

        function roomooocancel() {
            var edroommodal = document.getElementById("Roomoutoforder");
            edroommodal.style.display = "none";
        }

        function roomoutoforder() {
            var edroommodal = document.getElementById("Roomoutoforder");

            var roomidooo = document.getElementById("roomooo").value;
            var startdate = document.getElementById("startdate").value;
            var enddate = document.getElementById("enddate").value;
            var reason = document.getElementById("ooreason").value;
            if (startdate > enddate) {
                errorSweet("End date can't be less than start date");
            } else {
                let values = {
                    "start": startdate,
                    "end": enddate,
                    "resource": roomidooo,
                    "reason": reason
                };
                edroommodal.style.display = "none";
                $.ajax({
                    type: "POST",
                    url: "{{ route('postMaintenance') }}",
                    data: values,
                    success: function(response) {
                        (response.result == 'Error') ? errorSweet(response.message): successSweet(response
                            .message);
                        $("#Roomoutoforder").find('form').trigger('reset');
                        var date = $("#calendarPicker").datepicker('getDate');
                        $('[data-toggle="tooltip"]').tooltip('hide');
                        $("#calendarPicker").datepicker('setDate', new Date(date));
                    }
                });
            }

        }

        $("#edroom").click(function() {
            var edroommodal = document.getElementById("Roomenabledisablemodal");
            edroommodal.style.display = "block";
        });
        $("#closeedroom").click(function() {
            var edroommodal = document.getElementById("Roomenabledisablemodal");
            edroommodal.style.display = "none";
        });

        function roomedcancel() {
            var edroommodal = document.getElementById("Roomenabledisablemodal");
            edroommodal.style.display = "none";
        }

        function roomenabledisable() {
            var edroommodal = document.getElementById("Roomenabledisablemodal");
            var e = document.getElementById("roomed");
            var roomided = e.options[e.selectedIndex].value;
            var roomtypeedid = e.options[e.selectedIndex].getAttribute("data-roomtype");
            var roomstatus = document.getElementById("statused").value;
            var data = [];
            var values = {
                "status": roomstatus,
                "roomid": roomided,
                "roomtypeid": roomtypeedid
            };
            data = values;
            var json = JSON.stringify(data);
            console.log(json);
            edroommodal.style.display = "none";
            $.ajax({
                type: "POST",
                url: "backend_room_update.php",
                data: json,
                success: function(response) {
                    successSweet(response.message);
                    $("#Roomenabledisablemodal").find('form').trigger('reset');
                    var date = $("#calendarPicker").datepicker('getDate');
                    $('[data-toggle="tooltip"]').tooltip('hide');
                    $("#calendarPicker").datepicker('setDate', new Date(date));
                }
            });

        }

        $("#tabbody").on("dblclick", "td", function() {
            var id = $(this).val();
            var colroomtype = $(this).data('custom');
            var cindex = $(this).index();
            var roomtypeid = $(this).closest('tr').attr('id');
            if (cindex == 0) {} else if (id != '') {
                if (/^\d+$/.test(id)) {
                    let url = '{{ route('edit-reservation', ['id' => 'r_id']) }}'
                    url = url.replace('r_id', id);
                    window.location.replace(url);
                } else {
                    showresizereservation(id, 'dc');
                }
            } else if (colroomtype == "roomtype") {
                var date = $("#calendarPicker").datepicker('getDate');
                date = new Date(date.getFullYear() + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-01");
                date.setDate(date.getDate() + (cindex - 1));
                date = date.getFullYear() + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + ("0" + date
                    .getDate()).slice(-2);
                showStopsell(date, roomtypeid, "1");
            } else {
                window.location.replace("{{ route('new-reservation') }}");
            }
        });
        //enable disable function end...........................
        //edit function start .................................
        $("#editreservation").click(function() {
            var events = document.getElementsByClassName("event");
            for (var i = 0; i < events.length; i++) {
                var vales = events[i].value;
                events[i].setAttribute('onclick', 'showeditreservation(' + vales + ')');
            }
        });
        $("#closeedit").click(function() {
            var editrmodal = document.getElementById("editmodal");
            editrmodal.style.display = "none";
        });

        function showeditreservation(val) {
            console.log(val);
            var id = val;
            let url = '{{ route('edit-reservation', ['id' => 'r_id']) }}'
            url = url.replace('r_id', id);
            window.location.replace(url);
        }

        function btnedit() {
            var editrmodal = document.getElementById("editmodal");
            var bcode = document.getElementById("editbookingcode").value;
            var bstatus = document.getElementById("editbstatus").value;
            var rstatus = document.getElementById("editrstatus").value;
            var chargedate = document.getElementById("editkt_datepicker_4_4").value;
            var pmethods = document.getElementById("editpmethods").value;
            var pmode = document.getElementById("editpmode").value;
            var checkin = document.getElementById("editkt_datepicker_4_2").value;
            var checkout = document.getElementById("editkt_datepicker_4_3").value;
            var adults = document.getElementById("editadults").value;
            var kids = document.getElementById("editkids").value;
            var infants = document.getElementById("editinfants").value;
            var bookingdate = document.getElementById("editkt_datepicker_4_1").value;
            var arrivalhour = document.getElementById("editkt_timepicker_1").value;
            var ratetype = document.getElementById("editratetype").value;
            var roomno = document.getElementById("editroomno").value;
            var guestname = document.getElementById("editguestname").value;
            var guestemail = document.getElementById("editguestemail").value;
            var guestphone = document.getElementById("editguestphone").value;
            var country = document.getElementById("editcountry").value;
            var dailyrate = document.getElementById("editdailyrate").value;
            var comments = document.getElementById("editcomments").value;
            var reservationid = document.getElementById("editreservationid").value;
            var data = [];
            var values = {
                "id": reservationid,
                "code": bcode,
                "bstatus": bstatus,
                "status": rstatus,
                "cdate": chargedate,
                "paid": pmethods,
                "paidmodeid": pmode,
                "start": checkin,
                "end": checkout,
                "adults": adults,
                "children": kids,
                "infants": infants,
                "bdate": bookingdate,
                "ahour": arrivalhour,
                "ratetypeid": ratetype,
                "resource": roomno,
                "text": guestname,
                "email": guestemail,
                "phone": guestphone,
                "scid": country,
                "drate": dailyrate,
                "comments": comments
            };
            data = values;
            var json = JSON.stringify(data);
            editrmodal.style.display = "none";
            // console.log(json);
            $.ajax({
                type: "POST",
                url: "backend_reservation_update.php",
                data: json,
                success: function(response) {
                    successSweet(response.message);
                    $("#editmodal").find('form').trigger('reset');
                    var date = $("#calendarPicker").datepicker('getDate');
                    $('[data-toggle="tooltip"]').tooltip('hide');
                    $("#calendarPicker").datepicker('setDate', new Date(date));
                }
            });
        }

        function btneditcancel() {
            var editrmodal = document.getElementById("editmodal");
            editrmodal.style.display = "none";
        }

        $("#deletereservation").click(function() {
            var events = document.getElementsByClassName("event");
            for (var i = 0; i < events.length; i++) {
                var vales = events[i].value;
                events[i].setAttribute('onclick', 'showdeletereservation("' + vales + '")');
            }
        });
        $("#closedelete").click(function() {
            var movermodal = document.getElementById("deletemodal");
            movermodal.style.display = "none";
        });

        function showdeletereservation(val) {
            var movermodal = document.getElementById("deletemodal");
            var id = val;
            $("#bookingid").val(id);
            movermodal.style.display = "block";
            var events = document.getElementsByClassName("event");
            for (var i = 0; i < events.length; i++) {
                events[i].removeAttribute('onclick');
            }
        }

        function deletebtn() {
            var movermodal = document.getElementById("deletemodal");
            var id = document.getElementById("bookingid").value;
            if (/^\d+$/.test(id)) {
                var data = [];
                var values = {
                    "id": id
                };
                data = values;
                var json = JSON.stringify(data);
                movermodal.style.display = "none";
                $.ajax({
                    type: "POST",
                    url: "backend_reservation_delete.php",
                    data: json,
                    success: function(response) {
                        successSweet(response.message);
                        $("#deletemodal").find('form').trigger('reset');
                        var date = $("#calendarPicker").datepicker('getDate');
                        $('[data-toggle="tooltip"]').tooltip('hide');
                        $("#calendarPicker").datepicker('setDate', new Date(date));
                    }
                });
            } else {
                id = id.slice(1);
                movermodal.style.display = "none";
                $.ajax({
                    type: "POST",
                    url: "{{ route('deleteOutOfOrder') }}",
                    data: {
                        "id": id
                    },
                    success: function(response) {
                        successSweet(response.message);
                        $("#deletemodal").find('form').trigger('reset');
                        var date = $("#calendarPicker").datepicker('getDate');
                        $('[data-toggle="tooltip"]').tooltip('hide');
                        $("#calendarPicker").datepicker('setDate', new Date(date));
                    }
                });
            }
        }

        function deletecancel() {
            var movermodal = document.getElementById("deletemodal");
            movermodal.style.display = "none";
        }

        //delete function end..............................................
        //move function start .................................
        $("#movereservation").click(function() {
            var events = document.getElementsByClassName("event");
            for (var i = 0; i < events.length; i++) {
                var vales = events[i].value;
                events[i].setAttribute('onclick', 'showmovereservation(' + vales + ')');
            }

        });
        $("#closemove").click(function() {

            var movermodal = document.getElementById("movemodal");
            movermodal.style.display = "none";

        });

        function showmovereservation(val) {
            totaldaysofBooking = 0;
            console.log(val);

            var movermodal = document.getElementById("movemodal");

            var id = val;
            var moveoldroom = document.getElementById("moveoldroom");
            var checkin = "";
            var movenewroom = document.getElementById("movenewroom");
            var checkout = "";

            var reservationid = document.getElementById("movereservationid");

            document.getElementById("showmoveratebtn").disabled = true;
            var myoriginalroomtype = ""
            $.ajax({
                type: "POST",
                url: "{{ route('getRoomForSplit') }}",
                data: {
                    "id": id
                },
                success: function(response) {
                    checkin = response[0].checkin;
                    checkout = response[0].checkout;
                    var currentroomtypeid = response[0].roomtypeid;
                    $(moveoldroom).val(response[0].roomid);

                    $("#moveroomtypehidden").val(response[0].roomtypeid);
                    $("#movecheckin").val(response[0].checkin);
                    $("#movecheckout").val(response[0].checkout);
                    $("#moveoldratetype").val(response[0].ratetype);
                    $(reservationid).val(response[0].id);
                    myoriginalroomtype = response[0].roomtypeid;
                    var data = [];
                    var values = {
                        "start": checkin,
                        "end": checkout
                    };
                    data = values;
                    var json = JSON.stringify(data);
                    console.log(json);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('checkRoomAvailable') }}",
                        data: json,
                        success: function(response) {
                            console.log(response);
                            var movenewroom = document.getElementById("movenewroom");
                            var firstrow = "";
                            var secondrow = "";
                            movenewroom.innerHTML = "";
                            movenewroom.innerHTML += "<option selected disabled>Choose...</option>";
                            for (var i = 0; i < response.length; i++) {
                                if (response[i].length > 1) {
                                    var responsetypeid = response[i][0].typeid;
                                    if (responsetypeid == currentroomtypeid) {
                                        firstrow += "<option disabled class='bg-secondary'>" +
                                            response[i][0].typename + "</option>";
                                        for (var j = 1; j < response[i].length; j++) {
                                            firstrow += "<option value='" + response[i][0].typeid +
                                                "-" + response[i][j].roomid + "'  >" +
                                                response[i][j].roomnumber + "</option>";
                                        }
                                    } else {
                                        secondrow += "<option disabled class='bg-secondary'>" +
                                            response[i][0].typename + "</option>";
                                        for (var j = 1; j < response[i].length; j++) {
                                            secondrow += "<option value='" + response[i][0].typeid +
                                                "-" + response[i][j].roomid + "'  >" +
                                                response[i][j].roomnumber + "</option>";
                                        }
                                    }
                                }
                            }

                            var newrow = firstrow + secondrow;
                            movenewroom.innerHTML += newrow;
                        }
                    });
                    movermodal.style.display = "block";
                }
            });


            $("#movenewroom").change(function() {

                var splitnewroom = document.getElementById("movenewroom").value;
                var splitvalue = splitnewroom.split('-');

                var splitnewroomid = splitvalue[1];
                var splitnewroomvalue = splitvalue[0];

                var data = {
                    "id": splitnewroomvalue
                };
                $.ajax({
                    type: "POST",
                    url: "{{ route('getRateTypes') }}",
                    data: data,
                    success: function(result) {
                        showrates(result)
                    },
                })

                function showrates(emp) {

                    $("#moveratetype").html(emp);
                    var currentratetype = document.getElementById("moveoldratetype").value;
                    document.getElementById("moveratetype").value = currentratetype;

                }

                document.getElementById("showmoveratebtn").disabled = false;

            });

            var events = document.getElementsByClassName("event");
            for (var i = 0; i < events.length; i++) {
                events[i].removeAttribute('onclick');
            }

        }

        function movebtn() {

            var check_empty_dailyrate = false;
            var dailyrate = [];
            for (var i = 0; i < totaldaysofBooking; i++) {
                var label = document.getElementById("label" + i).textContent;
                var ratevalue = document.getElementById("dailyrate" + i).value;
                if (label === "" || ratevalue === "") {
                    check_empty_dailyrate = true;
                    break;

                }

                dailyrate.push({
                    "date": label,
                    "rate": ratevalue
                });
            }

            var movermodal = document.getElementById("movemodal");
            var checkin = document.getElementById("movecheckin").value;
            var checkout = document.getElementById("movecheckout").value;
            var splitnewroom = document.getElementById("movenewroom").value;
            var splitvalue = splitnewroom.split('-');

            var splitnewroomid = splitvalue[1];
            var movenewroomtype = splitvalue[0];
            var reservationid = document.getElementById("movereservationid").value;
            // var dailyratehidden=document.getElementById("movedailyratehidden").value;
            var roomtypehidden = document.getElementById("moveroomtypehidden").value;
            var moveoldroom = document.getElementById("moveoldroom").value;
            var moveratetype = document.getElementById("moveratetype").value;
            console.log("old room is " + moveoldroom);
            if (totaldaysofBooking == 0 || check_empty_dailyrate == true) {
                errorSweet("Please add daily rates");
            } else if (checkin > checkout) {
                errorSweet("Checkin can't be greater than checkout");
            } else if (splitnewroomid == "Choose..." || moveratetype == "") {
                errorSweet("Please fill all fields");
            } else {
                var data = [];
                if (movenewroomtype == roomtypehidden) {
                    var values = {
                        "id": reservationid,
                        "newStart": checkin,
                        "newEnd": checkout,
                        "newResource": splitnewroomid,
                        "oldroom": moveoldroom,
                        "ratetype": moveratetype,
                        "roomtypechanged": 0,
                        "drate": dailyrate
                    };
                } else {
                    var values = {
                        "id": reservationid,
                        "newStart": checkin,
                        "newEnd": checkout,
                        "newResource": splitnewroomid,
                        "oldroom": moveoldroom,
                        "ratetype": moveratetype,
                        "roomtypechanged": 1,
                        "drate": dailyrate
                    };
                }
                movermodal.style.display = "none";
                $.ajax({
                    type: "POST",
                    url: "{{ route('postMoveReservation') }}",
                    data: values,
                    success: function(response) {
                        successSweet(response.message);
                        $("#movemodal").find('form').trigger('reset');
                        var date = $("#calendarPicker").datepicker('getDate');
                        $('[data-toggle="tooltip"]').tooltip('hide');
                        $("#calendarPicker").datepicker('setDate', new Date(date));
                    }
                });


            }
        }

        function cancelmove() {

            var movermodal = document.getElementById("movemodal");
            movermodal.style.display = "none";
        }

        //move function end...........................
        //resize function start .................................
        $("#resizereservation").click(function() {
            var events = document.getElementsByClassName("event");
            for (var i = 0; i < events.length; i++) {
                var vales = events[i].value;
                events[i].setAttribute('onclick', 'showresizereservation("' + vales + '")');
            }
        });
        $("#closeresize").click(function() {
            var resizermodal = document.getElementById("resizemodal");
            resizermodal.style.display = "none";
        });

        //editreservation
        function showresizereservation(val, dc) {
            totaldaysofBooking = 0;
            //edit reservation modal will be here
            var resizermodal = document.getElementById("resizemodal");
            var id = val;
            var resizecheckin = document.getElementById("resizecheckin");
            var resizecheckout = document.getElementById("resizecheckout");
            var reservationid = document.getElementById("resizebookingid");
            var roomdiv = document.getElementById("roomdiv");
            var resizeroom = document.getElementById("resizeroom");
            var resizedrrow = document.getElementById("resizedratesrow");
            var resizeroomtype = document.getElementById("hiddenresizeroomtype");
            roomdiv.style.visibility = "hidden";
            resizedrrow.style.visibility = "visible";
            if (/^\d+$/.test(id)) {
                var myoriginalroomtype = ""
                $.ajax({
                    type: "POST",
                    url: "{{ route('loadResizeData') }}",
                    data: {
                        "id": id
                    },
                    success: function(response) {
                        console.log(response)
                        $(resizecheckin).val(response[0].checkin);
                        $(resizecheckout).val(response[0].checkout);
                        $("#hiddenresizecheckout").val(response[0].checkout);
                        $("#hiddenresizeroomid").val(response[0].roomid);
                        $(reservationid).val(response[0].id);
                        $(resizeroomtype).val(response[0].roomtypeid);

                        $("#restitle").html("Resize Reservation");
                        $("#idtitle").html("Reservation Id");
                        $("#stitle").html("Check In Date");
                        $("#etitle").html("Check Out Date");
                        resizermodal.style.display = "block";
                    }
                });
            } else {
                id = id.slice(1);
                var checkdc = dc;
                var myoriginalroomtype = ""
                $.ajax({
                    type: "POST",
                    url: "{{ route('getOutOfOrderForResize') }}",
                    data: {
                        "id": id
                    },
                    success: function(response) {
                        $(resizecheckin).val(response[0].checkin);
                        $(resizecheckout).val(response[0].checkout);
                        $("#hiddenresizecheckout").val(response[0].checkout);
                        $("#hiddenresizeroomid").val(response[0].roomid);
                        $(reservationid).val("a" + response[0].id);
                        $(resizeroom).val(response[0].roomno);
                        resizedrrow.style.visibility = "hidden";
                        if (checkdc == "dc") {
                            $("#restitle").html("Update Out Of order");
                            roomdiv.style.visibility = "visible";
                        } else {
                            $("#restitle").html("Resize Out Of order");
                        }

                        $("#idtitle").html("Id");
                        $("#stitle").html("Start Date");
                        $("#etitle").html("End Date");

                        document.getElementById("resizesubmit").disabled = true;
                        resizermodal.style.display = "block";
                    }
                });
            }


            $("#resizecheckout").change(function() {
                var newcheckin = document.getElementById("hiddenresizecheckout").value;
                var checkout = document.getElementById("resizecheckout").value;
                var roomid = document.getElementById("hiddenresizeroomid").value;
                var ccin = new Date(newcheckin);
                ccin.setHours(0, 0, 0, 0);
                var ccout = new Date(checkout);
                ccout.setHours(0, 0, 0, 0);
                var data = [];
                var values = {
                    "rid": roomid,
                    "start": newcheckin,
                    "end": checkout
                };
                data = values;
                var json = JSON.stringify(data);
                console.log(json);
                if (ccout > ccin) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('getAvailabilityThisRoom') }}",
                        data: json,
                        success: function(response) {
                            if (response.roomid == "yes") {
                                document.getElementById("resizesubmit").disabled = false;
                            } else if (response.roomid == "not") {
                                errorSweet("room not available");
                                document.getElementById("resizesubmit").disabled = true;
                            }
                        }
                    });
                } else {
                    document.getElementById("resizesubmit").disabled = false;
                }
            });
            var events = document.getElementsByClassName("event");
            for (var i = 0; i < events.length; i++) {
                events[i].removeAttribute('onclick');
            }

        }

        function resizebtn() {

            var check_empty_dailyrate = false;
            var dailyrate = [];
            for (var i = 0; i < totaldaysofBooking; i++) {
                var label = document.getElementById("label" + i).textContent;
                var ratevalue = document.getElementById("dailyrate" + i).value;
                if (label === "" || ratevalue === "") {
                    check_empty_dailyrate = true;
                    break;

                }

                dailyrate.push({
                    "date": label,
                    "rate": ratevalue
                });
            }

            var resizermodal = document.getElementById("resizemodal");
            var checkin = document.getElementById("resizecheckin").value;
            var checkout = document.getElementById("resizecheckout").value;
            var defaultcheckout = document.getElementById("hiddenresizecheckout").value;
            var reservationid = document.getElementById("resizebookingid").value;
            var resizeroomType = document.getElementById("hiddenresizeroomtype").value;
            const oneday = 1000 * 24 * 60 * 60;
            var chin = new Date(checkin);
            var chout = new Date(checkout);
            var startday = Date.UTC(chin.getFullYear(), chin.getMonth(), chin.getDate());
            var endday = Date.UTC(chout.getFullYear(), chout.getMonth(), chout.getDate());
            var actualdays = (endday - startday) / oneday;
            console.log("actualdays are " + actualdays);
            if (/^\d+$/.test(reservationid)) {
                if (totaldaysofBooking == 0 || check_empty_dailyrate == true || totaldaysofBooking !== actualdays) {
                    errorSweet("Please add daily rates");
                } else if (checkin > checkout) {
                    errorSweet("Checkin can't be greater than checkout");
                } else {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('getAvailabilityRoomType') }}",
                        data: {
                            "start": checkin,
                            "end": checkout,
                            "roomtype": resizeroomType
                        },
                        success: function(args) {
                            if (args.status == "Error") {
                                errorSweet("Sorry! Selected room Type is not available to sell");
                            } else {
                                var values = {
                                    "id": reservationid,
                                    "newStart": checkin,
                                    "newEnd": checkout,
                                    "current_checkout": defaultcheckout,
                                    "drate": dailyrate
                                };
                                resizermodal.style.display = "none";
                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('postResizeReservation') }}",
                                    data: values,
                                    success: function(response) {
                                        successSweet(response.message)
                                        $("#resizemodal").find('form').trigger('reset');
                                        var date = $("#calendarPicker").datepicker('getDate');
                                        $('[data-toggle="tooltip"]').tooltip('hide');
                                        $("#calendarPicker").datepicker('setDate', new Date(date));
                                    }
                                });
                            }
                        }
                    })
                }
            } else {
                reservationid = reservationid.slice(1);
                if (checkin > checkout) {
                    errorSweet("Start date can't be greater than End date");
                } else {
                    resizermodal.style.display = "none";
                    $.ajax({
                        async: true,
                        type: "POST",
                        url: "{{ route('postResizeOutOfOrder') }}",
                        data: {
                            "id": reservationid,
                            "newStart": checkin,
                            "newEnd": checkout
                        },
                        success: function(response) {
                            successSweet(response.message);
                            $("#resizemodal").find('form').trigger('reset');
                            var date = $("#calendarPicker").datepicker('getDate');
                            $('[data-toggle="tooltip"]').tooltip('hide');
                            $("#calendarPicker").datepicker('setDate', new Date(date));
                            // location.reload();
                        }
                    });
                }
            }
        }

        function cancelresize() {

            var resizermodal = document.getElementById("resizemodal");
            resizermodal.style.display = "none";
        }

        //resize function end...........................
        //split function start .................................
        $("#splitreservation").click(function() {
            var events = document.getElementsByClassName("event");
            for (var i = 0; i < events.length; i++) {
                var vales = events[i].value;
                events[i].setAttribute('onclick', 'showsplitreservation(' + vales + ')');
            }

        });
        $("#closesplit").click(function() {

            var splitrmodal = document.getElementById("splitmodal");
            splitrmodal.style.display = "none";

        });

        //editreservation
        function showsplitreservation(val) {
            totaldaysofBooking = 0;
            var splitrmodal = document.getElementById("splitmodal");
            var id = val;
            var splitguestname = document.getElementById("splitguestname");
            var splitoldroom = document.getElementById("splitoldroom");
            var checkin = document.getElementById("kt_datepicker_71");
            var newcheckout = document.getElementById("kt_datepicker_81");
            var splitnewroom = document.getElementById("splitnewroom");
            var newcheckin = document.getElementById("kt_datepicker_81");
            var checkout = document.getElementById("kt_datepicker_101");
            var dailyrate = document.getElementById("splitdailyrate");
            var reservationid = document.getElementById("splitreservationid");
            document.getElementById("splitdailyrate").disabled = true;
            var myoriginalroomtype = ""
            $.ajax({
                type: "POST",
                url: "{{ route('getRoomForSplit') }}",
                data: {
                    "id": id
                },
                success: function(response) {
                    $(checkin).val(response[0].checkin);
                    $(checkout).val(response[0].checkout);
                    $(newcheckout).attr('min', response[0].checkin);
                    $(newcheckout).attr('max', response[0].checkout);
                    $(splitoldroom).val(response[0].roomid);
                    $(splitguestname).val(response[0].guestname);
                    $("#roomtypehidden").val(response[0].roomtypeid);
                    $("#splitoldratetype").val(response[0].ratetype);
                    $(reservationid).val(response[0].id);
                    myoriginalroomtype = response[0].roomtypeid;
                    splitrmodal.style.display = "block";
                }
            });

            $("#kt_datepicker_81").change(function() {
                var newcheckin = document.getElementById("kt_datepicker_81").value;
                var newsplitcheckin = document.getElementById("newsplitcheckin");
                newsplitcheckin.value = newcheckin;
                var checkout = document.getElementById("kt_datepicker_101").value;
                var currentroomtypeid = document.getElementById("roomtypehidden").value;
                var data = [];
                var values = {
                    "start": newcheckin,
                    "end": checkout
                };
                data = values;
                var json = JSON.stringify(data);
                console.log(json);
                $.ajax({
                    type: "POST",
                    url: "{{ route('checkRoomAvailable') }}",
                    data: json,
                    success: function(response) {

                        var splitnewroom = document.getElementById("splitnewroom");
                        splitnewroom.innerHTML = "";
                        var firstrow = "";
                        var secondrow = "";
                        splitnewroom.innerHTML += "<option selected disabled>Choose...</option>";
                        for (var i = 0; i < response.length; i++) {

                            if (response[i].length > 1) {

                                var responsetypeid = response[i][0].typeid;
                                if (responsetypeid == currentroomtypeid) {
                                    firstrow += "<option disabled class='bg-secondary'>" + response[i][
                                        0].typename + "</option>";
                                    for (var j = 1; j < response[i].length; j++) {

                                        firstrow += "<option value='" + response[i][0].typeid + "-" +
                                            response[i][j].roomid + "'  >" +
                                            response[i][j].roomnumber + "</option>";
                                    }

                                } else {

                                    secondrow += "<option disabled class='bg-secondary'>" + response[i][
                                        0
                                    ].typename + "</option>";
                                    for (var j = 1; j < response[i].length; j++) {

                                        secondrow += "<option value='" + response[i][0].typeid + "-" +
                                            response[i][j].roomid + "'  >" +
                                            response[i][j].roomnumber + "</option>";
                                    }


                                }
                            }


                        }

                        var newrow = firstrow + secondrow;
                        splitnewroom.innerHTML += newrow;
                    }
                });


            });
            $("#splitnewroom").change(function() {

                var splitnewroom = document.getElementById("splitnewroom").value;
                var splitvalue = splitnewroom.split('-');

                var splitnewroomid = splitvalue[1];
                var splitnewroomvalue = splitvalue[0];

                var data = {
                    "id": splitnewroomvalue
                };

                $.ajax({
                    type: "POST",
                    url: "{{ route('getRateTypes') }}",
                    data: data,
                    success: function(result) {
                        showrates(result)
                    },
                })

                function showrates(emp) {
                    $("#splitratetype").html(emp);
                    var currentratetype = document.getElementById("splitoldratetype").value;
                    document.getElementById("splitratetype").value = currentratetype;

                }
            });
            var events = document.getElementsByClassName("event");
            for (var i = 0; i < events.length; i++) {
                events[i].removeAttribute('onclick');
            }
        }

        function splitbtn() {
            var check_empty_dailyrate = false;
            var dailyrate = [];
            for (var i = 0; i < totaldaysofBooking; i++) {
                var label = document.getElementById("label" + i).textContent;
                var ratevalue = document.getElementById("dailyrate" + i).value;
                if (label === "" || ratevalue === "") {
                    check_empty_dailyrate = true;
                    break;
                }
                dailyrate.push({
                    "date": label,
                    "rate": ratevalue
                });
            }
            var splitrmodal = document.getElementById("splitmodal");
            var splitguestname = document.getElementById("splitguestname").value;
            var splitoldroom = document.getElementById("splitoldroom").value;
            var checkin = document.getElementById("kt_datepicker_71").value;
            var newcheckout = document.getElementById("kt_datepicker_81").value;
            var splitnewroom = document.getElementById("splitnewroom").value;
            var splitvalue = splitnewroom.split('-');
            var splitnewroomid = splitvalue[1];
            var splitnewroomvalue = splitvalue[0];
            var newcheckin = document.getElementById("kt_datepicker_81").value;
            var checkout = document.getElementById("kt_datepicker_101").value;
            var reservationid = document.getElementById("splitreservationid").value;
            var roomtypehidden = document.getElementById("roomtypehidden").value;
            var newratetype = document.getElementById("splitratetype").value;
            const oneday = 1000 * 24 * 60 * 60;
            var chin = new Date(newcheckin);
            var chout = new Date(checkout);
            var startday = Date.UTC(chin.getFullYear(), chin.getMonth(), chin.getDate());
            var endday = Date.UTC(chout.getFullYear(), chout.getMonth(), chout.getDate());
            var actualdays = (endday - startday) / oneday;
            if (totaldaysofBooking == 0 || check_empty_dailyrate == true || actualdays > totaldaysofBooking || actualdays <
                totaldaysofBooking) {
                errorSweet("Please add daily rates");
            } else if (splitnewroom === "Choose..." || checkout === "") {
                errorSweet("please fill all fields");
            } else if (newcheckin == checkout || checkin == newcheckout) {
                errorSweet("Checkin and Checkout can't be same");
            } else {
                var data = {
                    "id": reservationid,
                    "start": checkin,
                    "end": newcheckout,
                    "start1": newcheckin,
                    "end1": checkout,
                    "resource": splitoldroom,
                    "resource1": splitnewroomid,
                    "text": splitguestname,
                    "ratetype": newratetype,
                    "drate": dailyrate
                };
                splitrmodal.style.display = "none";
                $.ajax({
                    type: "POST",
                    url: "{{ route('splitReservation') }}",
                    data: data,
                    success: function(response) {
                        successSweet(response.message)
                        $("#splitmodal").find('form').trigger('reset');
                        var date = $("#calendarPicker").datepicker('getDate');
                        $('[data-toggle="tooltip"]').tooltip('hide');
                        $("#calendarPicker").datepicker('setDate', new Date(date));
                    }
                });
            }
        }

        function cancelsplit() {

            var splitrmodal = document.getElementById("splitmodal");
            $("#splitmodal").find('form').trigger('reset');
            splitrmodal.style.display = "none";
        }

        //split function end...........................

        //...............Stop sell functions...............


        function showStopsell(date, roomtypeid, status) {
            var stopsellmodal = document.getElementById("stopSell");
            stopsellmodal.style.display = "block";
            $("#stopSelldiv").hide();
            $("#minStaydiv").hide();
            var roomTypeId = roomtypeid;
            var sdate = date;
            var stopstatus = status;
            var stoproomtype = "";
            var roomtypes = "";
            $("#ssStartdate").val(sdate);
            $("#ssEnddate").val(sdate);
            if (stopstatus == "1") {
                $("#ssrestriction").html("<select><option value='stop_availability' >Stop Availability</option></select>");
                $("#ratetypediv").hide();
                $("#ssroomtype").html(stoproomtype);
                $("#stopSelldiv").show();
            }
            var roomtype = $("#ssroomtype").val();
            var data = {
                "id": roomtype
            };
            $.ajax({
                type: "POST",
                url: "{{ route('getRateTypes') }}",
                data: data,
                success: function(result) {
                    console.log('here');
                    showrates(result)
                },
            })

            function showrates(emp) {
                $("#ssratetype").html(emp);
            }


            $("#ssroomtype").change(function() {
                var roomtype = $("#ssroomtype").val();
                var data = {
                    "id": roomtype
                };

                $.ajax({
                    type: "POST",
                    url: "{{ route('getRateTypes') }}",
                    data: data,
                    success: function(result) {
                        showrates(result)
                    },
                })

                function showrates(emp) {
                    $("#ssratetype").html(emp);
                }

            });

            $("#ssrestriction").change(function() {
                var restrict = $(this).val();
                $("#ssValue").val('');
                if (restrict == "min_stay_arrival" || restrict == "min_stay_through") {
                    $("#ssValue").attr('min', '1');
                } else {
                    $("#ssValue").attr('min', '0');
                }
                if (restrict == "stop_sell" || restrict == "closed_to_arrival" || restrict ==
                    "closed_to_departure" || restrict == "stop_availability") {

                    $("#stopSelldiv").show();
                    $("#minStaydiv").hide();
                } else {

                    $("#stopSelldiv").hide();
                    $("#minStaydiv").show();
                }
            })


        }

        $("#closesrestrictions").click(function() {

            var stopsellmodal = document.getElementById("stopSell");
            stopsellmodal.style.display = "none";

        });

        function closeRestrictions() {
            var stopsellmodal = document.getElementById("stopSell");
            stopsellmodal.style.display = "none";
        }

        function addRestrictions() {
            var stopsellmodal = document.getElementById("stopSell");

            var roomtypeId = document.getElementById("ssroomtype").value;
            var ratetypeId = document.getElementById("ssratetype").value;
            var restriction = document.getElementById("ssrestriction").value;
            var startdate = document.getElementById("ssStartdate").value;
            var enddate = document.getElementById("ssEnddate").value;
            var ssStatus = "";
            if ($("#ssStatus").is(':checked')) {
                ssStatus = "true";
            } else {
                ssStatus = "false";
            }
            var ssValue = document.getElementById("ssValue").value;
            if (roomtypeId === "" || startdate === "" || restriction === "Select restriction") {
                errorSweet("Please fill all fields");
            } else if (startdate > enddate) {
                errorSweet("End date can't be less than start date");
            } else {
                if (restriction === "stop_availability") {
                    var values = {
                        "start": startdate,
                        "end": enddate,
                        "roomtypeid": roomtypeId,
                        "ratetypeid": "",
                        "status": ssStatus,
                        "restriction": restriction
                    };
                } else if (restriction === "stop_sell" || restriction === "closed_to_arrival" || restriction ===
                    "closed_to_departure") {
                    var values = {
                        "start": startdate,
                        "end": enddate,
                        "roomtypeid": roomtypeId,
                        "ratetypeid": ratetypeId,
                        "status": ssStatus,
                        "restriction": restriction
                    };
                } else {
                    var values = {
                        "start": startdate,
                        "end": enddate,
                        "roomtypeid": roomtypeId,
                        "ratetypeid": ratetypeId,
                        "value": ssValue,
                        "restriction": restriction
                    };
                }
                stopsellmodal.style.display = "none";
                $.ajax({
                    type: "POST",
                    url: "{{ 'postStopSellOfRateType' }}",
                    data: values,
                    success: function(response) {
                        successSweet(response.message);
                        location.reload();
                    }
                });
            }
        }

        function showdailyrates(checkin, checkout, resid) {
            totaldaysofBooking = 0;
            var modal = document.getElementById("dailyratemodal");
            modal.style.display = "block";
            var checkin = document.getElementById(checkin).value;
            var checkout = document.getElementById(checkout).value;
            var resid = document.getElementById(resid).value;
            if (checkin == "" || checkout == "" || checkin > checkout) {} else {
                $.ajax({
                    url: "{{ route('getDailyRates') }}",
                    type: "post",
                    data: {
                        checkin: checkin,
                        checkout: checkout,
                        resid: resid
                    },
                    success: function(args) {
                        console.log(args);
                        var ratediv = document.getElementById("ratesdiv");
                        ratediv.innerHTML = args.inputs;
                        totaldaysofBooking = args.count;
                    }
                })
            }
        }

        $("#addratebtn").click(function() {
            var modal = document.getElementById("dailyratemodal");
            modal.style.display = "none";
        });


        function loadEmptyData(month, year) {
            var data = [];
            $.ajax({
                url: "{{ route('getAvailableRooms') }}",
                type: "POST",
                data: {
                    "year": year,
                    "month": month + 1
                },
                success: function(args) {
                    console.log(args);
                    for (var i = 0; i < args.length; i++) {
                        console.log(`loop ${i}`)
                        var cols = $("#" + args[i]["type"]).children();
                        cols.each(function(index, td) {
                            if (index == 0) {} else {
                                console.log(index, args[i]["empty"][index - 1]["day"])
                                if ((index == args[i]["empty"][index - 1]["day"])) {
                                    var availValue = args[i]["empty"][index - 1]['empty'];
                                    var restrictValue = args[i]["empty"][index - 1]['restrict'];
                                    // console.log(availValue);
                                    $(this).find(".typespan").text(availValue);
                                    if (restrictValue == 1) {
                                        $(this).find(".restrictspan").text("!");
                                        $(this).find(".restrictspan").attr('data-original-title', args[
                                            i]["empty"][index - 1]['popupdata']);
                                    }
                                    if (availValue == 0) {
                                        $(this).find(".typespan").css('backgroundColor', 'red');
                                    }
                                }
                            }
                        });
                    }
                    $("#calendar").css('border-collapse', 'collapse');
                }
            });
        }

        //...........show details of events on mouse hover
        $("#tabbody").on('mouseover', 'td', function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
        //...........show reservation status modal change

        $(document).ready(function() {
            var selectdate = $("#calendarPicker").data('date');

            $('[data-toggle="tooltip"]').tooltip();


            //.......change timeline on selecting date from picker
            $("#calendarPicker").datepicker().on('changeDate', function(e) {
                console.log('triggered');
                var cdate = e.date;
                var date = new Date(cdate);
                var currentMonthString = date.toLocaleString('default', {
                    month: 'long'
                });
                var year = date.getFullYear();
                var month = date.getMonth();
                var day = date.getDate();
                var daysinMonth = new Date(year, month + 1, 0).getDate();
                var calendarTitle = document.getElementById("tabtitle");
                calendarTitle.innerHTML = currentMonthString + " " + year;
                var btnTitle = document.getElementById("btntext");
                btnTitle.innerHTML = currentMonthString + " " + year;
                loadTimeline(daysinMonth, year, month);


            });

            //.......add rooms and rate type according to room type selected
            $("#roomtype").change(function() {
                var roomtype = $("#roomtype").val();
                var data = {
                    "id": roomtype
                };
                fetch("get_rooms.php", {
                    method: 'POST',
                    credentials: "same-origin",
                    body: data,
                }).then(result => result.json()).then(json => showrooms(json));

                function showrooms(emp) {
                    $("#rooms").html(emp);
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('getRateTypes') }}",
                    data: data,
                    success: function(result) {
                        showrates(result)
                    },
                })

                function showrates(emp) {
                    $("#ratetypes").html(emp);
                }


            });


        });


        fetch("{{ route('getCountries') }}").then(result => result.json()).then(json => show1(json));
        fetch("{{ route('getAgencies') }}").then(result => result.json()).then(json => show2(json));
        fetch("{{ route('getPaymentModes') }}").then(result => result.json()).then(json => show3(json));


        function show1(emp) {
            for (var i = 0; i < emp.length; i++) {
                var id = emp[i].id;
                var name = emp[i].name;
                $("#country").append('<option value="' + id + '">' + name + '</option>');
            }
        }

        function show2(emp) {
            for (var i = 0; i < emp.length; i++) {
                var id = emp[i].id;
                var name = emp[i].name;
                $("#bookingagency").append("<option value='" + id + "'>" + name + "</option>");
            }
        }

        function show3(emp) {
            for (var i = 0; i < emp.length; i++) {
                var id = emp[i].id;
                var name = emp[i].name;
                $("#paymentmode").append("<option value='" + id + "'>" + name + "</option>");
            }
        }


        $("#calendarPicker").datepicker('setDate', new Date("{{ $date }}"));

        //.......fetch bookings from channex
        setInterval(getBookings, 30000);
        getBookings();

        function getBookings() {
            var date = $("#calendarPicker").datepicker('getDate');
            $('[data-toggle="tooltip"]').tooltip('hide');
            $("#calendarPicker").datepicker('setDate', new Date(date));


        }

        $("#tabbody").on('click', '.roominfo', function() {

            var roomid = $(this).attr("data-value");
            var cdate = $("#calendarPicker").datepicker('getDate');
            cdate = new Date(cdate);
            cdate = cdate.getFullYear() + "-" + ('0' + (cdate.getMonth() + 1)).slice(-2) + "-" + ('0' + cdate
                .getDate()).slice(-2);
            // console.log("id "+roomid+" date "+cdate);

            $.ajax({
                url: "{{ route('getRoomStats') }}",
                type: "POST",
                data: {
                    id: roomid,
                    date: cdate
                },
                success: function(data) {
                    // console.log(data);
                    var formatter = Intl.NumberFormat('el-GR', {
                        style: 'currency',
                        currency: 'Eur',
                        maximumFractionDigits: 2
                    });
                    document.getElementById("riroomtype").innerHTML = "<b>" + data['roomtype'] + "</b>";
                    document.getElementById("rioccrate").innerHTML = "<b>" + data['occupancy'] +
                        " % </b>";
                    document.getElementById("showRoomno").innerHTML = "<b>" + data['roomno'] + "</b>";
                    document.getElementById("riadr").innerHTML = "<b>" + formatter.format(data['adr']) +
                        "</b>";
                    document.getElementById("riooo").innerHTML = "<b>" + data['outoforder'] + "</b>";
                    document.getElementById("riaccomnet").innerHTML = "<b>" + formatter.format(data[
                        'accomodationRevenue']) + "</b>";
                    document.getElementById("riextranet").innerHTML = "<b>" + formatter.format(data[
                        'extraRevenue']) + "</b>";
                    document.getElementById("riovernighttax").innerHTML = "<b>" + formatter.format(data[
                        'overnightTaxRevenue']) + "</b>";
                    document.getElementById("ricommission").innerHTML = "<b>" + formatter.format(data[
                        'commission']) + "</b>";
                    document.getElementById("riadults").innerHTML = "<b>" + data['adults'] + "</b>";
                    document.getElementById("rikids").innerHTML = "<b>" + data['kids'] + "</b>";
                    document.getElementById("riinfants").innerHTML = "<b>" + data['infants'] + "</b>";
                    document.getElementById("riaaccvat").innerHTML = "<b>" + formatter.format(data[
                        'accommodationVat']) + "</b>";
                    document.getElementById("riextravat").innerHTML = "<b>" + formatter.format(data[
                        'extraVat']) + "</b>";
                    document.getElementById("richannel").innerHTML = "<b>" + data['channels'] + "</b>";


                    $("#roominfoModal").modal('show');
                }
            })

        })

        function errorSweet(content) {
            Swal.fire("Error!", content, "warning");
        }

        function successSweet(content) {
            Swal.fire("Success!", content, "success");
        }
    </script>
@endpush

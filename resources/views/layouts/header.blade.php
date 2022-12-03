<div class="navigation-wrap bg-white">
    <div class="container-fluid">
        <div class="row">
            <nav class="navbar navbar-expand-lg navbar-light w-100" id="navBar">
                <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('images/logo/logo.png') }}" alt="" height="38px"></a>
                <button class="btn toggleMenu ml-auto mr-2" type="button" data-toggle="collapse" data-target="#main_nav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="dropdowns collapse navbar-collapse" id="main_nav">
                    <ul id="topmainMenu" class="nav">
                        @canany(['Reservations', 'Reservation List', 'Modified Reservation', 'Cancel Reservation', 'Ex Reservation', 'No Show List', 'Calendar', 'Booking Channels', 'Companies', 'Guest Profile'])
                            <li class="topmenu">
                                <a>Reservations</a>
                                <ul class="submenu">
                                    @canany(['Reservation List', 'Modified Reservation', 'Cancel Reservation', 'Ex Reservation', 'No Show List'])
                                        <li>
                                            <a>Reservations </a>
                                            <ul class="submenu">
                                                @can('Reservation List')
                                                    <li><a href="{{ route('reservations-list') }}">Reservations List</a></li>
                                                @endcan
                                                {{-- @can('Modified Reservation')
                                        <li><a href="{{route('reservations-list',['type'=>'modified'])}}">Modified Reservations</a></li>
                                        @endcan
                                        @can('Cancel Reservation')
                                        <li><a href="{{route('reservations-list',['type'=>'cancelled'])}}">Cancelled Reservations</a></li>
                                        @endcan --}}
                                                @can('Ex Reservation')
                                                    <li><a href="{{ route('ex-reservations-list') }}">Ex-Reservations</a></li>
                                                @endcan
                                                @can('No Show List')
                                                    <li><a href="{{ route('no-show-list') }}">No Show list</a></li>
                                                @endcan
                                            </ul>
                                        </li>
                                    @endcanany
                                    @can('Calendar')
                                        <li><a href="{{ route('calendar') }}">Calendar</a></li>
                                    @endcan
                                    @can('Booking Channels')
                                        <li><a href="{{ route('channel-list') }}">Channels</a></li>
                                    @endcan
                                    @can('Companies')
                                        <li><a href="{{ route('companies-list') }}">Companies</a></li>
                                    @endcan
                                    @can('Guest Profile')
                                        <li><a href="{{ route('guest-profiles') }}">Guest Profile</a></li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany
                        @canany(['Finance', 'Receipt List', 'Invoice List', 'Cancellation Fee', 'Credit Note', 'Special Annual Doc', 'Overnight Tax', 'Daily Cashier', 'Payment Tracker', 'Opex', 'Opex Form', 'Opex List', 'Add Supplier',
                            'Commission', 'Commission List', 'Credit Card List', 'Debtor Ledger', 'Hotel Budget', 'Actual Budget'])
                            <li class="topmenu">
                                <a>Finance</a>
                                <ul class="submenu">
                                    @canany(['Tax Document', 'Receipt List', 'Invoice List', 'Credit Note', 'Special Annual Doc', 'Overnight Tax'])
                                        <li>
                                            <a>Tax Documents </a>
                                            <ul class="submenu">
                                                @can('Receipt List')
                                                    <li><a href="{{ route('receipt-list') }}">Receipts</a></li>
                                                @endcan
                                                @can('Invoice List')
                                                    <li><a href="{{ route('invoice-list') }}">Invoice</a></li>
                                                @endcan
                                                @can('Cancellation Fee')
                                                    <li><a href="{{ route('cancellation-fee-list') }}">Cancellation Fee</a></li>
                                                @endcan
                                                @can('Credit Note')
                                                    <li><a href="{{ route('credit-note-list') }}">Credit Note</a></li>
                                                @endcan
                                                @can('Special Annual Doc')
                                                    <li><a href="{{ route('special-annulling-documents') }}">Special Annuling Document</a></li>
                                                @endcan
                                                @can('Overnight Tax')
                                                    <li><a href="{{ route('overnight-tax-list') }}">Overnight Tax</a></li>
                                                @endcan
                                            </ul>
                                        </li>
                                    @endcanany
                                    @can('Daily Cashier')
                                        <li><a href="{{ route('daily-cashier') }}">Daily Cashier Report</a></li>
                                    @endcan
                                    @can('Payment Tracker')
                                        <li><a href="{{ route('payment-tracker') }}">Payment Tracker</a></li>
                                    @endcan
                                    @canany(['Opex', 'Opex Form', 'Opex List', 'Add Supplier'])
                                        <li><a> Opex </a>
                                            <ul class="submenu">
                                                @can('Opex Form')
                                                    <li><a href="{{ route('opex-form') }}">Opex Form</a></li>
                                                @endcan
                                                @can('Opex List')
                                                    <li><a href="{{ route('opex-list') }}">Opex List</a></li>
                                                @endcan
                                                @can('Add Supplier')
                                                    <li><a href="{{ route('create-supplier') }}">Supplier</a></li>
                                                @endcan
                                            </ul>
                                        </li>
                                    @endcanany
                                    @canany(['Commission', 'Commission List', 'Credit Card List'])
                                        <li><a> Commission </a>
                                            <ul class="submenu">
                                                @can('Commission List')
                                                    <li><a href="/commision-list">Commission B2B</a></li>
                                                @endcan
                                                @can('Credit Card List')
                                                    <li><a href="/credit-card-list">Credit Card List</a></li>
                                                @endcan
                                            </ul>
                                        </li>
                                    @endcanany
                                    @can('Debtor Ledger')
                                        <li><a href="/sales-ledger">Debtor Ledger</a></li>
                                    @endcan
                                    @canany(['Hotel Budget', 'Actual Budget'])
                                        <li><a> Hotel Budget </a>
                                            <ul class="submenu">
                                                @can('Hotel Budget')
                                                    <li><a href="{{ route('hotel-budget') }}">Hotel Budget</a></li>
                                                @endcan
                                                @can('Actual Budget')
                                                    <li><a href="{{ route('hotel-actual') }}">Actual Budget</a></li>
                                                @endcan
                                            </ul>
                                        </li>
                                    @endcanany
                                </ul>
                            </li>
                        @endcanany
                        @canany(['Reporting', 'Revenue Report', 'KPI Report', 'Room Division Report', 'B2B Report', 'Housekeeping', 'Opex Report', 'Account Report'])

                            <li class="topmenu">
                                <a> Reporting </a>
                                <ul class="submenu">
                                    @can('Revenue Report')
                                        <li><a href="{{ route('revenue-reports') }}"> Revenue Reporting </a></li>
                                    @endcan
                                    @can('KPI Report')
                                        <li><a href="{{ route('kpi-reports') }}"> KPI Reporting </a></li>
                                    @endcan
                                    @can('Room Division Report')
                                        <li><a href="{{ route('roomdivision-reports') }}"> Room Division Reporting </a></li>
                                    @endcan
                                    @can('B2B Report')
                                        <li><a href="{{ route('b2b-reports') }}"> B2B Reporting </a></li>
                                    @endcan
                                    @can('Housekeeping')
                                        <li><a href="{{ route('housekeeping-reports') }}"> Housekeeping Reporting </a></li>
                                    @endcan
                                    @can('Opex Report')
                                        <li><a href="{{ route('opex-reports') }}"> OPEX Reporting </a></li>
                                    @endcan
                                    @can('Account Report')
                                        <li><a href="{{ route('accounting-reports') }}"> Accounting Reporting </a></li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany
                        @canany(['Channel Manager', 'Inventory', 'Channel', 'Room and Rates'])
                            <li class="topmenu">
                                <a> Channel Manager </a>
                                <ul class="submenu">
                                    @can('Inventory')
                                        <li><a href="{{ route('channex-inventory.index') }}"> Inventory </a></li>
                                    @endcan
                                    @can('Channel')
                                        <li><a href="{{ route('channex-channel.index') }}"> Channels </a></li>
                                    @endcan
                                    @can('Room and Rates')
                                        <li><a href="{{ route('channex-room_rate.index') }}"> Rooms & Rates </a></li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany
                        @can('Booking Engine')
                            <li class="topmenu">
                                <a href="{{ route('booking-engine.index') }}">Booking Engine</a>
                            </li>
                        @endcan
                        @canany(['Settings', 'Hotel Setting', 'User Setting'])
                            <li class="topmenu">
                                <a> Settings </a>
                                <ul class="submenu">
                                    @can('Hotel Setting')
                                        <li><a href="{{ route('hotels.index') }}">Hotel List</a></li>
                                        <li><a href="{{ route('hotel-settings', getHotelSettings()) }}"> Hotel Settings </a></li>
                                    @endcan
                                    @can('User Setting')
                                        <li><a href="{{ route('users-list') }}"> Users Settings </a></li>
                                    @endcan
                                    @can('Extra Charge')
                                        <li><a href="{{ route('services-settings') }}"> Services </a></li>
                                    @endcan
                                    @canany(['Room Type and Rooms', 'Rate Plan', 'Meal Categories'])
                                        <li><a>Rooms & Rates </a>
                                            <ul class="submenu">
                                                @can('Room Type and Rooms')
                                                    <li><a href="{{ route('room-type-and-room.show') }}">Room Types & Rooms</a></li>
                                                @endcan
                                                @can('Rate Plan')
                                                    <li><a href="{{ route('rate-plans.index') }}">Rate Plans</a></li>
                                                @endcan
                                                @can('Meal Categories')
                                                    <li><a href="{{ route('meal-category.index') }}">Meal Categories</a></li>
                                                @endcan
                                            </ul>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany
                        @can('Calendar')
                            <li class="topmenu">
                                <a href="{{ route('super-calendar') }}">Multi Calendar</a>
                            </li>
                        @endcan
                    </ul>
                </div>
                <div class="collapse navbar-collapse" id="right_nav">
                    <div class="ml-auto">
                        @livewire('hotel-switcher')
                    </div>
                    <div class="dropdown ml-auto">
                        <div class="topbar-item float-right" data-toggle="dropdown" data-offset="10px,0px">
                            <div class="btn btn-icon btn-clean pulse pulse-primary" data-toggle="modal" data-target="#msgsmodal">
                                <i id="messagetab" class="fa fa-envelope mr-2" aria-hidden="true" style="font-size: 26px; color: #1BC5BD;"></i>
                            </div>

                            <div class="btn btn-icon btn-icon-mobile btn-clean btn-lg w-auto px-2" id="kt_quick_user_toggle">
                                <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi {{ auth()->user()->first_name }}</span>
                                <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"></span>
                                <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                                    <span class="symbol-label font-size-h5 font-weight-bold">{{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div class="modal fade w-100" id="msgsmodal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true" style="z-index: 9999;">
            <div class="modal-dialog modal-xl modal-dialog-centered modal modal-dialog-scrollable" role="document">
                <div class="modal-content" style="min-height: 550px !important;">
                    <div class="modal-header btn btn-info" style="background-color:#1BC5BD !important;border-color:#1BC5BD !important;">
                        <h5 class="modal-title text-white" id="modalhead">Messages</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <button type="button" class="" onClick="" data-dismiss="modal" style='background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'>
                                Close
                            </button>
                        </button>
                    </div>

                    <div class="modal-body">

                           <iframe id="msgframe" frameBorder="0" hspace="0" vspace="0" style="min-width: 100% !important; height: auto !important; min-height: 100%;  border: none; margin-right: -20px; margin-left: -20px; padding: 0px !important;margin-top:-10px !important;" src="">
                           </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script type="text/javascript">
        (function($) {
            $.fn.dropdowns = function(options) {

                var defaults = {
                    toggleWidth: 992
                }

                var options = $.extend(defaults, options);

                var ww = document.body.clientWidth;

                var addParents = function() {
                    $(".nav li a").each(function() {
                        if ($(this).next().length > 0) {
                            $(this).addClass("parent");
                        }
                    });
                }

                var adjustMenu = function() {
                    if (ww < options.toggleWidth) {
                        $(".toggleMenu").css("display", "inline-block");
                        if (!$(".toggleMenu").hasClass("active")) {
                            $(".nav").hide();
                        } else {
                            $(".nav").show();
                        }
                        $(".nav li").unbind('mouseenter mouseleave');
                        $(".nav li a.parent").unbind('click').bind('click', function(e) {
                            // must be attached to anchor element to prevent bubbling
                            e.preventDefault();
                            $(this).parent("li").toggleClass("hover");
                        });
                    } else if (ww >= options.toggleWidth) {
                        $(".toggleMenu").css("display", "none");
                        $(".nav").show();
                        $(".nav li").removeClass("hover");
                        $(".nav li a").unbind('click');
                        $(".nav li").unbind('mouseenter mouseleave').bind('mouseenter mouseleave', function() {
                            // must be attached to li so that mouseleave is not triggered when hover over submenu
                            $(this).toggleClass('hover');
                        });
                    }
                }

                return this.each(function() {
                    $(".toggleMenu").click(function(e) {
                        e.preventDefault();
                        $(this).toggleClass("active");
                        $(this).next(".nav").toggle();
                        adjustMenu();
                    });
                    adjustMenu();
                    addParents();
                    $(window).bind('resize orientationchange', function() {
                        ww = document.body.clientWidth;
                        adjustMenu();
                    });
                });

            }
        })(jQuery)

        $(".dropdowns").dropdowns();

        $.ajax({
                url: "{{ route('channex-otp.get') }}",
                type: "get",
                success: function(args) {
                    if (args == 'reload')
                        window.location.reload();
                    var propertyid = args.propertyid;
                    var accesstoken = args.onetimeToken;
                    var iframeRef = "https://staging.channex.io/auth/exchange?oauth_session_key=" +
                        accesstoken +
                        " &app_mode=headless&redirect_to=/messages&property_id=" + propertyid;

                    $("#msgframe").attr("src", iframeRef);



                }
            })
    </script>
@endpush

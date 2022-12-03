@extends('layouts.master')
@section('content')
    <div>
        <x-table title='Reservation No Show List' hideBody="yes">
            <x-slot name="header">
                <div class="row">
                    <div class="col-md-10 form-group d-inline-block">
                        <form action="{{route('no-show-list')}}" method="get">
                            <table>
                                <tbody>
                                <tr>
                                    <input type="hidden" name="status" value="{{ request()->query('status', null) }}">
                                    <td class="align-middle">
                                        <div class="form-style-6 reservation-input my-0 p-0">
                                            <input class="m-0" name="from_date" type="date" style="min-width: 270px;"
                                                   value="{{old('from_date', request()->query('from_date', null))}}" id="from-date">
                                        </div>
                                    </td>
                                    <td class="align-middle"><span class="text-center px-2">-To-</span></td>
                                    <td class="align-middle">
                                        <div class="form-style-6 reservation-input my-0 p-0">
                                            <input class="m-0" name="to_date" type="date" style="min-width: 270px;"
                                                   value="{{old('to_date', request()->query('to_date', null))}}" id="to-date">
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-print-none pl-2">
                                            <button type="submit" class="btn btn-success rounded-0">
                                                Run
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                @error('from_date')
                                <tr>
                                    <td colspan="4" class="text-danger">{{ $message }}</td>
                                </tr>
                                @enderror

                                @error('to_date')
                                <tr>
                                    <td colspan="4" class="text-danger">{{ $message }}</td>
                                </tr>
                                @enderror
                            </table>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <a href="javascript:if(window.print)window.print()" type="button"
                           class="float-right btn btn-primary m-3">
                            <i class="fa fa-print"></i>Print
                        </a>
                    </div>
                </div>
            </x-slot>
            <x-slot name="heading">&nbsp;</x-slot>
        </x-table>
        <x-table id="chart">
            <x-slot name="heading">&nbsp;</x-slot>
                <div class="listcard listcard-custom" style="min-height:350px;">
                    <h3></h3>
                    <div id="chart"></div>
                </div>
        </x-table>
        <x-table tableClasses="table reservation-table table-striped table-bordered">
            <x-slot name="heading">
                <td>Reservation Status</td>
                <td>Booking Code</td>
                <td>Booking Source</td>
                <td>No Show Date</td>
                <td>Guest Name</td>
                <td>Room Type</td>
                <td>Daily Rate</td>
            </x-slot>
            @foreach($reservations as $item)
                <tr id="tr_{{$item->id}}">
                    <td>
                        <span class="badge badge-reservation badge-no-show rounded-0">
                            No Show
                        </span>
                    </td>
                    <td>{{$item->booking_code}}</td>
                    <td>{{$item->booking_agency->name}}</td>
                    <td>{{$item->daily_rates->first()->date ?? ''}}</td>
                    <td>{{$item->guest->full_name}}</td>
                    <td>{{$item->room->room_type->name}}</td>
                    <td>{{showPriceWithCurrency($item->daily_rates->first()->price ?? 0)}}</td>
                </tr>
            @endforeach
        </x-table>
    </div>
@endsection

@push('scripts')
    <script>
        let options = {
            chart: {
                type: 'line',
                height: "100%",
                toolbar: {
                    show: false,
                }
            },
            series: [{
                name: 'Total No Show',
                data: @json(array_values($chart_data))
            }],
            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
            },
            yaxis: [
                {
                    labels: {
                    formatter: function(val) {
                        return val.toFixed(0);
                    }
                    }
                }
            ]
        }

        let chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();
    </script>
@endpush

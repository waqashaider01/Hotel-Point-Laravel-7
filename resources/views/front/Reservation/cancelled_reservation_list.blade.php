@extends('layouts.master')
@section('content')
    <div>
        <x-table title='Cancelled Reservation List'>
            <x-slot name="header">
                <div class="row">
                    <div class="col-md-10 form-group d-inline-block">
                        <form action="{{route('reservations-list',['type'=>'cancelled'])}}" method="get">
                            <table>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="form-style-6" style="">
                                            <input class="form-control1" name="from_date" type="date"
                                                   value="{{old('from_date')}}" id="example-date-input">
                                        </div>
                                    </td>
                                    <td><span class="text-center mt-5">-To-</span></td>
                                    <td>
                                        <div class="form-style-6" style="">
                                            <input class="form-control1" name="to_date" type="date"
                                                   value="{{old('to_date')}}" id="example-date-input">
                                        </div>
                                    </td>
                                    <td>
                                        <div class=" d-print-none ml-2  form-group" style="">
                                            <button type="submit"
                                                    style="margin-top:60%;background-color:#48BD91;border:none !important;padding:2px 12px;color:white;border-radius:2px;">
                                                Run
                                            </button>
                                        </div>
                                    </td>
                                </tr>
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
            <x-slot name="heading">
                <td>Booking ID</td>
                <td>Channel</td>
                <td>Check In</td>
                <td>Check Out</td>
                <td>Guest Name</td>
                <td>Reservation Status</td>
            </x-slot>
            @foreach($reservations as $item)
                <tr id="tr_{{$item->id}}">
                    <td><a href="{{route('edit-reservation',['id'=>$item->id])}}">#{{$item->booking_code}}</a></td>
                    <td>{{$item->booking_agency->name}}</td>
                    <td>{{$item->check_in}}</td>
                    <td>{{$item->check_out}}</td>
                    <td>{{$item->guest->full_name}}</td>
                    <td>

                        @switch($item->status)
                            @case("New")
                                <span class="badge badge-reservation badge-new rounded-0">
                                    {{$item->status}}
                                </span>
                                @break
                            @case("Confirm")
                                <span class="badge badge-reservation badge-confirmed rounded-0">
                                    {{$item->status}}
                                </span>
                                @break
                            @case("Cancelled")
                                <span class="badge badge-reservation badge-cancelled rounded-0">
                                    {{$item->status}}
                                </span>

                                @break
                            @case("CheckedOut")
                            @case("Checked Out")
                                <span class="badge badge-reservation badge-checked-out rounded-0">
                                    Checked Out
                                </span>
                                @break
                            @case("No Show")
                                <span class="badge badge-reservation badge-no-show rounded-0">
                                    {{$item->status}}
                                </span>
                                @break
                            @case("Arrived")
                                <span class="badge badge-reservation badge-arrived rounded-0">
                                    {{$item->status}}
                                </span>
                                @break
                            @case("Offer")
                                <span class="badge badge-reservation badge-offer rounded-0">
                                    {{$item->status}}
                                </span>
                                @break
                            @default
                                <span class="badge badge-reservation badge-info rounded-0">
                                    {{$item->status}}
                                </span>
                        @endswitch
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>
@endsection

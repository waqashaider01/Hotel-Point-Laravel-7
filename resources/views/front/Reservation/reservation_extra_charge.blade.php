@extends('layouts.master')
@section('content')
    <div class="d-flex flex-column-fluid mt-5">
        <div class="container-fluid">
            <div class="row ">
                <div class="col">
                    <div class="extrachargecard">
                        <div class="choosedservices">
                            <div class="row">
                                <div class="col">
                                    <a class="servicebuttons" href="{{route('home')}}" type="button" id="bak"
                                       style="background-color:#757575;">Back</a>
                                </div>
                                <div class="col text-center">
                                    <h5>Services</h5>
                                </div>
                                <div class="col text-right">
                                    <a class="servicebuttons" type="button"
                                       href="{{route('create-reservation-extra-charges',$reservation_id)}}"
                                       style="background-color:#1BC5BD;">New Record</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-8 mb-10">
                <div class="col">
                    <div class="extrachargecard">
                        <div class="headerstyle">
                            <div class="row">
                                <div class="col">
                                    Receipt No
                                </div>
                                <div class="col">
                                    Amount
                                </div>
                                <div class="col">
                                    Discount
                                </div>
                                <div class="col">
                                    Date
                                </div>
                                <div class="col">
                                    Payment Method
                                </div>
                                <div class="col">
                                    Actions
                                </div>
                            </div>
                        </div>
                        <div class="choosedservicesnew">
                            @foreach($extras as $key=>$extra)
                                <div class="servicechoosed" id="showserviceselected">
                                    <div class="row text-center">
                                        <div class="col">{{$key}}</div>
                                        <div class="col">{{$extra->sum('extra_charge_total')}}</div>
                                        <div class="col">{{$extra->sum('extra_charge_discount')}}</div>
                                        <div class="col">{{$extra->first()->date}}</div>
                                        @if($extra->first()->is_paid == 0)
                                            <div class="col" style="color:red;">
                                                Room Charge
                                            </div>
                                        @else
                                            <div class="col">
                                                {{$extra->first()->payment_method->name}}
                                            </div>
                                        @endif
                                        <div class="col">
                                            <i data-toggle="modal" data-target="#infoModal"
                                               data-receipt="{{$extra->first()->receipt_number}}"
                                               data-services="{{json_encode($extra)}}"
                                               class="fa fa-2x fa-info-circle info" type="button" id="infoBtn"></i>
                                            @if($extra->first()->is_paid == 0)
                                                <a href="{{route('create-reservation-extra-charges',[$reservation_id,$extra->first()->receipt_number])}}">
                                                    <i type="button" class="fa fa-2x fa-pencil-alt"></i>
                                                </a>
                                                <a href="{{route('delete-reservation-extra-charge',$extra->first()->receipt_number)}}">
                                                    <i class="fa fa-2x fa-times-circle cross" type="button"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="infoModal" style="border-radius:0px !important;" tabindex="-1"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" style="">
            <div class="modal-content rounded-7">
                <div class="modal-header shadow-sm "
                     style="border-radius:0px !important;z-index:10;background-color:#D5D8DC;">
                    <h5 style="text-align:center;margin-left:40%;" class="modal-title text-dark text-center">
                        Receipt No: <span id="receipt_number"></span>
                    </h5>
                </div>
                <div class="modal-body" style="position:relative;background-color:#F5F4F4;">
                    <div class="servicechoosed1" id="showserviceselected">
                        <div class="row font-weight-bolder mb-1 text-center">
                            <div class="col">
                                Service
                            </div>
                            <div class="col">
                                Unit Price
                            </div>
                            <div class="col">
                                Units
                            </div>
                        </div>
                    </div>
                    <div class="form-style-61" id="info_body">
                    </div>
                </div>
                <div class="modal-footer" style="background-color:#EFF5F5;">
                    <div class="" style="background-color:#EFF5F5;float:right;">
                        <span class="servicebuttons" type="button" id="" data-dismiss="modal"
                              style="background-color:#757575;">Close</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#infoBtn').click(function () {
            let receipt = $(this).attr('data-receipt')
            let services = JSON.parse($(this).attr('data-services'))
            $('#receipt_number').html(receipt)
            let html_body = '';
            for (let i in services) {
                html_body += '<div class="servicechoosed"><div class="row text-center"><div class="col">' +
                    services[i]['extra_charge']['product'] + '</div>' +
                    '<div class="col">' + services[i]['extra_charge']['unit_price'] + '</div>' +
                    '<div class="col">' + services[i]['units'] + '</div></div></div>';
            }
            $('#info_body').html(html_body)
        })
    </script>
@endsection


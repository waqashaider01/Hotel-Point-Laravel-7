@extends('layouts.master')
@section('content')
    <div>
        <x-table title='Opex List'>
            <x-slot name="header">
                <div class="row">
                    <div class="col-md-10 form-group d-inline-block">
                        <form action="{{route('opex-list')}}" method="get">
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
                                                    style="margin-top:30%;background-color:#48BD91;border:none !important;padding:6px 12px;color:white;border-radius:2px;">
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
                           class="float-right btn btn-primary m-3 d-print-none">
                            <i class="fa fa-print"></i> Print
                        </a>
                        <a href="{{asset('storage/public/'.$file)}}" type="button"
                           class="float-right btn btn-secondary m-3 d-print-none" download>
                            <i class="fa fa-download"></i> Download
                        </a>
                    </div>
                </div>
            </x-slot>
            <x-slot name="heading">
                <td>Invoice Number</td>
                <td>Supplier</td>
                <td>Date</td>
                <td>Amount</td>
                <td>Payment</td>
                <td>Payment Bill</td>
                <td>Action</td>
            </x-slot>
            @foreach($opexes as $opex)
                <tr>
                    <td><a href="{{asset('storage/uploads/'.$opex->file)}}" style="color: #1BC5BD" download>{{$opex->invoice_number}}</a></td>
                    <td>{{$opex->supplier->name}}</td>
                    <td>{{$opex->date}}</td>
                    <td>{{$opex->amount}}</td>
                    @if($opex->payment == 'Debtor')
                        <td><span
                                style='background-color:red;padding:2px 8px;color:white;border-radius:2px;'>{{$opex->payment}}</span>
                        </td>
                        <td></td>
                        <td>
                            <button type='button'
                                    style='background-color:#48BBBE;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'
                                    onclick='setId({{$opex->id}})' data-toggle='modal' data-target='#updateOpexModal'>
                                Update
                            </button>
                        </td>
                    @elseif(!empty($opex->bill_no))
                        <td><span
                                style='background-color:#48BD91;padding:2px 8px;color:white;border-radius:2px;'>{{$opex->payment}}</span>
                        </td>
                        <td>
                            <a style='background-color:#48BBBE;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;' href="{{asset('storage/uploads/'.$opex->bill_no)}}"
                               download>Download</a>
                        </td>
                        <td></td>
                    @else
                        <td><span
                                style='background-color:#48BD91;padding:2px 8px;color:white;border-radius:2px;'>{{$opex->payment}}</span>
                        </td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
            @endforeach
        </x-table>
        <div class="listcard listcard-custom mt-10 mb-30 ml-8 mr-8" style="width: auto !important">
            <div class="ml-5 mr-4">
                <h4 class="text-center">Total</h4>
                <div class="table mt-10 text-center ">
                    <div>
                        <div class="row th text-center">
                            <div class="col">Amount</div>
                            <div class="col">VAT</div>
                        </div>
                    </div>
                    <div class="row mytr text-center">
                        <div class="col">{{showPriceWithCurrency($opexes->sum('amount'))}}</div>
                        <div class="col">{{showPriceWithCurrency($opexes->sum('vat'))}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateOpexModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Update Opex</h5>
                </div>
                <div class="modal-body" style="z-index:1004;position:relative;background-color:#F5F7F9;margin-top:-3%;">
                    <div class="">
                        <form action="{{route('post-opex')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mt-0">
                                <div class="form-style-6">
                                    <div class="row">
                                        <div class="col">
                                            <label class="">Amount</label>
                                            <input type="number" min='0' class="form-control1" name="amount">
                                            <x-error field="amount"></x-error>
                                        </div>
                                        <div class="col ">
                                            <label class="">Payment</label>
                                            <select class="form-control1" id="payment" name="payment" style="">
                                                <option disabled>Choose...</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Credit Card">Credit Card</option>
                                                <option value="Bank Transfer">Bank Transfer</option>
                                                <option value="Debtor">Debtor</option>
                                            </select>
                                            <x-error field="payment"></x-error>
                                        </div>
                                        <div class="col" id="bill_file">
                                            <label class="">Bill File</label>
                                            <input type="file" name="bill_file"
                                                   accept=".pdf, .png, .jpg, .jpeg" class="form-control1"
                                                   aria-label="Sizing example input"
                                                   aria-describedby="inputGroup-sizing-default">
                                            <x-error field="bill_file"></x-error>
                                        </div>
                                        <input type="hidden" id="opex_id" name="opex_id">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="background-color:#F5F7F9;">
                                <button type="submit" class="float-right"
                                        style='background-color:#48BBBE;padding:2px 12px;color:white;border-radius:2px;
	  border:none;'>Update
                                </button>
                                <button type="button" data-dismiss="modal"
                                        style='background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'>
                                    Close
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        let active_modal = $('#updateOpexModal');
        @if (count($errors) > 0)
        active_modal.modal('show');
        @endif
        function setId(id){
            console.log(id)
            $("#opex_id").val(id)
        }
        $("#payment").change(function () {
            if ($("#payment").val() === "Debtor") {
                $("#bill_file").hide();
            } else {
                $("#bill_file").show();
            }
        });
    </script>
@endpush


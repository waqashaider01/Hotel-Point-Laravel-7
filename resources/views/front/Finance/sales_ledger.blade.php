@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="listcard">
            <div class='d-flex align-items-center gap-4'>

                <h2 class="m-0" style="margin-right: 70px !important;">Debtor Ledger</h2>

            </div>
        </div>

        <div class="row mt-10 mb-10" style="">
            <div class="col" style="">
                <div class="listcard" style="height:150px;">
                    <h3>Total Debtors</h3>
                    <div class="font-weight-bold mt-8 text-center">
                        <h1 style="font-size:45px;"> {{ $totalDebtors }} </h1>
                    </div>
                </div>
            </div>

            <div class="col" style="">
                <div class="listcard" style="height:150px;">
                    <h3>Invoices/Receipts</h3>
                    <div class="font-weight-bold mt-8 text-center">
                        <h1 style="font-size:45px;"> {{ $totalInvoices }} </h1>
                    </div>
                </div>
            </div>
            <div class="col" style="">
                <div class="listcard" style="height:150px;">
                    <h3>Balance From Debtors</h3>
                    <div class="font-weight-bold mt-8 text-center">
                        <h1 style="font-size:45px;"> {{ showPriceWithCurrency($totalBalance) }} </h1>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <x-table containerClasses="w-100">
                <x-slot name="heading">
                    <td>Company</td>
                    <td>Total Invoice</td>
                    <td>Balance</td>
                    <td></td>
                </x-slot>
                @foreach ($agencies as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>
                            {{ $item->count }}
                        </td>
                        <td>{{ showPriceWithCurrency($item->total) }}</td>
                        <td>
                            <div class="d-flex justify-content-end">
                                <button id="{{ $item->id }}" onclick='agencypopup(this.id)' class="btn btn-primary">
                                    <i class="fa fa-eye mr-3"></i>
                                    View List</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade" id="agencylistModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Invoice List</h5>

                </div>
                <div class="modal-header" style="z-index:1;border:none;background-color:#F5F7F9;">
                    <canvas id="myCanvas1" style="margin-left:45%;margin-top:-8%;z-index:990 !important;position:relative;" width="80" height="80"></canvas>


                </div>

                <div class="modal-body" style="z-index:1004;position:relative;background-color:#F5F7F9;margin-top:-3%;">


                    <div class="table" id='reservations-table'>
                        <div>
                            <div class="row th text-center">
                                <div class="col">Invoice No</div>
                                <div class="col">Booking ID</div>
                                <div class="col">Date</div>
                                <div class="col">Amount</div>
                                <div class="col"></div>
                            </div>
                        </div>

                        <div class='' id="agencylist_detail">

                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color:#F5F7F9;">
                    <button type="button" class="" data-dismiss="modal" style='background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'>Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="invoiceupdateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Update Invoice</h5>
                </div>
                <form action="/sales-ledger-update" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body" style="z-index:1004;position:relative;background-color:#F5F7F9;">


                        <div class=" form-style-6">
                            <div class="form-row row" id='invoiceupdatelist'>


                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color:#F5F7F9;">
                        <button type='submit' name="sales_ledger_doc_button" class="float-right" style='background-color:#48BBBE;padding:2px 12px;color:white;border-radius:2px;border:none;' id="addreserv">Update</button>
                        <button type="button" class="" data-dismiss="modal" style='background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'>Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function agencypopup(aid) {
            $.ajax({
                url: "/sales-ledger-modal-show",
                method: "get",
                data: {
                    agency_id: aid
                },
                success: function(data) {
                    $('#agencylist_detail').html(data.html);
                    $('#agencylistModal').modal('show');
                }
            });
        }

        function invoiceupdate(did, paymentMethodId, paid) {
            $.ajax({
                url: "/sales-ledger-update-modal",
                method: "get",
                data: {
                    invoice_id: did,
                    paymentMethodId: paymentMethodId,
                    paid: paid
                },
                success: function(data) {
                    $('#invoiceupdatelist').html(data.html);
                    $('#invoiceupdateModal').modal('show');
                }
            });
        }
    </script>
@endpush

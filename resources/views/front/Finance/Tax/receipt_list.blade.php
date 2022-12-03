@extends('layouts.master')
@section('content')
    <div>
        <x-table title='Receipt List'>
            <x-slot name="header">
                <div class="row">
                    <div class="col-md-10">
                        <form action="{{route('receipt-list')}}" method="get">
                            <!-- <table> -->
                            <div class="row">
                                <div class="col-md-3">
                                       <div class="form-style-6" style="">
                                            <input class="form-control1" name="from_date" type="date"
                                                   value="{{old('from_date')}}" >
                                        </div>
                                </div>
                                <div class="col-md-3">
                                       <div class="form-style-6" style="">
                                            <input class="form-control1" name="to_date" type="date"
                                                   value="{{old('to_date')}}" >
                                        </div>
                                </div>
                                <div class="col-md-3">
                                      <div class=" d-print-none form-style-6" style="">
                                            <button type="submit" class="btn"
                                                    style="background-color:#48BD91;border:none !important;padding:4px 12px;color:white; margin-top:10px; border-radius:2px;">
                                                Run
                                            </button>
                                        </div>
                                </div>
                            </div>
                             
                        </form>
                    </div>
                    <div class="col-md-2 mt-10 d-print-none">
                            <div style="float:right;" >			
						       
								<a href="javascript:if(window.print)window.print()" class="  " style='background-color:black;padding:2px 12px;color:white;border-radius:2px;'>
                                    <span class="navi-icon">
                                        <i class="fa fa-print" style="color:white !important;"></i>
                                    </span>
                                    <span class="" >Print</span>
                                </a>
						       
							
				
					        </div>
			          </div>
                </div>
            </x-slot>
            <x-slot name="heading">
                <td>Receipt No.</td>
                <td>Mark ID</td>
                <td>Receipt Date</td>
                <td>Booking ID</td>
                <td>Guest Name</td>
                <td>Receipt Amount</td>
                <td>Payment Condition</td>
                <td>Special Annulling Doc</td>
                <td> Re-create (Doc)</td>
            </x-slot>
            @foreach($documents as $item)
                <tr>
                    <td><a href="{{asset('storage/invoices/'.$item->print_path)}}" style="color: #1BC5BD" download>{{$item->enumeration}}</a></td>
                    <td>{{$item->mark_id}}</td>
                    <td>{{$item->print_date}}</td>
                    <td><a href="{{ route('reservation-show', $item->activities->first()->reservation) }}">
                            #{{ str_pad($item->activities->first()->reservation->id, 5, '0', STR_PAD_LEFT) }}
                        </a>
                    </td>
                    <td>{{$item->document_info->guest->full_name}}</td>
                    <td>{{showPriceWithCurrency($item->total)}}</td>
                    <td>
                        @if ($item->paid == 1)
                            <span
                                style='background-color:#48BD91;padding:2px 8px;color:white;border-radius:2px;'> Paid </span>
                        @else
                            <span
                                style='background-color:red;padding:2px 8px;color:white;border-radius:2px;'> Not Paid </span>
                        @endif
                    </td>
                    <td>
                        @if(annullingDocumentCreated($item->activities->first()->reservation_id))
                            <div class='col'>
                                <button type='button' class=' disabled'
                                        style='background-color:gray;padding:2px 12px;color:white;border:none !important;border-radius:2px;'>
                                    Created
                                </button>
                            </div>
                        @else
                            <div class='col'>
                                <button type='button' data-toggle="modal" data-target="#annullingConfirmation"
                                        style='background-color:#48BBBE;padding:2px 12px;color:white;border-radius:2px;border:none !important;' onclick="setId('{{$item->id}}')"
                                        class=''>Create
                                </button>
                            </div>
                        @endif
                    </td>
                    <td>
                        @if($item->discount!=$item->activities->first()->reservation->discount)
                        @if(annullingDocumentCreated($item->activities->first()->reservation_id))
                            <button type='button' data-toggle="modal" data-target="#refundConfirmation" onclick="setId2('{{$item->id}}')"
                                    style='background-color:#48BBBE;padding:2px 12px;color:white;border-radius:2px;border:none !important;'>
                                Submit
                            </button>
                        @else
                            <button title='You must create a special annuling document first in order to refund' type='button' rel="tooltip" data-toggle="tooltip" data-placement="top"  aria-hidden="true" 
                                    style='background-color:gray;padding:2px 12px;color:white;border-radius:2px;border:none !important;'>
                                Submit
                            </button>
                        @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>
    <!-- Modals -->
    <div class="modal fade" id="annullingConfirmation" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light" style="margin-left:-10px;" id="exampleModalLabel">Document
                        Confirmation<span></span></h5>
                </div>
                <form action="{{route('add-special-annulling')}}" method="POST">
                    @csrf
                    <div class="modal-body"
                         style="z-index:1004;position:relative;background-color:#F5F7F9;margin-top:-2%;">
                         
                         <h4>To create Special Annuling Document, you must add discount</h4>
						<!-- <div class="inner mt-7">
						<div class="form-row row">
						<div class="form-holder col">
						<label class="form-row-inner">
						</label>
						</div>
						</div>
						</div> -->
						<div class="row">
                            <div class="col">
                                <input type="hidden" class="form-control1" name="document_id" id="document_id">
                        
                                <input type="text" class="form-control"  value='' name="discount"
                                id="discount"  placeholder="Enter discount" required="">
                            </div>
							
						</div>
                    </div>
                    <div class="modal-footer" style="background-color:#F5F7F9;">
                        <button type="submit" class="float-right"
                                style='background-color:#48BBBE;padding:2px 12px;color:white;border-radius:2px;
	  border:none;'>Proceed
                        </button>
                        <button type="button" class="" data-dismiss="modal"
                                style='background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'>
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="refundConfirmation" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light" style="margin-left:-10px;" id="exampleModalLabel">Refund
                        Confirmation<span></span>
                    </h5>
                </div>
                <div class="modal-header" style="z-index:1;border:none;background-color:#F5F7F9;">
                </div>
                <form action="{{route('add-refund')}}" method="POST">
                    @csrf
                    <div class="modal-body"
                         style="z-index:1004;position:relative;background-color:#F5F7F9;margin-top:-2%;">
                        <input type="hidden" name="document_id" id="document_id2">
                        
                        <h4>Are you sure you want to proceed to refund?</h4>
                    </div>
                    <div class="modal-footer" style="background-color:#F5F7F9;">
                        <button type="submit" name="create-refund-document" class="float-right"
                                style='background-color:#48BBBE;padding:2px 12px;color:white;border-radius:2px;
	  border:none;' id="addrefund">Yes
                        </button>
                        <button type="button" class="" data-dismiss="modal"
                                style='background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'>
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function setId(id){
            $('#document_id').val(id);
        }
        function setId2(id){
            $('#document_id2').val(id);
        }
    </script>
@endpush


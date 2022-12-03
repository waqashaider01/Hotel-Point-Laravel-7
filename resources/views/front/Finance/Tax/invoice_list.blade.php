@extends('layouts.master')
@section('content')
    <div>
        <x-table title='Invoice List'>
            <x-slot name="header">
                <div class="row">
                    <div class="col-md-10 form-group d-inline-block">
                        <form action="{{route('invoice-list')}}" method="get">
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
                <td>Invoice No.</td>
                <td>Mark ID</td>
                <td>Invoice Date</td>
                <td>Booking ID</td>
                <td>Company Name</td>
                <td>Invoice Amount</td>
                <td>Payment Condition</td>
                <td>Credit Note</td>
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
                    <td>{{optional($item->document_info->company)->name ?? ''}}</td>
                    <td>{{showPriceWithCurrency($item->total)}}</td>
                    <td><span
                            style='background-color:{{($item->paid == 1)?"#48BD91":"red"}};padding:2px 8px;color:white;border-radius:2px;'>
                            {{($item->paid == 1)?'Paid':'Not Paid'}}
                        </span>
                    </td>
                    <td>
                        @php
                            $checkCreditNote = \App\Models\Document::query()->where('document_type_id',6)->whereHas('activities',fn($q)=>$q->where('reservation_id',$item->activities->first()->reservation_id))->count()
                        @endphp
                        @if($checkCreditNote)
                            <input type='button' name='view' value='Created' id=''
                                   style='background-color:gray;padding:2px 12px;color:white;border:none !important;border-radius:2px;'
                                   class=' disabled'>
                        @else
                            <input type='button' name='view' value='Create' id='$documentId' data-toggle="modal" data-target="#creditConfirmation" onclick="setId('{{$item->id}}')"
                                   style='background-color:#48BBBE;padding:2px 12px;color:white;border-radius:2px;border:none !important;'
                                   class=' popupBtn'>
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>
     <!-- Modals -->
     <div class="modal fade" id="creditConfirmation" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light" style="margin-left:-10px;" id="exampleModalLabel">Refund
                        Confirmation<span></span></h5>
                </div>
                <form action="{{route('add-credit-note')}}" method="POST">
                    @csrf
                    <div class="modal-body"
                         style="z-index:1004;position:relative;background-color:#F5F7F9;margin-top:-2%;">
                         
                         <h4>Please Enter the amount to refund</h4>
						<div class="row">
                            <div class="col">
                                <input type="hidden" class="form-control1" name="document_id" id="document_id">
                        
                                <input type="text" class="form-control"  value='' name="discount"
                                id="discount"  placeholder="Enter refund amount" required="">
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
    
@endsection
@push('scripts')
    <script>
        function setId(id){
            $('#document_id').val(id);
        }
        
    </script>
@endpush


@extends('layouts.master')
@section('content')
    <div>
        <x-table title='Overnight Tax'>
            <x-slot name="header">
                <div class="row">
                    <div class="col-md-10 form-group d-inline-block">
                        <form action="{{route('overnight-tax-list')}}" method="get">
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
                <td>Tax No.</td>
                <td>Mark ID</td>
                <td>Receipt Date</td>
                <td>Booking ID</td>
                <td>Guest Name</td>
                <td>Tax Amount</td>
                <td>Payment Status</td>
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
                        <span
                            style='background-color:{{($item->paid == 1)?"#48BD91":"red"}};padding:2px 8px;color:white;border-radius:2px;'>
                            {{($item->paid == 1)?'Paid':'Not Paid'}}
                        </span>
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>
@endsection

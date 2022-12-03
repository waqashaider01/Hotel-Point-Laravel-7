<div>

        <div class="d-flex flex-column-fluid">
        
            <div class="container-fluid mb-10">
                <div class="listcard">
                    <div class="" style="background-color:#48BBBE; margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
                        <h2 class="pt-7 pl-3 pb-7"  >In House List</h2>
                    </div>
                    
                        <div class='row'>
                            <div class='col-6'>
                                <table>
                                    <tr>
                                        <td>
                                            <div class="form-style-6" style="" >
                                            <input wire:change="setdate($event.target.value)" class="form-control1"  name='date' type="date"  id="from"  value="{{$selectedDate}}"/>
                
                                            </div>
                                        </td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                </table>
                
                            </div>
            
                            <div class="col-6 mt-10 d-print-none">
                                <div  style="float:right;">			
                                
                                    <a href="javascript:if(window.print)window.print()" class="  " style='background-color:black;padding:2px 12px;color:white;border-radius:2px;'>
                                        <span class="navi-icon">
                                            <i class="fa fa-print" style="color:white !important;"></i>
                                        </span>
                                        <span class="" >Print</span>
                                    </a>
                                
                                
                    
                                </div>
                        </div>
                    </div>
                
            </div>
            
                <div class="listcard listcard-custom mt-10">
                    
                    <div class="table-responsive">
                        <table  class="table " >
                            <thead>
                                <tr class="text-center">
                                    <th >Booking ID</th>
                                    <th>Guest Name</th>
                                    <th>Room</th>
                                    <th>Room Type</th>
                                    <th>Adults</th>
                                    <th>Children</th>
                                    <th>Infants</th>
                                    
                                </tr>
                            </thead>
                            <tbody id="tabbody">
                            
                            @forelse($inhouse as $row)
                                <tr class="bg-white text-center">
                                        
                                            <td class="idcolor">#{{$row[0]}}</td>
                                            <td>{{$row[1]}}</td>
                                            <td>{{$row[2]}}</td>
                                            <td>{{$row[3]}}</td>
                                            <td>{{$row[4]}}</td>
                                            <td>{{$row[5]}}</td>
                                            <td>{{$row[6]}}</td>
                                            
                                    </tr>
                            @empty

                                <tr class="bg-white text-center">
                                    <td colspan="8">No in house</td>
                                </tr>
                                    
                            @endforelse

                            </tbody>
                        </table> 
                    </div>  
            
            </div>


        </div>
    </div>


</div>

<div>
   <!--begin::Entry-->
   <div class="d-flex flex-column-fluid ">
        <!--begin::Container-->
        <div class="container-fluid">

	         <div class="listcard " style="" >
                    <div class="" style="background-color:#48BBBE; margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
                          <h2 class="pt-7 pl-3 pb-7" >Housekeeping Day</h2> 
                    </div>
                    <div class='row'>
                            <div class='col-md-5'>
                                    <table>
                                        <tr>
                                            <td>
                                                <div class="form-style-6" style="" >
                                                <input wire:change="setdate($event.target.value)" class="" name='date' type="date"  id="from"  value="{{$date}}"/>
                                                
                                                </div>
                                            </td>
                                            <td>
                                                
                                            </td>
                                        </tr>
                                    </table>
                                </div>
            
                                <div class="col-md-7 mt-11 d-print-none form-group">
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
                   
             </div>
            
	  
										
   			<div class="listcard listcard-custom mt-10 mb-4">
			    
                 <div class="table-responsive">
                        <table  class="table " >
                            <thead>
                            <tr class="text-center">
                                <th>Room</th>
                                <th>Status</th>
                                <th>Comments</th>
                                
                            </tr>
                            </thead>
                            <tbody id="tabbody">
                                @forelse($records as $record)
                                <tr class="text-center bg-white">
                                  <td class="idcolor">{{$record['room']}}</td>
                                  <td>{{$record['status']}}</td>
                                  <td>{{$record['comment']}}</td>
                                
                                </tr>
                                @empty
                                <tr class="text-center bg-white">
                                    <td colspan="3">Not Found</td>
                                </tr>
                                @endforelse
                            
                            </tbody>
                        </table>
                    </div>
						
						      
            </div>
					
		</div>
				
	</div> 

             
  </div>


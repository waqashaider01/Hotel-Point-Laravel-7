<div>
   <!--begin::Entry-->
   <div class="d-flex flex-column-fluid ">
        <!--begin::Container-->
        <div class="container-fluid">

	         <div class="listcard " style="" >
                    <div class="" style="background-color:#48BBBE; margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
                          <h2 class="pt-7 pl-3 pb-7" >Housekeeping Period Report</h2> 
                    </div>
                    <div class='row'>
                            <div class='col-md-5'>
                                    <table>
                                        <tr>
                                            <td>
                                                <div class="form-style-6" style="" >
                                                <input class="" name='date' type="date"  id="from"  value="{{$startDate}}"/>
                                                
                                                </div>
                                            </td>
                                            <td>
                                               <div class="form-style-6" style="" >
                                                    <input  class="" name='date' type="date"  id="to"  value="{{$endDate}}"/>
                                                
                                                </div>
                                                
                                            </td>
                                            <td>
                                               <div class="form-style-6" style="" >
                                               <button type="button"    id="submit"  class=""  style='background-color:#48BD91;border:none !important;padding:2px 12px;color:white;border-radius:2px;'>Run</button>
                                                
                                                </div>
                                                
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
             <div class="row">
                    <div class="col">
                            <div class="listcard listcard-custom mt-10 " style="height:350px;" >
                                    <div id="columnchart_material" style="width: 100%; height: 100%;"></div>
                            </div>
                    </div>
            </div>
	  
										
   			<div class="listcard listcard-custom mt-10 mb-4">
			    
                 <div class="table-responsive">
                        <table  class="table " >
                            <thead>
                            <tr class="text-center">
                                <th>Room</th>
                                <th>Departure</th>
                                <th>Arrival</th>
                                <th>Accomodated</th>
                                <th>Out of Order</th>
                                
                            </tr>
                            </thead>
                            <tbody id="tabbody">
                                @forelse($monthlyRecords as $record)
                                <tr class="text-center bg-white">
                                  <td class="idcolor">{{$record['room']}}</td>
                                  <td>{{$record['departure']}}</td>
                                  <td>{{$record['arrival']}}</td>
                                  <td>{{$record['accommodated']}}</td>
                                  <td>{{$record['outOfOrder']}}</td>
                                
                                </tr>
                                @empty
                                <tr class="text-center bg-white">
                                    <td colspan="3">No Room Found</td>
                                </tr>
                                @endforelse
                            
                            </tbody>
                        </table>
                    </div>
						
						      
            </div>
					
		</div>
				
	</div> 

<script type="text/javascript">
    $(document).ready(function(){
        document.addEventListener("yearlyChanged", () => {
                
            addChart(@this.totalArrival, @this.totalDeparture, @this.totalAccomodated, @this.totalOutOfOrder);

            });
        addChart(@this.totalArrival, @this.totalDeparture, @this.totalAccomodated, @this.totalOutOfOrder);

        $("#from").on('change', function(){
            let selectedDate=$(this).val();
            $("#to").attr('min', selectedDate);
            $("#to").val('');
        })

        $("#submit").on('click', function(){
            let from =$("#from").val();
            let to=$("#to").val();
            @this.setdate(from, to);
            
        })
    })

    function addChart(arrival, departure, accomodation, ooo){
        
        
          google.charts.load("current", {packages:["corechart"]});
          google.charts.setOnLoadCallback(drawChart);
          function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Housekeeping', 'Total', {role:'style'}],
                ['Arrivals', arrival, '#498860' ],
                ['Departures', departure, 'grey'],
                ['Accommodated', accomodation, 'yellow'],
                ['Out of order', ooo, 'black']
                ]);

            var options = {
              
              is3D: true,
              legend:{position:"none"}
              
             
            };
            var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_material'));
            chart.draw(data, options);
            

          }

    }
          
   </script>
   

             
  </div>


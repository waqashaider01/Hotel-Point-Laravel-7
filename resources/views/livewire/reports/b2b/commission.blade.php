<div>
 
 <div class="d-flex flex-column-fluid ">
    
    <div class="container-fluid">
          <div class="listcard " >
         	<div class="" style=" background-color:#48BBBE;margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
		       <h2 class="pt-7 pl-3 pb-7" >Market Commission</h2>
               
            </div>
           
                <div class='row'>
                  <div class='col-md-10'>
			         <table>
                           <tr>
                                <td>
                                    <div class="form-style-6" style="" >
                                        <input type="date"  id="from_date"  data-date-format="mm-yyyy" 
                                                value="{{$startDate}}"/>
                                     </div>
                                </td>
                                <td>
                                    <span class="text-center" >-To-</span>
                                        
                                </td>
                                
                                <td>
                                    <div class="form-style-6" style="" >
                                        <input type="date"  id="to_date"  data-date-format="mm-yyyy" 
                                                value="{{$endDate}}" />
                                     </div>
                                </td>
                                
                                <td>
                                    <div class=" d-print-none  form-style-6" style="" >		
                                            <button type="button" id="submit"  style='background-color:#48BD91;border:none !important;padding:2px 12px;color:white;border-radius:2px;'>Run</button>
                                            
                                    </div>
                                </td>
                          </tr>
                     </table>
                 </div>
             
                 <div class="col-md-2 mt-11 d-print-none form-group">
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
      <div wire:ignore class="row">
            <div class="col">
                   <div class="listcard listcard-custom mt-10 " style="height:350px;" >
                        <div id="commissionChart" style="width: 100%; height: 100%;"></div>
                   </div>
             </div>
	   </div>
	  
                        
               
   	   <div  class="listcard listcard-custom mt-10 mb-4">
			  
             <div class="table-responsive">
                <table  class="table " >
                    <thead>
                    <tr class="text-center">
                        <th>Channel</th>
                        <th>Actual Sales Amount</th>
                        <th>Commission Amount</th>
                        <th>Commission %</th>
                        
                    </tr>
                    </thead>
                    <tbody id="tabbody">
                        @forelse($statistics as $occ)
                            <tr class="text-center bg-white">
                                        <td class="idcolor">{{$occ[0]}}</td>
                                        <td>{{$occ[1]}}</td>
                                        <td>{{$occ[2]}}</td>
                                        <td >{{$occ[3]}}%</td>
                                        
                                </tr>
                           @empty
                              <tr class="text-center bg-white">
                                   <td colspan="4">No record found</td>
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
            setMin();

            function setMin(){
                    let selectedDate=$("#from_date").val();
                    $("#to_date").attr('min', selectedDate);
                    
            }

              $("#submit").on('click', function(){
                  let startDate=$("#from_date").val();
                  let endDate=$("#to_date").val();
                  let roomtype=$("#roomtype").val();
                  if (startDate=="" || endDate=="" || roomtype=="") {
                    
                  }else{
                    @this.setValues(startDate, endDate, roomtype);
                   
                  }
              })
            
                populateChart();

                $("#from_date").on('change', function(){
                    setMin();
                    $("#to_date").val('');
                })

        document.addEventListener("commissionChanged", () => {
                
            populateChart();
                
         });
                                
                  
        })
                       

 


function populateChart(){
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(updateChart);

function updateChart(){
           
           var data = google.visualization.arrayToDataTable(@this.chartdata);
           var options = {
                        width:'100%',
                        chartArea:{width:'90%'},
                        
                        hAxis: {title: '',  titleTextStyle: {color: '#333'}},
                        colors:['#008080','#87CEFA'],
                        vAxis:{viewWindow:{min:0}},
                        legend:{position:"none"},
                        curveType:'function', 
                        pointSize:5
             
            };

            var chart = new google.visualization.AreaChart(document.getElementById('commissionChart'));
            chart.draw(data, options);
           

}
}






</script>


</div>

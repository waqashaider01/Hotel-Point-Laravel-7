<div>
 
 <div class="d-flex flex-column-fluid ">
    
    <div class="container-fluid">
          <div class="listcard " >
         	<div class="" style=" background-color:#48BBBE;margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
		       <h2 class="pt-7 pl-3 pb-7" >Overnight Tax Report</h2>
               
            </div>
            
            <form  style="width:100%;">
                <div class='row'>
                  <div class='col-md-5'>
			         <table>
                           <tr>
                                <td>
                                    <div class="form-style-6" style="" >
                                        <input wire:change="set_date($event.target.value)" name='selectedDate' type="date"  id="from"  data-date-format="mm-yyyy" 
                                                value="{{$selectedDate}}"/>
                        
                        
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
          </form>
       </div>
      <div wire:ignore class="row">
            <div class="col">
                   <div class="listcard listcard-custom mt-10 " style="height:350px;" >
                        <div id="linechart" style="width: 100%; height: 100%;"></div>
                   </div>
             </div>
	   </div>
	  
                        
               
   	   <div  class="listcard listcard-custom mt-10 mb-4">
			  <div  class="" style="background-color:#48BBBE;margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
		
					<div class="inner ">
						<div class="form-row row">
                            <div class="form-holder col-4 "></div>
                            <div class="form-holder col-4 ">
                                <div class="text-center" style="">
                                <label class="form-row-inner">
                                            <select wire:ignore wire:change="set_year($event.target.value)"  id="dropdown1"  class="btn custom-selects"  >
                                            </select>  	
                                           
                                </label>
                                </div>	
                            </div>
                        </div>
                    </div>
             </div>
             <div class="table-responsive">
                <table  class="table " >
                    <thead>
                    <tr class="text-center">
                        <th id="syear">{{$year}}</th>
                        <th><div data-original-title="{{showPriceWithCurrency($total[0])}}" rel="tooltip" data-html="true" type="button" data-toggle="tooltip" data-placement="top"  aria-hidden="true">Jan</div> </th>
                        <th><div data-original-title="{{showPriceWithCurrency($total[1])}}" rel="tooltip" data-html="true" type="button" data-toggle="tooltip" data-placement="top"  aria-hidden="true">Feb</div></th>
                        <th><div data-original-title="{{showPriceWithCurrency($total[2])}}" rel="tooltip" data-html="true" type="button" data-toggle="tooltip" data-placement="top"  aria-hidden="true">Mar</div></th>
                        <th><div data-original-title="{{showPriceWithCurrency($total[3])}}" rel="tooltip" data-html="true" type="button" data-toggle="tooltip" data-placement="top"  aria-hidden="true">Apr</div></th>
                        <th><div data-original-title="{{showPriceWithCurrency($total[4])}}" rel="tooltip" data-html="true" type="button" data-toggle="tooltip" data-placement="top"  aria-hidden="true">May</div></th>
                        <th><div data-original-title="{{showPriceWithCurrency($total[5])}}" rel="tooltip" data-html="true" type="button" data-toggle="tooltip" data-placement="top"  aria-hidden="true">Jun</div></th>
                        <th><div data-original-title="{{showPriceWithCurrency($total[6])}}" rel="tooltip" data-html="true" type="button" data-toggle="tooltip" data-placement="top"  aria-hidden="true">Jul</div></th>
                        <th><div data-original-title="{{showPriceWithCurrency($total[7])}}" rel="tooltip" data-html="true" type="button" data-toggle="tooltip" data-placement="top"  aria-hidden="true">Aug</div></th>
                        <th><div data-original-title="{{showPriceWithCurrency($total[8])}}" rel="tooltip" data-html="true" type="button" data-toggle="tooltip" data-placement="top"  aria-hidden="true">Sep</div></th>
                        <th><div data-original-title="{{showPriceWithCurrency($total[9])}}" rel="tooltip" data-html="true" type="button" data-toggle="tooltip" data-placement="top"  aria-hidden="true">Oct</div></th>
                        <th><div data-original-title="{{showPriceWithCurrency($total[10])}}" rel="tooltip" data-html="true" type="button" data-toggle="tooltip" data-placement="top"  aria-hidden="true">Nov</div></th>
                        <th><div data-original-title="{{showPriceWithCurrency($total[11])}}" rel="tooltip" data-html="true" type="button" data-toggle="tooltip" data-placement="top"  aria-hidden="true">Dec</div></th>
                    </tr>
                    </thead>
                    <tbody id="tabbody">
                    @forelse($cardsData as $card)
                        <tr class="text-center bg-white">
                            
                                <td class="idcolor">{{$card['card']}}</td>
                                <td>{{$card['1']}}</td>
                                <td>{{$card['2']}}</td>
                                <td>{{$card['3']}}</td>
                                <td>{{$card['4']}}</td>
                                <td>{{$card['5']}}</td>
                                <td>{{$card['6']}}</td>
                                <td>{{$card['7']}}</td>
                                <td>{{$card['8']}}</td>
                                <td>{{$card['9']}}</td>
                                <td>{{$card['10']}}</td>
                                <td>{{$card['11']}}</td>
                                <td>{{$card['12']}}</td>
                          
                        </tr>
                        @empty

                         <tr class="text-center bg-white"><td colspan="13">No Payment Method found</td></tr>

                    @endforelse
                    </tbody>
                </table>
            </div>
            
        </div>

    </div>

           
</div>


    <script type="text/javascript">
        $(document).ready(function(){
            
            fetch("{{route('getMinDate')}}").then(result=> result.json()).then(json => show1(json))

                function show1(emp)
                    {
                       
                    var maxyear=emp.maxyear;
                    var minyear=emp.minyear;
                    var dropdown=document.getElementById("dropdown1");
                    dropdown.innerHTML="";
                    for(minyear; minyear<=maxyear; minyear++ ){ 

                        var option="<option class='custom-select-option'  value='"+minyear+"' >"+minyear+"</option>";
                        
                        dropdown.innerHTML+=option;

                        }
                        let option1="<option selected disabled class='custom-select-disabled' >"+@this.year+"</option>";
                        $("#dropdown1").prepend(option1);
                        

                } 
                populateChart(@this.chartdata);
                document.addEventListener("overnightChanged", () => {
                    $("#dropdown1").find('option:disabled').remove();
                    let option1="<option selected disabled style='background:#fff; color:#000; padding:10px !important; font-size:20px;'>"+@this.year+"</option>";
                    $("#dropdown1").prepend(option1);
                    populateChart(@this.chartdata);
                    
                    
             });

                
        })
                       

 


function populateChart(chartdata){
    $('[data-toggle="tooltip"]').tooltip();
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(updateChart);

function updateChart(){
           

    var data = google.visualization.arrayToDataTable(chartdata);

          
           var options = {
            width:'95%',
              chartArea:{width:'85%'},
              legend:{position:"none"},
              colors:['#DC7633','#87CEFA', '#58D68D'],
              vAxis:{viewWindow:{min:0}},
              curveType:'function', 
              pointSize:5
            };
           var chart = new google.visualization.LineChart(document.getElementById('linechart'));
           chart.draw(data, options);
           

}
}






</script>


</div>

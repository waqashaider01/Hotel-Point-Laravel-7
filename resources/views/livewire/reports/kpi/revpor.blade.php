<div>
 
 <div class="d-flex flex-column-fluid ">
    
    <div class="container-fluid">
          <div class="listcard " >
         	<div class="" style=" background-color:#48BBBE;margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
		       <h2 class="pt-7 pl-3 pb-7" >RevPOR Report</h2>
               
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
                        <div id="revporchart" style="width: 100%; height: 100%;"></div>
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
                                            <select wire:ignore wire:change="set_year($event.target.value)"  id="dropdown1"  class="btn custom-selects ">
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
                        <th id="syear">RevPOR Index</th>
                        <th>Jan</th>
                        <th>Feb</th>
                        <th>Mar</th>
                        <th>Apr</th>
                        <th>May</th>
                        <th>Jun</th>
                        <th>Jul</th>
                        <th>Aug</th>
                        <th>Sep</th>
                        <th>Oct</th>
                        <th>Nov</th>
                        <th>Dec</th>
                    </tr>
                    </thead>
                    <tbody id="tabbody">
                    <tr class="text-center bg-white">
                                <td class="idcolor">Actual</td>
                                <td>{{$actual1[0]}}</td>
                                <td>{{$actual1[1]}}</td>
                                <td>{{$actual1[2]}}</td>
                                <td>{{$actual1[3]}}</td>
                                <td>{{$actual1[4]}}</td>
                                <td>{{$actual1[5]}}</td>
                                <td>{{$actual1[6]}}</td>
                                <td>{{$actual1[7]}}</td>
                                <td>{{$actual1[8]}}</td>
                                <td>{{$actual1[9]}}</td>
                                <td>{{$actual1[10]}}</td>
                                <td>{{$actual1[11]}}</td>
                        </tr>

                       <tr class="text-center bg-white">
                                <td class="idcolor">Forecast</td>
                                <td>{{$forecast1[0]}}</td>
                                <td>{{$forecast1[1]}}</td>
                                <td>{{$forecast1[2]}}</td>
                                <td>{{$forecast1[3]}}</td>
                                <td>{{$forecast1[4]}}</td>
                                <td>{{$forecast1[5]}}</td>
                                <td>{{$forecast1[6]}}</td>
                                <td>{{$forecast1[7]}}</td>
                                <td>{{$forecast1[8]}}</td>
                                <td>{{$forecast1[9]}}</td>
                                <td>{{$forecast1[10]}}</td>
                                <td>{{$forecast1[11]}}</td>
                        </tr>
                        <tr class="text-center bg-white">
                                <td class="idcolor">%</td>
                                <td style="color:{{$difference[0]['color']}}">{{$difference[0]['value']}}%</td>
                                <td style="color:{{$difference[1]['color']}}">{{$difference[1]['value']}}%</td>
                                <td style="color:{{$difference[2]['color']}}">{{$difference[2]['value']}}%</td>
                                <td style="color:{{$difference[3]['color']}}">{{$difference[3]['value']}}%</td>
                                <td style="color:{{$difference[4]['color']}}">{{$difference[4]['value']}}%</td>
                                <td style="color:{{$difference[5]['color']}}">{{$difference[5]['value']}}%</td>
                                <td style="color:{{$difference[6]['color']}}">{{$difference[6]['value']}}%</td>
                                <td style="color:{{$difference[7]['color']}}">{{$difference[7]['value']}}%</td>
                                <td style="color:{{$difference[8]['color']}}">{{$difference[8]['value']}}%</td>
                                <td style="color:{{$difference[9]['color']}}">{{$difference[9]['value']}}%</td>
                                <td style="color:{{$difference[10]['color']}}">{{$difference[10]['value']}}%</td>
                                <td style="color:{{$difference[11]['color']}}">{{$difference[11]['value']}}%</td>
                        </tr>

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

                        var option="<option class='custom-select-option' value='"+minyear+"' >"+minyear+"</option>";
                        
                        dropdown.innerHTML+=option;

                        }
                        let option1="<option selected disabled class='custom-select-disabled'>"+@this.year+"</option>";
                        $("#dropdown1").prepend(option1);
                        

                } 
                populateChart();
                document.addEventListener("revporChanged", () => {
                    $("#dropdown1").find('option:disabled').remove();
                    let option1="<option selected disabled style='background:#fff; color:#000; padding:10px !important; font-size:20px;'>"+@this.year+"</option>";
                    $("#dropdown1").prepend(option1);
                    populateChart();
                    
                    
             });

               
        })
                       

 


function populateChart(){
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(updateChart);

function updateChart(){
           

           var data = google.visualization.arrayToDataTable([
                    ['Month',  'Forecast', 'Actual'],
                    ['Jan', {v:parseFloat(@this.forecast[0]), f:String(@this.forecast1[0]) }, {v:parseFloat(@this.actual[0]), f:String(@this.actual1[0]) } ],
                    ['Feb', {v:parseFloat(@this.forecast[1]), f:String(@this.forecast1[1]) }, {v:parseFloat(@this.actual[1]), f:String(@this.actual1[1]) }],
                    ['Mar', {v:parseFloat(@this.forecast[2]), f:String(@this.forecast1[2]) }, {v:parseFloat(@this.actual[2]), f:String(@this.actual1[2]) }],
                    ['Apr', {v:parseFloat(@this.forecast[3]), f:String(@this.forecast1[3]) }, {v:parseFloat(@this.actual[3]), f:String(@this.actual1[3]) }],
                    ['May', {v:parseFloat(@this.forecast[4]), f:String(@this.forecast1[4]) }, {v:parseFloat(@this.actual[4]), f:String(@this.actual1[4]) }],
                    ['Jun', {v:parseFloat(@this.forecast[5]), f:String(@this.forecast1[5]) }, {v:parseFloat(@this.actual[5]), f:String(@this.actual1[5]) }],
                    ['Jul', {v:parseFloat(@this.forecast[6]), f:String(@this.forecast1[6]) }, {v:parseFloat(@this.actual[6]), f:String(@this.actual1[6]) }],
                    ['Aug', {v:parseFloat(@this.forecast[7]), f:String(@this.forecast1[7]) }, {v:parseFloat(@this.actual[7]), f:String(@this.actual1[7]) }],
                    ['Sep', {v:parseFloat(@this.forecast[8]), f:String(@this.forecast1[8]) }, {v:parseFloat(@this.actual[8]), f:String(@this.actual1[8]) }],
                    ['Oct', {v:parseFloat(@this.forecast[9]), f:String(@this.forecast1[9]) }, {v:parseFloat(@this.actual[9]), f:String(@this.actual1[9]) }],
                    ['Nov', {v:parseFloat(@this.forecast[10]), f:String(@this.forecast1[10]) }, {v:parseFloat(@this.actual[10]), f:String(@this.actual1[10]) }],
                    ['Dec', {v:parseFloat(@this.forecast[11]), f:String(@this.forecast1[11]) }, {v:parseFloat(@this.actual[11]), f:String(@this.actual1[11]) }]
           ]);
           

           
         
          
           var options = {
            width:'95%',
              chartArea:{width:'85%'},
              legend:{position:"none"},
              hAxis: {title: {{$year}},  titleTextStyle: {color: '#333'}},
              colors:['#008080','#87CEFA'],
              vAxis:{viewWindow:{min:0}},
              curveType:'function', 
              pointSize:5
            };
           var chart = new google.visualization.LineChart(document.getElementById('revporchart'));
           chart.draw(data, options);
           

}
}






</script>


</div>

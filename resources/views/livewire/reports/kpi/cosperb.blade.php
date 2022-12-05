<div>
 
 <div class="d-flex flex-column-fluid ">
    
    <div class="container-fluid">
          <div class="listcard " >
         	<div class="" style=" background-color:#48BBBE;margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
		       <h2 class="pt-7 pl-3 pb-7" >CosPerB Report</h2>
               
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
             
                 <div class="col-md-7 d-print-none form-group" style="margin: 10px auto;">
                      <div style="float:right; " class="print_btn">			
                                
                                    <a href="javascript:if(window.print)window.print()" class="">
                                            <span class="navi-icon mr-2">
                                                <i class="fa fa-print"></i>
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
                        <div id="cosperbchart" style="width: 100%; height: 100%;"></div>
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
                                            <select wire:ignore wire:change="set_year($event.target.value)"  id="dropdown1"  class="btn custom-selects">
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
                        <th id="syear">CosPerB Index</th>
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
                populateChart(@this.chartdata);
                document.addEventListener("cosperBChanged", () => {
                    $("#dropdown1").find('option:disabled').remove();
                    let option1="<option selected disabled style='background:#fff; color:#000; padding:10px !important; font-size:20px;'>"+@this.year+"</option>";
                    $("#dropdown1").prepend(option1);
                    populateChart(@this.chartdata);
                    
                    
             });

              
        })
                       

 


function populateChart(chartdata){
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(updateChart);

function updateChart(){
           

                 var data = google.visualization.arrayToDataTable([
                                ['Month',  'CosPerB', 'CosPerB'],
                                ['Jan', {v:parseFloat(@this.actual[0]), f:String(@this.actual1[0]) }, {v:parseFloat(@this.actual[0]), f:String(@this.actual1[0]) } ],
                                ['Feb', {v:parseFloat(@this.actual[1]), f:String(@this.actual1[1]) }, {v:parseFloat(@this.actual[1]), f:String(@this.actual1[1]) }],
                                ['Mar', {v:parseFloat(@this.actual[2]), f:String(@this.actual1[2]) }, {v:parseFloat(@this.actual[2]), f:String(@this.actual1[2]) }],
                                ['Apr', {v:parseFloat(@this.actual[3]), f:String(@this.actual1[3]) }, {v:parseFloat(@this.actual[3]), f:String(@this.actual1[3]) }],
                                ['May', {v:parseFloat(@this.actual[4]), f:String(@this.actual1[4]) }, {v:parseFloat(@this.actual[4]), f:String(@this.actual1[4]) }],
                                ['Jun', {v:parseFloat(@this.actual[5]), f:String(@this.actual1[5]) }, {v:parseFloat(@this.actual[5]), f:String(@this.actual1[5]) }],
                                ['Jul', {v:parseFloat(@this.actual[6]), f:String(@this.actual1[6]) }, {v:parseFloat(@this.actual[6]), f:String(@this.actual1[6]) }],
                                ['Aug', {v:parseFloat(@this.actual[7]), f:String(@this.actual1[7]) }, {v:parseFloat(@this.actual[7]), f:String(@this.actual1[7]) }],
                                ['Sep', {v:parseFloat(@this.actual[8]), f:String(@this.actual1[8]) }, {v:parseFloat(@this.actual[8]), f:String(@this.actual1[8]) }],
                                ['Oct', {v:parseFloat(@this.actual[9]), f:String(@this.actual1[9]) }, {v:parseFloat(@this.actual[9]), f:String(@this.actual1[9]) }],
                                ['Nov', {v:parseFloat(@this.actual[10]), f:String(@this.actual1[10]) }, {v:parseFloat(@this.actual[10]), f:String(@this.actual1[10]) }],
                                ['Dec', {v:parseFloat(@this.actual[11]), f:String(@this.actual1[11]) }, {v:parseFloat(@this.actual[11]), f:String(@this.actual1[11]) }]
                        ]);

                       var options = {
                                width:'95%',
                                chartArea:{width:'85%'},
                                colors:['#87CEFA', '#008080'],
                                vAxis:{viewWindow:{min:0}},
                                legend:{position:"none"},
                                seriesType:'bars',
                                series:{1:{type:'line', curveType:'function', pointSize:5}}

                              };
                         
                          var chart = new google.visualization.ComboChart(document.getElementById('cosperbchart'));

                          chart.draw(data, options);
           

          }
}






</script>


</div>

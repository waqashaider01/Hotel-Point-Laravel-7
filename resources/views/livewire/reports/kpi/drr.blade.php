<div>
 
 <div class="d-flex flex-column-fluid ">
    
    <div class="container-fluid">
          <div class="listcard " >
         	<div class="" style=" background-color:#48BBBE;margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
		       <h2 class="pt-7 pl-3 pb-7" >Direct Revenue Ratio Report</h2>
               
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
                        <div id="drrchart" style="width: 100%; height: 100%;"></div>
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
                        <th id="syear">DRR Index</th>
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
                                <td>{{$actual[0]}}</td>
                                <td>{{$actual[1]}}</td>
                                <td>{{$actual[2]}}</td>
                                <td>{{$actual[3]}}</td>
                                <td>{{$actual[4]}}</td>
                                <td>{{$actual[5]}}</td>
                                <td>{{$actual[6]}}</td>
                                <td>{{$actual[7]}}</td>
                                <td>{{$actual[8]}}</td>
                                <td>{{$actual[9]}}</td>
                                <td>{{$actual[10]}}</td>
                                <td>{{$actual[11]}}</td>
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
                document.addEventListener("drrChanged", () => {
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
                                ['Month',  'DRR', {role:'annotation'}],
                                ['Jan', parseFloat(@this.actual[0]), parseFloat(@this.actual[0])],
                                ['Feb', parseFloat(@this.actual[1]), parseFloat(@this.actual[1])],
                                ['Mar', parseFloat(@this.actual[2]), parseFloat(@this.actual[2])],
                                ['Apr', parseFloat(@this.actual[3]), parseFloat(@this.actual[3])],
                                ['May', parseFloat(@this.actual[4]), parseFloat(@this.actual[4])],
                                ['Jun', parseFloat(@this.actual[5]), parseFloat(@this.actual[5])],
                                ['Jul', parseFloat(@this.actual[6]), parseFloat(@this.actual[6])],
                                ['Aug', parseFloat(@this.actual[7]), parseFloat(@this.actual[7])],
                                ['Sep', parseFloat(@this.actual[8]), parseFloat(@this.actual[8])],
                                ['Oct', parseFloat(@this.actual[9]), parseFloat(@this.actual[9])],
                                ['Nov', parseFloat(@this.actual[10]), parseFloat(@this.actual[10])],
                                ['Dec', parseFloat(@this.actual[11]), parseFloat(@this.actual[11])]
                        ]);

                        var options = {
                                width:'95%',
                                chartArea:{width:'85%'},
                                is3D: true,
                                legend:{position:"none"},
                                
                                colors:['#87CEFA']
                            };
                         
                          var chart = new google.visualization.ColumnChart(document.getElementById('drrchart'));

                          chart.draw(data, options);
           

          }
}






</script>


</div>

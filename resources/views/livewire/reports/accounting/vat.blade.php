<div>
 
 <div class="d-flex flex-column-fluid ">
    
    <div class="container-fluid">
          <div class="listcard " >
         	<div class="" style=" background-color:#48BBBE;margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
		       <h2 class="pt-7 pl-3 pb-7" >VAT Report</h2>
               
            </div>
            
            <form  style="width:100%;">
                <div class='row'>
                  
             
                 <div class="col-md-12 mt-11 d-print-none form-group">
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
                        <div id="vatchart" style="width: 100%; height: 100%;"></div>
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
                                            <select wire:ignore wire:change="set_year($event.target.value)"  id="dropdown1"  class="btn btn-default" style=" font-size: 24px !important; background-color:transparent; border:none; color:#fff; ">
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
                                <td class="idcolor">VAT (<i class="fa fa-plus"  style="color:green;" aria-hidden="true"></i>)</td>
                                  @foreach($vatin1 as $vatin)
                                      <td>{{$vatin}}</td>
                                  @endforeach
                        </tr>

                       <tr class="text-center bg-white">
                                <td class="idcolor">VAT (<i class="fa  fa-minus" style="color:red;" aria-hidden="true"></i>)</td>
                                  @foreach($vatout1 as $vatout)
                                       <td>{{$vatout}}</td>
                                  @endforeach
                        </tr>
                        <tr class="text-center bg-white">
                                <td class="idcolor">Balance</td>
                                  @foreach($balances as $balance)
                                     <td>{{$balance}}</td>
                                  @endforeach
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

                        var option="<option style='background:#fff; color:#000; padding:10px !important; font-size:20px;' value='"+minyear+"' >"+minyear+"</option>";
                        
                        dropdown.innerHTML+=option;

                        }
                        let option1="<option selected disabled style='background:#dfdfdf; color:#000; padding:10px !important; font-size:20px;'>"+@this.year+"</option>";
                        $("#dropdown1").prepend(option1);
                        
                        

                } 
                populateChart();
                document.addEventListener("vatChanged", () => {
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
                    ['Month',  'VAT (+)', 'VAT (-)'],
                    ['Jan', {v:parseFloat(@this.vatin[0]), f:String(@this.vatin1[0]) }, {v:parseFloat(@this.vatout[0]), f:String(@this.vatout1[0]) } ],
                    ['Feb', {v:parseFloat(@this.vatin[1]), f:String(@this.vatin1[1]) }, {v:parseFloat(@this.vatout[1]), f:String(@this.vatout1[1]) }],
                    ['Mar', {v:parseFloat(@this.vatin[2]), f:String(@this.vatin1[2]) }, {v:parseFloat(@this.vatout[2]), f:String(@this.vatout1[2]) }],
                    ['Apr', {v:parseFloat(@this.vatin[3]), f:String(@this.vatin1[3]) }, {v:parseFloat(@this.vatout[3]), f:String(@this.vatout1[3]) }],
                    ['May', {v:parseFloat(@this.vatin[4]), f:String(@this.vatin1[4]) }, {v:parseFloat(@this.vatout[4]), f:String(@this.vatout1[4]) }],
                    ['Jun', {v:parseFloat(@this.vatin[5]), f:String(@this.vatin1[5]) }, {v:parseFloat(@this.vatout[5]), f:String(@this.vatout1[5]) }],
                    ['Jul', {v:parseFloat(@this.vatin[6]), f:String(@this.vatin1[6]) }, {v:parseFloat(@this.vatout[6]), f:String(@this.vatout1[6]) }],
                    ['Aug', {v:parseFloat(@this.vatin[7]), f:String(@this.vatin1[7]) }, {v:parseFloat(@this.vatout[7]), f:String(@this.vatout1[7]) }],
                    ['Sep', {v:parseFloat(@this.vatin[8]), f:String(@this.vatin1[8]) }, {v:parseFloat(@this.vatout[8]), f:String(@this.vatout1[8]) }],
                    ['Oct', {v:parseFloat(@this.vatin[9]), f:String(@this.vatin1[9]) }, {v:parseFloat(@this.vatout[9]), f:String(@this.vatout1[9]) }],
                    ['Nov', {v:parseFloat(@this.vatin[10]), f:String(@this.vatin1[10]) }, {v:parseFloat(@this.vatout[10]), f:String(@this.vatout1[10]) }],
                    ['Dec', {v:parseFloat(@this.vatin[11]), f:String(@this.vatin1[11]) }, {v:parseFloat(@this.vatout[11]), f:String(@this.vatout1[11]) }]
           ] );
            
          
           var options = {
            width:'95%',
              chartArea:{width:'85%'},
              legend:{position:"none"},
              colors:['#008080','#87CEFA'],
              vAxis:{viewWindow:{min:0}},
              curveType:'function', 
              pointSize:5
            };
           var chart = new google.visualization.LineChart(document.getElementById('vatchart'));
           chart.draw(data, options);
           

}
}






</script>


</div>

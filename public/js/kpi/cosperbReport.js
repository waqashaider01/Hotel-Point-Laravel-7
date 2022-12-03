$(document).ready(function(){
	
	$("#printdoc").click(function(){
            $("#printdoc").hide();
            $("#submit").hide();
            $("#dropdowndiv1").hide();
            window.print();
           });
           $(window).on('afterprint', function(){
            $("#printdoc").show();
            $("#submit").show();
            $("#dropdowndiv1").show();
            });
       
             var currentYear=(new Date()).getFullYear();
             $("#tabtitle1").html(currentYear);
             
             // drop down 1.................
              var dropdown1=$("#dropdown1");
             var dropdownt=$("#d1");
             dropdownt.html(currentYear);
             $("#dropdown1").on('click','.dropdown-item', function(e){
                var selectedValue=$(this).text();
                $("#tabtitle1").html(selectedValue);
                dropdownt.html(selectedValue);
                
                populate(selectedValue);
                 });
            
            fetch("getmindate.php").then(result=> result.json()).then(json => show1(json));
                 function show1(emp)
                    {
                        var dat=emp.reservation;
                        var fdate=emp.maxreservation;
                    
                   
                        let oldd=dat.split('-');
                        let minyear=oldd[0];
                        let final=fdate.split('-');
                        let maxyear=final[0];
                    for(minyear; minyear<=maxyear; minyear++ ){ 
                       var option=$("<a class='dropdown-item' />");
                       option.html(minyear);
                       option.val(minyear);
                       dropdown1.append(option);
                       
                    }
                    
                 }
                    var firstYear=$("#d1").text();
                   
                   
                    
                    populate(firstYear);
                    
        function populate(selectedYear){
                    
                    var data=[];
                    var year=selectedYear;
		                var ma='ma';
                    
                    var values={
                        "year":selectedYear
                    };
                    
                    data=values;
                    var json=JSON.stringify(data);
                    
                    $.ajax({
                        type:"POST",
                        url:"get_cospb.php",
                        data:json,
                        success:function(response){
                           
                				var month=0;

                        var actualArray=[];
                				for(var i=1; i<13; i++){
                			 
                			     month=month+1;
                			     ma='#ma';
                			     ma=ma+month;

                                 var formatter=Intl.NumberFormat('el-GR', {
                                    style:'currency',
                                    currency:'Eur',
                                    maximumFractionDigits:2
                                   });

                                    var monthdata=response[i].month;
                                    $(ma).html(formatter.format(monthdata));
                                    actualArray.push(monthdata);
                                    
		                           } 

                               showbarchart(actualArray); 
                        }
                    });

                } 
                    


    function showbarchart(actual){
                  
                 
                   google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawCharts);

                    function drawCharts() {
                      
                      var data = google.visualization.arrayToDataTable([
                        
                                ['Month',  'Actual', 'Actual'],
                                ['Jan', actual[0], actual[0]],
                                ['Feb', actual[1], actual[1]],
                                ['Mar', actual[2], actual[2]],
                                ['Apr', actual[3], actual[3]],
                                ['May', actual[4], actual[4]],
                                ['Jun', actual[5], actual[5]],
                                ['Jul', actual[6], actual[6]],
                                ['Aug', actual[7], actual[7]],
                                ['Sep', actual[8], actual[8]],
                                ['Oct', actual[9], actual[9]],
                                ['Nov', actual[10], actual[10]],
                                ['Dec', actual[11], actual[11]]
                        ]);

                      var formatter= new google.visualization.NumberFormat({decimalSymbol:',', groupingSymbol:'.', negativeColor:'red', suffix:' €'});
                            formatter.format(data, 1);
                            formatter.format(data, 2);

                     var options = {
                                width:'95%',
                                chartArea:{width:'95%'},
                                vAxis:{viewWindow:{min:0}},
                                hAxis: {title: '',  titleTextStyle: {color: '#333'}},
                                colors:['#87CEFA', '#008080'],
                                
                                legend:{position:"none"},
                                seriesType:'bars',
                                series:{1:{type:'line', curveType:'function', pointSize:5}}

                              };
                         
                          var chart = new google.visualization.ComboChart(document.getElementById('columnchart_material'));

                          chart.draw(data, options);
                          // chart.update();
                          

                        }
      }
      

      
})
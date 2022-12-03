<div>
    <div wire:ignore style="width:100%; height:100%; position:fixed; background:white; z-index:999;" id="magicdiv"></div>
    <div id="hotelbudget" class="d-flex flex-column-fluid mt-5 ">
            <!--begin::Container-->
            <div class="container-fluid">

                <div class="row" >
                    <div class="col">
                        <div class=" shadow-sm bg-white" style="padding:1%; border-radius:5px;">
                                <div class="row w-100" >
                                
                                    <div class="col-4">
                                        <div class="" >
                                                <h1 style="text-align:left;">Hotel Budget</h1>
                                        
                                        </div>
                                    </div>
                                   
                                    <div class="col-8">
                                        <div style="width:100%;">
                                                <span type="button" class="infbtn opexbtn" style=""  >Opex</span>
                                                <span type="button" class="infbtn revenuebtn" style=""  >Revenue</span>
                                                <select wire:ignore wire:change="setyears($event.target.value)" class="infbtn" style="background-color:white !important; max-width:70px;" id="dropdown">
                                                
                                                </select>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="mb-8" id="revenuerow">
                <div class="row mt-8 " id="">
                        <div class="col">
                                <div class="bg-white shadow-sm" style="padding:1%; border-radius:5px;">
                                        <div class="row">
                                            <div class="col">
                                                <h4 class="idcolor">Statistics</h4>
                                            </div>
                                            
                                        </div>
                                        
                                        <hr style="border: 1px solid #48BBBE;margin-left:0%;margin-right:0%;">
                                        <div class="table-responsive">
                                            <table class="table " style="border: 2px solid #48BBBE;">
                                                <thead>
                                                    
                                                </thead>
                                                <tbody>
                                                <tr class="text-center">
                                                        <th class="headingdata"></th>
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
                                                        <th>Year</th>
                                                    </tr>
                                                    @foreach($statistics as $statistic)
                                                        @if($statistic['rowid']=='110')
                                                    
                                                            <tr class="bg-white text-center">
                                                                <th class="headingdata">Operating Days</th>
                                                                
                                                                <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['january'], 'month'=>'january', 'min'=>'0', 'max'=>'31' ,'step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['february'], 'month'=>'february', 'min'=>'0', 'max'=>'29', 'step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['march'], 'month'=>'march', 'min'=>'0', 'max'=>'31', 'step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['april'], 'month'=>'april', 'min'=>'0', 'max'=>'30', 'step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['may'], 'month'=>'may', 'min'=>'0', 'max'=>'31', 'step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['june'], 'month'=>'june', 'min'=>'0', 'max'=>'30', 'step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['july'], 'month'=>'july', 'min'=>'0', 'max'=>'31', 'step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['august'], 'month'=>'august', 'min'=>'0', 'max'=>'31', 'step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['september'], 'month'=>'september', 'min'=>'0', 'max'=>'30', 'step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['october'], 'month'=>'october', 'min'=>'0', 'max'=>'31', 'step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['november'], 'month'=>'november', 'min'=>'0', 'max'=>'30', 'step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['december'], 'month'=>'december', 'min'=>'0', 'max'=>'31', 'step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                <td class="budget-total-data">{{$statistic['total']}}</td>
                                                                
                                                            </tr>
                                                           
                                                            @elseif($statistic['rowid']=='120')
                                                        
                                                                <tr class="bg-white text-center">
                                                                    <th class="headingdata">Available Rooms</th>
                                                                    
                                                                    
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['january'], 'month'=>'january', 'min'=>'0', 'max'=>'' ,'step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['february'], 'month'=>'february', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['march'], 'month'=>'march', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['april'], 'month'=>'april', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['may'], 'month'=>'may', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['june'], 'month'=>'june', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['july'], 'month'=>'july', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['august'], 'month'=>'august', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['september'], 'month'=>'september', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['october'], 'month'=>'october', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['november'], 'month'=>'november', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['december'], 'month'=>'december', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td class="budget-total-data">{{$statistic['total']}}</td>
                                                                    
                                                                </tr>
                                                                
                                                                @elseif($statistic['rowid']=='130')
                                                        
                                                                <tr class="bg-white text-center" >
                                                                    <th class="headingdata ">Occupied Room Nights</th>
                                                                    
                                                                    
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['january'], 'month'=>'january', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['february'], 'month'=>'february', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['march'], 'month'=>'march', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['april'], 'month'=>'april', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['may'], 'month'=>'may', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['june'], 'month'=>'june', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['july'], 'month'=>'july', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['august'], 'month'=>'august', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['september'], 'month'=>'september', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['october'], 'month'=>'october', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['november'], 'month'=>'november', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['december'], 'month'=>'december', 'min'=>'0', 'max'=>'','step'=>'1', 'convert'=>0), key(time().$loop->index))</td>
                                                                    <td class="budget-total-data">{{$statistic['total']}}</td>
                                                                    
                                                                </tr>

                                                            
                                                            @elseif($statistic['rowid']=='140')
                                                        
                                                                <tr class="bg-white text-center">
                                                                    <th class="headingdata">Average Daily Rate</th>
                                                                    
                                                                    
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['january'], 'month'=>'january', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['february'], 'month'=>'february', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['march'], 'month'=>'march', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['april'], 'month'=>'april', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['may'], 'month'=>'may', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['june'], 'month'=>'june', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['july'], 'month'=>'july', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['august'], 'month'=>'august', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['september'], 'month'=>'september', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['october'], 'month'=>'october', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['november'], 'month'=>'november', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['december'], 'month'=>'december', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                    <td class="budget-total-data">{{$this->formatFloatValues($statistic['total'])}}</td>
                                                                    
                                                                </tr>

                                                           

                                                            @elseif($statistic['rowid']=='150')
                                                        
                                                                <tr class="bg-white text-center">
                                                                    <th class="headingdata">Double Occupancy Factor</th>
                                                                    
                                                                    
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['january'], 'month'=>'january', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>'3'), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['february'], 'month'=>'february', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>'3'), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['march'], 'month'=>'march', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>'3'), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['april'], 'month'=>'april', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>'3'), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['may'], 'month'=>'may', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>'3'), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['june'], 'month'=>'june', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>'3'), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['july'], 'month'=>'july', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>'3'), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['august'], 'month'=>'august', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>'3'), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['september'], 'month'=>'september', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>'3'), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['october'], 'month'=>'october', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>'3'), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['november'], 'month'=>'november', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>'3'), key(time().$loop->index))</td>
                                                                    <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$statistic['type'], 'catg'=>$statistic['catg'], 'subcatg'=>$statistic['subcatg'],'value'=>$statistic['december'], 'month'=>'december', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>'3'), key(time().$loop->index))</td>
                                                                    <td class="budget-total-data">{{$this->formatFloatValues($statistic['total'])}}</td>
                                                                    
                                                                </tr>

                                                            @elseif($statistic['rowid']=='arn')
                                                        
                                                                <tr class="bg-white text-center">
                                                                    <th class="headingdata">Available Room Nights</th>
                                                                    
                                                                    
                                                                    <td>{{$statistic['january']}}</td>
                                                                    <td>{{$statistic['february']}}</td>
                                                                    <td>{{$statistic['march']}}</td>
                                                                    <td>{{$statistic['april']}}</td>
                                                                    <td>{{$statistic['may']}}</td>
                                                                    <td>{{$statistic['june']}}</td>
                                                                    <td>{{$statistic['july']}}</td>
                                                                    <td>{{$statistic['august']}}</td>
                                                                    <td>{{$statistic['september']}}</td>
                                                                    <td>{{$statistic['october']}}</td>
                                                                    <td>{{$statistic['november']}}</td>
                                                                    <td>{{$statistic['december']}}</td>
                                                                    <td class="budget-total-data">{{$statistic['total']}}</td>
                                                                    
                                                                </tr>

                                                            @elseif($statistic['rowid']=='revpar')
                                                        
                                                                <tr class="bg-white text-center">
                                                                    <th class="headingdata">RevPar</th>
                                                                    
                                                                    
                                                                    <td>{{$statistic['january']}}</td>
                                                                    <td>{{$statistic['february']}}</td>
                                                                    <td>{{$statistic['march']}}</td>
                                                                    <td>{{$statistic['april']}}</td>
                                                                    <td>{{$statistic['may']}}</td>
                                                                    <td>{{$statistic['june']}}</td>
                                                                    <td>{{$statistic['july']}}</td>
                                                                    <td>{{$statistic['august']}}</td>
                                                                    <td>{{$statistic['september']}}</td>
                                                                    <td>{{$statistic['october']}}</td>
                                                                    <td>{{$statistic['november']}}</td>
                                                                    <td>{{$statistic['december']}}</td>
                                                                    <td class="budget-total-data">{{$statistic['total']}}</td>
                                                                    
                                                                </tr>

                                                                @elseif($statistic['rowid']=='avgOcc')
                                                        
                                                                <tr class="bg-white text-center">
                                                                    <th class="headingdata">Average Occupancy %</th>
                                                                    
                                                                    
                                                                    <td>{{$statistic['january']}}%</td>
                                                                    <td>{{$statistic['february']}}%</td>
                                                                    <td>{{$statistic['march']}}%</td>
                                                                    <td>{{$statistic['april']}}%</td>
                                                                    <td>{{$statistic['may']}}%</td>
                                                                    <td>{{$statistic['june']}}%</td>
                                                                    <td>{{$statistic['july']}}%</td>
                                                                    <td>{{$statistic['august']}}%</td>
                                                                    <td>{{$statistic['september']}}%</td>
                                                                    <td>{{$statistic['october']}}%</td>
                                                                    <td>{{$statistic['november']}}%</td>
                                                                    <td>{{$statistic['december']}}%</td>
                                                                    <td class="budget-total-data">{{$statistic['total']}}%</td>
                                                                    
                                                                </tr>
                                                                @elseif($statistic['rowid']=='gih')
                                                        
                                                                <tr class="bg-white text-center">
                                                                    <th class="headingdata">Guests in House</th>
                                                                    
                                                                    
                                                                    <td>{{$statistic['january']}}</td>
                                                                    <td>{{$statistic['february']}}</td>
                                                                    <td>{{$statistic['march']}}</td>
                                                                    <td>{{$statistic['april']}}</td>
                                                                    <td>{{$statistic['may']}}</td>
                                                                    <td>{{$statistic['june']}}</td>
                                                                    <td>{{$statistic['july']}}</td>
                                                                    <td>{{$statistic['august']}}</td>
                                                                    <td>{{$statistic['september']}}</td>
                                                                    <td>{{$statistic['october']}}</td>
                                                                    <td>{{$statistic['november']}}</td>
                                                                    <td>{{$statistic['december']}}</td>
                                                                    <td class="budget-total-data">{{$statistic['total']}}</td>
                                                                    
                                                                </tr>
                                                        
                                                    
                                                        
                                                    
                                                            @endif

                                                        
                                                        @endforeach

                                                </tbody>
                                            </table>

                                        </div>


                            
                                </div>
                        </div>
                </div>
          <!-- </div> -->

          <!-- <div class="mb-8"> -->
                <div class="row mt-8">
                        <div class="col">
                        <div class="bg-white shadow-sm" style="padding:1%; border-radius:5px;">
                                        <div class="row">
                                            <div class="col">
                                                <h4 class="idcolor">Rooms Department Revenue</h4>
                                            </div>
                                            
                                        </div>
                                        
                                        <hr style="border: 1px solid #48BBBE;margin-left:0%;margin-right:0%;">
                                        <div class="table-responsive">
                                            <table class="table " style="border: 2px solid #48BBBE;">
                                                    <thead></thead>
                                                    <tbody>
                                                            <tr class="text-center">
                                                                <th class="headingdata" ></th>
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
                                                                <th>Year</th>
                                                            </tr>
                                                            @foreach($roomDeptData as $roomdept)
                                                               @if($roomdept['rowid']=="230")
                                                                    <tr class="bg-white text-center">
                                                                            <th class="headingdata">Accommodation Revenue</th>
                                                                            <td>{{$roomdept['january']}}</td>
                                                                            <td>{{$roomdept['february']}}</td>
                                                                            <td>{{$roomdept['march']}}</td>
                                                                            <td>{{$roomdept['april']}}</td>
                                                                            <td>{{$roomdept['may']}}</td>
                                                                            <td>{{$roomdept['june']}}</td>
                                                                            <td>{{$roomdept['july']}}</td>
                                                                            <td>{{$roomdept['august']}}</td>
                                                                            <td>{{$roomdept['september']}}</td>
                                                                            <td>{{$roomdept['october']}}</td>
                                                                            <td>{{$roomdept['november']}}</td>
                                                                            <td>{{$roomdept['december']}}</td>
                                                                            <td class="budget-total-data">{{$roomdept['total']}}</td>
                                                                    </tr>
                                                                    @elseif($roomdept['rowid']=="220")
                                                                    <tr class="bg-white text-center" >
                                                                            <th class="headingdata">Other Room Revenue<div class="triangle-down-blue mt-2" type="button" id="roomdeptbtn" style="float:right;" ></div></th>
                                                                            <td>{{$roomdept['january']}}</td>
                                                                            <td>{{$roomdept['february']}}</td>
                                                                            <td>{{$roomdept['march']}}</td>
                                                                            <td>{{$roomdept['april']}}</td>
                                                                            <td>{{$roomdept['may']}}</td>
                                                                            <td>{{$roomdept['june']}}</td>
                                                                            <td>{{$roomdept['july']}}</td>
                                                                            <td>{{$roomdept['august']}}</td>
                                                                            <td>{{$roomdept['september']}}</td>
                                                                            <td>{{$roomdept['october']}}</td>
                                                                            <td>{{$roomdept['november']}}</td>
                                                                            <td>{{$roomdept['december']}}</td>
                                                                            <td class="budget-total-data">{{$roomdept['total']}}</td>
                                                                    </tr>
                                                            
                                                               @elseif($roomdept['rowid']=='210')
                                                                    <tr class="bg-white text-center hiddenrow roomdept" >
                                                                        <td class="headingdata">CXL Fees %</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$roomdept['type'], 'catg'=>$roomdept['catg'], 'subcatg'=>$roomdept['subcatg'],'value'=>$roomdept['january'], 'month'=>'january', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>2), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$roomdept['type'], 'catg'=>$roomdept['catg'], 'subcatg'=>$roomdept['subcatg'],'value'=>$roomdept['february'], 'month'=>'february', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>2), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$roomdept['type'], 'catg'=>$roomdept['catg'], 'subcatg'=>$roomdept['subcatg'],'value'=>$roomdept['march'], 'month'=>'march', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>2), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$roomdept['type'], 'catg'=>$roomdept['catg'], 'subcatg'=>$roomdept['subcatg'],'value'=>$roomdept['april'], 'month'=>'april', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>2), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$roomdept['type'], 'catg'=>$roomdept['catg'], 'subcatg'=>$roomdept['subcatg'],'value'=>$roomdept['may'], 'month'=>'may', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>2), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$roomdept['type'], 'catg'=>$roomdept['catg'], 'subcatg'=>$roomdept['subcatg'],'value'=>$roomdept['june'], 'month'=>'june', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>2), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$roomdept['type'], 'catg'=>$roomdept['catg'], 'subcatg'=>$roomdept['subcatg'],'value'=>$roomdept['july'], 'month'=>'july', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>2), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$roomdept['type'], 'catg'=>$roomdept['catg'], 'subcatg'=>$roomdept['subcatg'],'value'=>$roomdept['august'], 'month'=>'august', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>2), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$roomdept['type'], 'catg'=>$roomdept['catg'], 'subcatg'=>$roomdept['subcatg'],'value'=>$roomdept['september'], 'month'=>'september', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>2), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$roomdept['type'], 'catg'=>$roomdept['catg'], 'subcatg'=>$roomdept['subcatg'],'value'=>$roomdept['october'], 'month'=>'october', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>2), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$roomdept['type'], 'catg'=>$roomdept['catg'], 'subcatg'=>$roomdept['subcatg'],'value'=>$roomdept['november'], 'month'=>'november', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>2), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$roomdept['type'], 'catg'=>$roomdept['catg'], 'subcatg'=>$roomdept['subcatg'],'value'=>$roomdept['december'], 'month'=>'december', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>2), key(time().$loop->index))</td>
                                                                        <td class="budget-total-data">{{$this->formatFloatValues($roomdept['total'])}}%</td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                            
                            </div>
                        </div>
                    </div>
            <!-- </div> -->

            <!-- <div class="mb-8"> -->
                <div class="row mt-8">
                        <div class="col">
                        <div class="bg-white shadow-sm" style="padding:1%; border-radius:5px;">
                                        <div class="row">
                                            <div class="col">
                                                <h4 class="idcolor">F&B Department Revenue</h4>
                                            </div>
                                            
                                        </div>
                                        
                                        <hr style="border: 1px solid #48BBBE;margin-left:0%;margin-right:0%;">
                                        <div class="table-responsive">
                                            <table class="table " style="border: 2px solid #48BBBE;">
                                                    <thead></thead>
                                                    <tbody>
                                                            <tr class="text-center">
                                                                <th class="headingdata" ></th>
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
                                                                <th>Year</th>
                                                            </tr>
                                                            @foreach($fbdept as $fb)
                                                              @if($fb['rowid']=='foodrevenue')
                                                                <tr class="bg-white text-center">
                                                                    <th class="headingdata">Food Revenue <div class="triangle-down-blue mt-2" type="button" id="fbdeptbtn" style="float:right;" ></div></td>
                                                                    <td>{{$this->formatFloatValues($fb['january'])}}</td>
                                                                    <td>{{$this->formatFloatValues($fb['february'])}}</td>
                                                                    <td>{{$this->formatFloatValues($fb['march'])}}</td>
                                                                    <td>{{$this->formatFloatValues($fb['april'])}}</td>
                                                                    <td>{{$this->formatFloatValues($fb['may'])}}</td>
                                                                    <td>{{$this->formatFloatValues($fb['june'])}}</td>
                                                                    <td>{{$this->formatFloatValues($fb['july'])}}</td>
                                                                    <td>{{$this->formatFloatValues($fb['august'])}}</td>
                                                                    <td>{{$this->formatFloatValues($fb['september'])}}</td>
                                                                    <td>{{$this->formatFloatValues($fb['october'])}}</td>
                                                                    <td>{{$this->formatFloatValues($fb['november'])}}</td>
                                                                    <td>{{$this->formatFloatValues($fb['december'])}}</td>
                                                                    <td class="budget-total-data">{{$this->formatFloatValues($fb['total'])}}</td>
                                                                </tr>

                                                                @elseif($fb['rowid']=='breakfastrevenue')
                                                            
                                                                    <tr class="bg-white text-center hiddenrow fbdept">
                                                                        <td class="headingdata">
                                                                            <div class="row">
                                                                                <div class="col-md-4">Breakfast</div>
                                                                                <div class="col-md-2"></div>
                                                                                <div class="col-md-6">
                                                                                    <div class="" style="max-width:50px !important; background:#dfdfdf; border-radius:2px;">
                                                                                        <input wire:change="setBreakfastPercentage($event.target.value)" class="littlestyle"  id="breakfast_percentage" type="number" value='{{$breakfastPercentage}}'>
                                                                                        
                                                                                            <span class="">%</span>
                                                                                        
                                                                                     </div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                                    <td>{{$fb['january']}}</td>
                                                                                    <td>{{$fb['february']}}</td>
                                                                                    <td>{{$fb['march']}}</td>
                                                                                    <td>{{$fb['april']}}</td>
                                                                                    <td>{{$fb['may']}}</td>
                                                                                    <td>{{$fb['june']}}</td>
                                                                                    <td>{{$fb['july']}}</td>
                                                                                    <td>{{$fb['august']}}</td>
                                                                                    <td>{{$fb['september']}}</td>
                                                                                    <td>{{$fb['october']}}</td>
                                                                                    <td>{{$fb['november']}}</td>
                                                                                    <td>{{$fb['december']}}</td>
                                                                                    <td class="budget-total-data">{{$this->formatFloatValues($fb['total'])}}</td>
                                                                    </tr>
                                                            
                                                              @elseif($fb['rowid']=='310')
                                                                    <tr class="bg-white text-center  hiddenrow fbdept">
                                                                        <td class="headingdata">Services</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['january'], 'month'=>'january', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['february'], 'month'=>'february', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['march'], 'month'=>'march', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['april'], 'month'=>'april', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['may'], 'month'=>'may', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['june'], 'month'=>'june', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['july'], 'month'=>'july', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['august'], 'month'=>'august', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['september'], 'month'=>'september', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['october'], 'month'=>'october', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['november'], 'month'=>'november', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['december'], 'month'=>'december', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td class="budget-total-data">{{$this->formatFloatValues($fb['total'])}}</td>
                                                                    </tr>
                                                              @elseif($fb['rowid']=='320')
                                                                    <tr class="bg-white text-center">
                                                                        <th class="headingdata">Beverage Revenue </th>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['january'], 'month'=>'january', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['february'], 'month'=>'february', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['march'], 'month'=>'march', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['april'], 'month'=>'april', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['may'], 'month'=>'may', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['june'], 'month'=>'june', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['july'], 'month'=>'july', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['august'], 'month'=>'august', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['september'], 'month'=>'september', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['october'], 'month'=>'october', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['november'], 'month'=>'november', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$fb['type'], 'catg'=>$fb['catg'], 'subcatg'=>$fb['subcatg'],'value'=>$fb['december'], 'month'=>'december', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td class="budget-total-data">{{$this->formatFloatValues($fb['total'])}}</td>
                                                                    </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                            
                            </div>
                        </div>
                    </div>
            <!-- </div> -->

            <!-- <div class="mb-8"> -->
                <div class="row mt-8">
                        <div class="col">
                        <div class="bg-white shadow-sm" style="padding:1%; border-radius:5px;">
                                        <div class="row">
                                            <div class="col">
                                                <h4 class="idcolor">Other Operated Department</h4>
                                            </div>
                                            
                                        </div>
                                        
                                        <hr style="border: 1px solid #48BBBE;margin-left:0%;margin-right:0%;">
                                        <div class="table-responsive">
                                            <table class="table " style="border: 2px solid #48BBBE;">
                                                    <thead></thead>
                                                    <tbody>
                                                            <tr class="text-center">
                                                                <th class="headingdata" ></th>
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
                                                                <th>Year</th>
                                                            </tr>
                                                            @foreach($oodData as $ood)
                                                              @if($ood['rowid']=='410')
                                                            
                                                                <tr class="bg-white text-center">
                                                                        <th class="headingdata">Spa & Therapies</th>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['january'], 'month'=>'january', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['february'], 'month'=>'february', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['march'], 'month'=>'march', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['april'], 'month'=>'april', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['may'], 'month'=>'may', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['june'], 'month'=>'june', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['july'], 'month'=>'july', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['august'], 'month'=>'august', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['september'], 'month'=>'september', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['october'], 'month'=>'october', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['november'], 'month'=>'november', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['december'], 'month'=>'december', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td class="budget-total-data">{{$this->formatFloatValues($ood['total'])}}</td>
                                                                </tr>
                                                              @elseif($ood['rowid']=='otherincome')
                                                                <tr class="bg-white text-center">
                                                                    <th class="headingdata">Other Income <div  class="triangle-down-blue mt-2" type="button" id="oibtn" style="float:right;" ></div></td>
                                                                    <td>{{$this->formatFloatValues($ood['january'])}}</td>
                                                                    <td>{{$this->formatFloatValues($ood['february'])}}</td>
                                                                    <td>{{$this->formatFloatValues($ood['march'])}}</td>
                                                                    <td>{{$this->formatFloatValues($ood['april'])}}</td>
                                                                    <td>{{$this->formatFloatValues($ood['may'])}}</td>
                                                                    <td>{{$this->formatFloatValues($ood['june'])}}</td>
                                                                    <td>{{$this->formatFloatValues($ood['july'])}}</td>
                                                                    <td>{{$this->formatFloatValues($ood['august'])}}</td>
                                                                    <td>{{$this->formatFloatValues($ood['september'])}}</td>
                                                                    <td>{{$this->formatFloatValues($ood['october'])}}</td>
                                                                    <td>{{$this->formatFloatValues($ood['november'])}}</td>
                                                                    <td>{{$this->formatFloatValues($ood['december'])}}</td>
                                                                    <td class="budget-total-data">{{$this->formatFloatValues($ood['total'])}}</td>
                                                                </tr>

                                                               
                                                            
                                                              @elseif($ood['rowid']=='420')
                                                                    <tr class="bg-white text-center  hiddenrow oidept">
                                                                        <td class="headingdata">Telephones and Fax</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['january'], 'month'=>'january', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['february'], 'month'=>'february', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['march'], 'month'=>'march', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['april'], 'month'=>'april', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['may'], 'month'=>'may', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['june'], 'month'=>'june', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['july'], 'month'=>'july', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['august'], 'month'=>'august', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['september'], 'month'=>'september', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['october'], 'month'=>'october', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['november'], 'month'=>'november', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['december'], 'month'=>'december', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td class="budget-total-data">{{$this->formatFloatValues($ood['total'])}}</td>
                                                                    </tr>
                                                                @elseif($ood['rowid']=='430')
                                                                    <tr class="bg-white text-center  hiddenrow oidept">
                                                                        <td class="headingdata">Guests Laundry and Dry Cleaning</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['january'], 'month'=>'january', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['february'], 'month'=>'february', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['march'], 'month'=>'march', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['april'], 'month'=>'april', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['may'], 'month'=>'may', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['june'], 'month'=>'june', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['july'], 'month'=>'july', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['august'], 'month'=>'august', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['september'], 'month'=>'september', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['october'], 'month'=>'october', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['november'], 'month'=>'november', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['december'], 'month'=>'december', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td class="budget-total-data">{{$this->formatFloatValues($ood['total'])}}</td>
                                                                    </tr>
                                                                @elseif($ood['rowid']=='440')
                                                                    <tr class="bg-white text-center  hiddenrow oidept">
                                                                        <td class="headingdata">Guests Transfers</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['january'], 'month'=>'january', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['february'], 'month'=>'february', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['march'], 'month'=>'march', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['april'], 'month'=>'april', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['may'], 'month'=>'may', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['june'], 'month'=>'june', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['july'], 'month'=>'july', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['august'], 'month'=>'august', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['september'], 'month'=>'september', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['october'], 'month'=>'october', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['november'], 'month'=>'november', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['december'], 'month'=>'december', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td class="budget-total-data">{{$this->formatFloatValues($ood['total'])}}</td>
                                                                    </tr>
                                                                @elseif($ood['rowid']=='450')
                                                                    <tr class="bg-white text-center  hiddenrow oidept">
                                                                        <td class="headingdata">Excursions</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['january'], 'month'=>'january', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['february'], 'month'=>'february', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['march'], 'month'=>'march', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['april'], 'month'=>'april', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['may'], 'month'=>'may', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['june'], 'month'=>'june', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['july'], 'month'=>'july', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['august'], 'month'=>'august', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['september'], 'month'=>'september', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['october'], 'month'=>'october', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['november'], 'month'=>'november', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['december'], 'month'=>'december', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td class="budget-total-data">{{$this->formatFloatValues($ood['total'])}}</td>
                                                                    </tr>
                                                                @elseif($ood['rowid']=='460')
                                                                    <tr class="bg-white text-center  hiddenrow oidept">
                                                                        <td class="headingdata">Cigars</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['january'], 'month'=>'january', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['february'], 'month'=>'february', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['march'], 'month'=>'march', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['april'], 'month'=>'april', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['may'], 'month'=>'may', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['june'], 'month'=>'june', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['july'], 'month'=>'july', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['august'], 'month'=>'august', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['september'], 'month'=>'september', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['october'], 'month'=>'october', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['november'], 'month'=>'november', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['december'], 'month'=>'december', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td class="budget-total-data">{{$this->formatFloatValues($ood['total'])}}</td>
                                                                    </tr>
                                                                    @elseif($ood['rowid']=='470')
                                                                    <tr class="bg-white text-center  hiddenrow oidept">
                                                                        <td class="headingdata">Newspapers/Megazines</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['january'], 'month'=>'january', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['february'], 'month'=>'february', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['march'], 'month'=>'march', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['april'], 'month'=>'april', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['may'], 'month'=>'may', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['june'], 'month'=>'june', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['july'], 'month'=>'july', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['august'], 'month'=>'august', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['september'], 'month'=>'september', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['october'], 'month'=>'october', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['november'], 'month'=>'november', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['december'], 'month'=>'december', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td class="budget-total-data">{{$this->formatFloatValues($ood['total'])}}</td>
                                                                    </tr>
                                                                    @elseif($ood['rowid']=='480')
                                                                    <tr class="bg-white text-center  hiddenrow oidept">
                                                                        <td class="headingdata">Guests Sundries/ Sounenirs</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['january'], 'month'=>'january', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['february'], 'month'=>'february', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['march'], 'month'=>'march', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['april'], 'month'=>'april', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['may'], 'month'=>'may', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['june'], 'month'=>'june', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['july'], 'month'=>'july', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['august'], 'month'=>'august', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['september'], 'month'=>'september', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['october'], 'month'=>'october', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['november'], 'month'=>'november', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['december'], 'month'=>'december', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td class="budget-total-data">{{$this->formatFloatValues($ood['total'])}}</td>
                                                                    </tr>
                                                                @elseif($ood['rowid']=='490')
                                                                    <tr class="bg-white text-center  hiddenrow oidept">
                                                                        <td class="headingdata">Rentals & Other Revenue</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['january'], 'month'=>'january', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['february'], 'month'=>'february', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['march'], 'month'=>'march', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['april'], 'month'=>'april', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['may'], 'month'=>'may', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['june'], 'month'=>'june', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['july'], 'month'=>'july', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['august'], 'month'=>'august', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['september'], 'month'=>'september', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['october'], 'month'=>'october', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['november'], 'month'=>'november', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['december'], 'month'=>'december', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td class="budget-total-data">{{$this->formatFloatValues($ood['total'])}}</td>
                                                                    </tr>
                                                                 @elseif($ood['rowid']=='4100')
                                                                    <tr class="bg-white text-center">
                                                                        <th class="headingdata">Miscellaneous</th>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['january'], 'month'=>'january', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['february'], 'month'=>'february', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['march'], 'month'=>'march', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['april'], 'month'=>'april', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['may'], 'month'=>'may', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['june'], 'month'=>'june', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['july'], 'month'=>'july', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['august'], 'month'=>'august', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['september'], 'month'=>'september', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['october'], 'month'=>'october', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['november'], 'month'=>'november', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$ood['type'], 'catg'=>$ood['catg'], 'subcatg'=>$ood['subcatg'],'value'=>$ood['december'], 'month'=>'december', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td class="budget-total-data">{{$this->formatFloatValues($ood['total'])}}</td>
                                                                    </tr>
                                                             
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                            
                            </div>
                        </div>
                    </div>
            </div>

            <div class="mb-8" id="opexrow">
                <div class="row mt-8">
                        <div class="col">
                        <div class="bg-white shadow-sm" style="padding:1%; border-radius:5px;">
                                        <div class="row">
                                            <div class="col">
                                                <h4 class="idcolor">Operating Expenses</h4>
                                            </div>
                                            
                                        </div>
                                        
                                        <hr style="border: 1px solid #48BBBE;margin-left:0%;margin-right:0%;">
                                        <div class="table-responsive">
                                            <table class="table " style="border: 2px solid #48BBBE;">
                                                    <thead></thead>
                                                    <tbody>
                                                            <tr class="text-center">
                                                                <th class="headingdata" ></th>
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
                                                                <th>Year</th>
                                                            </tr>
                                                            @foreach($opexData as $opex)
                                                              @if($opex['class']=='mainType' )
                                                            
                                                                <tr class="bg-white text-center">
                                                                    <th class="headingdata">{{$opex['name']}}<div class="triangle-down-blue mt-2" type="button" id="{{$opex['id']}}" style="float:right;" ></div></th>
                                                                    <td>{{$this->formatFloatValues($opex['january'])}}</td>
                                                                    <td>{{$this->formatFloatValues($opex['february'])}}</td>
                                                                    <td>{{$this->formatFloatValues($opex['march'])}}</td>
                                                                    <td>{{$this->formatFloatValues($opex['april'])}}</td>
                                                                    <td>{{$this->formatFloatValues($opex['may'])}}</td>
                                                                    <td>{{$this->formatFloatValues($opex['june'])}}</td>
                                                                    <td>{{$this->formatFloatValues($opex['july'])}}</td>
                                                                    <td>{{$this->formatFloatValues($opex['august'])}}</td>
                                                                    <td>{{$this->formatFloatValues($opex['september'])}}</td>
                                                                    <td>{{$this->formatFloatValues($opex['october'])}}</td>
                                                                    <td>{{$this->formatFloatValues($opex['november'])}}</td>
                                                                    <td>{{$this->formatFloatValues($opex['december'])}}</td>
                                                                    <td class="budget-total-data">{{$this->formatFloatValues($opex['total'])}}</td>
                                                                </tr>
                                                              
                                                                 @else
                                                                    <tr class="bg-white text-center hiddenrow {{$opex['class']}}">
                                                                        <td class="headingdata">{{$opex['name']}}</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$opex['type'], 'catg'=>$opex['catg'], 'subcatg'=>$opex['subcatg'],'value'=>$opex['january'], 'month'=>'january', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$opex['type'], 'catg'=>$opex['catg'], 'subcatg'=>$opex['subcatg'],'value'=>$opex['february'], 'month'=>'february', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$opex['type'], 'catg'=>$opex['catg'], 'subcatg'=>$opex['subcatg'],'value'=>$opex['march'], 'month'=>'march', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$opex['type'], 'catg'=>$opex['catg'], 'subcatg'=>$opex['subcatg'],'value'=>$opex['april'], 'month'=>'april', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$opex['type'], 'catg'=>$opex['catg'], 'subcatg'=>$opex['subcatg'],'value'=>$opex['may'], 'month'=>'may', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$opex['type'], 'catg'=>$opex['catg'], 'subcatg'=>$opex['subcatg'],'value'=>$opex['june'], 'month'=>'june', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$opex['type'], 'catg'=>$opex['catg'], 'subcatg'=>$opex['subcatg'],'value'=>$opex['july'], 'month'=>'july', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$opex['type'], 'catg'=>$opex['catg'], 'subcatg'=>$opex['subcatg'],'value'=>$opex['august'], 'month'=>'august', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$opex['type'], 'catg'=>$opex['catg'], 'subcatg'=>$opex['subcatg'],'value'=>$opex['september'], 'month'=>'september', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$opex['type'], 'catg'=>$opex['catg'], 'subcatg'=>$opex['subcatg'],'value'=>$opex['october'], 'month'=>'october', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$opex['type'], 'catg'=>$opex['catg'], 'subcatg'=>$opex['subcatg'],'value'=>$opex['november'], 'month'=>'november', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td>@livewire('finance.budget.hotel', array('year'=>$year,  'type'=>$opex['type'], 'catg'=>$opex['catg'], 'subcatg'=>$opex['subcatg'],'value'=>$opex['december'], 'month'=>'december', 'min'=>'0', 'max'=>'','step'=>'any', 'convert'=>1), key(time().$loop->index))</td>
                                                                        <td class="budget-total-data">{{$this->formatFloatValues($opex['total'])}}</td>
                                                                    </tr>
                                                             
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                            
                            </div>
                        </div>
                    </div>
            </div>





          </div>
    </div>

    <script>

       

        $(document).ready(function(){
            document.addEventListener("contentChanged", () => {
                
                    $('#opexrow').css('display', 'none');
                    $(".hiddenrow").hide();
                    // $(".hotel-items").show();
            
                
            });

            $('#opexrow').css('display', 'none');
            $('.revenuebtn').click(function(){
                $('#revenuerow').css('display', 'block');
                $('#opexrow').css('display', 'none');
            });

            $('.opexbtn').click(function(){
		 
                $('#opexrow').css('display', 'block');
                $('#revenuerow').css('display', 'none');
            });
            $(".hiddenrow").hide();
            fetch("{{route('getMinDate')}}").then(result=> result.json()).then(json => show1(json));
            function show1(emp)
                {
                    var minyear=emp.minyear-3;
                    var currentyear=(new Date()).getFullYear();
                    var futureyear=currentyear+5;
                    for (var i = minyear; i<= futureyear; i++) {
                    var option='<option value="'+i+'" >'+i+'</option>';
                    $("#dropdown").append(option);
                    
                    }
                    $("#dropdown").val(currentyear);
                    // $(".hotel-items").show();
                    document.getElementById("magicdiv").style.display="none";
                

                }
           

            $('#roomdeptbtn').on('click', function(){
                $(".roomdept").toggle();
            })

            $('#fbdeptbtn').on('click', function(){
                $(".fbdept").toggle();
            })

            $('#oibtn').on('click', function(){
                $(".oidept").toggle();
            })

            $('#opex1').on('click', function(){
                $(".opex1").toggle();
            })
            $('#opex2').on('click', function(){
                $(".opex2").toggle();
            })
            $('#opex3').on('click', function(){
                $(".opex3").toggle();
            })
            $('#opex4').on('click', function(){
                $(".opex4").toggle();
            })
            $('#opex5').on('click', function(){
                $(".opex5").toggle();
            })
            $('#opex6').on('click', function(){
                $(".opex6").toggle();
            })
            $('#opex7').on('click', function(){
                $(".opex7").toggle();
            })
            $('#opex8').on('click', function(){
                $(".opex8").toggle();
            })
            $('#opex9').on('click', function(){
                $(".opex9").toggle();
            })

           

        })

        

        </script>
    
</div>

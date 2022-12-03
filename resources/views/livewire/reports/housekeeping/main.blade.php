<div>
    <div class=" mt-5 ">
        <div class="">
            <div class=" tab-container">
                <ul class="nav nav-pills justify-content-center flex-column flex-sm-row d-print-none mt-5 w-100"
                    id="myTab" role="tablist">
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='daily')?'active':''}}" 
                           wire:click="$set('tab', 'daily')" href="#">Daily Reporting</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='monthly')?'active':''}}"
                           wire:click="$set('tab', 'monthly')" href="#">Monthly Reporting</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='yearly')?'active':''}}" 
                           wire:click="$set('tab', 'yearly')" href="#">Period Reporting</a>
                    </li>
                    
                    
                </ul>
            </div>
            <div class="tab-content mt-5" >
                @if($tab == "daily")
                   
                   @livewire('reports.housekeeping.daily', key(time()))
                @elseif($tab == "monthly")
                    @livewire('reports.housekeeping.monthly', key(time()))
                @elseif($tab == "yearly")
                    @livewire('reports.housekeeping.yearly', key(time()))
                
                @endif
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</div>

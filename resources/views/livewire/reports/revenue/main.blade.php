<div>
    <div class=" mt-5 ">
        <div class="">
            <div class=" tab-container">
                <ul class="nav nav-pills justify-content-center flex-column flex-sm-row d-print-none mt-5 w-100"
                    id="myTab" role="tablist">
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='channel')?'active':''}}" 
                           wire:click="$set('tab', 'channel')" href="#">Channel Revenue</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='accommodation')?'active':''}}"
                           wire:click="$set('tab', 'accommodation')" href="#">Accommodation</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='breakfast')?'active':''}}" 
                           wire:click="$set('tab', 'breakfast')" href="#">Breakfast Revenue</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='services')?'active':''}}" 
                           wire:click="$set('tab', 'services')" href="#">Services Revenue</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='cancellation')?'active':''}}" 
                           wire:click="$set('tab', 'cancellation')" href="#">Cancellation</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='other')?'active':''}}" 
                           wire:click="$set('tab', 'other')" href="#">Other Room Revenue</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='market')?'active':''}}" 
                           wire:click="$set('tab', 'market')" href="#">Market Report</a>
                    </li>
                    
                </ul>
            </div>
            <div class="tab-content mt-5" >
                @if($tab == "channel")
                   @livewire('reports.revenue.channel', key(time()))
                @elseif($tab == "accommodation")
                    @livewire('reports.revenue.accommodation', key(time()))
                @elseif($tab == "breakfast")
                    @livewire('reports.revenue.breakfast', key(time()))
                 @elseif($tab == "services")
                    @livewire('reports.revenue.service', key(time()))
                @elseif($tab == "cancellation")
                    @livewire('reports.revenue.cancel', key(time()))
                @elseif($tab == "other")
                    @livewire('reports.revenue.orr', key(time()))
                @elseif($tab == "market")
                    @livewire('reports.revenue.market', key(time())) 
                
                @endif
            </div>
        </div>
    </div>
</div>

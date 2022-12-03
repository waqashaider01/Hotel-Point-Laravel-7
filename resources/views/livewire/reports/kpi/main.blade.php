<div>
    <div class=" mt-5 ">
        <div class="">
            <div class=" tab-container">
                <ul class="nav nav-pills justify-content-center flex-column flex-sm-row d-print-none mt-5 w-100"
                    id="myTab" role="tablist">
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='adr')?'active':''}}" 
                           wire:click="$set('tab', 'adr')" href="#">ADR</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='revpar')?'active':''}}"
                           wire:click="$set('tab', 'revpar')" href="#">RevPar</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='occupancy')?'active':''}}" 
                           wire:click="$set('tab', 'occupancy')" href="#">Occupancy</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='los')?'active':''}}" 
                           wire:click="$set('tab', 'los')" href="#">LOS</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='cpor')?'active':''}}" 
                           wire:click="$set('tab', 'cpor')" href="#">CPOR</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='cosperb')?'active':''}}" 
                           wire:click="$set('tab', 'cosperb')" href="#">CosPerB</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='drr')?'active':''}}" 
                           wire:click="$set('tab', 'drr')" href="#">DRR</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='revpor')?'active':''}}" 
                           wire:click="$set('tab', 'revpor')" href="#">RevPOR</a>
                    </li>
                    
                </ul>
            </div>
            <div class="tab-content mt-5" >
                @if($tab == "adr")
                   @livewire('reports.kpi.adr', key(time()))
                @elseif($tab == "revpar")
                    @livewire('reports.kpi.revpar', key(time()))
                @elseif($tab == "occupancy")
                    @livewire('reports.kpi.occupancy', key(time()))
                 @elseif($tab == "los")
                    @livewire('reports.kpi.los', key(time()))
                @elseif($tab == "cpor")
                    @livewire('reports.kpi.cpor', key(time()))
                @elseif($tab == "cosperb")
                    @livewire('reports.kpi.cosperb', key(time()))
                @elseif($tab == "drr")
                    @livewire('reports.kpi.drr', key(time())) 
                @elseif($tab == "revpor")
                    @livewire('reports.kpi.revpor', key(time())) 
                
                @endif
            </div>
        </div>
    </div>
</div>

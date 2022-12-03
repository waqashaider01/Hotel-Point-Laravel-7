@props(['title', 'id' => 'dataTableExample', 'header' => null, 'tableClasses' => 'table', 'hideBody' => false, 'containerClasses' => 'container-fluid', 'cardsHeader2' => null])
<div class="d-flex flex-column-fluid mt-10">
    <div class="{{ $containerClasses }}">
        <div class="listcard">
            @if ($header != null)
                <div class="header-div">
                    <h2 class="pt-7 pl-3 pb-7">{{ $title }}</h2>
                </div>
            @endif
            <div class="">
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            @if ($header != null)
                                <div class="card-header">
                                    {{ $header }}
                                </div>
                            @endif
                            @if ($cardsHeader2 != null)
                                <div class="card-header">
                                    {{ $cardsHeader2 }}
                                </div>
                            @endif
                            @if (!$hideBody)
                                <div class="card-body">
                                    <div class="table-responsive" wire:ignore>
                                        <table id="{{ $id }}" class="{{ $tableClasses }}">
                                            <thead>
                                                <tr>
                                                    {{ $heading }}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{ $slot }}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

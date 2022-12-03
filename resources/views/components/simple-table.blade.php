@props(['id' => null, 'tableClasses' => 'table', 'title' => null])
@php
$id = $id ? $id : 'datatable-' . str_replace(' ', '-', $title);
$searchInputId = $id . '-search';
@endphp
<div class="col">
    <div class="cashier-info-card bg-white shadow-sm" style="padding:1%;">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="idcolor m-0"> {{ $title }} </h4>
            <input type="text" id="{{ $searchInputId }}" style="width: 200px" class="form-control1 d-print-none py-2" placeholder="Search">
        </div>
        <hr>
        <div>
            <table id="{{ $id }}" class="{{ $tableClasses }}">
                <thead>
                    <tr>
                        {{ $thead }}
                    </tr>
                </thead>
                <tbody>
                    {{ $slot }}
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    //jquery ready{}

    if (simpleTableJqueryIds != undefined) {
        simpleTableJqueryIds.push({
            id: `{{ $id }}`,
            searchInputId: `{{ $searchInputId }}`
        })
    } else {
        const simpleTableJqueryIds = [];
        simpleTableJqueryIds.push({
            id: `{{ $id }}`,
            searchInputId: `{{ $searchInputId }}`
        })
    }
</script>

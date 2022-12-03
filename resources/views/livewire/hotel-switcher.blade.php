@if(auth()->user()->hasRole('Super Admin') || auth()->user()->connected_hotels()->count() > 1)
<div>
    <select wire:model="selected_hotel" class="form-control" style="min-width: 150px; max-width: 300px !important;">
        <option value="">Select a Hotel</option>
        @foreach ($selectable_hotels as $hotel)
            <option value="{{ $hotel->id }}">{{ $hotel->name }} - {{ $hotel->owner->name }}</option>
        @endforeach
    </select>
</div>
@endif

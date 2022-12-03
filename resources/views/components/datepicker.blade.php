@props(['disabled'])
@php
    $options = [
    'mode'=> 'range',
    'minDate'=> date('Y-m-d'),
    'dateFormat' => 'Y-m-d',
    'enableTime' => false,
    'disable' => json_decode($disabled),
    ];
@endphp
<div>
    <input
        x-data="{
             value: @entangle($attributes->wire('model')),
             instance: undefined,
             init() {
                 $watch('value', value => this.instance.setDate(value, false));
                 this.instance = flatpickr(this.$refs.input, {{ json_encode((object)$options) }});
             }
        }"
        x-ref="input"
        x-bind:value="value"
        type="text"
        {{ $attributes->merge(['class' => 'form-input w-full rounded-md shadow-sm']) }}
    />
    @error('adv_dates')<span
        class="error-message">{{$message}}</span>@enderror
</div>

<div  style="max-width:130px;">
    <div
        class="flex items-center justify-between w-full"
        x-data="
            {
                 isEditing: false,
                 focus: function() {
                    const textInput = this.$refs.textInput;
                    textInput.focus();
                    textInput.select();
                 }
            }
        "
        x-cloak
    >
        <div
            x-show=!isEditing
        >
            <div class="inputEdit"
                x-on:dblclick="isEditing = true; $nextTick(() => focus())"
            >{{ $copyvalue }}</div>
        </div>
        <div x-show=isEditing class="">
                <input
                    type="number"
                    class="text-sm w-50 border border-light rounded"
                    placeholder=""
                    step="{{$step}}"
                    min="{{$min}}" max="{{$max}}"
                    oninput="validity.valid||(value='');"
                    x-ref="textInput"
                    wire:model.lazy="newValue"
                    x-on:keydown.enter="isEditing = false"
                    x-on:keydown.escape="isEditing = false"
                >
                <button wire:click="cancel()" type="button" class=" btn btn-danger" style="padding:3px 5px !important;" title="Cancel" x-on:click="isEditing = false">X</button>
                <button
                    type="submit"
                    class="confirmBtn btn btn-success" style="padding:3px 5px !important;"
                    title="Save"
                    x-on:click="isEditing = false; "
                    wire:click="save"
                >✓</button>
            
        </div>
    </div>

</div>
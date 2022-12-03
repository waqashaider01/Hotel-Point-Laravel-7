@props([
'field'
])
@error($field)
<span class="invalid-input-data"
      role="alert"><strong>{{ $message }}</strong></span>
@enderror

@props([
'field'
])
@error($field)
<div style="max-width: 100%; margin-top: .25rem; font-size: .875em; color: #dc3545;"
      role="alert"><strong>{{ $message }}</strong></div>
@enderror

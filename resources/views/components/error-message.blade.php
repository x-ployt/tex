@props(['field'])

{{-- Error Message --}}
@error($field)
    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
@enderror

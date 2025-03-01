@props(['field'])

@error($field)
    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
@enderror

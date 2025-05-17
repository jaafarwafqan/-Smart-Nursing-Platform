@props(['types'])

@php
    $types = is_array($types) ? $types : explode(',', $types);
@endphp

@if(auth()->check() && in_array(auth()->user()->type, $types))
    {{ $slot }}
@endif 
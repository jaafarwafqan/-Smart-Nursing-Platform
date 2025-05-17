@props(['permission'])

@can($permission)
    {{ $slot }}
@endcan 
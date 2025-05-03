@props(['color' => 'primary'])
<span {{ $attributes->merge(['class'=>"badge bg-$color"]) }}>
    {{ $slot }}
</span>

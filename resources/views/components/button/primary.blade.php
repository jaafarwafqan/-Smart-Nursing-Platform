<button {{ $attributes->merge(['class'=>'btn btn-primary rounded-pill px-4']) }}>
    {{ $slot }}
</button>

{{-- @props(['class' => '']) --}}
{{-- <button {{ $attributes->merge(['class'=>'btn btn-primary rounded-pill px-4']) }}>
    {{ $slot }}
</button> --}}


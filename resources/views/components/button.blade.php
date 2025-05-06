@props([
    'type' => 'button',
    'href' => null,
    'action' => null,
    'method' => 'POST',
    'icon' => null,
    'text' => '',
    'color' => 'primary', // primary, warning, danger, success, info, download
    'confirm' => null,
    'extraClass' => '',
])

@php
    $btnClass = 'btn btn-sm btn-' . ($color === 'download' ? 'info' : ($color === 'black' ? 'dark' : $color)) . ' ' . $extraClass;
@endphp

@if($href)
    <a href="{{ $href }}" class="{{ $btnClass }}" @if($confirm) onclick="return confirm('{{ $confirm }}')" @endif>
        @if($icon) <i class="fas fa-{{ $icon }} me-1"></i> @endif
        {{ $text }}
    </a>
@elseif($action)
    <form action="{{ $action }}" method="{{ $method }}" style="display:inline-block">
        @csrf
        @if($method !== 'GET' && $method !== 'POST') @method($method) @endif
        <button type="submit" class="{{ $btnClass }}" @if($confirm) onclick="return confirm('{{ $confirm }}')" @endif>
            @if($icon) <i class="fas fa-{{ $icon }} me-1"></i> @endif
            {{ $text }}
        </button>
    </form>
@else
    <button type="{{ $type }}" class="{{ $btnClass }}" @if($confirm) onclick="return confirm('{{ $confirm }}')" @endif>
        @if($icon) <i class="fas fa-{{ $icon }} me-1"></i> @endif
        {{ $text }}
    </button>
@endif 
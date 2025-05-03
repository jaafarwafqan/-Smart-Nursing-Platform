@props([
    'color' => 'primary',   // bootstrap color: primary | success | info | warning …
    'icon'  => 'chart-bar', // FontAwesome icon without fas/fa
    'value' => 0,
    'title' => '',
])

<div {{ $attributes->merge(['class' => "stat-card bg-{$color} text-white rounded shadow-sm"]) }}>
    <div class="stat-card-body d-flex align-items-center p-3">
        <div class="stat-card-icon flex-shrink-0 me-3 fs-2">
            <i class="fas fa-{{ $icon }}"></i>
        </div>
        <div class="stat-card-info">
            <div class="stat-card-value fs-4 fw-bold">{{ $value }}</div>
            <div class="stat-card-title small">{{ $title }}</div>
        </div>
    </div>
</div>



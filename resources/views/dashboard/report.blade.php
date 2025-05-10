<!-- report.blade.php -->
@extends('layouts.app')
@section('title', 'التقارير الجدولية')

@php use Illuminate\Support\Str; @endphp

@section('content')
<div class="container-fluid py-4">
    <!-- رأس الصفحة -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">التقارير الجدولية</h1>
            <p class="text-muted">عرض تفصيلي للفعاليات والحملات</p>
        </div>
        <div class="d-flex gap-2">
            <form method="GET" action="{{ route('dashboard.report') }}" class="d-flex gap-2">
                <select name="year" class="form-select" style="width: 150px" onchange="this.form.submit()">
                    @for ($y = now()->year; $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>
                            السنة: {{ $y }}
                        </option>
                    @endfor
                </select>
            </form>
            <a href="{{ route('dashboard.report', ['export' => 'excel', 'year' => request('year', date('Y'))]) }}"
               class="btn btn-success">
                <i class="fas fa-file-excel me-1"></i>
                تصدير Excel
            </a>
        </div>
    </div>

    <!-- فلاتر البحث -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('dashboard.report') }}" class="row g-3">
                <input type="hidden" name="year" value="{{ request('year', date('Y')) }}">
                <div class="col-md-3">
                    <label class="form-label">نوع الفعالية</label>
                    <select name="type" class="form-select">
                        <option value="">الكل</option>
                        @foreach($eventTypes as $type)
                            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">الفرع</label>
                    <select name="branch" class="form-select">
                        <option value="">الكل</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">الفترة الزمنية</label>
                    <select name="period" class="form-select">
                        <option value="">الكل</option>
                        <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>اليوم</option>
                        <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>هذا الأسبوع</option>
                        <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>هذا الشهر</option>
                        <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>هذه السنة</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-1"></i>
                        تصفية النتائج
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ملخص النتائج -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 bg-primary bg-gradient text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">إجمالي النتائج</h6>
                            <h3 class="mb-0">{{ $events->total() }}</h3>
                        </div>
                        <div class="rounded-circle bg-white bg-opacity-25 p-3">
                            <i class="fas fa-calendar-check fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-success bg-gradient text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">متوسط الحضور</h6>
                            <h3 class="mb-0">{{ number_format($events->avg('attendance'), 1) }}%</h3>
                        </div>
                        <div class="rounded-circle bg-white bg-opacity-25 p-3">
                            <i class="fas fa-users fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-info bg-gradient text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">عدد الفروع</h6>
                            <h3 class="mb-0">{{ $events->pluck('branch.name')->unique()->count() }}</h3>
                        </div>
                        <div class="rounded-circle bg-white bg-opacity-25 p-3">
                            <i class="fas fa-building fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-warning bg-gradient text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">أنواع الفعاليات</h6>
                            <h3 class="mb-0">{{ $events->pluck('type')->unique()->count() }}</h3>
                        </div>
                        <div class="rounded-circle bg-white bg-opacity-25 p-3">
                            <i class="fas fa-tags fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات الفروع بثلاث طرق -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0">عدد الفعاليات حسب الفروع</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>الفرع</th>
                                    <th>عدد الفعاليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($events->groupBy(fn($event) => $event->branch->name ?? 'غير محدد') as $branch => $branchEvents)
                                    <tr>
                                        <td>{{ $branch }}</td>
                                        <td>{{ $branchEvents->count() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0">توزيع الفعاليات حسب الفروع (رسم بياني)</h5>
                </div>
                <div class="card-body">
                    <canvas id="branchesPieChart"></canvas>
                </div>
            </div>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0">أكثر الفروع نشاطاً</h5>
                </div>
                <div class="card-body">
                    <ol>
                        @foreach($events->groupBy(fn($event) => $event->branch->name ?? 'غير محدد')->sortByDesc->count()->take(3) as $branch => $branchEvents)
                            <li>
                                <b>{{ $branch }}</b> ({{ $branchEvents->count() }} فعالية)
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- جدول النتائج -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent py-3">
            <h5 class="card-title mb-0">قائمة الفعاليات</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>اسم الفعالية</th>
                            <th>الفرع</th>
                            <th>النوع</th>
                            <th>التاريخ</th>
                            <th>الحضور</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <span class="avatar avatar-sm bg-primary">
                                            <i class="fas fa-calendar-day"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">{{ $event->event_title }}</h6>
                                        <small class="text-muted">{{ Str::limit($event->description, 50) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info">
                                    {{ $event->branch->name ?? 'غير محدد' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                    {{ $event->type }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar-alt text-muted me-2"></i>
                                    {{ \Carbon\Carbon::parse($event->event_datetime)->format('Y-m-d') }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 me-2" style="width: 100px">
                                        <div class="progress" style="height: 5px">
                                            <div class="progress-bar bg-success"
                                                 style="width: {{ $event->attendance }}%"></div>
                                        </div>
                                    </div>
                                    <span class="text-muted small">{{ $event->attendance }}%</span>
                                </div>
                            </td>
                            <td>
                                @if($event->is_completed)
                                    <span class="badge bg-success">مكتمل</span>
                                @else
                                    <span class="badge bg-warning text-dark">قيد التنفيذ</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    لا توجد نتائج للعرض
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-transparent">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    إجمالي النتائج: {{ $events->total() }}
                </div>
                {{ $events->appends(request()->except('page'))->links() }}
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }
    .progress {
        border-radius: 10px;
        overflow: hidden;
    }
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .badge {
        padding: 0.5em 0.75em;
        font-weight: 500;
    }
</style>
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('branchesPieChart').getContext('2d');
    var data = {
        labels: {!! json_encode($events->groupBy(fn($event) => $event->branch->name ?? 'غير محدد')->keys()) !!},
        datasets: [{
            data: {!! json_encode($events->groupBy(fn($event) => $event->branch->name ?? 'غير محدد')->map->count()->values()) !!},
            backgroundColor: [
                '#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6f42c1', '#fd7e14'
            ]
        }]
    };
    new Chart(ctx, {
        type: 'pie',
        data: data,
        options: { responsive: true }
    });
});
</script>
@endpush
@endsection

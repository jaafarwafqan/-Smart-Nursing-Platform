@extends('layouts.app')
@section('title', 'التقارير التفصيلية')


@section('content')
@php
    // Debug information to check the actual data structure
    // dd($statistics->first());
@endphp
<div class="container-fluid py-4">
    <!-- رأس الصفحة -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">التقارير التفصيلية</h1>
            <p class="text-muted">تحليل تفصيلي للفعاليات والحملات - {{ $year }}</p>
        </div>
        <div class="d-flex gap-2">
            <form method="GET" action="{{ route('dashboard.statistical') }}" class="d-flex gap-2">
                <select name="year" class="form-select" style="width: 150px" onchange="this.form.submit()">
                    @for ($y = now()->year; $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                            السنة: {{ $y }}
                        </option>
                    @endfor
                </select>
            </form>
            <a href="{{ route('dashboard.statistical', ['export' => 'excel', 'year' => $year]) }}"
               class="btn btn-success">
                <i class="fas fa-file-excel me-1"></i>
                تصدير Excel
            </a>
        </div>
    </div>

    <!-- الرسوم البيانية -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0">توزيع الحملات حسب الفروع</h5>
                </div>
                <div class="card-body">
                    <canvas id="campaignsChart" style="height: 300px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0">توزيع الفعاليات حسب الفروع</h5>
                </div>
                <div class="card-body">
                    <canvas id="eventsChart" style="height: 300px"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- جداول الإحصائيات -->
    <div class="row g-4">
        <!-- جدول الحملات -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0">إحصائيات الحملات</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>الفرع</th>
                                    <th>إجمالي الحملات</th>
                                    <th>الحملات النشطة</th>
                                    <th>الحملات المكتملة</th>
                                    <th>الحملات المخططة</th>
                                    <th>إجمالي المشاركين</th>
                                    <th>نسبة الإنجاز</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statistics as $stat)
                                    @php
                                        $totalCampaigns = $stat['campaigns_total'] ?? 0;
                                        $completedCampaigns = $stat['completed_campaigns'] ?? 0;
                                        $activeCampaigns = $stat['active_campaigns'] ?? 0;
                                        $plannedCampaigns = $stat['planned_campaigns'] ?? 0;
                                        $totalParticipants = $stat['participants_count'] ?? 0;
                                        $completionRate = $totalCampaigns > 0 ? ($completedCampaigns / $totalCampaigns) * 100 : 0;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <span class="avatar avatar-sm bg-primary">
                                                        <i class="fas fa-building"></i>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">{{ $stat['branch'] }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ $totalCampaigns }}</h6>
                                            <small class="text-muted">حملة</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-success bg-opacity-10 text-success">
                                                {{ $activeCampaigns }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info bg-opacity-10 text-info">
                                                {{ $completedCampaigns }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning bg-opacity-10 text-warning">
                                                {{ $plannedCampaigns }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-users text-muted me-2"></i>
                                                {{ number_format($totalParticipants) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 me-2" style="width: 100px">
                                                    <div class="progress" style="height: 5px">
                                                        <div class="progress-bar bg-success"
                                                             style="width: {{ $completionRate }}%"></div>
                                                    </div>
                                                </div>
                                                <span class="text-muted small">{{ number_format($completionRate, 1) }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- جدول الفعاليات -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0">إحصائيات الفعاليات</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>الفرع</th>
                                    <th>إجمالي الفعاليات</th>
                                    <th>مؤتمر علمي</th>
                                    <th>ندوة علمية</th>
                                    <th>ورشة عمل</th>
                                    <th>نشاط تعليمي مبتكر</th>
                                    <th>مشروع بحثي</th>
                                    <th>تعاون دولي</th>
                                    <th>خدمة مجتمعية</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statistics as $stat)
                                    @php
                                        $types = $stat['types'] ?? [];
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <span class="avatar avatar-sm bg-info">
                                                        <i class="fas fa-building"></i>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">{{ $stat['branch'] }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ $stat['events_total'] ?? 0 }}</h6>
                                            <small class="text-muted">فعالية</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                                {{ $types['مؤتمر علمي'] ?? 0 }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success bg-opacity-10 text-success">
                                                {{ $types['ندوة علمية'] ?? 0 }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info bg-opacity-10 text-info">
                                                {{ $types['ورشة عمل'] ?? 0 }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning bg-opacity-10 text-warning">
                                                {{ $types['نشاط تعليمي مبتكر'] ?? 0 }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger bg-opacity-10 text-danger">
                                                {{ $types['مشروع بحثي'] ?? 0 }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                                {{ $types['تعاون دولي'] ?? 0 }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-dark bg-opacity-10 text-dark">
                                                {{ $types['خدمة مجتمعية'] ?? 0 }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // إعداد الرسم البياني للحملات
    const campaignsCtx = document.getElementById('campaignsChart').getContext('2d');
    new Chart(campaignsCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($statistics->pluck('branch')) !!},
            datasets: [{
                label: 'الحملات النشطة',
                data: {!! json_encode($statistics->map(function($stat) {
                    return $stat['active_campaigns'] ?? 0;
                })) !!},
                backgroundColor: 'rgba(40, 167, 69, 0.5)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1
            }, {
                label: 'الحملات المكتملة',
                data: {!! json_encode($statistics->map(function($stat) {
                    return $stat['completed_campaigns'] ?? 0;
                })) !!},
                backgroundColor: 'rgba(23, 162, 184, 0.5)',
                borderColor: 'rgba(23, 162, 184, 1)',
                borderWidth: 1
            }, {
                label: 'الحملات المخططة',
                data: {!! json_encode($statistics->map(function($stat) {
                    return $stat['planned_campaigns'] ?? 0;
                })) !!},
                backgroundColor: 'rgba(255, 193, 7, 0.5)',
                borderColor: 'rgba(255, 193, 7, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // إعداد الرسم البياني للفعاليات
    const eventsCtx = document.getElementById('eventsChart').getContext('2d');
    new Chart(eventsCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($statistics->pluck('branch')) !!},
            datasets: [{
                label: 'مؤتمر علمي',
                data: {!! json_encode($statistics->map(function($stat) {
                    return isset($stat['types']) ? ($stat['types']['مؤتمر علمي'] ?? 0) : 0;
                })) !!},
                backgroundColor: 'rgba(0, 123, 255, 0.5)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 1
            }, {
                label: 'ندوة علمية',
                data: {!! json_encode($statistics->map(function($stat) {
                    return isset($stat['types']) ? ($stat['types']['ندوة علمية'] ?? 0) : 0;
                })) !!},
                backgroundColor: 'rgba(40, 167, 69, 0.5)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1
            }, {
                label: 'ورشة عمل',
                data: {!! json_encode($statistics->map(function($stat) {
                    return isset($stat['types']) ? ($stat['types']['ورشة عمل'] ?? 0) : 0;
                })) !!},
                backgroundColor: 'rgba(23, 162, 184, 0.5)',
                borderColor: 'rgba(23, 162, 184, 1)',
                borderWidth: 1
            }, {
                label: 'نشاط تعليمي',
                data: {!! json_encode($statistics->map(function($stat) {
                    return isset($stat['types']) ? ($stat['types']['نشاط تعليمي مبتكر'] ?? 0) : 0;
                })) !!},
                backgroundColor: 'rgba(255, 193, 7, 0.5)',
                borderColor: 'rgba(255, 193, 7, 1)',
                borderWidth: 1
            }, {
                label: 'مشروع بحثي',
                data: {!! json_encode($statistics->map(function($stat) {
                    return isset($stat['types']) ? ($stat['types']['مشروع بحثي'] ?? 0) : 0;
                })) !!},
                backgroundColor: 'rgba(220, 53, 69, 0.5)',
                borderColor: 'rgba(220, 53, 69, 1)',
                borderWidth: 1
            }, {
                label: 'تعاون دولي',
                data: {!! json_encode($statistics->map(function($stat) {
                    return isset($stat['types']) ? ($stat['types']['تعاون دولي'] ?? 0) : 0;
                })) !!},
                backgroundColor: 'rgba(108, 117, 125, 0.5)',
                borderColor: 'rgba(108, 117, 125, 1)',
                borderWidth: 1
            }, {
                label: 'خدمة مجتمعية',
                data: {!! json_encode($statistics->map(function($stat) {
                    return isset($stat['types']) ? ($stat['types']['خدمة مجتمعية'] ?? 0) : 0;
                })) !!},
                backgroundColor: 'rgba(52, 58, 64, 0.5)',
                borderColor: 'rgba(52, 58, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    stacked: true
                },
                x: {
                    stacked: true
                }
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20
                    }
                }
            }
        }
    });
</script>

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
@endsection

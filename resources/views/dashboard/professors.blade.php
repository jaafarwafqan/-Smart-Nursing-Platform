@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تقارير الأساتذة</h3>
                </div>
                <div class="card-body">
                    <!-- إحصائيات عامة -->
                    <div class="row row-cols-1 row-cols-lg-4 g-3 mb-4">
                        <div class="col">
                            <x-stat-card color="dark" icon="users" :value="$totalProfessors" title="إجمالي الأساتذة"/>
                        </div>
                        <div class="col">
                            <x-stat-card color="success" icon="chalkboard-teacher" :value="$researchProfessors" title="أساتذة باحثون"/>
                        </div>
                        <div class="col">
                            <x-stat-card color="primary" icon="chart-line" :value="number_format($averageResearchesPerProfessor, 2)" title="متوسط البحوث للأستاذ"/>
                        </div>
                        <div class="col">
                            <x-stat-card color="warning" icon="star" :value="$excellentProfessors" title="أساتذة متميزون"/>
                        </div>
                    </div>

                    <!-- الرسوم البيانية -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">توزيع الأساتذة حسب الرتبة الأكاديمية</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="academicRankChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">توزيع الأساتذة حسب الكلية</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="collegeDistributionChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- جدول الأساتذة المتميزين -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">الأساتذة المتميزين</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>اسم الأستاذ</th>
                                                <th>الرتبة الأكاديمية</th>
                                                <th>الكلية</th>
                                                <th>القسم</th>
                                                <th>عدد البحوث</th>
                                                <th>عدد البحوث المنشورة</th>
                                                <th>متوسط التقييم</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($excellentProfessorsList as $professor)
                                            <tr>
                                                <td>{{ $professor->name }}</td>
                                                <td>{{ $professor->academic_rank }}</td>
                                                <td>{{ $professor->college }}</td>
                                                <td>{{ $professor->department }}</td>
                                                <td>{{ $professor->researches_count }}</td>
                                                <td>{{ $professor->published_researches_count }}</td>
                                                <td>{{ $professor->average_rating }}</td>
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
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // رسم بياني لتوزيع الأساتذة حسب الرتبة الأكاديمية
    const academicRankCtx = document.getElementById('academicRankChart').getContext('2d');
    new Chart(academicRankCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($academicRankDistribution->pluck('rank')) !!},
            datasets: [{
                data: {!! json_encode($academicRankDistribution->pluck('count')) !!},
                backgroundColor: ['#36A2EB', '#FF6384', '#4BC0C0', '#FFCE56', '#9966FF']
            }]
        }
    });

    // رسم بياني لتوزيع الأساتذة حسب الكلية
    const collegeCtx = document.getElementById('collegeDistributionChart').getContext('2d');
    new Chart(collegeCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($collegeDistribution->pluck('college')) !!},
            datasets: [{
                label: 'عدد الأساتذة',
                data: {!! json_encode($collegeDistribution->pluck('count')) !!},
                backgroundColor: '#36A2EB'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
@endsection 
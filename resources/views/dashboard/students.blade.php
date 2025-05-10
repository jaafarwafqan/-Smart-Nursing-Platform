@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تقارير الطلاب</h3>
                </div>
                <div class="card-body">
                    <!-- إحصائيات عامة -->
                    <div class="row row-cols-1 row-cols-lg-4 g-3 mb-4">
                        <div class="col">
                            <x-stat-card color="dark" icon="user-graduate" :value="$totalStudents" title="إجمالي الطلاب"/>
                        </div>
                        <div class="col">
                            <x-stat-card color="success" icon="users" :value="$researchStudents" title="طلاب باحثون"/>
                        </div>
                        <div class="col">
                            <x-stat-card color="primary" icon="chart-line" :value="number_format($averageResearchesPerStudent, 2)" title="متوسط البحوث للطالب"/>
                        </div>
                        <div class="col">
                            <x-stat-card color="warning" icon="star" :value="$excellentStudents" title="طلاب متميزون"/>
                        </div>
                    </div>

                    <!-- الرسوم البيانية -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">توزيع الطلاب حسب الكلية</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="collegeDistributionChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">توزيع الطلاب حسب المستوى</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="levelDistributionChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- جدول الطلاب المتميزين -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">الطلاب المتميزين</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>اسم الطالب</th>
                                                <th>الكلية</th>
                                                <th>القسم</th>
                                                <th>المستوى</th>
                                                <th>عدد البحوث</th>
                                                <th>متوسط التقييم</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($excellentStudentsList as $student)
                                            <tr>
                                                <td>{{ $student->name }}</td>
                                                <td>{{ $student->college }}</td>
                                                <td>{{ $student->department }}</td>
                                                <td>{{ $student->level }}</td>
                                                <td>{{ $student->researches_count }}</td>
                                                <td>{{ $student->average_rating }}</td>
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
    // رسم بياني لتوزيع الطلاب حسب الكلية
    const collegeCtx = document.getElementById('collegeDistributionChart').getContext('2d');
    new Chart(collegeCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($collegeDistribution->pluck('college')) !!},
            datasets: [{
                data: {!! json_encode($collegeDistribution->pluck('count')) !!},
                backgroundColor: ['#36A2EB', '#FF6384', '#4BC0C0', '#FFCE56', '#9966FF']
            }]
        }
    });

    // رسم بياني لتوزيع الطلاب حسب المستوى
    const levelCtx = document.getElementById('levelDistributionChart').getContext('2d');
    new Chart(levelCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($levelDistribution->pluck('level')) !!},
            datasets: [{
                label: 'عدد الطلاب',
                data: {!! json_encode($levelDistribution->pluck('count')) !!},
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
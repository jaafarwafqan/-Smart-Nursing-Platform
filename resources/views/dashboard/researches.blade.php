@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تقارير البحوث</h3>
                </div>
                <div class="card-body">
                    <!-- إحصائيات عامة -->
                    <div class="row row-cols-1 row-cols-lg-4 g-3 mb-4">
                        <div class="col">
                            <x-stat-card color="dark" icon="book" :value="$totalResearches" title="إجمالي البحوث"/>
                        </div>
                        <div class="col">
                            <x-stat-card color="success" icon="check-circle" :value="$completedResearches" title="بحوث مكتملة"/>
                        </div>
                        <div class="col">
                            <x-stat-card color="primary" icon="spinner" :value="$inProgressResearches" title="بحوث قيد الإنجاز"/>
                        </div>
                        <div class="col">
                            <x-stat-card color="warning" icon="cloud-upload-alt" :value="$publishedResearches" title="بحوث منشورة"/>
                        </div>
                    </div>

                    <!-- الرسوم البيانية -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">توزيع البحوث حسب النوع</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="researchTypeChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">توزيع البحوث حسب حالة النشر</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="publicationStatusChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- جدول آخر البحوث -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">آخر البحوث</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>عنوان البحث</th>
                                                <th>نوع البحث</th>
                                                <th>حالة النشر</th>
                                                <th>نسبة الإنجاز</th>
                                                <th>تاريخ البدء</th>
                                                <th>تاريخ الانتهاء</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($latestResearches as $research)
                                            <tr>
                                                <td>{{ $research->title }}</td>
                                                <td>{{ $research->research_type }}</td>
                                                <td>{{ $research->publication_status }}</td>
                                                <td>{{ $research->completion_percentage }}%</td>
                                                <td>{{ $research->start_date }}</td>
                                                <td>{{ $research->end_date }}</td>
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
    // رسم بياني لتوزيع البحوث حسب النوع
    const researchTypeCtx = document.getElementById('researchTypeChart').getContext('2d');
    new Chart(researchTypeCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($researchTypes->pluck('type')) !!},
            datasets: [{
                data: {!! json_encode($researchTypes->pluck('count')) !!},
                backgroundColor: ['#36A2EB', '#FF6384', '#4BC0C0', '#FFCE56']
            }]
        }
    });

    // رسم بياني لتوزيع البحوث حسب حالة النشر
    const publicationStatusCtx = document.getElementById('publicationStatusChart').getContext('2d');
    new Chart(publicationStatusCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($publicationStatuses->pluck('status')) !!},
            datasets: [{
                label: 'عدد البحوث',
                data: {!! json_encode($publicationStatuses->pluck('count')) !!},
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
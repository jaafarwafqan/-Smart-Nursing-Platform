@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تقارير الدوريات</h3>
                </div>
                <div class="card-body">
                    <!-- إحصائيات عامة -->
                    <div class="row row-cols-1 row-cols-lg-4 g-3 mb-4">
                        <div class="col">
                            <x-stat-card color="dark" icon="newspaper" :value="$totalJournals" title="إجمالي الدوريات"/>
                        </div>
                        <div class="col">
                            <x-stat-card color="success" icon="globe" :value="$internationalJournals" title="دوريات دولية"/>
                        </div>
                        <div class="col">
                            <x-stat-card color="primary" icon="database" :value="$scopusIndexed" title="مفهرسة في Scopus"/>
                        </div>
                        <div class="col">
                            <x-stat-card color="warning" icon="award" :value="$clarivateIndexed" title="مفهرسة في Clarivate"/>
                        </div>
                    </div>

                    <!-- الرسوم البيانية -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">توزيع الدوريات حسب النوع</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="journalTypeChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">توزيع البحوث المنشورة في الدوريات</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="publishedResearchesChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- جدول الدوريات المتميزة -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">الدوريات المتميزة</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>اسم الدورية</th>
                                                <th>النوع</th>
                                                <th>مفهرسة في Scopus</th>
                                                <th>مفهرسة في Clarivate</th>
                                                <th>عدد البحوث المنشورة</th>
                                                <th>متوسط التقييم</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($excellentJournalsList as $journal)
                                            <tr>
                                                <td>{{ $journal->name }}</td>
                                                <td>{{ $journal->type }}</td>
                                                <td>{{ $journal->is_scopus_indexed ? 'نعم' : 'لا' }}</td>
                                                <td>{{ $journal->is_clarivate_indexed ? 'نعم' : 'لا' }}</td>
                                                <td>{{ $journal->researches_count }}</td>
                                                <td>{{ $journal->average_rating }}</td>
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
    // رسم بياني لتوزيع الدوريات حسب النوع
    const journalTypeCtx = document.getElementById('journalTypeChart').getContext('2d');
    new Chart(journalTypeCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($journalTypeDistribution->pluck('type')) !!},
            datasets: [{
                data: {!! json_encode($journalTypeDistribution->pluck('count')) !!},
                backgroundColor: ['#36A2EB', '#FF6384', '#4BC0C0', '#FFCE56']
            }]
        }
    });

    // رسم بياني لتوزيع البحوث المنشورة في الدوريات
    const publishedResearchesCtx = document.getElementById('publishedResearchesChart').getContext('2d');
    new Chart(publishedResearchesCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($publishedResearchesDistribution->pluck('journal')) !!},
            datasets: [{
                label: 'عدد البحوث المنشورة',
                data: {!! json_encode($publishedResearchesDistribution->pluck('count')) !!},
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
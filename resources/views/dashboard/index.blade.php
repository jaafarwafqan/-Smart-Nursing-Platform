@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-4">
        <!-- اختيار السنة -->
        <div class="mt-6 mb-5">
            <label for="yearSelect" class="block text-gray-700 font-medium mb-2">اختر السنة:</label>
            <select id="yearSelect" class="border border-gray-300 rounded-md px-4 py-2 w-full md:w-auto"
                    onchange="location = this.value;">
                @for($y = date('Y'); $y >= 2020; $y--)
                    <option value="{{ route('dashboard.index', ['year' => $y]) }}" {{ $y == $year ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>
        </div>

        <!-- إحصائيات الفعاليات حسب الفروع -->
        <h2 class="text-3xl font-bold text-center text-blue-800 mb-6">إحصائيات الفعاليات حسب الفروع (السنة {{ $year }})</h2>
        <div class="stats-horizontal mb-8">
            @foreach($statistics as $stat)
                <div class="stat-card-horizontal bg-white p-4 rounded-lg shadow d-flex align-items-center gap-3 flex-shrink-0 border-start {{ $stat['color'] }}" style="min-width: 320px; max-width: 350px;">
                    <div class="stat-icon flex-shrink-0">
                        @if(str_contains($stat['branch'], 'البالغين'))
                            <i class="fas fa-user-injured text-3xl {{ $stat['icon_color'] }}"></i>
                        @elseif(str_contains($stat['branch'], 'أساسيات'))
                            <i class="fas fa-plus-square text-3xl {{ $stat['icon_color'] }}"></i>
                        @elseif(str_contains($stat['branch'], 'الأم والوليد'))
                            <i class="fas fa-baby text-3xl {{ $stat['icon_color'] }}"></i>
                        @else
                            <i class="fas fa-chart-pie text-3xl {{ $stat['icon_color'] }}"></i>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-1">{{ $stat['branch'] }}</h3>
                        <div class="d-flex gap-3">
                            <span class="badge bg-primary">فعاليات: <b>{{ $stat['events_total'] }}</b></span>
                            <span class="badge bg-success">حملات: <b>{{ $stat['campaigns_total'] }}</b></span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <style>
            .stats-horizontal {
                display: flex;
                flex-direction: row;
                justify-content: center;
                gap: 2rem;
                flex-wrap: wrap;
                padding-bottom: 1rem;
            }
            .stat-card-horizontal {
                min-width: 300px;
                max-width: 350px;
                flex: 1 1 300px;
            }
            .stat-card-horizontal {
                transition: box-shadow .2s, transform .2s;
                border-width: 4px !important;
                border-radius: 1rem;
            }
            .stat-card-horizontal:hover {
                box-shadow: 0 8px 24px rgba(0,0,0,0.13);
                transform: translateY(-4px) scale(1.03);
            }
            .stat-icon {
                font-size: 2.5rem;
                opacity: 0.85;
            }
        </style>

        <!-- رسم بياني: توزيع الفعاليات حسب الفروع -->
        <div class="bg-white rounded-lg shadow p-6 mb-6" style="display:none;"></div>
        <!-- رسم بياني: توزيع الحملات حسب الفروع -->
        <div class="bg-white rounded-lg shadow p-6" style="display:none;"></div>
    </div>

    <!-- تضمين Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // رسم بياني للفعاليات
            const eventsCtx = document.getElementById('eventsByBranchChart').getContext('2d');
            const eventsLabels = JSON.parse(eventsCtx.canvas.dataset.labels);
            const eventsValues = JSON.parse(eventsCtx.canvas.dataset.values);

            new Chart(eventsCtx, {
                type: 'doughnut',
                data: {
                    labels: eventsLabels,
                    datasets: [{
                        data: eventsValues,
                        backgroundColor: eventsLabels.map(() => '#' + Math.floor(Math.random()*16777215).toString(16)),
                        borderColor: '#fff',
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                font: { size: 12 }
                            }
                        }
                    }
                }
            });

            // رسم بياني للحملات
            const campaignsCtx = document.getElementById('campaignsByBranchChart').getContext('2d');
            const campaignsLabels = JSON.parse(campaignsCtx.canvas.dataset.labels);
            const campaignsValues = JSON.parse(campaignsCtx.canvas.dataset.values);

            new Chart(campaignsCtx, {
                type: 'doughnut',
                data: {
                    labels: campaignsLabels,
                    datasets: [{
                        data: campaignsValues,
                        backgroundColor: campaignsLabels.map(() => '#' + Math.floor(Math.random()*16777215).toString(16)),
                        borderColor: '#fff',
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                font: { size: 12 }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection

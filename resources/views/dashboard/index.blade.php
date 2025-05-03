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
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
            @foreach($statistics as $stat)
                <div class="bg-white p-4 rounded-lg shadow transform transition duration-300 hover:scale-105 border-l-4 {{ $stat['color'] }}">
                    <div class="flex items-center">
                        <i class="fas fa-chart-pie text-3xl {{ $stat['icon_color'] }} mr-4"></i>
                        <div>
                            <h3 class="text-xl font-semibold ">{{ $stat['branch'] }}</h3>
                            <p class="text-gray-600">فعاليات: <span class="font-bold">{{ $stat['events_total'] }}</span></p>
                            <p class="text-gray-600">حملات: <span class="font-bold">{{ $stat['campaigns_total'] }}</span></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- رسم بياني: توزيع الفعاليات حسب الفروع -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-xl font-semibold mb-4 text-blue-700 text-center">توزيع الفعاليات حسب الفروع (السنة {{ $year }})</h3>
            <canvas id="eventsByBranchChart" width="300" height="300"
                    data-labels="{{ $statistics->pluck('branch')->toJson() }}"
                    data-values="{{ $statistics->pluck('events_total')->toJson() }}">
            </canvas>
        </div>

        <!-- رسم بياني: توزيع الحملات حسب الفروع -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl font-semibold mb-4 text-blue-700 text-center">توزيع الحملات حسب الفروع (السنة {{ $year }})</h3>
            <canvas id="campaignsByBranchChart" width="300" height="300"
                    data-labels="{{ $statistics->pluck('branch')->toJson() }}"
                    data-values="{{ $statistics->pluck('campaigns_total')->toJson() }}">
            </canvas>
        </div>
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
        });
    </script>
@endsection

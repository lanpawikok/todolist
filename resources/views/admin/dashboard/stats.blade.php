@extends('layouts.admin')

@section('title', 'Performance Stats')

@section('content')
<div class="container">
    <h1 class="mb-4">Performance Stats</h1>

    <!-- Bar Chart -->
    <canvas id="tasksChart" height="100"></canvas>

    <hr>

    <!-- Doughnut Chart -->
    <canvas id="tasksDoughnutChart" height="100"></canvas>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Plugin untuk menampilkan label di chart -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>
    // Bar Chart
    const ctxBar = document.getElementById('tasksChart').getContext('2d');
    const tasksChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: {!! json_encode($tasksPerUser->pluck('name')) !!},
            datasets: [{
                label: 'Jumlah Task per User',
                data: {!! json_encode($tasksPerUser->pluck('tasks_count')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                title: { display: true, text: 'Jumlah Task per User' }
            },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Doughnut Chart dengan persentase
    const ctxDoughnut = document.getElementById('tasksDoughnutChart').getContext('2d');
    const data = {!! json_encode($tasksPerUser->pluck('tasks_count')) !!};
    const labels = {!! json_encode($tasksPerUser->pluck('name')) !!};

    const tasksDoughnutChart = new Chart(ctxDoughnut, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'right' },
                title: { display: true, text: 'Proporsi Task per User' },
                datalabels: {
                    color: '#fff',
                    formatter: (value, ctx) => {
                        let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                        let percentage = (value / sum * 100).toFixed(1) + '%';
                        return percentage;
                    },
                    font: { weight: 'bold', size: 14 }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
</script>
@endsection

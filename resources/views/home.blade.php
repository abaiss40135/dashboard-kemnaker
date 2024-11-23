@extends('layouts.app')
@section('css')
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
            <div class="card">
                <canvas id="myChart" width="200" height="200"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="{{ asset('vendor/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('vendor/chartjs/chart.min.js') }}"></script>
    <script>
        let pendapat = @json($pendapat);
        console.log(pendapat)
        const ctx = document.getElementById('myChart').getContext('2d');
        const labels = Object.keys(pendapat);
        const data = {
            labels: labels,
            datasets: [{
                axis: 'y',
                label: 'Keluhan',
                data: Object.values(pendapat).map(item => item.keluhan),
                fill: false,
                backgroundColor: [
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgb(153, 102, 255)'
                ],
                borderWidth: 1
            },{
                axis: 'y',
                label: 'Harapan',
                data: Object.values(pendapat).map(item => item.harapan),
                fill: false,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)'
                ],
                borderWidth: 1
            }]
        };

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection

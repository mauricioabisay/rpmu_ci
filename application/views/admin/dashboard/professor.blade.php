@extends('layouts.main')

@section('content')
<div class="row">
	<div class="col">
		<p>Bienvenido Profesor {{ Auth::user()->name }}</p>
	</div>
</div>

<div class="row">
    <div class="col-sm-12 col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Avance de mis Investigaciones</h5>
                <canvas id="rpm-researches-by-status"></canvas>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Objetivos de Investigaciones</h5>
                <canvas id="rpm-researches-by-faculty"></canvas>
            </div>
        </div>
    </div>  
</div>

<script type="text/javascript">
    new Chart(
        document.getElementById('rpm-researches-by-status').getContext('2d'),
        {
            type: 'pie',
            data: {
                labels: ['Creadas', 'En desarrollo', 'Terminadas'],
                datasets: [{
                    label: 'Dataset',
                    backgroundColor: ['#aaa', '#afa', '#faa'],
                    data: {!! $researches_by_status_data !!}
                }]
            },
            options: {
                legend: {
                    position: 'right'
                }
            }
        }
    );
    new Chart(
        document.getElementById('rpm-researches-by-faculty').getContext('2d'),
        {
            type: 'horizontalBar',
            data: {
                labels: {!! $researches_objectives['labels'] !!},
                datasets: [
                    {
                        label: 'Pendientes',
                        data: {!! $researches_objectives['pending'] !!},
                        backgroundColor: '#aaa'
                    },
                    {
                        label: 'Cumplidos',
                        data: {!! $researches_objectives['completed'] !!},
                        backgroundColor: '#afa'
                    }
                ]
            },
            options: {
                legend: {
                    position: 'bottom'
                },
                scales: {
                    xAxes: [{stacked: true}],
                    yAxes: [{stacked: true}]
                },
                responsive: true,
            }
        }
    );
</script>

@endsection
@extends('layouts.main')

@section('content')
<div class="row">
	<div class="col">
		<p>Bienvenido Director de Departamento {{ Auth::user()->name }}</p>
	</div>
</div>

<div class="row">
	<div class="col-sm-12 col-md-6 rpm-graph">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">Avance de Investigaciones</h5>
				<canvas id="rpm-researches-by-status"></canvas>
			</div>
		</div>
	</div>
	<div class="col-sm-12 col-md-6 rpm-graph">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">Rendimiento de Investigadores</h5>
				<canvas id="rpm-researchers-performance"></canvas>
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
					backgroundColor: ['#aaa', '#ffa', '#afa'],
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
		document.getElementById('rpm-researchers-performance').getContext('2d'),
		{
			type: 'pie',
			data: {
				labels: ['Sin Investigaciones', 'Con Investigaciones'],
				datasets: [{
					label: 'Dataset',
					backgroundColor: ['#aaa', '#afa',],
					data: {!! $researchers_performance_data !!}
				}]
			},
			options: {
				legend: {
					position: 'right'
				}
			}
		}
	);
</script>

@endsection
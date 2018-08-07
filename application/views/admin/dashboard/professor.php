<?php $this->load->view('admin/layouts/main')?>

<div class="row">
	<div class="col">
		<p>Bienvenido <?php echo $this->session->user->participant->name;?></p>
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
                    data: <?php echo $researches_by_status;?>
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
                labels: <?php echo $researches_goals['labels'];?>,
                datasets: [
                    {
                        label: 'Cumplidos',
                        data: <?php echo $researches_goals['achieved'];?>,
                        backgroundColor: '#afa'
                    },
                    {
                        label: 'Pendientes',
                        data: <?php echo $researches_goals['pending'];?>,
                        backgroundColor: '#aaa'
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

<?php $this->load->view('admin/layouts/footer');?>
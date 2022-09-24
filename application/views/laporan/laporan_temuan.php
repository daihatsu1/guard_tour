<!-- START SECTION HEADER -->
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<!-- <h1>Master Company</h1> -->
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Laporan</a></li>
					<li class="breadcrumb-item"><a href="<?= base_url('Laporan_Patroli') ?>">Laporan Temuan</a></li>
				</ol>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>
<!-- END SECTION HEADER -->

<!--START SECTION CONTENT-->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-sm-6 col-md-3">
				<div class="info-box">
					<span class="info-box-icon bg-gradient-danger elevation-1"><i class="fa fa-bell"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Temuan Hari Ini</span>
						<span class="info-box-number"><?= $temuan_hari_ini ?></span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->
			<div class="col-12 col-sm-6 col-md-3">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-exclamation-triangle"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Total Temuan</span>
						<span class="info-box-number"><?= $total_temuan ?></span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->

			<!-- fix for small devices only -->
			<div class="clearfix hidden-md-up"></div>

			<div class="col-12 col-sm-6 col-md-3">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-square"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Tindakan Cepat</span>
						<span class="info-box-number"><?= $tindakan_cepat ?></span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->
			<div class="col-12 col-sm-6 col-md-3">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-gradient-warning elevation-1 text-white"><i
								class="fas fa-user-friends"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Laporkan PIC</span>
						<span class="info-box-number"><?= $laporkan_pic ?></span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->

		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<!--						<h5 class="card-title">Grafik Temuan</h5>-->

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<div class="row">
							<div class="col-md-8">
								<p class="text-center">
									<strong>Temuan: <span id="chart_start_date"></span> - <span
												id="chart_end_date"></span></strong>
								</p>

								<div class="chart">
									<!-- Sales Chart Canvas -->
									<canvas id="salesChart" height="180" style="height: 180px;"></canvas>
								</div>
								<!-- /.chart-responsive -->
							</div>
							<!-- /.col -->
							<div class="col-md-4">
								<p class="text-center">
									<strong>Temuan Berdasarkan kategori objek</strong>
								</p>

								<div class="progress-group">
									A
									<span class="float-right"><b>160</b>/200</span>
									<div class="progress progress-sm">
										<div class="progress-bar bg-primary" style="width: 80%"></div>
									</div>
								</div>
								<!-- /.progress-group -->

								<div class="progress-group">
									B
									<span class="float-right"><b>310</b>/400</span>
									<div class="progress progress-sm">
										<div class="progress-bar bg-danger" style="width: 75%"></div>
									</div>
								</div>

								<!-- /.progress-group -->
								<div class="progress-group">
									<span class="progress-text">C</span>
									<span class="float-right"><b>480</b>/800</span>
									<div class="progress progress-sm">
										<div class="progress-bar bg-success" style="width: 60%"></div>
									</div>
								</div>

								<!-- /.progress-group -->
								<div class="progress-group">
									D
									<span class="float-right"><b>250</b>/500</span>
									<div class="progress progress-sm">
										<div class="progress-bar bg-warning" style="width: 50%"></div>
									</div>
								</div>
								<!-- /.progress-group -->
							</div>
							<!-- /.col -->
						</div>
						<!-- /.row -->
					</div>
					<!-- ./card-body -->
					<div class="card-footer">
						<div class="row">
							<div class="col-sm-3 col-6">
								<div class="description-block border-right">
									<!--									<span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>-->
									<h5 class="description-header"><?= $temuan_selesai ?></h5>
									<span class="description-text">TEMUAN SELESAI</span>
								</div>
								<!-- /.description-block -->
							</div>
							<!-- /.col -->
							<div class="col-sm-3 col-6">
								<div class="description-block border-right">
									<!--									<span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>-->
									<h5 class="description-header"><?= $temuan_belum_selesai ?></h5>
									<span class="description-text">TEMUAN BELUM SELESAI</span>
								</div>
								<!-- /.description-block -->
							</div>
							<!-- /.col -->
							<div class="col-sm-3 col-6">
								<div class="description-block border-right">
									<!--									<span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>-->
									<h5 class="description-header">0</h5>
									<span class="description-text">TOTAL </span>
								</div>
								<!-- /.description-block -->
							</div>
							<!-- /.col -->
							<div class="col-sm-3 col-6">
								<div class="description-block">
									<!--									<span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>-->
									<h5 class="description-header">0</h5>
									<span class="description-text">TOTAL</span>
								</div>
								<!-- /.description-block -->
							</div>
						</div>
						<!-- /.row -->
					</div>
					<!-- /.card-footer -->
				</div>
				<!-- /.card -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->

		<!-- Main row -->
		<div class="row">
			<!-- Left col -->
			<div class="col-md-8">
				<!-- TABLE: LATEST ORDERS -->
				<div class="card">
					<div class="card-header border-transparent">
						<h3 class="card-title">Daftar Temuan</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
							<button type="button" class="btn btn-tool" data-card-widget="remove">
								<i class="fas fa-times"></i>
							</button>
						</div>
					</div>
					<!-- /.card-header -->
					<div class="card-body p-4">
						<div class="table-responsive ">
							<table class="table m-0 table-hover" id="tableTemuan">
								<thead>
								<tr>
									<th>Foto</th>
									<th>Object ID</th>
									<th>Nama Objek</th>
									<th>Deskripsi</th>
									<th>Tanggal Patroli</th>
									<th>Shift</th>
								</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>
						<!-- /.table-responsive -->
					</div>
					<!-- /.card-footer -->
				</div>
				<!-- /.card -->
			</div>
			<!-- /.col -->

			<div class="col-md-4">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title"></h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
							<button type="button" class="btn btn-tool" data-card-widget="remove">
								<i class="fas fa-times"></i>
							</button>
						</div>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<div class="row">
							<div class="col-md-8">
								<div class="chart-responsive">
									<canvas id="pieChart" height="150"></canvas>
								</div>
								<!-- ./chart-responsive -->
							</div>
							<!-- /.col -->
							<div class="col-md-4">
								<!--								<ul class="chart-legend clearfix">-->
								<!--									<li><i class="far fa-circle text-danger"></i> Chrome</li>-->
								<!--									<li><i class="far fa-circle text-success"></i> IE</li>-->
								<!--									<li><i class="far fa-circle text-warning"></i> FireFox</li>-->
								<!--									<li><i class="far fa-circle text-info"></i> Safari</li>-->
								<!--									<li><i class="far fa-circle text-primary"></i> Opera</li>-->
								<!--									<li><i class="far fa-circle text-secondary"></i> Navigator</li>-->
								<!--								</ul>-->
							</div>
							<!-- /.col -->
						</div>
						<!-- /.row -->
					</div>
					<!-- /.card-body -->
					<!--					<div class="card-footer p-0">-->
					<!--						<ul class="nav nav-pills flex-column">-->
					<!--							<li class="nav-item">-->
					<!--								<a href="#" class="nav-link">-->
					<!--									United States of America-->
					<!--									<span class="float-right text-danger">-->
					<!--                        <i class="fas fa-arrow-down text-sm"></i>-->
					<!--                        12%</span>-->
					<!--								</a>-->
					<!--							</li>-->
					<!--							<li class="nav-item">-->
					<!--								<a href="#" class="nav-link">-->
					<!--									India-->
					<!--									<span class="float-right text-success">-->
					<!--                        <i class="fas fa-arrow-up text-sm"></i> 4%-->
					<!--                      </span>-->
					<!--								</a>-->
					<!--							</li>-->
					<!--							<li class="nav-item">-->
					<!--								<a href="#" class="nav-link">-->
					<!--									China-->
					<!--									<span class="float-right text-warning">-->
					<!--                        <i class="fas fa-arrow-left text-sm"></i> 0%-->
					<!--                      </span>-->
					<!--								</a>-->
					<!--							</li>-->
					<!--						</ul>-->
					<!--					</div>-->
					<!-- /.footer -->
				</div>
				<!-- /.card -->

			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div>
</section>
<!--END SECTION CONTENT-->

<script src="<?= base_url('assets') ?>/dist/js/vendor/chart.js/Chart.min.js"></script>
<script src="<?= base_url('assets') ?>/dist/js/vendor/chart.js/chartjs-plugin-colorschemes.min.js"></script>
<script>
	$(function () {
		$('#tableTemuan').DataTable({
			paging: true,
			lengthChange: true,
			searching: true,
			ordering: true,
			info: true,
			autoWidth: false,
			responsive: true,
			processing: true,
			serverSide: false,
			ajax: {
				url: "<?=base_url('Laporan_Temuan/list_temuan') ?>",
				dataSrc: '',
			},
			columns: [
				{
					data: 'image',
					"render": function (data) {
						return '<img src="' + data + '" class="img-thumbnail" width="100px">';
					}
				},
				{data: 'object_id'},
				{data: 'nama_objek'},
				{data: 'description'},
				{data: 'date_patroli'},
				{data: 'nama_shift'}
			]
		});
	});
</script>
<script>
	$(document).ready(function () {
		$.ajax({
			url: "<?=base_url('Laporan_Temuan/temuan_plant') ?>",
			method: "GET",
			success: function (data) {
				// console.log(data);
				let label = [];
				let dataset_ = []
				Object.keys(data).forEach(plant_name => {
					Object.keys(data[plant_name]).forEach(key => {
						label.push(data[plant_name][key]['x'])
					})
					console.log(data[plant_name])
					let ds = {
						label: plant_name,
						data: data[plant_name],
					}
					dataset_.push(ds)
				});
				$("#chart_start_date").text(label[0])
				$("#chart_end_date").text(label[label.length - 1])
				var ctx = document.getElementById('salesChart').getContext('2d');
				var chart = new Chart(ctx, {
					type: 'line',
					data: {
						labels: label,
						datasets: dataset_
					},
					options: {
						maintainAspectRatio: false,
						responsive: true,
						legend: {
							display: true
						},
						scales: {
							xAxes: [{
								gridLines: {
									display: false
								}
							}],
							yAxes: [{
								gridLines: {
									display: false
								}
							}]
						},
						plugins: {
							colorschemes: {
								scheme: 'brewer.DarkTwo5',
							}

						}
					}
				});
			}
		});
	});
</script>
<!--<script>-->
<!--	const salesChartCanvas = $('#salesChart').get(0).getContext('2d');-->
<!---->
<!--	const salesChartData = {-->
<!--		labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],-->
<!--		datasets: [-->
<!--			{-->
<!--				label: 'Digital Goods',-->
<!--				backgroundColor: 'rgba(60,141,188,0.9)',-->
<!--				borderColor: 'rgba(60,141,188,0.8)',-->
<!--				pointRadius: false,-->
<!--				pointColor: '#3b8bba',-->
<!--				pointStrokeColor: 'rgba(60,141,188,1)',-->
<!--				pointHighlightFill: '#fff',-->
<!--				pointHighlightStroke: 'rgba(60,141,188,1)',-->
<!--				data: [28, 48, 40, 19, 86, 27, 90]-->
<!--			},-->
<!--			{-->
<!--				label: 'Electronics',-->
<!--				backgroundColor: 'rgba(210, 214, 222, 1)',-->
<!--				borderColor: 'rgba(210, 214, 222, 1)',-->
<!--				pointRadius: false,-->
<!--				pointColor: 'rgba(210, 214, 222, 1)',-->
<!--				pointStrokeColor: '#c1c7d1',-->
<!--				pointHighlightFill: '#fff',-->
<!--				pointHighlightStroke: 'rgba(220,220,220,1)',-->
<!--				data: [65, 59, 80, 81, 56, 55, 40]-->
<!--			}-->
<!--		]-->
<!--	};-->
<!---->
<!--	const salesChartOptions = {-->
<!--		maintainAspectRatio: false,-->
<!--		responsive: true,-->
<!--		legend: {-->
<!--			display: true-->
<!--		},-->
<!--		scales: {-->
<!--			xAxes: [{-->
<!--				gridLines: {-->
<!--					display: false-->
<!--				}-->
<!--			}],-->
<!--			yAxes: [{-->
<!--				gridLines: {-->
<!--					display: false-->
<!--				}-->
<!--			}]-->
<!--		}-->
<!--	};-->

<!--	// This will get the first returned node in the jQuery collection.-->
<!--	// eslint-disable-next-line no-unused-vars-->
<!--	const salesChart = new Chart(salesChartCanvas, {-->
<!--			type: 'line',-->
<!--			data: salesChartData,-->
<!--			options: salesChartOptions-->
<!--		}-->
<!--	);-->
<!---->
<!--	//----------------------------->
<!--	// - END MONTHLY SALES CHART --->
<!--	//----------------------------->
<!---->
<!--	//--------------->
<!--	// - PIE CHART --->
<!--	//--------------->
<!--	// Get context with jQuery - using jQuery's .get() method.-->
<!--	const pieChartCanvas = $('#pieChart').get(0).getContext('2d');-->
<!--	const pieData = {-->
<!--		labels: [-->
<!--			'Chrome',-->
<!--			'IE',-->
<!--			'FireFox',-->
<!--			'Safari',-->
<!--			'Opera',-->
<!--			'Navigator'-->
<!--		],-->
<!--		datasets: [-->
<!--			{-->
<!--				data: [700, 500, 400, 600, 300, 100],-->
<!--				backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de']-->
<!--			}-->
<!--		]-->
<!--	};-->
<!--	const pieOptions = {-->
<!--		legend: {-->
<!--			display: false-->
<!--		}-->
<!--	};-->
<!--	// Create pie or douhnut chart-->
<!--	// You can switch between pie and douhnut using the method below.-->
<!--	// eslint-disable-next-line no-unused-vars-->
<!--	const pieChart = new Chart(pieChartCanvas, {-->
<!--		type: 'doughnut',-->
<!--		data: pieData,-->
<!--		options: pieOptions-->
<!--	});-->
<!---->
<!--</script>-->

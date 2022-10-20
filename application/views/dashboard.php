<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Dashboard</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
				</ol>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<!-- Default box -->
				<div class="card">
					<div class="card-header">
						<h3 class="card-title"></h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
								<i class="fas fa-minus"></i>
							</button>
							<!-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
								<i class="fas fa-times"></i>
							</button> -->
						</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-12 col-sm-6 col-md-3">
								<div class="info-box">
									<span class="info-box-icon bg-gradient-danger elevation-1"><i
												class="fa fa-bell"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Temuan Hari Ini</span>
										<span class="info-box-number"><?= $data_temuan->temuan_hari_ini ?></span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
							<!-- /.col -->
							<div class="col-12 col-sm-6 col-md-3">
								<div class="info-box mb-3">
									<span class="info-box-icon bg-danger elevation-1"><i
												class="fas fa-exclamation-triangle"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Total Temuan</span>
										<span class="info-box-number"><?= $data_temuan->total_temuan ?></span>
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
									<span class="info-box-icon bg-success elevation-1"><i
												class="fas fa-check-square"></i></span>

									<div class="info-box-content">
										<span class="info-box-text">Tindakan Cepat</span>
										<span class="info-box-number"><?= $data_temuan->tindakan_cepat ?></span>
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
										<span class="info-box-number"><?= $data_temuan->laporkan_pic ?></span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
							<!-- /.col -->
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<!-- /.card-header -->
									<div class="card-body">
										<div class="row my-5">
											<div class="col-md-6 px-5">
												<p class="text-center">
													<strong>Grafik Temuan <br/>Periode Tahun <?= $year; ?></strong>
												</p>

												<div class="chart">
													<canvas id="chartTemuan" style="height: 300px;"></canvas>
												</div>
												<!-- /.chart-responsive -->
											</div>
											<div class="col-md-6 px-5">
												<p class="text-center">
													<strong>Performance Patroli <br/>Periode Tahun <?= $year; ?>
													</strong>
												</p>

												<div class="chart" style="">
													<canvas id="chartPatroli" style="height: 300px;"></canvas>
												</div>
												<!-- /.chart-responsive -->
											</div>
										</div>
										<div class="row mb-5">
											<div class="col-md-6">
												<p class="text-center">
													<strong>Temuan Group Per Plant <br/> Periode Tahun <?= $year; ?>
													</strong>
												</p>

												<div class="chart">
													<canvas id="chartTemuanByUser" style="height: 300px;"></canvas>
												</div>
												<!-- /.chart-responsive -->
											</div>
											<!-- /.col -->
											<div class="col-md-6">
												<p class="text-center">
													<strong>Temuan Berdasarkan kategori objek</strong>
												</p>
												<div class="mt-5 px-5">
													<?php
													foreach ($by_kategori_objek as $item) {
														?>
														<div class="progress-group">
															<?= $item->plant_name ?> - <?= $item->kategori_name ?>
															<span class="float-right"><b><?= $item->total_temuan ?></b>/<?= $item->total_objek ?></span>
															<div class="progress progress-sm">
																<div class="progress-bar bg-primary"
																	 style="width: <?= $item->percentage ?>%"></div>
															</div>
														</div>
														<!-- /.progress-group -->
														<?php
													}
													?>
												</div>

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
													<h5 class="description-header"><?= $data_temuan->temuan_selesai ?></h5>
													<span class="description-text">TEMUAN SELESAI</span>
												</div>
												<!-- /.description-block -->
											</div>
											<!-- /.col -->
											<div class="col-sm-3 col-6">
												<div class="description-block border-right">
													<h5 class="description-header"><?= $data_temuan->temuan_belum_selesai ?></h5>
													<span class="description-text">TEMUAN BELUM SELESAI</span>
												</div>
												<!-- /.description-block -->
											</div>
											<!-- /.col -->
											<div class="col-sm-3 col-6">
												<div class="description-block border-right">
													<h5 class="description-header">0</h5>
													<span class="description-text">TOTAL </span>
												</div>
												<!-- /.description-block -->
											</div>
											<!-- /.col -->
											<div class="col-sm-3 col-6">
												<div class="description-block">
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
					</div>
					<!-- /.card-footer-->
				</div>
				<!-- /.card -->
			</div>
		</div>
	</div>
</section>

<script src="<?= base_url('assets') ?>/dist/js/vendor/chart.js/Chart.min.js"></script>
<script src="<?= base_url('assets') ?>/dist/js/vendor/chart.js/chartjs-plugin-colorschemes.min.js"></script>
<script>
	$(document).ready(function () {
		var MONTHS = [
			'JAN',
			'FEB',
			'MAR',
			'APR',
			'MEI',
			'JUN',
			'JUL',
			'AGU',
			'SEP',
			'OKT',
			'NOV',
			'DES'
		];

		$.ajax({
			url: "<?=base_url('Dashboard/temuan_plant') ?>",
			method: "GET",
			success: function (data) {
				let dataset_ = []
				Object.keys(data).forEach(plant_name => {
					let ds = {
						label: plant_name,
						data: data[plant_name],
					}
					dataset_.push(ds)
				});

				const ctx = document.getElementById('chartTemuan').getContext('2d');
				ctx.height = 300;

				const chartTemuan = new Chart(ctx, {
					type: 'line',
					data: {
						labels: MONTHS,
						datasets: dataset_
					},
					options: {
						maintainAspectRatio: true,
						responsive: true,
						legend: {
							display: true
						},
						scales: {
							xAxes: [{
								gridLines: {
									display: true
								}
							}],
							yAxes: [{
								gridLines: {
									display: false
								},
								ticks: {
									beginAtZero: true,
									// stepSize: 1
								}
							}]
						},
						tooltips: {
							callbacks: {
								title: function (tooltipItem, data) {
									return data.datasets[tooltipItem[0].datasetIndex].data[0].x;
								}
							}
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
		$.ajax({
			url: "<?=base_url('Dashboard/patroli_plant') ?>",
			method: "GET",
			success: function (data) {
				let label = [];
				let dataset_ = []
				Object.keys(data).forEach(plant_name => {
					let ds = {
						label: plant_name,
						data: data[plant_name],
					}
					dataset_.push(ds)
				});
				label.sort(function (a, b) {
					return new Date(a) - new Date(b);
				});

				const chartPatroli = document.getElementById('chartPatroli').getContext('2d');
				const chart = new Chart(chartPatroli, {
					type: 'line',
					data: {
						labels: MONTHS,
						datasets: dataset_
					},
					options: {
						maintainAspectRatio: true,
						responsive: true,
						legend: {
							display: true
						},
						scales: {
							xAxes: [{
								gridLines: {
									display: true
								}
							}],
							yAxes: [{
								gridLines: {
									display: false
								},
								ticks: {
									beginAtZero: true,
									stepSize: 1
								}
							}]
						},
						tooltips: {
							callbacks: {
								title: function (tooltipItem, data) {
									return data.datasets[tooltipItem[0].datasetIndex].data[0].x;
								}
							}
						},
						plugins: {
							colorschemes: {
								scheme: 'brewer.DarkTwo5',
							},
						}
					}
				});
			}
		});
		$.ajax({
			url: "<?=base_url('Dashboard/listPatroliByUser') ?>",
			method: "GET",
			success: function (data) {
				let dataset_ = data.datasets

				// Object.keys(data).forEach(key => {
				// 	let ds = {
				// 		label: data[key]['labels'],
				// 		data: data[key]['data']
				// 	}
				// 	dataset_.push(ds)
				// });
				console.log(dataset_)
				const chartTemuanByUser = document.getElementById('chartTemuanByUser').getContext('2d');
				const chart = new Chart(chartTemuanByUser, {
					type: 'bar',
					data: {
						labels: MONTHS,
						datasets: dataset_
						// labels: [2017, 2018, 2019, 2020, 2021, 2022, 2023],
						// datasets: [{
						// 	label: "Income - Base",
						// 	type: "bar",
						// 	stack: "Base",
						// 	backgroundColor: "#eece01",
						// 	data: [30, 31, 32, 33, 34, 35, 36],
						// }, {
						// 	label: "Tax - Base",
						// 	type: "bar",
						// 	stack: "Base",
						// 	backgroundColor: "#87d84d",
						// 	data: [-15, -16, -17, -18, -19, -20, -21],
						// }, {
						// 	label: "Income - Sensitivity",
						// 	type: "bar",
						// 	stack: "Sensitivity",
						// 	backgroundColor: "#f8981f",
						// 	data: [20, 21, 22, 23, 24, 25, 26],
						// }, {
						// 	label: "Tax - Sensitivity",
						// 	type: "bar",
						// 	stack: "Sensitivity",
						// 	backgroundColor: "#00b300",
						// 	backgroundColorHover: "#3e95cd",
						// 	data: [-10, -11, -12, -13, -14, -15, -16]
						// }]
					},
					options: {
						maintainAspectRatio: true,
						responsive: true,
						legend: {
							display: true
						},
						scales: {
							xAxes: [{
								stacked: true,
								gridLines: {
									display: true
								}
							}],
							yAxes: [{
								stacked: true,
								gridLines: {
									display: false
								},
								ticks: {
									beginAtZero: true,
									// stepSize:
								}
							}]
						},
						// tooltips: {
						// 	callbacks: {
						// 		title: function (tooltipItem, data) {
						// 			return data.datasets[tooltipItem[0].datasetIndex].data[0].x;
						// 		}
						// 	}
						// },
						plugins: {
							colorschemes: {
								scheme: 'brewer.DarkTwo5',
							},
						}
					}
				});
			}
		});
	});
</script>


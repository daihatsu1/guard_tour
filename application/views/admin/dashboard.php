<style xmlns="http://www.w3.org/1999/html">
	.ui-datepicker-calendar {
		display: none;
	}

	.ui-datepicker {
		padding-bottom: 0.2em !important;
		font-size: 10px;
	}
</style>
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
			<div class="col-md-6">
				<div class="card">
					<!-- /.card-header -->
					<div class="card-body">
						<div class="">
							<p class="text-center mb-2">
								<strong>Grafik Temuan <br/>Periode Tahun <?= $year; ?></strong>
							</p>

							<div class="chart">
								<canvas id="chartTemuan" style="height: 300px;"></canvas>
							</div>
							<!-- /.chart-responsive -->
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-body">
						<div class="">
							<p class="text-center mb-2">
								<strong>Performance Patroli <br/>Periode Tahun <?= $year; ?>
								</strong>
							</p>

							<div class="chart" style="">
								<canvas id="chartPatroli" style="height: 300px;"></canvas>
							</div>
							<!-- /.chart-responsive -->
						</div>
					</div>
				</div>

			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<p class="text-center mb-2">
									<strong>Temuan Group Per Plant
									</strong>
								</p>
								<div class="d-flex justify-content-center mb-2 month-picker"
									 data-chart="chartTemuanByUser" data-action="ajaxListPatroliByUser">
								</div>

								<div class="chart">
									<canvas id="chartTemuanByUser" style="height: 300px;"></canvas>
								</div>
								<!-- /.chart-responsive -->
							</div>
							<!-- /.col -->
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<p class="text-center mb-2">
									<strong>Patroli Group Per Plant
									</strong>
								</p>
								<div class="d-flex justify-content-center mb-2 month-picker"
									 data-chart="chartPatroliByUser" data-action="ajaxListPatroliByUser">
								</div>

								<div class="chart">
									<canvas id="chartPatroliByUser" style="height: 300px;"></canvas>
								</div>
								<!-- /.chart-responsive -->
							</div>
							<!-- /.col -->
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
					<div class="card-body">
						<p class="text-center mb-2">
							<strong>Temuan Berdasarkan Plant
							</strong>
						</p>
						<div class="d-flex justify-content-center mb-2 month-picker"
							 data-chart="chartTemuanbyPlant" data-action="ajaxTemuanbyPlant">
						</div>

						<div class="chart">
							<canvas id="chartTemuanbyPlant" style="height: 300px;"></canvas>
						</div>
					</div>
				</div>
				<!-- /.chart-responsive -->
			</div>

		</div>
		<div class="row">
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<p class="text-center mb-2">
							<strong>Temuan Berdasarkan Kategori object
							</strong>
						</p>
						<div class="d-flex justify-content-center mb-2 month-picker"
							 data-chart="chartTemuanByKategori"
							 data-action="ajaxTemuanKategori">
						</div>

						<div class="chart">
							<canvas id="chartTemuanByKategori" style="height: 300px;"></canvas>
						</div>
					</div>
				</div>
				<!-- /.chart-responsive -->
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<p class="text-center mb-2">
							<strong>Temuan Berdasarkan Zona
							</strong>
						</p>
						<div class="d-flex justify-content-center mb-2 month-picker"
							 data-chart="chartTemuanZone"
							 data-action="ajaxTemuanZone">
						</div>

						<div class="chart">
							<canvas id="chartTemuanZone" style="height: 300px;"></canvas>
						</div>
						<!-- /.chart-responsive -->
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<p class="text-center mb-2">
							<strong>Tren Temuan
							</strong>
						</p>
						<div class="d-flex justify-content-center mb-2 month-picker"
							 data-chart="chartTrenTemuan"
							 data-action="ajaxTrenTemuan">
						</div>

						<div class="chart">
							<canvas id="chartTrenTemuan" style="height: 300px;"></canvas>
						</div>
						<!-- /.chart-responsive -->
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<p class="text-center mb-2">
							<strong>Tren Patroli
							</strong>
						</p>
						<div class="d-flex justify-content-center mb-2 month-picker"
							 data-chart="chartTrenPatroli"
							 data-action="ajaxTrenPatroli">
						</div>

						<div class="chart">
							<canvas id="chartTrenPatroli" style="height: 300px;"></canvas>
						</div>
						<!-- /.chart-responsive -->
					</div>
				</div>
			</div>
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
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
		integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
		crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="<?= base_url('assets') ?>/dist/js/vendor/chart.js/Chart.min.js"></script>
<script src="<?= base_url('assets') ?>/dist/js/vendor/chart.js/chartjs-plugin-colorschemes.min.js"></script>
<script>
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

	// TEMUAN
	const ctxChartTemuan = document.getElementById('chartTemuan').getContext('2d');
	ctxChartTemuan.height = 300;

	const chartTemuan = new Chart(ctxChartTemuan, {
		type: 'line',
		data: {},
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

	function ajaxTemuanPlant() {
		$.ajax({
			url: "<?=base_url('Admin/Dashboard/temuan_plant') ?>",
			method: "GET",
			success: function (data) {
				if (data) {
					let dataset_ = []
					Object.keys(data).forEach(plant_name => {
						let ds = {
							label: 'TOTAL TEMUAN',
							data: data[plant_name],
						}
						dataset_.push(ds)
					});
					chartTemuan.data = {datasets: dataset_, labels: MONTHS}
					chartTemuan.update()
				}
			}
		});

	}

	// PATROLI
	const ctxChartPatroli = document.getElementById('chartPatroli').getContext('2d');
	const chartPatroli = new Chart(ctxChartPatroli, {
		type: 'line',
		data: {},
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

	function ajaxPatroliPlant() {
		$.ajax({
			url: "<?=base_url('Admin/Dashboard/patroli_plant') ?>",
			method: "GET",
			success: function (data) {
				if (data) {
					let label = [];
					let dataset_ = []
					Object.keys(data).forEach(plant_name => {
						let ds = {
							label: 'TOTAL PATROLI',
							data: data[plant_name],
						}
						dataset_.push(ds)
					});
					label.sort(function (a, b) {
						return new Date(a) - new Date(b);
					});
					chartPatroli.data = {datasets: dataset_, labels: MONTHS}
					chartPatroli.update();
				}
			}
		});
	}

	//   PATROL GROUP
	const ctxChartPatroliByUser = document.getElementById('chartPatroliByUser').getContext('2d');
	const chartPatroliByUser = new Chart(ctxChartPatroliByUser, {
		type: 'bar',
		data: {},
		options: {
			maintainAspectRatio: false,
			responsive: true,
			legend: {
				display: true,
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
						stepSize: 1
					}
				}]
			},
			plugins: {
				colorschemes: {
					scheme: 'brewer.DarkTwo5',
				},
			}
		}
	});

	function ajaxListPatroliByUser(params) {
		$.ajax({
			url: "<?=base_url('Admin/Dashboard/listPatroliByUser') ?>",
			method: "GET",
			data: params,
			success: function (data) {
				chartPatroliByUser.data = data
				chartPatroliByUser.update()
			}
		});
	}

	const ctxChartTemuanByUser = document.getElementById('chartTemuanByUser').getContext('2d');
	const chartTemuanByUser = new Chart(ctxChartTemuanByUser, {
		type: 'bar',
		data: {},
		options: {
			maintainAspectRatio: false,
			responsive: true,
			legend: {
				display: true,
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
						stepSize: 1
					}
				}]
			},
			plugins: {
				colorschemes: {
					scheme: 'brewer.DarkTwo5',
				},
			}
		}
	});

	function ajaxListTemuanByUser(params) {
		$.ajax({
			url: "<?=base_url('Admin/Dashboard/listTemuanByUser') ?>",
			method: "GET",
			data: params,
			success: function (data) {
				chartTemuanByUser.data = data
				chartTemuanByUser.update()
			}
		});
	}

	// PLANT
	const ctxChartTemuanbyPlant = document.getElementById('chartTemuanbyPlant').getContext('2d');
	const chartTemuanbyPlant = new Chart(ctxChartTemuanbyPlant, {
		type: 'bar',
		data: {},
		options: {
			maintainAspectRatio: false,
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

	function ajaxTemuanByPlant(params) {
		$.ajax({
			url: "<?=base_url('Admin/Dashboard/temuanTindakanPlant') ?>",
			method: "GET",
			data: params,
			success: function (data) {
				chartTemuanbyPlant.data = data
				chartTemuanbyPlant.update()
			}
		});
	}

	//  TEMUAN BY KATEGORI
	const ctxChartTemuanByKategori = document.getElementById('chartTemuanByKategori').getContext('2d');
	const chartTemuanByKategori = new Chart(ctxChartTemuanByKategori, {
		data: {},
		options: {
			maintainAspectRatio: false,
			responsive: true,
			legend: {
				display: true,
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
					}
				}]
			},
			plugins: {
				colorschemes: {
					scheme: 'brewer.DarkTwo5',
				},
			}
		}
	});

	function ajaxTemuanKategori(params) {
		$.ajax({
			url: "<?=base_url('Admin/Dashboard/temuan_kategori') ?>",
			method: "GET",
			data: params,
			success: function (data) {
				chartTemuanByKategori.data = data
				chartTemuanByKategori.update()
			}
		});
	}

	//  TEMUAN BY KATEGORI
	const ctxChartTemuanZone = document.getElementById('chartTemuanZone').getContext('2d');
	const chartTemuanZone = new Chart(ctxChartTemuanZone, {
		data: {},
		options: {
			maintainAspectRatio: false,
			responsive: true,
			legend: {
				display: true,
			},
			tooltips: {
				intersect: false
			},
			scales: {
				barValueSpacing: 0.5,
				xAxes: [{
					gridLines: {
						display: false,
						offsetGridLines: true,
					},
					ticks: {
						scaleBeginAtZero: false
					},
					offset: true,
				}],
				yAxes: [{
					gridLines: {
						display: true
					},
					ticks: {
						beginAtZero: true,
						stepSize: 1
					}
				}]
			},
			plugins: {
				colorschemes: {
					scheme: 'brewer.DarkTwo5',
				},
			}
		}
	});

	function ajaxTemuanZone(params) {
		$.ajax({
			url: "<?=base_url('Admin/Dashboard/temuan_zone') ?>",
			method: "GET",
			data: params,
			success: function (data) {
				chartTemuanZone.data = data
				chartTemuanZone.update()
				console.log(chartTemuanZone)
			}
		});
	}

	//  TEMUAN BY KATEGORI
	const ctxChartTrenTemuan = document.getElementById('chartTrenTemuan').getContext('2d');
	const chartTrenTemuan = new Chart(ctxChartTrenTemuan, {
		data: {},
		options: {
			maintainAspectRatio: false,
			responsive: true,
			legend: {
				display: true,
			},
			tooltips: {
				intersect: false
			},
			scales: {
				xAxes: [{
					gridLines: {
						display: false,
						offsetGridLines: true,
					},
					ticks: {
						scaleBeginAtZero: false
					},
					offset: true,
				}],
				yAxes: [{
					gridLines: {
						display: true
					},
					ticks: {
						beginAtZero: true,
						stepSize: 1
					}
				}]
			},
			plugins: {
				colorschemes: {
					scheme: 'brewer.DarkTwo5',
				},
			}
		}
	});

	function ajaxTrenTemuan(params) {
		$.ajax({
			url: "<?=base_url('Admin/Dashboard/tren_temuan') ?>",
			method: "GET",
			data: params,
			success: function (data) {
				chartTrenTemuan.data = data
				chartTrenTemuan.update()
				console.log(chartTrenTemuan)
			}
		});
	}

	//  TEMUAN BY KATEGORI
	const ctxChartTrenPatroli = document.getElementById('chartTrenPatroli').getContext('2d');
	const chartTrenPatroli = new Chart(ctxChartTrenPatroli, {
		data: {},
		options: {
			maintainAspectRatio: false,
			responsive: true,
			legend: {
				display: true,
			},
			tooltips: {
				intersect: false
			},
			scales: {
				xAxes: [{
					gridLines: {
						display: false,
						offsetGridLines: true,
					},
					ticks: {
						scaleBeginAtZero: false
					},
					offset: true,
				}],
				yAxes: [{
					max: 100,
					gridLines: {
						display: true
					},
					ticks: {
						beginAtZero: true,
						max: 100,
					}
				}]
			},
			plugins: {
				colorschemes: {
					scheme: 'brewer.DarkTwo5',
				},
			}
		}
	});

	function ajaxTrenPatroli(params) {
		$.ajax({
			url: "<?=base_url('Admin/Dashboard/tren_patroli') ?>",
			method: "GET",
			data: params,
			success: function (data) {
				chartTrenPatroli.data = data
				chartTrenPatroli.update()
				console.log(chartTrenTemuan)
			}
		});
	}

	$(document).ready(function () {
		$('.month-picker').each(function (i, v) {
			let container = $(v)
			let dataChartID = container.data('chart')
			let filterPlant = container.data('filterplant')
			let action = container.data('action')

			let altField = $('<input>').attr({
				type: 'hidden',
				id: 'filter_input_' + dataChartID,
				name: 'filter_input_' + dataChartID,
			}).appendTo(container);

			let pickerContainer = jQuery('<div>', {
				id: 'filter_' + dataChartID,
			})
			pickerContainer.appendTo(container);

			let picker = $(pickerContainer).datepicker({
				changeMonth: true,
				changeYear: true,
				inline: true,
				showButtonPanel: false,
				dateFormat: 'm yy',
				altField: altField,
				onChangeMonthYear: function (year, month, inst) {
					$(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
				}
			});
			if (filterPlant) {
				let sel = $('<select>', {
					id: 'filter_plant_btn_' + dataChartID,
					class: 'custom-select custom-select-sm ml-2 w-auto',
				}).appendTo(container);
				<?php
				foreach ($plants->result() as $plant) {
				?>
				sel.append($("<option>").attr('value', '<?=$plant->plant_id?>').text('<?=$plant->plant_name?>'));
				<?php } ?>
			}

			let btnFilter = $('<button/>',
				{
					id: 'filter_btn_' + dataChartID,
					class: 'btn btn-xs btn-secondary ml-2',
					text: 'FILTER',
					click: function () {
						let ajaxParams = {
							'month': $(picker).datepicker('getDate').getMonth() + 1,
							'year': $(picker).datepicker('getDate').getFullYear()
						}
						if (filterPlant) {
							ajaxParams['plantId'] = $('#filter_plant_btn_' + dataChartID).val()
						}

						if (action !== null) {
							window[action](ajaxParams);
						}
					}
				});
			btnFilter.appendTo(container)
		})

		function initChart() {
			let defaultParams = {
				'year': moment().format('Y'),
				'month': moment().format('MM'),
			}
			ajaxTemuanPlant()
			ajaxPatroliPlant()
			ajaxListPatroliByUser(defaultParams)
			ajaxTemuanPlant(defaultParams)
			ajaxTemuanByPlant(defaultParams)
			ajaxListTemuanByUser(defaultParams)
			ajaxTemuanKategori(defaultParams)
			ajaxTemuanZone(defaultParams)
			ajaxTrenTemuan(defaultParams)
			ajaxTrenPatroli(defaultParams)
		}

		initChart()
	});
</script>


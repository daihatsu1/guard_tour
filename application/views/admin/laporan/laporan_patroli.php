<style>
	.table td {
		vertical-align: middle !important;
		padding: 5px 12px;
	}

	.table thead th {
		vertical-align: middle !important;
		/*padding: 0;*/

	}
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<!-- START SECTION HEADER -->
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Laporan Patroli</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Laporan</a></li>
					<li class="breadcrumb-item"><a href="<?= base_url('Laporan_Patroli') ?>">Laporan Patroli</a></li>
				</ol>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>
<!-- END SECTION HEADER -->

<!--START SECTION CONTENT-->
<section class="content">
	<div class="container-fluid">
		<!-- Main row -->
		<div class="row">
			<!-- Left col -->
			<div class="col-md-12">
				<div class="row justify-content-center">
					<div class="card col-6 ">
						<!-- /.card-header -->
						<div class="card-body p-4">
							<div class="row justify-content-center">
								<div class="col-lg-4">
									<div class="form-group">
										<label for="">PLANT</label>
										<select name="plant" class="form-control" id="plant">
											<option value="">--- Pilih Plant ---</option>
											<?php foreach ($plant->result() as $pl) :
												if ($pl->plant_id == $plant_id) { ?>
													<option selected value="<?= $pl->plant_id ?>"><?= $pl->plant_name ?></option>
												<?php } else { ?>
													<option value="<?= $pl->plant_id ?>"><?= $pl->plant_name ?></option>
											<?php }
											endforeach ?>
										</select>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="reportrange">TANGGAL</label>
										<input type="text" id="reportrange" class="form-control">
										<!--										<input type="text" class="form-control" id="date-range">-->
									</div>
								</div>

								<div class="col-lg-2">
									<div style="margin-top: 10px;position:absolute" class="form-group">
										<button name="filter" id="filter" class="btn btn-primary btn-sm mt-4"><i class="fa fa-search"></i> FILTER
										</button>
									</div>
								</div>
							</div>
						</div>
						<!-- /.card-footer -->
					</div>
				</div>

				<div class="card">
					<div class="card-header border-transparent">
						<h3 class="card-title">Laporan Patroli</h3>
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
							<table class="table m-0 table-hover" id="tablePatroli" style="width: 100%">
								<thead>
									<tr>
										<th>Tgl Patroli</th>
										<th>Shift</th>
										<th>Plant</th>
										<th>NPK</th>
										<th>Pelaksana</th>
										<th>Mulai</th>
										<th>Selesai</th>
										<th>Total Temuan</th>
										<th>Durasi</th>
										<th>Total Checkpoint</th>
										<th>Completion</th>
										<th>Detail</th>
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

				<div class="card">
					<div class="card-header border-transparent">
						<h3 class="card-title">Laporan Patroli Diluar Jadwal</h3>
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
							<table class="table table-sm m-0 table-hover" id="tablePatroliDiluarJadwal" style="width: 100%">
								<thead>
									<tr>
										<th>Tgl Patroli</th>
										<th>Shift</th>
										<th>Plant</th>
										<th>NPK</th>
										<th>Pelaksana</th>
										<th>Mulai</th>
										<th>Selesai</th>
										<th>Total Temuan</th>
										<th>Durasi</th>
										<th>Total Checkpoint</th>
										<th>Completion</th>
										<th>Detail</th>
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
		</div>
		<!-- /.row -->
	</div>
</section>
<!--END SECTION CONTENT-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
	$(function() {
		moment.locale('id'); // id
		var start = moment().subtract(2, 'days');
		var end = moment();

		$('#reportrange').daterangepicker({
			"autoApply": true,
			ranges: {
				'Hari Ini': [moment(), moment()],
				'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'7 hari terakhir': [moment().subtract(6, 'days'), moment()],
				'30 hari terakhir': [moment().subtract(29, 'days'), moment()],
				'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
			},
			"locale": {
				"format": "LL",
				"separator": " - ",
				"applyLabel": "Apply",
				"cancelLabel": "Cancel",
				"fromLabel": "Dari",
				"toLabel": "Sampai",
				"customRangeLabel": "Custom",
				"weekLabel": "W",
				"daysOfWeek": [
					"Min",
					"Sen",
					"Sel",
					"Rab",
					"Kam",
					"Jum",
					"Sab"
				],
				"monthNames": [
					"Januari",
					"Februari",
					"Maret",
					"April",
					"Mei",
					"Juni",
					"Juli",
					"Augustus",
					"September",
					"Oktober",
					"November",
					"Desember"
				],
				"firstDay": 1
			},
			"alwaysShowCalendars": true,
			"startDate": start,
			"endDate": end,
			"opens": "center",
			"drops": "auto"
		});


		function parseData(type) {
			var drp = $('#reportrange').data('daterangepicker');
			var param = {
				'start': drp.startDate.format('YYYY-MM-DD'),
				'end': drp.endDate.format('YYYY-MM-DD'),
				'plantId': $('#plant').find(":selected").val(),
				'type': type
			}
			return param
		}


		let tablePatroli = $('#tablePatroli').DataTable({
			paging: true,
			scrollX: true,
			lengthChange: true,
			searching: true,
			ordering: true,
			autoWidth: true,
			processing: true,
			serverSide: false,
			ajax: {
				url: "<?= base_url('Admin/Laporan_patroli/list_patroli') ?>",
				dataSrc: '',
				data: function() {
					var drp = $('#reportrange').data('daterangepicker');
					var param = {
						'start': drp.startDate.format('YYYY-MM-DD'),
						'end': drp.endDate.format('YYYY-MM-DD'),
						'plantId': $('#plant').find(":selected").val(),
						'type': 0
					}
					return param
				}
			},
			order: [
				[5, 'desc']
			],
			pageLength: 25,
			columns: [{
					data: 'date_patroli'
				},
				{
					data: 'nama_shift'
				},
				{
					data: 'plant_name'
				},
				{
					data: 'npk'
				},
				{
					data: 'name'
				},
				{
					data: 'start_at',
					render: function(data, type, row) {
						if (data) {
							return moment(data).format('lll')
						} else {
							return '-'
						}
					}
				},
				{
					data: 'end_at',
					render: function(data, type, row) {
						if (data) {
							return moment(data).format('lll')
						} else {
							return '-'
						}
					}
				},
				{
					data: 'total_object_temuan',
					render: function(data, type, row) {
						if (data > 0) {
							return '<span class="d-block bg-danger text-center">' + data + '</span>'
						}
						return '<span class="d-block text-center">-</span>'
					}
				},
				{
					data: null,
					render: function(data, type, row) {
						if (data.start_at == null || data.end_at == null) {
							return '-'
						}
						var start = moment(data.start_at)
						var end = moment(data.end_at)
						var duration = moment.duration(end.diff(start));
						var minutes = duration.asMinutes();
						return '<span class="d-block text-center">' + Math.round(minutes) + ' Menit</span>'
					}
				},
				{
					data: null,
					render: function(data, type, row) {
						if ((row.chekpoint_patroli !== 0) && (row.chekpoint_patroli === row.total_ckp)) {
							return '<span class="bg-success d-block text-center">' + row.chekpoint_patroli + '/' + row.total_ckp + '</span>'
						}
						if ((row.total_ckp === 0)) {
							return '<span class="bg-info d-block text-center">' + row.chekpoint_patroli + '/' + row.total_ckp + '</span>'
						}
						return '<span class="bg-danger d-block text-center">' + row.chekpoint_patroli + '/' + row.total_ckp + '</span>'
					}
				}, {
					data: null,
					render: function(data, type, row) {
						let persentage = 0
						if (row.chekpoint_patroli === 0) {
							persentage = 0
						} else if (row.total_ckp === 0) {
							persentage = '-'
						} else {
							persentage = Math.round(row.chekpoint_patroli / row.total_ckp * 100)
						}

						if (persentage === 100) {
							return '<span class="bg-success d-block text-center">' + persentage + '%</span>'
						}
						if (persentage === '-') {
							return '<span class="bg-info d-block text-center">-</span>'
						}

						return '<span class="bg-danger d-block text-center">' + persentage + '%</span>'
					}
				}, {
					data: null,
					render: function(data, type, row) {
						if (data.start_at == null || data.end_at == null) {
							return ''
						}
						return '<a href="<?= base_url('Admin/Laporan_Patroli/detail?idJadwal=') ?>' + row.id_jadwal_patroli + '&npk=' + row.npk + '&type=0" class="btn btn-sm btn-info">Detail</a>'
					}
				},
			],
			createdRow: function(row, data, dataIndex) {
				if (data.start_at === null) {
					$(row).find('td').addClass('text-danger');
				}
			}
		});

		let tablePatroliDiluarJadwal = $('#tablePatroliDiluarJadwal').DataTable({
			paging: true,
			scrollX: true,
			lengthChange: true,
			searching: true,
			ordering: true,
			autoWidth: true,
			processing: true,
			serverSide: false,
			ajax: {
				url: "<?= base_url('Admin/Laporan_patroli/list_patroli') ?>",
				dataSrc: '',
				data: function() {
					var drp = $('#reportrange').data('daterangepicker');
					var param = {
						'start': drp.startDate.format('YYYY-MM-DD'),
						'end': drp.endDate.format('YYYY-MM-DD'),
						'plantId': $('#plant').find(":selected").val(),
						'type': 1
					}
					return param
				}
			},
			order: [
				[5, 'desc']
			],
			pageLength: 25,
			columns: [{
					data: 'date_patroli'
				},
				{
					data: 'nama_shift'
				},
				{
					data: 'plant_name'
				},
				{
					data: 'npk'
				},
				{
					data: 'name'
				},
				{
					data: 'start_at',
					render: function(data, type, row) {
						if (data) {
							return moment(data).format('lll')
						} else {
							return '-'
						}
					}
				},
				{
					data: 'end_at',
					render: function(data, type, row) {
						if (data) {
							return moment(data).format('lll')
						} else {
							return '-'
						}
					}
				},
				{
					data: 'total_object_temuan',
					render: function(data, type, row) {
						if (data > 0) {
							return '<span class="d-block bg-danger text-center">' + data + '</span>'
						}
						return '<span class="d-block text-center">-</span>'
					}
				},
				{
					data: null,
					render: function(data, type, row) {
						if (data.start_at == null || data.end_at == null) {
							return '-'
						}
						var start = moment(data.start_at)
						var end = moment(data.end_at)
						var duration = moment.duration(end.diff(start));
						var minutes = duration.asMinutes();
						return '<span class="d-block text-center">' + Math.round(minutes) + ' Menit</span>'
					}
				},
				{
					data: null,
					render: function(data, type, row) {
						if ((row.chekpoint_patroli !== 0) && (row.chekpoint_patroli === row.total_ckp)) {
							return '<span class="bg-success d-block text-center">' + row.chekpoint_patroli + '/' + row.total_ckp + '</span>'
						}
						if ((row.total_ckp === 0)) {
							return '<span class="bg-info d-block text-center">' + row.chekpoint_patroli + '/' + row.total_ckp + '</span>'
						}
						return '<span class="bg-danger d-block text-center">' + row.chekpoint_patroli + '/' + row.total_ckp + '</span>'
					}
				}, {
					data: null,
					render: function(data, type, row) {
						let persentage = 0
						if (row.chekpoint_patroli === 0) {
							persentage = 0
						} else if (row.total_ckp === 0) {
							persentage = '-'
						} else {
							persentage = Math.round(row.chekpoint_patroli / row.total_ckp * 100)
						}

						if (persentage === 100) {
							return '<span class="bg-success d-block text-center">' + persentage + '%</span>'
						}
						if (persentage === '-') {
							return '<span class="bg-info d-block text-center">-</span>'
						}

						return '<span class="bg-danger d-block text-center">' + persentage + '%</span>'
					}
				}, {
					data: null,
					render: function(data, type, row) {
						return '<a href="<?= base_url('Admin/Laporan_Patroli/detail?idJadwal=') ?>' + row.id_jadwal_patroli + '&npk=' + row.npk + '&type=1" class="btn btn-sm btn-info">Detail</a>'
					}
				},
			],
			createdRow: function(row, data, dataIndex) {
				if (data.start_at === null) {
					$(row).find('td').addClass('text-danger');
				}
			}
		});
		new $.fn.dataTable.Buttons(tablePatroli, {
			buttons: [{
					text: '<i class="fa fa-files-o"></i> XLSX',
					titleAttr: 'EXCEL',
					className: 'btn btn-default btn-sm',
					action: function(e, dt, node, config) {
						var drp = $('#reportrange').data('daterangepicker');
						let start = drp.startDate.format('YYYY-MM-DD')
						let end = drp.endDate.format('YYYY-MM-DD')
						let type = 0

						window.open(
							'<?= base_url('Admin/Laporan_patroli/downloadLaporanPatroli?') ?>start=' + start + '&end=' + end + '&type=' + type,
							'_blank'
						);
					}
				},
				{
					extend: 'csv',
					text: '<i class="fa fa-files-o"></i> CSV',
					titleAttr: 'CSV',
					className: 'btn btn-default btn-sm',
					exportOptions: {
						columns: ':visible'
					},
					filename: function() {
						var d = new Date();
						return 'laporan_patroli_' + d.getTime();
					},
				},
				{
					extend: 'print',
					text: '<i class="fa fa-print"></i> Print',
					titleAttr: 'Print',
					className: 'btn btn-default btn-sm',
					exportOptions: {
						columns: ':visible'
					},

				},
			]
		});
		tablePatroli.buttons().container().appendTo('#tablePatroli_filter');
		new $.fn.dataTable.Buttons(tablePatroliDiluarJadwal, {
			buttons: [{
					text: '<i class="fa fa-files-o"></i> XLSX',
					titleAttr: 'EXCEL',
					className: 'btn btn-default btn-sm',
					action: function(e, dt, node, config) {
						var drp = $('#reportrange').data('daterangepicker');
						let start = drp.startDate.format('YYYY-MM-DD')
						let end = drp.endDate.format('YYYY-MM-DD')
						let type = 1

						window.open(
							'<?= base_url('Admin/Laporan_patroli/downloadLaporanPatroli?') ?>start=' + start + '&end=' + end + '&type=' + type,
							'_blank'
						);
					}
				},
				{
					extend: 'csv',
					text: '<i class="fa fa-files-o"></i> CSV',
					titleAttr: 'CSV',
					className: 'btn btn-default btn-sm',
					exportOptions: {
						columns: ':visible'
					},
					filename: function() {
						var d = new Date();
						return 'laporan_patroli_diluarjadwal' + d.getTime();
					},
				},
				{
					extend: 'print',
					text: '<i class="fa fa-print"></i> Print',
					titleAttr: 'Print',
					className: 'btn btn-default btn-sm',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
					},

				},
			]
		});
		tablePatroliDiluarJadwal.buttons().container().appendTo('#tablePatroliDiluarJadwal_filter');


		$('#filter').click(function() {
			tablePatroli.ajax.reload();
			tablePatroliDiluarJadwal.ajax.reload();
		})
	});
</script>
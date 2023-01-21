<link rel="stylesheet" href="<?= base_url('assets') ?>/dist/js/vendor/lightbox.js/css/lightbox.css">

<!-- START SECTION HEADER -->
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Abnormality</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Laporan</a></li>
					<li class="breadcrumb-item"><a href="<?= base_url('Laporan_Abnormal') ?>">Abnormality</a></li>
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
				<!-- TABLE: LATEST ORDERS -->
				<div class="card">
					<div class="card-header border-transparent">
						<h3 class="card-title">Abnormality</h3>
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
							<table class="table table-sm m-0 table-hover" id="tableTemuan">
								<thead>
									<tr>
										<th>Foto</th>
										<th>Tanggal Patroli</th>
										<th>Shift</th>
										<th>Plant</th>
										<th>Zona</th>
										<th>Chekpoint</th>
										<th>Nama Objek</th>
										<th>Deskripsi Temuan</th>
										<th>Status</th>
										<th>Action</th>
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
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header border-transparent">
						<h3 class="card-title">Tindakan Cepat</h3>
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
							<table class="table table-sm m-0 table-hover" id="tableTemuanTindakanCepat">
								<thead>
									<tr>
										<th>Foto</th>
										<th>Tanggal Patroli</th>
										<th>Shift</th>
										<th>Plant</th>
										<th>Zona</th>
										<th>Chekpoint</th>
										<th>Nama Objek</th>
										<th>Deskripsi Temuan</th>
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
			</div>
		</div>
		<!-- /.row -->
	</div>
</section>
<!--END SECTION CONTENT-->
<script src="<?= base_url('assets') ?>/dist/js/vendor/lightbox.js/js/lightbox.js"></script>

<style>
	.table td {
		vertical-align: middle !important;
		padding: 5px 12px;
	}

	.table thead th {
		vertical-align: middle !important;

	}
</style>
<script>
	$(function() {
		let table = $('#tableTemuan').DataTable({
			paging: true,
			lengthChange: true,
			searching: true,
			ordering: true,
			info: true,
			autoWidth: false,
			responsive: true,
			processing: true,
			serverSide: false,
			pageLength: 25,
			ajax: {
				url: "<?= base_url('Admin/Laporan_Abnormal/list_temuan') ?>",
				dataSrc: '',
			},
			columns: [{
					data: 'image_1',
					"render": function(data, type, row) {
						if (data === null) {
							var ln = "<?= base_url('assets') . '/dist/img/img-not-found.png' ?>";
						} else {
							ln = "<?= base_url() ?>" + data;
						}
						return '<a href="' + ln + '"  data-lightbox="' + row.object_id + '" data-title="' + row.nama_objek + '">' +
							'<img src="' + ln + '" class="img-thumbnail" data-lightbox="' + row.object_id + '" data-title="' + row.nama_objek + '" width="50px" alt="' + row.nama_objek + '">' +
							'</a>'
					}
				},
				{
					data: 'date_patroli'
				},
				{
					data: 'nama_shift'
				},
				{
					data: 'plant_name'
				},
				{
					data: 'zone_name'
				},
				{
					data: 'checkpoint_name'
				},
				{
					data: 'nama_objek'
				},
				{
					data: 'description'
				},
				{
					data: 'status_temuan',
					render: function(data, type, row) {
						if (data === 1) {
							return '<span class="badge badge-success">CLOSE</span>'
						} else {
							return '<span class="badge badge-danger">OPEN</span>'
						}
					}
				},
				{
					data: null,
					render: function(data, type, row) {
						if (row.status_temuan === 1) {
							return '';
						}
						const actionURL = "<?= base_url('Admin/Laporan_Abnormal/update_status_temuan') ?>";
						let img = '<a href="' + row.image_1 + '"  data-lightbox="' + row.object_id + '" data-title="' + row.nama_objek + '">';

						if (row.image_1 !== null) {
							img = img + '<img src="' + row.image_1 + '" class="img-thumbnail" data-lightbox="' + row.object_id + '" data-title="' + row.nama_objek + '" width="50px" alt="' + row.nama_objek + '">';
						}
						if (row.image_2 !== null) {
							img = img + '<img src="' + row.image_2 + '" class="img-thumbnail" data-lightbox="' + row.object_id + '" data-title="' + row.nama_objek + '" width="50px" alt="' + row.nama_objek + '">';

						}
						if (row.image_3 !== null) {
							img = img + '<img src="' + row.image_3 + '" class="img-thumbnail" data-lightbox="' + row.object_id + '" data-title="' + row.nama_objek + '" width="50px" alt="' + row.nama_objek + '">';
						}
						img = img + '</a>';
						return `
							<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_` + row.trans_detail_id + `">Tindakan</button>
							<div class="modal fade" id="modal_` + row.trans_detail_id + `" tabindex="-1" role="dialog" aria-labelledby="modal_` + row.trans_detail_id + `Label" aria-hidden="true">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<form method="post" action="` + actionURL + `">
										<div class="modal-header">
											<h5 class="modal-title">Tindakan Temuan</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
										</div>
										<div class="modal-body">
											<div class="row">
												<div class="col-6">
													<p><b>Objek Temuan :</b> ` + row.nama_objek + `</br>
														<b>Deskrisi Temuan :</b> ` + row.description + `</br>
														<b>Tanggal Temuan :</b> ` + row.date_patroli + `, Shift ` + row.nama_shift + `</br>
														<b>Pelaksana :</b> ` + row.pelaksana + `</p>
												</div>
												<div class="col"><b>Lampiran :</b> ` + img + `</div>
											</div>
											<div class="form-group">
												<input type="hidden" name="trans_detail_id" value="` + row.trans_detail_id + `">
												<label for="catatan_tindakan">Catatan Tindakan</label>
												<textarea class="form-control" placeholder="Catatan Tindakan" name="catatan_tindakan" rows="3" required></textarea>
												<small class="form-text text-muted">
												  Deskripsikan tindakan penyelesaian terhadap temuan pada objek <i>` + row.nama_objek + `</i>.
												</br>Klik simpan untuk merubah status objek menjadi <b>Normal</b>
												</small>
											 </div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-primary">Simpan</button>
										</div>
									</form>
								</div>
								</div>
							</div>`;
					}
				}
			],
			initComplete: function() {
				this.api().columns([3, 5, 6, 8]).every(function() {
					let column = this;
					let select = $('<select class="form-control form-control-sm"><option value=""> -- Filter -- </option></select>')
						.appendTo($(column.header()))
						.on('change', function() {
							const val = $.fn.dataTable.util.escapeRegex($(this).val());
							column
								.search(val ? '^' + val + '$' : '', true, false)
								.draw();
						});

					column.data().unique().sort().each(function(d, j) {
						let cols = column.selector.cols
						if (cols === 8) {
							if (d === 1) {
								select.append('<option value="CLOSE">CLOSE</option>')
							} else {
								select.append('<option value="OPEN">OPEN</option>')
							}
						} else {
							select.append('<option value="' + d + '">' + d + '</option>')
						}
					});
				});
			}
		});
		new $.fn.dataTable.Buttons(table, {
			buttons: [{
					extend: 'excelHtml5',
					title: 'Data export',
					text: '<i class="fa fa-files-o"></i> XLSX',
					titleAttr: 'EXCEL',
					className: 'btn btn-default btn-sm',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7]
					},
					filename: function() {
						var d = new Date();
						return 'laporan_temuan_' + d.getTime();
					},
					customize: function(xlsx) {
						var sheet = xlsx.xl.worksheets['sheet1.xml'];

						$('row c', sheet).attr('s', '25');
						$('c[r=A1] t', sheet).text('Laporan Temuan');
						$('row:first c', sheet).attr('s', '2');
					}
				},
				{
					extend: 'csv',
					text: '<i class="fa fa-files-o"></i> CSV',
					titleAttr: 'CSV',
					className: 'btn btn-default btn-sm',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7]
					},
					filename: function() {
						var d = new Date();
						return 'laporan_temuan_' + d.getTime();
					},
				},
				{
					extend: 'print',
					text: '<i class="fa fa-print"></i> Print',
					titleAttr: 'Print',
					className: 'btn btn-default btn-sm',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7]
					}
				},
			]
		});
		table.buttons().container().appendTo('#tableTemuan_filter');

		let tableTemuanTindakanCepat = $('#tableTemuanTindakanCepat').DataTable({
			paging: true,
			lengthChange: true,
			searching: true,
			ordering: true,
			info: true,
			autoWidth: false,
			responsive: true,
			processing: true,
			serverSide: false,
			pageLength: 25,
			ajax: {
				url: "<?= base_url('Admin/Laporan_Abnormal/list_temuan_tindakan_cepat') ?>",
				dataSrc: '',
			},
			columns: [{
					data: 'image_1',
					"render": function(data, type, row) {
						if (data === null) {
							var ln = "<?= base_url('assets') . '/dist/img/img-not-found.png' ?>";
						} else {
							ln = "<?= base_url() ?>" + data;
						}
						return '<a href="' + ln + '"  data-lightbox="' + row.object_id + '" data-title="' + row.nama_objek + '">' +
							'<img src="' + ln + '" class="img-thumbnail" data-lightbox="' + row.object_id + '" data-title="' + row.nama_objek + '" width="50px" alt="' + row.nama_objek + '">' +
							'</a>'
					}
				},
				{
					data: 'date_patroli'
				},
				{
					data: 'nama_shift'
				},
				{
					data: 'plant_name'
				},
				{
					data: 'zone_name'
				},
				{
					data: 'checkpoint_name'
				},
				{
					data: 'nama_objek'
				},
				{
					data: 'description'
				}
			],
			initComplete: function() {
				this.api().columns([3, 5, 6]).every(function() {
					let column = this;
					let select = $('<select class="form-control form-control-sm"><option value=""> -- Filter -- </option></select>')
						.appendTo($(column.header()))
						.on('change', function() {
							const val = $.fn.dataTable.util.escapeRegex($(this).val());
							column
								.search(val ? '^' + val + '$' : '', true, false)
								.draw();
						});

					column.data().unique().sort().each(function(d, j) {
						let cols = column.selector.cols
						if (cols === 8) {
							if (d === 1) {
								select.append('<option value="CLOSE">CLOSE</option>')
							} else {
								select.append('<option value="OPEN">OPEN</option>')
							}
						} else {
							select.append('<option value="' + d + '">' + d + '</option>')
						}
					});
				});
			}
		});
		new $.fn.dataTable.Buttons(tableTemuanTindakanCepat, {
			buttons: [{
					extend: 'excelHtml5',
					title: 'Data export',
					text: '<i class="fa fa-files-o"></i> XLSX',
					titleAttr: 'EXCEL',
					className: 'btn btn-default btn-sm',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7]
					},
					filename: function() {
						var d = new Date();
						return 'laporan_temuan_' + d.getTime();
					},
					customize: function(xlsx) {
						var sheet = xlsx.xl.worksheets['sheet1.xml'];

						$('row c', sheet).attr('s', '25');
						$('c[r=A1] t', sheet).text('Laporan Temuan');
						$('row:first c', sheet).attr('s', '2');
					}
				},
				{
					extend: 'csv',
					text: '<i class="fa fa-files-o"></i> CSV',
					titleAttr: 'CSV',
					className: 'btn btn-default btn-sm',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7]
					},
					filename: function() {
						var d = new Date();
						return 'laporan_temuan_tindakan_cepat_' + d.getTime();
					},
				},
				{
					extend: 'print',
					text: '<i class="fa fa-print"></i> Print',
					titleAttr: 'Print',
					className: 'btn btn-default btn-sm',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7]
					}
				},
			]
		});
		tableTemuanTindakanCepat.buttons().container().appendTo('#tableTemuanTindakanCepat_filter');
	});
</script>
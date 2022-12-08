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
									<th data-filter="input">Tanggal Patroli</th>
									<th data-filter="select">Shift</th>
									<th data-filter="select">Plant</th>
									<th data-filter="select">Zona</th>
									<th data-filter="input">Chekpoint</th>
									<th data-filter="input">Nama Objek</th>
									<th data-filter="input">Deskripsi Temuan</th>
									<th data-filter="select">Status</th>
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
									<th data-filter="select">Shift</th>
									<th data-filter="select">Plant</th>
									<th data-filter="input">Zona</th>
									<th data-filter="input">Chekpoint</th>
									<th data-filter="input">Nama Objek</th>
									<th data-filter="input">Deskripsi Temuan</th>
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
	$(function () {
		$('#tableTemuan thead tr')
			.clone(true)
			.addClass('filters')
			.appendTo('#tableTemuan thead');

		$('#tableTemuanTindakanCepat thead tr')
			.clone(true)
			.addClass('filters')
			.appendTo('#tableTemuanTindakanCepat thead');

		let table = $('#tableTemuan').DataTable({
			paging: true,
			orderCellsTop: true,
			fixedHeader: true,
			lengthChange: true,
			searching: true,
			ordering: true,
			info: false,
			autoWidth: false,
			responsive: true,
			processing: true,
			serverSide: false,
			pageLength: 25,
			ajax: {
				url: "<?=base_url('Laporan_Abnormal/list_temuan') ?>",
				dataSrc: '',
			},
			columns: [
				{
					data: 'image_1',
					"render": function (data, type, row) {
						if (data === null) {
							data = "<?=base_url('assets') . '/dist/img/img-not-found.png'?>";
						}
						return '<a href="' + data + '"  data-lightbox="' + row.object_id + '" data-title="' + row.nama_objek + '">' +
							'<img src="' + data + '" class="img-thumbnail" data-lightbox="' + row.object_id + '" data-title="' + row.nama_objek + '" width="50px" alt="' + row.nama_objek + '">' +
							'</a>'
					}
				},
				{data: 'date_patroli'},
				{data: 'nama_shift'},
				{data: 'plant_name'},
				{data: 'zone_name'},
				{data: 'checkpoint_name'},
				{data: 'nama_objek'},
				{data: 'description'},
				{
					data: 'status_temuan',
					render: function (data, type, row) {
						if (data === 1) {
							return '<span class="badge badge-success">CLOSE</span>'
						} else {
							return '<span class="badge badge-danger">OPEN</span>'
						}
					}
				},
				{
					data: null,
					render: function (data, type, row) {
						if (row.status_temuan === 1) {
							return '';
						}
						const actionURL = "<?=base_url('Laporan_Abnormal/update_status_temuan') ?>";
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
			initComplete: function () {
				var api = this.api();

				function initFilterInput(api, cell, colIdx) {
					var title = $(cell).text();
					$(cell).html('<input type="text"  class="form-control form-control-sm" placeholder="' + title + '" />');
					// On every keypress in this input
					$(
						'input',
						$('.filters th').eq($(api.column(colIdx).header()).index())
					)
						.off('keyup change')
						.on('change', function (e) {
							// Get the search value
							$(this).attr('title', $(this).val());
							var regexr = '({search})'; //$(this).parents('th').find('select').val();

							var cursorPosition = this.selectionStart;
							// Search the column for that value
							api
								.column(colIdx)
								.search(
									this.value !== ''
										? regexr.replace('{search}', '(((' + this.value + ')))')
										: '',
									this.value !== '',
									this.value === ''
								)
								.draw();
						})
						.on('keyup', function (e) {
							e.stopPropagation();

							$(this).trigger('change');
							$(this)
								.focus()[0]
								.setSelectionRange(cursorPosition, cursorPosition);
						});
				}

				function initFilterSelect(api, cell, colIdx) {
					let select = $('<select class="form-control form-control-sm"><option value=""> -- Filter -- </option></select>')
						.on('change', function () {
							const val = $.fn.dataTable.util.escapeRegex($(this).val());
							api.column(colIdx)
								.search(val ? '^' + val + '$' : '', true, false)
								.draw();
						});
					$(cell).html(select);
					api.column(colIdx).data().unique().sort().each(function (d, j) {
						let cols = api.column(colIdx).selector.cols
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
				}

				// For each column
				api
					.columns()
					.eq(0)
					.each(function (colIdx) {
						// Set the header cell to contain the input element
						var cell = $('#tableTemuan .filters th').eq(
							$(api.column(colIdx).header()).index()
						);
						console.log()
						let filterType = $(cell).data("filter");
						switch (filterType) {
							case 'select':
								initFilterSelect(api, cell, colIdx)
								break;

							case 'input':
								initFilterInput(api, cell, colIdx)
								break
							default:
								console.log(colIdx, 'no filter')
								$(cell).html('')
								break;
						}
					});
			}
		});
		new $.fn.dataTable.Buttons(table, {
			buttons: [
				{
					extend: 'excelHtml5',
					title: 'Data export',
					text: '<i class="fa fa-files-o"></i> XLSX',
					titleAttr: 'EXCEL',
					className: 'btn btn-default btn-sm',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7]
					},
					filename: function () {
						var d = new Date();
						return 'laporan_temuan_' + d.getTime();
					},
					customize: function (xlsx) {
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
					filename: function () {
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
			orderCellsTop: true,
			fixedHeader: true,
			lengthChange: true,
			searching: true,
			ordering: true,
			info: false,
			autoWidth: false,
			responsive: true,
			processing: true,
			serverSide: false,
			pageLength: 25,
			ajax: {
				url: "<?=base_url('Laporan_Abnormal/list_temuan_tindakan_cepat') ?>",
				dataSrc: '',
			},
			columns: [
				{
					data: 'image_1',
					"render": function (data, type, row) {
						if (data === null) {
							data = "<?=base_url('assets') . '/dist/img/img-not-found.png'?>";
						}
						return '<a href="' + data + '"  data-lightbox="' + row.object_id + '" data-title="' + row.nama_objek + '">' +
							'<img src="' + data + '" class="img-thumbnail" data-lightbox="' + row.object_id + '" data-title="' + row.nama_objek + '" width="50px" alt="' + row.nama_objek + '">' +
							'</a>'
					}
				},
				{data: 'date_patroli'},
				{data: 'nama_shift'},
				{data: 'plant_name'},
				{data: 'zone_name'},
				{data: 'checkpoint_name'},
				{data: 'nama_objek'},
				{data: 'description'}
			],
			initComplete: function () {
				var api = this.api();
				console.log(this)

				function initFilterInput(api, cell, colIdx) {
					var title = $(cell).text();
					$(cell).html('<input type="text"  class="form-control form-control-sm" placeholder="' + title + '" />');
					// On every keypress in this input
					$(
						'input',
						$('.filters th').eq($(api.column(colIdx).header()).index())
					)
						.off('keyup change')
						.on('change', function (e) {
							// Get the search value
							$(this).attr('title', $(this).val());
							var regexr = '({search})'; //$(this).parents('th').find('select').val();

							var cursorPosition = this.selectionStart;
							// Search the column for that value
							api
								.column(colIdx)
								.search(
									this.value !== ''
										? regexr.replace('{search}', '(((' + this.value + ')))')
										: '',
									this.value !== '',
									this.value === ''
								)
								.draw();
						})
						.on('keyup', function (e) {
							e.stopPropagation();

							$(this).trigger('change');
							$(this)
								.focus()[0]
								.setSelectionRange(cursorPosition, cursorPosition);
						});
				}

				function initFilterSelect(api, cell, colIdx) {
					let select = $('<select class="form-control form-control-sm"><option value=""> -- Filter -- </option></select>')
						.on('change', function () {
							const val = $.fn.dataTable.util.escapeRegex($(this).val());
							api.column(colIdx)
								.search(val ? '^' + val + '$' : '', true, false)
								.draw();
						});
					$(cell).html(select);
					console.log(cell, select)
					api.column(colIdx).data().unique().sort().each(function (d, j) {
						let cols = api.column(colIdx).selector.cols
						select.append('<option value="' + d + '">' + d + '</option>')
					});
				}

				// For each column
				api
					.columns()
					.eq(0)
					.each(function (colIdx) {
						// Set the header cell to contain the input element
						var cell = $('#tableTemuanTindakanCepat .filters th').eq(
							$(api.column(colIdx).header()).index()
						);
						let filterType = $(cell).data("filter");
						switch (filterType) {
							case 'select':
								initFilterSelect(api, cell, colIdx)
								break;

							case 'input':
								initFilterInput(api, cell, colIdx)
								break
							default:
								console.log(colIdx, 'no filter')
								$(cell).html('')
								break;
						}
					});
			}
		});
		new $.fn.dataTable.Buttons(tableTemuanTindakanCepat, {
			buttons: [
				{
					extend: 'excelHtml5',
					title: 'Data export',
					text: '<i class="fa fa-files-o"></i> XLSX',
					titleAttr: 'EXCEL',
					className: 'btn btn-default btn-sm',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7]
					},
					filename: function () {
						var d = new Date();
						return 'laporan_temuan_' + d.getTime();
					},
					customize: function (xlsx) {
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
					filename: function () {
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

<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<!-- <h1>Master Event</h1> -->
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= base_url('Mst_Event') ?>">Master</a></li>
					<li class="breadcrumb-item"><a href="<?= base_url('Mst_Settings') ?>">Settings</a></li>
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
				<?php if ($this->session->flashdata("info")) { ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<?= $this->session->flashdata('info') ?>
						<?= $this->session->unset_userdata('info') ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php } else if ($this->session->flashdata("fail")) { ?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<?= $this->session->flashdata('fail') ?>
						<?= $this->session->unset_userdata('fail') ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php } ?>
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Data Settings</h3>
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
						<table id="example2" class="table-sm  mt-1 table table-striped table-bordered">
							<thead>
							<tr>
								<th>NO</th>
								<th>NAMA SETTING</th>
								<th>NILAI</th>
								<th>TYPE</th>
								<th>UNIT</th>
								<th>STATUS</th>
								<th>ACTION</th>
							</tr>
							</thead>
							<tbody>
							<?php $no = 1;
							foreach ($settings->result() as $zn) : ?>
								<tr>
									<td><?= $no++ ?></td>
									<td><?= $zn->nama_setting ?></td>
									<td><pre><?= $zn->nilai_setting ?></pre></td>
									<td><?= $zn->type ?></td>
									<td><?= $zn->unit ?></td>
									<td>
										<?php if ($zn->status == 1) { ?>
											ACTIVE
										<?php } else if ($zn->status == 0) { ?>
											INACTIVE
										<?php } ?>
									</td>
									<td>
										<a href='' data-toggle="modal" data-target="#view-data"
										   class="text-primary ml-2 "
										   data-backdrop="static"
										   data-keyboard="false"
										   data-id="<?= $zn->id_setting ?>"
										   data-status="<?= $zn->status ?>"
										   data-nama-setting="<?= $zn->nama_setting ?>"
										   data-nilai-setting="<?= $zn->nilai_setting ?>"
										   data-type="<?= $zn->type ?>"
										   data-unit="<?= $zn->unit ?>"
										><i class="fas fa-eye"></i></a>

										<a href="<?= base_url('Mst_Settings/edit?id_setting=' . $zn->id_setting) ?>"
										   class='text-success ml-2 '><i class="fas fa-edit"></i></a>
									</td>
								</tr>
							<?php endforeach ?>
							</tbody>
						</table>
					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card -->
			</div>
		</div>
	</div>
</section>


<!-- modal edit data Event -->
<div class="modal fade" id="view-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Detail</h5>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>NAMA SETTING</label>
					<input type="text" readonly class="form-control" id="nama-setting">
				</div>
				<div class="form-group">
					<label>NILAI SETTING</label>
					<textarea type="text" readonly class="form-control" id="nilai-setting"></textarea>
				</div>

				<div class="form-group">
					<label>TYPE</label>
					<input type="text" readonly class="form-control" id="type">
				</div>

				<div class="form-group">
					<label>UNIT</label>
					<input type="text" readonly class="form-control" id="unit">
				</div>
				<div class="form-group">
					<label>STATUS</label>
					<input type="text" readonly class="form-control" id="status">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>
<!-- edit data object -->


<script>
	$("#view-data").on("show.bs.modal", function (event) {
		var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
		var modal = $(this);
		modal.find("#nama-setting").attr("value", div.data("nama-setting"));
		modal.find("#nilai-setting").text(div.data("nilai-setting"));
		modal.find("#type").attr("value", div.data("type"));
		modal.find("#unit").attr("value", div.data("unit"));
		if (div.data("status") === 1) {
		    modal.find("#status").attr("value", "ACTIVE");
		} else {
		    modal.find("#status").attr("value", "INACTIVE");
		}
	});
</script>

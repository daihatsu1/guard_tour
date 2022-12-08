<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<!-- <h1>Master User</h1> -->
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= base_url('Mst_User_ga') ?>">Master</a></li>
					<li class="breadcrumb-item"><a href="<?= base_url('Mst_User_ga') ?>">User GA</a></li>
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
				<?php if ($this->session->flashdata("info")) : ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<?= $this->session->flashdata('info') ?>
						<?= $this->session->unset_userdata('info') ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Master User GA</h3>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<a href="<?= base_url('Mst_user_ga/form_add') ?>" class="btn btn-sm btn-primary"
						   data-backdrop="static" data-keyboard="false">
							<i class="fa fa-plus"></i> Tambah User GA
						</a>

						<table id="example" class="mt-1 table table-sm   table-striped table-bordered">
							<thead>
							<tr>
								<th style="width: 50px;">NO</th>
								<th>NAMA</th>
								<th>EMAIL</th>
								<th>PLANT</th>
								<th>STATUS</th>
								<th>TYPE</th>
								<th>ACTION</th>
							</tr>
							</thead>
							<tbody>
							<?php $no = 1;
							foreach ($userGa->result() as $zn) : ?>
								<tr>
									<td><?= $no++ ?></td>
									<td><?= strtoupper($zn->name) ?></td>
									<td><?= strtoupper($zn->email) ?></td>
									<td><?= $zn->admisecsgp_mstplant_plant_id ?></td>
									<td><?= $zn->status == 1 ? 'ACTIVE' : 'INACTIVE' ?></td>
									<td><?= $zn->type == 1 ? 'GA' : 'CC' ?></td>
									<td>
										<a href="<?= base_url('Mst_user_ga/hapus/' . $zn->id) ?>"
										   onclick="return confirm('Yakin Hapus ?')" class='text-danger'
										   title="hapus data"><i class="fa fa-trash"></i></a>

										<a href='' data-toggle="modal"
										   data-target="#edit-data"
										   class="text-primary ml-2 "
										   title="lihat data"
										   data-backdrop="static"
										   data-keyboard="false"
										   data-email="<?= $zn->email ?>"
										   data-status="<?= $zn->status ?>"
										   data-plant="<?= strtoupper($zn->admisecsgp_mstplant_plant_id) ?>"
										   data-nama="<?= strtoupper($zn->name) ?>"><i class="fa fa-eye"></i></a>
										<a href="<?= base_url('Mst_user_ga/edit?id=' . $zn->id) ?>"
										   class='text-success  ml-2 '
										   title="edit data"
										   data-backdrop="static"
										   data-keyboard="false"
										   data-id="<?= $zn->id ?>"><i class="fa fa-edit"></i></a>
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


<!-- modal edit data user -->
<div class="modal fade" id="edit-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Detail</h5>
			</div>
			<div class="modal-body">
				<div class="card-body">
					<div class="form-group">
						<label>NAMA</label>
						<input readonly type="text" class="form-control" id="nama">
					</div>
					<div class="form-group">
						<label>EMAIL</label>
						<input readonly type="text" class="form-control" id="email">
					</div>
					<div class="form-group">
						<label>PLANT</label>
						<input readonly type="text" class="form-control" id="plant">
					</div>
					<div class="form-group">
						<label>STATUS</label>
						<input readonly type="text" class="form-control" id="status">
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>
	<!-- edit data object -->

</div>

<script>
	function cekpassword() {
		if (document.getElementById("password3").value == "") {
			alert("isi password ");
			$("#password3").focus();
			return false
		} else if (document.getElementById("password4").value == "") {
			alert("isi password ");
			$("#password4").focus();
			return false
		} else if (document.getElementById("password3").value != document.getElementById("password4").value) {
			alert("password harus sama");
			return false
		}
		return;
	}

	$("#edit-data").on("show.bs.modal", function (event) {
		var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
		var modal = $(this);
		// Isi nilai pada field
		modal.find("#nama").attr("value", div.data("nama"));
		modal.find("#email").attr("value", div.data("email"));
		modal.find("#plant").attr("value", div.data("plant"));
		modal.find("#level").attr("value", div.data("level"));
		if (div.data("status") == 1) {
			modal.find("#status").attr("value", "ACTIVE");
		} else {
			modal.find("#status").attr("value", "INACTIVE");
		}
	});
</script>

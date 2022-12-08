<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<!-- <h1>Master Company</h1> -->
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= base_url('Mst_user_ga') ?>">Master</a></li>
					<li class="breadcrumb-item"><a href="<?= base_url('Mst_user_ga') ?>">User GA</a></li>
					<li class="breadcrumb-item"><a href="">Edit User</a></li>
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
						<?php $this->session->unset_userdata('info') ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php } elseif ($this->session->flashdata("fail")) { ?>
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
						<h3 class="card-title">Tambah Data</h3>

						<div class="card-tools">
						</div>
					</div>
					<form onsubmit="return cek()" action="<?= base_url('Mst_user_ga/update') ?>" method="post"
						  id="inputPlant">
						<input type="hidden" name="id" value="<?= $data->id ?>">
						<div class="card-body">
							<div id="list_plant">
								<div class="form-group">
									<label for="">PLANT</label>
									<select name="plant_id" id="plant_id" class="form-control">
										<option value="">Pilih Plant</option>
										<?php foreach ($plants->result() as $plant) : ?>
											<option value="<?= $plant->plant_id ?>"
													<?php if ($data->admisecsgp_mstplant_plant_id == $plant->plant_id) {
														echo 'selected';
													}
													?>
											><?= $plant->plant_name ?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="">USERNAME</label>
								<input type="text" name="nama" autocomplete="off" value="<?= $data->name ?>" id="nama"
									   class="form-control">
							</div>
							<div class="form-group">
								<label for="email">EMAIL</label>
								<input type="email" name="email" autocomplete="off" value="<?= $data->email ?>"
									   id="email" class="form-control">
							</div>
							<div class="form-group">
								<label for="">STATUS</label>
								<select name="status" class="form-control" id="">
									<?php if ($data->status == 1) { ?>
										<option selected value="<?= $data->status ?>">ACTIVE</option>
										<option value="0">INACTIVE</option>
									<?php } else if ($data->status == 0) { ?>
										<option value="<?= $data->status ?>">INACTIVE</option>
										<option value="1">ACTIVE</option>
									<?php } ?>
								</select>
							</div>

							<div class="form-group">
								<label for="">TYPE</label>
								<select name="type" class="form-control" id="" required>
									<?php if ($data->status == 1) { ?>
										<option selected value="<?= $data->status ?>">GA</option>
										<option value="0">CC</option>
									<?php } else if ($data->status == 0) { ?>
										<option value="<?= $data->status ?>">CC</option>
										<option value="1">GA</option>
									<?php } ?>
								</select>
							</div>
							<a href="<?= base_url('Mst_user_ga') ?>" class="btn btn-success btn-sm"><i
										class="fas fa-arrow-left"></i> Kembali</a>
							<button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan Data
							</button>
						</div>
						<!-- /.card-body -->
					</form>
				</div>
				<!-- /.card -->
			</div>
		</div>
	</div>
</section>
<script>
</script>

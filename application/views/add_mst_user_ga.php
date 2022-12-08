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
                    <li class="breadcrumb-item"><a href="">Tambah User GA</a></li>
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
                    <form onsubmit="return cek()" action="<?= base_url('Mst_user_ga/input') ?>" method="post" id="inputPlant">

                        <div class="card-body">
                            <div class="form-group">
                                <label for="">PLANT</label>
                                <select class="form-control" name="plant_id" id="plant_id" required>
                                    <option selected value="">Pilih Plant</option>
                                    <?php foreach ($plants->result() as $plant) : ?>
                                        <option value="<?= $plant->plant_id ?>"><?= $plant->plant_name ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">NAMA</label>
                                <input type="text" name="nama" autocomplete="off" id="nama" class="form-control" required>
                            </div>
							<div class="form-group">
								<label for="email">EMAIL</label>
								<input type="text" name="email" autocomplete="off" id="email" class="form-control" required>
							</div>
							<div class="form-group">
								<label for="">TYPE</label>
								<select name="type" class="form-control" id="" required>
									<option value="1">GA</option>
									<option value="0">CC</option>
								</select>
							</div>
                            <div class="form-group">
                                <label for="">STATUS</label>
                                <select name="status" class="form-control" id="" required>
                                    <option value="1">ACTIVE</option>
                                    <option value="0">INACTIVE</option>
                                </select>
                            </div>

                            <a href="<?= base_url('Mst_user_ga') ?>" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
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

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Company</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Event') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Event') ?>">Shift</a></li>
                    <li class="breadcrumb-item"><a href="">Edit Shift</a></li>
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
                        <?php $this->session->unset_userdata('info') ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Data</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <form onsubmit="return cek()" action="<?= base_url('Mst_Settings/update') ?>" method="post" id="inputEvent">

                        <div class="card-body">
                            <input type="hidden" name="id" value="<?= $data->id_setting ?>">
                            <div class="form-group">
                                <label for="">NAMA SETTING</label>
                                <input type="text" required value="<?= $data->nama_setting ?>" name="nama_setting" autocomplete="off" id="nama_setting" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">NILAI</label>
								<textarea class="form-control" name="nilai_setting" required><?= $data->nilai_setting ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="">TYPE</label>
                                <input type="text" required value="<?= $data->type ?>" name="type" autocomplete="off" id="type" class="form-control">
                            </div>
							
							<div class="form-group">
								<label for="">UNIT</label>
								<input type="text" required value="<?= $data->unit ?>" name="unit" autocomplete="off" id="unit" class="form-control">
							</div>
							<div class="form-group">
                                <label for="">STATUS</label>
                                <select name="status" class="form-control">
                                    <?php if ($data->status == 1) { ?>
                                        <option selected value="<?= $data->status ?>">ACTIVE</option>
                                        <option value="0">INACTIVE</option>
                                    <?php } else if ($data->status == 0) { ?>
                                        <option value="<?= $data->status ?>">INACTIVE</option>
                                        <option value="1">ACTIVE</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <a href="<?= base_url('Mst_Settings') ?>" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
    function cek() {
        if (document.getElementById("nama_setting").value === "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'nama setting harus di isi',
                icon: 'error',
            }).then((result) => {
                $("#nama_setting").focus();
            })
            return false
        } else if (document.getElementById("nilai_setting").value === "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'Nilai harus di isi',
                icon: 'error',
            }).then((result) => {
                $("#nilai_setting").focus();
            })
            return false
        } else if (document.getElementById("type").value === "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'Type harus di isi',
                icon: 'error',
            }).then((result) => {
                $("#type").focus();
            })
            return false
        }else if (document.getElementById("unit").value === "") {
			Swal.fire({
				title: 'Perhatian!',
				text: 'Unit harus di isi',
				icon: 'error',
			}).then((result) => {
				$("#type").focus();
			})
			return false
        return;
    }
</script>

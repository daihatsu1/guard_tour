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
                            <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button> -->
                        </div>
                    </div>
                    <form onsubmit="return cek()" action="<?= base_url('Mst_Shift/update') ?>" method="post" id="inputEvent">

                        <div class="card-body">
                            <input type="hidden" name="id" value="<?= $data->shift_id ?>">
                            <div class="form-group">
                                <label for="">NAMA SHIFT</label>
                                <input type="text" value="<?= $data->nama_shift ?>" name="shift" autocomplete="off" id="shift" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">JAM MASUK</label>
                                <input type="text" value="<?= $data->jam_masuk ?>" name="jam_masuk" autocomplete="off" id="jam_masuk" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">JAM PULANG</label>
                                <input type="text" value="<?= $data->jam_pulang ?>" name="jam_pulang" autocomplete="off" id="jam_pulang" class="form-control">
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

                            <a href="<?= base_url('Mst_Shift') ?>" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
        if (document.getElementById("shift").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'nama shift harus di isi',
                icon: 'error',
            }).then((result) => {
                $("#site_name").focus();
            })
            return false
        } else if (document.getElementById("jam_masuk").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'jam masuk harus di isi',
                icon: 'error',
            }).then((result) => {
                $("#site_name").focus();
            })
            return false
        } else if (document.getElementById("jam_pulang").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'jam pulang harus di isi',
                icon: 'error',
            }).then((result) => {
                $("#site_name").focus();
            })
            return false
        }
        return;
    }
</script>
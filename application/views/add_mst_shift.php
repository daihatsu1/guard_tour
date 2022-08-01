<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Company</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Shift') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Shift') ?>">Shift</a></li>
                    <li class="breadcrumb-item"><a href="">Tambah Shift</a></li>
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
                        <h3 class="card-title">Tambah Data</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button> -->
                        </div>
                    </div>
                    <form onsubmit="return cek()" action="<?= base_url('Mst_Shift/input') ?>" method="post" id="inputEvent">

                        <div class="card-body">

                            <div class="form-group">
                                <label for="">NAMA SHIFT</label>
                                <input type="text" name="shift" autocomplete="off" id="shift" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">JAM MASUK</label>
                                <input type="text" name="jam_masuk" autocomplete="off" id="jam_masuk" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">JAM PULANG</label>
                                <input type="text" name="jam_pulang" autocomplete="off" id="jam_pulang" class="form-control">
                            </div>


                            <div class="form-group">
                                <label for="">STATUS</label>
                                <select name="status" class="form-control">
                                    <option value="1">ACTIVE</option>
                                    <option value="0">INACTIVE</option>
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



    // $('#jam_masuk').timepicker({
    //     timeFormat: 'hh:mm:ss',
    //     interval: 60,
    //     minTime: '10',
    //     maxTime: '6:00pm',
    //     defaultTime: '11',
    //     startTime: '10:00',
    //     dynamic: false,
    //     dropdown: true,
    //     scrollbar: true
    // });
</script>
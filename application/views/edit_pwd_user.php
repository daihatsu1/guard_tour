<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Company</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_User') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_User') ?>">User</a></li>
                    <li class="breadcrumb-item"><a href="">Edit Password</a></li>
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
                        <h3 class="card-title">Edit Password</h3>

                        <div class="card-tools">
                            <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button> -->
                        </div>
                    </div>
                    <form onsubmit="return cek()" action="<?= base_url('Mst_user/resetPasword') ?>" method="post" id="inputPlant">
                        <input type="hidden" name="id" value="<?= $data->npk ?>">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">PASSWORD BARU</label>
                                <input type="password" name="password" autocomplete="off" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">KETIK ULANG PASSWORD</label>
                                <input type="password" name="password1" autocomplete="off" id="password1" class="form-control">
                            </div>


                            <a href="<?= base_url('Mst_user') ?>" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
        if (document.getElementById("password").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'isi password baru ',
                icon: 'error',
            })
            return false
        } else if (document.getElementById("password1").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'ketik ulang password',
                icon: 'error',
            })
            return false
        } else if (document.getElementById("password").value != document.getElementById("password1").value) {
            Swal.fire({
                title: 'Perhatian!',
                text: 'password harus sama',
                icon: 'error',
            })
            return false
        }
        return;
    }
</script>
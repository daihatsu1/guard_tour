<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Company</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Company') ?>">Master Company</a></li>
                    <li class="breadcrumb-item"><a href="">Edit Data Company</a></li>

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
                    <form onsubmit="return cek()" action="<?= base_url('Mst_Company/update') ?>" method="post">

                        <div class="card-body">
                            <div class="form-group">
                                <label for="">NAMA PERUSAHAAN</label>
                                <input type="hidden" name="id" value="<?= $data->company_id ?>">
                                <input type="text" value="<?= $data->comp_name ?>" name="comp_name" autocomplete="off" id="comp_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">TELEPON</label>
                                <input type="text" value="<?= $data->comp_phone ?>" name="comp_phone" autocomplete="off" id="comp_phone" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">ALAMAT</label>
                                <textarea name="address1" autocomplete="off" class="form-control" id="address" cols="4" rows="2"><?= $data->address1 ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="">STATUS</label>
                                <select name="status" class="form-control" id="">
                                    <?php if ($data->status == 1) { ?>
                                        <option selected value="<?= $data->status ?>">ACTIVE</option>
                                        <option value="0">IN-ACTIVE</option>
                                    <?php } else if ($data->status == 0) { ?>
                                        <option value="<?= $data->status ?>">IN-ACTIVE</option>
                                        <option value="1">ACTIVE</option>
                                    <?php } ?>
                                </select>
                            </div>

                            <a href="<?= base_url('Mst_Company') ?>" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
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
        if (document.getElementById("comp_name").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'Isi Nama Perusahaan',
                icon: 'error',
            }).then(() => {
                $("#comp_name").focus();
            })
            return false
        } else if (document.getElementById("comp_phone").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'Isi No Telepon Perusahaan',
                icon: 'error',
            }).then((result) => {
                $("#comp_phone").focus();
            })
            return false
        } else if (document.getElementById("address1").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'Isi Alamat Perusahaan',
                icon: 'error',
            }).then((result) => {
                $("#address1").focus();
            })
            return false

        }
        return;
    }
</script>
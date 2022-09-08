<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Company</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Site') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Site') ?>">Wilayah</a></li>
                    <li class="breadcrumb-item"><a href="">Edit Wilayah</a></li>
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
                    <form onsubmit="return cek()" action="<?= base_url('Mst_Site/update') ?>" method="post">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">COMPANY</label>
                                <input type="hidden" name="id" value="<?= $data->site_id ?>">
                                <select class="form-control" name="comp_id" id="comp_id">

                                    <?php foreach ($company->result() as $cmp) :
                                        if ($data->admisecsgp_mstcmp_company_id == $cmp->company_id) { ?>
                                            <option selected value="<?= $data->admisecsgp_mstcmp_company_id ?>"><?= $data->comp_name ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $cmp->company_id ?>"><?= $cmp->comp_name ?></option>
                                    <?php  }
                                    endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">NAMA WILAYAH</label>
                                <input type="text" name="site_name" value="<?= $data->site_name ?>" autocomplete="off" id="site_name" class="form-control">
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
                                <label for="">KETERANGAN</label>
                                <textarea class="form-control" name="others"><?= $data->others ?></textarea>
                            </div>

                            <a href="<?= base_url('Mst_Site') ?>" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
        if (document.getElementById("site_name").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'nama wilayah harus di isi',
                icon: 'error',
            }).then((result) => {
                $("#site_name").focus();
            })
            return false
        }
        return;
    }
</script>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Company</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Plant') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Plant') ?>">Plant</a></li>
                    <li class="breadcrumb-item"><a href="">Edit Plant</a></li>
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
                    <form onsubmit="return cek()" action="<?= base_url('Mst_Plant/update') ?>" method="post">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">COMPANY</label>
                                <input type="hidden" name="plant_id" value="<?= $data->plant_id ?>">
                                <select class="form-control" name="comp_id" id="comp_id">
                                    <option selected value="<?= $data->admisecsgp_mstcmp_company_id ?>"><?= $data->comp_name ?></option>
                                    <option value="">Pilih Company</option>
                                    <?php foreach ($company->result() as $cmp) :  ?>
                                        <option value="<?= $cmp->company_id ?>"><?= $cmp->comp_name ?></option>
                                    <?php endforeach ?>
                                </select>
                                <span id="info" style="display: none;" class="text-danger font-italic small">load data wilayah . . .</span>
                            </div>
                            <div class="form-group">

                                <div id="list_wilayah">
                                    <label for="">WILAYAH</label>
                                    <select class="form-control" name="site_id" id="site_id">
                                        <option selected value="<?= $data->admisecsgp_mstsite_site_id ?>"><?= $data->site_name ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">NAMA PLANT</label>
                                <input type="text" value="<?= $data->plant_name ?>" name="plant_name" autocomplete="off" id="plant_name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">KODE PLANT</label>
                                <input type="text" value="<?= $data->kode_plant ?>" name="kodeplant" autocomplete="off" id="kodeplant" class="form-control">
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
                                <textarea class="form-control" name="others" id="others"><?= $data->others ?></textarea>
                            </div>

                            <a href="<?= base_url('Mst_Plant') ?>" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan Perubahan </button>
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
        if (document.getElementById("site_id").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'wilayah harus di isi',
                icon: 'error',
            }).then((result) => {})
            // alert("nama plant harus di isi");
            // $("#plant_name").focus();
            return false
        } else if (document.getElementById("plant_name").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'nama plant harus di isi',
                icon: 'error',
            }).then((result) => {})
            // alert("nama plant harus di isi");
            // $("#plant_name").focus();
            return false
        }
        return;
    }

    $(function() {
        //input data wilayah berdasarkan
        $('select[name=comp_id').on('change', function() {
            var id = $("select[name=comp_id] option:selected").val();
            // alert(id)
            if (id == null || id == "") {
                document.getElementById('list_wilayah').innerHTML = '<label for="">WILAYAH</label><select class ="form-control" name="site_id" id ="site_id"><option selected value="<?= $data->admisecsgp_mstsite_site_id ?>"><?= $data->site_name ?></option></select> ';
            } else {
                $.ajax({
                    url: "<?= base_url('Mst_Plant/showWilayah') ?>",
                    method: "POST",
                    data: "id=" + id,
                    beforeSend: function() {
                        document.getElementById('info').style.display = "block"
                    },
                    complete: function() {
                        document.getElementById('info').style.display = "none"

                    },
                    success: function(e) {
                        document.getElementById('list_wilayah').innerHTML = e;
                        console.log(e);
                    }
                })
            }
        });
    })
</script>
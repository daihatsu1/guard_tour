<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Company</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Zona') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Zona') ?>">Zona</a></li>
                    <li class="breadcrumb-item"><a href="">Edit Zona</a></li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid z-->
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
                    <form onsubmit="return cek()" action="<?= base_url('Admin/Mst_Zona/update') ?>" method="post" id="inputZona">
                        <input type="hidden" name="id" value="<?= $data->id ?>">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">WILAYAH</label>
                                <select class="form-control" name="site_id" id="site_id">
                                    <option selected value="<?= $data->admisecsgp_mstsite_site_id ?>"><?= $data->site_name ?></option>
                                    <option value="">Pilih Wilayah</option>
                                    <?php foreach ($wilayah->result() as $cmp) : ?>
                                        <option value="<?= $cmp->site_id ?>"><?= $cmp->site_name ?></option>
                                    <?php endforeach ?>
                                </select>
                                <span id="info" style="display: none;" class="text-danger font-italic small">load data plant . . .</span>
                            </div>

                            <div id="list_plant">
                                <div class="form-group">
                                    <label for="">PLANT</label>
                                    <select class="form-control" name="plant_id" id="plant_id">
                                        <option value="<?= $data->admisecsgp_mstplant_plant_id ?>"><?= $data->plant_name ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">NAMA ZONA</label>
                                <input type="text" value="<?= $data->zone_name ?>" name="zone_name" autocomplete="off" id="zone_name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">KODE ZONA</label>
                                <input type="text" value="<?= $data->kode_zona ?>" name="kode_zona" autocomplete="off" id="kode_zona" class="form-control">
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
                                <textarea name="others" class="form-control" id="others"><?= $data->others ?></textarea>
                            </div>

                            <a href="<?= base_url('Admin/Mst_Zona') ?>" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
        if (document.getElementById("plant_id").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'plant harus di pilih',
                icon: 'error',
            }).then((result) => {
                // $("#site_name").focus();
            })
            return false
        } else if (document.getElementById("zone_name").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'nama zona harus di isi',
                icon: 'error',
            }).then((result) => {
                // $("#site_name").focus();
            })
            return false
        }
        return;
    }

    $("select[name=site_id").on('change', function() {
        var id = $("select[name=site_id] option:selected").val();
        // console.log(id)
        if (id == null || id == "") {
            document.getElementById('list_plant').innerHTML = '<div class="form-group"><label for="">PLANT</label><select class="form-control" name="plant_id" id="plant_id"><option value="<?= $data->admisecsgp_mstplant_plant_id ?>"><?= $data->plant_name ?></option></select></div>';
        } else {
            $.ajax({
                url: "<?= base_url('Admin/Mst_Zona/showPlant') ?>",
                method: "POST",
                data: "id=" + id,
                beforeSend: function() {
                    document.getElementById('info').style.display = "block"
                },
                complete: function() {
                    document.getElementById('info').style.display = "none"

                },
                success: function(e) {
                    document.getElementById('list_plant').innerHTML = e;
                    console.log(e);
                }
            })
        }
    });
</script>
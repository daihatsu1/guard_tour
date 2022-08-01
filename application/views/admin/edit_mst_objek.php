<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Company</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_objek') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_objek') ?>">Objek</a></li>
                    <li class="breadcrumb-item"><a href="">Edit Objek</a></li>
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
                            <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button> -->
                        </div>
                    </div>
                    <form onsubmit="return cek()" action="<?= base_url('Admin/Mst_objek/update') ?>" method="post" id="updateObjek">
                        <input type="hidden" name="id_object" value="<?= $data->id ?>">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">PLANT</label>
                                <select class="form-control" name="plant_id" id="plant_id">
                                    <option selected value="<?= $data->plant_id ?>"><?= $data->plant_name ?></option>
                                    <option value="">Pilih Plant</option>
                                    <?php foreach ($plant->result() as $plt) : ?>
                                        <option value="<?= $plt->id ?>"><?= $plt->plant_name ?></option>
                                    <?php endforeach ?>
                                </select>
                                <span id="info_zona" style="display: none;" class="text-danger font-italic small">load data zona . . .</span>
                            </div>

                            <div class="form-group ">
                                <label for="">ZONA</label>
                                <select class="form-control" name="zone_id" id="zone_id">
                                    <option selected value="<?= $data->zona_id ?>"><?= $data->zone_name ?></option>
                                    <option value="">Pilih Zona</option>
                                    <?php foreach ($zone->result() as $znp) : ?>
                                        <option value="<?= $znp->id ?>"><?= $znp->zone_name ?></option>
                                    <?php endforeach ?>
                                </select>
                                <span id="info_kategori" style="display: none;" class="text-danger font-italic small">load data kategori objek . . .</span>
                            </div>

                            <div class="form-group mt-2 ">
                                <label for="">CHECKPOINT</label>
                                <select class="form-control" name="check_id" id="check_id">
                                    <option selected value="<?= $data->check_id ?>"><?= $data->check_name ?></option>
                                    <option value="">Pilih Checkpoint</option>
                                    <?php foreach ($checkpoint->result() as $ckp) : ?>
                                        <option value="<?= $ckp->id ?>"><?= $ckp->check_name ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group mt-2 ">
                                <label for="">KATEGORI OBJEK</label>
                                <select class="form-control" name="kategori_id" id="kategori_id">
                                    <option selected value="<?= $data->kategori_id ?>"><?= $data->kategori_name ?></option>
                                    <option value="">Pilih Kategori Objek</option>
                                    <?php foreach ($kategori_objek->result() as $ktr) : ?>
                                        <option value="<?= $ktr->id ?>"><?= $ktr->kategori_name ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">NAMA OBJEK</label>
                                <input type="text" value="<?= $data->nama_objek ?>" name="nama_objek" autocomplete="off" id="nama_objek" class="form-control">
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
                                <textarea name="others" class="form-control" id="others"></textarea>
                            </div>

                            <a href="<?= base_url('Admin/Mst_objek') ?>" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
        if (document.getElementById("check_id").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'pilih checkpoint',
                icon: 'error',
            }).then((result) => {
                // $("#site_name").focus();
            })
            return false
        } else if (document.getElementById("nama_objek").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'nama objek harus di isi',
                icon: 'error',
            }).then((result) => {
                // $("#site_name").focus();
            })
            return false
        }
        return;
    }


    $("select[name=zone_id").on('change', function() {
        var id = $("select[name=zone_id] option:selected").val();
        if (id == null || id == "") {
            document.getElementById('list_check').innerHTML = '<label for="">CHECKPOINT</label><select class ="form-control" name="zone_id" id="zone_id"><option selected value="<?= $data->admisecsgp_mstckp_id ?>"><?= $data->check_name ?></option></select> ';
        } else {
            $.ajax({
                url: "<?= base_url('Admin/Mst_objek/getCheck') ?>",
                method: "POST",
                data: "id=" + id,
                beforeSend: function() {
                    document.getElementById('info').style.display = "block"
                },
                complete: function() {
                    document.getElementById('info').style.display = "none"

                },
                success: function(e) {
                    document.getElementById('list_check').innerHTML = e;
                    console.log(e);
                }
            })
        }
    });
</script>
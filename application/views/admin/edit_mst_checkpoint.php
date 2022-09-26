<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Company</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Checkpoint') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Checkpoint') ?>">Checkpoint</a></li>
                    <li class="breadcrumb-item"><a href="">Edit Checkpoint</a></li>
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
                            <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button> -->
                        </div>
                    </div>
                    <form onsubmit="return cek()" action="<?= base_url('Admin/Mst_Checkpoint/update') ?>" method="post" id="updateCheckpoint">
                        <input type="hidden" name="id" value="<?= $data->id ?>">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">PLANT</label>
                                <select class="form-control" name="plant_id" id="plant_id">
                                    <option selected value="<?= $data->admisecsgp_mstplant_plant_id ?>"><?= $data->plant_name ?></option>
                                    <option value="">Pilih Plant</option>
                                    <?php foreach ($plant->result() as $plt) : ?>
                                        <option value="<?= $plt->plant_id ?>"><?= $plt->plant_name ?></option>
                                    <?php endforeach ?>
                                </select>
                                <span id="info" style="display: none;" class="text-danger font-italic small">load data zona . . .</span>
                            </div>

                            <div id="list_zone">
                                <label for="">ZONA</label>
                                <select class="form-control" name="zone_id" id="zone_id">
                                    <?php foreach ($zone->result() as $znp) :

                                        if ($znp->zone_id == $zona_id) { ?>
                                            <option selected value="<?= $data->admisecsgp_mstzone_zone_id ?>"><?= $znp->zone_name ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $znp->zone_id ?>"><?= $znp->zone_name ?></option>
                                        <?php } ?>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">NAMA CHECKPOINT</label>
                                <input type="text" value="<?= $data->check_name ?>" name="check_name" autocomplete="off" id="check_name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">ID CHECKPOINT</label>
                                <input type="text" name="check_no" value="<?= $data->check_no ?>" autocomplete="off" id="check_no" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">DURASI BATAS ATAS</label>
                                <input type="number" value="<?= $data->durasi_batas_atas ?>" name="durasi" autocomplete="off" id="durasi" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">DURASI BATAS BAWAH</label>
                                <input type="number" value="<?= $data->durasi_batas_bawah ?>" name="durasi2" autocomplete="off" id="durasi2" class="form-control">
                            </div>


                            <div class="form-group">
                                <label for="">STATUS </label>
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

                            <div class="form-group">
                                <label for="">KETERANGAN</label>
                                <textarea name="others" class="form-control" id="others"><?= $data->others ?></textarea>
                            </div>

                            <a href="<?= base_url('Admin/Mst_Checkpoint') ?>" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
        if (document.getElementById("zone_id").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'pilih zona',
                icon: 'error',
            }).then((result) => {
                // $("#site_name").focus();
            })
            return false
        } else if (document.getElementById("check_name").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'nama checkpoint harus di isi',
                icon: 'error',
            }).then((result) => {
                // $("#site_name").focus();
            })
            return false
        } else if (document.getElementById("check_no").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'id checkpoint harus di isi',
                icon: 'error',
            }).then((result) => {
                // $("#site_name").focus();
            })
            return false
        }
        return;
    }


    $("select[name=plant_id").on('change', function() {
        var id = $("select[name=plant_id] option:selected").val();
        // console.log(id)
        if (id == null || id == "") {
            document.getElementById('list_zone').innerHTML = '<label for="">ZONA</label><select class ="form-control" name="zone_id" id="zone_id"><option selected value="<?= $data->admisecsgp_mstzone_zone_id ?>"><?= $data->zone_name ?></option></select> ';
        } else {
            $.ajax({
                url: "<?= base_url('Mst_Checkpoint/showZone') ?>",
                method: "POST",
                data: "id=" + id,
                beforeSend: function() {
                    document.getElementById('info').style.display = "block"
                },
                complete: function() {
                    document.getElementById('info').style.display = "none"

                },
                success: function(e) {
                    document.getElementById('list_zone').innerHTML = e;
                    // console.log(e);
                }
            })
        }
    });
</script>
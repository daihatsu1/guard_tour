<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Company</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_User') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_User') ?>">User</a></li>
                    <li class="breadcrumb-item"><a href="">Edit User</a></li>
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
                    <form onsubmit="return cek()" action="<?= base_url('Admin/Mst_user/update') ?>" method="post" id="inputPlant">
                        <input type="hidden" name="id" value="<?= $data->npk ?>">
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
                                    <select name="plant_id" id="plant_id" class="form-control">
                                        <option value="<?= $data->admisecsgp_mstplant_plant_id ?>"><?= $data->plant_name ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">NPK</label>
                                <input disabled type="text" name="npk" value="<?= $data->npk ?>" autocomplete="off" id="npk" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">USERNAME</label>
                                <input type="text" name="nama" autocomplete="off" value="<?= $data->name ?>" id="nama" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">LEVEL</label>
                                <select name="level" class="form-control" id="">
                                    <option selected value="<?= $data->admisecsgp_mstroleusr_role_id ?>"><?= $data->level ?></option>
                                    <option value="">Pilih Role</option>
                                    <?php foreach ($role->result() as $rl) : ?>
                                        <option value="<?= $rl->role_id ?>"><?= $rl->level ?></option>
                                    <?php endforeach ?>
                                </select>
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

                            <a href="<?= base_url('Admin/Mst_user') ?>" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
        if (document.getElementById("site_id").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'pilih wilayah',
                icon: 'error',
            }).then((result) => {})

            return false
        } else if (document.getElementById("plant_id").value == "") {
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
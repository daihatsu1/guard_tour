<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Company</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Zona') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Zona') ?>">Zona</a></li>
                    <li class="breadcrumb-item"><a href="">Tambah Zona</a></li>
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
                    <form onsubmit="return cek()" action="<?= base_url('Mst_Zona/input') ?>" method="post" id="inputZona">

                        <div class="card-body">
                            <div class="form-group">
                                <label for="">WILAYAH</label>
                                <select class="form-control" name="site_id" id="site_id">
                                    <option selected value="">Pilih Wilayah</option>
                                    <?php foreach ($wilayah->result() as $cmp) : ?>
                                        <option value="<?= $cmp->site_id ?>"><?= $cmp->site_name ?></option>
                                    <?php endforeach ?>
                                </select>
                                <span id="info" style="display: none;" class="text-danger font-italic small">load data plant . . .</span>
                            </div>

                            <div id="list_plant">

                            </div>
                            <div class="form-group">
                                <label for="">NAMA ZONA</label>
                                <input type="text" name="zone_name" autocomplete="off" id="zone_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">KODE ZONA</label>
                                <input type="text" name="kode_zona" autocomplete="off" id="kode_zona" class="form-control">
                            </div>


                            <div class="form-group">
                                <label for="">STATUS</label>
                                <select name="status" class="form-control" id="">
                                    <option value="1">ACTIVE</option>
                                    <option value="0">INACTIVE</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">KETERANGAN</label>
                                <textarea name="others" class="form-control" id="others"></textarea>
                            </div>

                            <a href="<?= base_url('Mst_Zona') ?>" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
            }).then((result) => {
                // $("#site_name").focus();
            })
            return false
        } else if (document.getElementById("plant_id").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'pilih plant',
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
        } else if (document.getElementById("kode_zona").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'kode zona harus di isi',
                icon: 'error',
            }).then((result) => {
                // $("#site_name").focus();
            })
            return false
        }
        return;
    }

    //input data wilayah berdasarkan
    $('select[name=comp_id').on('change', function() {
        var id = $("select[name=comp_id] option:selected").val();
        if (id == null || id == "") {
            document.getElementById('list_wilayah').innerHTML = "";
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
                }
            })
        }
    });

    $("select[name=site_id").on('change', function() {
        var id = $("select[name=site_id] option:selected").val();
        // console.log(id)
        if (id == null || id == "") {
            document.getElementById('list_plant').innerHTML = "";
        } else {
            $.ajax({
                url: "<?= base_url('Mst_Zona/showPlant') ?>",
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
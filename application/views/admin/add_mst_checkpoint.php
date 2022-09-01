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
                    <li class="breadcrumb-item"><a href="">Tambah Checkpoint</a></li>
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
                    <form onsubmit="return cek()" action="<?= base_url('Admin/Mst_Checkpoint/input') ?>" method="post" id="inputCheckpoint">

                        <div class="card-body">
                            <div class="form-group">
                                <label for="">PLANT</label>
                                <select class="form-control" name="plant_id" id="plant_id">
                                    <option selected value="">Pilih Plant</option>
                                    <?php foreach ($plant->result() as $plt) : ?>
                                        <option value="<?= $plt->plant_id ?>"><?= $plt->plant_name ?></option>
                                    <?php endforeach ?>
                                </select>
                                <span id="info" style="display: none;" class="text-danger font-italic small">load data zone . . .</span>
                            </div>

                            <div id="list_zone">

                            </div>
                            <div class="form-group">
                                <label for="">ID CHECKPOINT</label>
                                <input type="text" name="check_no" autocomplete="off" id="check_no" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">NAMA CHECKPOINT</label>
                                <input type="text" name="check_name" autocomplete="off" id="check_name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">DURASI BATAS BAWAH</label>
                                <input type="number" name="durasi_batas_bawah" autocomplete="off" id="durasi" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">DURASI BATAS ATAS</label>
                                <input type="number" name="durasi_batas_atas" autocomplete="off" id="durasi2" class="form-control">
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
        if (document.getElementById("plant_id").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'pilih plant',
                icon: 'error',
            }).then((result) => {
                // $("#site_name").focus();
            })
            return false
        } else if (document.getElementById("zone_id").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'pilih zona',
                icon: 'error',
            }).then((result) => {})
            return false
        } else if (document.getElementById("check_name").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'nama checkpoint harus di isi',
                icon: 'error',
            }).then((result) => {})
            return false
        } else if (document.getElementById("durasi").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'durasi batas bawah harus di isi',
                icon: 'error',
            }).then((result) => {})
            return false
        } else if (document.getElementById("durasi2").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'durasi batas atas harus di isi',
                icon: 'error',
            }).then((result) => {})
            return false
        } else if (document.getElementById("check_no").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'id checkpoint harus di isi',
                icon: 'error',
            }).then((result) => {})
            return false
        }
        return;
    }


    $("select[name=plant_id").on('change', function() {
        var id = $("select[name=plant_id] option:selected").val();
        // console.log(id)
        if (id == null || id == "") {
            document.getElementById('list_zone').innerHTML = "";
        } else {
            $.ajax({
                url: "<?= base_url('Admin/Mst_Checkpoint/showZone') ?>",
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
                    console.log(e);
                }
            })
        }
    });
</script>
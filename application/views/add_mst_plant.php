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
                    <li class="breadcrumb-item"><a href="">Tambah Plant</a></li>
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
                    <form onsubmit="return cek()" action="<?= base_url('Mst_Plant/input') ?>" method="post" id="inputPlant">

                        <div class="card-body">
                            <div class="form-group">
                                <label for="">COMPANY</label>
                                <select class="form-control" name="comp_id" id="comp_id">
                                    <option selected value="">Pilih Company</option>
                                    <?php foreach ($company->result() as $cmp) : ?>
                                        <option value="<?= $cmp->company_id ?>"><?= $cmp->comp_name ?></option>
                                    <?php endforeach ?>
                                </select>
                                <span id="info" style="display: none;" class="text-danger font-italic small">load data wilayah . . .</span>
                            </div>
                            <div id="list_wilayah">

                            </div>
                            <div class="form-group">
                                <label for="">NAMA PLANT</label>
                                <input type="text" name="plant_name" autocomplete="off" id="plant_name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">KODE PLANT</label>
                                <input type="text" name="kodeplant" autocomplete="off" id="kodeplant" class="form-control">
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

                            <a href="<?= base_url('Mst_Plant') ?>" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
        if (document.getElementById("comp_id").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'pilih company',
                icon: 'error',
            }).then((result) => {
                // $("#comp_id").focus();
            })
            return false
        } else if (document.getElementById("site_id").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'pilih wilayah',
                icon: 'error',
            }).then((result) => {})

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
        } else if (document.getElementById("kodeplant").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'kode plant harus di isi',
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
                        console.log(e);
                    }
                })
            }
        });
    })
</script>
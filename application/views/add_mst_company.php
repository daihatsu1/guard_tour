<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Company</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Company') ?>">Master Company</a></li>
                    <li class="breadcrumb-item"><a href="">Tambah Data</a></li>
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
                    <form onsubmit="return cek()" action="<?= base_url('Mst_Company/input') ?>" method="post" id="inputCompany">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">NAMA PERUSAHAAN</label>
                                <input type="text" name="comp_name" autocomplete="off" id="comp_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">TELEPON</label>
                                <input type="text" name="comp_phone" autocomplete="off" id="comp_phone" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">ALAMAT</label>
                                <textarea name="address1" autocomplete="off" class="form-control" id="address1" cols="4" rows="2"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="">STATUS</label>
                                <select name="status" class="form-control" id="">
                                    <option value="1">ACTIVE</option>
                                    <option value="0">INACTIVE</option>
                                </select>
                            </div>

                            <a href="<?= base_url('Mst_Company') ?>" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Zona</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Event') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Event') ?>">Event</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Event/form_upload_event') ?>">Upload Event</a></li>
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
                        <?= $this->session->unset_userdata('info') ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } else if ($this->session->flashdata("fail")) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('fail') ?>
                        <?= $this->session->unset_userdata('fail') ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ?>
                <a href="<?= base_url('assets/format_upload/upload_event.xlsx')  ?>" class="ml-2 btn btn-primary btn-sm"> <i class="fas fa-download"></i> Download Format Upload</a>
                <div class="card mt-2">
                    <div class="card-body">
                        <form method="post" action="<?= base_url('Admin/Mst_Event/form_upload_event') ?>" onsubmit="return cekExe()" enctype="multipart/form-data">
                            <div class="form group">
                                <label for="">Upload File</label>
                                <input onchange="return exe()" id="file" accept=".xlsx" type="file" name="file" class="form-control form-control-sm">
                                <span class="text-danger font-italic small">* hanya file dengan ekstensi xlsx yang boleh di upload *</span>
                            </div>

                            <div class="form-inline mt-2">
                                <a href="<?= base_url('Admin/Mst_Event') ?>" class="mr-2 btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                <input type="submit" value="Upload Event" name="view" class="btn btn-info btn-sm"></input>
                            </div>
                        </form>

                        <form action="<?= base_url('Admin/Mst_Event/upload') ?>" method="post" enctype="multipart/form-data" class="mt-2">
                            <?php

                            $count = 0;
                            if (isset($_POST['view'])) {
                                //cek data kode zona 
                                foreach ($sheet as $sh) {
                                    // 
                                    $cek_kategori = $this->db->query("SELECT kategori_id from admisecsgp_mstkobj where kategori_name = '" . $sh[0] . "'");
                                    if ($cek_kategori->num_rows() <= 0) {
                                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <b class="font-italice">Kategori ' . $sh[0] . ' </b> tidak terdaftar di database
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                                        $count += 1;
                                    }
                                }

                                //hitung total kesalahan input
                                if ($count <= 0) {
                                    redirect('Admin/Mst_Event/upload');
                                }
                            }
                            ?>
                        </form>
                    </div>


                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    </div>
</section>

<script>
    function cekExe() {
        var fi = document.getElementById('file');
        if (fi.value == '' || fi.value == null) {
            Swal.fire({
                title: 'Perhatian!',
                text: 'Pilih file yang akan di upload',
                icon: 'error',
            })
            return false;
        }
        return
    }

    function exe() {
        const file = document.getElementById('file');
        const path = file.value;
        const exe = /(\.xlsx)$/i;
        if (!exe.exec(path)) {
            Swal.fire({
                title: 'Perhatian!',
                text: 'File tidak diijinkan',
                icon: 'error',
            })
            // alert('File tidak diijinkan');
            file.value = "";
        }
    }
</script>
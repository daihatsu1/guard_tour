<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Zona</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Checkpoint') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Checkpoint') ?>">Checkpoint</a></li>
                    <li class="breadcrumb-item"><a href="">Upload Checkpoint</a></li>
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
                <!-- <a href="<?= base_url('Mst_Checkpoint') ?>" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a> -->
                <a href="<?= base_url('assets/format_upload/upload_checkpoint.xlsx')  ?>" class="ml-2 btn btn-primary btn-sm"> <i class="fas fa-download"></i> Download Format Upload</a>
                <div class="card mt-2">
                    <div class="card-body">
                        <form method="post" action="<?= base_url('Mst_Checkpoint/form_upload') ?>" onsubmit="return cekExe()" enctype="multipart/form-data">
                            <label for="">PLANT</label>
                            <select class="form-control" name="plant_id" id="plant_id">
                                <option value="">Pilih Plant</option>
                                <?php foreach ($plant->result() as $plt) :
                                    if ($plt->plant_name == $plant_kode_input) { ?>
                                        <option selected value="<?= $plt->plant_name ?>"><?= $plt->plant_name ?></option>
                                    <?php } else { ?>
                                        <option value="<?= $plt->plant_name ?>"><?= $plt->plant_name ?></option>
                                    <?php } ?>
                                <?php endforeach ?>
                            </select>
                            <div class="form group">
                                <label for="">Upload File</label>
                                <input onchange="return exe()" id="file" accept=".xlsx" type="file" name="file" class="form-control form-control-sm">
                                <span class="text-danger font-italic small">* hanya file dengan ekstensi xlsx yang boleh di upload *</span>
                            </div>

                            <div class="form-inline mt-2">
                                <a href="<?= base_url('Mst_Checkpoint') ?>" class="mr-2 btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                <input type="submit" value="Upload Checkpoint" name="view" class="btn btn-info btn-sm"></input>
                            </div>
                        </form>

                        <form action="<?= base_url('Mst_Checkpoint/upload') ?>" method="post" enctype="multipart/form-data" class="mt-2">
                            <?php

                            $count = 0;
                            if (isset($_POST['view'])) {

                                //cek data kode zona 
                                foreach ($sheet as $sh) {
                                    // 
                                    if ($sh[0] != $plant_kode_input) {
                                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        Plant yang dipilih tidak sama dengan instalasi plant yang ada di file excel
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                                        $count += 1;
                                    }
                                    //cek kode plant 
                                    $plantCek = $this->db->get_where('admisecsgp_mstplant',  ['plant_name' => $sh[0]]);
                                    if ($plantCek->num_rows() <= 0) {
                                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <b class="font-italice">' . $sh[0] . ' </b> tidak terdaftar di database
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                                        $count += 1;
                                    }

                                    //cek kode zona 
                                    $kodezona = $this->db->get_where('admisecsgp_mstzone', ['kode_zona' => $sh[1], 'zone_name' => $sh[2]]);
                                    if ($kodezona->num_rows() <= 0) {
                                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        Nama zona <b class="font-italice">' . $sh[2] . '</b> dengan kode zona <b>' . $sh[1] . '</b> tidak terdaftar di database
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                                        $count += 1;
                                    } else {
                                        //cek id checkpoint 
                                        $checkpoint_name =  $this->db->get_where('admisecsgp_mstckp', ['check_name' => $sh[4]]);
                                        if ($checkpoint_name->num_rows() >= 1) {
                                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        checkpoint <b class="font-italice"> ' . $sh[4] . ' </b> sudah terdaftar di zona ' . $sh[2] . '
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                                            $count += 1;
                                        }
                                    }


                                    //cek id checkpoint 
                                    $checkpoint_id =  $this->db->get_where('admisecsgp_mstckp', ['check_no' => $sh[3]]);
                                    if ($checkpoint_id->num_rows() >= 1) {
                                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        id checkpoint <b class="font-italice"> ' . $sh[3] . ' </b> sudah terdaftar di database
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                                        $count += 1;
                                    }
                                }

                                //hitung total kesalahan input
                                if ($count <= 0) {
                                    redirect('Mst_Checkpoint/upload');
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
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Zona</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Jadwal') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Jadwal') ?>">Jadwal Patroli</a></li>
                    <li class="breadcrumb-item"><a href="">Koreksi Jadwal</a></li>
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
                <a href="<?= base_url('assets/format_upload/upload_jadwal.xlsx')  ?>" class="ml-2 btn btn-primary btn-sm"> <i class="fas fa-download"></i> Download Format Upload</a>
                <div class="card mt-2">
                    <div class="card-body">
                        <form method="post" action="<?= base_url('Mst_Jadwal/form_koreksi_jadwal') ?>" onsubmit="return cekExe()" enctype="multipart/form-data">
                            <div class="form group">
                                <label for="">Upload File</label>
                                <input onchange="return exe()" id="file" accept=".xlsx" type="file" name="file" class="form-control form-control-sm">
                                <span class="text-danger font-italic small">* hanya file dengan ekstensi xlsx yang boleh di upload *</span>
                            </div>

                            <div class="form-inline mt-2">
                                <a href="<?= base_url('Mst_Jadwal') ?>" class="mr-2 btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                <input type="submit" value="Upload Jadwal" name="view" class="btn btn-info btn-sm"></input>
                            </div>
                        </form>
                        <hr>
                        <form action="<?= base_url('Mst_Jadwal/upload_koreksi') ?>" method="post" enctype="multipart/form-data" class="mt-2">
                            <?php

                            $count = 0;
                            if (isset($_POST['view'])) {

                                //cek kode plant terdaftar apa tidak 
                                $cekplant = $this->db->get_where("admisecsgp_mstplant", ['kode_plant' => $plant]);
                                //jika tidak maka muncul alert 
                                if ($cekplant->num_rows() <= 0) {
                                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        Kode Plant <b class="font-italice">' . $plant . '</b> tidak terdaftar di database
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                                    $count += 1;
                                } else {
                                    //cek data jadwal patroli di bulan ini 
                                    $plt = $cekplant->row();
                                    $cekjadwalexist = $this->db->get_where('admisecsgp_mstjadwalpatroli', ['admisecsgp_mstplant_id' => $plt->id, 'bulan' => $bulan_patroli, 'tahun' => $tahun_patroli, 'status' => 1]);
                                    if ($cekjadwalexist->num_rows() <= 0) {
                                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        Jadwal Patroli  <b class="font-italice">' . $bulan_patroli . ' ' . $tahun_patroli . '</b> tidak ditemukan , tidak bisa lanjut koreksi jadwal
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                                        $count += 1;
                                    }


                                    //cek data produksi di bulan ini 
                                    $cekjadwalexistProduksi = $this->db->get_where('admisecsgp_mstproductiondtls', ['admisecsgp_mstplant_id' => $plt->id, 'bulan' => $bulan_patroli, 'tahun' => $tahun_patroli, 'status' => 1]);
                                    if ($cekjadwalexistProduksi->num_rows() <= 0) {
                                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        Jadwal Produksi  <b class="font-italice">' . $bulan_patroli . ' ' . $tahun_patroli . '</b> tidak ditemukan , tidak bisa lanjut koreksi jadwal
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                                        $count += 1;
                                    }
                                }


                                //cek jadwal patroli 
                                foreach ($jadwal as $jdl) {
                                    //cek data npk user 
                                    $cek_user = $this->db->get_where("admisecsgp_mstusr", ['npk' => $jdl[2]]);
                                    //jika tidak maka muncul alert 
                                    if ($cek_user->num_rows() <= 0) {
                                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            NPK <b class="font-italice">' . $jdl[2] . '</b> tidak terdaftar di database
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                                        $count += 1;
                                    }


                                    for ($l = 4; $l <= 34; $l++) {
                                        //cek shift 
                                        if ($jdl[$l] != 'LIBUR') {
                                            $cekshift = $this->db->get_where("admisecsgp_mstshift", ['nama_shift' => $jdl[$l]]);
                                            //jika tidak maka muncul alert 
                                            if ($cekshift->num_rows() <= 0) {
                                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">SHIFT <b class="font-italice">' . $jdl[$l] . '</b> tidak terdaftar di database<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button></div>';
                                                $count += 1;
                                            }
                                        } else {
                                            //no action
                                        }
                                    }
                                }



                                //cek jadwal produksi 
                                foreach ($produksi as $prd) {

                                    //cek inputan shift
                                    $cek_shift_prd = $this->db->get_where("admisecsgp_mstshift", ['nama_shift' => $prd[0]]);
                                    if ($cek_shift_prd->num_rows() <= 0) {
                                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">SHIFT <b class="font-italice">' . $prd[0] . '</b> tidak terdaftar di database<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button></div>';
                                        $count += 1;
                                    }


                                    //cek penulisan produksi non-produksi
                                    for ($pr = 1; $pr <= 31; $pr++) {
                                        //cek shift 
                                        if ($prd[$pr] != 'LIBUR') {
                                            $cekshift = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[$pr]]);
                                            //jika tidak maka muncul alert 
                                            if ($cekshift->num_rows() <= 0) {
                                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">STATUS <b class="font-italice">' . $prd[$pr] . '</b> tidak terdaftar di database<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button></div>';
                                                $count += 1;
                                            }
                                        } else {
                                            //no action
                                        }
                                    }
                                }

                                //hitung total kesalahan input
                                if ($count <= 0) {
                                    redirect('Mst_Jadwal/upload_koreksi');
                                    // echo '<button class="btn btn-danger btn-sm"><i class="fas fa-upload"></i> UPLOAD JADWAL PATROLI</button>';
                                }
                            } ?>

                        </form>
                    </div>


                </div>
            </div>
        </div>

    </div>
    <!-- /.card -->
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
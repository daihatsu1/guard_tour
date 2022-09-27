<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Zona</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Upload_Jadwal_Patroli') ?>">Jadwal</a></li>
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
                <a href="<?= base_url('assets/format_upload/upload_jadwal_patroli.xlsx')  ?>" class="ml-2 btn btn-primary btn-sm"> <i class="fas fa-download"></i> Download Format Upload</a>
                <div class="card mt-2">
                    <div class="card-body">
                        <form method="post" action="<?= base_url('Upload_Jadwal_Patroli') ?>" onsubmit="return cekExe()" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="">PLANT</label>
                                <select class="form-control" name="plant_3" id="plant_3">
                                    <?php foreach ($plant_master->result() as $pltmst) :
                                        if ($plant_3 == $pltmst->kode_plant) { ?>
                                            <option selected value="<?= $pltmst->kode_plant ?>"><?= $pltmst->plant_name ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $pltmst->kode_plant ?>"><?= $pltmst->plant_name ?></option>
                                        <?php   } ?>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">PILIH TAHUN</label>
                                <select name="tahun_input" id="tahun_input" class="form-control">
                                    <option>2022</option>
                                    <option>2023</option>
                                    <option>2024</option>
                                    <option>2025</option>
                                    <option>2026</option>
                                    <option>2027</option>
                                    <option>2028</option>
                                    <option>2029</option>
                                    <option>2030</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">PILIH BULAN</label>
                                <select class="form-control" name="bulan_input" id="bulan_input">
                                    <option>JANUARI</option>
                                    <option>FEBRUARI</option>
                                    <option>MARET</option>
                                    <option>APRIL</option>
                                    <option>MEI</option>
                                    <option>JUNI</option>
                                    <option>JULI</option>
                                    <option>AGUSTUS</option>
                                    <option>SEPTEMBER</option>
                                    <option>OKTOBER</option>
                                    <option>NOVEMBER</option>
                                    <option>DESEMBER</option>
                                </select>
                            </div>

                            <div class="form group">
                                <label for="">UPLOAD FILE</label>
                                <input onchange="return exe()" id="file" accept=".xlsx" type="file" name="file" class="form-control form-control-sm">
                                <span class="text-danger font-italic small">* hanya file dengan ekstensi xlsx yang boleh di upload *</span>
                            </div>

                            <div class="form-inline mt-2">

                                <input type="submit" value="Upload Jadwal Patroli" name="view" class="btn btn-info btn-sm"></input>
                            </div>
                        </form>
                        <hr>
                        <form action="#" method="post" enctype="multipart/form-data" class="mt-2">
                            <?php
                            $count = 0;
                            if (isset($_POST['view'])) {
                                $bln_ = ['JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'];
                                $cek_bulan_patrol = in_array($bulan_patroli, $bln_);

                                if (!$cek_bulan_patrol) {
                                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        Format penulisan bulan di sheet jadwal patroli tidak sesuai
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                                    $count += 1;
                                }

                                if ("$plant_3" != "$plant") {
                                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        Plant yang di pilih tidak sama dengan plant yang di upload , periksa kembali file excel anda
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                                    $count += 1;
                                }

                                if ($bulan_input != $bulan_patroli) {
                                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        Bulan yang di pilih tidak sama dengan bulan yang di upload , periksa kembali file excel anda
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                                    $count += 1;
                                }

                                if ($tahun_input != $tahun_patroli) {
                                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        Tahun yang di pilih tidak sama dengan tahun yang di upload , periksa  kembali file excel anda
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                                    $count += 1;
                                }

                                //cek kode plant terdaftar apa tidak 
                                $cekplant = $this->db->get_where("admisecsgp_mstplant", ['kode_plant' => $plant, 'plant_name' => $plant_name]);
                                //jika tidak maka muncul alert 
                                if ($cekplant->num_rows() <= 0) {
                                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <b class="font-italice">' . $plant_name . '-' .  $plant . '</b> tidak terdaftar di database
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                                    $count += 1;
                                } else {
                                    //cek data jadwal di bulan ini 
                                    $plt = $cekplant->row();
                                    $cekJadwalPatroli = $this->db->query("SELECT  format(date_patroli,'yyyy-MM','en-US')  from admisecsgp_trans_jadwal_patroli atjp 
                                    WHERE format(date_patroli,'yyyy-MM','en-US') = '" . $date  . "' AND  admisecsgp_mstplant_plant_id ='" . $plt->plant_id   . "'
                              GROUP BY format(date_patroli,'yyyy-MM','en-US') ");


                                    if ($cekJadwalPatroli->num_rows() >= 1) {
                                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        Jadwal Patroli Bulan ' . $bulan_patroli . ' - ' .  $tahun_patroli . ' sudah pernah terupload
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                                        $count += 1;
                                    }


                                    // cek data jadwal patroli
                                    foreach ($jadwal as $jdl) {
                                        //cek data npk user 
                                        $cekplantuser = $this->db->get_where("admisecsgp_mstplant", ['kode_plant' => $jdl[0], 'plant_name' => $jdl[1]]);

                                        if ($cekplantuser->num_rows() > 0) {
                                            $pk = $cekplantuser->row();
                                            $cek_user = $this->db->get_where("admisecsgp_mstusr", ['npk' => $jdl[2], 'name' => $jdl[3], 'admisecsgp_mstplant_plant_id' => $pk->plant_id]);
                                            //jika tidak maka muncul alert 
                                            if ($cek_user->num_rows() <= 0) {
                                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                username <b class="font-italice">' . $jdl[3] . '-' . $jdl[2] . '</b> tidak terdaftar di database
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>';
                                                $count += 1;
                                            }
                                        } else {
                                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <b class="font-italice">' . $jdl[1] . ' dengan kode plant ' . $jdl[0] . '</b> tidak terdaftar di database
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>';
                                            $count += 1;
                                        }

                                        $shift = array();
                                        $k = 4;
                                        for ($i = 1; $i <= (count($jadwal[7]) - 4); $i++) {
                                            $sh = [
                                                'tanggal_' . $i => $jdl[$k]
                                            ];
                                            array_push($shift, $sh);
                                            $k++;
                                        }
                                        $o = 1;
                                        for ($l = 0; $l < count($shift); $l++) {
                                            //cek shift 
                                            if ($shift[$l]['tanggal_' . $o] != 'LIBUR') {
                                                $cekshift = $this->db->get_where("admisecsgp_mstshift", ['nama_shift' => strval($shift[$l]['tanggal_' . $o]), 'status' => 1]);
                                                //jika tidak maka muncul alert 
                                                if ($cekshift->num_rows() <= 0) {
                                                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">SHIFT <b class="font-italice">' . $shift[$l]['tanggal_' . $o] . '</b> tidak terdaftar di database<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                                                    $count += 1;
                                                }
                                            } else {
                                                //no action
                                            }
                                            $o++;
                                        }
                                    }
                                }

                                //hitung total kesalahan input
                                if ($count <= 0) {
                                    redirect('Upload_Jadwal_Patroli/uploadjadwalPatroli');
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
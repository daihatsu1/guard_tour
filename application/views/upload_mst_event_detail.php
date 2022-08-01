<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Zona</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Event_Detail') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Event_Detail') ?>">Event Detail</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Event_Detail/form_upload_event_detail') ?>">Upload Event Detail</a></li>
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
                <a href="<?= base_url('assets/format_upload/upload_event_objek .xlsx')  ?>" class="ml-2 btn btn-primary btn-sm"> <i class="fas fa-download"></i> Download Format Upload</a>
                <div class="card mt-2">
                    <div class="card-body">
                        <form method="post" action="<?= base_url('Mst_Event_Detail/form_upload_event_detail') ?>" onsubmit="return cekExe()" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="">PLANT</label>
                                <select class="form-control" name="plant_id" id="plant_id">
                                    <?php foreach ($plant->result() as $pltmst) :
                                        if ($plant_kode_input == $pltmst->plant_name) { ?>
                                            <option selected value="<?= $pltmst->plant_name ?>"><?= $pltmst->plant_name ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $pltmst->plant_name ?>"><?= $pltmst->plant_name ?></option>
                                        <?php   } ?>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form group">
                                <label for="">UPLOAD FILE</label>
                                <input onchange="return exe()" id="file" accept=".xlsx" type="file" name="file" class="form-control form-control-sm">
                                <span class="text-danger font-italic small">* hanya file dengan ekstensi xlsx yang boleh di upload *</span>
                            </div>

                            <div class="form-inline mt-2">
                                <a href="<?= base_url('Mst_Event_Detail') ?>" class="mr-2 btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>

                                <input type="submit" value="Upload Event Detail" name="view" class="btn btn-info btn-sm"></input>
                            </div>
                        </form>
                        <hr>
                        <form action="<?= base_url('Mst_Event_Detail/upload_event') ?>" method="post" enctype="multipart/form-data" class="mt-2">
                            <?php

                            $count = 0;
                            if (isset($_POST['view'])) {

                                foreach ($sheet as $row) {
                                    if ($plant_kode_input != $row[0]) {
                                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                             Plant yang di pilih tidak sama dengan plant yang di upload , periksa lagi kembali file excel anda
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                                        $count += 1;
                                    } else {
                                        $plt = $this->db->query("select id , plant_name , kode_plant from admisecsgp_mstplant where status = 1 and plant_name='" . $row[0] . "' ")->row();
                                        //cek zona 
                                        $cekzona = $this->db->query("select id , zone_name , kode_zona from admisecsgp_mstzone where admisecsgp_mstplant_id = '" . $plt->id . "' and kode_zona='" . $row[1] . "' and zone_name = '" . $row[2] . "' ");
                                        if ($cekzona->num_rows() <= 0) {
                                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><b>ZONA '
                                                . $row[2]  .
                                                ' </b> dengan <b> KODE ZONA ' . $row[1] . '</b> tidak terdaftar di database<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                                            $count += 1;
                                        } else {
                                            $zna = $cekzona->row();
                                            //cek data checkpoint 
                                            $cekcheckpoint = $this->db->query("select id , check_name  from admisecsgp_mstckp where admisecsgp_mstzone_id = '" . $zna->id . "' and check_name = '" . $row[3] . "' ");

                                            //cek kategori objek 
                                            $cekKategori = $this->db->query("select id , kategori_name  from admisecsgp_mstkobj where admisecsgp_mstzone_id = '" . $zna->id . "' and kategori_name = '" . $row[4] . "' ");

                                            //cek checkpoint 
                                            if ($cekcheckpoint->num_rows() <= 0) {
                                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">CHECKPOINT <b>'
                                                    . $row[3]  .
                                                    ' </b>tidak terdaftar di <b>' . $row[0] . ' - ZONA ' . $row[2] . '</b> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                                                $count += 1;
                                            } else {
                                                $checkp = $cekcheckpoint->row();
                                                $cekobjek = $this->db->query("select id , nama_objek  from admisecsgp_mstobj where admisecsgp_mstckp_id = '" . $checkp->id . "' and nama_objek = '" . $row[5] . "' ");
                                                if ($cekobjek->num_rows() <= 0) {
                                                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Objek <b>'
                                                        . $row[5]  .
                                                        ' </b>tidak terdaftar di <b>' . $row[0] . ' - ZONA ' . $row[2] . ' - CHECKPOINT ' . $row[3] . '</b> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>';
                                                    $count += 1;
                                                } else {
                                                    //cek jika event sudah ada 
                                                    $cekEvent = $this->db->query("select id from admisecsgp_mstevent where event_name='" . $row[6] . "'");
                                                    $dataobjek = $cekobjek->row();
                                                    if ($cekEvent->num_rows() <= 0) {
                                                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Event<b> '
                                                            . $row[6]  .
                                                            ' </b>tidak terdaftar di master event<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                                                        $count += 1;
                                                    } else {
                                                        $dataevent = $cekEvent->row();
                                                        //cek event exist atau tidak 
                                                        $cekEventExist = $this->db->query("select id from admisecsgp_msteventdtls where admisecsgp_mstobj_id ='" . $dataobjek->id . "' and admisecsgp_mstevent_id = '" . $dataevent->id . "' ");
                                                        if ($cekEventExist->num_rows() >= 1) {
                                                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Event<b> '
                                                                . $row[6]  .
                                                                ' </b>sudah terdaftar di objek <b>' . $row[5] . '</b><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>';
                                                            $count += 1;
                                                        }
                                                    }
                                                }
                                            }

                                            //cek kategori objek
                                            if ($cekKategori->num_rows() <= 0) {
                                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Kategori Objek <b>'
                                                    . $row[4]  .
                                                    ' </b>tidak terdaftar di <b>' . $row[0] . ' - ZONA ' . $row[2] . '</b> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>';
                                                $count += 1;
                                            }
                                        }

                                        //cek event tersedia atau tidak 

                                    }
                                }


                                //hitung total kesalahan input
                                if ($count <= 0) {
                                    redirect('Mst_Event_Detail/upload_event');
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
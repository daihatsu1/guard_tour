<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Company</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Jadwal') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Jadwal') ?>">Jadwal Patroli</a></li>
                    <li class="breadcrumb-item"><a href="">Edit Petugas Patroli</a></li>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Data</h3>

                        <div class="card-tools">
                            <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button> -->
                        </div>
                    </div>
                    <form action="<?= base_url('Admin/Mst_Jadwal/form_rubah_jadwal_petugas') ?>" method="post" id="updateJadwal">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">PLANT

                                            <?php

                                            ?>
                                        </label>
                                        <select name="plant_id" class="form-control" id="plant">
                                            <?php foreach ($plant->result() as $pl) :
                                                if ($session_plant == $pl->id) { ?>
                                                    <option selected value="<?= $pl->id ?>"><?= $pl->plant_name ?></option>
                                                <?php } else { ?>
                                                    <option value="<?= $pl->id ?>"><?= $pl->plant_name ?></option>
                                            <?php    }
                                            endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">Tahun</label>
                                        <select name="tahun" class="form-control" id="tahun">
                                            <?php for ($i = 22; $i <= 35; $i++) {
                                                if ($tahun_pilih == "20" . $i) { ?>
                                                    <option selected>20<?= $i ?></option>
                                                <?php } else { ?>
                                                    <option>20<?= $i ?></option>
                                                <?php } ?>
                                            <?php  } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">Pilih Bulan</label>
                                        <select name="bulan" class="form-control" id="bulan">
                                            <?php
                                            if ($bulan_pilih == null) {
                                                for ($bl = 0; $bl < count($daftar_bulan); $bl++) {
                                                    echo "<option>" . $daftar_bulan[$bl] . "</option>";
                                                }
                                            ?>
                                                <!-- <option>JANUARI</option>
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
                                                <option>DESEMBER</option> -->
                                            <?php } else {
                                                for ($bl = 0; $bl < count($daftar_bulan); $bl++) {
                                                    if ($daftar_bulan[$bl] == $bulan_pilih) {
                                                        echo "<option selected>" . $daftar_bulan[$bl] . "</option>";
                                                    } else {
                                                        echo "<option>" . $daftar_bulan[$bl] . "</option>";
                                                    }
                                                }
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">Pilih Tanggal</label>
                                        <select name="tanggal" class="form-control" id="tanggal">
                                            <?php for ($i = 1; $i <= 31; $i++) {
                                                if ($tanggal_pilih == $i) { ?>
                                                    <option selected><?= $i ?></option>
                                                <?php   } else { ?>
                                                    <option><?= $i ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <a href="<?= base_url('Admin/Mst_Jadwal') ?>" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <button type="submit" name="lihat" class="btn btn-sm btn-primary"><i class="fas fa-search"></i> Cari Data</button>
                        </div>
                        <!-- /.card-body -->
                    </form>
                </div>
                <!-- /.card -->

                <?php
                if (isset($_POST['lihat'])) {
                    $p_tanggal  = $_POST['tanggal'];
                    $p_tahun    = $_POST['tahun'];
                    $p_month    = $_POST['bulan'];
                    $p_bulan = "";
                    if ($p_tanggal <= 9) {
                        $p_tanggal = '0' . $_POST['tanggal'];
                    } else {
                        $p_tanggal = $_POST['tanggal'];
                    }
                    switch ($p_month) {
                        case 'JANUARI':
                            $p_bulan = '01';
                            break;
                        case 'FEBRUARI':
                            $p_bulan = '02';
                            break;
                        case 'MARET':
                            $p_bulan = '03';
                            break;
                        case 'APRIL':
                            $p_bulan = '04';
                            break;
                        case 'MEI':
                            $p_bulan = '05';
                            break;
                        case 'JUNI':
                            $p_bulan = '06';
                            break;
                        case 'JULI':
                            $p_bulan = '07';
                            break;
                        case 'AGUSTUS':
                            $p_bulan = '08';
                            break;
                        case 'SEPTEMBER':
                            $p_bulan = '09';
                            break;
                        case 'OKTOBER':
                            $p_bulan = '10';
                            break;
                        case 'NOVEMBER':
                            $p_bulan = '11';
                            break;
                        case 'DESEMBER':
                            $p_bulan = '12';
                            break;
                        default:

                            break;
                    }

                    $date_sistem = $p_tahun . "-" . $p_bulan . "-" . $p_tanggal;
                    $today       = date('Y-m-d H:i:s');

                    $tanggal_terpilih = strtotime($date_sistem . "23:59:59");
                    $tanggal_sekarang = strtotime($today);
                ?>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-sm" id="petugasTable">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>PLANT</th>
                                        <th>NAMA</th>
                                        <th>NPK</th>
                                        <th>TANGGAL</th>
                                        <th>SHIFT</th>
                                        <th>OPSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($petugas->result_array() as $ptg) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $ptg['plant_name'] ?></td>
                                            <td><?= $ptg['name'] ?></td>
                                            <td><?= $ptg['npk'] ?></td>
                                            <td><?= $date ?></td>
                                            <td><?= $ptg[$tanggal] ?></td>
                                            <td>
                                                <?php
                                                if ($tanggal_terpilih >= $tanggal_sekarang) { ?>
                                                    <!-- echo "edit di ijinkan"; -->
                                                    <a id="petugasData" data-toggle="modal" onclick="showuserdetail('<?= $ptg['id'] ?>' , '<?= $ptg['id_plant'] ?>', '<?= $ptg['id_user'] ?>' , '<?= $kolom_update ?>' , '<?= $ptg[$tanggal] ?>' , '<?= $date ?>' )" href="#modal_userDetail" class="text-success" data-backdrop="static" data-keyboard="false"><i class="fa fa-edit"></i></a>
                                                <?php } else { ?>
                                                    <!-- echo "expired date"; -->
                                                    <span class="font-italic text-danger">exp-date</span>
                                                <?php }
                                                ?>

                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php
                } ?>
            </div>
        </div>
    </div>
</section>
<!-- modal edit data Event -->
<div class="modal fade" id="modal_userDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Petugas Patroli</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="bodymodal_userDetail">

            </div>
        </div>
    </div>
</div>
<!-- edit data object -->

<script>
    function showuserdetail(idUpdate, idPlant, idUser, kolomUpdate, dataShift, datePatrol) {
        $.ajax({
            type: "post",
            url: "<?= base_url('Admin/Mst_Jadwal/load_data_petugas'); ?>",
            data: "id_update=" + idUpdate + "&plant_id=" + idPlant + "&user_id=" + idUser + "&colom_update=" + kolomUpdate + "&tanggal_patroli=" + datePatrol + "&shift=" + dataShift,
            dataType: "html",
            success: function(response) {
                $('#bodymodal_userDetail').empty();
                $('#bodymodal_userDetail').append(response);
            }
        });
    }
</script>
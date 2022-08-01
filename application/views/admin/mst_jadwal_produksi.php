<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Event</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Jadwal') ?>">Jadwal</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Jadwal') ?>">Jadwal Produksi</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
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
                <a href="<?= base_url('Admin/Mst_Jadwal_Produksi/form_rubah_jadwal_produksi') ?>" class="btn btn-sm btn-success">
                    <i class="fa fa-calendar"></i> Koreksi Jadwal Per Tanggal
                </a>
                <a href="<?= base_url('Admin/Mst_Jadwal_Produksi/form_revisi_upload_jadwal') ?>" class="btn btn-sm btn-info">
                    <i class="fa fa-file-excel"></i> Upload Koreksi Jadwal
                </a>
                <div class="card mt-2">
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="<?= base_url('Admin/Mst_Jadwal_Produksi') ?>" method="post">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">PLANT</label>
                                        <select name="plant" class="form-control" id="plant">
                                            <?php foreach ($plant->result() as $pl) :
                                                if ($pl->id == $plant_id) { ?>
                                                    <option selected value="<?= $pl->id ?>"><?= $pl->plant_name ?></option>
                                                <?php } else { ?>
                                                    <option value="<?= $pl->id ?>"><?= $pl->plant_name ?></option>
                                            <?php  }
                                            endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">TAHUN</label>
                                        <select name="tahun" class="form-control" id="tahun">
                                            <?php for ($i = 22; $i <= 35; $i++) { ?>
                                                <option>20<?= $i ?></option>
                                            <?php  } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">BULAN</label>
                                        <select name="bulan" class="form-control" id="bulan">
                                            <?php for ($kl = 0; $kl <= 11; $kl++) {
                                                if ($bulan == $daftar_bulan[$kl]) { ?>
                                                    <option selected><?= $daftar_bulan[$kl] ?></option>
                                                <?php } else { ?>
                                                    <option><?= $daftar_bulan[$kl] ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div style="margin-top: 10px;position:absolute" class="form-group">
                                        <button name="lihat" class="btn btn-primary btn-sm mt-4"><i class="fa fa-search"></i> Lihat Jadwal</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <?php
                if (isset($_POST['lihat'])) {

                    if ($jadwal->num_rows() > 0) { ?>
                        <div class="card">
                            <div class="card-body">
                                <table class="small">
                                    <tr>
                                        <td>TIPE</td>
                                        <td>:</td>
                                        <td>Jadwal Produksi</td>
                                    </tr>
                                    <tr>
                                        <td>TAHUN</td>
                                        <td>:</td>
                                        <td><?= $tahun ?></td>
                                    </tr>
                                    <tr>
                                        <td>Bulan</td>
                                        <td>:</td>
                                        <td><?= $bulan ?></td>
                                    </tr>
                                </table>
                                <table id="jadwal_produksi" class="table table-sm small table-striped  table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="120px">PLANT</th>
                                            <th>ZONA</th>
                                            <th>SHIFT</th>
                                            <?php for ($i = 1; $i <= 31; $i++) {  ?>
                                                <th><?= $i ?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($jadwal->result() as $jwl) : ?>
                                            <tr>
                                                <td style="width: 30px;"><?= $jwl->plant_name ?></td>
                                                <td><?= $jwl->zone_name ?></td>
                                                <td><?= $jwl->nama_shift ?></td>
                                                <td style="color:<?= $jwl->TGL_1 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_1 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_2 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_2 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_3 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_3 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_4 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_4 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_5 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_5 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_6 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_6 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_7 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_7 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_8 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_8 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_9 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_9 == '0' ? 'OFF' : $jwl->TGL_9 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_10 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_10 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_11 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_11 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_12 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_12 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_13 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_13 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_14 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_14 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_15 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_15 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_16 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_16 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_17 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_17 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_18 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_18 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_19 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_19 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_20 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_20 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_21 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_21 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_22 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_22 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_23 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_23 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_24 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_24 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_25 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_25 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_26 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_26 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_27 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_27 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_28 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_28 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_29 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_29 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_30 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_30 ?>
                                                </td>
                                                <td style="color:<?= $jwl->TGL_31 == 'OFF' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->TGL_31 ?>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php  } else { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Tidak ada jadwal di bulan ini
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                <?php }
                }
                ?>
            </div>

        </div>

    </div>
</section>





<script>
    $(document).ready(function() {
        $('#jadwal_produksi').DataTable({
            fixedHeader: true,
            scrollX: "200px",
            scrollCollapse: false,
            paging: false,
            ordering: false,
            searching: false,
            info: false,
            fixedColumns: {
                left: 3,
                right: 2
            }
        });
    });
</script>
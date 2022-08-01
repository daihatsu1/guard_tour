<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Event</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Jadwal') ?>">Jadwal</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Jadwal') ?>">Jadwal Patroli</a></li>
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
                <a href="<?= base_url('Admin/Mst_Jadwal/form_rubah_jadwal_petugas') ?>" class="btn btn-sm btn-success">
                    <i class="fa fa-file-excel"></i> Koreksi Jadwal Patroli
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
                        <form action="<?= base_url('Admin/Mst_Jadwal') ?>" method="post">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">PLANT</label>
                                        <select name="plant" class="form-control" id="plant">
                                            <?php foreach ($plant->result() as $pl) :
                                                if ($pl->kode_plant == $plant_id) { ?>
                                                    <option selected value="<?= $pl->kode_plant ?>"><?= $pl->plant_name ?></option>
                                                <?php } else { ?>
                                                    <option value="<?= $pl->kode_plant ?>"><?= $pl->plant_name ?></option>
                                            <?php  }
                                            endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">TAHUN</label>
                                        <select name="tahun" class="form-control" id="tahun">
                                            <?php for ($i = 22; $i <= 35; $i++) {

                                                if ($tahun == '20' . $i) { ?>
                                                    <option selected>20<?= $i ?></option>
                                                <?php  } else { ?>
                                                    <option>20<?= $i ?></option>
                                            <?php   }
                                            } ?>
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
                                <table>
                                    <tr>
                                        <td>Tahun</td>
                                        <td>:</td>
                                        <td><?= $tahun ?></td>
                                    </tr>
                                    <tr>
                                        <td>Bulan</td>
                                        <td>:</td>
                                        <td><?= $bulan ?></td>
                                    </tr>
                                </table>
                                <a target="_blank" href="<?= base_url('Admin/Mst_Jadwal/download_jadwal?bulan=' . $bulan . '&tahun=' . $tahun . '&plant_id=' . $plant_id . '') ?>" class="btn btn-success btn-sm "><i class="fas fa-download"></i> Download Jadwal</a>
                                <table id="jadwal_patroli" class="table table-bordered small table-sm">
                                    <thead>
                                        <tr>
                                            <th width="90px">PLANT</th>
                                            <th>NPK</th>
                                            <th width="120px">NAMA</th>
                                            <?php for ($i = 1; $i <= 31; $i++) {  ?>
                                                <th><?= $i ?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($jadwal->result() as $jwl) : ?>
                                            <tr>
                                                <td><?= $jwl->plant_name ?></td>
                                                <td><?= $jwl->npk ?></td>
                                                <td><?= $jwl->name ?></td>
                                                <td style="color:<?= $jwl->tanggal_1 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_1 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_2 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_2 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_3 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_3 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_4 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_4 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_5 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_5 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_6 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_6 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_7 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_7 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_8 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_8 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_9 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_9 == '0' ? 'LIBUR' : $jwl->tanggal_9 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_10 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_10 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_11 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_11 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_12 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_12 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_13 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_13 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_14 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_14 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_15 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_15 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_16 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_16 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_17 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_17 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_18 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_18 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_19 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_19 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_20 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_20 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_21 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_21 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_22 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_22 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_23 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_23 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_24 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_24 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_25 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_25 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_26 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_26 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_27 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_27 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_28 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_28 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_29 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_29 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_30 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_30 ?>
                                                </td>
                                                <td style="color:<?= $jwl->tanggal_31 == 'LIBUR' ? 'red' : 'blue' ?>">
                                                    <?= $jwl->tanggal_31 ?>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php  } else { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Tidak ada jadwal patroli di bulan ini
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
        $('#jadwal_patroli').DataTable({
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
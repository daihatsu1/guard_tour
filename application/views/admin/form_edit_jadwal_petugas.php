<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Company</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Jadwal_Patroli') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Jadwal_Patroli') ?>">Jadwal Patroli</a></li>
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
                    <form action="<?= base_url('Admin/Mst_Jadwal_Patroli/form_rubah_jadwal_petugas') ?>" method="post" id="updateJadwal">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">PLANT</label>
                                        <select name="plant_id" class="form-control" id="plant">
                                            <?php foreach ($plant->result() as $pl) :
                                                if ($session_plant == $pl->plant_id) { ?>
                                                    <option selected value="<?= $pl->plant_id ?>"><?= $pl->plant_name ?></option>
                                                <?php } else { ?>
                                                    <option value="<?= $pl->plant_id ?>"><?= $pl->plant_name ?></option>
                                            <?php    }
                                            endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">Tanggal </label>
                                        <input autocomplete="off" value="<?= $session_date ?>" placeholder="<?= date('Y-m-d') ?>" type="text" id="tgl1" name="date" class="form-control">
                                    </div>
                                </div>

                            </div>

                            <a href="<?= base_url('Admin/Mst_Jadwal_Patroli') ?>" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <button type="submit" name="lihat" class="btn btn-sm btn-primary"><i class="fas fa-search"></i> Cari Data</button>
                        </div>
                        <!-- /.card-body -->
                    </form>
                </div>
                <!-- /.card -->

                <?php
                if (isset($_POST['lihat'])) {

                    if ($petugas->num_rows() > 0) { ?>
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
                                        foreach ($petugas->result() as $ptg) : ?>
                                            <tr>

                                                <td><?= $no++ ?></td>
                                                <td><?= $ptg->plant ?></td>
                                                <td><?= $ptg->nama ?></td>
                                                <td><?= $ptg->npk ?></td>
                                                <td><?= $ptg->tanggal ?></td>
                                                <td><?= $ptg->shift ?></td>
                                                <td>
                                                    <a id="petugasData" data-toggle="modal" onclick="showuserdetail('<?= $ptg->plant_id ?>' , '<?= $ptg->user_id ?>' , '<?= $ptg->shift ?>', '<?= $ptg->tanggal ?>' , '<?= $ptg->shift_id ?>' , '<?= $ptg->nama ?>', '<?= $ptg->npk ?>')" href="#modal_userDetail" class="text-success" data-backdrop="static" data-keyboard="false"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } else { ?>
                        <h3>Tidak ada data</h3>
                    <?php }

                    ?>

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
    function showuserdetail(idPlant, idUser, dataShift, date, shiftId, name, npk) {
        $.ajax({
            type: "post",
            url: "<?= base_url('Admin/Mst_Jadwal_Patroli/load_data_petugas'); ?>",
            data: "plant_id=" + idPlant + "&user_id=" + idUser + "&shift=" + dataShift + "&tanggal_patroli=" + date + "&shift_id=" + shiftId + "&nama=" + name + "&npk=" + npk,
            dataType: "html",
            success: function(response) {
                $('#bodymodal_userDetail').empty();
                $('#bodymodal_userDetail').append(response);
            }
        });
    }
</script>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Company</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Jadwal_Produksi') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Jadwal_Produksi') ?>">Jadwal Produksi</a></li>
                    <li class="breadcrumb-item"><a href="">Edit Jadwal Produksi</a></li>
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
                    <form action="<?= base_url('Mst_Jadwal_Produksi/form_rubah_jadwal_produksi') ?>" method="post" id="updateJadwal">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">PLANT </label>
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

                            <a href="<?= base_url('Mst_Jadwal_Produksi') ?>" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <button type="submit" name="lihat" class="btn btn-sm btn-primary"><i class="fas fa-search"></i> Cari Data</button>

                        </div>
                        <!-- /.card-body -->
                    </form>
                </div>
                <!-- /.card -->

                <?php
                if (isset($_POST['lihat'])) {
                    if ($produksi->num_rows() > 0) {
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
                                            <th>ZONA</th>
                                            <th>SHIFT</th>
                                            <th>TANGGAL</th>
                                            <th>STATUS PRODUKSI</th>
                                            <th>STATUS ZONA</th>
                                            <th>OPSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($produksi->result_array() as $prd) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $prd['plant_name'] ?></td>
                                                <td><?= $prd['zone_name'] ?></td>
                                                <td><?= $prd['nama_shift'] ?></td>
                                                <td><?= $date ?></td>
                                                <td><?= $prd['status_produksi'] ?></td>
                                                <td><?= $prd['status_zona'] ?></td>
                                                <td>
                                                    <?php
                                                    if ($tanggal_terpilih >= $tanggal_sekarang) { ?>
                                                        <!-- echo "edit di ijinkan"; -->
                                                        <a id="petugasData" data-toggle="modal" onclick="showuserdetail('<?= $prd['id'] ?>','<?= $prd['id_plant'] ?>','<?= $prd['id_zona'] ?>','<?= $prd['id_shift'] ?>','<?= $prd[$kolom_update_tgl] ?>','<?= $kolom_update_stat_zona ?>','<?= $kolom_update_tgl ?>','<?= $prd['status_zona'] ?>' ,'<?= $date ?>')" href="#modal_userDetail" class="text-success" data-backdrop="static" data-keyboard="false"><i class="fa fa-edit"></i></a>
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
                    <?php } else { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Tidak ada data
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>
                <?php
                } ?>
            </div>
        </div>
    </div>
</section>

<!-- modal edit data zona -->
<div class="modal fade" id="tambah-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
            </div>
            <div class="modal-body">
                <form action="#" id="submitDataTambah">

                    <label for="">DAFTAR PLANT</label>
                    <select class="form-control" name="plant_id3" id="plant_id">
                        <option selected value="">Pilih Plant</option>
                        <?php foreach ($plant->result() as $plt) : ?>
                            <option value="<?= $plt->id ?>"><?= $plt->plant_name ?></option>
                        <?php endforeach ?>
                    </select>
                    <span id="info" style="display: none;" class="text-danger font-italic small">load data zone . . .</span>
                    <div id="list_zone">

                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <label for="">TAHUN</label>
                            <select name="tahun_2" class="form-control" id="tahun_2">
                                <?php for ($i = 22; $i <= 35; $i++) { ?>
                                    <option>20<?= $i ?></option>
                                <?php  } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="">BULAN</label>
                            <select name="bulan_2" class="form-control" id="bulan_2">
                                <?php
                                for ($bl = 0; $bl < count($daftar_bulan); $bl++) {
                                    echo "<option>" . $daftar_bulan[$bl] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="">TANGGAL</label>
                            <select name="tanggal_2" class="form-control" id="tanggal_2">
                                <?php for ($i = 1; $i <= 31; $i++) { ?>
                                    <option><?= $i ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <label for="">SHIFT</label>
                    <select name="shift_2" id="shift_2" class="form-control">
                        <?php foreach ($mst_shift->result() as $shf) : ?>
                            <option value="<?= $shf->id ?>"><?= $shf->nama_shift ?></option>
                        <?php endforeach ?>
                    </select>
                    <label for="">STATUS PRODUKSI</label>
                    <select name="status_produksi_2" id="status_produksi_2" class="form-control">
                        <?php foreach ($mst_produksi->result() as $prdc) : ?>
                            <option value="<?= $prdc->id ?>"><?= $prdc->name ?></option>
                        <?php endforeach ?>
                    </select>
                    <label for="">STATUS ZONA</label>
                    <select name="status_zona_2" id="status_zona_2" class="form-control">
                        <option value="1">ON</option>
                        <option value="0">OFF</option>
                    </select>
                    <div class="alert alert-danger" id="inf" style="display: none ;">
                        <p class="small font-italic">harap tunggu sedang memperbarui data</p>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="" class="btn btn-sm btn-primary">Simpan Data</button>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- edit data zona -->


<!-- modal edit data Event -->
<div class="modal fade" id="modal_userDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Jadwal Produksi</h5>
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
    function showuserdetail(idUpdate, idPlant, idZona, idShift, idProduksi, colomStatusZona, colomProduksi, statusZona, dateProduksi) {

        $.ajax({
            type: "post",
            url: "<?= base_url('Mst_Jadwal_Produksi/load_data_produksi'); ?>",
            data: "id_update=" + idUpdate + "&plant_id=" + idPlant + "&zona_id=" + idZona + "&colom_update_produksi=" + colomProduksi + "&colom_update_status_zona=" + colomStatusZona + "&tanggal_produksi=" + dateProduksi + "&shift_id=" + idShift + "&produksi_id=" + idProduksi + "&status_zona=" + statusZona,
            dataType: "html",
            success: function(response) {
                $('#bodymodal_userDetail').empty();
                $('#bodymodal_userDetail').append(response);
            }
        });
    }

    // 
    $("select[name=plant_id3").on('change', function() {
        var id = $("select[name=plant_id3] option:selected").val();
        // console.log(id)
        if (id == null || id == "") {
            document.getElementById('list_zone').innerHTML = "";
        } else {
            $.ajax({
                url: "<?= base_url('Mst_Jadwal_Produksi/showZone') ?>",
                method: "POST",
                data: "id=" + id,
                beforeSend: function() {
                    document.getElementById('info').style.display = "block"
                },
                complete: function() {
                    document.getElementById('info').style.display = "none"

                },
                success: function(e) {
                    document.getElementById('list_zone').innerHTML = e;
                    // console.log(e);
                }
            })
        }
    });



    $("#submitDataTambah").on('submit', function(e) {
        e.preventDefault();
        var id = $("select[name=plant_id3] option:selected").val();
        if (id == "" || id == null) {
            Swal.fire({
                title: 'Perhatian!',
                text: 'pilih plant ',
                icon: 'error',
            }).then((result) => {})
        } else {
            $.ajax({
                url: "<?= base_url('Mst_Jadwal_Produksi/input') ?>",
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function() {
                    document.getElementById("inf").style.display = "block";
                },
                complete: function() {
                    document.getElementById("inf").style.display = "none";
                },
                success: function(e) {
                    alert(e)
                    // if (e == 1) {
                    //     Swal.fire({
                    //         title: 'Berhasil!',
                    //         text: 'jadwal dirubah',
                    //         icon: 'success',
                    //     }).then((result) => {
                    //         location.reload();
                    //     })
                    // } else {
                    //     Swal.fire({
                    //         title: 'Error !',
                    //         text: e,
                    //         icon: 'error',
                    //     }).then((result) => {})
                    // }
                }
            })

        }
    })
</script>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Zona</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Checkpoint') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Checkpoint') ?>">Checkpoint</a></li>
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
                        <h3 class="card-title">Daftar Checkpoint</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button> -->
                        </div>
                    </div>
                    <div class="card-body">
                        <a href="<?= base_url('Admin/Mst_Checkpoint/form_add') ?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Checkpoint</a>
                        <a href="<?= base_url('Admin/Mst_Checkpoint/form_upload') ?>" class="btn btn-sm btn-success"><i class="fa fa-file-excel"></i> Upload Checkpoint</a>

                        <form method="post" action="<?= base_url('Admin/Mst_Checkpoint/multipleDelete') ?>">
                            <div class="row justify-content-end">
                                <button onclick="return confirm('Yakin Hapus Data ?')" id="btn_delete_all" style="display:none ;" class="btn btn-danger btn-sm mb-2 mr-2"> <i class="fas fa-trash"></i> HAPUS DATA TERPILIH</button>
                            </div>
                            <table id="example" class="mt-1 table-sm table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px;">
                                            <input id="check-all" type="checkbox">
                                        </th>
                                        <th>NO</th>
                                        <th>PLANT</th>
                                        <th>ZONA</th>
                                        <th>NAMA CHECKPOINT</th>
                                        <th>ID CHECKPOINT</th>
                                        <th>STATUS</th>
                                        <th>OPSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($checkpoint->result() as $zn) : ?>
                                        <tr>
                                            <td><input id="check-item" class="check-item" type="checkbox" name="id_check[]" value="<?= $zn->id ?>"> </td>
                                            <td><?= $no++ ?></td>
                                            <td><?= $zn->plant_name ?></td>
                                            <td><?= $zn->zone_name ?></td>
                                            <td><?= $zn->check_name ?></td>
                                            <td><?= $zn->check_no ?></td>
                                            <td><?= $zn->status == 1 ? 'ACTIVE' : 'INACTIVE' ?></td>
                                            <td>
                                                <a href="<?= base_url('Admin/Mst_Checkpoint/hapus/' . $zn->id) ?>" onclick="return confirm('Yakin Hapus ?')" class='text-danger' title="hapus data"><i class="fa fa-trash"></i></a>

                                                <a data-toggle="modal" data-target="#edit-data" class=" ml-2 text-primary" title="lihat data" data-backdrop="static" data-keyboard="false" data-id="<?= $zn->id ?>" data-check="<?= $zn->check_name ?>" data-check_no="<?= $zn->check_no ?>" data-zone="<?= $zn->zone_name ?>" data-others="<?= $zn->others ?>" data-status="<?= $zn->status ?>" data-durasi="<?= $zn->durasi_batas_atas ?>" data-durasi2="<?= $zn->durasi_batas_bawah ?>" data-plant="<?= $zn->plant_name ?>"><i class="fa fa-eye"></i></a>

                                                <a href="<?= base_url('Admin/Mst_Checkpoint/edit?check_id=' . $zn->id) ?>&id_zona=<?= $zn->zona_id ?>&id_plant=<?= $zn->plant_id ?>" class=' ml-2 text-success' title="edit data"><i class="fa fa-edit"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
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


<!-- modal edit data zona -->
<div class="modal fade" id="edit-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">PLANT</label>
                            <input type="text" readonly autocomplete="off" id="plant" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">ZONA</label>
                            <input type="text" readonly autocomplete="off" id="zona" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">ID CHECKPOINT</label>
                            <input type="text" readonly autocomplete="off" id="check_no" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">NAMA CHECKPOINT</label>
                            <input type="text" readonly autocomplete="off" id="check" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">DURASI BATAS ATAS</label>
                            <input type="text" readonly autocomplete="off" id="durasi" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">DURASI BATAS BAWAH</label>
                            <input type="text" readonly autocomplete="off" id="durasi2" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">STATUS</label>
                            <input type="text" readonly class="form-control" id="status">
                        </div>

                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <textarea class="form-control" readonly id="others" cols="4" rows="2"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <!-- edit data zona -->



    <script>
        $(document).ready(function() {
            $(this).attr("data-check_name")
            // Untuk sunting modal data edit zona
            $("#edit-data").on("show.bs.modal", function(event) {
                var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
                var modal = $(this);
                // Isi nilai pada field
                modal.find("#zona").attr("value", div.data("zone"));
                modal.find("#check").attr("value", div.data("check"));
                modal.find("#check_no").attr("value", div.data("check_no"));
                modal.find("#plant").attr("value", div.data("plant"));
                modal.find("#durasi").attr("value", div.data("durasi") + ' menit');
                modal.find("#durasi2").attr("value", div.data("durasi2") + ' menit');
                if (div.data("status") == 1) {
                    modal.find("#status").attr("value", "ACTIVE");
                } else {
                    modal.find("#status").attr("value", "INACTIVE");
                }
                document.getElementById("others").value = div.data("others");
            });
        });

        $(".check-item").click(function() {
            var panjang = $('[name="id_check[]"]:checked').length;
            if (panjang > 0) {
                document.getElementById('btn_delete_all').style.display = "block";
            } else {
                document.getElementById('btn_delete_all').style.display = "none";

            }
        })

        $("#check-all").click(function() {
            if ($(this).is(":checked")) {
                $(".check-item").prop("checked", true);
                document.getElementById('btn_delete_all').style.display = "block";
                var panjang = $('[name="id_check[]"]:checked').length;
            } else {
                $(".check-item").prop("checked", false);
                document.getElementById('btn_delete_all').style.display = "none";
            }
        })
    </script>
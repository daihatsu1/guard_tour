<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Zona</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_objek') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="#">Objek</a></li>
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
                        <h3 class="card-title">Daftar Objek</h3>

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
                        <a href="<?= base_url('Mst_objek/form_add') ?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Objek</a>

                        <a href="<?= base_url('Mst_objek/form_upload') ?>" class="btn btn-sm btn-success"><i class="fa fa-file-excel"></i> Upload Objek</a>
                        <form method="post" action="<?= base_url('Mst_objek/multipleDelete') ?>">
                            <div class="row justify-content-end">
                                <button onclick="return confirm('Yakin Hapus Data ?')" id="btn_delete_all" style="display:none ;" class="btn btn-danger btn-sm mb-2 mr-2"> <i class="fas fa-trash"></i> HAPUS DATA TERPILIH</button>
                            </div>

                            <table id="example" class="mt-1 table-sm table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px;">
                                            <input id="check-all" type="checkbox">
                                        </th>
                                        <th style="width: 50px;">NO</th>
                                        <th>PLANT</th>
                                        <th>ZONA</th>
                                        <th>NAMA CHECKPOINT</th>
                                        <th>KATEGORI</th>
                                        <th>NAMA OBJEK</th>
                                        <th>STATUS</th>
                                        <th>OPSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($objek->result() as $zn) : ?>
                                        <tr>
                                            <td><input id="check-item" class="check-item" type="checkbox" name="id_objek[]" value="<?= $zn->objek_id ?>"> </td>
                                            <td><?= $no++ ?></td>
                                            <td><?= $zn->plant_name ?></td>
                                            <td><?= $zn->zone_name ?></td>
                                            <td><?= $zn->check_name ?></td>
                                            <td><?= $zn->kategori_name ?></td>
                                            <td><?= $zn->nama_objek ?></td>
                                            <td><?= $zn->status == 1 ? 'ACTIVE' : 'INACTIVE' ?></td>
                                            <td>
                                                <!-- data-kategori="<?= $zn->kategori_name ?> -->
                                                <a href="<?= base_url('Mst_objek/hapus/' . $zn->objek_id) ?>" onclick="return confirm('Yakin Hapus ?')" class='text-danger' title="hapus data"><i class="fa fa-trash"></i></a>

                                                <a data-toggle="modal" data-target="#edit-data" class=" ml-2 text-primary" title="lihat data" data-backdrop="static" data-keyboard="false" data-id="<?= $zn->objek_id ?>" data-plant="<?= $zn->plant_name ?>" data-check="<?= $zn->check_name ?>" data-zone="<?= $zn->zone_name ?>" data-others="<?= $zn->others ?>" data-status="<?= $zn->status ?>" data-objek_name="<?= $zn->nama_objek ?>" data-kategori="<?= $zn->kategori_name ?>"><i class="fa fa-eye"></i></a>

                                                <a href=" <?= base_url('Mst_objek/edit?check_id=' . $zn->objek_id) ?>&zona_id=<?= $zn->zona_id ?>&id_checkpoint=<?= $zn->id_check ?>&plant_id=<?= $zn->plant_id ?>" class=' ml-2 text-success' title="edit data"><i class="fa fa-edit"></i></a>
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
                            <input type="text" readonly autocomplete="off" id="plant_name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">ZONA</label>
                            <input type="text" readonly autocomplete="off" id="zona" class="form-control">
                        </div>


                        <div class="form-group">
                            <label for="">NAMA CHECKPOINT</label>
                            <input type="text" readonly autocomplete="off" id="check" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">NAMA OBJEK</label>
                            <input type="text" readonly autocomplete="off" id="objek" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">KATEGORI</label>
                            <input type="text" readonly autocomplete="off" id="kategori" class="form-control">
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
                modal.find("#kategori").attr("value", div.data("kategori"));
                modal.find("#objek").attr("value", div.data("objek_name"));
                modal.find("#plant_name").attr("value", div.data("plant"));
                if (div.data("status") == 1) {
                    modal.find("#status").attr("value", "ACTIVE");
                } else {
                    modal.find("#status").attr("value", "INACTIVE");
                }
                document.getElementById("others").value = div.data("others");
            });
        });

        $(".check-item").click(function() {
            var panjang = $('[name="id_objek[]"]:checked').length;
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
                var panjang = $('[name="id_objek[]"]:checked').length;
            } else {
                $(".check-item").prop("checked", false);
                document.getElementById('btn_delete_all').style.display = "none";
            }
        })
    </script>
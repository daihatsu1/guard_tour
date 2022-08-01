<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Zona</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Zona') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Zona') ?>">Zona</a></li>
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
                        <h3 class="card-title">Daftar Zona</h3>

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
                        <a href="<?= base_url('Admin/Mst_Zona/form_add') ?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Zona</a>
                        <table id="example" class="table-sm mt-1 table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>WILAYAH</th>
                                    <th>PLANT</th>
                                    <th>KODE ZONA</th>
                                    <th>NAMA ZONA</th>
                                    <th>STATUS</th>
                                    <th>OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($zona->result() as $zn) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $zn->site_name ?></td>
                                        <td><?= $zn->plant_name ?></td>
                                        <td><?= $zn->kode_zona ?></td>
                                        <td><?= $zn->zone_name ?></td>
                                        <td><?= $zn->status == 1 ? 'ACTIVE' : 'INACTIVE' ?></td>
                                        <td>

                                            <a href="<?= base_url('Admin/Mst_Zona/hapus/' . $zn->id) ?>" onclick="return confirm('Yakin Hapus ?')" class='text-danger' title="hapus data"><i class="fa fa-trash"></i></a>

                                            <a data-toggle="modal" data-target="#edit-data" class="text-primary ml-2" title="lihat data" data-backdrop="static" data-keyboard="false" data-id="<?= $zn->id ?>" data-zone_name="<?= $zn->zone_name ?>" data-plant="<?= $zn->plant_name ?>" data-kodezona="<?= $zn->kode_zona ?>" data-others="<?= $zn->others ?>" data-status="<?= $zn->status ?>"><i class="fa fa-eye"></i></a>

                                            <a href="<?= base_url('Admin/Mst_Zona/edit?zone_id=' . $zn->id) ?>" class='text-success ml-2' title="edit data"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
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
                <h5 class="modal-title" id="exampleModalLabel">Detail Zona</h5>
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
                            <label for="">NAMA ZONA</label>
                            <input type="text" readonly autocomplete="off" id="zone_name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">KODE ZONA</label>
                            <input type="text" readonly autocomplete="off" id="kode_zona" class="form-control">
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
        function cek() {
            if (document.getElementById("plant_no").value == "") {
                alert("plant harus di pilih");
                $("#plant_no").focus();
                return false
            } else if (document.getElementById("zone_no").value == "") {
                alert("isi id zona");
                $("#zone_no").focus();
                return false
            } else if (document.getElementById("zone_name").value == "") {
                alert("isi nama zona");
                $("#zone_name").focus();
                return false
            }
            return;
        }


        $(document).ready(function() {
            $(this).attr("data-zone_name")
            // Untuk sunting modal data edit zona
            $("#edit-data").on("show.bs.modal", function(event) {
                var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
                var modal = $(this);
                // Isi nilai pada field
                modal.find("#plant").attr("value", div.data("plant"));
                modal.find("#zone_name").attr("value", div.data("zone_name"));
                modal.find("#kode_zona").attr("value", div.data("kodezona"));
                if (div.data("status") == 1) {
                    modal.find("#status").attr("value", "ACTIVE");
                } else {
                    modal.find("#status").attr("value", "INACTIVE");
                }
                document.getElementById("others").value = div.data("others");
            });

        });
    </script>
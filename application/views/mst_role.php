<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Role User</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Role') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Mst_Role') ?>">Role User</a></li>
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
                <?php  } else if ($this->session->flashdata("fail")) { ?>
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
                        <h3 class="card-title">Role User</h3>
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
                        <a href="<?= base_url('Mst_Role/form_add') ?>" class="btn btn-sm btn-primary" data-backdrop="static">
                            <i class="fa fa-plus"></i> Tambah Role User
                        </a>

                        <table id="example2" class="table-sm mt-1 table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <!-- <th>ID ROLE</th> -->
                                    <th>LEVEL</th>
                                    <th>STATUS</th>
                                    <th>OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($role->result() as $zn) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $zn->level ?></td>
                                        <td><?= $zn->status == 1 ? 'ACTIVE' : 'INACTIVE' ?></td>
                                        <td>

                                            <a href="<?= base_url('Mst_Role/hapus/' . $zn->role_id) ?>" onclick="return confirm('Yakin Hapus ?')" class='text-danger '><i class="fas fa-trash"></i></a>


                                            <a href='' data-toggle="modal" data-target="#edit-data" class="text-primary  ml-3 " data-backdrop="static" data-keyboard="false" data-id="<?= $zn->role_id ?>" data-status="<?= $zn->status ?>" data-idrole="<?= $zn->role_id ?>" data-level="<?= $zn->level ?>"><i class="fa fa-eye"></i></a>

                                            <a href="<?= base_url('Mst_Role/edit?role_id=' . $zn->role_id) ?>" class='text-success  ml-3 '><i class="fa fa-edit"></i></a>
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
</section>

<!-- modal edit data Event -->
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
                <div class="form-group">
                    <label>ID ROLE</label>
                    <input type="text" readonly class="form-control" id="idrole">
                </div>
                <div class="form-group">
                    <label>LEVEL</label>
                    <input type="text" readonly class="form-control" id="level">
                </div>
                <div class="form-group">
                    <label>STATUS</label>
                    <input type="text" readonly class="form-control" id="status2">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- edit data object -->



<script>
    function cek() {
        if (document.getElementById("id_role").value == "") {
            alert("isi id role");
            $("#id_role").focus();
            return false
        } else if (document.getElementById("level").value == "") {
            alert("isi level ");
            $("#level").focus();
            return false
        }
        return;
    }

    $("#edit-data").on("show.bs.modal", function(event) {
        var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
        var modal = $(this);
        // Isi nilai pada field
        modal.find("#level").attr("value", div.data("level"));
        modal.find("#idrole").attr("value", div.data("idrole"));
        if (div.data("status") == 1) {
            modal.find("#status2").attr("value", "ACTIVE");
        } else {
            modal.find("#status2").attr("value", "INACTIVE");
        }
    });
</script>
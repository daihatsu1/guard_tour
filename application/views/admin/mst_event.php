<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Event</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Event') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Event') ?>">Event</a></li>
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
                        <h3 class="card-title">Data Event</h3>
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
                        <a href="<?= base_url('Admin/Mst_Event/form_add') ?>" class="btn btn-sm btn-primary">
                            <i class="fa fa-plus"></i> Tambah Event
                        </a>
                        <a href="<?= base_url('Admin/Mst_Event/form_upload_event') ?>" class="btn btn-sm btn-success">
                            <i class="fa fa-file-excel"></i> Upload Event
                        </a>
                        <table id="example" class="table-sm mt-1 table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">NO</th>
                                    <th>KATEGORI</th>
                                    <th>EVENT</th>
                                    <th>STATUS</th>
                                    <th>OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($event->result() as $zn) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $zn->kategori_name ?></td>
                                        <td><?= $zn->event_name ?></td>
                                        <td><?= $zn->status  == 1 ? 'ACTIVE'  : 'INACTIVE' ?></td>
                                        <td>

                                            <a href="<?= base_url('Admin/Mst_Event/hapus/' . $zn->event_id) ?>" onclick="return confirm('Yakin Hapus ?')" class='text-danger' title="hapus data"><i class="fa fa-trash"></i></a>


                                            <a href='' data-toggle="modal" data-target="#edit-data" class="text-primary ml-2 " title="lihat data" data-backdrop="static" data-keyboard="false" data-id="<?= $zn->event_id ?>" data-status="<?= $zn->status ?>" data-event_name="<?= $zn->event_name ?>" data-kategori="<?= $zn->kategori_name ?>"><i class="fa fa-eye"></i></a>


                                            <a href="<?= base_url('Admin/Mst_Event/edit?event_id=' . $zn->event_id) ?>" class='text-success ml-2 ' title="edit data"><i class="fa fa-edit"></i></a>
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
                <h5 class="modal-title" id="exampleModalLabel">Edit Event</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <!-- <div class="form-group">
                    <label>PLANT</label>
                    <input type="text" readonly class="form-control" id="plant2">
                </div>
                <div class="form-group">
                    <label>ZONA</label>
                    <input type="text" readonly class="form-control" id="zona2">
                </div>
                 -->
                <div class="form-group">
                    <label>KATEGORI OBJEK</label>
                    <input type="text" readonly class="form-control" id="kategori2">
                </div>
                <div class="form-group">
                    <label>NAMA EVENT</label>
                    <input type="text" readonly class="form-control" id="event_name2">
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
    $("#edit-data").on("show.bs.modal", function(event) {
        var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
        var modal = $(this);
        // Isi nilai pada field
        modal.find("#event_name2").attr("value", div.data("event_name"));
        // modal.find("#plant2").attr("value", div.data("plant"));
        // modal.find("#zona2").attr("value", div.data("zona"));
        modal.find("#kategori2").attr("value", div.data("kategori"));
        if (div.data("status") == 1) {
            modal.find("#status2").attr("value", "ACTIVE");
        } else {
            modal.find("#status2").attr("value", "INACTIVE");
        }
    });
</script>
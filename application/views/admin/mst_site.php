<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Wilayah</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Master</a></li>
                    <li class="breadcrumb-item"><a href="">Wilayah</a></li>
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
                        <h3 class="card-title">Data Wilayah</h3>

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
                        <!-- <a href="<?= base_url('Mst_Site/form_add') ?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> -->
                        <!-- Tambah Wilayah</a> -->

                        <table id="example2" class="table-sm mt-1 table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>PERUSAHAAN</th>
                                    <th>WILAYAH</th>
                                    <th>STATUS</th>
                                    <th>OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($wilayah->result() as $zn) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $zn->comp_name ?></td>
                                        <td><?= $zn->site_name ?></td>
                                        <td><?= $zn->status == 1 ? 'ACTIVE'  : 'INACTIVE' ?></td>
                                        <td>
                                            <!-- <a href="<?= base_url('Mst_Site/hapus/' . $zn->id) ?>" onclick="return confirm('Yakin Hapus ?')" class='text-danger' title="hapus data"><i class="fa fa-trash"></i></a> -->

                                            <a href='' data-toggle="modal" data-target="#edit-data" class="text-primary" title="lihat data" data-backdrop="static" data-keyboard="false" data-id="<?= $zn->id ?>" data-ket="<?= $zn->others ?>" data-site_name="<?= $zn->site_name ?>" data-comp_name="<?= $zn->comp_name ?>" data-status="<?= $zn->status ?>"><i class="fa fa-eye"></i></a>

                                            <!-- <a href="<?= base_url('Mst_Site/edit?site_id=' . $zn->id) ?>" class='text-success' title="edit data"><i class="fa fa-edit"></i></a> -->
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

<!-- tambah data wilayah -->

<!-- tambah data wilayah -->


<!-- modal edit data wilayah -->
<div class="modal fade" id="edit-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group">
                        <label for="">COMPANY</label>
                        <input type="text" readonly class="form-control" id="comp">
                    </div>
                    <div class="form-group">
                        <label for="">NAMA WILAYAH</label>
                        <input type="text" readonly autocomplete="off" id="site_name2" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">STATUS</label>
                        <input type="text" readonly autocomplete="off" id="status2" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">KETERANGAN</label>
                        <textarea readonly class="form-control" id="others2"></textarea>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- edit data wilayah -->



<script>
    $(document).ready(function() {
        // Untuk sunting modal data edit zona
        $("#edit-data").on("show.bs.modal", function(event) {
            var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
            var modal = $(this);
            // Isi nilai pada field
            modal.find("#id_comp").attr("value", div.data("id"));
            modal.find("#site_name2").attr("value", div.data("site_name"));
            modal.find("#site_name3").attr("value", div.data("site_name"));
            modal.find("#site_no2").attr("value", div.data("site_no"));
            modal.find("#comp").attr("value", div.data("comp_name"));
            if (div.data("status") == 1) {
                modal.find("#status2").attr("value", "ACTIVE");
            } else {
                modal.find("#status2").attr("value", "INACTIVE");
            }
            document.getElementById("others2").value = div.data("ket");
        });
    });
</script>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Kategori Objek</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Kategori_Object') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Kategori_Object') ?>">Kategori Objek</a></li>
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
                        <h3 class="card-title">Data Kategori Objek</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <a href="<?= base_url('Admin/Mst_Kategori_Object/form_add') ?>" class="btn btn-sm btn-primary">
                            <i class="fa fa-plus"></i> Tambah Kategori Objek
                        </a>
                        <form method="post" action="<?= base_url('Admin/Mst_Kategori_Object/multipleDelete') ?>">
                            <div class="row justify-content-end">
                                <button onclick="return confirm('Yakin Hapus Data ?')" id="btn_delete_all" style="display:none ;" class="btn btn-danger btn-sm mb-2 mr-2"> <i class="fas fa-trash"></i> HAPUS DATA TERPILIH</button>
                            </div>
                            <table id="example" class="table-sm mt-1 table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px;">
                                            <input id="check-all" type="checkbox">
                                        </th>
                                        <th style="width: 50px;">NO</th>
                                        <th>NAMA KATEGORI</th>
                                        <th>STATUS</th>
                                        <th>OPSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($kategori_obj->result() as $zn) : ?>
                                        <tr>
                                            <td><input id="check-item" class="check-item" type="checkbox" name="id_kategori[]" value="<?= $zn->kategori_id ?>"> </td>
                                            <td><?= $no++ ?></td>
                                            <td><?= $zn->kategori_name ?></td>
                                            <td><?= $zn->status == 1 ? 'ACTIVE' : 'INACTIVE'  ?></td>
                                            <td>

                                                <a href="<?= base_url('Admin/Mst_Kategori_Object/hapus/' . $zn->kategori_id) ?>" onclick="return confirm('Yakin Hapus ?')" class='text-danger ' title="hapus data"><i class="fa fa-trash"></i></a>


                                                <a href='' data-toggle="modal" data-target="#edit-data" class=" ml-2 text-primary" data-backdrop="static" data-keyboard="false" data-id="<?= $zn->kategori_id ?>" data-status="<?= $zn->status ?>" data-ket="<?= $zn->others ?>" data-category_name="<?= $zn->kategori_name ?>"><i class="fa fa-eye"></i></a>


                                                <a href="<?= base_url('Admin/Mst_Kategori_Object/edit?kategori_id=' . $zn->kategori_id) ?>" class=' ml-2 text-success' title="edit data"><i class="fa fa-edit"></i></a>
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
</section>

<!-- tambah kategori  object -->

<!-- tambah data kategori object -->


<!-- modal edit data kategori object -->
<div class="modal fade" id="edit-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>NAMA KATEGORI</label>
                    <input type="text" readonly class="form-control" id="kategori_name">
                </div>
                <div class="form-group">
                    <label>STATUS</label>
                    <input type="text" readonly class="form-control" id="status">
                </div>
                <div class="form-group">
                    <label>KETERANGAN</label>
                    <textarea readonly class="form-control" id="others"></textarea>
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
    $(function() {
        $("#edit-data").on("show.bs.modal", function(event) {
            var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
            var modal = $(this);
            // Isi nilai pada field
            modal.find("#id").attr("value", div.data("id"));
            modal.find("#kategori_name").attr("value", div.data("category_name"));
            modal.find("#others").attr("value", div.data("ket"));
            if (div.data("status") == 1) {
                modal.find("#status").attr("value", "ACTIVE");
            } else {
                modal.find("#status").attr("value", "INACTIVE");
            }
            document.getElementById('others').value = div.data('ket')
        });
    })

    $(".check-item").click(function() {
        var panjang = $('[name="id_kategori[]"]:checked').length;
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
            var panjang = $('[name="id_kategori[]"]:checked').length;
        } else {
            $(".check-item").prop("checked", false);
            document.getElementById('btn_delete_all').style.display = "none";
        }
    })
</script>
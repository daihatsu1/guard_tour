<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Plant</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Plant') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Plant') ?>">Plant</a></li>
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
                        <h3 class="card-title">Data Plant</h3>

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
                        <!-- <a href="<?= base_url('Mst_Plant/form_add') ?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>
                            Tambah Plant</a> -->
                        <table id="example" class="table-sm mt-1 table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>COMPANY</th>
                                    <th>WILAYAH</th>
                                    <th>KODE PLANT</th>
                                    <th>NAMA PLANT</th>
                                    <th>STATUS</th>
                                    <th>OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($plant->result() as $zn) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $zn->comp_name ?></td>
                                        <td><?= $zn->site_name ?></td>
                                        <td><?= $zn->kode_plant ?></td>
                                        <td><?= $zn->plant_name ?></td>
                                        <td><?= $zn->status == 1 ? 'ACTIVE' : 'INACTIVE' ?></td>
                                        <td>
                                            <!-- <a href="<?= base_url('Mst_Plant/hapus/' . $zn->id) ?>" onclick="return confirm('Yakin Hapus ?')" class='text-danger' title="hapus data"><i class="fa fa-trash"></i></a> -->


                                            <a href='' data-toggle="modal" data-target="#edit-data" class="text-primary" title="lihat data" data-backdrop="static" data-keyboard="false" data-id="<?= $zn->id ?>" data-plant_name="<?= $zn->plant_name ?>" data-site_no="<?= $zn->admisecsgp_mstsite_id ?>" data-status="<?= $zn->status ?>" data-ket="<?= $zn->others ?>" data-comp_name="<?= $zn->comp_name ?>" data-site_name="<?= $zn->site_name ?>" data-plantkode="<?= $zn->kode_plant ?>"><i class="fa fa-eye"></i></a>

                                            <!-- <a href="<?= base_url('Mst_Plant/edit?plant_id=' . $zn->id) ?>" class='text-success' title="edit data"><i class="fa fa-edit"></i></a> -->
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

<!-- tambah data plant -->

<!-- tambah data plant -->


<!-- modal edit data plant -->
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

                    <label for="">COMPANY</label>
                    <input type="text" readonly autocomplete="off" id="comp_" class="form-control">

                    <label for="">WILAYAH</label>
                    <input type="text" readonly autocomplete="off" id="wil_" class="form-control">

                    <label for="">NAMA PLANT</label>
                    <input type="text" readonly autocomplete="off" id="plant_name2" class="form-control">
                    <label for="">KODE PLANT</label>
                    <input type="text" readonly autocomplete="off" id="kodeplant" class="form-control">

                    <label for="">STATUS</label>
                    <input type="text" readonly autocomplete="off" id="status2" class="form-control">

                    <label for="">KETERANGAN</label>
                    <textarea name="others2" readonly class="form-control" id="others2"></textarea>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- edit data plant -->



<script>
    function cek() {
        if (document.getElementById("comp_id").value == "") {
            alert("pilih company");
            $("#site_no").focus();
            return false
        } else if (document.getElementById("site_id").value == "") {
            alert("nama site harus di isi");
            $("#site_id").focus();
            return false
        } else if (document.getElementById("plant_name").value == "") {
            alert("nama plant harus di isi");
            $("#plant_name").focus();
            return false
        }
        return;
    }


    $(document).ready(function() {
        // Untuk sunting modal data edit zona
        $("#edit-data").on("show.bs.modal", function(event) {
            var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
            var modal = $(this);
            // Isi nilai pada field
            modal.find("#plant_name2").attr("value", div.data("plant_name"));
            modal.find("#comp_").attr("value", div.data("comp_name"));
            modal.find("#wil_").attr("value", div.data("site_name"));
            modal.find("#kodeplant").attr("value", div.data("plantkode"));
            if (div.data("status") == 1) {
                modal.find("#status2").attr("value", "ACTIVE");
            } else {
                modal.find("#status2").attr("value", "INACTIVE");
            }

            document.getElementById("others2").value = div.data("ket")
        });


        //input data wilayah berdasarkan
        $('select[name=comp_id').on('change', function() {

            var id = $("select[name=comp_id] option:selected").val();
            if (id == null || id == "") {
                document.getElementById('list_wilayah').innerHTML = "";
            } else {
                $.ajax({
                    url: "<?= base_url('Mst_Plant/showWilayah') ?>",
                    method: "POST",
                    processData: false,
                    contentType: false,
                    data: "id=" + id,
                    success: function(e) {
                        document.getElementById('list_wilayah').innerHTML = e;
                    }
                })
            }
        });

    });
</script>
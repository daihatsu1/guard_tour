<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Company</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Event_Detail') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Event_Detail') ?>">Event Detail</a></li>
                    <li class="breadcrumb-item"><a href="">Tambah Event Details</a></li>
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
                <?php if ($this->session->flashdata("info")) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('info') ?>
                        <?php $this->session->unset_userdata('info') ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Data</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button> -->
                        </div>
                    </div>
                    <form onsubmit="return cek()" action="<?= base_url('Admin/Mst_Event_Detail/input') ?>" method="post" id="inputEvent">

                        <div class="card-body">
                            <div class="form-group">
                                <label for="">PLANT</label>
                                <select class="form-control" name="plant_id" id="plant_id">
                                    <option selected value="">Pilih Plant</option>
                                    <?php foreach ($plant->result() as $plt) : ?>
                                        <option value="<?= $plt->id ?>"><?= $plt->plant_name ?></option>
                                    <?php endforeach ?>
                                </select>
                                <span id="info_zona" style="display: none;" class="text-danger font-italic small">load data zona . . .</span>
                            </div>

                            <div class="form-group ">
                                <label for="">ZONA</label>
                                <select class="form-control" name="zone_id" id="zone_id">
                                    <option selected value="">Pilih Zona</option>
                                </select>
                                <span id="info_check" style="display: none;" class="text-danger font-italic small">load data checkpoint . . .</span>
                            </div>

                            <div class="form-group ">
                                <label for="">CHECKPOINT</label>
                                <select class="form-control" name="check_id" id="check_id">
                                    <option selected value="">Pilih Checkpoint</option>
                                </select>
                                <span id="info_objek" style="display: none;" class="text-danger font-italic small">load data objek. . .</span>
                            </div>

                            <div class="form-group ">
                                <label for="">OBJEK</label>
                                <select class="form-control" name="objek_id" id="objek_id">
                                    <option selected value="">Pilih Objek</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>EVENT</label>
                                <select name="event_id[]" id="event_id" class="select2 form-control" multiple="multiple" data-placeholder="Pilih Event" style="width: 100%;">
                                    <?php foreach ($event->result() as $ev) : ?>
                                        <option value="<?= $ev->id ?>"><?= $ev->event_name ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="">STATUS</label>
                                <select name="status" class="form-control">
                                    <option value="1">ACTIVE</option>
                                    <option value="0">INACTIVE</option>
                                </select>
                            </div>

                            <a href="<?= base_url('Admin/Mst_Event_Detail') ?>" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
                        </div>
                        <!-- /.card-body -->
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>
<script>
    function cek() {
        if (document.getElementById("plant_id").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'pilih plant',
                icon: 'error',
            }).then((result) => {
                // $("#site_name").focus();
            })
            return false
        } else if (document.getElementById("zone_id").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'pilih zona',
                icon: 'error',
            }).then((result) => {})
            return false
        } else if (document.getElementById("check_id").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'pilih checkpoint',
                icon: 'error',
            }).then((result) => {
                // $("#site_name").focus();
            })
            return false
        } else if (document.getElementById("objek_id").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'pilih objek',
                icon: 'error',
            }).then((result) => {
                // $("#site_name").focus();
            })
            return false
        } else if (document.getElementById("event_name").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'event harus di isi',
                icon: 'error',
            }).then((result) => {
                // $("#site_name").focus();
            })
            return false
        }
        return;
    }



    $("select[name=plant_id").on('change', function() {
        var id = $("select[name=plant_id] option:selected").val();
        if (id == "" || id == null) {
            // alert("data kosong")
        } else {
            $.ajax({
                url: "<?= base_url('Admin/Mst_objek/show_zona') ?>",
                method: "POST",
                data: "plant_id=" + id,
                beforeSend: function() {
                    document.getElementById('info_zona').style.display = "block"
                },
                complete: function() {
                    document.getElementById('info_zona').style.display = "none"

                },
                success: function(e) {
                    var select1 = $('#zone_id');
                    if (e == 'tidak ada zona') {
                        alert(e);
                    } else {
                        // console.log(e);
                        select1.empty();
                        var added2 = document.createElement('option');
                        added2.value = "";
                        added2.innerHTML = "Pilih Zona";
                        select1.append(added2);
                        var result = JSON.parse(e);
                        for (var i = 0; i < result.length; i++) {
                            var added = document.createElement('option');
                            added.value = result[i].id;
                            added.innerHTML = result[i].zone_name;
                            select1.append(added);
                        }
                    }
                }
            })

        }
    });

    //load daftar  checkpoint zona id 
    $("select[name=zone_id").on('change', function() {
        var id = $("select[name=zone_id] option:selected").val();
        $.ajax({
            url: "<?= base_url('Admin/Mst_Event_Detail/show_checkpoint') ?>",
            method: "POST",
            data: "zone_id=" + id,
            type: 'json',
            cache: false,
            beforeSend: function() {
                document.getElementById('info_check').style.display = "block"
            },
            complete: function() {
                document.getElementById('info_check').style.display = "none"

            },
            success: function(e) {
                var select1 = $('#check_id');
                if (e == 'tidak ada checkpoint di zona ini') {
                    alert(e);
                } else {
                    var data = JSON.parse(e);
                    // console.log(data);
                    const data_check = data;
                    //tambahkan check objek
                    select1.empty();
                    var added2 = document.createElement('option');
                    added2.value = "";
                    added2.innerHTML = "Pilih Checkpoint";
                    select1.append(added2);
                    for (var i = 0; i < data_check.length; i++) {
                        var added = document.createElement('option');
                        added.value = data_check[i].id;
                        added.innerHTML = data_check[i].check_name;
                        select1.append(added);
                    }
                }
            }
        })
    });

    //load daftar  objek dari checkpoint
    $("select[name=check_id").on('change', function() {
        var id = $("select[name=check_id] option:selected").val();
        $.ajax({
            url: "<?= base_url('Admin/Mst_Event_Detail/show_objek') ?>",
            method: "POST",
            data: "check_id=" + id,
            type: 'json',
            cache: false,
            beforeSend: function() {
                document.getElementById('info_objek').style.display = "block"
            },
            complete: function() {
                document.getElementById('info_objek').style.display = "none"

            },
            success: function(e) {
                var select1 = $('#objek_id');
                if (e == 'tidak ada objek di objek ini') {
                    alert(e);
                } else {
                    var data = JSON.parse(e);
                    // console.log(data);
                    const data_objek = data;
                    //tambahkan objek objek
                    select1.empty();
                    var added2 = document.createElement('option');
                    added2.value = "";
                    added2.innerHTML = "Pilih Objek";
                    select1.append(added2);
                    for (var i = 0; i < data_objek.length; i++) {
                        var added = document.createElement('option');
                        added.value = data_objek[i].id;
                        added.innerHTML = data_objek[i].nama_objek;
                        select1.append(added);
                    }
                }
            }
        })
    });
</script>
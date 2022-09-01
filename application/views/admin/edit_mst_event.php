<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Master Company</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Event') ?>">Master</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Mst_Event') ?>">Event</a></li>
                    <li class="breadcrumb-item"><a href="">Edit Event</a></li>
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
                        <h3 class="card-title">Edit Data</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button> -->
                        </div>
                    </div>
                    <form onsubmit="return cek()" action="<?= base_url('Admin/Mst_Event/update') ?>" method="post">

                        <div class="card-body">

                            <div class="form-group mt-2 ">
                                <label for="">KATEGORI OBJEK</label>
                                <select class="form-control" name="kategori_id" id="kategori_id">
                                    <option selected value="<?= $data->kategori_id ?>"><?= $data->kategori_name ?></option>
                                    <option value="">Pilih Kategori Objek</option>
                                    <?php foreach ($kategori_objek->result() as $ktr) : ?>
                                        <option value="<?= $ktr->kategori_id ?>"><?= $ktr->kategori_name ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">NAMA EVENT</label>
                                <input type="hidden" name="id" value="<?= $data->event_id ?>">
                                <input type="text" name="event_name" value="<?= $data->event_name ?>" autocomplete="off" id="event_name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">STATUS</label>
                                <select name="status" class="form-control" id="">
                                    <?php if ($data->status == 1) { ?>
                                        <option selected value="<?= $data->status ?>">ACTIVE</option>
                                        <option value="0">INACTIVE</option>
                                    <?php } else if ($data->status == 0) { ?>
                                        <option value="<?= $data->status ?>">INACTIVE</option>
                                        <option value="1">ACTIVE</option>
                                    <?php } ?>
                                </select>
                            </div>


                            <a href="<?= base_url('Admin/Mst_Event') ?>" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
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
        } else if (document.getElementById("kategori_id").value == "") {
            Swal.fire({
                title: 'Perhatian!',
                text: 'pilih kategori objek',
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

    //load daftar kategori zona id 
    $("select[name=zone_id").on('change', function() {
        var id = $("select[name=zone_id] option:selected").val();
        $.ajax({
            url: "<?= base_url('Admin/Mst_event/show_kategori') ?>",
            method: "POST",
            data: "zone_id=" + id,
            type: 'json',
            cache: false,
            beforeSend: function() {
                document.getElementById('info_kategori').style.display = "block"
            },
            complete: function() {
                document.getElementById('info_kategori').style.display = "none"

            },
            success: function(e) {
                var select1 = $('#kategori_id');
                if (e == 'tidak ada kategori objek di zona ini') {
                    alert(e);
                } else {
                    var data = JSON.parse(e);
                    console.log(data);
                    const data_kategori = data;
                    //tambahkan kategori objek
                    select1.empty();
                    var added2 = document.createElement('option');
                    added2.value = "";
                    added2.innerHTML = "Pilih Kategori Objek";
                    select1.append(added2);
                    for (var i = 0; i < data_kategori.length; i++) {
                        var added = document.createElement('option');
                        added.value = data_kategori[i].id;
                        added.innerHTML = data_kategori[i].kategori_name;
                        select1.append(added);
                    }
                }
            }
        })
    });
</script>
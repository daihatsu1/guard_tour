<form id="submitData" method="post">
    <input type="hidden" name="id_update" value="<?= $id ?>" id="id_update">
    <input type="hidden" name="kolom_tanggal_update" value="<?= $kolom_tanggal_produksi ?>" id="kolom_tanggal_update">
    <input type="hidden" name="kolom_status_zona" value="<?= $kolom_status_zona ?>" id="kolom_status_zona">
    <label for="">TANGGAL PRODUKSI</label>
    <input type="text" class="form-control" value="<?= $tanggal_produksi ?>" name="tanggal_produksi" id="tanggal_produksi" disabled>
    <label for="">SHIFT</label>
    <select class="form-control" name="shift_produksi" id="shift_produksi">
        <?php foreach ($data_shift->result() as $sh)
            if ($sh->id == $shift_id) { ?>
            <option selected value="<?= $shift_id ?>"><?= $sh->nama_shift ?></option>
        <?php   } else { ?>
            <option value="<?= $sh->id ?>"><?= $sh->nama_shift ?></option>
        <?php  }
        ?>
    </select>

    <label for="">ZONA</label>
    <select class="form-control" name="zona_produksi" id="zona_produksi">
        <?php foreach ($data_zona->result() as $zn)
            if ($zn->id == $zone_id) { ?>
            <option selected value="<?= $zone_id ?>"><?= $zn->zone_name ?></option>
        <?php   } else { ?>
            <option value="<?= $zn->id ?>"><?= $zn->zone_name ?></option>
        <?php  }
        ?>
    </select>

    <label for="">STATUS PRODUKSI</label>
    <select class="form-control" name="status_produksi" id="status_produksi">
        <?php foreach ($data_produksi->result() as $prd)
            if ($prd->id == $produksi_id) { ?>
            <option selected value="<?= $prd->id ?>"><?= $prd->name ?></option>
        <?php   } else { ?>
            <option value="<?= $prd->id ?>"><?= $prd->name ?></option>
        <?php  }
        ?>
    </select>

    <label for="">STATUS ZONA</label>
    <select class="form-control" name="status_zona" id="status_zona">
        <?php if ($status_zona == 'ACTIVE') { ?>
            <option selected value="1"><?= $status_zona ?></option>
            <option value="0">INACTIVE</option>
        <?php } else if ($status_zona == 'INACTIVE') { ?>
            <option selected value="0"><?= $status_zona  ?></option>
            <option value="1">ACTIVE</option>
        <?php } ?>
    </select>

    <div class="alert alert-danger" id="inf" style="display: none ;">
        <p class="small font-italic">harap tunggu sedang memperbarui data</p>
    </div>

    </div>
    <div class="modal-footer">
        <button class="btn btn-primary btn-sm">Simpan Perubahan</button>
        <button type="button" id="submit" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
    </div>
</form>

<script>
    $("#submitData").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= base_url('Mst_Jadwal_Produksi/update_jadwal_produksi') ?>",
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function() {
                document.getElementById("inf").style.display = "block";
            },
            complete: function() {
                document.getElementById("inf").style.display = "none";
            },
            success: function(e) {
                if (e == 1) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'jadwal dirubah',
                        icon: 'success',
                    }).then((result) => {
                        location.reload();
                    })
                } else {
                    Swal.fire({
                        title: 'Error !',
                        text: e,
                        icon: 'error',
                    }).then((result) => {})
                }
            }
        })
    })
</script>
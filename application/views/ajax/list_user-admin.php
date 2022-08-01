<form id="submitData" action="#" method="post">

    <input type="hidden" value="<?= $kolom_update ?>" name="kolom_update" id="kolom_update">
    <input type="hidden" value="<?= $id ?>" name="id_update" id="id_update">
    <div class="form-group">
        <label>TANGGAL PATROLI</label>
        <input type="text" readonly class="form-control" value="<?= $tanggal_patroli ?>" id="tanggal_jaga" name="tanggal_patroli">
    </div>

    <div class="form-group">
        <label>PETUGAS</label>
        <select class="form-control" name="id_user" id="id_user">
            <?php foreach ($data_petugas->result() as $sh) :
                if ($sh->id == $id_user) { ?>
                    <option selected value="<?= $sh->id ?>"><?= $sh->npk . '-' . $sh->name  ?></option>
                <?php } else { ?>
                    <option value="<?= $sh->id ?>"><?= $sh->npk . '-' . $sh->name  ?></option>
                <?php } ?>
            <?php endforeach ?>
        </select>
    </div>

    <div class="form-group">
        <label>SHIFT</label>
        <select class="form-control" name="shift" id="shift">
            <?php foreach ($data_shift->result() as $sh) :
                if ($sh->nama_shift == $shift) { ?>
                    <option selected><?= $sh->nama_shift ?></option>
                <?php } else { ?>
                    <option><?= $sh->nama_shift ?></option>
                <?php } ?>
            <?php endforeach ?>
        </select>
    </div>

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
    $(function() {
        $("#submitData").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('Admin/Mst_Jadwal/update_petugas_patroli') ?>",
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
                    // alert(e);
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
                            text: 'Gagal melakukan perubahan jadwal ',
                            icon: 'error',
                        }).then((result) => {})
                    }
                }
            })
        })
    })
</script>
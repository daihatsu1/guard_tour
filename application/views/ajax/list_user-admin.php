<form id="submitData" action="#" method="post">
    <input type="hidden" name="plant_id" value="<?= $plant_id ?>">
    <input type="hidden" name="user_npk" value="<?= $npk ?>">
    <div class="form-group">
        <label>TANGGAL PATROLI</label>
        <input type="text" readonly class="form-control" value="<?= $tanggal_patroli ?>" id="tanggal_jaga" name="tanggal_patroli">
    </div>

    <div class="form-group">
        <label>PETUGAS</label>
        <input type="text" class="form-control" readonly value="<?= $nama ?>">
    </div>

    <div class="form-group">
        <label>SHIFT</label>
        <select class="form-control" name="shift_id" id="shift">
            <?php foreach ($data_shift->result() as $sh) :
                if ($sh->nama_shift == $shift) { ?>
                    <option value="<?= $sh->shift_id ?>" selected><?= $sh->nama_shift ?></option>
                <?php } else { ?>
                    <option value="<?= $sh->shift_id ?>"><?= $sh->nama_shift ?></option>
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
                url: "<?= base_url('Admin/Mst_Jadwal_Patroli/update_petugas_patroli') ?>",
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
                            text: 'Gagal melakukan perubahan jadwal ',
                            icon: 'error',
                        }).then((result) => {})
                    }
                }
            })
        })
    })
</script>
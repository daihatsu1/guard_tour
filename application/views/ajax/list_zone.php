<div class="form-group">
    <label for="">ZONA</label>
    <select class="form-control" name="zone_id" id="zone_id">
        <option value="">Pilih Zona</option>
        <?php foreach ($zona->result() as $zn) : ?>
            <option value="<?= $zn->zone_id ?>"><?= $zn->zone_name ?></option>
        <?php endforeach ?>
    </select>
</div>
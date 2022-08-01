<div class="form-group">
    <label for="">CHECKPOINT</label>
    <select class="form-control" name="check_id" id="check_id">
        <option value="">Pilih Checkpoint</option>
        <?php foreach ($data->result() as $zn) : ?>
            <option value="<?= $zn->id ?>"><?= $zn->check_name ?></option>
        <?php endforeach ?>
    </select>
</div>
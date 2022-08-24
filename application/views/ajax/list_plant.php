<div class="form-group">
    <label for="">PLANT</label>
    <select class="form-control" name="plant_id" id="plant_id">
        <option value="">Pilih Plant</option>
        <?php foreach ($plant->result() as $plt) : ?>
            <option value="<?= $plt->plant_id ?>"><?= $plt->plant_name ?></option>
        <?php endforeach ?>
    </select>
</div>
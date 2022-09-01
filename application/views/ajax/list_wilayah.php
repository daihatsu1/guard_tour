<div class="form-group">
    <label for="">Wilayah</label>
    <select class="form-control" name="site_id" id="site_id">
        <option value="">Pilih Wilayah</option>
        <?php foreach ($wilayah->result() as $site) : ?>
            <option value="<?= $site->site_id ?>"><?= $site->site_name ?></option>
        <?php endforeach ?>
    </select>
</div>
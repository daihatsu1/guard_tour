 <div class="form-group">
 <select class="form-control" name="check_no" id="check_no">
     <?php foreach ($data->result() as $data) : ?>
        <option value="<?= $data->check_no ?>" ><?= $data->check_name ?></option>
     <?php endforeach ?>
 </select>
</div>
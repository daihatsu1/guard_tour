 <label>Pilih Zona</label>
 <select class="form-control" name="zone_no" id="zone_no">
     <option value="">Pilih Zona</option>
     <?php foreach ($data->result() as $data) : ?>
         <option value="<?= $data->zone_no ?>"><?= $data->zone_name ?></option>
     <?php endforeach ?>
 </select>
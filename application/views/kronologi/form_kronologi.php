<input type="hidden" name="pmi_news" value="<?= $idPmiNews?>">
<input type="hidden" name="last_status" value="<?= $last_status?>">
<input type="hidden" name="loc" value="<?= $my_province?>">    
<div class="form-group">
    <label for="exampleInputEmail1">Status</label>
    <select name="status" id="status" class="form-control" onchange="app.newReadStatus('fly')">
    <option value="">pilih</option>
    <?foreach($next as $n){?>
        <option value="<?= $n?>"><?= $allS[$n]?></option>
    <?}?>
    </select>
</div>
<div class="form-group hide" id="div-transit">
<label for="exampleInputEmail1">Tujuan Berikutnya</label>
<select name="transit" id="transit" class="form-control">
    <option v-for="(item, index) of province_available" :value="index">{{item}}</option>
    </select>
</div>
<hr id="line-tujuan"/>
<div class="form-group">
    <label for="exampleInputEmail1">Deskripsi</label>
    <textarea name="desc" class="form-control" ></textarea>
</div>
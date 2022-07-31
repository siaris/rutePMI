<div class="content-wrapper">
<section class="content-header"><div class="row">
    <h1><small><?= 'mesin ini di '.$all[$l]?></small></h1>
    </div>
    <div class="row">
        <form action="" method="post">
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Set Lokasi Mesin</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Lokasi</label>
                  <select name="loc" class="form-control" >
                    <?foreach($all as $k=>$v){?>
                        <option value="<?= $k?>"><?= $v?></option>
                    <?}?>
                  </select>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.box -->

          

        </div>

        </form>
    </div>
</section>
</div>
<div class="" id = "app">
<? include 'head_kronologi.php'?>
<section class="content-header">
    <div class="row">
        <form action="<?= BASEURL?>/kronologi/set_status/" method="post" enctype="multipart/form-data" accept-charset="utf-8">
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Set Status</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
              <? include 'form_kronologi.php'?>
                <input type="hidden" name="platform" value="mobile">
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button id="submit" type="submit" class="btn btn-primary">Submit</button>
              </div>
            
          </div>
          <!-- /.box -->

          

        </div>

        </form>
    </div>
</section>
</div>
<? include 'kronologi_form_js.php';?>
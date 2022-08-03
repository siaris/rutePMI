<div class="" id = "app">
<section class="content-header">
<h1><small>Staff <?= $allP[$my_province]?> melayani PMI:</small></h1>
<h1><small>{{pmi}}</small></h1>
</section>
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
            <form role="form">
              <div class="box-body">
              <input type="hidden" name="platform" value="">
              <input type="hidden" name="pmi_news" value="<?= $idPmiNews?>">
              <input type="hidden" name="last_status" value="<?= $last_status?>">
              <input type="hidden" name="loc" value="<?= $my_province?>">    
                <div class="form-group">
                  <label for="exampleInputEmail1">Status</label>
                  <select name="status" class="form-control" >
                    <?foreach($next as $n){?>
                        <option value="<?= $n?>"><?= $allS[$n]?></option>
                    <?}?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Deskripsi</label>
                  <textarea name="desc" class="form-control" ></textarea>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Berkas</label>
                  <input type="file" name="berkas">
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
<script src="https://unpkg.com/vue@2.3.2/dist/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.0.0-alpha.1/axios.min.js" integrity="sha512-xIPqqrfvUAc/Cspuj7Bq0UtHNo/5qkdyngx6Vwt+tmbvTLDszzXM0G6c91LXmGrRx8KEPulT+AfOOez+TeVylg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
const app = new Vue({
	el:'#app',
    data() {
			return {
				pmi:'<?= $idPmiNews?>'
			}
		},
    mounted: function(){
		this.fetchData()	
	},
    methods:{
        fetchData(){

        }
    }
})
</script>
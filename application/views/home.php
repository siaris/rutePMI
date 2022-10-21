<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dc/3.0.12/dc.min.css" integrity="sha512-uHCMYHmu81oruDl1bOy5twa5LKyoU2WkCx5F+nHueev7RPOlwBHFSj92QIqisAwTMMvpirUVp1ziM7W8nxUOJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<section class="content" id="app">
<div class="row">
   
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="form-group">
                    <label for="">FILTER</label>
                    <select v-model="filter" class="form-control">
                        <option value=""></option>
                        <? foreach($dd as $k=>$v){
                            echo '<option value="'.$k.'">'.$v.'</option>';
                        }?>
                    </select>
                </div>
                <div class="form-group">
                    <div class="col-sm-1"><button @click.prevent="getDataReport()" class="btn btn-primary" id="do-load">Load Data</button></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{totalReady}}</h3>
                <p>LABOR READY</p>
            </div>
            <div class="icon">
                <i class="fa fa-user-o"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{totalOnGoing}}</h3>
                <p>LABOR ONGOING</p>
            </div>
            <div class="icon">
                <i class="fa fa-user-o"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-grey">
            <div class="inner">
                <h3>{{totalFinished}}</h3>
                <p>LABOR COMPLETED</p>
            </div>
            <div class="icon">
                <i class="fa fa-user-o"></i>
            </div>
        </div>
    </div>

</div>
</section>
<script src="https://unpkg.com/vue@2.3.2/dist/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.0.0-alpha.1/axios.min.js" integrity="sha512-xIPqqrfvUAc/Cspuj7Bq0UtHNo/5qkdyngx6Vwt+tmbvTLDszzXM0G6c91LXmGrRx8KEPulT+AfOOez+TeVylg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.7.0/d3.min.js" integrity="sha512-L5K9Bf852XyB+wrvRFGwWzfhVI+TZqJlgwzX9yvrfhILuzIZfrcQO4au9D9eVDnkQ6oqYr9v2QwJdFo+eKE50Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crossfilter/1.3.12/crossfilter.min.js" integrity="sha512-nlO6OGj6wb0uu/thpSry7qFal63hfhCLExpWxYomYB3tBznqWmKggsDHNHSLjnVaoade9tv/rErN498NSzwBnA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dc/3.0.12/dc.min.js" integrity="sha512-N4kLl4HUjaZ7L4RPG+6+GoqVTVol8tkskOpNOISSJqQjd/uG8j8e/UY3R5CZOnnlM3AXtrhVij8Txnbf4U5HYQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
const app = new Vue({
    el:'#app',
	data() {
        return{
            filter: '',
            result: [],
            totalOnGoing: 0,
            totalReady: 0,
            totalFinished: 0
        }},
    mounted: function(){
		$('#do-load').click()		
	},
    methods: {
        async getDataReport(){
            $('#do-load').addClass('disabled')
            this.totalReady = this.totalFinished = this.totalOnGoing = 0
            let data = new FormData()
            data.append('q', this.filter);
            this.result = await axios.post('<?= BASEURL?>/apis/dashboard/', data, {crossdomain: false})
			.then((resp) => {
				return resp.data
			})
            if(this.result.length > 0) this.processResult()
            $('#do-load').removeClass('disabled')
            return
        },
        processResult(){
            for(o of this.result){
                switch (o.status){
                    case 'P0':
                        this.totalReady += 1; break
                    case 'E':
                        this.totalFinished += 1; break
                    default:
                        this.totalOnGoing += 1; break
                }
            }
            return
        }
    }
})
</script>
<div id="app">
    <span>TOTAL KK : {{totalKK}}</span>
</div>
<script src="https://unpkg.com/vue@2.3.2/dist/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.0.0-alpha.1/axios.min.js" integrity="sha512-xIPqqrfvUAc/Cspuj7Bq0UtHNo/5qkdyngx6Vwt+tmbvTLDszzXM0G6c91LXmGrRx8KEPulT+AfOOez+TeVylg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
const app = new Vue({
    el:'#app',
	data() {
        return{
            totalKK:0
        }},
    mounted: async function(){
        await this.get_totalKK()
    },
    methods:{
        async get_totalKK(){
            await axios.get('<?= BASEURL?>/front/total_kk/',{ crossdomain: false })
            .then((resp) => { app.totalKK = resp.data.r
            })
        }
    }
})
</script>
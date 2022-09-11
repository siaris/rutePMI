<script src="https://unpkg.com/vue@2.3.2/dist/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.0.0-alpha.1/axios.min.js" integrity="sha512-xIPqqrfvUAc/Cspuj7Bq0UtHNo/5qkdyngx6Vwt+tmbvTLDszzXM0G6c91LXmGrRx8KEPulT+AfOOez+TeVylg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
const ALL_PROVINCE =  JSON.parse(`<?= json_encode($allP)?>`)
var app = new Vue({
	el:'#app',
    data() {
			return {
				pmi:'<?= $idPmiNews?>',
                my_province:'<?= $my_province?>',
                province_available: ALL_PROVINCE,
                ket: {},
                news: [],
                no_news: '',
                desc_news:'',
                list_pmi:'',
                status: ''
			}
		},
    mounted: function(){
		this.fetchData()
		this.fetchNews()
        this.readStatus()
	},
    watch: {
        
    },
    computed:{
        
    },
    methods:{
        async fetchData(){
            $('#submit').addClass('disabled')
            this.ket = await axios.get('<?= BASEURL?>/apis/ket_kronologi/'+this.pmi+'/',{ crossdomain: false })
			.then((resp) => {
                return JSON.parse(resp.data[0]['json'])
            })
            let pmi_dest = this.ket.transit[this.ket.transit.length - 1]
            if(pmi_dest != this.my_province){
                let allP = ALL_PROVINCE
                alert('PMI harus diproses oleh staff '+allP[pmi_dest])
                window.location.assign('/news_labor/all_proses/')
            }
            $('#submit').removeClass('disabled')
            return
        },
        async fetchNews(){
            let news = this.pmi.split('.')[0]
            this.news = await axios.get('<?= BASEURL?>/apis/detail_news/'+news+'/',{ crossdomain: false })
			.then((resp) => {
                return resp.data
            })
            this.no_news = this.news[0].judul
            this.desc_news = this.news[0].deskripsi
            this.list_pmi = this.susunPMI()
            return
        },
        susunPMI(){
            // return 'yuhuu'
            let r = []
            this.news.forEach((x, i) => r.push(x.nama))
            return r.join(',')
        },
        readStatus(){
            let act = $('#status').val()
            if(act != 'P'){
                $('#transit').val(this.my_province)
                $('#transit').addClass('hide')
            } else $('#transit').removeClass('hide')
            return
        }
    }
})
</script>
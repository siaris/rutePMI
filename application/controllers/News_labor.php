<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_labor extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->library('template');
	    $this->template->set_template("template_admin_panel");
        // $this->load->model('newslabormodel');
    }
	
	public function index($newsId){
		$this->prep_bootstrap();
        $this->load->model('newsmodel');
        $this->judulBerita = $this->newsmodel->queryOne('id = '.$newsId, 'judul', 'id ASC');

        $this->load->library('grocery_crud/Grocery_CRUD_extended');
        $C = new Grocery_CRUD_extended();
        $C->set_table('news_labor')
        ->unset_delete()
        ->unset_edit()
        ->columns('news_id','labor_id','qr')
        ->set_relation('news_id','news','judul')
        ->set_relation('labor_id','labor','nama')
        ->fields('news_id','labor_id','uuid','json')
        ->callback_column('qr',function($v,$r){
            return '<a href="'.BASEURL.json_decode($r->json,TRUE)['qrcode'].'">lihat qrcode</a> ('.$r->uuid.')';
        })
        ->display_as('news_id','berita kepulangan')
        ->display_as('labor_id','PMI')
        ->field_type('uuid', 'invisible')
        ->field_type('json', 'invisible')
        ->callback_add_field('news_id',function() use ($newsId){
            return '<input type="hidden" name="news_id" value="'.$newsId.'">'.$this->judulBerita;
        })
        ->where('news_id',$newsId)
        ->required_fields('judul','deskripsi')
        ->callback_before_insert(array($this,'collect_insert_data'));
        $D = $C->render('<a href="'.BASEURL.'/news/" ><i class="fa fa-arrow-left"></i></a><h3>Pemulangan PMI Berita : '.$this->judulBerita.'</h3>'); 
        
        $this->template->write_view("content", 'grocery_crud_content',$D);
        $this->template->render();
	}

    public function all_proses(){
        $this->prep_bootstrap();
        $this->load->model('newsmodel');

        $this->load->library('grocery_crud/Grocery_CRUD_extended');
        $C = new Grocery_CRUD_extended();
        $C->set_table('news_labor')
        ->unset_delete()
        ->unset_edit()
        ->unset_add()
        ->unset_read()
        ->columns('news_id','labor_id','qr','status','kronologi_ringkas')
        ->set_relation('news_id','news','judul')
        ->set_relation('labor_id','labor','nama')
        ->callback_column('qr',function($v,$r){
            return '<a class="btn btn-small btn-success" href="'.BASEURL.json_decode($r->json,TRUE)['qrcode'].'">lihat qrcode</a> <a class="btn btn-small btn-success" href="'.BASEURL.'/kronologi/act_pmi/'.$r->uuid.'">proses PMI</a> ('.$r->uuid.')';
        })
        ->callback_column('status',function($v,$r){
            return $this->config->item('statusDesc')[$v];
        })
        ->callback_column('kronologi_ringkas',function($v,$r){
            $this->load->model('Kronologimodel');
            $Rr = $this->Kronologimodel->find_all('uuid like "'.$r->uuid.'.%"','`desc`','id');
            $r = [];
            if(!empty($Rr))
                array_walk($Rr,function($v) use (&$r){
                    $d = json_decode($v['desc'],true);
                    $r[] = $d['rute']['d'].' : '.$this->config->item('statusDesc')[$d['rute']['f']].' ---> '.$this->config->item('statusDesc')[$d['rute']['t']];
                });

            return implode('<br>',$r);
        })
        ->display_as('news_id','berita kepulangan')
        ->display_as('labor_id','PMI')
        ->field_type('uuid', 'invisible')
        ->field_type('json', 'invisible')
        ->where('status <>','E')
        ->required_fields('judul','deskripsi')
        ->callback_before_insert(array($this,'collect_insert_data'));
        $D = $C->render(); 
        
        $this->template->write_view("content", 'grocery_crud_content',$D);
        $this->template->render();
    }
    
    function collect_insert_data($p){
        $this->load->model('labormodel');
        $this->load->library('ciqrcode');
        $nik = $this->labormodel->queryOne('id = '.$p['labor_id'], 'nik', 'id ASC');
        $uuid = $p['news_id'].'.'.$nik;
        $p['uuid'] = $uuid;

        /* BUAT BARCODE */
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = APPPATH.'/assets/'; //string, the default is application/cache/
        $config['errorlog']     = APPPATH.'/assets/'; //string, the default is application/logs/
        $config['imagedir']     = ROOTPATH.'/rute/public/support/img/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        $params['data'] = BASEURL."/kronologi/act_pmi/".$uuid; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = ROOTPATH.'/rute/public/support/img/'.$uuid.'.png';
        $this->ciqrcode->generate($params);
        
        $p['json'] = json_encode(['qrcode'=>'/public/support/img/'.$uuid.'.png']);
        return $p;   
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->library('template');
	    $this->template->set_template("template_admin_panel");
        $this->load->helper('app');
        $this->listNegara = $this->config->item('negara');
        $this->load->model('Newsmodel');
    }
	
	public function index(){
		$this->prep_bootstrap();

        $this->load->library('grocery_crud/Grocery_CRUD_extended');
        $C = new Grocery_CRUD_extended();
        $C->set_table('news')
        ->unset_delete()
        ->unset_read()
        ->columns('judul','deskripsi')
        ->fields('judul','json_v','negara','perwakilan_sumber_referensi','tgl_dokumen','media_berita','pelayanan_kepulangan','deskripsi')
        ->field_type('json_v', 'invisible')
        ->callback_column('judul',function($v,$r){return $v.' &nbsp;&nbsp;&nbsp;<a class="btn btn-small" href="'.BASEURL.'/news_labor/index/'.$r->id.'/">input PMI</a> &nbsp;&nbsp;&nbsp;<a class="btn btn-small" href="'.BASEURL.'/news/detail/'.$r->id.'/">Detail Berita</a>';})
        ->callback_add_field('negara',function($v,$r){
            return gc_val_select('negara','',$this->listNegara);
        })->callback_edit_field('negara',function($v,$r){
            $this->get_j = $this->get_j($r);
            return gc_val_select('negara',$this->get_j['negara'],$this->listNegara);})
        ->callback_edit_field('perwakilan_sumber_referensi',function($v,$r){return gc_val_input('perwakilan_sumber_referensi',$this->get_j['perwakilan_sumber_referensi']);})
        ->callback_edit_field('tgl_dokumen',function($v,$r){return gc_val_input('tgl_dokumen',$this->get_j['tgl_dokumen']);})
        ->callback_edit_field('media_berita',function($v,$r){return gc_val_input('media_berita',$this->get_j['media_berita']);})
        ->callback_edit_field('pelayanan_kepulangan',function($v,$r){return gc_val_input('pelayanan_kepulangan',$this->get_j['pelayanan_kepulangan']);})
        ->display_as('judul','Nomor Berita')    
        ->display_as('deskripsi','Perihal Kepulangan')    
        ->callback_before_insert(array($this,'collect_data'))
        ->callback_before_update(array($this,'collect_data'))
        ->required_fields('judul','deskripsi');
        $D = $C->render(); 
        
        $this->template->write_view("content", 'grocery_crud_content',$D);
        $this->template->render();
	}

    public function detail($id){
        $this->prep_bootstrap();
        $D['news'] = $this->Newsmodel->find('id = '.$id);
        $this->template->write_view("content", 'news/detail',$D);
        $this->template->render();
    }

    function collect_data($p){
        $p['json_v'] = json_encode([
        'negara'=>$p['negara'],
        'perwakilan_sumber_referensi'=>$p['perwakilan_sumber_referensi'],
        'tgl_dokumen'=>$p['tgl_dokumen'],
        'media_berita'=>$p['media_berita'],
        'pelayanan_kepulangan'=>$p['pelayanan_kepulangan']
        ]);
        unset($p['negara']);
        unset($p['perwakilan_sumber_referensi']);
        unset($p['tgl_dokumen']);
        unset($p['media_berita']);
        unset($p['pelayanan_kepulangan']);
        return $p;
    }

    public function get_j($id){
        $j = $this->Newsmodel->queryOne('id = '.$id,'json_v','');
        return !empty($j)?json_decode($j,TRUE):[];
    }
}

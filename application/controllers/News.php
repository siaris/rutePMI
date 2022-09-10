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
        ->columns('judul','deskripsi')
        ->fields('judul','json_v','negara','deskripsi')
        ->field_type('json_v', 'invisible')
        ->callback_column('judul',function($v,$r){return $v.' &nbsp;&nbsp;&nbsp;<a class="btn btn-small" href="'.BASEURL.'/news_labor/index/'.$r->id.'/">input PMI</a>';})
        ->callback_add_field('negara',function($v,$r){
            return gc_val_select('negara','',$this->listNegara);
        })->callback_edit_field('negara',function($v,$r){
            $this->get_j = $this->get_j($r);
            return gc_val_select('negara',$this->get_j['negara'],$this->listNegara);})
        ->callback_before_insert(array($this,'collect_data'))
        ->callback_before_update(array($this,'collect_data'))
        ->required_fields('judul','deskripsi');
        $D = $C->render(); 
        
        $this->template->write_view("content", 'grocery_crud_content',$D);
        $this->template->render();
	}

    function collect_data($p){
        $p['json_v'] = json_encode([
        'negara'=>$p['negara']
        ]);
        unset($p['negara']);
        return $p;
    }

    public function get_j($id){
        $j = $this->Newsmodel->queryOne('id = '.$id,'json_v','');
        return !empty($j)?json_decode($j,TRUE):[];
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Labor extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->library('template');
	    $this->template->set_template("template_admin_panel");
        $this->load->model('Labormodel');
    }
	
	public function index(){
		$this->prep_bootstrap();
        $this->load->library('grocery_crud/Grocery_CRUD_extended');
        $C = new Grocery_CRUD_extended();
        // $this->cmt = $this->_get_cmt();
        $this->get_j = [];
        $C->set_table('labor')
        ->unset_delete()
        ->columns('nik','nama')
        ->fields('nik','nama','json_v','alamat_domisili','kecamatan_tujuan_pemulangan')
        ->unique_fields('nik')
        ->callback_edit_field('alamat_domisili',function($v,$r){
            $this->get_j = $this->get_j($r);
            return isset($this->get_j['alamat_domisili'])?'<textarea name="alamat_domisili">'.$this->get_j['alamat_domisili'].'</textarea>':'<textarea name="alamat_domisili"></textarea>';
        })
        ->callback_add_field('alamat_domisili',function(){
            return '<textarea name="alamat_domisili"></textarea>';
        })
        ->callback_add_field('kecamatan_tujuan_pemulangan',function(){
            $this->load->model('Wilayahmodel');
            $R = $this->Wilayahmodel->find_all_tujuan(array_keys($this->config->item('provinsi')));
            $r = '<select name="tujuan">';
            foreach($R as $v) $r .= '<option value="'.$v['id_wilayah'].'">'.$v['nama_wilayah'].'</option>';
            return $r.'</select>';
        })
        ->callback_before_insert(array($this,'collect_data'))
        ->callback_before_update(array($this,'collect_data'))
        ->field_type('json_v', 'invisible')
        ->required_fields('nik','nama','alamat_domisili');
        $D = $C->render(); 
        
        $this->template->write_view("content", 'grocery_crud_content',$D);
        $this->template->render();
	}

    function collect_data($p){
        $p['json_v'] = json_encode(['alamat_domisili'=>$p['alamat_domisili'],'kecamatan_domisili'=>$p['tujuan']]);
		unset($p['alamat_domisili']);
        unset($p['tujuan']);
        return $p;
    }

    public function get_j($id){
        $j = $this->Labormodel->queryOne('id = '.$id,'json_v','');
        return !empty($j)?json_decode($j,TRUE):[];
    }
}

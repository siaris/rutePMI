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
        ->fields('nik','nama','json_v','alamat_domisili','kecamatan_tujuan_pemulangan','tgl_lahir','tempat_lahir','jenis_kelamin','status_nikah','pendidikan','no_telp')
        ->unique_fields('nik')
        ->callback_edit_field('alamat_domisili',function($v,$r){
            $this->get_j = $this->get_j($r);
            return isset($this->get_j['alamat_domisili'])?'<textarea name="alamat_domisili">'.$this->get_j['alamat_domisili'].'</textarea>':'<textarea name="alamat_domisili"></textarea>';
        })
        ->callback_edit_field('tempat_lahir',function($v,$r){
            return $this->val_input('tempat_lahir',$this->get_j['tempat_lahir']);
        })->callback_edit_field('jenis_kelamin',function($v,$r){
            return $this->val_input('jenis_kelamin',$this->get_j['jenis_kelamin']);
        })->callback_edit_field('status_nikah',function($v,$r){
            return $this->val_input('status_nikah',$this->get_j['status_nikah']);
        })->callback_edit_field('pendidikan',function($v,$r){
            return $this->val_input('pendidikan',$this->get_j['pendidikan']);
        })->callback_edit_field('no_telp',function($v,$r){
            return $this->val_input('no_telp',$this->get_j['no_telp']);
        })
        ->callback_add_field('alamat_domisili',function(){
            return '<textarea name="alamat_domisili"></textarea>';
        })->field_type('tgl_lahir', 'date', 'hehe')
        ->callback_add_field('kecamatan_tujuan_pemulangan',function(){
            $this->load->model('Wilayahmodel');
            $R = $this->Wilayahmodel->find_all_tujuan(array_keys($this->config->item('provinsi')));
            $r = '<select name="tujuan">';
            foreach($R as $v) $r .= '<option value="'.$v['id_wilayah'].'">'.$v['nama_wilayah'].'</option>';
            return $r.'</select>';
        })->callback_edit_field('kecamatan_tujuan_pemulangan',function($V,$r){
            $this->load->model('Wilayahmodel');
            $R = $this->Wilayahmodel->find_all_tujuan(array_keys($this->config->item('provinsi')));
            $r = '<select name="tujuan">';
            
            foreach($R as $v){
                $s = $v == $this->get_j['kecamatan_domisili'] ?'selected':''; 
                $r .= '<option '.$s.' value="'.$v['id_wilayah'].'">'.$v['nama_wilayah'].'</option>';}
            return $r.'</select>';
        })
        ->callback_before_insert(array($this,'collect_data'))
        ->callback_before_update(array($this,'collect_data'))
        ->field_type('json_v', 'invisible')
        ->required_fields('nik','nama','alamat_domisili');
        $D = $C->render(); 
        
        $this->template->write_view("content", 'grocery_crud_content',$D);
        if(isset($this->get_j['tgl_lahir']))
            $this->template->write("js_bottom_scripts", '<script>$(document).ready(function() {$("#field-tgl_lahir").val("'.date('d/m/Y',strtotime($this->get_j['tgl_lahir'])).'");});</script>',NULL,FALSE);
        $this->template->render();
	}

    public function val_input($name,$val='',$otherAttr=''){
        return '<input type="text" name="'.$name.'" '.$otherAttr.' id="field-'.$name.'" value="'.$val.'">';
    }

    function collect_data($p){
        $p['json_v'] = json_encode(['alamat_domisili'=>$p['alamat_domisili'],'kecamatan_domisili'=>$p['tujuan'],
        'tgl_lahir'=>date('Y-m-d',strtotime($p['tgl_lahir'])),
        'tempat_lahir'=>$p['tempat_lahir'],
        'jenis_kelamin'=>$p['jenis_kelamin'],
        'status_nikah'=>$p['status_nikah'],
        'pendidikan'=>$p['pendidikan'],
        'no_telp'=>$p['no_telp']
        ]);
		unset($p['alamat_domisili']);
        unset($p['tujuan']);
        unset($p['tgl_lahir']);
        unset($p['tempat_lahir']);
        unset($p['jenis_kelamin']);
        unset($p['status_nikah']);
        unset($p['pendidikan']);
        unset($p['no_telp']);
        return $p;
    }

    public function get_j($id){
        $j = $this->Labormodel->queryOne('id = '.$id,'json_v','');
        return !empty($j)?json_decode($j,TRUE):[];
    }
}

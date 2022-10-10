<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->library('template');
	    $this->template->set_template("template_admin_panel");
        $this->load->helper('app');
    }
	
	public function modules(){
        $this->prep_bootstrap();

        $this->load->library('grocery_crud/Grocery_CRUD_extended');
        $C = new Grocery_CRUD_extended();
        $C->set_table('module')
        ->unset_delete()
        ->unset_read();
        $D = $C->render(); 
        
        $this->template->write_view("content", 'grocery_crud_content',$D);
        
        $this->template->render();
    }

    public function list_user(){
        $this->prep_bootstrap();
        $this->listProv = $this->config->item('provinsi');
        $this->load->model('Usermodel');

        $this->load->library('grocery_crud/Grocery_CRUD_extended');
        $C = new Grocery_CRUD_extended();
        $C->set_table('user')
        ->columns('username','name','group','status')
        ->fields('username','password','name','group','status','map_user_function','wilayah_operasi')
        ->field_type('password','password')
        ->callback_before_insert(array($this,'insert_collect_data_user'))
        ->callback_before_update(array($this,'update_collect_data_user'))
        ->set_relation('group','group','name')
        ->field_type('status','dropdown',['non active','active'])
        ->field_type('map_user_function','invisible')
        ->callback_add_field('wilayah_operasi',function($v,$r){
            array_unshift($this->listProv,'');
            return $this->val_select('wilayah_operasi','',$this->listProv);})
        ->callback_edit_field('wilayah_operasi',function($v,$r){
            $this->get_j = $this->get_j($r);
            array_unshift($this->listProv,'');
            return $this->val_select('wilayah_operasi',$this->get_j['wilayah_operasi'],$this->listProv);})
        ->callback_edit_field('password',function($v,$r){
            return '<input value="'.$v.'" name="password" type="password" readonly>';})
        ->required_fields('username','password','name','group','status')
        ->unset_delete()
        ->unset_read();
        $D = $C->render(); 
        
        $this->template->write_view("content", 'grocery_crud_content',$D);
        
        $this->template->render();
    }

    function get_j($id){
        $j = $this->Usermodel->queryOne('id = '.$id,'map_user_function','');
        return !empty($j)?json_decode($j,TRUE):[];
    }

    public function val_select($name,$val,$ref){
        return gc_val_select($name,$val,$ref);
    }

    function insert_collect_data_user($p){
        $p['password'] = md5($p['password']); 
        return $this->update_collect_data_user($p);
    }

    function update_collect_data_user($p){
        $p['map_user_function'] = json_encode(['wilayah_operasi'=>$p['wilayah_operasi']]);
        unset($p['wilayah_operasi']);  
        //insert to user group
        return $p;
    }

    public function groups(){
        $this->prep_bootstrap();

        $this->load->library('grocery_crud/Grocery_CRUD_extended');
        $C = new Grocery_CRUD_extended();
        $C->set_table('group')
        ->unset_delete()
        ->unset_read();
        $D = $C->render(); 
        
        $this->template->write_view("content", 'grocery_crud_content',$D);
        
        $this->template->render();
    }
}

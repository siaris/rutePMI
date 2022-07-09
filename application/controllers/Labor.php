<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Labor extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->library('template');
	    $this->template->set_template("template_admin_panel");
        // $this->load->model('labormodel');
    }
	
	public function index(){
		$this->prep_bootstrap();

        $this->load->library('grocery_crud/Grocery_CRUD_extended');
        $C = new Grocery_CRUD_extended();
        $C->set_table('labor')
        ->unset_delete()
        ->columns('nik','nama')
        ->fields('nik','nama')
        ->unique_fields('nik')
        ->required_fields('nik','nama');
        $D = $C->render(); 
        
        $this->template->write_view("content", 'grocery_crud_content',$D);
        $this->template->render();
	}
}

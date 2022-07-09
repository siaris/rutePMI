<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->library('template');
	    $this->template->set_template("template_admin_panel");
        // $this->load->model('newsmodel');
    }
	
	public function index(){
		$this->prep_bootstrap();

        $this->load->library('grocery_crud/Grocery_CRUD_extended');
        $C = new Grocery_CRUD_extended();
        $C->set_table('news')
        ->unset_delete()
        ->columns('judul','deskripsi')
        ->fields('judul','deskripsi')
        ->required_fields('judul','deskripsi');
        $D = $C->render(); 
        
        $this->template->write_view("content", 'grocery_crud_content',$D);
        $this->template->render();
	}
}

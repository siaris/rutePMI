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

        $this->load->library('grocery_crud/Grocery_CRUD_extended');
        $C = new Grocery_CRUD_extended();
        $C->set_table('user')
        ->columns('username','name','group','status')
        ->unset_delete()
        ->unset_read();
        $D = $C->render(); 
        
        $this->template->write_view("content", 'grocery_crud_content',$D);
        
        $this->template->render();
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

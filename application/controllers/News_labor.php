<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_labor extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->library('template');
	    $this->template->set_template("template_admin_panel");
        $this->load->model('newslabormodel');
    }
	
	public function index(){
		
	}
}

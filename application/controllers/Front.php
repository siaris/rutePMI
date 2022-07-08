<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->library('template');
	    $this->template->set_template("template_admin_panel");
        // $this->load->model('mwargamodel');
    }
	
	public function index(){
		redirect(BASEURL.'/front/home/','refresh');
		return;
	}

    public function home(){
        $this->prep_bootstrap();
        $D['message'] = ['Coming Soon'];
        
        $this->template->write_view("content", 'home',$D);
        $this->template->render();
    }
}

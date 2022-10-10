<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->library('template');
    }

    public function logout() {
        $this->auth->logout();
    }

    public function login(){
        $this->template->set_template("template_login");
        if($this->input->post()){
            $this->login_as();
        }
        $this->prep_bootstrap(FALSE);
        $this->template->render();
	}

    public function login_as(){
        if($this->input->post()){
            $u = $this->input->post('username');
			$p = $this->input->post('password');
            $usemd5 = $u == 'adm1'?true:false;
			$this->auth->login($u, $p);
        }
        return;
    }

    public function set_sess_location($id){
        $this->load->library('session');
        $this->session->set_userdata("location", $id);
        exit('set lokasi di '.$id);
    }
}

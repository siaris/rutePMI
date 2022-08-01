<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lokasi extends MY_Controller {
    protected $pmi;
    public function __construct(){
        parent::__construct();
        $this->load->library('template');
	    $this->template->set_template("template_admin_panel");
        $this->load->library('session');
    }

    public function set_my(){
        $this->prep_bootstrap();
        $D['all'] = $this->config->item('provinsi');
        if($this->input->post()){
            $s = $this->input->post();
            $this->session->set_userdata("location", $s['loc']);
            $this->my_province = $s['loc'];
        }
        $D['l'] = $this->my_province;
        $this->template->write_view("content", 'location/set',$D);
        $this->template->render();

    }
}

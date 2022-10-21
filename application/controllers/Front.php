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
        $dd = [];
        foreach($this->config->item('jenis_kelamin') as $k=>$v) $dd['jenis_kelamin:'.$k] = 'jenis kelamin: '.$v;
        foreach($this->config->item('provinsi') as $k=>$v) $dd['UPT:'.$k] = 'UPT: '.$v;
        $this->load->model('Wilayahmodel');
        $R = $this->Wilayahmodel->find_all_tujuan(array_keys($this->config->item('provinsi')));
        foreach($R as $v) $dd['TUJUAN:'.$v['id_wilayah']] = 'TUJUAN: '.$v['nama_wilayah'];

        $D['dd'] = $dd;
        
        $this->template->write_view("content", 'home',$D);
        $this->template->render();
    }
}

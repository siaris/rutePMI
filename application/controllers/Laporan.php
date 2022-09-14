<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller {
    protected $pmi;
    public function __construct(){
        parent::__construct();
        $this->load->library('template');
	    $this->template->set_template("template_admin_panel");
    }

    public function pmi_selesai(){
        $this->prep_bootstrap();
        $this->load->model('NewsLabormodel');
        $D = [];
        // if($this->input->post()){
            $P = $this->input->post();
            $m = $this->NewsLabormodel;
            $m->db->join('labor','labor.id=labor_id','inner');
            $m->db->join('news','news.id=news_id','inner');
            
            $D['R'] = $m->find_all('status = "E"','*,labor.json_v l_json_v');
        // }
        
        $this->template->write_view("content", 'report_pmi_selesai',$D);
        $this->template->render();
    }
}

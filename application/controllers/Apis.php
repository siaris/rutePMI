<?php

require_once APPPATH."/core/REST_Controller.php";

class Apis extends REST_Controller {
    protected $pmi;
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
    }

    public function ket_kronologi_get($idPmiNews){ //exit('hehe');
        
        $this->load->model('NewsLabormodel');
        $this->NewsLabormodel->db->join('kronologi_perjalanan','news_labor.uuid = news_labor_id','left');
        $R = $this->NewsLabormodel->find_all('news_labor.uuid = "'.$idPmiNews.'"','*');

        // $rest = new REST_Controller();
        $this->response($R, REST_Controller::HTTP_OK);
    }
}

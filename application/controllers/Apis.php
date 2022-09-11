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

    public function detail_news_get($id){
        $this->load->model('Newsmodel');
        $m = $this->Newsmodel;
        $m->db->join('news_labor','news_id='.$m->table.'.id','left');
        $m->db->join('labor','labor_id=labor.id','inner');
        $R = $m->find_all($m->table.'.id = '.$id);
        $this->response($R, REST_Controller::HTTP_OK);
    }
}

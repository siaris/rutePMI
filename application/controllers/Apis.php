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

    public function dashboard_post(){
        $this->load->model('NewsLabormodel');
        $q = !empty($this->input->post('q'))?$this->get_q_dashboard($this->input->post('q')):' and true ';
        $R = $this->NewsLabormodel->query('select * from 
        (select labor.json_v,news_labor.status,json,group_concat(kronologi_perjalanan.uuid) kronologi from news_labor
        inner join labor on labor_id = labor.id
        inner join news on news_id = news.id
        left join kronologi_perjalanan on news_labor_id = news_labor.uuid
        where true group by news_labor.uuid)
        x where true '.$q)->result_array();
        $this->response($R, REST_Controller::HTTP_OK); 
    }

    private function get_q_dashboard($v){
        $vQ = explode(':',$v);
        $return = '';
        switch($vQ[0]){
            case 'UPT':
                $return = ' and kronologi like "%.31" ';
                break;
            default:
                $key = $vQ[0] == 'TUJUAN'?'kecamatan_domisili':'jenis_kelamin';
                $return = ' and json_v like \'"'.$key.'":"'.$vQ[1].'"\' ';
                break;
        }
        return $return;
    }
}

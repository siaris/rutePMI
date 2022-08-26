<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kronologi extends MY_Controller {
    protected $pmi;
    public function __construct(){
        parent::__construct();
        $this->load->library('template');
	    $this->template->set_template("template_admin_panel");
        // $this->load->model('mwargamodel');
        $this->isMobile = false;
        $this->load->library('session');
    }

    public function act_pmi($idPmiNews){
        $this->pmi = $idPmiNews;
        $this->_route_page();
    }

    private function _route_page(){
        //pilih kronologis akhir
        $kronologiId = '';
        $mobileText = $this->isMobile?'_mobile':'';
        foreach($this->config->item('pmiKronologi') as $k=>$v){
            if($k == $this->pmi.'.'.$this->my_province) $kronologiId = $k;
        }
        
        if(empty($kronologiId)) redirect(BASEURL.'/kronologi/kronologi_lokasi_baru'.$mobileText.'/'.$this->pmi.'/','refresh');
        redirect(BASEURL.'/kronologi/kronologi_lokasi_baru'.$mobileText.'/'.$kronologiId.'/','refresh');
    }

    private function get_last_status(){
        // foreach($this->config->item('pmiInNews') as $v)
        //     if($v['id'] == $this->pmi) return $v['act'];
        // exit('pmi not found');
        $this->load->model('NewsLabormodel');
        $v = $this->NewsLabormodel->queryOne('uuid = "'.$this->pmi.'" and status <> "E"','status',null);
        if(!empty($v)) return $v;
        exit('pmi not found');
    }

    private function get_next_status(){
        $status_sekarang = $this->get_last_status();
        $this->last_status = $status_sekarang;
        switch($status_sekarang){
            case 'P0':$n = ['D'];
            break;
            case 'D':$n = ['P','S'];
            break;
            case 'P':$n = ['D'];
            break;
            case 'S':$n = ['E'];
            break;
            default:$n = [];
            break;
        }
        return $n;
    }

    public function kronologi_lokasi_baru($idPmiNews){
        $this->prep_bootstrap();
        $this->pmi = $idPmiNews;
        $next = $this->get_next_status();

        //deteksi mobile berlaku disini ketika akan redirect
        $this->load->library('Mobile_Detect');
        $D = new Mobile_Detect();
        $v = 'new';
        if ( $D->isMobile() || $D->isTablet()) {
            $this->isMobile = true;
            $v = 'new_mobile';
        }

        $this->template->write_view("content", 'kronologi/'.$v,['next'=>$next,'idPmiNews'=>$this->pmi,'my_province'=>$this->my_province,'allP'=>$this->config->item('provinsi'),'allS'=>$this->config->item('statusDesc'),'last_status'=>$this->last_status]);
        $this->template->render();
    }

    public function kronologi_lokasi_exist_not($head_kronologi_id){
        $this->prep_bootstrap();
        $e = explode('.',$head_kronologi_id);
        $this->pmi = $e[0].'.'.$e[1];
        $next = $this->get_next_status();

        $this->load->library('Mobile_Detect');
        $D = new Mobile_Detect();
        $v = 'new';
        if ( $D->isMobile() || $D->isTablet()) {
            $this->isMobile = true;
            $v = 'new_mobile';
        }

        $this->template->write_view("content", 'kronologi/'.$v,['next'=>$next,'idPmiNews'=>$this->pmi,'my_province'=>$this->my_province,'allP'=>$this->config->item('provinsi'),'allS'=>$this->config->item('statusDesc'),'last_status'=>$this->last_status]);
        $this->template->render();
    }

    public function set_status(){
        if($this->input->post()){
            $s = $this->input->post();
            $this->load->model(['NewsLabormodel','Kronologimodel']);
            $jsonNewsLabor = $this->NewsLabormodel->queryOne('uuid = "'.$s['pmi_news'].'"','json',null);
            $decodeJNewsLabor = json_decode($jsonNewsLabor,true);
            $decodeJNewsLabor['transit'][] = $s['transit'];
            $this->NewsLabormodel->save($D = ['status' => $s['status'], 'json'=>json_encode($decodeJNewsLabor)], $id = $s['pmi_news']);
            //set status sebelumnya
            $rute = ['f'=>$s['last_status'],'t'=>$s['status'],'d'=>date('Y-m-d H:i')];
            $desc = $s['desc'];
            $loc = $s['loc'];
            $data['desc'] = json_encode(['rute'=>$rute,'ket'=>$desc,'lokasi'=>$loc]);
            $data['status_kronologi'] = $s['status'];
            $data['uuid'] = $s['pmi_news'].".".$s['loc'];
            $data['news_labor_id'] = $s['pmi_news'];

            $this->Kronologimodel->save($data);
            
            redirect(BASEURL.'/news_labor/all_proses/','refresh');
        }
        return;
    }
}

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
        $this->my_province = '31';
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
        redirect(BASEURL.'/kronologi/kronologi_lokasi_exist'.$mobileText.'/'.$kronologiId.'/','refresh');
    }

    private function get_last_status(){
        foreach($this->config->item('pmiInNews') as $v)
            if($v['id'] == $this->pmi) return $v['act'];
        exit('pmi not found');
    }

    private function get_next_status(){
        $status_sekarang = $this->get_last_status();
        switch($status_sekarang){
            case 'D':$n = ['P'];
            break;
            case 'P':$n = ['D','S'];
            break;
            case 'S':$n = ['E'];
            break;
            default:$n = [];
            break;
        }
        return $n;
    }

    public function kronologi_lokasi_baru($idPmiNews){
        $this->pmi = $idPmiNews;
        $next = $this->get_next_status();

        //deteksi mobile berlaku disini ketika akan redirect
        $this->load->library('Mobile_Detect');
        $D = new Mobile_Detect();
        if ( $D->isMobile() || $D->isTablet()) {
            $this->isMobile = true;
        }


        exit('lokasi baru kronologi baru '.($this->isMobile?'mobile':'pc').', status yg bisa dipilih '.(empty($next)?'tidak ada':implode(' dan ',$next)));
    }

    public function kronologi_lokasi_exist($head_kronologi_id){
        $e = explode('.',$head_kronologi_id);
        $this->pmi = $e[0].'.'.$e[1];
        $next = $this->get_next_status();

        $this->load->library('Mobile_Detect');
        $D = new Mobile_Detect();
        if ( $D->isMobile() || $D->isTablet()) {
            $this->isMobile = true;
        }

        exit('lokasi exist kronologi baru '.($this->isMobile?'mobile':'pc').', status yg bisa dipilih '.(empty($next)?'tidak ada':implode(' dan ',$next)));
    }
}

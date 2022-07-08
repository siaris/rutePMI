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
        //deteksi mobile berlaku disini ketika akan redirect
        $this->load->library('Mobile_Detect');
        $D = new Mobile_Detect();
        if ( $D->isMobile() || $D->isTablet()) {
            $this->isMobile = true;
        }
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
        redirect(BASEURL.'/kronologi/modif_kronologi_lokasi'.$mobileText.'/'.$kronologiId.'/','refresh');
    }

    public function kronologi_lokasi_baru_mobile($idPmiNews){
        exit('lokasi baru kronologi baru mobile');
    }

    public function kronologi_lokasi_baru($idPmiNews){
        exit('lokasi baru kronologi baru pc');
    }

    public function modif_kronologi_lokasi_mobile($head_kronologi_id){
        exit('lokasi exist kronologi baru mobile');
    }

    public function modif_kronologi_lokasi($head_kronologi_id){
        exit('lokasi exist kronologi baru pc');
    }
}

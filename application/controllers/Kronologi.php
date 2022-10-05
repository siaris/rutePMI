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
            $j = $this->_collect_for_json($s,$rute,$desc,$loc);
            
            $data['status_kronologi'] = $s['status'];
            $data['uuid'] = $s['pmi_news'].".".$s['loc'];
            $data['news_labor_id'] = $s['pmi_news'];

            $this->defPath = '/public/support/img/';

            if(isset($_FILES['berkas'])){
				$config['upload_path']   = ROOTPATH.$this->defPath;
				$config['allowed_types'] = 'jpeg|jpg|png|gif|pdf';
				$config['encrypt_name']	 = true;
				$this->load->library('upload',$config);
				// var_dump($this->upload->do_upload('berkas'),ROOTPATH.$this->defPath);
				if($this->upload->do_upload('berkas')){
					$d = $this->upload->data();
					$j['berkas'] = [$this->defPath.$d['file_name']];
				}else echo $this->upload->display_errors();
			}
            $data['desc'] = json_encode($j);
            
            // die;

            $this->Kronologimodel->save($data);
            
            redirect(BASEURL.'/news_labor/all_proses/','refresh');
        }
        return;
    }

    private function _collect_for_json($s,$rute,$desc,$loc){
        $arr = ['no_perjalanan',
        'perusahaan_transportasi',
        'estimasi_waktu_kedatangan',
        'zona_waktu',
        'sumber_pembiayaan',
        'penerima',
        'tanggal_tindak_lanjut',
        'pendamping_pemulangan'];
        $r = ['rute'=>$rute,'ket'=>$desc,'lokasi'=>$loc];
        foreach($arr as $i){
            if(isset($s[$i])) $r[$i] = $s[$i];
        }
        return $r;
    }

    public function timeline($id){
        $this->prep_bootstrap();
        $this->load->model(['Kronologimodel','NewsLabormodel']);
        $D['d'] = $this->Kronologimodel->find_all('news_labor_id = "'.$id.'"',NULL,'created_at desc');
        $D['d0'] = $this->NewsLabormodel->find('uuid = "'.$id.'"');
        $this->template->write_view("content", 'kronologi/timeline',$D);
        $this->template->render();
    }
}

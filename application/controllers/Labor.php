<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Labor extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->library('template');
	    $this->template->set_template("template_admin_panel");
        $this->load->model('Labormodel');
        $this->load->helper('app');
        $this->listAgama = $this->config->item('agama');
        $this->listNegara = $this->config->item('negara');
        $this->jenisProfesi = $this->config->item('jenis_profesi');
        $this->statusNikah = $this->config->item('status_nikah');
        $this->pendidikan = $this->config->item('pendidikan');
        $this->jenisKelamin = $this->config->item('jenis_kelamin');
    }
	
	public function index(){
		$this->prep_bootstrap();
        $this->load->library('grocery_crud/Grocery_CRUD_extended');
        $C = new Grocery_CRUD_extended();
        // $this->cmt = $this->_get_cmt();
        $this->get_j = [];
        $C->set_table('labor')
        ->unset_delete()
        ->columns('nik','nama')
        ->fields('nik','nama','json_v','alamat_domisili','kecamatan_tujuan_pemulangan','tgl_lahir','tempat_lahir','jenis_kelamin','agama','status_nikah','pendidikan','no_telp',
        'p3mi','negara', 'jabatan', 'jenis_pekerjaan', 'nama_pengguna', 'telp_pengguna', 'gaji', 'perkiraan_tgl_mulai_kerja', 'asuransi', 'nomor_asuransi')
        ->unique_fields('nik')
        ->callback_edit_field('alamat_domisili',function($v,$r){
            $this->get_j = $this->get_j($r);
            return isset($this->get_j['alamat_domisili'])?'<textarea name="alamat_domisili">'.$this->get_j['alamat_domisili'].'</textarea>':'<textarea name="alamat_domisili"></textarea>';
        })
        ->callback_add_field('alamat_domisili',function(){
            return '<textarea name="alamat_domisili"></textarea>';
        })->field_type('tgl_lahir', 'date', 'hehe')
        ->callback_add_field('kecamatan_tujuan_pemulangan',function(){
            $this->load->model('Wilayahmodel');
            $R = $this->Wilayahmodel->find_all_tujuan(array_keys($this->config->item('provinsi')));
            $r = '<select name="tujuan">';
            foreach($R as $v) $r .= '<option value="'.$v['id_wilayah'].'">'.$v['nama_wilayah'].'</option>';
            return $r.'</select>';
        })->callback_edit_field('kecamatan_tujuan_pemulangan',function($V,$r){
            $this->load->model('Wilayahmodel');
            $R = $this->Wilayahmodel->find_all_tujuan(array_keys($this->config->item('provinsi')));
            $r = '<select name="tujuan">';
            
            foreach($R as $v){
                $s = $v == $this->get_j['kecamatan_domisili'] ?'selected':''; 
                $r .= '<option '.$s.' value="'.$v['id_wilayah'].'">'.$v['nama_wilayah'].'</option>';}
            return $r.'</select>';
        })
        ->callback_add_field('agama',function($v,$r){
            return $this->val_select('agama','',$this->listAgama);
        })->callback_edit_field('agama',function($v,$r){
            return $this->val_select('agama',$this->get_j['agama'],$this->listAgama);
        })->callback_add_field('negara',function($v,$r){
            return $this->val_select('negara','',$this->listNegara);
        })->callback_edit_field('negara',function($v,$r){
            return $this->val_select('negara',$this->get_j['TK-negara'],$this->listNegara);
        })->callback_edit_field('tempat_lahir',function($v,$r){
            return $this->val_input('tempat_lahir',$this->get_j['tempat_lahir']);
        })->callback_edit_field('jenis_kelamin',function($v,$r){
            return $this->val_select('jenis_kelamin',$this->get_j['jenis_kelamin'],$this->jenisKelamin);
        })->callback_add_field('jenis_kelamin',function($v,$r){
            return $this->val_select('jenis_kelamin','',$this->jenisKelamin);
        })->callback_edit_field('status_nikah',function($v,$r){
            return $this->val_select('status_nikah',$this->get_j['status_nikah'],$this->statusNikah);
        })->callback_add_field('status_nikah',function($v,$r){
            return $this->val_select('status_nikah','',$this->statusNikah);
        })->callback_edit_field('pendidikan',function($v,$r){
            return $this->val_select('pendidikan',$this->get_j['pendidikan'],$this->pendidikan);
        })->callback_add_field('pendidikan',function($v,$r){
            return $this->val_select('pendidikan','',$this->pendidikan);
        })->callback_edit_field('no_telp',function($v,$r){
            return $this->val_input('no_telp',$this->get_j['no_telp']);
        })
        ->callback_edit_field('p3mi',function($v,$r){ return $this->val_input('p3mi',$this->get_j['TK-p3mi']); })
        ->callback_edit_field('jabatan',function($v,$r){ return $this->val_input('jabatan',$this->get_j['TK-jabatan']); })
        ->callback_edit_field('jenis_pekerjaan',function($v,$r){ return $this->val_select('jenis_pekerjaan',$this->get_j['TK-jenis_pekerjaan'],$this->jenisProfesi); })
        ->callback_add_field('jenis_pekerjaan',function($v,$r){ return $this->val_select('jenis_pekerjaan','',$this->jenisProfesi); })
        ->callback_edit_field('nama_pengguna',function($v,$r){ return $this->val_input('nama_pengguna',$this->get_j['TK-nama_pengguna']); })
        ->callback_edit_field('telp_pengguna',function($v,$r){ return $this->val_input('telp_pengguna',$this->get_j['TK-telp_pengguna']); })
        ->callback_edit_field('gaji',function($v,$r){ return $this->val_input('gaji',$this->get_j['TK-gaji']); })
        ->callback_edit_field('perkiraan_tgl_mulai_kerja',function($v,$r){ return $this->val_input('perkiraan_tgl_mulai_kerja',$this->get_j['TK-perkiraan_tgl_mulai_kerja']); })
        ->callback_edit_field('asuransi',function($v,$r){ return $this->val_input('asuransi',$this->get_j['TK-asuransi']); })
        ->callback_edit_field('nomor_asuransi',function($v,$r){ return $this->val_input('nomor_asuransi',$this->get_j['TK-nomor_asuransi']); })
        ->callback_before_insert(array($this,'collect_data'))
        ->callback_before_update(array($this,'collect_data'))
        ->field_type('json_v', 'invisible')
        ->required_fields('nik','nama','alamat_domisili');
        $D = $C->render(); 
        
        $this->template->write_view("content", 'grocery_crud_content',$D);
        if(isset($this->get_j['tgl_lahir']))
            $this->template->write("js_bottom_scripts", '<script>$(document).ready(function() {$("#field-tgl_lahir").val("'.date('d/m/Y',strtotime($this->get_j['tgl_lahir'])).'");
            $(\'[name="tujuan"]\').val("'.$this->get_j['kecamatan_domisili'].'")
            });</script>',NULL,FALSE);
        $this->template->render();
	}

    public function val_input($name,$val='',$otherAttr=''){
        return gc_val_input($name,$val,$otherAttr);//'<input type="text" name="'.$name.'" '.$otherAttr.' id="field-'.$name.'" value="'.$val.'">';
    }

    public function val_select($name,$val,$ref){
        return gc_val_select($name,$val,$ref);
    }

    function collect_data($p){
        $p['json_v'] = json_encode(['alamat_domisili'=>$p['alamat_domisili'],'kecamatan_domisili'=>$p['tujuan'],
        'tgl_lahir'=>date('Y-m-d',strtotime($p['tgl_lahir'])),
        'tempat_lahir'=>$p['tempat_lahir'],
        'jenis_kelamin'=>$p['jenis_kelamin'],
        'status_nikah'=>$p['status_nikah'],
        'pendidikan'=>$p['pendidikan'],
        'agama'=>$p['agama'],
        'no_telp'=>$p['no_telp'],
        'TK-p3mi'=>$p['p3mi'], 
        'TK-negara'=>$p['negara'], 
        'TK-jabatan'=>$p['jabatan'], 
        'TK-jenis_pekerjaan'=>$p['jenis_pekerjaan'], 
        'TK-nama_pengguna'=>$p['nama_pengguna'], 
        'TK-telp_pengguna'=>$p['telp_pengguna'], 
        'TK-gaji'=>$p['gaji'], 
        'TK-perkiraan_tgl_mulai_kerja'=>$p['perkiraan_tgl_mulai_kerja'], 
        'TK-asuransi'=>$p['asuransi'], 
        'TK-nomor_asuransi'=>$p['nomor_asuransi']
        ]);
		unset($p['alamat_domisili']);
        unset($p['tujuan']);
        unset($p['tgl_lahir']);
        unset($p['tempat_lahir']);
        unset($p['jenis_kelamin']);
        unset($p['status_nikah']);
        unset($p['pendidikan']);
        unset($p['no_telp']);
        unset($p['agama']);
        unset($p['p3mi']); 
        unset($p['negara']); 
        unset($p['jabatan']); 
        unset($p['jenis_pekerjaan']); 
        unset($p['nama_pengguna']); 
        unset($p['telp_pengguna']); 
        unset($p['gaji']); 
        unset($p['perkiraan_tgl_mulai_kerja']); 
        unset($p['asuransi']); 
        unset($p['nomor_asuransi']);
        return $p;
    }

    public function get_j($id){
        $j = $this->Labormodel->queryOne('id = '.$id,'json_v','');
        return !empty($j)?json_decode($j,TRUE):[];
    }
}

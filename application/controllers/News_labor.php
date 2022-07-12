<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_labor extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->library('template');
	    $this->template->set_template("template_admin_panel");
        // $this->load->model('newslabormodel');
    }
	
	public function index($newsId){
		$this->prep_bootstrap();
        $this->load->model('newsmodel');
        $this->judulBerita = $this->newsmodel->queryOne('id = '.$newsId, 'judul', 'id ASC');

        $this->load->library('grocery_crud/Grocery_CRUD_extended');
        $C = new Grocery_CRUD_extended();
        $C->set_table('news_labor')
        ->unset_delete()
        ->unset_edit()
        ->columns('news_id','labor_id')
        ->set_relation('news_id','news','judul')
        ->set_relation('labor_id','labor','nama')
        ->fields('news_id','labor_id')
        ->display_as('news_id','berita kepulangan')
        ->display_as('labor_id','PMI')
        ->callback_add_field('news_id',function() use ($newsId){
            return '<input type="hidden" values="'.$newsId.'">'.$this->judulBerita;
        })
        ->where('news_id',$newsId)
        ->required_fields('judul','deskripsi');
        $D = $C->render('<h3>Pemulangan PMI Berita : '.$this->judulBerita.'</h3>'); 
        
        $this->template->write_view("content", 'grocery_crud_content',$D);
        $this->template->render();
	}
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    protected $publicAction = ['login', 'logout','login_as'];
    protected $allows = [];
   	public function __construct() {
		parent::__construct();
        $this->load->library('auth');

        $this->set('isLogin', $this->session->userdata('isLogin'));
        $this->basename = strtolower(get_class($this));
        // $this->output->enable_profiler(TRUE);
        $this->my_province = $this->session->userdata('location') !== null?$this->session->userdata('location'):$this->config->item('provinsiDefault');
	}

    public function set($key, $value) {
		$this->data[$key] = $value;
	}

    public function get($key) {
        if (array_key_exists($key, $this->data)) return $this->data[$key];
        return false;
    }

    public function _remap($action, $args=null) {
        $methods = $this->get_public_method($this);
        if (method_exists($this, $action)) { 
            if ($this->isAuth($action) || $this->get('isAdmin') ||($this->get('isLogin') && $this->checkAllowAction($action))) $this->call_func_array(array($this, $action), $args);
            else if ($this->get('isLogin')) {
              $this->setFlash('Permission Denied!.', 'bg-danger');
              redirect($_SERVER['HTTP_REFERER']);
            }else{
				redirect(BASEURL.'/user/login');
            }
        }
        else show_404($action);
    }

    private function checkAllowAction($action){
		// foreach($this->allows as $allow_item){ 
		// 	if(preg_match('/'.$allow_item.'/i',$action)){
		// 		return true;
		// 	}
		// }
		return true;
	}

    private function get_public_method($obj) {
        $methods = array();
        foreach(get_class_methods($obj) as $method) 
        {
           $reflect = new ReflectionMethod($obj, $method);
           if ($reflect->isPublic()) 
           {
              array_push($methods,$method);
           }
        }
        return $methods;
    }

    private function isAuth($action) {
        if (in_array($action, (array) $this->publicAction)) return true;
        else return $this->auth->is_auth($this->basename, $action);
    }

    private function call_func_array($callback, $args=null) {
        if ($args) call_user_func_array($callback, $args);
        else call_user_func($callback);
    }

	protected function prep_bootstrap($isLogin=TRUE){
        $this->template->write('css', '
            <link rel="stylesheet" href="'.BASEURL.'/components/bootstrap/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="'.BASEURL.'/assets/css/AdminLTE.min.css">
            <link rel="stylesheet" href="'.BASEURL.'/assets/css/skins/_all-skins.min.css">
            <link rel="stylesheet" href="'.BASEURL.'/components/font-awesome/css/font-awesome.min.css">', FALSE);

        $this->template->write('js_top_scripts','<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha512-bnIvzh6FU75ZKxp0GXLH9bewza/OIw6dLVh9ICg0gogclmYGguQJWl8U30WpbsGTqbIiAwxTsbe76DErLq5EDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>',FALSE);

        $this->template->write('js', '
                <script src="'.BASEURL.'/assets/js/adminlte.min.js"></script>
                <script src="'.BASEURL.'/components/bootstrap/dist/js/bootstrap.min.js"></script><script src="'.BASEURL.'/components/bootstrap/dist/js/bootstrap-typeahead.js"></script>', FALSE);
        if($isLogin) $this->template->write('left_menu',$this->draw_menu($this->build_menu_by_group()));
		return;
    }

    private function draw_menu($M){
        $t = '';
        foreach($M as $k=>$m){
            $childNode = isset($m['child'])?'<ul class="treeview-menu">'.$this->draw_menu($m['child']).'</ul>':'';
            $arrowChild = isset($m['child'])?'<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>':'';
            $t .= '<li class="'.(isset($m['child'])?'treeview':'').'">
            <a href="'.$m['url'].'">
              <i class="'.$m['icon'].'"></i> <span>'.$k.'</span>'.$arrowChild.'
            </a>'.$childNode.'
          </li>';
        }
        return $t;
    }

    private function build_menu_by_group(){
        $menu = ['pmi'=>[
            'icon'=>'fa fa-child',
            'url'=>BASEURL.'/labor'
            ],
            'news'=>['icon'=>'fa fa-bookmark',
            'url'=>BASEURL.'/news'],
            'pmi dalam proses'=>['icon'=>'fa fa-paper-plane',
            'url'=>BASEURL.'/news_labor/all_proses'],
            'set lokasi'=>['icon'=>'fa fa-map-marker',
            'url'=>BASEURL.'/lokasi/set_my'],
            'pmi selesai proses'=>['icon'=>'fa fa-file-text',
            'url'=>BASEURL.'/laporan/pmi_selesai'],
            'config'=>['child'=>[
                'user'=>[
                    'icon'=>'fa fa-gear',
                    'url'=>BASEURL.'/config/list_user'
                ]],'icon'=>'fa fa-gear',
                'url'=>'#']
            ];
        switch($this->session->userdata['userLogin']['group']){
            case '2':
                unset($menu['pmi dalam proses']);
                unset($menu['config']);
                unset($menu['set lokasi']);
                break;
            case '3':
                unset($menu['pmi']);
                unset($menu['news']);
                unset($menu['config']);
                break;
            default: break;
        }
        return $menu;
    }

}
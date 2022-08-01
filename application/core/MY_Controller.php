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

    public function not_remap($action, $args=null) {
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

	protected function prep_bootstrap(){
        $this->template->write('css', '
            <link rel="stylesheet" href="'.BASEURL.'/components/bootstrap/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="'.BASEURL.'/assets/css/AdminLTE.min.css">
            <link rel="stylesheet" href="'.BASEURL.'/assets/css/skins/_all-skins.min.css">
            <link rel="stylesheet" href="'.BASEURL.'/components/font-awesome/css/font-awesome.min.css">', FALSE);

        $this->template->write('js_top_scripts','<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha512-bnIvzh6FU75ZKxp0GXLH9bewza/OIw6dLVh9ICg0gogclmYGguQJWl8U30WpbsGTqbIiAwxTsbe76DErLq5EDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>',FALSE);

        $this->template->write('js', '
                <script src="'.BASEURL.'/assets/js/adminlte.min.js"></script>
                <script src="'.BASEURL.'/components/bootstrap/dist/js/bootstrap.min.js"></script><script src="'.BASEURL.'/components/bootstrap/dist/js/bootstrap-typeahead.js"></script>', FALSE);
		return;
    }

}
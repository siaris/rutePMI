<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth {
   protected $data;
   protected $ci;
   protected $allows = array();
   protected $remember_session = false;

    public function __construct() {
        $this->ci =& get_instance();
        $this->ci->load->model('usermodel');
        $this->ci->load->model('groupmodel');
        $this->ci->load->library('session');

        $this->data['loginRedirect'] = base_url();

        $groupModule = $this->ci->session->userdata('groupModule');
        if (is_array($groupModule)) {
            $controller = ''; $actions = '';
            foreach($groupModule as $module){         
                if ($module->permission) $actions = explode(',', $module->permission);
                if(isset($this->allows[$module->controller])) $this->allows[$module->controller] = array_merge($this->allows[$module->controller],$actions);
                else $this->allows[$module->controller] = $actions;
            }
        }
    }
    
    public function login($login_uname, $password) {
		$login = $this->ci->usermodel->login($login_uname, $password);
        
		if ($login !== false){ 
			$this->ci->session->set_userdata("remember_me", true);
			$this->setSessionLogin($login);

			if ($login[0]->group == 1){
				$this->ci->session->set_userdata('isAdmin', true);
			}
			redirect(BASEURL);
			return;
		}else{
			redirect(BASEURL.'/user/login');
			return false;
		}
	}

    private function setSessionLogin($D){
        $this->ci->session->set_userdata('isLogin', true);
        $S = $D[0]; $S->password = '';
		$this->ci->session->set_userdata('userLogin', (array)$S);
		// $fields = "module.id, module.controller, permission, module.action ";
		// $groups = explode(',', $D[0]->groups);
		// $groupModule = $this->ci->GroupModel->findGroupModule($groups, $fields); 
		// $this->ci->session->set_userdata('groupModule', $groupModule);
		return;
    }

    public function is_auth($controller=null, $action=null){
    
        if (in_array($controller, array_keys($this->allows)) && in_array($action, (array) $this->allows[$controller])) return true;
        else if (in_array($controller, array_keys($this->allows)) && empty($this->allows[$controller])) return true;
        
        return false;
    }

    public function logout() {
        $this->ci->session->sess_destroy();
        redirect(BASEURL.'/user/login');
    }
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usermodel extends MY_Model {
   protected $tableName = 'user';
   protected $resultMode = 'object';
   protected $noJoin = false;
   
   public function login($user, $password, $not_md5 = false) {
	   $pass_to_compare = md5($password);
	   if($not_md5 === true)
		   $pass_to_compare = $password;
	   $fields = [
         'user.id as id', 
         'user.username',
         'user.password',
         'user.name',
         'user.status',
         'user.group',
         "GROUP_CONCAT(group.id SEPARATOR ',') as groups",
         "GROUP_CONCAT(group.name SEPARATOR ',') as group_name"];      
	   $strFields = implode(', ', $fields);
      $this->db->select($strFields, false);
      $this->db->join('user_group', 'user_group.user_id=user.id');
      $this->db->join('group', 'group.id=user_group.group_id');
      $this->db->group_by('user.id');
      $this->db->where(['username'=>$user, 'password'=>$pass_to_compare, 'status'=>1]);
      $result = $this->db->get($this->tableName)->result_object();
      // var_dump(count($result),$this->db->last_query());die;
      if (count($result) > 0) {
         return $result;
      } else {
         return false;
      }
   }
   
   public function set_no_join($boolean_val){
		$this->noJoin = $boolean_val;
   }
   
   protected function beforeFind() {
      if($this->noJoin === true){
		$this->fields = array(
         'user.id as id', 
         'user.username',
         'user.password',
         'user.name',
         'user.status',
         'user.group',
         'user.nip',
         'user.pegawai_id',
         'user.id_instalasi',
         'user.id_poli',
		 'user.map_user_function'
		);
		return;
	  }
	  $this->fields = array(
         'user.id as id', 
         'user.username',
         'user.password',
         'user.name',
         'user.status',
         'user.group',
         'user.nip',
         'user.pegawai_id',
         'user.id_instalasi',
         'user.id_poli',
         "GROUP_CONCAT(group.id SEPARATOR ',') as groups",
         "GROUP_CONCAT(group.name SEPARATOR ',') as group_name",
         'group.id_instalasi group_instalasi',
         'group.id_poli group_poli',
		   'map_user_function'
      );
      $this->db->join('user_group', 'user_group.user_id=user.id');
      $this->db->join('group', 'group.id=user_group.group_id');
      $this->db->group_by('user.id');
   }
   
   protected function _parse($rResult, $aColumns, $action, $output) {
      
      if ($rResult) {
         foreach($rResult as $aRow) {
            $row = array();
            for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
               /* General output */
               $field = $this->field_alias($aColumns[$i]);
               $row[] = $this->isDateFormat($aRow->{$field});
            }
            
            if ($action) {
               if ($aRow->id == 1) 
                  $row[] = "";
               else 
                  $row[] = sprintf($action, $aRow->id);
            }
                        
            $output['aaData'][] = $row;
         }
      } else {
         $output['aaData'] = "";
      }
      return json_encode( $output );

   }
   
   public function addGroups($data) {
      $this->db->where('user_id', $data['id']);
      $this->db->delete('user_group');
      
      if (is_array($data['groups'])) {
         foreach($data['groups'] as $group) {
            $this->db->set('user_id', $data['id']);
            $this->db->set('group_id', $group);
            $return = $this->db->insert('user_group');
         }
      }
      return $return;
   }
   
   public function findiduser($id)
   {
	    $query = $this->db->query('SELECT id FROM user WHERE pegawai_id = '.$id.' LIMIT 1');
		$row = $query->row();
		return $row->id;
	}
	
	function mapQGenerator($key,$operator=null,$field_used=''){
		$CI =& get_instance();
		$CI->load->model('mastersumberreferensimodel');
		$uraian_json = $CI->mastersumberreferensimodel->queryOne('kode_ref = "'.$key.'"','uraian_json',null);
		if(empty($uraian_json)){  //config not found
			$return[] = !empty($operator)?'1 '.$operator:1;
			$return[] = 1;
		}else{
			$this->uraian_arr = json_decode($uraian_json,true);
			if(in_array($this->session->userdata['userLogin']['id'],$this->uraian_arr['invulnerable_user'])){ //invulnerable user
				$return[] = !empty($operator)?'1 '.$operator:1;
				$return[] = 1;
			}elseif(!empty($this->session->userdata['userLogin']['map_user_function'])){ //bangun kondisi
				$this->field_used = !empty($field_used)?$field_used:$this->uraian_arr['primary_key'];
				$return = $this->filterMapUser($this->session->userdata['userLogin']['map_user_function'],$key,$operator);
			}else{ //config tidak ditemukan
				$return[] = !empty($operator)?'1 '.$operator:1;
				$return[] = 0;
			}
		}
		return $return;
	}
	
	private function filterMapUser($map_user,$key,$operator){
		$map_user_array = json_decode($map_user,true);
		$return[] = !empty($operator)?'1 '.$operator:1;
		$return[] = 0;
		if(isset($map_user_array[$key])){
			$return = array();
			$return[] = $this->field_used.' in ';
			$return[] = '("'.implode('","',$map_user_array[$key]).'")';
		}	
		return $return;
	}

   function extract_map($v){
      if (strlen($v) > 1) $r = $v;
      else
         if($v == 0) $r = false;
         elseif($v == 1) $r = true;
      
      return $r;
   }
         
}
?>

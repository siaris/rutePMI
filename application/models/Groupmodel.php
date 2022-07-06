<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groupmodel extends MY_Model {
   protected $tableName = 'group';
   protected $resultMode = 'object';


   protected function _parse($rResult, $aColumns, $action, $output) {
      
      if ($rResult) {
         foreach($rResult as $aRow) {
            $row = array();
            for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
               /* General output */
               $row[] = $this->isDateFormat($aRow->{$aColumns[$i]});
            }
            
            if ($action) {
               if ($aRow->id == 1) 
                  $row[] = "";
               else 
                  $row[] = sprintf($action, $aRow->id);
            }
            
            $row["DT_RowId"] = trim($aRow->id);
            
            $output['aaData'][] = $row;
         }
      } else {
         $output['aaData'] = "";
      }
      
      return json_encode( $output );

   }
   
   public function saveModule($data) {
      $this->db->where('group_id', $data['id']);
      $this->db->delete('group_module');
      
      if (is_array($data['module'])) {
         foreach($data['module'] as $module) {
            $this->db->set('group_id', $data['id']);
            $this->db->set('module_id', $module);
            if (!empty($data['permission'][$module]) && is_array($data['permission'][$module]))
               $this->db->set('permission', implode(',', $data['permission'][$module]));
            $return = $this->db->insert('group_module');
         }
      }
      return $return;
   }

   public function findModule($group=0) {
      $this->db->select("module.id, module.name, module.description, module.controller, module.action, permission, group.id as group_id");
      if (is_array($group)) {
		$this->db->join('group_module', 'group.id=group_id and group_id IN ('.implode(',', $group).')', 'left');
	  } else {
		$this->db->join('group_module', 'group.id=group_id and group_id = '.$group, 'left');
      }
      $this->db->join('module', 'module_id=module.id', 'right');
      
      $query = $this->db->get($this->tableName);
      if ($query->num_rows() > 0) {
         if ($this->resultMode === 'object') {
            return $query->result();
         } else {
            return $query->result_array();
         }
      }
   }
   
   public function findGroupModule($group=0, $fileds=null) {
      if (!empty($fileds)) {
         $this->db->select($fileds);
      } else {
         $this->db->select("module.id, module.name, module.description, module.controller, module.action, permission, group.id as group_id");
      }
      $this->db->join('group_module', 'group.id=group_id', 'left');
      $this->db->join('module', 'module_id=module.id', 'right');
      if (is_array($group)) {
		  $this->db->where_in('group.id', $group);
	  } else {
		$this->db->where('group.id', $group);
	  }
      
      $query = $this->db->get($this->tableName);
      if ($query->num_rows() > 0) {
         if ($this->resultMode === 'object') {
            return $query->result();
         } else {
            return $query->result_array();
         }
      }
   }
   
   public function getGroup($group)
   {
	   $query = $this->db->query('SELECT default_link FROM `group` WHERE group.id = '.$group.'');
	  // return $query->result();
	  return 'pendaftaran/igh';
   }

}
?>

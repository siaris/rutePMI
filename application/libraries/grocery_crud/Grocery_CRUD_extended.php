<?php 
require_once "Grocery_CRUD.php";
class Grocery_CRUD_extended extends Grocery_CRUD{
	protected $_unique_fields = array();
	protected $_unique_logfar_fields = [];
	protected $post_ajax_callbacks = array();
	protected $default_language_path				= 'components/grocery_crud/languages';
	protected $default_config_path					= 'components/grocery_crud/config';
	protected $default_assets_path					= 'components/grocery_crud';

	public $unset_columns_filter, $unset_columns_order, $value_is_string_in_excel = [];
	public $put_search_above = false;
	public $data_to_edit;

    public function unique_fields(){
        $args = func_get_args();

        if(isset($args[0]) && is_array($args[0]))
        {
            $args = $args[0];
        }

        $this->_unique_fields = $args;

        return $this;
	}
	
	

    protected function db_insert_validation(){
        $validation_result = (object)array('success'=>false);

        $field_types = $this->get_field_types();
		$unique_fields = $this->_unique_fields;
		$unique_logfar_fields = $this->_unique_logfar_fields;
        $add_fields = $this->get_add_fields();

        if(!empty($unique_fields))
        {
            $form_validation = $this->form_validation();

            foreach($add_fields as $add_field)
            {
                $field_name = $add_field->field_name;
                if(in_array( $field_name, $unique_fields) )
                {
                    $form_validation->set_rules( $field_name, 
                            $field_types[$field_name]->display_as, 
                            'is_unique['.$this->basic_db_table.'.'.$field_name.']');
                }
            }

            if(!$form_validation->run())
            {
                $validation_result->error_message = $form_validation->error_string();
                $validation_result->error_fields = $form_validation->_error_array;

                return $validation_result;
            }
		}
		
		if(!empty($unique_logfar_fields))
        {
            $form_validation = $this->form_validation();

            foreach($add_fields as $add_field)
            {
                $field_name = $add_field->field_name;
                if(in_array( $field_name, $unique_logfar_fields) )
                {
                    $form_validation->set_rules( $field_name, 
                            $field_types[$field_name]->display_as, 
                            'item_logfar_unique['.$this->basic_db_table.'.'.$field_name.']');
                }
            }

            if(!$form_validation->run())
            {
                $validation_result->error_message = $form_validation->error_string();
                $validation_result->error_fields = $form_validation->_error_array;

                return $validation_result;
            }
        }
        return parent::db_insert_validation();
    }

    protected function db_update_validation(){
        $validation_result = (object)array('success'=>false);

        $field_types = $this->get_field_types();
        $unique_fields = $this->_unique_fields;
        $add_fields = $this->get_add_fields();

        if(!empty($unique_fields))
        {
            $form_validation = $this->form_validation();

            $form_validation_check = false;

            foreach($add_fields as $add_field)
            {
                $field_name = $add_field->field_name;
                if(in_array( $field_name, $unique_fields) )
                {
                    $state_info = $this->getStateInfo();
                    $primary_key = $this->get_primary_key();
                    $field_name_value = $_POST[$field_name];

                    $ci = &get_instance();
                    $previous_field_name_value = 
                        $ci->db->where($primary_key,$state_info->primary_key)
                            ->get($this->basic_db_table)->row()->$field_name;

                    if(!empty($previous_field_name_value) && $previous_field_name_value != $field_name_value) {
                        $form_validation->set_rules( $field_name, 
                                $field_types[$field_name]->display_as, 
                                'is_unique['.$this->basic_db_table.'.'.$field_name.']');

                        $form_validation_check = true;
                    }
                }
            }

            if($form_validation_check && !$form_validation->run())
            {
                $validation_result->error_message = $form_validation->error_string();
                $validation_result->error_fields = $form_validation->_error_array;

                return $validation_result;
            }
        }
        return parent::db_update_validation();
    }   
		
	protected function pre_render_extended(){
		$this->_initialize_variables();
		$this->_initialize_helpers();
		$this->_load_language();
		$this->state_code = $this->getStateCode();
		
		if($this->basic_model === null)
			$this->set_default_Model();
		
		$this->set_basic_db_table($this->get_table());	

		$this->_load_date_format();
		
		$this->_set_primary_keys_to_model();
	}
	
	public function render_view_to_print(){
		$this->pre_render_extended();
		
		if( $this->state_code != 0 )
		{
			$this->state_info = $this->getStateInfo();
		}
		else
		{
			throw new Exception('The state is unknown , I don\'t know what I will do with your data!', 4);
			die();
		}
		
		switch ($this->state_code) {
			case 3://edit_for_print
				if($this->unset_edit)
				{
					throw new Exception('You don\'t have permissions for this operation', 14);
					die();
				}
				
				if($this->theme === null)
					$this->set_theme($this->default_theme);				
				$this->setThemeBasics();
				
				$this->set_basic_Layout();
				
				$state_info = $this->getStateInfo();
				
				$this->showEditForm_extended($state_info);
				
			break;
		}
		
		return $this->get_layout();
	}
	
	protected function showEditForm_extended($state_info){
		$this->set_js($this->default_javascript_path.'/jquery-1.8.1.min.js');
		
		$data 				= $this->get_common_data();
		$data->types 		= $this->get_field_types();
		
		$data->field_values = $this->get_edit_values($state_info->primary_key);
		
		$data->add_url		= $this->getAddUrl();
		
		$data->list_url 	= $this->getListUrl();
		$data->update_url	= $this->getUpdateUrl($state_info);
		$data->delete_url	= $this->getDeleteUrl($state_info);
		$data->input_fields = $this->get_edit_input_fields($data->field_values);

		$data->fields 		= $this->get_edit_fields();
		$data->hidden_fields	= $this->get_edit_hidden_fields();
		$data->unset_back_to_list	= $this->unset_back_to_list;
		$data->unset_button_update	= $this->unset_button_update;
		
		$data->unset_back	= $this->unset_back;
		$data->unset_cancel	= $this->unset_cancel;
		
		$data->validation_url	= $this->getValidationUpdateUrl($state_info->primary_key); 
		
		$this->_theme_view('edit_for_print.php',$data);
		$this->_inline_js("var js_date_format = '".$this->js_date_format."';");
	}
	
	public function unset_button_update(){
		$this->unset_button_update = true;
		
		return $this;
	}
	
	protected function get_list(){
		if(!empty($this->order_by))
			$this->basic_model->order_by($this->order_by[0],$this->order_by[1]);

		if(!empty($this->where))
			foreach($this->where as $where)
				$this->basic_model->where($where[0],$where[1],$where[2]);

		if(!empty($this->or_where))
			foreach($this->or_where as $or_where)
				$this->basic_model->or_where($or_where[0],$or_where[1],$or_where[2]);

		if(!empty($this->like))
			foreach($this->like as $like)
				$this->basic_model->like($like[0],$like[1],$like[2]);
		
		if(!empty($this->or_like)){
			foreach($this->or_like as $or_like)
				$or_like_arr[] = $or_like[0]." LIKE '%".$or_like[1]."%'";
				//$this->basic_model->or_like_ala_aris($or_like[0],$or_like[1],$or_like[2]);
			$this->basic_model->db->where('('.implode(' OR ',$or_like_arr).')');
		}

		if(!empty($this->having))
			foreach($this->having as $having)
				$this->basic_model->having($having[0],$having[1],$having[2]);

		if(!empty($this->or_having))
			foreach($this->or_having as $or_having)
				$this->basic_model->or_having($or_having[0],$or_having[1],$or_having[2]);

		if(!empty($this->relation))
			foreach($this->relation as $relation)
				$this->basic_model->join_relation($relation[0],$relation[1],$relation[2]);

		if(!empty($this->relation_n_n))
		{
			$columns = $this->get_columns();
			foreach($columns as $column)
			{
				//Use the relation_n_n ONLY if the column is called . The set_relation_n_n are slow and it will make the table slower without any reason as we don't need those queries.
				if(isset($this->relation_n_n[$column->field_name]))
				{
					$this->basic_model->set_relation_n_n_field($this->relation_n_n[$column->field_name]);
				}
			}

		}

		if($this->theme_config['crud_paging'] === true)
		{
			if($this->limit === null)
			{
				$default_per_page = $this->config->default_per_page;
				if(is_numeric($default_per_page) && $default_per_page >1)
				{
					$this->basic_model->limit($default_per_page);
				}
				else
				{
					$this->basic_model->limit(10);
				}
			}
			else
			{
				$this->basic_model->limit($this->limit[0],$this->limit[1]);
			}
		}

		$results = $this->basic_model->get_list();

		return $results;
	}
	
	protected function get_total_results(){
		if(!empty($this->where))
			foreach($this->where as $where)
				$this->basic_model->where($where[0],$where[1],$where[2]);

		if(!empty($this->or_where))
			foreach($this->or_where as $or_where)
				$this->basic_model->or_where($or_where[0],$or_where[1],$or_where[2]);

		if(!empty($this->like))
			foreach($this->like as $like)
				$this->basic_model->like($like[0],$like[1],$like[2]);

		if(!empty($this->or_like)){
			foreach($this->or_like as $or_like)
				$or_like_arr[] = $or_like[0]." LIKE '%".$or_like[1]."%'";
			$this->basic_model->db->where('('.implode(' OR ',$or_like_arr).')');
		}

		if(!empty($this->having))
			foreach($this->having as $having)
				$this->basic_model->having($having[0],$having[1],$having[2]);

		if(!empty($this->or_having))
			foreach($this->or_having as $or_having)
				$this->basic_model->or_having($or_having[0],$or_having[1],$or_having[2]);

		if(!empty($this->relation))
			foreach($this->relation as $relation)
				$this->basic_model->join_relation($relation[0],$relation[1],$relation[2]);

		if(!empty($this->relation_n_n))
		{
			$columns = $this->get_columns();
			foreach($columns as $column)
			{
				//Use the relation_n_n ONLY if the column is called . The set_relation_n_n are slow and it will make the table slower without any reason as we don't need those queries.
				if(isset($this->relation_n_n[$column->field_name]))
				{
					$this->basic_model->set_relation_n_n_field($this->relation_n_n[$column->field_name]);
				}
			}

		}

		return $this->basic_model->get_total_results();
	}

	public function post_ajax_callbacks($callback) {
        $this->post_ajax_callbacks[] = $callback;
    }
	
	protected function showList($ajax = false, $state_info = null){
		$data = $this->get_common_data();

		$data->order_by 	= $this->order_by;

		$data->types 		= $this->get_field_types();

		$data->list = $this->get_list();
		$data->list = $this->change_list($data->list , $data->types);
		$data->list = $this->change_list_add_actions($data->list);

		$data->total_results = $this->get_total_results();

		$data->columns 				= $this->get_columns();
		$data->unset_columns_filter = $this->unset_columns_filter; //20160216-aris buat unset filter untuk theme flexigrid-aris
		$data->unset_columns_order = $this->unset_columns_order; //20160216-aris buat unset order untuk theme flexigrid-aris
		$data->success_message		= $this->get_success_message_at_list($state_info);

		$data->primary_key 			= $this->get_primary_key();
		$data->add_url				= $this->getAddUrl();
		$data->edit_url				= $this->getEditUrl();
		$data->delete_url			= $this->getDeleteUrl();
		$data->read_url				= $this->getReadUrl();
		$data->ajax_list_url		= $this->getAjaxListUrl();
		$data->ajax_list_info_url	= $this->getAjaxListInfoUrl();
		$data->export_url			= $this->getExportToExcelUrl();
		$data->print_url			= $this->getPrintUrl();
		$data->actions				= $this->actions;
		$data->unique_hash			= $this->get_method_hash();
		$data->order_by				= $this->order_by;
		$data->post_ajax_callbacks  = $this->post_ajax_callbacks;
		$data->table_title 			= isset($this->table_title) ? $this->table_title : '';

		$data->unset_add			= $this->unset_add;
		$data->unset_edit			= $this->unset_edit;
		$data->unset_read			= $this->unset_read;
		$data->unset_delete			= $this->unset_delete;
		$data->unset_export			= $this->unset_export;
		$data->unset_print			= $this->unset_print;

		$default_per_page = $this->config->default_per_page;
		$data->paging_options = $this->config->paging_options;
		$data->default_per_page		= is_numeric($default_per_page) && $default_per_page >1 && in_array($default_per_page,$data->paging_options)? $default_per_page : 25;

		if($data->list === false)
		{
			throw new Exception('It is impossible to get data. Please check your model and try again.', 13);
			$data->list = array();
		}

		foreach($data->list as $num_row => $row)
		{
			$data->list[$num_row]->edit_url = $data->edit_url.'/'.$row->{$data->primary_key};
			$data->list[$num_row]->delete_url = $data->delete_url.'/'.$row->{$data->primary_key};
			$data->list[$num_row]->read_url = $data->read_url.'/'.$row->{$data->primary_key};
		}

		if(!$ajax)
		{
			$this->_add_js_vars(array('dialog_forms' => $this->config->dialog_forms));

			$data->list_view = $this->_theme_view('list.php',$data,true);
			$tmplt = ($this->put_search_above===false)?'list_template':'list_template_s_above';
			$this->_theme_view($tmplt.'.php',$data);
		}
		else
		{
			$this->set_echo_and_die();
			$this->_theme_view('list.php',$data);
		}
	}

	public function set_table_title( $table_title ){		
		$this->table_title 			= $table_title;
		$this->table_title_plural 	= $table_title;
			
		return $this;
	}
	
	protected function _export_to_excel($data){
		/**
		 * No need to use an external library here. The only bad thing without using external library is that Microsoft Excel is complaining
		 * that the file is in a different format than specified by the file extension. If you press "Yes" everything will be just fine.
		 * */

		$string_to_export = "";
		foreach($data->columns as $column){
			$string_to_export .= $column->display_as."\t";
		}
		$string_to_export .= "\n";

		foreach($data->list as $num_row => $row){
			foreach($data->columns as $column){
				$a_char = '';
				if(in_array($column->field_name,$this->value_is_string_in_excel))
					$a_char = '|';
				$string_to_export .= $a_char.$this->_trim_export_string($row->{$column->field_name}).$a_char."\t";
			}
			$string_to_export .= "\n";
		}

		// Convert to UTF-16LE and Prepend BOM
		$string_to_export = "\xFF\xFE" .mb_convert_encoding($string_to_export, 'UTF-16LE', 'UTF-8');

		$filename = "export-".date("Y-m-d_H:i:s").".xls";

		header('Content-type: application/vnd.ms-excel;charset=UTF-16LE');
		header('Content-Disposition: attachment; filename='.$filename);
		header("Cache-Control: no-cache");
		echo $string_to_export;
		die();
	}

	protected function get_edit_values($primary_key_value){
		return $r = $this->data_to_edit = parent::get_edit_values($primary_key_value);
	}
}
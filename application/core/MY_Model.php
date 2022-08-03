<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Model extends CI_Model {

    var $use_dbconfig = 'default';
    var $id = null;
    var $data = array();
    var $table;
    var $primary_key = 'id';
    var $fields = array();
    var $__insert_id = null;
    var $__num_rows = null;
    var $__affected_rows = null;
    var $return_array = TRUE;
    var $debug = FALSE;
    var $queries = array();
    var $_parent_name = '';

    function __construct() {
        parent::__construct();

        $this->_assign_libraries((method_exists($this, '__get') OR method_exists($this, '__set')) ? FALSE : TRUE );

        // We don't want to assign the model object to itself when using the
        // assign_libraries function below so we'll grab the name of the model parent
        $this->_parent_name = ucfirst(get_class($this));

        log_message('debug', "Model Class Initialized");
    }

    /**
     * Assign Libraries
     *
     * Creates local references to all currently instantiated objects
     * so that any syntax that can be legally used in a controller
     * can be used within models.  
     *
     * @access private
     */
    function _assign_libraries($use_reference = TRUE) {
        $CI = & get_instance();
        foreach (array_keys(get_object_vars($CI)) as $key) {
            if (!isset($this->$key) AND $key != $this->_parent_name) {
                // In some cases using references can cause
                // problems so we'll conditionally use them
                if ($use_reference == TRUE) {
                    // Needed to prevent reference errors with some configurations
                    $this->$key = '';
                    $this->$key = & $CI->$key;
                } else {
                    $this->$key = $CI->$key;
                }
            }
        }
    }

    /**
     * Load the associated database table.
     *
     * @author md emran hasan <emran@rightbrainsolution.com>
     * @access public
     */
    function load_table($table, $config = 'default') {
        if ($this->debug)
            log_message('debug', "Loading model table: $table");

        $this->table = $table;
        $this->use_dbconfig = $config;

        $this->load->database($config);
        $this->fields = $this->db->list_fields($this->set_table($table));

        if ($this->debug) {
            log_message('debug', "Successfull Loaded model table: $table");
        }
    }

    /**
     * Returns a resultset array with specified fields from database matching given conditions.
     *
     * @author md emran hasan <emran@rightbrainsolution.com>
     * @return query result either in array or in object based on model config
     * @access public
     */
    function find_all($conditions = NULL, $fields = '*', $order = NULL, $start = 0, $limit = NULL) {
        if ($conditions != NULL) {
            $this->db->where($conditions);
        }

        if ($fields != NULL) {
            $this->db->select($fields, FALSE);
        }
		
		if (isset($this->join)) {
			foreach($this->join as $table => $val) {
				//list($condition, $type) = each($val);
				//$this->db->join($table, $condition, $type);
				$this->db->join($table, @$val[0], @$val[1]);
			}
		}

        if ($order != NULL) {
            $this->db->order_by($order);
        }

        if ($limit != NULL) {
            $this->db->limit($limit, $start);
        }

        $query = $this->db->get($this->table);
        $this->__num_rows = $query->num_rows();

        if ($this->debug) {
            echo $this->queries[] = $this->db->last_query();
        }

        return ($this->return_array) ? $query->result_array() : $query->result();
    }
    
    /*
     * Aris adding Group By
     */
    function find_all_with_groupby($conditions = NULL, $fields = '*', $order = NULL, $groupby = NULL, $start = 0, $limit = NULL) {
        if ($groupby != NULL) {
            $this->db->group_by($groupby);
        }
        return $this->find_all($conditions, $fields, $order, $start, $limit);
    }

    function find_all_with_query($sql) {
        $query = $this->db->query($sql);
        return ($this->return_array) ? $query->result_array() : $query->result();
    }

    /**
     * Return a single row as a resultset array with specified fields from database matching given conditions.
     *
     * @author md emran hasan <emran@rightbrainsolution.com>
     * @return single row either in array or in object based on model config
     * @access public
     */
    function find($conditions = NULL, $fields = '*', $order = 'id ASC') {
        $data = $this->find_all($conditions, $fields, $order, 0, 1);

        if ($data) {
            return $data[0];
        } else {
            return false;
        }
    }

    /**
     * Returns contents of a field in a query matching given conditions.
     *
     * @author md emran hasan <emran@rightbrainsolution.com>
     * @return string the value of the field specified of the first row
     * @access public
     */
    function field($conditions = null, $name, $fields = '*', $order = 'id ASC') {
        $data = $this->find_all($conditions, $fields, $order, 0, 1);

        if ($data) {
            $row = $data[0];

            if (isset($row[$name])) {
                return $row[$name];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Returns number of rows matching given SQL condition.
     *
     * @author md emran hasan <emran@rightbrainsolution.com>
     * @return integer the number of records returned by the condition 
     * @access public
     */
    function find_count($conditions = null) {
        $data = $this->find_all($conditions, 'COUNT(*) AS count', null, 0, 1);

        if ($data) {
            return $data[0]['count'];
        } else {
            return false;
        }
    }

    /**
     * Returns a key value pair array from database matching given conditions.
     *
     * Example use: generateList(null, '', 0. 10, 'id', 'username');
     * Returns: array('10' => 'emran', '11' => 'hasan')
     *
     * @author md emran hasan <emran@rightbrainsolution.com>
     * @return array a list of key value pairs given criteria
     * @access public
     */
    function generate_list($conditions = null, $order = 'id ASC', $start = 0, $limit = NULL, $key = null, $value = null, $first_key = '-1', $first_value = 'Inget valt') {
        $data = $this->find_all($conditions, "$key, $value", $order, $start, $limit);

        if ($data) {

            if ($first_key != NULL) {
                $keys[] = $first_key;
                $vals[] = $first_value;
            }

            foreach ($data as $row) {
                $keys[] = ($this->return_array) ? $row[$key] : $row->$key;
                $vals[] = ($this->return_array) ? $row[$value] : $row->$value;
            }

            if (!empty($keys) && !empty($vals)) {
                $return = array_combine($keys, $vals);
                return $return;
            }
        } else {
            return false;
        }
    }

    /**
     * Returns an array of the values of a specific column from database matching given conditions.
     *
     * Example use: generateSingleArray(null, 'name');
     *
     * @author md emran hasan <emran@rightbrainsolution.com>
     * @return array a list of key value pairs given criteria
     * @access public
     */
    function generate_single_array($conditions = null, $field = null, $order = 'id ASC', $start = 0, $limit = NULL) {
        $data = $this->find_all($conditions, "$field", $order, $start, $limit);

        if ($data) {
            foreach ($data as $row) {
                $arr[] = ($this->return_array) ? $row[$field] : $row->$field;
            }

            return $arr;
        } else {
            return false;
        }
    }

    /**
     * Initializes the model for writing a new record.
     *
     * @author md emran hasan <emran@rightbrainsolution.com>
     * @return boolean True
     * @access public
     */
    function create() {
        $this->id = false;
        unset($this->data);

        $this->data = array();
        return true;
    }

    /**
     * Returns a list of fields from the database and saves in the model
     *
     * @author md emran hasan <emran@rightbrainsolution.com>
     * @return array Array of database fields
     * @access public
     */
    function read($id = null, $fields = null) {
        if ($id != null) {
            $this->id = $id;
        }

        $id = $this->id;

        if ($this->id !== null && $this->id !== false) {
            $this->data = $this->find($this->primary_key . ' = ' . $id, $fields);
            return $this->data;
        } else {
            return false;
        }
    }

    /**
     * Inserts a new record in the database.
     *
     * @author md emran hasan <emran@rightbrainsolution.com>
     * @return boolean success
     * @access public
     */
    function insert($data = null, $return_id = true) {
        if ($data == null) {
            return FALSE;
        }

        $this->_assign_libraries('admin_session');
        $this->data = $data;
        $this->data['created_by'] = $this->admin_session->getSession('username');
        $this->data['created_date'] = date("Y-m-d H:i:s");

        foreach ($this->data as $key => $value) {
            if (array_search($key, $this->fields) === FALSE) {
                unset($this->data[$key]);
            }
        }

        $this->db->insert($this->table, $this->data);

        if ($this->debug) {
            $this->queries[] = $this->db->last_query();
        }

        if ($return_id) {
            $this->__insert_id = $this->db->insert_id();
            return $this->__insert_id;
        }
    }

    function insert_non_return($data = null) {
        $this->insert($data, false);
    }

    /**
     * Saves model data to the database.
     *
     * @author md emran hasan <emran@rightbrainsolution.com>
     * @return boolean success
     * @access public
     */
    function save($data = null, $id = null, $xss = TRUE) {
        $this->_assign_libraries('admin_session');
        if ($data) {
            $this->data = $data;
            // $this->data['last_upd_by'] = $this->admin_session->getSession('username');
            // $this->data['last_upd_date'] = date("Y-m-d H:i:s");
        }

        foreach ($this->data as $key => $value) {
            if (array_search($key, $this->fields) === FALSE) {
                unset($this->data[$key]);
            }
        }

        if ($xss) {
            // $this->data = $this->input->xss_clean($this->data);
        }

        if ($id != null) {
            $this->id = $id;
        }

        $id = $this->id;

        if ($this->id !== null && $this->id !== false) {
            if (is_array($this->primary_key)) {
                $this->db->where($this->primary_key);
            }else
                $this->db->where($this->primary_key, $id);

            $this->db->update($this->table, $this->data);

            if ($this->debug) {
                $this->queries[] = $this->db->last_query();
            }

            $this->__affected_rows = $this->db->affected_rows();
            return $this->id;
        } else {
            $this->db->insert($this->table, $this->data);

            if ($this->debug) {
                $this->queries[] = $this->db->last_query();
            }

            $this->__insert_id = $this->db->insert_id();
            return $this->__insert_id;
        }
    }

    /**
     * Removes record for given id. If no id is given, the current id is used. Returns true on success.
     *
     * @author md emran hasan <emran@rightbrainsolution.com>
     * @return boolean True on success
     * @access public
     */
    function remove($id = null) {
        if ($id != null) {
            $this->id = $id;
        }

        $id = $this->id;

        if ($this->id !== null && $this->id !== false) {
            if ($this->db->delete($this->table, array($this->primary_key => $id))) {
                $this->id = null;
                $this->data = array();

                if ($this->debug) {
                    $this->queries[] = $this->db->last_query();
                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Returns a resultset for given SQL statement. Generic SQL queries should be made with this method.
     *
     * @author md emran hasan <emran@rightbrainsolution.com>
     * @return array Resultset
     * @access public
     */
    function query($sql) {
        $ret = $this->db->query($sql);

        if ($this->debug) {
            $this->queries[] = $this->db->last_query();
        }

        return $ret;
    }

    /**
     * Returns the last query that was run (the query string, not the result).
     *
     * @author md emran hasan <emran@rightbrainsolution.com>
     * @return string SQL statement
     * @access public
     */
    function last_query() {
        return $this->db->last_query();
    }

    /**
     * Returns the list of all queries peformed (if debug is TRUE)
     *
     * @author md emran hasan <emran@rightbrainsolution.com>
     * @return array list of SQL statements
     * @access public
     */
    function debug_queries() {
        $queries = array_reverse($this->queries);
        return $queries;
    }

    /**
     * This function simplifies the process of writing database inserts. It returns a correctly formatted SQL insert string.
     *
     * @author md emran hasan <emran@rightbrainsolution.com>
     * @return string SQL statement
     * @access public
     */
    function insert_string($data) {
        return $this->db->insert_string($this->table, $data);
    }

    /**
     * Returns the current record's ID.
     *
     * @author md emran hasan <emran@rightbrainsolution.com>
     * @return integer The ID of the current record
     * @access public
     */
    function get_id() {
        return $this->id;
    }

    /**
     * Returns the ID of the last record this Model inserted.
     *
     * @author md emran hasan <emran@rightbrainsolution.com>
     * @return int
     * @access public
     */
    function get_insert_id() {
        return $this->__insert_id;
    }

    /**
     * Returns the number of rows returned from the last query.
     *
     * @author md emran hasan <emran@rightbrainsolution.com>
     * @return int
     * @access public
     */
    function get_num_rows() {
        return $this->__num_rows;
    }

    /**
     * Returns the number of rows affected by the last query
     *
     * @author md emran hasan <emran@rightbrainsolution.com>
     * @return int
     * @access public
     */
    function get_affected_rows() {
        return $this->__affected_rows;
    }

    function execute($sql) {
        if (!$this->db->query($sql))
            return false;
        return true;
    }

    function queryOne($conditions = NULL, $fields, $order) {
        $result = $this->find($conditions, $fields, $order);
        return $result[$fields];
    }

    /*
     * get table hacked by Aris for PostgreSQL with more than one schema
     */
    function set_table($table) {
        if ($this->db->dbdriver == 'postgre') {
            if (preg_match('|\.|', $table)) {
                $table_array = explode('.', $table);
                return $table_array[1];
            }
            return $table;
        }
        return $table;
    }

}

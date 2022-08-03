<?

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kronologimodel extends MY_Model {
    function __construct() {
        $this->table = 'kronologi_perjalanan';
        $this->primary_key = 'id';
        $this->load_table($this->table);
    }
}
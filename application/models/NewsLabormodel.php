<?

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class NewsLabormodel extends MY_Model {
    function __construct() {
        $this->table = 'news_labor';
        $this->load_table($this->table);
        $this->primary_key = 'uuid';
    }
}
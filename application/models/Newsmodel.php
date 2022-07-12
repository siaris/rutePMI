<?

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Newsmodel extends MY_Model {
    function __construct() {
        $this->table = 'news';
    }
}
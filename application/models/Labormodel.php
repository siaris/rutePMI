<?

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Labormodel extends MY_Model {
    function __construct() {
        $this->table = 'labor';
    }
}
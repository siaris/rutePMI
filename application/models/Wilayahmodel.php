<?

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wilayahmodel extends MY_Model {
    function __construct() {
        $this->table = 'wilayah';
    }

    function find_all_tujuan($prv){
        $this->db->join('wilayah w1','w1.id_wilayah = left(wilayah.id_wilayah,4)','inner');
        $this->db->join('wilayah w2','w2.id_wilayah = left(w1.id_wilayah,2)','inner');
        return $this->find_all('wilayah.id_wilayah regexp "^('.implode('|',$prv).')" and length(wilayah.id_wilayah) = 6','wilayah.id_wilayah,concat(wilayah.nama_wilayah," - ",w1.nama_wilayah," - ",w2.nama_wilayah) nama_wilayah');
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends CI_Model
{

    public function cekLogin($username, $password)
    {
        $query = "select * from karyawan where (username='" . $username . "' and password='" . $password . "') and statusaktif='Aktif' ";
        return $this->db->query($query);
    }

    public function update($idkaryawan, $data)
    {
        $this->db->where('idkaryawan', $idkaryawan);
        return $this->db->update('karyawan', $data);
    }

}

/* End of file Login_model.php */
/* Location: ./application/models/Login_model.php */

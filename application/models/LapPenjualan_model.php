<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LapPenjualan_model extends CI_Model
{

    public function getLapPenjualan($tglawal, $tglakhir, $idkaryawan)
    {
        $filter = "";

        if ($idkaryawan != '') {
            $filter .= "AND idkaryawan='$idkaryawan' ";
        }

        $strSQL = "
			SELECT * FROM v_penjualan
			WHERE tglpenjualan BETWEEN '$tglawal' AND '$tglakhir' $filter
		";

        return $this->db->query($strSQL);
    }

}

/* End of file LapPenjualan_model.php */
/* Location: ./application/models/LapPenjualan_model.php */

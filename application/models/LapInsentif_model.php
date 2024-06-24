<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LapInsentif_model extends CI_Model
{

    public function getLapInsentif($tglawal, $tglakhir, $idkaryawan)
    {
        $filter = "";
        if ($idkaryawan != '') {
            $filter .= "AND idkaryawan='$idkaryawan' ";
        }

        $strSQL = "
			SELECT * FROM v_mapping_insentif
			WHERE tglmapping BETWEEN '$tglawal' AND '$tglakhir' $filter
		";

        return $this->db->query($strSQL);
    }

}

/* End of file LapInsentif_model.php */
/* Location: ./application/models/LapInsentif_model.php */

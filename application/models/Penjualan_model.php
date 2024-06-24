<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan_model extends CI_Model
{

    public $table    = 'penjualan';
    public $pK_table = 'idpenjualan';
    public $v_table  = 'v_penjualan';

    public $column_order  = array(null, 'idpenjualan', 'tglpenjualan', 'idkonsumen', 'namakonsumen', 'notelp', 'email', 'keterangan', 'totalharga', 'tglinsert', 'tglupdate', 'idkaryawan', 'namakaryawan', 'jabatan');
    public $column_search = array('idpenjualan', 'tglpenjualan', 'idkonsumen', 'namakonsumen', 'notelp', 'email', 'keterangan', 'totalharga', 'tglinsert', 'tglupdate', 'idkaryawan', 'namakaryawan', 'jabatan');
    public $order         = array('tglpenjualan' => 'asc'); // default order

    public function getAll()
    {
        return $this->db->get($this->v_table);
    }

    public function getById($primaryKey)
    {
        $this->db->where($this->pK_table, $primaryKey);
        return $this->db->get($this->v_table);
    }

    public function delete($primaryKey)
    {
        $this->db->trans_begin();

        $this->db->query("DELETE FROM penjualan_detail WHERE idpenjualan='$primaryKey' ");

        $idkaryawan   = $this->session->userdata('idpengguna');
        $tglpenjualan = $this->db->query("SELECT tglpenjualan FROM penjualan WHERE idpenjualan='$primaryKey' ")->row()->tglpenjualan;

        $this->db->where($this->pK_table, $primaryKey);
        $this->db->delete($this->table);

        $this->insentif($idkaryawan, $tglpenjualan);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function insert($data, $dataDetail)
    {
        $this->db->trans_begin();

        $this->db->insert($this->table, $data);
        $this->db->insert_batch('penjualan_detail', $dataDetail);

        $this->insentif($data['idkaryawan'], $data['tglpenjualan']);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }

    }

    public function update($data, $primaryKey, $dataDetail)
    {
        $this->db->trans_begin();

        $this->db->query("DELETE FROM penjualan_detail WHERE idpenjualan='$primaryKey' ");
        $this->db->insert_batch('penjualan_detail', $dataDetail);

        $this->db->where($this->pK_table, $primaryKey);
        $this->db->update($this->table, $data);

        $this->insentif($data['idkaryawan'], $data['tglpenjualan']);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function insentif($idkaryawan, $tglpenjualan)
    {
        $this->db->trans_begin();
        // Start

        $tglpenjualan = date('Y-m-d', strtotime($tglpenjualan));

        $this->db->query("DELETE FROM mapping_insentif_detail WHERE idmapping IN(
                            SELECT idmapping FROM mapping_insentif WHERE tglmapping='$tglpenjualan' AND idkaryawan='$idkaryawan'
                        );");
        $this->db->query("DELETE FROM mapping_insentif WHERE tglmapping='$tglpenjualan' AND idkaryawan='$idkaryawan' ");

        $strPenjualan = "
                            SELECT SUM(totalharga) AS totalharga
                            FROM penjualan
                            WHERE tglpenjualan='$tglpenjualan' AND idkaryawan='$idkaryawan'
                        ";

        $queryPenjualan = $this->db->query($strPenjualan);
        if ($queryPenjualan->num_rows() > 0) {
            $Penjualan_totalharga = $queryPenjualan->row()->totalharga;

            $rowinsentif = $this->db->query("SELECT idinsentif, target, besarbonus FROM insentif WHERE idinsentif='INS-000001'")->row();
            $idinsentif  = $rowinsentif->idinsentif;
            $target      = $rowinsentif->target;
            $besarbonus  = $rowinsentif->besarbonus;

            if ($Penjualan_totalharga >= $target) {

                $idmapping = $this->db->query("SELECT f_idmapping_create('" . $tglpenjualan . "') AS idmapping ")->row()->idmapping;
                $strInsert = "
                    INSERT INTO mapping_insentif
                                (idmapping,
                                 tglmapping,
                                 idkaryawan,
                                 idinsentif,
                                 besarbonus,
                                 tagerterjual,
                                 target)
                    VALUES ('" . $idmapping . "',
                            '" . $tglpenjualan . "',
                            '" . $idkaryawan . "',
                            '" . $idinsentif . "',
                            " . $besarbonus . ",
                            " . $Penjualan_totalharga . ",
                            " . $target . ");
                ";
                $this->db->query($strInsert);

                $strQueryDetail = "
                    SELECT idbarang, SUM(qty) AS totalqty FROM penjualan_detail WHERE idpenjualan IN(
                        SELECT idpenjualan FROM penjualan WHERE tglpenjualan='$tglpenjualan' AND idkaryawan='$idkaryawan'
                    )
                    GROUP BY idbarang;
                ";

                $queryDetail = $this->db->query($strQueryDetail);
                if ($queryDetail->num_rows() > 0) {
                    foreach ($queryDetail->result() as $rowDetail) {

                        $statusLoop = 0;

                        $queryInsentifBarang = $this->db->query("SELECT * FROM barang_insentif WHERE idbarang='$rowDetail->idbarang' AND statusaktif='Aktif' ORDER BY targetqty_awal ASC;");
                        if ($queryInsentifBarang->num_rows() > 0) {
                            foreach ($queryInsentifBarang->result() as $rowInsentifBarang) {

                                $totalqty        = $rowDetail->totalqty;
                                $targetqty_awal  = $rowInsentifBarang->targetqty_awal;
                                $targetqty_akhir = $rowInsentifBarang->targetqty_akhir;

                                $idbarang_insentif_Terakhir = $this->db->query("
                                    SELECT idbarang_insentif FROM barang_insentif WHERE idbarang='$rowDetail->idbarang' AND statusaktif='Aktif' AND targetqty_akhir=(
                                             SELECT MAX(targetqty_akhir) FROM barang_insentif WHERE idbarang='$rowDetail->idbarang' AND statusaktif='Aktif')
                                             ;
                                ")->row()->idbarang_insentif;

                                if ($statusLoop == 0) {

                                    if ($rowInsentifBarang->idbarang_insentif == $idbarang_insentif_Terakhir) {
                                        if ($totalqty >= $targetqty_awal) {
                                            $statusLoop = 1;
                                            $this->db->query("
                                                INSERT INTO mapping_insentif_detail
                                                            (idmapping,
                                                             idbarang_insentif,
                                                             bonus,
                                                             qtyterjual)
                                                VALUES ('$idmapping',
                                                        '$rowInsentifBarang->idbarang_insentif',
                                                        '$rowInsentifBarang->bonus',
                                                        '$rowDetail->totalqty');
                                            ");
                                        }
                                    } else {
                                        if ($totalqty >= $targetqty_awal and $totalqty <= $targetqty_akhir) {
                                            $statusLoop = 1;
                                            $this->db->query("
                                                INSERT INTO mapping_insentif_detail
                                                            (idmapping,
                                                             idbarang_insentif,
                                                             bonus,
                                                             qtyterjual)
                                                VALUES ('$idmapping',
                                                        '$rowInsentifBarang->idbarang_insentif',
                                                        '$rowInsentifBarang->bonus',
                                                        '$rowDetail->totalqty');
                                            ");
                                        }
                                    }

                                }

                            }
                        }

                    }
                }

            }
        }

        // end start
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    // Datatable serverside
    private function _get_datatables_query()
    {
        $level = $this->session->userdata('level');
        if ($level == 'Canvasser') {
            $idpengguna = $this->session->userdata('idpengguna');
            $this->db->where('idkaryawan', $idpengguna);
        }

        $this->db->from($this->v_table);
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end();
                }

            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $level = $this->session->userdata('level');
        if ($level == 'Canvasser') {
            $idpengguna = $this->session->userdata('idpengguna');
            $this->db->where('idkaryawan', $idpengguna);
        }

        $this->db->from($this->v_table);
        return $this->db->count_all_results();
    }

}

/* End of file Penjualan_model.php */
/* Location: ./application/models/Penjualan_model.php */

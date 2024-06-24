<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_insentif_model extends CI_Model
{

    public $table    = 'barang_insentif';
    public $pK_table = 'idbarang_insentif';
    public $v_table  = 'v_barang_insentif';

    public $column_order  = array(null, 'idbarang_insentif', 'idbarang', 'namabarang', 'jenis', 'satuan', 'hargajual', 'foto', 'targetqty_awal', 'targetqty_akhir', 'bonus', 'tglinsert', 'tglupdate', 'statusaktif', 'idkaryawan', 'namakaryawan', 'jabatan');
    public $column_search = array('idbarang_insentif', 'idbarang', 'namabarang', 'jenis', 'satuan', 'hargajual', 'foto', 'targetqty_awal', 'targetqty_akhir', 'bonus', 'tglinsert', 'tglupdate', 'statusaktif', 'idkaryawan', 'namakaryawan', 'jabatan');
    public $order         = array('idbarang' => 'asc'); // default order

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
        $this->db->where($this->pK_table, $primaryKey);
        return $this->db->delete($this->table);
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($data, $primaryKey)
    {
        $this->db->where($this->pK_table, $primaryKey);
        return $this->db->update($this->table, $data);
    }

    // Datatable serverside
    private function _get_datatables_query()
    {

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
        $this->db->from($this->v_table);
        return $this->db->count_all_results();
    }

}

/* End of file Barang_insentif_model.php */
/* Location: ./application/models/Barang_insentif_model.php */

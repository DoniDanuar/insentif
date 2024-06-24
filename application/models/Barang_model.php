<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_model extends CI_Model {

    var $table             = 'barang';
    var $pK_table          = 'idbarang';   
    var $v_table           = 'barang';

    var $column_order = array(null, 'idbarang','namabarang','jenis','satuan','hargajual','foto','statusaktif' );
    var $column_search = array('idbarang','namabarang','jenis','satuan','hargajual','foto','statusaktif');
    var $order = array('idbarang' => 'asc'); // default order 
   

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
            if($_POST['search']['value']) {
                if($i===0) {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }else {
                    $this->db->or_like($item, $_POST['search']['value']);
                } if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }else if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    function count_all()
    {
        $this->db->from($this->v_table);
        return $this->db->count_all_results();
    }

}

/* End of file Barang_model.php */
/* Location: ./application/models/Barang_model.php */
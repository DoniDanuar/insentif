<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{

    public $controller   = 'Penjualan';
    public $loadViewList = 'penjualan/list';
    public $loadViewForm = 'penjualan/form';

    public $formNameHead = 'Penjualan';
    public $formNameData = 'Data Penjualan';
    public $formNameAdd  = 'Form Tambah Data';
    public $formNameEdit = 'Form Edit Data';

    public $menu = 'Penjualan';

    public function __construct()
    {
        parent::__construct();
        $this->isLogin();
        $this->load->model('Penjualan_model');

        $config['upload_path']   = 'uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size']      = '2000000KB'; // 200KB
        $config['quality']       = '100%';
        $config['remove_space']  = true;

        $this->load->library('upload', $config);
        $this->load->library('image_lib');
    }

    public function isLogin()
    {
        $idpengguna = $this->session->userdata('idpengguna');
        if (empty($idpengguna)) {
            $pesan = '
                        <script type="text/javascript">
                          Swal.fire(
                          "Gagal !",
                          "Session telah berakhir. Silahkan login kembali . . . ",
                          "error"
                        );
                        </script>
                        ';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('Login');
            exit();
        }
    }

    public function index()
    {
        $data['menu']         = $this->menu;
        $data['controller']   = $this->controller;
        $data['formNameHead'] = $this->formNameHead;
        $data['formNameData'] = $this->formNameData;
        $this->load->view($this->loadViewList, $data);
    }

    public function tambah()
    {
        $data['primaryKey'] = '';

        $data['menu']         = $this->menu;
        $data['controller']   = $this->controller;
        $data['formNameHead'] = $this->formNameHead;
        $data['formNameData'] = $this->formNameData;
        $data['formName']     = $this->formNameAdd;
        $data['button']       = 'Simpan';
        $this->load->view($this->loadViewForm, $data);
    }

    public function edit($primaryKey)
    {
        $primaryKey = $this->encrypt->decode($primaryKey);
        if ($this->Penjualan_model->getById($primaryKey)->num_rows() == 0) {
            $pesan = '
                        <script type="text/javascript">
                          Swal.fire(
                          "Gagal !",
                          "Data tidak ditemukan",
                          "error"
                        );
                        </script>
                        ';
            $this->session->set_flashdata('pesan', $pesan);
            redirect($this->controller);
            exit();
        };

        $data['primaryKey'] = $primaryKey;

        $data['menu']         = $this->menu;
        $data['controller']   = $this->controller;
        $data['formNameHead'] = $this->formNameHead;
        $data['formNameData'] = $this->formNameData;
        $data['formName']     = $this->formNameEdit;
        $data['button']       = 'Update';
        $this->load->view($this->loadViewForm, $data);
    }

    public function hapus($primaryKey)
    {
        $primaryKey = $this->encrypt->decode($primaryKey);
        if ($this->Penjualan_model->getById($primaryKey)->num_rows() == 0) {
            $pesan = '
                        <script type="text/javascript">
                          Swal.fire(
                          "Gagal !",
                          "Data tidak ditemukan",
                          "error"
                        );
                        </script>
                        ';
            $this->session->set_flashdata('pesan', $pesan);
            redirect($this->controller);
            exit();
        };

        $hapus = $this->Penjualan_model->delete($primaryKey);
        if ($hapus) {
            $pesan = $this->pesan(true, 'Hapus');
        } else {
            $pesan = $this->pesan(false, 'Gagal');
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect($this->controller);
    }

    public function simpan()
    {

        $idpenjualan  = $this->input->post('idpenjualan');
        $tglpenjualan = date('Y-m-d', strtotime($this->input->post('tglpenjualan')));
        $idkonsumen   = $this->input->post('idkonsumen');
        $keterangan   = $this->input->post('keterangan');
        $totalharga   = untitik($this->input->post('totalharga'));
        $tglinsert    = date('Y-m-d H:i:s');
        $tglupdate    = date('Y-m-d H:i:s');
        $idkaryawan   = $this->session->userdata('idpengguna');

        $isidatatable = $this->input->post('isidatatable');

        if ($idpenjualan == '') {

            $idpenjualan = $this->db->query("SELECT f_idpenjualan_create('" . date('Y-m-d') . "') AS idpenjualan")->row()->idpenjualan;

            $data = array(
                'idpenjualan'  => $idpenjualan,
                'tglpenjualan' => $tglpenjualan,
                'idkonsumen'   => $idkonsumen,
                'keterangan'   => $keterangan,
                'totalharga'   => $totalharga,
                'tglinsert'    => $tglinsert,
                'tglupdate'    => $tglupdate,
                'idkaryawan'   => $idkaryawan,
            );

            $dataDetail = array();
            foreach ($isidatatable as $item) {
                $idbarang   = $item[1];
                $qty        = $item[5];
                $hargajual  = $item[4];
                $totalharga = $item[6];

                $dataDetailTemp = array(
                    'idpenjualan' => $idpenjualan,
                    'idbarang'    => $idbarang,
                    'qty'         => untitik($qty),
                    'hargajual'   => untitik($hargajual),
                    'totalharga'  => untitik($totalharga),
                );

                array_push($dataDetail, $dataDetailTemp);
            }

            $simpan = $this->Penjualan_model->insert($data, $dataDetail);
            if ($simpan) {
                echo json_encode(array(
                    'success' => true,
                    'msg'     => 'Data Berhasil Disimpan',
                ));
                exit();
            } else {
                $eror = $this->db->error();
                echo json_encode(array(
                    'success' => false,
                    'msg'     => 'Kode Eror: ' . $eror['code'] . ' ' . $eror['message'],
                ));
                exit();
            }

        } else {

            $data = array(
                'tglpenjualan' => $tglpenjualan,
                'idkonsumen'   => $idkonsumen,
                'keterangan'   => $keterangan,
                'totalharga'   => $totalharga,
                'tglinsert'    => $tglinsert,
                'tglupdate'    => $tglupdate,
                'idkaryawan'   => $idkaryawan,
            );

            $dataDetail = array();
            foreach ($isidatatable as $item) {
                $idbarang   = $item[1];
                $qty        = $item[5];
                $hargajual  = $item[4];
                $totalharga = $item[6];

                $dataDetailTemp = array(
                    'idpenjualan' => $idpenjualan,
                    'idbarang'    => $idbarang,
                    'qty'         => untitik($qty),
                    'hargajual'   => untitik($hargajual),
                    'totalharga'  => untitik($totalharga),
                );

                array_push($dataDetail, $dataDetailTemp);
            }

            $simpan = $this->Penjualan_model->update($data, $idpenjualan, $dataDetail);
            if ($simpan) {
                echo json_encode(array(
                    'success' => true,
                    'msg'     => 'Data Berhasil Disimpan',
                ));
                exit();
            } else {
                $eror = $this->db->error();
                echo json_encode(array(
                    'success' => false,
                    'msg'     => 'Kode Eror: ' . $eror['code'] . ' ' . $eror['message'],
                ));
                exit();
            }
        }
    }

    public function pesan($boolean, $pesan)
    {
        if ($boolean) {
            $output = '
                        <script type="text/javascript">
                          Swal.fire(
                          "Berhasil !",
                          "Data Berhasil Di ' . $pesan . ' !",
                          "success"
                        );
                        </script>
                        ';
        } else {
            $eror   = $this->db->error();
            $output = '
                        <script type="text/javascript">
                          Swal.fire(
                          "Gagal !",
                          "Pesan Error : ' . $eror['code'] . ' ' . $eror['message'] . '",
                          "error"
                        );
                        </script>
                        ';
        }
        return $output;
    }

    // UPLOAD FILE
    public function upload_file($file, $nama)
    {
        if (!empty($file[$nama]['tmp_name'])) {
            if ($this->upload->do_upload($nama)) {
                $file = $this->upload->data('file_name');
                $size = $this->upload->data('file_size');
                $ext  = $this->upload->data('file_ext');

                // $this->resize_foto($this->upload->data());

            } else {
                $file = "";
            }
        } else {
            $file = "";
        }
        return $file;
    }

    public function update_upload_file($file, $nama, $file_lama)
    {
        if (!empty($file[$nama]['tmp_name'])) {
            if ($this->upload->do_upload($nama)) {
                $file = $this->upload->data('file_name');
                $size = $this->upload->data('file_size');
                $ext  = $this->upload->data('file_ext');

                // $this->resize_foto($this->upload->data());

            } else {
                $file = $file_lama;
            }
        } else {
            $file = $file_lama;
        }
        return $file;
    }

    public function resize_foto($data)
    {
        $config['image_library']  = 'gd2';
        $config['source_image']   = 'uploads/' . $data['file_name'];
        $config['create_thumb']   = false;
        $config['maintain_ratio'] = false;
        $config['quality']        = '70';
        $config['width']          = 600;
        $config['height']         = 480;
        $config['new_image']      = 'uploads/' . $data['file_name'];

        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }
    // END UPLOAD FILE

    // AJAX
    public function getEditData()
    {
        $primaryKey = $this->input->post('primaryKey');
        $result     = $this->Penjualan_model->getById($primaryKey)->row();

        $data = array(
            'idpenjualan'  => $result->idpenjualan,
            'tglpenjualan' => $result->tglpenjualan,
            'idkonsumen'   => $result->idkonsumen,
            'namakonsumen' => $result->namakonsumen,
            'notelp'       => $result->notelp,
            'email'        => $result->email,
            'keterangan'   => $result->keterangan,
            'totalharga'   => $result->totalharga,
            'tglinsert'    => $result->tglinsert,
            'tglupdate'    => $result->tglupdate,
            'idkaryawan'   => $result->idkaryawan,
            'namakaryawan' => $result->namakaryawan,
            'jabatan'      => $result->jabatan,

        );

        echo (json_encode($data));
    }

    public function getData()
    {
        $data    = $this->Penjualan_model->get_datatables();
        $dataArr = array();
        $no      = $_POST['start'];

        foreach ($data as $row) {
            $no++;
            $arr = array();

            $arr[] = $no;
            $arr[] = $row->idpenjualan;

            $arr[] = formatHariTanggal($row->tglpenjualan);
            $arr[] = '<small>
                        ID. ' . $row->idkonsumen . ' <br>
                        <b>' . $row->namakonsumen . '</b> <br>
                        No. Telp : ' . $row->notelp . '
                    </small>';

            $arr[] = $row->keterangan;
            $arr[] = 'Rp. ' . number_format($row->totalharga);
            $arr[] = '<small>
                        ID. ' . $row->idkaryawan . ' <br>
                        <b>' . $row->namakaryawan . '</b> <br>
                        Jabatan : ' . $row->jabatan . '
                    </small>';

            $arr[] = '
                        <a href="' . site_url($this->controller . '/edit/' . $this->encrypt->encode($row->idpenjualan)) . '" class="btn btn-sm btn-warning btn-circle" title="Edit Data">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a href="' . site_url($this->controller . '/hapus/' . $this->encrypt->encode($row->idpenjualan)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus" title="Hapus Data">
                            <i class="fa fa-trash"></i>
                        </a>';

            array_push($dataArr, $arr);
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Penjualan_model->count_all(),
            "recordsFiltered" => $this->Penjualan_model->count_filtered(),
            "data"            => $dataArr,
        );

        echo json_encode($output);
    }

    public function datatablesourcedetail()
    {
        $idpenjualan = $this->input->post('idpenjualan');
        $data        = array();

        $no    = 1;
        $query = $this->db->query("SELECT * FROM v_penjualan_detail WHERE idpenjualan='$idpenjualan' ");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $dataTemp = array(
                    $no++,
                    $row->idbarang,
                    '<b>' . $row->namabarang . '</b><br> Satuan : ' . $row->satuan,
                    $row->jenis,
                    number_format($row->hargajual),
                    number_format($row->qty),
                    number_format($row->totalharga),
                    '<span class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></span>',
                );
                array_push($data, $dataTemp);
            }
        }

        $output = array(
            'data' => $data,
        );

        echo (json_encode($output));
    }

    public function getBarang()
    {
        $idbarang = $this->input->post('idbarang');
        $qty      = untitik($this->input->post('qty'));

        $query = $this->db->query("SELECT * FROM barang WHERE idbarang='$idbarang' ");
        if ($query->num_rows() > 0) {
            $row = $query->row();

            $totalharga = $qty * $row->hargajual;

            $data = array(
                'idbarang'   => $row->idbarang,
                'namabarang' => '<b>' . $row->namabarang . '</b><br> Satuan : ' . $row->satuan,
                'jenis'      => $row->jenis,
                'hargajual'  => $row->hargajual,
                'qty'        => $qty,
                'totalharga' => $totalharga,
            );
        } else {
            $data = array();
        }

        echo (json_encode($data));
    }
    // END AJAX

}

/* End of file Penjualan.php */
/* Location: ./application/controllers/Penjualan.php */

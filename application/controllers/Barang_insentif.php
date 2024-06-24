<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_insentif extends CI_Controller
{

    public $controller   = 'Barang_insentif';
    public $loadViewList = 'barang_insentif/list';
    public $loadViewForm = 'barang_insentif/form';

    public $formNameHead = 'Insentif Per Barang';
    public $formNameData = 'Data Insentif Per Barang';
    public $formNameAdd  = 'Form Tambah Data';
    public $formNameEdit = 'Form Edit Data';

    public $menu = 'Barang_insentif';

    public function __construct()
    {
        parent::__construct();
        $this->isLogin();
        $this->load->model('Barang_insentif_model');

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
        if ($this->Barang_insentif_model->getById($primaryKey)->num_rows() == 0) {
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
        if ($this->Barang_insentif_model->getById($primaryKey)->num_rows() == 0) {
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

        $hapus = $this->Barang_insentif_model->delete($primaryKey);
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

        $idbarang_insentif = $this->input->post('idbarang_insentif');
        $idbarang          = $this->input->post('idbarang');
        $targetqty_awal    = untitik($this->input->post('targetqty_awal'));
        $targetqty_akhir   = untitik($this->input->post('targetqty_akhir'));
        $bonus             = untitik($this->input->post('bonus'));
        $tglinsert         = date('Y-m-d H:i:s');
        $tglupdate         = date('Y-m-d H:i:s');
        $idkaryawan        = $this->session->userdata('idpengguna');

        if ($this->input->post('statusaktif')) {
            $statusaktif = $this->input->post('statusaktif');
        } else {
            $statusaktif = "Tidak Aktif";
        }

        if ($idbarang_insentif == '') {

            $idbarang_insentif = $this->db->query("SELECT f_idbarang_insentif_create() AS idbarang_insentif")->row()->idbarang_insentif;

            $data = array(
                'idbarang_insentif' => $idbarang_insentif,
                'idbarang'          => $idbarang,
                'targetqty_awal'    => $targetqty_awal,
                'targetqty_akhir'   => $targetqty_akhir,
                'bonus'             => $bonus,
                'tglinsert'         => $tglinsert,
                'tglupdate'         => $tglupdate,
                'idkaryawan'        => $idkaryawan,
                'statusaktif'       => $statusaktif,
            );

            $simpan = $this->Barang_insentif_model->insert($data);
            if ($simpan) {
                $pesan = $this->pesan(true, 'Simpan');
            } else {
                $pesan = $this->pesan(true, 'Gagal');
            }

        } else {

            $data = array(
                'idbarang'        => $idbarang,
                'targetqty_awal'  => $targetqty_awal,
                'targetqty_akhir' => $targetqty_akhir,
                'bonus'           => $bonus,
                'tglinsert'       => $tglinsert,
                'tglupdate'       => $tglupdate,
                'idkaryawan'      => $idkaryawan,
                'statusaktif'     => $statusaktif,
            );

            $simpan = $this->Barang_insentif_model->update($data, $idbarang_insentif);
            if ($simpan) {
                $pesan = $this->pesan(true, 'Update');
            } else {
                $pesan = $this->pesan(true, 'Gagal');
            }
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect($this->controller);

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
        $result     = $this->Barang_insentif_model->getById($primaryKey)->row();

        $data = array(
            'idbarang_insentif' => $result->idbarang_insentif,
            'idbarang'          => $result->idbarang,
            'namabarang'        => $result->namabarang,
            'jenis'             => $result->jenis,
            'satuan'            => $result->satuan,
            'hargajual'         => number_format($result->hargajual),
            'foto'              => $result->foto,
            'targetqty_awal'    => $result->targetqty_awal,
            'targetqty_akhir'   => $result->targetqty_akhir,
            'bonus'             => number_format($result->bonus),
            'tglinsert'         => $result->tglinsert,
            'tglupdate'         => $result->tglupdate,
            'statusaktif'       => $result->statusaktif,
            'idkaryawan'        => $result->idkaryawan,
            'namakaryawan'      => $result->namakaryawan,
            'jabatan'           => $result->jabatan,

        );

        echo (json_encode($data));
    }

    public function getData()
    {
        $data    = $this->Barang_insentif_model->get_datatables();
        $dataArr = array();
        $no      = $_POST['start'];

        foreach ($data as $row) {
            $no++;
            $arr = array();

            $arr[] = $no;

            if ($row->statusaktif == 'Aktif') {
                $statusaktif = '<span class="badge badge-success">Aktif</span>';
            } else {
                $statusaktif = '<span class="badge badge-danger">Tidak Aktif</span>';
            }

            $arr[] = '<b>' . $row->idbarang_insentif . '</b> <br>' . $statusaktif;

            $arr[] = '<small>
                    ' . $row->idbarang . ' <br>
                    <b>' . $row->namabarang . '</b> / ' . $row->satuan . ' <br>
                    Harga : Rp. <b>' . number_format($row->hargajual) . '</b>
                    </small>';
            $arr[] = number_format($row->targetqty_awal);
            $arr[] = number_format($row->targetqty_akhir);
            $arr[] = 'Rp. ' . number_format($row->bonus);

            $arr[] = '<small>
                        ID. ' . $row->idkaryawan . ' <br>
                        <b>' . $row->namakaryawan . '</b> <br>
                        Jabatan : ' . $row->jabatan . '
                    </small>';

            $arr[] = '
                        <a href="' . site_url($this->controller . '/edit/' . $this->encrypt->encode($row->idbarang_insentif)) . '" class="btn btn-sm btn-warning btn-circle" title="Edit Data">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a href="' . site_url($this->controller . '/hapus/' . $this->encrypt->encode($row->idbarang_insentif)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus" title="Hapus Data">
                            <i class="fa fa-trash"></i>
                        </a>';

            array_push($dataArr, $arr);
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Barang_insentif_model->count_all(),
            "recordsFiltered" => $this->Barang_insentif_model->count_filtered(),
            "data"            => $dataArr,
        );

        echo json_encode($output);
    }
    // END AJAX

}

/* End of file Barang_insentif.php */
/* Location: ./application/controllers/Barang_insentif.php */

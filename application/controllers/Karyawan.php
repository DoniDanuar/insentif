<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{

    public $controller   = 'Karyawan';
    public $loadViewList = 'karyawan/list';
    public $loadViewForm = 'karyawan/form';

    public $formNameHead = 'Karyawan';
    public $formNameData = 'Data Karyawan';
    public $formNameAdd  = 'Form Tambah Data';
    public $formNameEdit = 'Form Edit Data';

    public $menu = 'Karyawan';

    public function __construct()
    {
        parent::__construct();
        $this->isLogin();
        $this->load->model('Karyawan_model');

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
        if ($this->Karyawan_model->getById($primaryKey)->num_rows() == 0) {
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
        if ($this->Karyawan_model->getById($primaryKey)->num_rows() == 0) {
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

        $hapus = $this->Karyawan_model->delete($primaryKey);
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

        $idkaryawan   = $this->input->post('idkaryawan');
        $namakaryawan = $this->input->post('namakaryawan');
        $jk           = $this->input->post('jk');
        $tempatlahir  = $this->input->post('tempatlahir');
        $tgllahir     = date('Y-m-d', strtotime($this->input->post('tgllahir')));
        $notelp       = $this->input->post('notelp');
        $email        = $this->input->post('email');
        $alamat       = $this->input->post('alamat');
        $jabatan      = $this->input->post('jabatan');
        $username     = $this->input->post('username');
        $password     = md5($this->input->post('password'));
        $foto         = $this->input->post('foto');

        $statusaktif = $this->input->post('statusaktif');
        if ($this->input->post('statusaktif')) {
            $statusaktif = $this->input->post('statusaktif');
        } else {
            $statusaktif = "Tidak Aktif";
        }

        if ($idkaryawan == '') {

            $idkaryawan = $this->db->query("SELECT f_idkaryawan_create() AS idkaryawan")->row()->idkaryawan;
            $foto       = $this->upload_file($_FILES, "file");

            $data = array(
                'idkaryawan'   => $idkaryawan,
                'namakaryawan' => $namakaryawan,
                'jk'           => $jk,
                'tempatlahir'  => $tempatlahir,
                'tgllahir'     => $tgllahir,
                'notelp'       => $notelp,
                'email'        => $email,
                'alamat'       => $alamat,
                'jabatan'      => $jabatan,
                'username'     => $username,
                'password'     => $password,
                'foto'         => $foto,
                'statusaktif'  => $statusaktif,
            );

            $simpan = $this->Karyawan_model->insert($data);
            if ($simpan) {
                $pesan = $this->pesan(true, 'Simpan');
            } else {
                $pesan = $this->pesan(true, 'Gagal');
            }

        } else {

            $file_lama = $this->input->post('file_lama');
            $foto      = $this->update_upload_file($_FILES, "file", $file_lama);

            $data = array(
                'namakaryawan' => $namakaryawan,
                'jk'           => $jk,
                'tempatlahir'  => $tempatlahir,
                'tgllahir'     => $tgllahir,
                'notelp'       => $notelp,
                'email'        => $email,
                'alamat'       => $alamat,
                'jabatan'      => $jabatan,
                'username'     => $username,
                'password'     => $password,
                'foto'         => $foto,
                'statusaktif'  => $statusaktif,
            );

            $simpan = $this->Karyawan_model->update($data, $idkaryawan);
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
        $result     = $this->Karyawan_model->getById($primaryKey)->row();

        $data = array(
            'idkaryawan'   => $result->idkaryawan,
            'namakaryawan' => $result->namakaryawan,
            'jk'           => $result->jk,
            'tempatlahir'  => $result->tempatlahir,
            'tgllahir'     => $result->tgllahir,
            'notelp'       => $result->notelp,
            'email'        => $result->email,
            'alamat'       => $result->alamat,
            'jabatan'      => $result->jabatan,
            'username'     => $result->username,
            'password'     => $result->password,
            'foto'         => $result->foto,
            'statusaktif'  => $result->statusaktif,
        );

        echo (json_encode($data));
    }

    public function getData()
    {
        $data    = $this->Karyawan_model->get_datatables();
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

            $arr[] = '<b> ID. ' . $row->idkaryawan . '</b> <br>' . $row->jabatan . '<br>' . $statusaktif;

            if ($row->foto == '') {
                $arr[] = '<img class="img-thumbnail" style="height: 75px; width: auto;" src="' . base_url('images/nofoto_l.png') . '">';
            } else {
                $arr[] = '<a href="' . base_url('uploads/' . $row->foto) . '" target="_blank"><img class="img-thumbnail" style="height: 75px; width: auto;" src="' . base_url('uploads/' . $row->foto) . '"></a>';
            }

            $arr[] = $row->namakaryawan . '<small><b> <br>' . $row->jk . '</b></small>';

            $arr[] = $row->tempatlahir . ', <br> ' . date('d/m/Y', strtotime($row->tgllahir));

            $arr[] = '<b><small> No. Telp. : ' . $row->notelp . '<br> Email : ' . $row->email . '</small></b>';
            $arr[] = '<small>' . $row->alamat . '</small>';
            $arr[] = $row->username;

            $arr[] = '
                        <a href="' . site_url($this->controller . '/edit/' . $this->encrypt->encode($row->idkaryawan)) . '" class="btn btn-sm btn-warning btn-circle" title="Edit Data">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a href="' . site_url($this->controller . '/hapus/' . $this->encrypt->encode($row->idkaryawan)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus" title="Hapus Data">
                            <i class="fa fa-trash"></i>
                        </a>';

            array_push($dataArr, $arr);
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Karyawan_model->count_all(),
            "recordsFiltered" => $this->Karyawan_model->count_filtered(),
            "data"            => $dataArr,
        );

        echo json_encode($output);
    }
    // END AJAX

}

/* End of file Karyawan.php */
/* Location: ./application/controllers/Karyawan.php */

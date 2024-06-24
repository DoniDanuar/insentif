<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Insentif extends CI_Controller
{

    public $controller   = 'Insentif';
    public $loadViewList = 'insentif/list';
    public $loadViewForm = 'insentif/form';

    public $formNameHead = 'Insentif';
    public $formNameData = 'Data Insentif';
    public $formNameAdd  = 'Form Tambah Data';
    public $formNameEdit = 'Form Edit Data';

    public $menu = 'Insentif';

    public function __construct()
    {
        parent::__construct();
        $this->isLogin();
        $this->load->model('Insentif_model');

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
        if ($this->Insentif_model->getById($primaryKey)->num_rows() == 0) {
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
        if ($this->Insentif_model->getById($primaryKey)->num_rows() == 0) {
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

        $hapus = $this->Insentif_model->delete($primaryKey);
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

        $idinsentif = $this->input->post('idinsentif');
        $target     = untitik($this->input->post('target'));
        $besarbonus = untitik($this->input->post('besarbonus'));
        $keterangan = $this->input->post('keterangan');

        if ($this->input->post('statusaktif')) {
            $statusaktif = $this->input->post('statusaktif');
        } else {
            $statusaktif = "Tidak Aktif";
        }

        $tginsert   = date('Y-m-d H:i:s');
        $tglupdate  = date('Y-m-d H:i:s');
        $idkaryawan = $this->session->userdata('idpengguna');

        if ($idinsentif == '') {

            $idinsentif = $this->db->query("SELECT f_idinsentif_create() AS idinsentif")->row()->idinsentif;

            $data = array(
                'idinsentif'  => $idinsentif,
                'target'      => $target,
                'besarbonus'  => $besarbonus,
                'keterangan'  => $keterangan,
                'statusaktif' => $statusaktif,
                'tginsert'    => $tginsert,
                'tglupdate'   => $tglupdate,
                'idkaryawan'  => $idkaryawan,
            );

            $simpan = $this->Insentif_model->insert($data);
            if ($simpan) {
                $pesan = $this->pesan(true, 'Simpan');
            } else {
                $pesan = $this->pesan(true, 'Gagal');
            }

        } else {

            $data = array(
                'target'      => $target,
                'besarbonus'  => $besarbonus,
                'keterangan'  => $keterangan,
                'statusaktif' => $statusaktif,
                'tginsert'    => $tginsert,
                'tglupdate'   => $tglupdate,
                'idkaryawan'  => $idkaryawan,
            );

            $simpan = $this->Insentif_model->update($data, $idinsentif);
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
        $result     = $this->Insentif_model->getById($primaryKey)->row();

        $data = array(
            'idinsentif'  => $result->idinsentif,
            'target'      => number_format($result->target),
            'besarbonus'  => number_format($result->besarbonus),
            'keterangan'  => $result->keterangan,
            'statusaktif' => $result->statusaktif,
            'tginsert'    => $result->tginsert,
            'tglupdate'   => $result->tglupdate,
            'idkaryawan'  => $result->idkaryawan,
        );

        echo (json_encode($data));
    }

    public function getData()
    {
        $data    = $this->Insentif_model->get_datatables();
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

            $arr[] = '<b>' . $row->idinsentif . '</b>' . $statusaktif;

            $arr[] = 'Rp. ' . number_format($row->target);
            $arr[] = 'Rp. ' . number_format($row->besarbonus);
            $arr[] = $row->keterangan;

            $arr[] = '<small>
                        ID. ' . $row->idkaryawan . ' <br>
                        <b>' . $row->namakaryawan . '</b> <br>
                        Jabatan : ' . $row->jabatan . '
                    </small>';

            // if ($row->foto == '') {
            //  $arr[] = '<img class="img-thumbnail" style="height: 90px; width: auto;" src="'. base_url('images/nofoto_l.png') .'">';
            // }else{
            //  $arr[] = '<a href="'. base_url('uploads/'.$row->foto) .'" target="_blank"><img class="img-thumbnail" style="height: 90px; width: auto;" src="'. base_url('uploads/'.$row->foto) .'"></a>';
            // }

            $arr[] = '
                        <a href="' . site_url($this->controller . '/edit/' . $this->encrypt->encode($row->idinsentif)) . '" class="btn btn-sm btn-warning btn-circle" title="Edit Data">
                            <i class="fa fa-edit"></i>
                        </a>



                        ';

            array_push($dataArr, $arr);
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Insentif_model->count_all(),
            "recordsFiltered" => $this->Insentif_model->count_filtered(),
            "data"            => $dataArr,
        );

        echo json_encode($output);
    }
    // END AJAX

}

/* End of file Insentif.php */
/* Location: ./application/controllers/Insentif.php */

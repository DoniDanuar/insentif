<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LapInsentif extends CI_Controller
{

    public $controller   = 'LapInsentif';
    public $loadViewList = 'lapinsentif/list';
    public $loadViewForm = 'lapinsentif/form';

    public $formNameHead = 'Laporan Insentif';
    public $formNameData = 'Data Laporan Insentif';
    public $formNameAdd  = 'Form Tambah Data';
    public $formNameEdit = 'Form Edit Data';

    public $menu = 'LapInsentif';

    public function __construct()
    {
        parent::__construct();
        $this->isLogin();
        $this->load->model('LapInsentif_model');
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
        $this->load->view('lapinsentif/form', $data);
    }

    public function cetak()
    {
        error_reporting(0);
        $this->load->library('Pdf');

        $tglawal    = $this->uri->segment(3);
        $tglakhir   = $this->uri->segment(4);
        $idkaryawan = $this->uri->segment(5);

        $dataFilter = array();

        array_push($dataFilter, 'Tgl. Awal &nbsp;: ' . formatHariTanggal($tglawal));
        array_push($dataFilter, 'Tgl. Akhir : ' . formatHariTanggal($tglakhir));

        if ($idkaryawan == '-') {
            $idkaryawan = '';
        } else {
            $idkaryawan  = $idkaryawan;
            $rowKaryawan = $this->db->query("SELECT * FROM karyawan WHERE idkaryawan='$idkaryawan' ")->row();

            array_push($dataFilter, '<br>ID. ' . $rowKaryawan->idkaryawan . '<br><b>' . strtoupper($rowKaryawan->namakaryawan) . '</b><br>Jabatan : ' . $rowKaryawan->jabatan);

        }

        $data['data']       = $this->LapInsentif_model->getLapInsentif($tglawal, $tglakhir, $idkaryawan);
        $data['dataFilter'] = $dataFilter;

        $this->load->view('lapinsentif/cetakpdf', $data);
    }

}

/* End of file LapInsentif.php */
/* Location: ./application/controllers/LapInsentif.php */

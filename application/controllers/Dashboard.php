
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public $controller   = 'Dashboard';
    public $loadViewList = 'dashboard';

    public $menu = 'Dashboard';

    public function __construct()
    {
        parent::__construct();
        $this->isLogin();
        $this->load->model('Dashboard_model');
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
        $data['menu']       = $this->menu;
        $data['controller'] = $this->controller;

        $date_now = date('Y-m-d');
        $date     = date_create($date_now);
        date_sub($date, date_interval_create_from_date_string("1 month"));
        $bulan_sebelumnya = 0 + date_format($date, "m");
        $tahun_sebelumnya = date_format($date, "Y");

        $level      = $this->session->userdata('level');
        $idkaryawan = $this->session->userdata('idpengguna');
        $filter     = "";
        if ($level == "Canvasser") {
            $filter .= "AND idkaryawan='$idkaryawan' ";
        }

        $data['totalInsentif'] = $this->db->query("
                                                    SELECT ( IFNULL(SUM(besarbonus), 0)  + IFNULL(SUM(totalbonusbarang), 0) ) AS totalinsentif FROM v_mapping_insentif
                                                    WHERE MONTH(tglmapping)= MONTH(NOW()) AND YEAR(tglmapping)=YEAR(NOW())
                                                    $filter")->row()->totalinsentif;

        $data['totalPenjualan_bulanini'] = $this->db->query("
                                                                SELECT SUM(totalharga) AS totalharga FROM v_penjualan
                                                                WHERE MONTH(tglpenjualan)= MONTH(NOW()) AND YEAR(tglpenjualan)=YEAR(NOW()) $filter
                                                            ")->row()->totalharga;

        $data['totalPenjualan_bulanlalu'] = $this->db->query("
                                                                SELECT SUM(totalharga) AS totalharga FROM v_penjualan
                                                                WHERE MONTH(tglpenjualan)='$bulan_sebelumnya' AND YEAR(tglpenjualan)='$tahun_sebelumnya' $filter
                                                            ")->row()->totalharga;

        $data['totalKonsumen'] = $this->db->query("
                                                    SELECT COUNT(*) AS totalkonsumen FROM konsumen
                                                    WHERE statusaktif='Aktif'
                                                ")->row()->totalkonsumen;

        $strSQL = "
                    SELECT * FROM
                    (
                        SELECT
                            v_insentif.keterangan AS insentif,
                            CONCAT('Rp. ', FORMAT(v_insentif.target, 0)) AS target,
                            v_insentif.besarbonus AS bonus,
                            '1' AS nourut
                        FROM v_insentif
                        WHERE v_insentif.statusaktif='Aktif'
                        UNION ALL
                        SELECT
                            v_barang_insentif.namabarang,
                            CONCAT(v_barang_insentif.targetqty_awal, ' - ',v_barang_insentif.targetqty_akhir,' / ',v_barang_insentif.satuan) AS target,
                            v_barang_insentif.bonus AS bonus,
                            '2' AS nourut
                        FROM v_barang_insentif
                        WHERE v_barang_insentif.statusaktif='Aktif'
                    ) z
                    ORDER BY nourut, insentif, bonus
        ";
        $data['dataInsentif'] = $this->db->query($strSQL);

        $this->load->view($this->loadViewList, $data);
    }

    public function getBar()
    {
        $filter     = "";
        $level      = $this->session->userdata('level');
        $idkaryawan = $this->session->userdata('idpengguna');
        if ($level == 'Canvasser') {
            $filter .= "WHERE idkaryawan='$idkaryawan'";
        }

        $dataTanggal = array();
        $dataTotal   = array();

        $strSQL = "
                    SELECT
                        tglpenjualan,
                        SUM(totalharga) AS totalharga
                    FROM v_penjualan
                    $filter
                    GROUP BY
                        tglpenjualan
        ";

        $query = $this->db->query($strSQL);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {

                array_push($dataTanggal, formatHariTanggal(date('d-m-Y', strtotime($row->tglpenjualan))));
                array_push($dataTotal, $row->totalharga);

            }
        }

        $output = array(
            'dataTanggal' => $dataTanggal,
            'dataTotal'   => $dataTotal,
        );

        echo (json_encode($output));

    }

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */

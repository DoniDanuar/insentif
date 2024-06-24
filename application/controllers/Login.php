<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
    }

    public function index()
    {
        $username = $this->session->userdata('username');
        if (!empty($username)) {
            redirect('Dashboard');
        } else {
            $this->load->view('login');
        }

    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('Login');
    }

    public function cekLogin()
    {
        $username = trim($this->input->post('username'));
        $password = trim($this->input->post('password'));

        if (empty($username) and empty($password)) {

            $pesan = '
                        <script type="text/javascript">
                          Swal.fire(
                          "Gagal !",
                          "Username atau Password Anda Salah . . . Silahkan Coba Lagi . . .  ",
                          "error"
                        );
                        </script>
                        ';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('Login');
            exit();

        } else {

            $query = $this->Login_model->cekLogin($username, md5($password));
            if ($query->num_rows() > 0) {

                $result = $query->row();

                $data = array(
                    'idpengguna'   => $result->idkaryawan,
                    'namapengguna' => $result->namakaryawan,
                    'jk'           => $result->jk,
                    'tempatlahir'  => $result->tempatlahir,
                    'tgllahir'     => $result->tgllahir,
                    'notelp'       => $result->notelp,
                    'email'        => $result->email,
                    'alamat'       => $result->alamat,
                    'foto'         => $result->foto,
                    'username'     => $result->username,
                    'password'     => $result->password,
                    'level'        => $result->jabatan,
                );

                $this->session->set_userdata($data);
                redirect('Dashboard');
            } else {

                $pesan = '
                        <script type="text/javascript">
                          Swal.fire(
                          "Gagal !",
                          "Username atau Password Anda Salah . . . Silahkan Coba Lagi . . .  ",
                          "error"
                        );
                        </script>
                        ';
                $this->session->set_flashdata('pesan', $pesan);
                redirect('Login');
                exit();

            }

        }
    }

    public function settingAkun()
    {
        $data['menu'] = 'Settingakun';
        $this->load->view('settingakun', $data);
    }

    public function settingAkunSimpan()
    {
        $idpengguna = $this->session->userdata('idpengguna');

        $username            = $this->input->post('username');
        $password_lama       = md5($this->input->post('password_lama'));
        $password_baru       = $this->input->post('password_baru');
        $password_konfirmasi = $this->input->post('password_konfirmasi');
        $password_default    = $this->input->post('password_default');

        if ($password_baru != $password_konfirmasi) {
            $dataJson = array(
                'simpan' => false,
                'pesan'  => 'Password Baru dan Password Konfirmasi Tidak Sesuai',
            );
            echo (json_encode($dataJson));
            exit();
        }

        if ($password_lama != $password_default) {
            $dataJson = array(
                'simpan' => false,
                'pesan'  => 'Password Lama Anda Tidak Sesuai, Silahkan coba lagi',
            );
            echo (json_encode($dataJson));
            exit();
        }

        $data = array(
            'username' => $username,
            'password' => md5($password_konfirmasi),
        );

        $update = $this->Login_model->update($idpengguna, $data);
        if ($update) {

            $this->session->set_userdata('username', $username);
            $this->session->set_userdata('password', md5($password_konfirmasi));
            $this->session->set_userdata('statusubahpassword', '1');

            $dataJson = array(
                'simpan' => true,
                'pesan'  => 'Data Akun Anda Berhasil Di Update',
            );
            echo (json_encode($dataJson));
            exit();
        } else {
            $dataJson = array(
                'simpan' => false,
                'pesan'  => 'Data Akun Anda Gagal Di Update',
            );
            echo (json_encode($dataJson));
            exit();
        }
    }

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */

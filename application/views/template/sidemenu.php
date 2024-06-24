<?php
$idpengguna   = $this->session->userdata('idpengguna');
$namapengguna = $this->session->userdata('namapengguna');
$level        = $this->session->userdata('level');
$foto         = $this->session->userdata('foto');
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="dashboard" class="brand-link">
    <img src="<?php echo (base_url()) ?>/assets/adminlte3/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">SI. INSENTIF</span>
  </a>

  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">

        <?php
if (empty($foto)) {?>
          <img src="<?php echo (base_url()) ?>/images/nofoto_l.png" class="img-circle elevation-2" alt="User Image">
        <?php
} else {?>
          <img src="<?php echo (base_url()) ?>/uploads/<?php echo ($foto) ?>" class="img-circle elevation-2" alt="User Image">
        <?php
}
?>

      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo ($namapengguna) ?></a>
      </div>
    </div>


    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-header">Daftar Menu</li>

        <li class="nav-item">
          <a href="<?php echo (site_url('Dashboard')) ?>" class="nav-link <?php echo ($menu == 'Dashboard') ? 'active' : '' ?> ">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>


        <?php
$menudropdown = array('Karyawan', 'Barang', 'Konsumen');
if (in_array($menu, $menudropdown)) {
    $dropdownselected = true;
} else {
    $dropdownselected = false;
}
?>

        <li class="nav-item has-treeview <?php echo ($dropdownselected) ? 'menu-open' : '' ?> ">
          <a href="#" class="nav-link <?php echo ($dropdownselected) ? 'active' : '' ?> ">
            <i class="nav-icon fas fa-folder"></i>
            <p>
              Master Data
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

<?php
if ($level == 'Supervisor') {?>

            <li class="nav-item">
              <a href="<?php echo (site_url("Karyawan")) ?>" class="nav-link <?php echo ($menu == "Karyawan") ? 'active' : '' ?> ">
                <i class="far fa-circle nav-icon"></i>
                <p>Karyawan</p>
              </a>
            </li>
<?php
}
?>



            <li class="nav-item">
              <a href="<?php echo (site_url("Barang")) ?>" class="nav-link <?php echo ($menu == "Barang") ? 'active' : '' ?> ">
                <i class="far fa-circle nav-icon"></i>
                <p>Barang</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?php echo (site_url("Konsumen")) ?>" class="nav-link <?php echo ($menu == "Konsumen") ? 'active' : '' ?> ">
                <i class="far fa-circle nav-icon"></i>
                <p>Konsumen</p>
              </a>
            </li>

          </ul>
        </li>

<?php
if ($level == 'Canvasser') {?>
        <li class="nav-header">Transaksi</li>

        <li class="nav-item">
          <a href="<?php echo (site_url("Penjualan")) ?>" class="nav-link <?php echo ($menu == "Penjualan") ? 'active' : '' ?> ">
            <i class="fab fa-sellcast nav-icon"></i>
            <p>Penjualan</p>
          </a>
        </li>
<?php
}
?>

        <li class="nav-header">Laporan</li>

        <li class="nav-item">
          <a href="<?php echo (site_url("LapPenjualan")) ?>" class="nav-link <?php echo ($menu == "LapPenjualan") ? 'active' : '' ?> ">
            <i class="fa fa-book nav-icon"></i>
            <p>Lap. Penjualan</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo (site_url("LapInsentif")) ?>" class="nav-link <?php echo ($menu == "LapInsentif") ? 'active' : '' ?> ">
            <i class="fa fa-book nav-icon"></i>
            <p>Lap. Insentif</p>
          </a>
        </li>


        <li class="nav-header">Setting</li>

<?php
if ($level == 'Supervisor') {?>
        <li class="nav-item">
          <a href="<?php echo (site_url("Insentif")) ?>" class="nav-link <?php echo ($menu == "Insentif") ? 'active' : '' ?> ">
            <i class="fa fa-money-bill nav-icon"></i>
            <p>Insentif</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo (site_url("Barang_insentif")) ?>" class="nav-link <?php echo ($menu == "Barang_insentif") ? 'active' : '' ?> ">
            <i class="fa fa-money-bill nav-icon"></i>
            <p>Insentif Per Barang</p>
          </a>
        </li>

<?php
}
?>

        <li class="nav-item">
          <a href="<?php echo (site_url('Login/settingAkun')) ?>" class="nav-link <?php echo ($menu == 'Settingakun') ? 'active' : '' ?> ">
            <i class="nav-icon fas fa-cog"></i>
            <p>
              Setting Akun
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo (site_url('Login/logout')) ?>" class="nav-link">
            <i class="nav-icon fas fa-power-off"></i>
            <p>
              Log Out
            </p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>


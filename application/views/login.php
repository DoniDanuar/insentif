<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SIstem Informasi Insentif</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="<?php echo (base_url()) ?>/assets/adminlte3/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo (base_url()) ?>/assets/adminlte3/dist/css/adminlte.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>
<body>

<div class="container-fluid">
    <div class="row no-gutter">
        <!-- The image half -->
        <div class="col-md-6 d-none d-md-flex bg-image"></div>


        <!-- The content half -->
        <div class="col-md-6 bg-light">
            <div class="login d-flex align-items-center py-5">

                <!-- Demo content-->
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 col-xl-7 mx-auto">
                            <h4 class="display-4" align="center" style="font-size: 36px;">Sistem Informasi Insentif</h4><br>
                            <p class="text-muted mb-4" align="center" style="font-size: 24px;">Silahkan Login</p>
                            <form action="<?php echo (site_url('Login/cekLogin')) ?>" method="post">
                                <div class="form-group mb-3">
                                    <input id="inputEmail" name="username" type="text" placeholder="Username" required="" autofocus="" class="form-control rounded-pill border-0 shadow-sm px-4">
                                </div>
                                <div class="form-group mb-3">
                                    <input id="inputPassword" name="password" type="password" placeholder="Password" required="" class="form-control rounded-pill border-0 shadow-sm px-4 text-primary">
                                </div>
                                <button type="submit" class="btn btn-primary btn-block text-uppercase mb-2 rounded-pill shadow-sm">Log in</button>
                            </form>
                        </div>
                    </div>
                </div><!-- End -->

            </div>
        </div><!-- End -->

    </div>
</div>


<style>
/*
*
* ==========================================
* CUSTOM UTIL CLASSES
* ==========================================
*
*/
.login,
.image {
  min-height: 100vh;
}

.bg-image {
  background-image: url("<?php echo (base_url('images/log.jpg')) ?>");
  background-size: cover;
  background-position: center center;
}
</style>

<!-- jQuery -->
<script src="<?php echo (base_url()) ?>/assets/adminlte3/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo (base_url()) ?>/assets/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo (base_url()) ?>/assets/adminlte3/dist/js/adminlte.min.js"></script>
<!-- Sweat Alert -->
<script src="<?php echo (base_url('assets/sweatalert/sweatalert.js')) ?>"></script>
<?php
$pesan = $this->session->flashdata('pesan');
if (isset($pesan)) {
    echo ($pesan);
}
?>


</body>
</html>




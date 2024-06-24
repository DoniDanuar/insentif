<?php 
  $this->load->view('template/header');
  $this->load->view('template/topmenu');
  $this->load->view('template/sidemenu');

  $idpengguna = $this->session->userdata('idpengguna');
  $namapengguna = $this->session->userdata('namapengguna');
  $notelp = $this->session->userdata('notelp');
  $email = $this->session->userdata('email');
  $foto = $this->session->userdata('foto');
  $username = $this->session->userdata('username');
  $password = $this->session->userdata('password');
 ?>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><i class="nav-icon fas fa-cog"></i> Setting Akun</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Setting Akun</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
        
          <div class="col-md-3">

            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  
                  <?php 
                  if (empty($foto)) { ?>

                    <img class="profile-user-img img-fluid img-circle"
                         src="<?php echo(base_url()) ?>/images/nofoto_l.png"
                         alt="User profile picture">
                  
                  <?php
                  }else{ ?>

                    <img class="profile-user-img img-fluid img-circle"
                         src="<?php echo(base_url()) ?>/uploads/<?php echo($foto) ?>"
                         alt="User profile picture">

                  <?php
                  }
                   ?>

                </div>

                <h3 class="profile-username text-center mt-3"><?php echo(strtoupper($namapengguna)) ?></h3>
                <p class="text-muted text-center">Administrator</p>
                
              </div>
            </div>

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><i class="fa fa-user"></i> Data Profil</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <strong><i class="far fa fa-tag mr-1"></i> Np. Telp & E-mail</strong>
                <p class="text-muted">
                  <?php echo($notelp); ?> 
                  <br>
                  <?php echo($email) ?>
                </p>
                <hr>

              </div>
            </div>
          </div>


          <div class="col-md-9">

            <div class="card">
              <div class="card-header p-2 bg-danger">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link" href="javascript:void(0)" data-toggle="tab" style="color: white !important;"><i class="fa fa-cogs"></i> Setting Akun</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    
                    <form class="form-horizontal" id="form" method="post" action="<?php echo(site_url('Login/update')); ?>">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-9">
                          <input type="name" class="form-control" id="username" value="<?php echo($username); ?>" name="username" placeholder="Username">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">Password Lama</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="password_lama" name="password_lama" placeholder="Password Lama">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">Password Baru</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="password_baru" name="password_baru" placeholder="Password Baru">
                        </div>
                      </div>
                      
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">Password Konfirmasi</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="password_konfirmasi" name="password_konfirmasi" placeholder="Password Konfirmasi">
                        </div>
                      </div>
                      <br>
                      <div class="form-group row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" id="setuju"> Setuju dengan perubahan ini !
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">
                          <button type="submit" id="simpan" class="btn btn-danger">Update</button>
                        </div>
                      </div>
                    </form>


                  </div>
                </div>
              </div>
            </div>
          </div>







        </div>
      </div>
    </div>    

    
  </div>
  
</div>

<?php 
  $this->load->view('template/footer');
?>
<script type="text/javascript">
$(document).ready(function(){
//----------------------------------------------------------------- > validasi
    $('#form').bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {

        username: {
          validators:{
            notEmpty: {
                message: '<span style="color:red;">Username Tidak Boleh Kosong</span>'
            },
          }
        },

        password_lama: {
          validators:{
            notEmpty: {
                message: '<span style="color:red;">Password Lama Tidak Boleh Kosong</span>'
            },
          }
        },

        password_baru: {
          validators:{
            identical: {
                field: 'password_konfirmasi',
                message: '<span style="color:red;">Password Baru dan Password Konfirmasi Belum Sama</span>'
            },
            notEmpty: {
                message: '<span style="color:red;">Password Baru Tidak Boleh Kosong</span>'
            },
          }
        },

        password_konfirmasi: {
          validators:{
            identical: {
                field: 'password_baru',
                message: '<span style="color:red;">Password Baru dan Password Konfirmasi Belum Sama</span>'
            },
            notEmpty: {
                message: '<span style="color:red;">Password Konfirmasi Tidak Boleh Kosong</span>'
            },
          }
        },


      }
    }).on('success.form.bv', function(e) {
        e.preventDefault();

        if ( !$('#setuju').prop('checked') ) {
          Swal.fire(
            "Gagal !",
            "Silahkan centang Setuju dengan perubahan ini, untuk update data anda . . .",
            "error"
          );
          $('#simpan').prop('disabled', false);
          return false;
        }
        
        var username              = $('#username').val();
        var password_lama         = $('#password_lama').val();
        var password_baru         = $('#password_baru').val();
        var password_konfirmasi   = $('#password_konfirmasi').val();

        var password_default      = "<?php echo($this->session->userdata('password')); ?>";

        
        $.ajax({
          url : "<?php echo(site_url('Login/settingAkunSimpan')); ?>",
          method : "POST",
          dataType : "JSON",
          data : {
            'username' : username,
            'password_lama' : password_lama,
            'password_baru' : password_baru,
            'password_konfirmasi' : password_konfirmasi,
            'password_default' : password_default
          },
          success : function(result){
            
            if (result.simpan) {
              Swal.fire(
                "Berhasil !",
                result.pesan,
                "success"
              );
            }else{
              Swal.fire(
                "Gagal !",
                result.pesan,
                "error"
              );
              $('#simpan').prop('disabled', false);
            }

          },
          error : function(){
            Swal.fire(
              "Gagal !",
              "Terjadi Kesalahan . . . Silahkan Hubungi Admin . . .",
              "error"
            );
          }
        });
        
    });

  //------------------------------------------------------------------------> END VALIDASI DAN SIMPAN
});
</script>

</body>
</html>


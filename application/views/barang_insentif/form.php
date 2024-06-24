<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');
?>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><i class="nav-icon fas fa-file"></i> <?php echo ($formNameHead); ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo (site_url('Dashboard')) ?>">Dashboard</a></li>
              <li class="breadcrumb-item active"> <a href="<?php echo (site_url('Kategori')) ?>"><?php echo ($formNameData); ?></a></li>
              <li class="breadcrumb-item active"><?php echo ($formName); ?></li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="card mb-4">

            <div class="card-body">

              <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <h5 class="card-title"><i class="fa fa-list-alt"></i> <?php echo ($formName) ?></h5>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <a href="<?php echo (site_url($controller)) ?>" class="btn btn-sm btn-default float-right mb-3" title="Tambah Data">
                            <i class="fa fa-chevron-circle-left"></i> Kembali
                        </a>
                    </div>
                </div>


              <form action="<?php echo (site_url($controller . '/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">

                      <div class="form-group row">
                          <label for="staticEmail" class="col-sm-3 col-form-label">ID. Barang Insentif</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="idbarang_insentif" id="idbarang_insentif" placeholder="Kode Otomatis Generate" readonly="">
                          </div>
                      </div>

                      <div class="form-group row required">
                          <label for="inputPassword" class="col-sm-3 col-form-label">Barang</label>
                          <div class="col-sm-9">
                            <select name="idbarang" id="idbarang" class="form-control select2">
                              <option value="">Pilih Barang...</option>
<?php
$queryBarang = $this->db->query("SELECT * FROM barang WHERE statusaktif='Aktif' ORDER BY namabarang ");
if ($queryBarang->num_rows() > 0) {
    foreach ($queryBarang->result() as $rowBarang) {
        echo ("<option value='" . $rowBarang->idbarang . "'>" . $rowBarang->namabarang . "</option>");
    }
}
?>

                            </select>
                          </div>
                      </div>

                      <div class="form-group row required">
                          <label for="inputPassword" class="col-sm-3 col-form-label">Target Awal (Qty)</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control money" name="targetqty_awal" id="targetqty_awal" placeholder="0">
                          </div>
                      </div>

                      <div class="form-group row required">
                          <label for="inputPassword" class="col-sm-3 col-form-label">Target Akhir (Qty)</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control money" name="targetqty_akhir" id="targetqty_akhir" placeholder="0">
                          </div>
                      </div>

                      <div class="form-group row required">
                          <label for="inputPassword" class="col-sm-3 col-form-label">Bonus (Rp.)</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control money" name="bonus" id="bonus" placeholder="Bonus (Rp.)">
                          </div>
                      </div>

                      <div class="form-group row">
                          <div class="col-sm-3"></div>
                          <div class="col-sm-9">
                            <div class="form-group float-right">
                                <label for="inputPassword" class="col-form-label">Status Aktif</label>
                                <div class="">
                                  <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="statusaktif" name="statusaktif" value="Aktif">
                                    <label class="form-check-label" for="statusaktif"> Aktif</label>
                                  </div>
                                </div>
                            </div>
                          </div>
                      </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> <?php echo ($button) ?></button>

                        <a href="<?php echo (site_url($controller)) ?>" class="btn btn-danger float-right mr-1 ml-1"><i class="fa fa-times"></i> Batal</a>
                    </div>
                </div>

              </form>
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

    var primaryKey = "<?php echo ($primaryKey); ?>";

    if (primaryKey != "") {

        $.ajax({
            url : "<?php echo (site_url($controller . '/getEditData')); ?>",
            type : "POST",
            dataType : "JSON",
            data : { primaryKey : primaryKey },
            success : function(result){

              $("#idbarang_insentif").val(result.idbarang_insentif);

              $("#idbarang").val(result.idbarang);
              $("#targetqty_awal").val(result.targetqty_awal);
              $("#targetqty_akhir").val(result.targetqty_akhir);
              $("#bonus").val(result.bonus);

              var statusaktif = result.statusaktif;
              if (statusaktif == 'Aktif') {
                $('#statusaktif').prop('checked', true);
              }else{
                $('#statusaktif').prop('checked', false);
              }
            }
        });

    }else{
      $('#statusaktif').prop('checked', true);
    }

    $("form").attr('autocomplete', 'off');
    $('.tanggal').mask('00-00-0000', {placeholder:"hh-bb-tttt"});
    $('.money').mask('000,000,000,000', {reverse: true});


    //----------------------------------------------------------------- > validasi
    $('#form').bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {

        idbarang: {
          validators:{
            notEmpty: {
                message: "<span style='color:red;'>idbarang tidak boleh kosong</span>"
            },
          }
        },
        targetqty_awal: {
          validators:{
            notEmpty: {
                message: "<span style='color:red;'>targetqty_awal tidak boleh kosong</span>"
            },
          }
        },
        targetqty_akhir: {
          validators:{
            notEmpty: {
                message: "<span style='color:red;'>targetqty_akhir tidak boleh kosong</span>"
            },
          }
        },
        bonus: {
          validators:{
            notEmpty: {
                message: "<span style='color:red;'>bonus tidak boleh kosong</span>"
            },
          }
        },
        tglinsert: {
          validators:{
            notEmpty: {
                message: "<span style='color:red;'>tglinsert tidak boleh kosong</span>"
            },
          }
        },
        tglupdate: {
          validators:{
            notEmpty: {
                message: "<span style='color:red;'>tglupdate tidak boleh kosong</span>"
            },
          }
        },
        idkaryawan: {
          validators:{
            notEmpty: {
                message: "<span style='color:red;'>idkaryawan tidak boleh kosong</span>"
            },
          }
        },
        statusaktif: {
          validators:{
            notEmpty: {
                message: "<span style='color:red;'>statusaktif tidak boleh kosong</span>"
            },
          }
        },
      }
    });
  //------------------------------------------------------------------------> END VALIDASI DAN SIMPAN
});

</script>

</body>
</html>



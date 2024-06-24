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
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active"><?php echo ($formNameData); ?></li>
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
                        <h5 class="card-title"><i class="fa fa-list-alt"></i> List <?php echo ($formNameData) ?></h5>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <a href="<?php echo (site_url($controller . '/tambah')) ?>" class="btn btn-sm btn-primary float-right mb-3" title="Tambah Data">
                            <i class="fa fa-plus-circle"></i> Tambah Data
                        </a>
                    </div>
                </div>


                <div class="table-responsive">
                    <table class="table table-striped" id="table">
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align: center;">No</th>
                                <th style="width: 10%; text-align: center;">ID. Penjualan</th>
                                <th style="text-align: center;">Tanggal</th>
                                <th style="text-align: center;">Konsumen</th>
                                <th style="text-align: center;">keterangan</th>
                                <th style="text-align: center;">Total Harga <br> (Rp.)</th>
                                <th style="text-align: center;">Karyawan</th>
                                <th style="width: 10%; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
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

    var table;
    table = $('#table').DataTable({
        "select": true,
        "processing": true,
        "serverSide": true,
        "order": [],
         "ajax": {
            "url": "<?php echo site_url($controller . '/getData') ?>",
            "type": "POST"
        },
        "columnDefs": [
            { "targets": [ 0 ], "orderable": false, "className": 'dt-body-center' },
            { "targets": [ 1 ], "className": 'dt-body-center' },
            { "targets": [ 5 ], "className": 'dt-body-right' },
            { "targets": [ -1 ], "orderable": false, "className": 'dt-body-center' },
        ],

    });

    $('#table').on('click','#hapus', function(e){
      var link = $(this).attr("href");
      e.preventDefault();

      Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "Ingin Menghapus Data ini ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus Data!'
      }).then((result) => {
        if (result.value) {
          document.location.href = link;
        }
      });
    });

});
</script>



</body>
</html>



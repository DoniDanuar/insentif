<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');

$level = $this->session->userdata('level');
if ($level == "Canvasser") {
    $namaDashboard = " - " . strtoupper($this->session->userdata('namapengguna'));
} else {
    $namaDashboard = strtoupper(" - Keseluruhan Canvasser");
}
?>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><i class="nav-icon fas fa-tachometer-alt"></i> Dashboard <?php echo ($namaDashboard); ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dashboard <?php echo ($namaDashboard); ?></a></li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">

        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fa fa-money-bill"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Insentif Bulan ini</span>
                <span class="info-box-number">
                  Rp. <?php echo (number_format($totalInsentif)); ?>
                </span>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fab fa-sellcast"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Penjualan Bulan Lalu</span>
                <span class="info-box-number">
                  Rp. <?php echo (number_format($totalPenjualan_bulanlalu)); ?>
                </span>
              </div>
            </div>
          </div>

          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fab fa-sellcast"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Penjualan Bulan Ini</span>
                <span class="info-box-number">
                  Rp. <?php echo (number_format($totalPenjualan_bulanini)); ?>
                </span>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Konsumen</span>
                <span class="info-box-number">
                  <?php echo (number_format($totalKonsumen)); ?> Orang
                </span>
              </div>
            </div>
          </div>

          <div class="col-md-5">
            <div class="card">
              <div class="card-header">
                <h5>Daftar Insentif</h5>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" style="font-size: 14px;">
                    <thead>
                      <tr class="bg-secondary">
                        <td style="text-align: center;">Insentif</td>
                        <td style="text-align: center;">Target</td>
                        <td style="text-align: center;">Bonus</td>
                      </tr>
                    </thead>
                    <tbody>
<?php
if ($dataInsentif->num_rows() > 0) {
    foreach ($dataInsentif->result() as $rowInsentif) {?>
                      <tr>
                        <td style="text-align: left;"><?php echo ($rowInsentif->insentif) ?></td>
                        <td style="text-align: left;"><?php echo ($rowInsentif->target); ?></td>
                        <td style="text-align: right;"><?php echo ('Rp. ' . number_format($rowInsentif->bonus)) ?></td>
                      </tr>
<?php
}
}
?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>


          <div class="col-md-7">
            <div class="card">
              <div class="card-header">
                <h5>Grafik Penjualan</h5>
              </div>
              <div class="card-body">

                <canvas id="myChart"></canvas>


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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript">
$(document).ready(function(){

  $.ajax({
    url : "<?php echo site_url('Dashboard/getBar') ?>",
    method : "POST",
    dataType : "JSON",
    success : function(result){

      const labels = result.dataTanggal;
      const data = {
        labels: labels,
        datasets: [
            {
              label: 'Total Penjualan',
              backgroundColor: 'rgb(255, 99, 132)',
              borderColor: 'rgb(255, 99, 132)',
              data: result.dataTotal,
            }
        ]
      };



      const config = {
        type: 'bar',
        data: data,
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'top',
            },
            title: {
              display: true,
              text: 'Grafik Penjualan Harian'
            }
          },
          scales: {
              yAxes: [
                  {
                      ticks: {
                          callback: function(label, index, labels) {
                              return numberWithCommas(label);
                          }
                      },
                      scaleLabel: {
                          display: true,
                          labelString: '1k = 1000'
                      }
                  }
              ]
          }
        },
      };
      var myChart = new Chart( document.getElementById('myChart'), config );


    },
    error : function(){
      alert("Error getBar");
    }
  });




});


</script>

</body>
</html>




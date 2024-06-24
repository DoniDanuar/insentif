
<!-- jQuery -->
<script src="<?php echo(base_url()) ?>/assets/adminlte3/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo(base_url()) ?>/assets/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo(base_url()) ?>/assets/adminlte3/dist/js/adminlte.min.js"></script>

<!-- datatables -->
<script src="<?php echo(base_url('assets/datatables/js/jquery.dataTables.min.js')) ?>"></script>
<!-- bootbox -->
<script type="text/javascript" src="<?php echo base_url('assets/bootbox/bootbox.js'); ?>"></script>
<!-- jquery-mask -->
<script type="text/javascript" src="<?php echo base_url('assets/jquery_mask/jquery.mask.js') ?>"></script>
<!-- Bootstrap validator -->
<script src="<?php echo(base_url('assets/bootstrap-validator/js/bootstrapValidator.js')) ?>"></script>
<!-- jquery-ui -->
<script src="<?php echo(base_url('assets/jquery-ui/jquery-ui-2.js')) ?>"></script>
<!-- Sweat Alert -->
<script src="<?php echo(base_url('assets/sweatalert/sweatalert.js')) ?>"></script>
<!-- Font Awesome -->
<script src="<?php echo(base_url('assets/fa/fa.min.js')); ?>"></script>
<!-- CK Editor -->
<script type="text/javascript" src="<?php echo(base_url()) ?>/assets/ckeditor/ckeditor.js"></script>
<!-- Select 2 -->
<link href="<?php echo(base_url('assets/select2/dist/css/select2.min.css')) ?>" rel="stylesheet" />
<script src="<?php echo(base_url('assets/select2/dist/js/select2.min.js')) ?>"></script>
<script>
  $('.select2').addClass('form-control');
  $('.select2').select2();

  $('.select2_1').addClass('form-control');
  $('.select2_1').select2();

  $('.select2_2').addClass('form-control');
  $('.select2_2').select2();

  $('.select2_3').addClass('form-control');
  $('.select2_3').select2();
</script>
<style>
  .select2-container .select2-selection--single {
    height: 40px !important;
  }
</style>

<script>
const numberWithCommas = (x) => {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }  

const untitik = (i) => {
    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
}

function AllowOnlyNumbers(e) {

  e = (e) ? e : window.event;
  var clipboardData = e.clipboardData ? e.clipboardData : window.clipboardData;
  var key = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;
  var str = (e.type && e.type == "paste") ? clipboardData.getData('Text') : String.fromCharCode(key);

  return (/^\d+$/.test(str));
}
</script>

<?php
  $pesan = $this->session->flashdata('pesan');
    if (isset($pesan)) {
        echo($pesan);
  }
?>

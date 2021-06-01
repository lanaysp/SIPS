<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>SIPS | Guru</title>
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?=base_url('assets/main/')?>plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="<?=base_url('assets/https/')?>ionicons.min.css">
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="<?=base_url('assets/main/')?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="<?=base_url('assets/main/')?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- JQVMap -->
<link rel="stylesheet" href="<?=base_url('assets/main/')?>plugins/jqvmap/jqvmap.min.css">
<!-- Ekko Lightbox -->
<link rel="stylesheet" href="<?=base_url('assets/main/')?>plugins/ekko-lightbox/ekko-lightbox.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?=base_url('assets/main/')?>dist/css/adminlte.min.custom.css">
<link rel="stylesheet" href="<?=base_url('assets/main/')?>dist/css/loading.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="<?=base_url('assets/main/')?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="<?=base_url('assets/main/')?>plugins/daterangepicker/daterangepicker.css">
<!-- summernote -->
<link rel="stylesheet" href="<?=base_url('assets/main/')?>plugins/summernote/summernote-bs4.css">
<!-- Google Font: Source Sans Pro -->
<link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<!-- Toastr -->
<link rel="stylesheet" href="<?=base_url('assets/main/')?>plugins/toastr/toastr.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets/main/')?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets/main/')?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- DataTables Button -->
<link rel="stylesheet" href="<?=base_url('assets/https/')?>buttons.dataTables.min.css">
<!-- SWEET ALERT -->
<link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="<?=base_url('assets/https/sweetalert.min.css')?>" />
<!-- Select2 -->
<link rel="stylesheet" href="<?=base_url('assets/main/')?>plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url('assets/main/')?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<link rel="icon" href="<?=base_url('assets/upload/profile/favicon/')?><?=$logo_aplikasi?>" type="image/gif">

<?php $this->load->view('guru/_partials/_js'); ?>

<script type="text/javascript">
base_url = "<?=base_url('guru/')?>";
auth_url = "<?=base_url('auth/')?>";

$(window).on('load',function() {
	$(".loading").fadeOut("slow");
});

function showToast(message, timeout, type) {
  type = (typeof type === 'undefined') ? 'info' : type;
  toastr.options.timeOut = timeout;
  toastr[type](message);
}

$(function () {
  $(document).on('click', '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox({
      alwaysShowClose: true
    });
  });
})

function fDatatables(tableid,target,order){
  $('#'+tableid).DataTable({
    dom: 'lBfrtip',
    buttons: [
      'copy', 'excel', 'print',
      <?php if($this->uri->segment(2)=='siswa'){ ?>
        {
            extend: 'pdfHtml5',
            orientation: 'landscape',
            pageSize: 'LEGAL'
        }
      <?php } else { echo "'pdf'";} ?>
    ],
    processing: true,
    columnDefs: [],
    serverSide: true,
    bDestroy: true,
    bPaginate: true,
    bLengthChange: true,
    bFilter: true,
    bSort: true,
    bInfo: true,
    bAutoWidth: false,
    aaSorting: [[<?php 
        if ($this->uri->segment(2)=='kompetensi_dasar'){ echo "1"; } 
        else { echo "0"; }?>,order]],
    lengthMenu: [[10, 25, 50, 100, 500, 1000, -1], [10, 25, 50, 100, 500, 1000, "Semua"]],
      ajax: {
        url: target,
        type: "POST",
        error: function(){  // error handling code
            $('#'+tableid).css("display","none");
        }
      }
  });
}

function fDuplicate(tableid,target){
  setTimeout(function(){ 
    var contents = {}, duplicates = false;
    $('#'+tableid+' td:'+target).each(function() {
        var tdContent = $(this).text();
        if (contents[tdContent]) {
            duplicates = true;
            return false;
        }
        contents[tdContent] = true;
    });    
    if (duplicates) {
      location.reload();
    }
  }, 1500);
}
</script>

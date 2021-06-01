<!DOCTYPE html>
<html>
<head>
  <?php $this->load->view('guru/_partials/header'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?php $this->load->view('guru/_partials/navbar'); ?>
  <?php $this->load->view('guru/_partials/sidebar'); ?>
  <?=$contents?>
  <?php $this->load->view('guru/_partials/footer'); ?>
</div>
</body>
</html>

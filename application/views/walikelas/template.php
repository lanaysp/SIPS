<!DOCTYPE html>
<html>
<head>
  <?php $this->load->view('walikelas/_partials/header'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?php $this->load->view('walikelas/_partials/navbar'); ?>
  <?php $this->load->view('walikelas/_partials/sidebar'); ?>
  <?=$contents?>
  <?php $this->load->view('walikelas/_partials/footer'); ?>
</div>
</body>
</html>

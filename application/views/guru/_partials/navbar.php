<div class="loading"></div>
<!-- Navbar -->
  <div id="nav-refresh"></div>
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" id="nav-refresh-content">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button" id="sidemenu-button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link" style="font-size:25px; margin-bottom:15px;"><?=$nama?>, Tahun Pelajaran <?=$p_tahun_pelajaran?></a>
        <?php 
          if (empty($tahunpelajaran_dipilih['tp_tahun'])){
            redirect (base_url('auth/logout/'));
          }
          $tahun_explode = explode('-',$tahunpelajaran_dipilih['tp_tahun']);
          $p_tahun = $tahun_explode[0];
          $p_semester = $tahun_explode[1];
        ?>
        <div class="bg-primary col-7"><center><a>Tahun pelajaran yang anda pilih : <?=$p_tahun?> (Semester <?=$p_semester?>)</a></center></div>
      </li>
    </ul>
  </nav>
<!-- /.navbar -->

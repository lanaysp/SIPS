<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background:#293D55">
    <!-- Brand Logo -->
    <a href="<?=base_url('administrator/dashboard')?>" class="brand-link">
      <img src="<?=base_url('assets/main/')?>dist/img/users.png" alt="AdminLTE Logo" class="img-circle elevation-3" style="width:50px; height:50px;">
      <span class="brand-text font-weight-light"><small>Selamat Datang, Admin</small></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?=base_url('assets/upload/administrator/thumbnails/')?><?=$u_photo?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $this->session->userdata('nama')?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?=base_url('administrator/dashboard')?>" class="nav-link <?= $this->uri->segment(2)=='dashboard' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url('administrator/data')?>" class="nav-link <?= $this->uri->segment(2)=='data' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Data Administrator
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url('administrator/users')?>" class="nav-link <?= $this->uri->segment(2)=='users' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Data Guru/Wali Kelas
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url('administrator/siswa')?>" class="nav-link <?= $this->uri->segment(2)=='siswa' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Data Siswa
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview <?= $this->uri->segment(2)=='profile' || $this->uri->segment(2)=='tahun_pelajaran' || $this->uri->segment(2)=='kelas' || $this->uri->segment(2)=='mata_pelajaran' || $this->uri->segment(2)=='kkm' || $this->uri->segment(2)=='interval_predikat' || $this->uri->segment(2)=='butir_sikap' || $this->uri->segment(2)=='ekstra' || $this->uri->segment(2)=='kesehatan' ? 'menu-open' : ''; ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Data Referensi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=base_url('administrator/profile')?>" class="nav-link <?= $this->uri->segment(2)=='profile' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Profil Sekolah</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('administrator/tahun_pelajaran')?>" class="nav-link <?= $this->uri->segment(2)=='tahun_pelajaran' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Tahun Pelajaran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('administrator/kelas')?>" class="nav-link <?= $this->uri->segment(2)=='kelas' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Kelas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('administrator/mata_pelajaran')?>" class="nav-link <?= $this->uri->segment(2)=='mata_pelajaran' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Mata Pelajaran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('administrator/kkm')?>" class="nav-link <?= $this->uri->segment(2)=='kkm' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data KKM Mapel</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('administrator/interval_predikat')?>" class="nav-link <?= $this->uri->segment(2)=='interval_predikat' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Interval Predikat</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('administrator/butir_sikap')?>" class="nav-link <?= $this->uri->segment(2)=='butir_sikap' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Butir - Butir Sikap</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('administrator/ekstra')?>" class="nav-link <?= $this->uri->segment(2)=='ekstra' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Ekstrakurikuler</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('administrator/kesehatan')?>" class="nav-link <?= $this->uri->segment(2)=='kesehatan' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Kesehatan</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview <?= $this->uri->segment(2)=='nilai' || $this->uri->segment(2)=='nilai_rapor' || $this->uri->segment(2)=='nilai_sikap' || $this->uri->segment(2)=='ekstra_hasil' || $this->uri->segment(2)=='kehadiran_hasil' || $this->uri->segment(2)=='cetak_rapor' || $this->uri->segment(2)=='nilai_leger' ? 'menu-open' : ''; ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Hasil Pengolahan Nilai
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=base_url('administrator/nilai')?>" class="nav-link <?= $this->uri->segment(2)=='nilai' ? 'active' : ''; ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rincian Nilai</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('administrator/nilai_rapor')?>" class="nav-link <?= $this->uri->segment(2)=='nilai_rapor' ? 'active' : ''; ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Radar Nilai Rapor</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('administrator/nilai_sikap')?>" class="nav-link <?= $this->uri->segment(2)=='nilai_sikap' ? 'active' : ''; ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nilai Sikap</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('administrator/ekstra_hasil')?>" class="nav-link <?= $this->uri->segment(2)=='ekstra_hasil' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nilai Ekstrakurikuler</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('administrator/kehadiran_hasil')?>" class="nav-link <?= $this->uri->segment(2)=='kehadiran_hasil' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kehadiran Siswa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('administrator/cetak_rapor')?>" class="nav-link <?= $this->uri->segment(2)=='cetak_rapor' ? 'active' : ''; ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cetak Rapor</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('administrator/nilai_leger')?>" class="nav-link <?= $this->uri->segment(2)=='nilai_leger' ? 'active' : ''; ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cetak Leger Nilai</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?=base_url('administrator/log_activity')?>" class="nav-link <?= $this->uri->segment(2)=='log_activity' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-eye"></i>
              <p>
                Aktifitas User
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url('administrator/web_config')?>" class="nav-link <?= $this->uri->segment(2)=='web_config' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Pengaturan Website
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url('Auth/logout')?>" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background:#293D55">
    <!-- Brand Logo -->
    <a href="<?=base_url('walikelas/dashboard')?>" class="brand-link">
      <img src="<?=base_url('assets/main/')?>dist/img/users.png" alt="AdminLTE Logo" class="img-circle elevation-3" style="width:50px; height:50px;">
      <span class="brand-text font-weight-light"><small>Selamat Datang, Guru Kelas</small></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?=base_url('assets/upload/guru/thumbnails/')?><?=$u_photo?>" class="img-circle elevation-2" alt="User Image">
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
            <a href="<?=base_url('walikelas/dashboard')?>" class="nav-link <?= $this->uri->segment(2)=='dashboard' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" onclick="return edit_password();" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Ubah Password
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url('walikelas/peserta_didik')?>" class="nav-link <?= $this->uri->segment(2)=='peserta_didik' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Data Peserta Didik
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url('walikelas/periodik_siswa')?>" class="nav-link <?= $this->uri->segment(2)=='periodik_siswa' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Data Periodik Siswa
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview <?= $this->uri->segment(2)=='kehadiran_siswa' || $this->uri->segment(2)=='ekstrakurikuler' || $this->uri->segment(2)=='prestasi' || $this->uri->segment(2)=='kesehatan' || $this->uri->segment(2)=='catatan' ? 'menu-open' : ''; ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Input Data dan Nilai
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=base_url('walikelas/kehadiran_siswa')?>" class="nav-link <?= $this->uri->segment(2)=='kehadiran_siswa' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Input Kehadiran Siswa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('walikelas/ekstrakurikuler')?>" class="nav-link <?= $this->uri->segment(2)=='ekstrakurikuler' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Input Nilai Ekstrakurikuler</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('walikelas/prestasi')?>" class="nav-link <?= $this->uri->segment(2)=='prestasi' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Input Prestasi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('walikelas/kesehatan')?>" class="nav-link <?= $this->uri->segment(2)=='kesehatan' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Input Kesehatan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('walikelas/catatan')?>" class="nav-link <?= $this->uri->segment(2)=='catatan' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Catatan Wali Kelas</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?=base_url('walikelas/deskripsi_sikap')?>" class="nav-link <?= $this->uri->segment(2)=='deskripsi_sikap' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Proses Deskripsi Sikap
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview <?= $this->uri->segment(2)=='hasil_pengetahuan' || $this->uri->segment(2)=='hasil_keterampilan' || $this->uri->segment(2)=='nilai_akhir' ? 'menu-open' : ''; ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Hasil Pengolahan Nilai
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=base_url('walikelas/hasil_pengetahuan')?>" class="nav-link <?= $this->uri->segment(2)=='hasil_pengetahuan' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nilai Pengetahuan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('walikelas/hasil_keterampilan')?>" class="nav-link <?= $this->uri->segment(2)=='hasil_keterampilan' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nilai Keterampilan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('walikelas/nilai_akhir')?>" class="nav-link <?= $this->uri->segment(2)=='nilai_akhir' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Radar Nilai Rapor</p>
                </a>
              </li>
            </ul>
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
  <div class="modal fade" id="modal_data_password" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#293D55; color:white;">
          <h6 class="modal-title">[Ubah Password]</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12 col-sm-12">
              <div class="card card-primary card-tabs">
                <div class="card-header p-0 pt-1">
                  <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Password <span class="error-tab1"></span></a>
                    </li>
                  </ul>
                </div>
                <form class="form-horizontal" method="post" name="f_password" id="f_password">
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <div class="card-body">
                        <div class="form-group">
                          <label for="old">Password Lama</label>
                          <div class="error-message-p1"></div>
                          <input type="hidden" name="identity" class="form-control" id="identity" value="<?=$u_email?>" required>
                          <input type="hidden" name="u_status" class="form-control" id="u_status" value="users_login" required>
                          <input type="password" name="old" class="form-control" id="old" required>
                        </div>
                        <div class="form-group">
                          <label for="new">Password Baru</label>
                          <div class="error-message-p2"></div>
                          <input type="password" name="new" class="form-control" id="new" required>
                        </div>
                        <div class="form-group">
                          <label for="new_confirm">Konfirmasi Password Baru</label>
                          <div class="error-message-p3"></div>
                          <input type="password" name="new_confirm" class="form-control" id="new_confirm" required>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card -->
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary" id="btn-save-password">Simpan</button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

<script type="text/javascript">
  function formValidationPassword()
  {
    var new_password = $('#new').val();
    var new_confirm = $('#new_confirm').val();

    if (new_confirm!=new_password){
      showToast('Konfirmasi password tidak sama !',1000,'error');
      $(".error-message-p3").append('<div class="font-italic text-danger" id="error-message-p3"><small>* konfirmasi password tidak sama</small></div>');
    } else {
      return true;
    }
  }

  function removeErrorMessagesPassword()
  {
    $("#error-message-p3").remove();
  }

  function edit_password()
  {
    $("#modal_data_password").modal('show');
  }

  $(document).ready(function(){
    $("#f_password").on("submit", function(e) {
      e.preventDefault();
      removeErrorMessagesPassword();
      if(formValidationPassword()){
        $('#btn-save-password').prop('disabled',true);
        var data = $(this).serialize();
        $.ajax({
            type: "POST",
            data: data,
            url: auth_url+"change_password",
            success: function(r) {
                if (r.status == "gagal") {
                    showToast('Password gagal diubah, silahkan periksa lebih detail password lama dan kesamaan password baru yang akan diganti! Password baru tidak boleh kurang dari 8 karakter',4000,'error');
                    $('#btn-save-password').prop('disabled',false);
                } else if (r.status == "ok") {
                    $("#modal_data_password").modal('hide');
                    showToast('Password berhasil diubah !',1000,'success');
                    setTimeout(function(){
                      window.location.href = auth_url;
                    }, 2000);

                }
            }
        });
        return false;
      }
    });
  })
</script>

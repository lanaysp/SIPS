<!-- Content Wrapper. Contains page content -->
<div id="refresh"></div>
<div class="content-wrapper" id="refresh_content">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
         <section class="col-lg-12 connectedSortable">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h5><?=$nama_aplikasi?></h5>
                <p><?=$ket_aplikasi?></p>
                <button id="btn-show-data" type="button" class="btn-sm btn-info animate__animated animate__heartBeat animate__delay-1s" data-toggle="modal" data-target="#modal_diagram">Lihat Detail Data <i class="ion ion-stats-bars"></i></button>
                <button id="btn-show-covid" type="button" class="btn-sm btn-danger animate__animated animate__backInRight animate__delay-1s" data-toggle="modal" data-target="#modal_corona">Waspada Corona <i class="ion ion-stats-bars"></i></button>
                <div class="icon">
                  <i class="ion ion-ribbon-b"></i>
                </div>
              </div>
            </div>
         </section>
        </div>
        <!-- /.row -->
          <?php 
            if (empty($tahunpelajaran_dipilih['tp_tahun'])){
              redirect (base_url('auth/logout/'));
            }
            $tahun_explode = explode('-',$tahunpelajaran_dipilih['tp_tahun']);
            $p_tahun = $tahun_explode[0];
            $p_semester = $tahun_explode[1];
          ?>
          <!-- MODAL -->
          <div class="modal fade" id="modal_diagram" data-backdrop="static">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-header" style="background-color:#293D55; color:white;">
                  <h6 class="modal-title">Informasi Detail Sekolah Tahun Pelajaran <?=$p_tahun?> (Semester <?=$p_semester?>)</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  
                </div>
              </div>
            </div>
          </div>
          <!-- END MODAL -->

          <!-- MODAL -->
          <div class="modal fade" id="modal_corona" data-backdrop="static">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-header" style="background-color:#293D55; color:white;">
                  <h6 class="modal-title">INFO PERKEMBANGAN COVID 19 REALTIME</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  
                </div>
              </div>
            </div>
          </div>
          <!-- END MODAL -->

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-md-4">
            <!-- Profile Image -->
            <div class="card card-primary card-outline" style="border-top:3px solid #2D5E89;">
              <div class="card-body box-profile">
                <div class="text-center">
                  <a href="<?=base_url('assets/upload/profile/')?><?=$logo_aplikasi?>" data-toggle="lightbox" data-title="<?=$logo_aplikasi?>">
                  <img class="profile-user-img img-fluid img-circle"
                       src="<?=base_url('assets/upload/profile/thumbnails/')?><?=$logo_aplikasi?>"
                       alt="User profile picture">
                  </a>
                </div>
                <h3 class="profile-username text-center"><?=$nama?></h3>
                <p class="text-muted text-center">Tahun Pelajaran <?=$p_tahun_pelajaran?></p>
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>NPSN</b> <a class="float-right"><?=$npsn?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Status</b> <a class="float-right"><?=$status?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Bentuk Pendidikan</b> <a class="float-right"><?=$bentuk_pendidikan?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Status Kepemilikan</b> <a class="float-right"><?=$status_kepemilikan?></a>
                  </li>
                  <li class="list-group-item">
                    <b>SK Pendirian Sekolah</b> <a class="float-right"><?=$sk_pendirian?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Tanggal SK  Pendirian</b> <a class="float-right"><?=date('d-M-Y',strtotime($tanggal_sk_pendirian))?></a>
                  </li>
                  <li class="list-group-item">
                    <b>SK Izin Operasional</b> <a class="float-right"><?=$sk_izin?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Tanggal SK Izin Operasional</b> <a class="float-right"><?=date('d-M-Y',strtotime($tanggal_sk_izin))?></a>
                  </li>
                </ul>
                <a href="#" class="btn btn-primary btn-block" onclick="return showModal();"><b>Ubah</b></a>
              </div>
              <!-- /.card-body -->
            </div>
          </div>

          <div class="col-lg-8">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card card-primary">
              <div class="card-header" style="background-color:#2D5E89;">
                <i class="fas fa-edit"></i> <span>Data Profil Sekolah</span>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Nama</strong>
                <p class="text-muted">
                  <?=$nama?>
                </p>
                <hr>
                <strong><i class="fas fa-book mr-1"></i> Kepala Sekolah</strong>
                <p class="text-muted">
                  <?=$kepala_sekolah?><br/>
                  NIP. <?=$kepala_nbmnip?>
                </p>
                <hr>
                <strong><i class="far fa-file-alt mr-1"></i> Tahun Pelajaran</strong>
                <p class="text-muted"><?=$p_tahun_pelajaran?></p>
                <hr>
                <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                <p class="text-muted"><?=$alamat?>, <?=$provinsi?>, <?=$kota?>, <?=$kecamatan?>, <?=$kodepos?></p>
                <hr>
                <strong><i class="fas fa-phone mr-1"></i> No Telepon</strong>
                <p class="text-muted">
                  <?=$telepon?>
                </p>
                <hr>
                <strong><i class="far fa-envelope mr-1"></i> Email</strong>
                <p class="text-muted"><?=$email?></p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <div class="modal fade" id="modal_data" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#293D55; color:white;">
          <h6 class="modal-title">[Ubah Profil Sekolah]</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <?=form_open_multipart('',array('class'=>'form-horizontal','method'=>'post','id'=>'f_profile','name'=>'f_profile'))?>
        <div class="modal-body">
          <div class="row">
            <div class="col-12 col-sm-12">
              <div class="card card-primary card-tabs">
                <div class="card-header p-0 pt-1">
                  <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Umum <span class="error-tab1"></span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Detail <span class="error-tab2"></span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-one-aplikasi-tab" data-toggle="pill" href="#custom-tabs-one-aplikasi" role="tab" aria-controls="custom-tabs-one-aplikasi" aria-selected="false">Aplikasi <span class="error-tab3"></span></a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <div class="card-body">
                        <div class="form-group">
                            <label for="edit_nama" class="col-sm-3 control-label">Nama</label>
                            <div class="error-message1"></div>
                            <div class="col-sm-12">
                              <?=form_input($edit_idprofile)?>
                              <?=form_input($current_kota);?>
                              <?=form_input($current_kecamatan);?>
                              <?=form_input($edit_nama)?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_nama" class="col-sm-3 control-label">Kepala Sekolah</label>
                            <div class="error-message21"></div>
                            <div class="col-sm-12">
                              <?=form_input($edit_kepala_sekolah)?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_nama" class="col-sm-6 control-label">Kepala Sekolah NBM/NIP</label>
                            <div class="error-message22"></div>
                            <div class="col-sm-12">
                              <?=form_input($edit_kepala_nbmnip)?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_tahun_pelajaran" class="col-sm-3 control-label">Tahun Pelajaran</label>
                            <div class="error-message2"></div>
                            <div class="col-sm-12">
                              <?php echo form_dropdown('',$tahun,$tahun_select,$tahun_attribut); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_alamat" class="col-sm-3 control-label">Alamat</label>
                            <div class="error-message3"></div>
                            <div class="col-sm-12">
                              <?=form_input($edit_alamat)?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_provinsi" class="col-sm-3 control-label">Provinsi</label>
                            <div class="error-message4"></div>
                            <div class="col-sm-12">
                              <?=form_dropdown('',$edit_provinsi,$edit_provinsi_select,$edit_provinsi_attribute)?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_kota" class="col-sm-3 control-label">Kota</label>
                            <div class="error-message5"></div>
                            <div class="col-sm-12">
                              <?=form_dropdown('',$edit_kota,$edit_kota_select,$edit_kota_attribute)?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_kecamatan" class="col-sm-3 control-label">Kecamatan</label>
                            <div class="error-message6"></div>
                            <div class="col-sm-12">
                              <?=form_dropdown('',$edit_kecamatan,$edit_kecamatan_select,$edit_kecamatan_attribute)?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_kodepos" class="col-sm-3 control-label">Kode Pos</label>
                            <div class="error-message7"></div>
                            <div class="col-sm-12">
                              <?=form_input($edit_kodepos)?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_telepon" class="col-sm-3 control-label">Telepon</label>
                            <div class="error-message8"></div>
                            <div class="col-sm-12">
                              <?=form_input($edit_telepon)?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_email" class="col-sm-3 control-label">Email</label>
                            <div class="error-message9"></div>
                            <div class="col-sm-12">
                              <?=form_input($edit_email)?>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                      <div class="form-group">
                          <label for="edit_npsn" class="col-sm-3 control-label">NPSN</label>
                          <div class="error-message10"></div>
                          <div class="col-sm-12">
                            <?=form_input($edit_npsn)?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="edit_status" class="col-sm-3 control-label">Status</label>
                          <div class="error-message11"></div>
                          <div class="col-sm-12">
                            <?=form_input($edit_status)?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="edit_bentuk_pendidikan" class="col-sm-3 control-label">Bentuk Pendidikan</label>
                          <div class="error-message12"></div>
                          <div class="col-sm-12">
                            <?=form_input($edit_bentuk_pendidikan)?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="edit_status_kepemilikan" class="col-sm-3 control-label">Status Kepemilikan</label>
                          <div class="error-message13"></div>
                          <div class="col-sm-12">
                            <?=form_input($edit_status_kepemilikan)?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="edit_sk_pendirian" class="col-sm-3 control-label">SK Pendirian</label>
                          <div class="error-message14"></div>
                          <div class="col-sm-12">
                            <?=form_input($edit_sk_pendirian)?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="edit_tanggal_pendirian" class="col-sm-3 control-label">Tanggal SK Pendirian</label>
                          <div class="error-message15"></div>
                          <div class="col-sm-12">
                            <?=form_input($edit_tanggal_sk_pendirian)?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="edit_sk_izin" class="col-sm-3 control-label">SK Izin</label>
                          <div class="error-message16"></div>
                          <div class="col-sm-12">
                            <?=form_input($edit_sk_izin)?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="edit_tanggal_sk_izin" class="col-sm-3 control-label">Tanggal SK Izin</label>
                          <div class="error-message17"></div>
                          <div class="col-sm-12">
                            <?=form_input($edit_tanggal_sk_izin)?>
                          </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-aplikasi" role="tabpanel" aria-labelledby="custom-tabs-one-aplikasi-tab">
                      <div class="form-group">
                          <label for="logo_aplikasi" class="col-sm-3 control-label">Logo Aplikasi</label>
                          <div class="error-message20"></div>
                          <div class="col-sm-12">
                            <input type="file" name="logo_aplikasi" id="logo_aplikasi" class="form-control-file" required><br/>
                            <div id="uploadPreview"></div>
                            <?php
                                echo "<img style='max-width:60%;' data-image='$logo_aplikasi' src='".base_url('assets/upload/profile/')."$logo_aplikasi' class='thumb img-responsive current-img-remove'> ";
                            ?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="edit_nama_aplikasi" class="col-sm-3 control-label">Nama Aplikasi</label>
                          <div class="error-message18"></div>
                          <div class="col-sm-12">
                            <?=form_input($edit_nama_aplikasi)?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="edit_ket_aplikasi" class="col-sm-3 control-label">Keterangan Aplikasi</label>
                          <div class="error-message19"></div>
                          <div class="col-sm-12">
                            <?=form_input($edit_ket_aplikasi)?>
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
          <button type="button" class="btn btn-primary" id="btn-simpan">Simpan</button>
        </div>
        <?=form_close()?>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- /.modal -->

<script type="text/javascript">
  $('#modal_diagram').on('show.bs.modal', function () {
    $("#modal_diagram").find(".modal-body").html("<center>Mohon ditunggu, data sedang diproses ..</center>"); 
    $.ajax({
      url: "<?=base_url('administrator/Dashboard/diagram/')?>",
      type: "post",
      success: function(data){
        $("#modal_diagram").find(".modal-body").html(data);
      }
    });
  });

  $('#modal_corona').on('show.bs.modal', function () { 
    $("#modal_corona").find(".modal-body").html("<center>Mohon ditunggu, data sedang diproses ..</center>");
    $.ajax({
      url: "<?=base_url('administrator/Dashboard/corona/')?>",
      type: "post",
      success: function(data){
        $("#modal_corona").find(".modal-body").html(data);
      }
    });
  });

  function showModal()
  {
    $("#modal_data").modal('show');
  }

  function emailValidation($email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test( $email );
  }

  function removeErrorMessages()
  {
    $("#error-message1").remove();
    $("#error-message2").remove();
    $("#error-message3").remove();
    $("#error-message4").remove();
    $("#error-message5").remove();
    $("#error-message6").remove();
    $("#error-message7").remove();
    $("#error-message8").remove();
    $("#error-message9").remove();
    $("#error-message10").remove();
    $("#error-message11").remove();
    $("#error-message12").remove();
    $("#error-message13").remove();
    $("#error-message14").remove();
    $("#error-message15").remove();
    $("#error-message16").remove();
    $("#error-message17").remove();
    $("#error-message18").remove();
    $("#error-message19").remove();
    $("#error-message20").remove();
    $("#error-message21").remove();
    $("#error-message22").remove();
  }

  function removeBadge()
  {
    $('#badge-danger-tab1').remove();
    $('#badge-danger-tab2').remove();
    $('#badge-danger-tab3').remove();
  }

  function formValidation()
  {
    var idprofile = $('#idprofile').val();
    var p_nama = $('#p_nama').val();
    var p_kepala_sekolah = $('#p_kepala_sekolah').val();
    var p_kepala_nbmnip = $('#p_kepala_nbmnip').val();
    var p_tahun_pelajaran = $('#p_tahun_pelajaran').val();
    var p_alamat = $('#p_alamat').val();
    var p_provinsi = $('#p_provinsi').val();
    var p_kota = $('#p_kota').val();
    var p_kecamatan = $('#p_kecamatan').val();
    var p_kodepos = $('#p_kodepos').val();
    var p_telepon = $('#p_telepon').val();
    var p_email = $('#p_email').val();
    var p_npsn = $('#p_npsn').val();
    var p_status = $('#p_status').val();
    var p_bentuk_pendidikan = $('#p_bentuk_pendidikan').val();
    var p_status_kepemilikan = $('#p_status_kepemilikan').val();
    var p_sk_pendirian = $('#p_sk_pendirian').val();
    var p_tanggal_sk_pendirian = $('#p_tanggal_sk_pendirian').val();
    var p_sk_izin = $('#p_sk_izin').val();
    var p_tanggal_sk_izin = $('#p_tanggal_sk_izin').val();
    var p_nama_aplikasi = $('#p_nama_aplikasi').val();
    var p_ket_aplikasi = $('#p_ket_aplikasi').val();

    var images_length = document.getElementById('logo_aplikasi').files.length;
    var images = $('#logo_aplikasi')[0].files[0];
    var current_images = $(".current-img-remove").attr('data-image');

    if ($.trim(idprofile)==''){
      toastr.error('ID Profile Kosong !');
    } else if ($.trim(p_nama)==''){
      showToast('Nama sekolah tidak boleh kosong !',1000,'error');
      $(".error-message1").append('<div class="font-italic text-danger" id="error-message1"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab1").append('<span id="badge-danger-tab1" class="badge badge-danger">!</span>');
    } else if ($.trim(p_kepala_sekolah)==''){
      showToast('Nama kepala sekolah tidak boleh kosong !',1000,'error');
      $(".error-message21").append('<div class="font-italic text-danger" id="error-message21"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab1").append('<span id="badge-danger-tab1" class="badge badge-danger">!</span>');
    } else if ($.trim(p_kepala_nbmnip)==''){
      showToast('NBM/NIP kepala sekolah tidak boleh kosong !',1000,'error');
      $(".error-message22").append('<div class="font-italic text-danger" id="error-message22"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab1").append('<span id="badge-danger-tab1" class="badge badge-danger">!</span>');
    } else if ($.trim(p_tahun_pelajaran)==''){
      showToast('Tahun pelajaran tidak boleh kosong !',1000,'error');
      $(".error-message2").append('<div class="font-italic text-danger" id="error-message2"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab1").append('<span id="badge-danger-tab1" class="badge badge-danger">!</span>');
    } else if ($.trim(p_alamat)==''){
      showToast('Alamat tidak boleh kosong !',1000,'error');
      $(".error-message3").append('<div class="font-italic text-danger" id="error-message3"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab1").append('<span id="badge-danger-tab1" class="badge badge-danger">!</span>');
    } else if ($.trim(p_provinsi)==''){
      showToast('Silahkan pilih provinsi !',1000,'error');
      $(".error-message4").append('<div class="font-italic text-danger" id="error-message4"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab1").append('<span id="badge-danger-tab1" class="badge badge-danger">!</span>');
    } else if ($.trim(p_kota)==''){
      showToast('Silahkan pilih kota !',1000,'error');
      $(".error-message5").append('<div class="font-italic text-danger" id="error-message5"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab1").append('<span id="badge-danger-tab1" class="badge badge-danger">!</span>');
    } else if ($.trim(p_kecamatan)==''){
      showToast('Silahkan pilih kecamatan !',1000,'error');
      $(".error-message6").append('<div class="font-italic text-danger" id="error-message6"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab1").append('<span id="badge-danger-tab1" class="badge badge-danger">!</span>');
    } else if ($.trim(p_kodepos)==''){
      showToast('Kode pos tidak boleh kosong !',1000,'error');
      $(".error-message7").append('<div class="font-italic text-danger" id="error-message7"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab1").append('<span id="badge-danger-tab1" class="badge badge-danger">!</span>');
    } else if ($.trim(p_telepon)==''){
      showToast('Telepon tidak boleh kosong !',1000,'error');
      $(".error-message8").append('<div class="font-italic text-danger" id="error-message8"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab1").append('<span id="badge-danger-tab1" class="badge badge-danger">!</span>');
    } else if ($.trim(p_email)==''){
      showToast('Email tidak boleh kosong !',1000,'error');
      $(".error-message9").append('<div class="font-italic text-danger" id="error-message9"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab1").append('<span id="badge-danger-tab1" class="badge badge-danger">!</span>');
    }
    // Tab 2
    else if ($.trim(p_npsn)==''){
      showToast('NPSN tidak boleh kosong !',1000,'error');
      $(".error-message10").append('<div class="font-italic text-danger" id="error-message10"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab2").append('<span id="badge-danger-tab2" class="badge badge-danger">!</span>');
    } else if ($.trim(p_status)==''){
      showToast('Status tidak boleh kosong !',1000,'error');
      $(".error-message11").append('<div class="font-italic text-danger" id="error-message11"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab2").append('<span id="badge-danger-tab2" class="badge badge-danger">!</span>');
    } else if ($.trim(p_bentuk_pendidikan)==''){
      showToast('Bentuk tidak boleh kosong !',1000,'error');
      $(".error-message12").append('<div class="font-italic text-danger" id="error-message12"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab2").append('<span id="badge-danger-tab2" class="badge badge-danger">!</span>');
    } else if ($.trim(p_status_kepemilikan)==''){
      showToast('Status kepemilikan tidak boleh kosong !',1000,'error');
      $(".error-message13").append('<div class="font-italic text-danger" id="error-message13"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab2").append('<span id="badge-danger-tab2" class="badge badge-danger">!</span>');
    } else if ($.trim(p_sk_pendirian)==''){
      showToast('SK pendirian tidak boleh kosong !',1000,'error');
      $(".error-message14").append('<div class="font-italic text-danger" id="error-message14"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab2").append('<span id="badge-danger-tab2" class="badge badge-danger">!</span>');
    } else if ($.trim(p_tanggal_sk_pendirian)==''){
      showToast('Tanggal SK pendirian tidak boleh kosong !',1000,'error');
      $(".error-message15").append('<div class="font-italic text-danger" id="error-message15"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab2").append('<span id="badge-danger-tab2" class="badge badge-danger">!</span>');
    } else if ($.trim(p_sk_izin)==''){
      showToast('SK izin tidak boleh kosong !',1000,'error');
      $(".error-message16").append('<div class="font-italic text-danger" id="error-message16"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab2").append('<span id="badge-danger-tab2" class="badge badge-danger">!</span>');
    } else if ($.trim(p_tanggal_sk_izin)==''){
      showToast('Tanggal SK izin tidak boleh kosong !',1000,'error');
      $(".error-message17").append('<div class="font-italic text-danger" id="error-message17"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab2").append('<span id="badge-danger-tab2" class="badge badge-danger">!</span>');
    }
    // Tab 3
    else if (images_length<1 && current_images==''){
      showToast('Logo aplikasi tidak boleh kosong !',1000,'error');
      $(".error-message20").append('<div class="font-italic text-danger" id="error-message20"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab3").append('<span id="badge-danger-tab3" class="badge badge-danger">!</span>');
    } else if ($.trim(p_nama_aplikasi)==''){
      showToast('Nama aplikasi tidak boleh kosong !',1000,'error');
      $(".error-message18").append('<div class="font-italic text-danger" id="error-message18"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab3").append('<span id="badge-danger-tab3" class="badge badge-danger">!</span>');
    } else if ($.trim(p_ket_aplikasi)==''){
      showToast('Keterangan aplikasi tidak boleh kosong !',1000,'error');
      $(".error-message19").append('<div class="font-italic text-danger" id="error-message19"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab3").append('<span id="badge-danger-tab3" class="badge badge-danger">!</span>');
    } else {
      return true;
    }
  }

  function readImage(file) {
    var reader = new FileReader();
    var image  = new Image();

    reader.readAsDataURL(file);
    reader.onload = function(_file) {
      image.src = _file.target.result; // url.createObjectURL(file);
      image.onload = function() {
        var w = this.width,
            h = this.height,
            t = file.type, // ext only: // file.type.split('/')[1],
            n = file.name,
            s = ~~(file.size/1024) +'KB';
      $('#uploadPreview').append('<img style="max-width:150px" src="' + this.src + '" class="thumb img-responsive img-remove"> ');
        $(".img-remove").click(function(){
          $(".img-remove").attr('src', '').hide();
          $("#logo_aplikasi").val('');
        });
      };

      image.onerror= function() {
        alert('Invalid file type: '+ file.type);
      };
    };
  }

  $(".current-img-remove").click(function(){
    $(".current-img-remove").attr('src', '').hide();
    $(".current-img-remove").attr('data-image', '').hide();
    $("#logo_aplikasi").val('');
  });

  $("#logo_aplikasi").change(function (e) {
    if(this.disabled) {
      return alert('File upload not supported!');
    }
    var F = this.files;
    if (F.length > 1){
      $("#logo_aplikasi").val('');
      return alert('Gambar tidak boleh lebih dari 1');
    }
    if (F[0]) {
      for (var i = 0; i < F.length; i++) {
      $(".img-remove").attr('src', '').hide();
      $(".current-img-remove").attr('src', '').hide();
      $(".current-img-remove").attr('data-image', '').hide();
        readImage(F[i]);
      }
    }
  });

  $('#modal_data').on('hidden.bs.modal', function () {
    $("#f_profile")[0].reset();
    removeErrorMessages();
    removeBadge();
  })

  $('#p_provinsi').on('change', function(){
		var idprovinsi = $('#p_provinsi').val();
		$.ajax({
			url: '<?=base_url('administrator/dashboard/read_kota/')?>'+idprovinsi,
			dataType: 'html',
			success: function(data){
				$('#p_kota').html(data);
			}
		});

		$.ajax({
			url: '<?=base_url('administrator/dashboard/read_kecamatan/')?>',
			dataType: 'html',
			success: function(data){
				$('#p_kecamatan').html(data);
			}
		});
	});

  $('#p_kota').on('change', function (){
		var idkota = $('#p_kota').val();
		$.ajax({
			url: '<?=base_url('administrator/dashboard/read_kecamatan/')?>'+idkota,
			dataType: 'html',
			success: function(data){
				$('#p_kecamatan').html(data);
			}
		});
	});

  $('#btn-simpan').click(function() {
    removeErrorMessages();
    removeBadge();
    if(formValidation()){
      $('#btn-simpan').hide();
      //var data = $('#f_profile').serialize(); untuk browser yang belum support FormData()
      var form = $('#f_profile')[0];
      var data = new FormData(form);
      var images = $('#logo_aplikasi')[0].files[0];
      if (images===undefined){
        data.append("attach",'N');
      } else {
        data.append("attach",'Y');
        data.append("files",images);
      }
        $.ajax({
            type: "POST",
            data: data,
            cache:false,
            contentType: false,
            processData: false,
            url: "<?=base_url('administrator/dashboard/save_data')?>",
            success: function(r) {
                if (r.status == "success") {
                    //location.reload();
                    $('#btn-simpan').show();
                    showToast(r.data,1000,'success');
                    $("#modal_data").modal('hide');
                    $('#f_profile')[0].reset();
                    $("#refresh").load(" #refresh_content");
                    $("#refresh_content").hide();
                    $("#nav-refresh").load(" #nav-refresh-content");
                    $("#nav-refresh-content").hide();
                } else {
                    showToast(r.data,1000,'error');
                    $('#btn-simpan').show();
                }
            }
        });
      return false;
    }
  });

</script>

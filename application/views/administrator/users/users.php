<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-outline" style="background-color:#2D5E89; color:#fff;">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-edit"></i>
                  Data Pengguna
                </h3>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
        <div class="row">
          <div class="col-12 col-sm-12">
            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1" style="background:#17a2b8;">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-homey-tab" data-toggle="pill" href="#custom-tabs-one-homey" role="tab" aria-controls="custom-tabs-one-homey" aria-selected="true">Data Pengguna Guru</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Data Pengguna Guru Kelas</a>
                  </li>
                  <li class="nav-item ml-auto">
                    <a href="#" onclick="return edit(0)" class="btn btn-primary">(+) Tambah Pengguna</a>
                    <a href="#" onclick="return cetak_users()" class="btn btn-primary"><i class="fa fa-print"></i> Cetak Data</a>
                    <!-- <a href="#" data-toggle="modal" data-target="#modal_import_data" class="btn btn-primary"><i class="fa fa-download"></i> Import Data</a> -->
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-homey" role="tabpanel" aria-labelledby="custom-tabs-one-homey-tab">
                    <div class="row">
                      <div class="col-12">
                        <!-- /.card -->
                        <div class="card">
                          <!-- /.card-header -->
                          <div class="card-body table-responsive">
                            <table id="tGuru" class="table table-bordered table-striped table-hover">
                              <thead style="background-color:#17a2b8; color:#fff;">
                              <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NBP/NIP</th>
                                <th>Status Pegawai</th>
                                <th>Tugas Tambahan</th>
                                <th>Mata Pelajaran<br/><small><i>(yang diajarkan)</i></small></th>
                                <th>Kelas<br/><small><i>(yang diajarkan)</i></small></th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th></th>
                              </tr>
                              </thead>
                              <tbody>

                              </tbody>

                              <tfoot>
                              <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NBP/NIP</th>
                                <th>Status Pegawai</th>
                                <th>Tugas Tambahan</th>
                                <th>Mata Pelajaran<br/><small><i>(yang diajarkan)</i></small></th>
                                <th>Kelas<br/><small><i>(yang diajarkan)</i></small></th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th></th>
                              </tr>
                              </tfoot>
                            </table>
                          </div>
                          <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                      </div>
                      <!-- /.col -->
                    </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                    <div class="row">
                      <div class="col-12">
                        <!-- /.card -->
                        <div class="card">
                          <!-- /.card-header -->
                          <div class="card-body table-responsive">
                            <table id="tGurukelas" class="table table-bordered table-striped table-hover">
                              <thead style="background-color:#17a2b8; color:#fff;">
                              <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NBP/NIP</th>
                                <th>Status Pegawai</th>
                                <th>Tugas Tambahan</th>
                                <th>Mata Pelajaran<br/><small><i>(yang diajarkan)</i></small></th>
                                <th>Kelas<br/><small><i>(yang diajarkan)</i></small></th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th></th>
                              </tr>
                              </thead>
                              <tbody>

                              </tbody>

                              <tfoot>
                              <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NBP/NIP</th>
                                <th>Status Pegawai</th>
                                <th>Tugas Tambahan</th>
                                <th>Mata Pelajaran<br/><small><i>(yang diajarkan)</i></small></th>
                                <th>Kelas<br/><small><i>(yang diajarkan)</i></small></th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th></th>
                              </tr>
                              </tfoot>
                            </table>
                          </div>
                          <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                      </div>
                      <!-- /.col -->
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <div class="modal fade" id="modal_data_users" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#293D55; color:white;">
          <h5 class="modal-title">Tambah Data User</h5>
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
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Data Pengguna </a>
                    </li>
                  </ul>
                </div>
                <form class="form-horizontal" method="post" name="f_data" id="f_data" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <div class="card-body">
                        <div class="form-group">
                          <label for="u_nama_awal">Nama awal</label>
                          <div class="error-message1"></div>
                          <input type="text" name="u_nama_awal" class="form-control" id="u_nama_awal" placeholder="Nama awal" value="" required="">
                        </div>
                        <div class="form-group">
                          <label for="u_nama_akhir">Nama akhir dan title lengkap</label>
                          <div class="error-message2"></div>
                          <input type="text" name="u_nama_akhir" class="form-control" id="u_nama_akhir" placeholder="Nama akhir + Title" value="">
                        </div>
                        <div class="form-group">
                          <label for="u_jenis_kelamin">Status User</label>
                          <div class="error-message21"></div>
                          <?=form_dropdown('',$edit_groups,'',$edit_groups_attr)?>
                        </div>
                        <div class="form-group">
                          <label for="u_nbm_nip">NBM/NIP</label>
                          <div class="error-message3"></div>
                          <input type="text" name="u_nbm_nip" class="form-control" id="u_nbm_nip" placeholder="NBM/NIP" value="" required="">
                        </div>
                        <div class="form-group">
                          <label for="u_nuptk_nuks">NUPTK/NUKS</label>
                          <div class="error-message4"></div>
                          <input type="text" name="u_nuptk_nuks" class="form-control" id="u_nuptk_nuks" placeholder="NUPTK/NUKS" value="">
                        </div>
                        <div class="form-group">
                          <label for="$u_tempat_lahir">Tempat Lahir</label>
                          <div class="error-message5"></div>
                          <?=form_dropdown('',$edit_provinsi,'',$edit_provinsi_attribute)?><br/>
                          <?=form_dropdown('',$edit_kota,'',$edit_kota_attribute)?><br/>
                        </div>
                        <div class="form-group">
                          <label for="u_tanggal_lahir">Tanggal Lahir</label>
                          <div class="error-message6"></div>
                          <input type="date" name="u_tanggal_lahir" class="form-control" id="u_tanggal_lahir" placeholder="" value="" required="">
                        </div>
                        <div class="form-group">
                          <label for="u_jenis_kelamin">Jenis Kelamin</label>
                          <div class="error-message7"></div>
                          <?=form_dropdown('',$edit_jenis_kelamin,'',$edit_jenis_kelamin_attr)?>
                        </div>
                        <div class="form-group">
                          <label for="u_status_pegawai">Status Kepegawaian</label>
                          <div class="error-message8"></div>
                          <input type="text" name="u_status_pegawai" class="form-control" id="u_status_pegawai" placeholder="GTY/GTT/PTY/PNS dll." value="" required="">
                        </div>
                        <div class="form-group">
                          <label for="u_tunjangan">Tunjangan APBD</label>
                          <div class="error-message13"></div>
                          <input type="text" name="u_tunjangan" class="form-control" id="u_tunjangan" placeholder="Tunjangan APBD" value="">
                        </div>
                        <div class="form-group">
                          <label for="u_tugas_tambahan">Tugas Tambahan</label>
                          <div class="error-message9"></div>
                          <input type="text" name="u_tugas_tambahan" class="form-control" id="u_tugas_tambahan" placeholder="Tugas tambahan" value="">
                        </div>
                        <div class="form-group">
                          <label for="u_jenjang">Ijazah Terakhir</label>
                          <div class="error-message12"></div>
                          <input type="text" name="u_jenjang" class="form-control" id="u_jenjang" placeholder="Jenjang: SD/SMP/SMA/S1/S2" value="" required=""><br/>
                          <input type="text" name="u_perguruan_tinggi" class="form-control" id="u_perguruan_tinggi" placeholder="Perguruan tinggi" value="" required=""><br/>
                          <input type="text" name="u_jurusan" class="form-control" id="u_jurusan" placeholder="Jurusan" value=""><br/>
                          <input type="number" name="u_tahun_lulus" class="form-control" id="u_tahun_lulus" placeholder="Tahun lulus: 2009/2010/ dst" value="" required="">
                        </div>
                        <div class="form-group">
                          <label for="u_npwp">NPWP</label>
                          <div class="error-message14"></div>
                          <input type="text" name="u_npwp" class="form-control" id="u_npwp" placeholder="NPWP" value="">
                        </div>
                        <div class="form-group">
                          <label for="u_sertifikasi">Sertifikasi</label>
                          <div class="error-message15"></div>
                          <select class="form-control" name="u_sertifikasi" id="u_sertifikasi">
                            <option value="" hidden>- Pilih Status -</option>
                            <option value="Sudah">Sudah</option>
                            <option value="Belum">Belum</option>
                          </select>
                          <input type="number" name="u_sertifikasi_tahun" class="form-control" style="display:none;" id="u_sertifikasi_tahun" placeholder="Tahun sertifikasi: 2018/2019/ dst" value="">
                        </div>
                        <div class="form-group">
                          <label for="u_prestasi">Prestasi Kerja</label>
                          <div class="error-message16"></div>
                          <input type="text" name="u_prestasi" class="form-control" id="u_prestasi" placeholder="Prestasi kerja" value="">
                        </div>
                        <div class="form-group">
                          <label for="u_nominal_honor">Nominal Honor</label>
                          <div class="error-message17"></div>
                          <input type="number" name="u_nominal_honor" class="form-control" id="u_nominal_honor" placeholder="Nominal" value="" required="">
                        </div>
                        <div class="form-group">
                          <label for="u_kerja_pasangan">Pekerjaan Suami/Istri</label>
                          <div class="error-message18"></div>
                          <input type="text" name="u_kerja_pasangan" class="form-control" id="u_kerja_pasangan" placeholder="Pekerjaan suami/istri" value="">
                        </div>
                        <div class="form-group">
                          <label for="u_alamat_tinggal">Alamat Tinggal</label>
                          <div class="error-message19"></div>
                          <input type="text" name="u_alamat_tinggal" class="form-control" id="u_alamat_tinggal" placeholder="Alamat tinggal" value="" required="">
                        </div>
                        <div class="form-group">
                          <label for="u_telepon">No Telepon</label>
                          <div class="error-message10"></div>
                          <input type="number" name="u_telepon" class="form-control" id="u_telepon" placeholder="08xxx" value="" required="">
                        </div>
                        <div class="form-group">
                          <label for="u_email">Email Aktif</label>
                          <div class="error-message11"></div>
                          <input type="email" name="u_email" class="form-control" id="u_email" placeholder="xxx@xxx.com" value="" required="">
                        </div>
                        <div class="form-group">
                            <label for="u_photo" class="col-sm-3 control-label">Photo</label>
                            <div class="error-message20"></div>
                            <div class="col-sm-12">
                              <input type="file" name="u_photo" id="u_photo" class="form-control-file"><br/>
                              <div id="uploadPreview"></div>
                            </div>
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
          <button type="submit" class="btn btn-primary" id="btn-save">Simpan</button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <!-- MODAL -->
  <div class="modal fade" id="modal_import_data" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#293D55; color:white;">
          <h6 class="modal-title">Import Data Pengguna</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="<?php print site_url();?>phpspreadsheet/upload" id="f_import_data" enctype="multipart/form-data" method="post" accept-charset="utf-8">
          <div class="row padall">
            <div class="col-lg-6 order-lg-1">
              
              <input type="file" class="custom-file-input" id="validatedCustomFile" name="fileURL">
              <label class="custom-file-label" for="validatedCustomFile">Pilih file ..</label>
            </div>
            <div class="col-lg-6 order-lg-2">
              <button type="submit" name="import" id="btn-import" class="float-right btn btn-primary">Import</button>
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
  <!-- END MODAL -->

  <script type="text/javascript">
  $(window).on('load',function () {
      $('#sidemenu-button').click();
  });

  // $("#f_import_data").on('submit',function(e){
  //   e.preventDefault();
  //   $('#btn-import').hide();
  //   var import_length = document.getElementById('validatedCustomFile').files.length;

  //   if (import_length<1){
  //     showToast("Silahkan pilih file yang akan diimport",1000,'error');
  //     $('#btn-import').show();
  //   } else {
  //     var form = $('#f_import_data')[0];
  //     var data = new FormData(form);
  //     var import_data = $('#validatedCustomFile')[0].files[0];
  //     data.append("fileURL",import_data);
  //     $.ajax({
  //       type: "POST",
  //       data: data,
  //       cache:false,
  //       contentType: false,
  //       processData: false,
  //       url: "<?=base_url('administrator/Users/upload')?>",
  //       success: function(r) {
  //           if (r.status == "success") {
  //               $('#btn-import').show();
  //               showToast("sukses import",1000,'success');
  //           } else {
  //               showToast("gagal import",1000,'error');
  //               $('#btn-import').show();
  //           }
  //       }
  //     });
  //     return false;
  //   }
  // });

  function reset_password(email)
  {
    swal({
        title: "Lanjut reset password ..?",
        text: "Apakah anda yakin akan mengirim link reset password untuk email "+email+" ?",
        icon: "warning",
        buttons: [
          'Batal',
          'Lanjut'
        ],
        dangerMode: true,
      }).then(function(isConfirm) {
        if (isConfirm) {
          $.ajax({
            type: "POST",
            data:{identity:email,type_identity:'administrator'},
            url: auth_url+"forgot_password",
            success: function(r) {
              if (r.status == 'ok'){
                swal("Dikirim", "Email untuk reset password telah dikirim", "success");
              } else {
                swal("Gagal", "Email untuk reset password gagal dikirim, silahkan ulangi kembali", "error");
              }
            }
          });
          return false;
        } else {
          swal("Dibatalkan", "Reset password dibatalkan", "error");
        }
      })
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
          $("#u_photo").val('');
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
    $("#u_photo").val('');
  });

  $("#u_photo").change(function (e) {
    if(this.disabled) {
      return alert('File upload not supported!');
    }
    var F = this.files;
    if (F.length > 1){
      $("#u_photo").val('');
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

  $('#u_tl_idprovinsi').on('change', function(){
    var idprovinsi = $('#u_tl_idprovinsi').val();
    $.ajax({
      url: '<?=base_url('administrator/users/read_kota/')?>'+idprovinsi,
      dataType: 'html',
      success: function(data){
        $('#u_tl_idkota').html(data);
      }
    });
  });

  $('#u_email').on('change', function (e){
    e.preventDefault();
    var email = $(this).val();
    $.ajax({
        type: "POST",
        data: {u_email:email},
        url: base_url+"Users/check_email",
        success: function(r) {
            if (r.status == "gagal") {
              $('#u_email').val('');
              showToast('Email sudah dipakai, silahkan gunakan email lainnya',1000,'error');
            }
        }
    });
    return false;
  });

  $('#u_telepon').on('change', function (e){
    e.preventDefault();
    var telepon = $(this).val();
    if (telepon<0){
      $('#s_telepon').val(0);
      showToast('No telepon tidak boleh bernilai minus',1000,'error');
      return false;
    }
    $.ajax({
        type: "POST",
        data: {u_telepon:telepon},
        url: base_url+"Users/check_telepon",
        success: function(r) {
            if (r.status == "gagal") {
              $('#u_telepon').val('');
              showToast('No telepon sudah dipakai, silahkan gunakan nomor lainnya',1000,'error');
            }
        }
    });
    return false;
  });

  function formValidationData()
  {
    var u_nama_awal = $('#u_nama_awal').val();
    var u_nama_akhir = $('#u_nama_akhir').val();
    var u_nbm_nip = $('#u_nbm_nip').val();
    var u_tempat_lahir = $('#u_tl_idkota').val();
    var u_tanggal_lahir = $('#u_tanggal_lahir').val();
    var u_jenis_kelamin = $('#u_jenis_kelamin').val();
    var u_status_pegawai = $('#u_status_pegawai').val();
    var u_telepon = $('#u_telepon').val();
    var u_email = $('#u_email').val();
    var u_jenjang = $('#u_jenjang').val();
    var u_perguruan_tinggi = $('#u_perguruan_tinggi').val();
    var u_tahun_lulus = $('#u_tahun_lulus').val();
    var u_sertifikasi = $('#u_sertifikasi').val();
    var u_sertifikasi_tahun = $('#u_sertifikasi_tahun').val();
    var u_nominal_honor = $('#u_nominal_honor').val();
    var u_alamat_tinggal = $('#u_alamat_tinggal').val();
    var users_groups = $('#users_groups').val();

    var re = new RegExp(/^(\d{4})$/);
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

    var images_length = document.getElementById('u_photo').files.length;
    var images = $('#u_photo')[0].files[0];
    var current_images = $(".current-img-remove").attr('data-image');

    if ($.trim(u_nama_awal)==''){
      showToast('Nama awal tidak boleh kosong !',1000,'error');
      $(".error-message1").append('<div class="font-italic text-danger" id="error-message1"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(users_groups)==''){
      showToast('Status user tidak boleh kosong !',1000,'error');
      $(".error-message21").append('<div class="font-italic text-danger" id="error-message21"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_nbm_nip)==''){
      showToast('NBM/NIP tidak boleh kosong !',1000,'error');
      $(".error-message3").append('<div class="font-italic text-danger" id="error-message3"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_tempat_lahir)==''){
      showToast('Tempat lahir tidak boleh kosong !',1000,'error');
      $(".error-message5").append('<div class="font-italic text-danger" id="error-message5"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_tanggal_lahir)==''){
      showToast('Tanggal lahir tidak boleh kosong !',1000,'error');
      $(".error-message6").append('<div class="font-italic text-danger" id="error-message6"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_jenis_kelamin)==''){
      showToast('Jenis kelamin tidak boleh kosong !',1000,'error');
      $(".error-message7").append('<div class="font-italic text-danger" id="error-message7"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_status_pegawai)==''){
      showToast('Status pegawai tidak boleh kosong !',1000,'error');
      $(".error-message8").append('<div class="font-italic text-danger" id="error-message8"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_telepon)==''){
      showToast('Telepon tidak boleh kosong !',1000,'error');
      $(".error-message10").append('<div class="font-italic text-danger" id="error-message10"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_email)=='' || !emailReg.test(u_email)){
      showToast('Email tidak boleh kosong atau tidak sesuai format !',1000,'error');
      $(".error-message11").append('<div class="font-italic text-danger" id="error-message11"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_jenjang)==''){
      showToast('Jenjang tidak boleh kosong !',1000,'error');
      $(".error-message12").append('<div class="font-italic text-danger" id="error-message12"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_perguruan_tinggi)==''){
      showToast('Perguruan tinggi tidak boleh kosong !',1000,'error');
      $(".error-message12").append('<div class="font-italic text-danger" id="error-message12"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_tahun_lulus)=='' || !re.test(u_tahun_lulus)){
      showToast('Tahun lulus tidak boleh kosong atau tidak sesuai format !',1000,'error');
      $(".error-message12").append('<div class="font-italic text-danger" id="error-message12"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_sertifikasi)=='Sudah' && $.trim(u_sertifikasi_tahun)=='' || $.trim(u_sertifikasi)=='Sudah' && !re.test(u_sertifikasi_tahun)){
      showToast('Tahun sertifikasi tidak boleh kosong !',1000,'error');
      $(".error-message15").append('<div class="font-italic text-danger" id="error-message15"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_nominal_honor)=='' || u_nominal_honor<=0){
      showToast('Nominal honor tidak boleh kosong atau minus !',1000,'error');
      $(".error-message16").append('<div class="font-italic text-danger" id="error-message16"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_alamat_tinggal)==''){
      showToast('Alamat tinggal tidak boleh kosong !',1000,'error');
      $(".error-message19").append('<div class="font-italic text-danger" id="error-message19"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if (images_length<1){
      showToast('Foto tidak boleh kosong !',1000,'error');
      $(".error-message20").append('<div class="font-italic text-danger" id="error-message20"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab2").append('<span id="badge-danger-tab2" class="badge badge-danger">!</span>');
    } else {
      return true;
    }
  }

  function removeErrorMessagesData()
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
  }

  $(document).ready(function(){
    fDatatables("tGuru","<?=base_url('administrator/Users/ajax_list_guru')?>","ASC");
    fDatatables("tGurukelas","<?=base_url('administrator/Users/ajax_list_guru_kelas')?>","ASC");

    $("#f_data").on("submit", function(e) {
      e.preventDefault();
      removeErrorMessagesData();
      if(formValidationData()){
        $('#btn-save').prop('disabled',true);
        var form = $('#f_data')[0];
        var data = new FormData(form);
        var images = $('#u_photo')[0].files[0];
        var u_sertifikasi = $('#u_sertifikasi').val();
        var u_sertifikasi_tahun = $('#u_sertifikasi_tahun').val();
        if (u_sertifikasi == 'Belum'){

        } else {
          data.append("u_sertifikasi_tahun",u_sertifikasi_tahun);
        }
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
            url: base_url+"Users/create_users",
            success: function(r) {
                if (r.status == "gagal") {
                    showToast('Data gagal disimpan !',1000,'error');
                    $('#btn-save').prop('disabled',false);
                } else if (r.status == "ok") {
                    $("#modal_data_users").modal('hide');
                    showToast('Data berhasil disimpan !',1000,'success');
                    fDatatables("tGuru","<?=base_url('administrator/Users/ajax_list_guru')?>","ASC");
                    fDatatables("tGurukelas","<?=base_url('administrator/Users/ajax_list_guru_kelas')?>","ASC");
                    $('#f_data')[0].reset();
                    $(".img-remove").attr('src', '').hide();
                    $(".current-img-remove").attr('src', '').hide();
                    $(".current-img-remove").attr('data-image', '').hide();
                    $('#btn-save').prop('disabled',false);
                } else {
                    $("#modal_data_users").modal('hide');
                    showToast('Data sudah ada atau email sudah pernah dipakai !',3000,'warning');
                }
            }
        });
        return false;
      }
    });

    $("#u_sertifikasi").on("change", function(e) {
      e.preventDefault();
      var status = $('#u_sertifikasi').val();
      if(status=='Sudah'){
        $('#u_sertifikasi_tahun').show();
      } else if(status=='Belum') {
        $('#u_sertifikasi_tahun').hide();
      }
    });
  })

  function edit(id){
    if (id == 0) {
        $("#_mode").val('add');
    } else {
        $("#_mode").val('edit');
    }
    $('#modal_data_users').modal('show');
    $('#f_data')[0].reset();
    removeErrorMessagesData();
    return false;
  }

  function cetak_users()
  {
    window.location.href=base_url+"users/cetak_users/";
  }

  function detail(id){
    window.location.href=base_url+"Users/detail/"+id;
  }

  function delete_data(id,data) {
    if (id == 0) {
      showToast('Silahkan pilih data yang akan dihapus !',1000,'error');
    }
    swal({
        title: "Lanjut menghapus ..?",
        text: "Apakah anda yakin akan menghapus data "+data+" ? Data yang telah dihapus tidak dapat dikembalikan",
        icon: "warning",
        buttons: [
          'Batal',
          'Lanjut'
        ],
        dangerMode: true,
      }).then(function(isConfirm) {
        if (isConfirm) {
          $.ajax({
            type: "GET",
            url: base_url+"Users/delete/"+id,
            success: function(r) {
              if (r.status == 'ok'){
                swal("Dihapus", "Data berhasil dihapus", "success");
                fDatatables("tGuru","<?=base_url('administrator/Users/ajax_list_guru')?>","ASC");
                fDatatables("tGurukelas","<?=base_url('administrator/Users/ajax_list_guru_kelas')?>","ASC");
              } else if(r.status == 'walikelas'){
                swal("Gagal", "Data gagal dihapus karena user terhubung sebagai wali kelas pada pengaturan kelas, silahkan ubah terlebih dahulu walikelas menjadi selain user ini", "error");
              } else {
                swal("Gagal", "Data gagal dihapus karena ada data yang sedang terhubung dengan user ini, silahkan klik logo info disebelah label Data Pengguna untuk melihat info data yang terhubung dengan data ini", "error");
              }
            }
          });
          return false;
        } else {
          swal("Dibatalkan", "Penghapusan data dibatalkan", "error");
        }
      })
  }

  </script>

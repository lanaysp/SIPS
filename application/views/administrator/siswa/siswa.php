<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-outline" style="background-color:#2D5E89; color:#fff;">
              <div class="card-header">
                <h3 class="card-title" style="padding-top:8px;">
                  <i class="fas fa-edit"></i>
                  Data Siswa
                </h3>
                <a onclick="return edit(0);" class="btn btn-info" style="color:#FFF; float:right;">(+) Tambah Siswa</a>
                <a class="btn btn-info float-right" style="margin-right:5px;" data-toggle="modal" data-target="#modal_show_all_chart">Grafik Seluruh Siswa</a>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
        <div class="row">
          <div class="col-12">
            <!-- /.card -->
            <div class="col-6">
            <table class="table table-bordered table-striped">
              <tbody>
                <tr>
                  <td style="vertical-align:middle;">Kelas</td>
                  <td>
                    <div class="error-message1"></div>
                    <?=form_dropdown('',$list_kelas,'',$list_kelas_attribute)?>
                  </td>
                </tr>
              </tbody>
            </table>
            </div><br/>
            <div class="card" id="divSiswa" style="display:none;">
              <!-- /.card-header -->
              <input type="hidden" id="_idsiswa" value=""/>
              <input type="hidden" id="_s_nama" value=""/>
              <div class="card-body table-responsive">
                <table id="tSiswa" class="table table-bordered table-striped">
                  <thead style="background-color:#17a2b8; color:white;">
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NISN</th>
                    <th>NIK</th>
                    <th>JK</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Email/Telepon</th>
                    <th>Wali</th>
                    <th>Dusun/Desa/Kecamatan</th>
                    <th>Dalam/Luar Kabupaten</th>
                    <th>Anak ABK</th>
                    <th>Penerima BSM/PIP</th>
                    <th>Keluarga Miskin</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>

                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NISN</th>
                    <th>NIK</th>
                    <th>JK</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Email/Telepon</th>
                    <th>Wali</th>
                    <th>Dusun/Desa/Kecamatan</th>
                    <th>Dalam/Luar Kabupaten</th>
                    <th>Anak ABK</th>
                    <th>Penerima BSM/PIP</th>
                    <th>Keluarga Miskin</th>
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

        <!-- /.card -->

        <!-- /.card -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <div class="modal fade" id="modal_data_siswa" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#293D55; color:white;">
          <h6 class="modal-title">[Tambah] / [Ubah Data]</h6>
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
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Siswa <span class="error-tab1"></span></a>
                    </li>
                  </ul>
                </div>
                <form class="form-horizontal" method="post" id="f_siswa" name="f_siswa">
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <div class="card-body">
                        <div class="form-group">
                          <!-- -->
                          <input type="hidden" name="_id" id="_id" value="">
                          <input type="hidden" name="_mode" id="_mode" value="">
                          <!-- -->
                          <label for="s_kelas">Kelas</label>
                          <div class="error-message6"></div>
                          <?=form_dropdown('',$edit_kelas,'',$edit_kelas_attr)?>
                          <?=form_input($current_kota);?>
                        </div>
                        <div class="form-group">
                          <label for="s_nisn">NISN</label>
                          <div class="error-message1"></div>
                          <input type="number" name="s_nisn" class="form-control" id="s_nisn" placeholder="Nomor Induk Siswa Nasional" value="" required>
                        </div>
                        <div class="form-group">
                          <label for="s_nama">Nama lengkap</label>
                          <div class="error-message2"></div>
                          <input type="text" name="s_nama" class="form-control" id="s_nama" placeholder="Nama lengkap" value="" required>
                        </div>
                        <div class="form-group">
                          <label for="s_nik">NIK</label>
                          <div class="error-message3"></div>
                          <input type="number" name="s_nik" class="form-control" id="s_nik" placeholder="Nomor Induk Kependudukan" value="" required>
                        </div>
                        <div class="form-group">
                          <label for="s_jenis_kelamin">Jenis Kelamin</label>
                          <div class="error-message4"></div>
                          <?=form_dropdown('',$edit_jenis_kelamin,'',$edit_jenis_kelamin_attr)?>
                        </div>
                        <div class="form-group">
                          <label for="s_tempat_lahir">Tempat lahir</label>
                          <div class="error-message5"></div>
                          <?=form_dropdown('',$edit_provinsi,'',$edit_provinsi_attribute)?><br/>
                          <?=form_dropdown('',$edit_kota,'',$edit_kota_attribute)?><br/>
                        </div>
                        <div class="form-group">
                          <label for="s_tanggal_lahir">Tanggal lahir</label>
                          <div class="error-message15"></div>
                          <input type="date" name="s_tanggal_lahir" class="form-control" id="s_tanggal_lahir" placeholder="" value="" required>
                        </div>
                        <div class="form-group">
                          <label for="s_email">Email</label>
                          <div class="error-message16"></div>
                          <input type="email" name="s_email" class="form-control" id="s_email" placeholder="Email" value="" required>
                        </div>
                        <div class="form-group">
                          <label for="s_telepon">Telepon</label>
                          <div class="error-message17"></div>
                          <input type="number" name="s_telepon" class="form-control" id="s_telepon" placeholder="Telepon" value="" required>
                        </div>
                        <div class="form-group">
                          <label for="s_wali">Nama Wali</label>
                          <div class="error-message7"></div>
                          <input type="text" name="s_wali" class="form-control" id="s_wali" placeholder="Nama wali" value="" required>
                        </div>
                        <div class="form-group">
                          <label for="s_dusun">Dusun</label>
                          <div class="error-message8"></div>
                          <input type="text" name="s_dusun" class="form-control" id="s_dusun" placeholder="Dusun" value="" required>
                        </div>
                        <div class="form-group">
                          <label for="s_desa">Desa</label>
                          <div class="error-message9"></div>
                          <input type="text" name="s_desa" class="form-control" id="s_desa" placeholder="Desa" value="" required>
                        </div>
                        <div class="form-group">
                          <label for="s_kecamatan">Kecamatan</label>
                          <div class="error-message10"></div>
                          <input type="text" name="s_kecamatan" class="form-control" id="s_kecamatan" placeholder="Kecamatan" value="" required>
                        </div>
                        <div class="form-group">
                          <label for="s_domisili">Dalam/Luar Kabupaten</label>
                          <div class="error-message11"></div>
                          <select class="form-control" name="s_domisili" id="s_domisili">
                            <option value="" hidden>- Pilih -</option>
                            <option value="Dalam">Dalam</option>
                            <option value="Luar">Luar</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="s_abk">Anak ABK</label>
                          <div class="error-message12"></div>
                          <select class="form-control" name="s_abk" id="s_abk">
                            <option value="" hidden>- Pilih -</option>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="s_bsm_pip">Penerima BSM/PIP</label>
                          <div class="error-message13"></div>
                          <select class="form-control" name="s_bsm_pip" id="s_bsm_pip">
                            <option value="" hidden>- Pilih -</option>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="s_keluarga_miskin">Keluarga Miskin</label>
                          <div class="error-message14"></div>
                          <select class="form-control" name="s_keluarga_miskin" id="s_keluarga_miskin">
                            <option value="" hidden>- Pilih -</option>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                          </select>
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
  <?php 
    if (empty($tahunpelajaran_dipilih['tp_tahun'])){
      redirect (base_url('auth/logout/'));
    }
    $tahun_explode = explode('-',$tahunpelajaran_dipilih['tp_tahun']);
    $p_tahun = $tahun_explode[0];
    $p_semester = $tahun_explode[1];
  ?>
  <!-- MODAL -->
  <div class="modal fade" id="modal_show_all_chart" data-backdrop="static">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#293D55; color:white;">
          <h6 class="modal-title">Grafik Nilai Seluruh Siswa Tahun Pelajaran <?=$p_tahun?> (Semester <?=$p_semester?>)</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer justify-content-between float-right">
          <button onclick="return printCanvas('allChart');" type="button" class="btn-info ml-auto"><i class="fa fa-edit"></i> Print</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!-- END MODAL -->

  <!-- MODAL -->
  <div class="modal fade" id="modal_show_chart" data-backdrop="static">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#293D55; color:white;">
          <h6 class="modal-title">Grafik Nilai Siswa Tahun Pelajaran <?=$p_tahun?> (Semester <?=$p_semester?>)</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer justify-content-between">
          <button onclick="return printCanvas('pengetahuanChart','keterampilanChart');" type="button" class="btn-info ml-auto"><i class="fa fa-edit"></i> Print</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!-- END MODAL -->

<script type="text/javascript">
$(window).on('load',function () {
  $('#sidemenu-button').click();
});

$('#modal_show_all_chart').on('show.bs.modal', function () {
  var idkelas = $('#opsi_kelas option:selected').val();
  var token = 'access';
  if (idkelas==''){
    swal("Pilih kelas ..", "Silahkan pilih kelas untuk menampilkan grafik", "error");
    $('#modal_show_all_chart').find(".modal-body").html("<center>Silahkan pilih kelas untuk menampilkan grafik</center>"); 
  } else {
    $('#modal_show_all_chart').find(".modal-body").html("<center>Mohon ditunggu, data sedang diproses ..</center>"); 
    $.ajax({
      url: "<?=base_url('administrator/Nilai_rapor/nilai_seluruh_siswa_chart/')?>",
      type: "post",
      data: {token:token,idkelas:idkelas},
      success: function(data){
        $("#modal_show_all_chart").find(".modal-body").html(data);
      }
    });
  }
});

$('#modal_show_chart').on('show.bs.modal', function () {
  var idkelas = $('#opsi_kelas option:selected').val();
  var idsiswa = $('#_idsiswa').val();
  var s_nama = $('#_s_nama').val();
  $('#modal_show_all_chart').find(".modal-body").html("<center>Mohon ditunggu, data sedang diproses ..</center>"); 
  $.ajax({
    url: "<?=base_url('administrator/Siswa/diagram/')?>",
    type: "post",
    data: {idsiswa:idsiswa,idkelas:idkelas,s_nama:s_nama},
    success: function(data){
      $("#modal_show_chart").find(".modal-body").html(data);
    }
  });
});

function diagramNilai(id,name)
{
  $('#_idsiswa').val(id);
  $('#_s_nama').val(name);
  $('#modal_show_chart').modal('show');
}

function naik(id)
{
  swal({
      title: "Naik kelas ..?",
      text: "Apakah anda yakin siswa ini naik kelas ?",
      icon: "warning",
      buttons: [
        'Batal',
        'Lanjut'
      ],
      dangerMode: true,
    }).then(function(isConfirm) {
      if (isConfirm) {
        var idsiswa = id;
        var tipe = 'naik';
        var k_tingkat = $('#opsi_kelas option:selected').val();
        if (k_tingkat==''){
          showToast('Silahkan pilih kelas !',1000,'error');
          return false;
        }
        $.ajax({
              type: "POST",
              data: {idsiswa:idsiswa,tipe:tipe},
              url: base_url+"Siswa/naik_turun_kelas",
              success: function(r) {
                  if (r.status == "gagal") {
                      showToast('Gagal naik kelas !',1000,'error');
                  } else if (r.status == "ok") {
                      showToast('Berhasil naik kelas !',1000,'success');
                      fDatatables("tSiswa","<?=base_url('administrator/Siswa/ajax_list/')?>"+k_tingkat,"ASC");
                  }
              }
          });
          return false;
      } else {
        swal("Dibatalkan", "Naik kelas dibatalkan", "error");
      }
    })
}

function turun(id)
{
  swal({
      title: "Turun kelas ..?",
      text: "Apakah anda yakin siswa ini turun kelas ?",
      icon: "warning",
      buttons: [
        'Batal',
        'Lanjut'
      ],
      dangerMode: true,
    }).then(function(isConfirm) {
      if (isConfirm) {
        var idsiswa = id;
        var tipe = 'turun';
        var k_tingkat = $('#opsi_kelas option:selected').val();
        if (k_tingkat==''){
          showToast('Silahkan pilih kelas !',1000,'error');
          return false;
        }
        $.ajax({
              type: "POST",
              data: {idsiswa:idsiswa,tipe:tipe},
              url: base_url+"Siswa/naik_turun_kelas",
              success: function(r) {
                  if (r.status == "gagal") {
                      showToast('Gagal turun kelas !',1000,'error');
                  } else if (r.status == "ok") {
                      showToast('Berhasil turun kelas !',1000,'success');
                      fDatatables("tSiswa","<?=base_url('administrator/Siswa/ajax_list/')?>"+k_tingkat,"ASC");
                  }
              }
          });
          return false;
      } else {
        swal("Dibatalkan", "Turun kelas dibatalkan", "error");
      }
    })
}

$('#s_tl_idprovinsi').on('change', function(){
  var idprovinsi = $('#s_tl_idprovinsi').val();
  $.ajax({
    url: '<?=base_url('administrator/Siswa/read_kota/')?>'+idprovinsi,
    dataType: 'html',
    success: function(data){
      $('#s_tl_idkota').html(data);
    }
  });
});

$('#opsi_kelas').on('change', function (){
  $('#divSiswa').fadeIn();
  var k_tingkat = $('#opsi_kelas option:selected').val();
  if (k_tingkat==''){
    $('#divSiswa').fadeOut();
  } else {
    fDatatablesP("tSiswa","<?=base_url('administrator/Siswa/ajax_list/')?>"+k_tingkat,"ASC");
  }
});

$('#s_email').on('change', function (e){
  e.preventDefault();
  var email = $(this).val();
  $.ajax({
      type: "POST",
      data: {s_email:email},
      url: base_url+"Siswa/check_email",
      success: function(r) {
          if (r.status == "gagal") {
            $('#s_email').val('');
            showToast('Email sudah dipakai, silahkan gunakan email lainnya',1000,'error');
          }
      }
  });
  return false;
});

$('#s_telepon').on('change', function (e){
  e.preventDefault();
  var telepon = $(this).val();
  if (telepon<0){
    $('#s_telepon').val(0);
    showToast('No telepon tidak boleh bernilai minus',1000,'error');
    return false;
  }
  $.ajax({
      type: "POST",
      data: {s_telepon:telepon},
      url: base_url+"Siswa/check_telepon",
      success: function(r) {
          if (r.status == "gagal") {
            $('#s_telepon').val('');
            showToast('No telepon sudah dipakai, silahkan gunakan nomor lainnya',1000,'error');
          }
      }
  });
  return false;
});

function formValidation()
{
  var s_nisn = $('#s_nisn').val();
  var s_nama = $('#s_nama').val();
  var s_nik = $('#s_nik').val();
  var s_jenis_kelamin = $('#s_jenis_kelamin').val();
  var s_tl_idkota = $('#s_tl_idkota').val();
  var s_tanggal_lahir = $('#s_tanggal_lahir').val();
  var s_telepon = $('#s_telepon').val();
  var s_kelas = $('#s_kelas').val();
  var s_wali = $('#s_wali').val();
  var s_dusun = $('#s_dusun').val();
  var s_desa = $('#s_desa').val();
  var s_kecamatan = $('#s_kecamatan').val();
  var s_domisili = $('#s_domisili').val();
  var s_abk = $('#s_abk').val();
  var s_bsm_pip = $('#s_bsm_pip').val();
  var s_keluarga_miskin = $('#s_keluarga_miskin').val();
  var mode = $('#_mode').val();

  if ($.trim(s_nisn)=='' || s_nisn<0){
    showToast('NISN tidak boleh kosong atau bernilai minus (-) !',1000,'error');
    $(".error-message1").append('<div class="font-italic text-danger" id="error-message1"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(s_nama)==''){
    showToast('Nama siswa tidak boleh kosong !',1000,'error');
    $(".error-message2").append('<div class="font-italic text-danger" id="error-message2"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(s_nik)=='' || s_nik<0){
    showToast('NIK tidak boleh kosong atau bernilai minus (-) !',1000,'error');
    $(".error-message3").append('<div class="font-italic text-danger" id="error-message3"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(s_jenis_kelamin)==''){
    showToast('Jenis kelamin tidak boleh kosong !',1000,'error');
    $(".error-message4").append('<div class="font-italic text-danger" id="error-message4"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(s_tanggal_lahir)==''){
    showToast('Tanggal lahir tidak boleh kosong !',1000,'error');
    $(".error-message15").append('<div class="font-italic text-danger" id="error-message15"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(s_telepon)==''){
    showToast('Telepon tidak boleh kosong !',1000,'error');
    $(".error-message17").append('<div class="font-italic text-danger" id="error-message17"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(s_kelas)==''){
    showToast('Kelas tidak boleh kosong !',1000,'error');
    $(".error-message6").append('<div class="font-italic text-danger" id="error-message6"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(s_wali)==''){
    showToast('Jenis kelamin tidak boleh kosong !',1000,'error');
    $(".error-message7").append('<div class="font-italic text-danger" id="error-message7"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(s_dusun)==''){
    showToast('Jenis kelamin tidak boleh kosong !',1000,'error');
    $(".error-message8").append('<div class="font-italic text-danger" id="error-message8"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(s_desa)==''){
    showToast('Jenis kelamin tidak boleh kosong !',1000,'error');
    $(".error-message9").append('<div class="font-italic text-danger" id="error-message9"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(s_kecamatan)==''){
    showToast('Jenis kelamin tidak boleh kosong !',1000,'error');
    $(".error-message10").append('<div class="font-italic text-danger" id="error-message10"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(s_domisili)==''){
    showToast('Jenis kelamin tidak boleh kosong !',1000,'error');
    $(".error-message11").append('<div class="font-italic text-danger" id="error-message11"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(s_abk)==''){
    showToast('Jenis kelamin tidak boleh kosong !',1000,'error');
    $(".error-message12").append('<div class="font-italic text-danger" id="error-message12"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(s_bsm_pip)==''){
    showToast('Jenis kelamin tidak boleh kosong !',1000,'error');
    $(".error-message13").append('<div class="font-italic text-danger" id="error-message13"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(s_keluarga_miskin)==''){
    showToast('Jenis kelamin tidak boleh kosong !',1000,'error');
    $(".error-message14").append('<div class="font-italic text-danger" id="error-message14"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else {
    return true;
  }
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
  $("#error-message17").remove();
}

$(document).ready(function(){
  $("#f_siswa").on("submit", function(e) {
    e.preventDefault();
    removeErrorMessages();
    if(formValidation()){
      $('#btn-save').prop('disabled',true);
      var form = $("#f_siswa")[0];
      var data = new FormData(form);
      var current_kota = $('#current_kota').val();
      var s_tl_idkota = $("#s_tl_idkota").val();
      var k_tingkat = $('#opsi_kelas option:selected').val();
      if (s_tl_idkota==undefined){
        data.append("s_tl_idkota",current_kota);
      } else {
        data.append("s_tl_idkota",s_tl_idkota);
      }
      $.ajax({
          type: "POST",
          data: data,
          cache:false,
          contentType: false,
          processData: false,
          url: base_url+"Siswa/save",
          success: function(r) {
              if (r.status == "gagal") {
                  showToast('Data gagal disimpan !',1000,'error');
              } else if (r.status == "ok") {
                  $("#modal_data_siswa").modal('hide');
                  showToast('Data berhasil disimpan !',1000,'success');
                  fDatatables("tSiswa","<?=base_url('administrator/Siswa/ajax_list/')?>"+k_tingkat,"ASC");
              } else {
                  showToast('Data sudah ada !',1000,'warning');
                  $('#modal_data_siswa').modal('hide');
              }
          }
      });
      return false;
    }
  });
})

function edit(id){
  if (id == 0) {
      $("#_mode").val('add');
  } else {
      $("#_mode").val('edit');
  }
  $('#f_siswa')[0].reset();
  $('#modal_data_siswa').modal('show');
  $.ajax({
      type: "GET",
      url: base_url+"Siswa/reload_kota/"+id,
      success: function(data) {
          $("#s_tl_idkota").html(data);
      }
  });
  $.ajax({
      type: "GET",
      url: base_url+"Siswa/edit/"+id,
      success: function(result) {
          $("#_id").val(result.data.idsiswa);
          $("#s_nisn").val(result.data.s_nisn);
          $("#s_nama").val(result.data.s_nama);
          $("#s_nik").val(result.data.s_nik);
          $("#s_jenis_kelamin").val(result.data.s_jenis_kelamin);
          $("#s_tl_idprovinsi").val(result.data.s_tl_idprovinsi);
          $("#s_tl_idkota").val(result.data.s_tl_idkota);
          $("#current_kota").val(result.data.s_tl_idkota);
          $("#s_tanggal_lahir").val(result.data.s_tanggal_lahir);
          $("#s_email").val(result.data.s_email);
          $("#s_telepon").val(result.data.s_telepon);
          $("#s_kelas").val(result.data.idkelas);
          $("#s_wali").val(result.data.s_wali);
          $("#s_dusun").val(result.data.s_dusun);
          $("#s_desa").val(result.data.s_desa);
          $("#s_kecamatan").val(result.data.s_kecamatan);
          $("#s_domisili").val(result.data.s_domisili);
          $("#s_abk").val(result.data.s_abk);
          $("#s_bsm_pip").val(result.data.s_bsm_pip);
          $("#s_keluarga_miskin").val(result.data.s_keluarga_miskin);
          $('#btn-save').prop('disabled',false);
      }
  });
  return false;
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
        var k_tingkat = $('#opsi_kelas option:selected').val();
        $.ajax({
        type: "GET",
        url: base_url+"Siswa/delete/"+id,
        success: function(r) {
          if (r.status == 'ok'){
            swal("Dihapus", "Data berhasil dihapus", "success");
            fDatatables("tSiswa","<?=base_url('administrator/Siswa/ajax_list/')?>"+k_tingkat,"ASC");
          } else {
            swal("Gagal", "Data gagal dihapus karena ada data yang sedang terhubung pada siswa ini, silahkan aktifkan fitur 'Penghapusan Tanpa Validasi' pada pengaturan website apabila tetap ingin menghapus data dengan resiko seluruh data yang terhubung dengan data ini juga akan ikut terhapus", "error");
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

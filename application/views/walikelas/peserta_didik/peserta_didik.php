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
                  Data Peserta Didik
                </h3>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
        <div class="row">
          <div class="col-12">
            <!-- /.card -->
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="tSiswa" class="table table-bordered table-striped table-hover">
                  <thead style="background-color:#17a2b8; color:#fff;">
                  <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>JK</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Wali</th>
                    <th>Dusun</th>
                    <th>Desa</th>
                    <th>Kecamatan</th>
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
                    <th>Kelas</th>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>JK</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Wali</th>
                    <th>Dusun</th>
                    <th>Desa</th>
                    <th>Kecamatan</th>
                    <th>Dalam/Luar Kabupaten</th>
                    <th>Anak ABK</th>
                    <th>Penerima BSM/PIP</th>
                    <th>Keluarga Miskin</th>
                    <th></th>
                  </tr>
                  </tfoot>
                </table><br/>
                <a href="#" onclick="return reset_data();" class="btn btn-danger float-left text-light ml-auto col-2"><i class="fa fa-window-close"></i> Reset Data</a>
                <a href="#" onclick="return tambah_siswa();" class="btn btn-primary float-right text-light ml-auto col-2"><i class="fa fa-plus"></i> Tambah Siswa</a>
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
          <h6 class="modal-title">[Ubah Data Siswa]</h6>
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
                          <?=form_input($current_kota);?>
                          <!-- -->
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

<!-- MODAL -->
<div class="modal fade" id="modal_tambah_siswa" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#293D55; color:white;">
          <h6 class="modal-title">[Tambah Siswa]</h6>
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
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Data Siswa <span class="error-tab1"></span></a>
                    </li>
                  </ul>
                </div>
                <form class="form-horizontal" method="post" name="f_siswa_add" id="f_siswa_add">
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <div class="card-body">
                        <small class="float-right"><i>* gunakan fitur ini hanya jika ada siswa kelas anda namun namanya tidak tercantum dalam daftar penilaian</i></small>
                        <div class="form-group">
                          <label for="old">Pilih Siswa</label>
                          <div class="error-message1"></div>
                          <?=form_dropdown('',$list_siswa,'',$list_siswa_attribute)?>
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
          <button type="submit" class="btn btn-primary" id="btn-tambah-siswa">Simpan</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /.modal-content -->
<script type="text/javascript">
function tambah_siswa()
{
  $('#modal_tambah_siswa').modal('show');
}

$('#s_tl_idprovinsi').on('change', function(){
  var idprovinsi = $('#s_tl_idprovinsi').val();
  $.ajax({
    url: '<?=base_url('walikelas/Peserta_didik/read_kota/')?>'+idprovinsi,
    dataType: 'html',
    success: function(data){
      $('#s_tl_idkota').html(data);
    }
  });
});

function formValidation()
{
  var s_nisn = $('#s_nisn').val();
  var s_nama = $('#s_nama').val();
  var s_nik = $('#s_nik').val();
  var s_jenis_kelamin = $('#s_jenis_kelamin').val();
  var s_tl_idkota = $('#s_tl_idkota').val();
  var s_tanggal_lahir = $('#s_tanggal_lahir').val();
  var s_wali = $('#s_wali').val();
  var s_dusun = $('#s_dusun').val();
  var s_desa = $('#s_desa').val();
  var s_kecamatan = $('#s_kecamatan').val();
  var s_domisili = $('#s_domisili').val();
  var s_abk = $('#s_abk').val();
  var s_bsm_pip = $('#s_bsm_pip').val();
  var s_keluarga_miskin = $('#s_keluarga_miskin').val();
  var mode = $('#_mode').val();

  if (mode=='edit'){
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
  } else {
    return false;
  }
}

function removeErrorMessages()
{
  $("#error-message1").remove();
  $("#error-message2").remove();
  $("#error-message3").remove();
  $("#error-message4").remove();
  $("#error-message5").remove();
  $("#error-message7").remove();
  $("#error-message8").remove();
  $("#error-message9").remove();
  $("#error-message10").remove();
  $("#error-message11").remove();
  $("#error-message12").remove();
  $("#error-message13").remove();
  $("#error-message14").remove();
  $("#error-message15").remove();
}

$(document).ready(function(){
  fDatatables("tSiswa","<?=base_url('walikelas/Peserta_didik/ajax_list')?>","ASC");
  fDuplicate("tSiswa","nth-child(4)");

  $('.select2bs4').select2({
    theme: 'bootstrap4'
  });

  $("#modal_tambah_siswa").on('hide.bs.modal', function () {
    $("#f_siswa_add")[0].reset();
    $("#list_siswa").trigger('change.select2');
  });

  $("#f_siswa").on("submit", function(e) {
    e.preventDefault();
    removeErrorMessages();
    if(formValidation()){
      $('#btn-save').prop('disabled',true);
      var form = $("#f_siswa")[0];
      var data = new FormData(form);
      var current_kota = $('#current_kota').val();
      var s_tl_idkota = $("#s_tl_idkota").val();
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
          url: base_url+"Peserta_didik/save",
          success: function(r) {
              if (r.status == "gagal") {
                  showToast('Data gagal disimpan !',1000,'error');
              } else if (r.status == "ok") {
                  $("#modal_data_siswa").modal('hide');
                  showToast('Data berhasil disimpan !',1000,'success');
                  fDatatables("tSiswa","<?=base_url('walikelas/Peserta_didik/ajax_list')?>","ASC");
              } else {
                  showToast('Data sudah ada !',1000,'warning');
                  $('#modal_data_siswa').modal('hide');
              }
          }
      });
      return false;
    }
  });

  $("#f_siswa_add").on("submit", function(e) {
    e.preventDefault();
    var list_siswa = $('#list_siswa').val();
    if (list_siswa==''){
      showToast('Siswa belum dipilih!',2000,'warning');
    } else {
      $.ajax({
          type: "POST",
          data: {idsiswa:list_siswa},
          url: base_url+"Peserta_didik/add_one_siswa",
          success: function(r) {
              if (r.status=='ok'){
                $('#f_siswa_add')[0].reset();
                $('#modal_tambah_siswa').modal('hide');
                showToast('Data berhasil disimpan !',1000,'success');
                fDatatables("tSiswa","<?=base_url('walikelas/Peserta_didik/ajax_list')?>","ASC");
              } else if (r.status=='ada') {
                $('#f_siswa_add')[0].reset();
                $('#modal_tambah_siswa').modal('hide');
                showToast('Siswa sudah ada !',2000,'warning');
              } else if (r.status=='kelas') {
                $('#f_siswa_add')[0].reset();
                $('#modal_tambah_siswa').modal('hide');
                showToast('Siswa bukan dari kelas yang anda ampu !',2000,'error');
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
      url: base_url+"Peserta_didik/reload_kota/"+id,
      success: function(data) {
          $("#s_tl_idkota").html(data);
      }
  });
  $.ajax({
      type: "GET",
      url: base_url+"Peserta_didik/edit/"+id,
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

function reset_data() {
  swal({
      title: "Lanjut reset ..?",
      text: "Apakah anda yakin ingin mereset seluruh data..? ** PENTING ** Seluruh data periodik seperti tinggi badan, berat badan, dll akan dikosongkan!",
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
          url: base_url+"Peserta_didik/reset_data/",
          success: function(r) {
            if (r.status == 'ok'){
              showToast('Data berhasil direset !',1000,'success');
              fDatatables("tSiswa","<?=base_url('walikelas/Peserta_didik/ajax_list')?>","ASC");
              fDuplicate("tSiswa","nth-child(4)");
            } else {
              showToast('Data gagal direset !',1000,'error');
            }
          }
        });
        return false;
      } else {
        swal("Dibatalkan", "Reset data dibatalkan", "error");
      }
    })
}

</script>

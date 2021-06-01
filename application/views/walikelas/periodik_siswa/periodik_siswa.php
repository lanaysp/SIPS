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
                  Data Periodik Siswa
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
              <div class="float-right"><small><i>* jika ada nama siswa anda yang tidak ada dalam daftar, silahkan klik tambah data atau reset data pada bagian bawah tabel</i></small></div>
                <table id="tSiswa" class="table table-bordered table-striped table-hover">
                  <thead style="background-color:#17a2b8; color:#fff;">
                  <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Nama</th>
                    <th>Tinggi Badan</th>
                    <th>Berat Badan</th>
                    <th>Jarak Sekolah</th>
                    <th>Waktu Sekolah</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>

                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Nama</th>
                    <th>Tinggi Badan</th>
                    <th>Berat Badan</th>
                    <th>Jarak Sekolah</th>
                    <th>Waktu Sekolah</th>
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
          <h6 class="modal-title">[Ubah Data Periodik Siswa]</h6>
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
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Periodik Siswa <span class="error-tab1"></span></a>
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
                          <label for="s_nama">Nama lengkap</label>
                          <div class="error-message1"></div>
                          <input type="text" name="s_nama" class="form-control" id="s_nama" placeholder="Nama lengkap" value="" required readonly>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="form-group">
                          <label for="s_tinggi_badan">Tinggi badan <i>(cm)</i></label>
                          <div class="error-message2"></div>
                          <input type="text" name="s_tinggi_badan" class="form-control" id="s_tinggi_badan" placeholder="Tinggi badan" value="" required>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="form-group">
                          <label for="s_berat_badan">Berat badan <i>(Kg)</i></label>
                          <div class="error-message3"></div>
                          <input type="text" name="s_berat_badan" class="form-control" id="s_berat_badan" placeholder="Berat badan" value="" required>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="form-group">
                          <label for="s_jarak_sekolah">Jarak sekolah</label>
                          <div class="error-message4"></div>
                          <input type="text" name="s_jarak_sekolah" class="form-control" id="s_jarak_sekolah" placeholder="Jarak sekolah" value="" required>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="form-group">
                          <label for="s_waktu_sekolah">Waktu sekolah</label>
                          <div class="error-message5"></div>
                          <input type="text" name="s_waktu_sekolah" class="form-control" id="s_waktu_sekolah" placeholder="Waktu sekolah" value="" required>
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

function formValidation()
{
  var s_nama = $('#s_nama').val();
  var s_tinggi_badan = $('#s_tinggi_badan').val();
  var s_berat_badan = $('#s_berat_badan').val();
  var s_jarak_sekolah = $('#s_jarak_sekolah').val();
  var s_waktu_sekolah = $('#s_waktu_sekolah').val();
  var mode = $('#_mode').val();

  var reg = new RegExp(/^\d*\.?\d*$/);

  if (mode=='edit'){
    if ($.trim(s_nama)==''){
      showToast('Nama siswa tidak boleh kosong !',1000,'error');
      $(".error-message1").append('<div class="font-italic text-danger" id="error-message1"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(s_tinggi_badan)=='' || !reg.test(s_tinggi_badan)){
      showToast('Tinggi badan tidak boleh kosong atau tidak menggunakan titik sebagai pemisah atau mengandung huruf dan spasi !',4000,'error');
      $(".error-message2").append('<div class="font-italic text-danger" id="error-message2"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(s_berat_badan)=='' || !reg.test(s_berat_badan)){
      showToast('Berat badan tidak boleh kosong atau tidak menggunakan titik sebagai pemisah atau mengandung huruf dan spasi!',4000,'error');
      $(".error-message3").append('<div class="font-italic text-danger" id="error-message3"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(s_jarak_sekolah)==''){
      showToast('Jarak sekolah tidak boleh kosong !',4000,'error');
      $(".error-message4").append('<div class="font-italic text-danger" id="error-message4"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(s_waktu_sekolah)==''){
      showToast('Waktu menuju sekolah tidak boleh kosong !',4000,'error');
      $(".error-message5").append('<div class="font-italic text-danger" id="error-message5"><small>* silahkan isi sesuai format yang diminta</small></div>');
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
}

$(document).ready(function(){
  fDatatables("tSiswa","<?=base_url('walikelas/Periodik_siswa/ajax_list')?>","ASC");
  fDuplicate("tSiswa","nth-child(3)");

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
      var data = $(this).serialize();
      $.ajax({
          type: "POST",
          data: data,
          url: base_url+"Periodik_siswa/save",
          success: function(r) {
              if (r.status == "gagal") {
                  showToast('Data gagal disimpan !',1000,'error');
              } else if (r.status == "ok") {
                  $("#modal_data_siswa").modal('hide');
                  showToast('Data berhasil disimpan !',1000,'success');
                  fDatatables("tSiswa","<?=base_url('walikelas/Periodik_siswa/ajax_list')?>","ASC");
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
          url: base_url+"Periodik_siswa/add_one_siswa",
          success: function(r) {
              if (r.status=='ok'){
                $('#f_siswa_add')[0].reset();
                $('#modal_tambah_siswa').modal('hide');
                showToast('Data berhasil disimpan !',1000,'success');
                fDatatables("tSiswa","<?=base_url('walikelas/Periodik_siswa/ajax_list')?>","ASC");
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
      url: base_url+"Periodik_siswa/edit/"+id,
      success: function(result) {
          $("#_id").val(result.data.idsiswa_guru);
          $("#s_nama").val(result.data.s_nama);
          $("#s_tinggi_badan").val(result.data.s_tinggi_badan);
          $("#s_berat_badan").val(result.data.s_berat_badan);
          $("#s_jarak_sekolah").val(result.data.s_jarak_sekolah);
          $("#s_waktu_sekolah").val(result.data.s_waktu_sekolah);
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
        url: base_url+"Periodik_siswa/reset_data/",
        success: function(r) {
          if (r.status == 'ok'){
            showToast('Data berhasil direset!',5000,'success');
            fDatatables("tSiswa","<?=base_url('walikelas/Periodik_siswa/ajax_list')?>","ASC");
            fDuplicate("tSiswa","nth-child(3)");
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

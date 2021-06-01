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
                  Data Kehadiran Siswa
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
                <table id="tKehadiran" class="table table-bordered table-striped table-hover">
                  <thead style="background-color:#17a2b8; color:#fff;">
                  <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Nama</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Tanpa keterangan</th>
                    <th>Dibuat</th>
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
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Tanpa keterangan</th>
                    <th>Dibuat</th>
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
  <div class="modal fade" id="modal_data_kehadiran" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#293D55; color:white;">
          <h5 class="modal-title">Ubah Kehadiran</h5>
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
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Kehadiran <span class="error-tab1"></span></a>
                    </li>
                  </ul>
                </div>
                <form class="form-horizontal" method="post" id="f_kehadiran" name="f_kehadiran">
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <div class="card-body">
                        <div class="form-group">
                          <!-- -->
                          <input type="hidden" name="_id" id="_id" value="">
                          <input type="hidden" name="_mode" id="_mode" value="">
                          <!-- -->
                          <label for="s_nama">Nama</label>
                          <div class="error-message1"></div>
                          <input type="text" name="s_nama" class="form-control" id="s_nama" placeholder="" value="" readonly>
                        </div>
                        <div class="form-group">
                          <label for="kh_izin">Izin</label>
                          <div class="error-message2"></div>
                          <input type="number" name="kh_izin" class="form-control" id="kh_izin" placeholder="" value="" required>
                        </div>
                        <div class="form-group">
                          <label for="kh_sakit">Sakit</label>
                          <div class="error-message3"></div>
                          <input type="number" name="kh_sakit" class="form-control" id="kh_sakit" placeholder="" value="" required>
                        </div>
                        <div class="form-group">
                          <label for="kh_tanpa_keterangan">Tanpa keterangan</label>
                          <div class="error-message4"></div>
                          <input type="number" name="kh_tanpa_keterangan" class="form-control" id="kh_tanpa_keterangan" placeholder="" value="" required>
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
  var kh_izin = $('#kh_izin').val();
  var kh_sakit = $('#kh_sakit').val();
  var kh_tanpa_keterangan = $('#kh_tanpa_keterangan').val();

  if ($.trim(s_nama)==''){
    showToast('Nama tidak boleh kosong, silahkan refresh halaman !',1000,'error');
    $(".error-message1").append('<div class="font-italic text-danger" id="error-message1"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(kh_izin)=='' || kh_izin<0){
    showToast('Izin tidak boleh kosong atau bernilai minus (-) !',1000,'error');
    $(".error-message2").append('<div class="font-italic text-danger" id="error-message2"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(kh_sakit)=='' || kh_sakit<0){
    showToast('Sakit tidak boleh kosong atau bernilai minus (-) !',1000,'error');
    $(".error-message3").append('<div class="font-italic text-danger" id="error-message3"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(kh_tanpa_keterangan)=='' || kh_tanpa_keterangan<0){
    showToast('Tanpa keterangan tidak boleh kosong atau bernilai minus (-) !',1000,'error');
    $(".error-message4").append('<div class="font-italic text-danger" id="error-message4"><small>* silahkan isi sesuai format yang diminta</small></div>');
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
}

fDatatables("tKehadiran","<?=base_url('walikelas/Kehadiran_siswa/ajax_list')?>","ASC");
$(document).ready(function(){
  fDatatables("tKehadiran","<?=base_url('walikelas/Kehadiran_siswa/ajax_list')?>","ASC");
  fDuplicate("tKehadiran","nth-child(3)");

  $('.select2bs4').select2({
    theme: 'bootstrap4'
  });

  $("#modal_tambah_siswa").on('hide.bs.modal', function () {
    $("#f_siswa_add")[0].reset();
    $("#list_siswa").trigger('change.select2');
  });

  $("#f_kehadiran").on("submit", function(e) {
    e.preventDefault();
    removeErrorMessages();
    if(formValidation()){
      $('#btn-save').prop('disabled',true);
      var data    = $(this).serialize();
      $.ajax({
          type: "POST",
          data: data,
          url: base_url+"Kehadiran_siswa/save",
          success: function(r) {
              if (r.status == "gagal") {
                  showToast('Data gagal disimpan !',1000,'error');
              } else if (r.status == "ok") {
                  $("#modal_data_kehadiran").modal('hide');
                  showToast('Data berhasil disimpan !',1000,'success');
                  fDatatables("tKehadiran","<?=base_url('walikelas/Kehadiran_siswa/ajax_list')?>","ASC");
              } else {
                  showToast('Data sudah ada !',1000,'warning');
                  $('#modal_data_kehadiran').modal('hide');
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
          url: base_url+"Kehadiran_siswa/add_one_siswa",
          success: function(r) {
              if (r.status=='ok'){
                $('#f_siswa_add')[0].reset();
                $('#modal_tambah_siswa').modal('hide');
                showToast('Data berhasil disimpan !',1000,'success');
                fDatatables("tKehadiran","<?=base_url('walikelas/Kehadiran_siswa/ajax_list')?>","ASC");
                fDuplicate("tKehadiran","nth-child(3)");
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

function detail(id){
  if (id == 0) {
      $("#_mode").val('add');
  } else {
      $("#_mode").val('edit');
  }
  $('#modal_data_kehadiran').modal('show');
  $.ajax({
      type: "GET",
      url: base_url+"Kehadiran_siswa/edit/"+id,
      success: function(result) {
          $("#_id").val(result.data.idkehadiran);
          $("#s_nama").val(result.data.s_nama);
          $("#kh_izin").val(result.data.kh_izin);
          $("#kh_sakit").val(result.data.kh_sakit);
          $("#kh_tanpa_keterangan").val(result.data.kh_tanpa_keterangan );
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
        url: base_url+"Kehadiran_siswa/reset_data",
        success: function(r) {
          if (r.status == 'ok'){
            showToast('Data berhasil direset !',1000,'success');
            fDatatables("tKehadiran","<?=base_url('walikelas/Kehadiran_siswa/ajax_list')?>","ASC");
            fDuplicate("tKehadiran","nth-child(3)");
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

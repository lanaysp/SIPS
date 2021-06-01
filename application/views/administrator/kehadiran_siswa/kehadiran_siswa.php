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
            <div class="card" id="divKehadiran" style="display:none;">
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="tKehadiran" class="table table-bordered table-striped">
                  <thead style="background-color:#17a2b8; color:#fff;">
                  <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Nama</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Tanpa keterangan</th>
                    <th>Wali Kelas</th>
                    <th>Dibuat</th>
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
                    <th>Wali Kelas</th>
                    <th>Dibuat</th>
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

<script type="text/javascript">
$('#opsi_kelas').on('change', function (){
  $('#divKehadiran').fadeIn();
  var k_tingkat = $('#opsi_kelas option:selected').val();
  if (k_tingkat==''){
    $('#divKehadiran').fadeOut();
  } else {
    fDatatablesP("tKehadiran","<?=base_url('administrator/Kehadiran_hasil/ajax_list/')?>"+k_tingkat,"ASC");
  }
});

function formValidation()
{
  var s_nama = $('#s_nama').val();
  var kh_izin = $('#kh_izin').val();
  var kh_sakit = $('#kh_sakit').val();
  var kh_tanpa_keterangan = $('#kh_tanpa_keterangan').val();

  if ($.trim(s_nama)==''){
    showToast('Nama tidak boleh kosong !',1000,'error');
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

$(document).ready(function(){
  fDatatables("tKehadiran","<?=base_url('administrator/Kehadiran_hasil/ajax_list')?>","DESC");

  $("#f_kehadiran").on("submit", function(e) {
    e.preventDefault();
    removeErrorMessages();
    if(formValidation()){
      $('#btn-save').prop('disabled',true);
      var data    = $(this).serialize();
      $.ajax({
          type: "POST",
          data: data,
          url: base_url+"Kehadiran_hasil/save",
          success: function(r) {
              if (r.status == "gagal") {
                  showToast('Data gagal disimpan !',1000,'error');
              } else if (r.status == "ok") {
                  $("#modal_data_kehadiran").modal('hide');
                  showToast('Data berhasil disimpan !',1000,'success');
                  fDatatables("tKehadiran","<?=base_url('administrator/Kehadiran_hasil/ajax_list')?>","DESC");
              } else {
                  showToast('Data sudah ada !',1000,'warning');
                  $('#modal_data_kehadiran').modal('hide');
              }
          }
      });
      return false;
    }
  });
})

// function detail(id){
//   if (id == 0) {
//       $("#_mode").val('add');
//   } else {
//       $("#_mode").val('edit');
//   }
//   $('#modal_data_kehadiran').modal('show');
//   $.ajax({
//       type: "GET",
//       url: base_url+"Kehadiran_hasil/edit/"+id,
//       success: function(result) {
//           $("#_id").val(result.data.idkehadiran);
//           $("#s_nama").val(result.data.s_nama);
//           $("#kh_izin").val(result.data.kh_izin);
//           $("#kh_sakit").val(result.data.kh_sakit);
//           $("#kh_tanpa_keterangan").val(result.data.kh_tanpa_keterangan );
//           $('#btn-save').prop('disabled',false);
//       }
//   });
//   return false;
// }

// function delete_data(id,data) {
//   if (id == 0) {
//     showToast('Silahkan pilih data yang akan dihapus !',1000,'error');
//   }
//   if (confirm('Apakah anda yakin ingin menghapus data ekstra '+data+'..? ')) {
//     $.ajax({
//     type: "GET",
//     url: base_url+"Kehadiran_hasil/delete/"+id+"/"+data,
//     success: function(r) {
//       if (r.status == 'ok'){
//         showToast('Data berhasil dihapus !',1000,'success');
//         fDatatables("tKehadiran","<?=base_url('administrator/Kehadiran_hasil/ajax_list')?>","DESC");
//       } else {
//         showToast('Data gagal dihapus !',1000,'error');
//       }
//     }
//     });
//   }
//   return false;
// }

</script>

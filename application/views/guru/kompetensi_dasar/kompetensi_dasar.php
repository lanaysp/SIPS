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
                  Data Kompetensi Dasar
                </h3>
                <a onclick="return edit(0)" class="btn btn-info" style="color:#FFF; float:right;">(+) Tambah KD</a>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
        <div class="row">
          <div class="col-12">
            <div class="col-6">
            <div class="error-message1"></div>
            <table class="table table-bordered table-striped">
              <tbody>
                <tr>
                  <td style="vertical-align:middle;">Mata Pelajaran</td>
                  <td><?=form_dropdown('',$list_mapel,'',$list_mapel_attribute)?></td>
                </tr>
              </tbody>
            </table>
            </div><br/>
            <!-- /.card -->
            <div class="card" id="divKompetensi" style="display:none;">
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="tKompetensi" class="table table-bordered table-striped">
                  <thead style="background-color:#17a2b8; color:#fff;">
                  <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Kategori</th>
                    <th>Kode</th>
                    <th>Kompetensi Dasar</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>

                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Kategori</th>
                    <th>Kode</th>
                    <th>Kompetensi Dasar</th>
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
  <div class="modal fade" id="modal_data_kompetensi" data-backdrop="static">
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
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Kompetensi Dasar <span class="error-tab1"></span></a>
                    </li>
                  </ul>
                </div>
                <form class="form-horizontal" method="post" id="f_kompetensi" name="f_kompetensi">
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <div class="card-body">
                        <div class="form-group">
                          <!-- -->
                          <input type="hidden" name="_id" id="_id" value="">
                          <input type="hidden" name="_mode" id="_mode" value="">
                          <input type="hidden" name="_idmata_pelajaran" id="_idmata_pelajaran" value="">
                          <!-- -->
                          <label for="kd_kode">Kode</label>
                          <div class="error-message2"></div>
                          <input type="text" name="kd_kode" class="form-control" id="kd_kode" placeholder="Kode KD" value="" required>
                        </div>
                        <div class="form-group">
                          <label for="kd_nama">Kompetensi Dasar</label>
                          <div class="error-message3"></div>
                          <input type="text" name="kd_nama" class="form-control" id="kd_nama" placeholder="Nama KD" value="" required>
                        </div>
                        <div class="form-group">
                          <label for="kd_type">Kategori</label>
                          <div class="error-message4"></div>
                          <?=form_dropdown('',$list_kategori,'',$list_kategori_attribute)?>
                        </div>
                        <div class="form-group">
                          <label for="kd_type">Kelas</label>
                          <div class="error-message5"></div>
                          <?=form_dropdown('',$list_kelas,'',$list_kelas_attribute)?>
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
function formValidation()
{
  var idmata_pelajaran = $('#idmata_pelajaran').val();
  var kd_kode = $('#kd_kode').val();
  var kd_nama = $('#kd_nama').val();
  var kd_kategori = $('#kd_kategori').val();
  var idkelas = $('#idkelas').val();

  if ($.trim(idmata_pelajaran)==''){
    showToast('Silahkan pilih mata pelajaran !',1000,'error');
    $(".error-message1").append('<div class="font-italic text-danger" id="error-message1"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(kd_kode)==''){
    showToast('Kode Kompetensi dasar tidak boleh kosong !',1000,'error');
    $(".error-message2").append('<div class="font-italic text-danger" id="error-message2"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(kd_nama)==''){
    showToast('Nama Kompetensi dasar tidak boleh kosong !',1000,'error');
    $(".error-message3").append('<div class="font-italic text-danger" id="error-message3"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(kd_kategori)==''){
    showToast('Kategori dasar tidak boleh kosong !',1000,'error');
    $(".error-message4").append('<div class="font-italic text-danger" id="error-message4"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(idkelas)==''){
    showToast('Kelas tidak boleh kosong !',1000,'error');
    $(".error-message5").append('<div class="font-italic text-danger" id="error-message5"><small>* silahkan isi sesuai format yang diminta</small></div>');
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
}

$(document).ready(function(){
  fDatatables("tKompetensi","<?=base_url('guru/Kompetensi_dasar/ajax_list')?>","ASC");

  $("#idmata_pelajaran").on("change", function( ) {
    removeErrorMessages();
    $('#divKompetensi').fadeIn();
    var idmata_pelajaran = $(this).val();
    $('#_idmata_pelajaran').val(idmata_pelajaran);

    fDatatables("tKompetensi","<?=base_url('guru/Kompetensi_dasar/ajax_list/')?>"+idmata_pelajaran,"ASC");
  });

  $("#f_kompetensi").on("submit", function(e) {
    e.preventDefault();
    removeErrorMessages();
    if(formValidation()){
      $('#btn-save').prop('disabled',true);
      var data    = $(this).serialize();
      var idmata_pelajaran = $('#idmata_pelajaran').val();
      $.ajax({
          type: "POST",
          data: data,
          url: base_url+"Kompetensi_dasar/save",
          success: function(r) {
              if (r.status == "gagal") {
                  showToast('Data gagal disimpan !',1000,'error');
              } else if (r.status == "ok") {
                  $("#modal_data_kompetensi").modal('hide');
                  showToast('Data berhasil disimpan !',1000,'success');
                  fDatatables("tKompetensi","<?=base_url('guru/Kompetensi_dasar/ajax_list/')?>"+idmata_pelajaran,"ASC");
              } else if (r.status == "exist"){
                  showToast('Sudah ada guru yang mengampu mata pelajaran untuk kelas ini !',3000,'warning');
                  $('#modal_data_kompetensi').modal('hide');
              } else {
                  showToast('Data sudah ada !',1000,'warning');
                  $('#modal_data_kompetensi').modal('hide');
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
  $('#modal_data_kompetensi').modal('show');
  $.ajax({
      type: "GET",
      url: base_url+"Kompetensi_dasar/edit/"+id,
      success: function(result) {
          $("#_id").val(result.data.idkompetensi_dasar);
          $("#idkelas").val(result.data.idkelas);
          $("#kd_kategori").val(result.data.kd_kategori);
          $("#kd_kode").val(result.data.kd_kode);
          $("#kd_nama").val(result.data.kd_nama);
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
        var idmata_pelajaran = $('#idmata_pelajaran').val();
        $.ajax({
        type: "GET",
        url: base_url+"Kompetensi_dasar/delete/"+id,
        success: function(r) {
          if (r.status == 'ok'){
            swal("Dihapus", "Data berhasil dihapus", "success");
            fDatatables("tKompetensi","<?=base_url('guru/Kompetensi_dasar/ajax_list/')?>"+idmata_pelajaran,"ASC");
          } else {
            swal("Gagal", "Data gagal dihapus karena ada data yang sedang terhubung dengan data ini, silahkan minta administrator untuk aktifkan 'Penghapusan Tanpa Validasi' pada pengaturan website jika ingin tetap menghapus data ini dengan resiko seluruh data terhubung juga akan terhapus", "error");
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

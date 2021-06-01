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
                  Data Mata Pelajaran
                </h3>
                <a onclick="return edit(0)" class="btn btn-info" style="color:#FFF; float:right;">(+) Tambah Mata Pelajaran</a>
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
                <table id="tMatapelajaran" class="table table-bordered table-striped">
                  <thead style="background-color:#17a2b8; color:#fff;">
                  <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelompok</th>
                    <th>Urutan</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>

                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelompok</th>
                    <th>Urutan</th>
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
  <div class="modal fade" id="modal_data_mapel" data-backdrop="static">
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
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Mata Pelajaran <span class="error-tab1"></span></a>
                    </li>
                  </ul>
                </div>
                <form class="form-horizontal" method="post" id="f_mata_pelajaran" name="f_mata_pelajaran">
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <div class="card-body">
                        <div class="form-group">
                          <!-- -->
                          <input type="hidden" name="_id" id="_id" value="">
                          <input type="hidden" name="_mode" id="_mode" value="">
                          <!-- -->
                          <label for="mp_kode">Kode Mata Pelajaran</label>
                          <div class="error-message1"></div>
                          <input type="text" name="mp_kode" class="form-control" id="mp_kode" placeholder="Kode" value="" required>
                        </div>
                        <div class="form-group">
                          <label for="mp_nama">Nama Mata Pelajaran</label>
                          <div class="error-message2"></div>
                          <input type="text" name="mp_nama" class="form-control" id="mp_nama" placeholder="Nama" value="" required>
                        </div>
                        <div class="form-group">
                          <label for="mp_kelompok">Kelompok</label>
                          <div class="error-message3"></div>
                          <?=form_dropdown('',$list_kelompok,'',$list_kelompok_attribute)?>
                        </div>
                        <div class="form-group">
                          <label for="mp_urutan">Urutan Rapor</label>
                          <div class="error-message4"></div>
                          <input type="number" name="mp_urutan" class="form-control" id="mp_urutan" placeholder="Urutan" value="" required>
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
  var mp_kode = $('#mp_kode').val();
  var mp_nama = $('#mp_nama').val();
  var mp_kelompok = $('#list_kelompok').val();
  var mp_urutan = $('#mp_urutan').val();

  if ($.trim(mp_kode)==''){
    showToast('Kode mata pelajaran tidak boleh kosong !',1000,'error');
    $(".error-message1").append('<div class="font-italic text-danger" id="error-message1"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(mp_nama)==''){
    showToast('Nama mata pelajaran tidak boleh kosong !',1000,'error');
    $(".error-message2").append('<div class="font-italic text-danger" id="error-message2"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(mp_kelompok)==''){
    showToast('Kelompok mata pelajaran tidak boleh kosong !',1000,'error');
    $(".error-message3").append('<div class="font-italic text-danger" id="error-message3"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(mp_urutan)==''){
    showToast('Urutan rapor mata pelajaran tidak boleh kosong !',1000,'error');
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
  fDatatables("tMatapelajaran","<?=base_url('administrator/Mata_pelajaran/ajax_list')?>","DESC");

  $("#f_mata_pelajaran").on("submit", function(e) {
    e.preventDefault();
    removeErrorMessages();
    if(formValidation()){
      $('#btn-save').prop('disabled',true);
      var data = $(this).serialize();
      $.ajax({
          type: "POST",
          data: data,
          url: base_url+"Mata_pelajaran/save",
          success: function(r) {
              if (r.status == "gagal") {
                  showToast('Data gagal disimpan !',1000,'error');
              } else if (r.status == "ok") {
                  $("#modal_data_mapel").modal('hide');
                  showToast('Data berhasil disimpan !',1000,'success');
                  fDatatables("tMatapelajaran","<?=base_url('administrator/Mata_pelajaran/ajax_list')?>","DESC");
              } else {
                  showToast('Data sudah ada !',1000,'warning');
                  $("#modal_data_mapel").modal('hide');
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
  $('#modal_data_mapel').modal('show');
  $.ajax({
      type: "GET",
      url: base_url+"Mata_pelajaran/edit/"+id,
      success: function(result) {
          $("#_id").val(result.data.idmata_pelajaran);
          $("#mp_kode").val(result.data.mp_kode);
          $("#mp_nama").val(result.data.mp_nama);
          $("#list_kelompok").val(result.data.mp_kelompok);
          $("#mp_urutan").val(result.data.mp_urutan);
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
        $.ajax({
        type: "GET",
        url: base_url+"Mata_pelajaran/delete/"+id,
        success: function(r) {
          if (r.status == 'ok'){
            swal("Dihapus", "Data berhasil dihapus", "success");
            fDatatables("tMatapelajaran","<?=base_url('administrator/Mata_pelajaran/ajax_list')?>","DESC");
          } else {
            swal("Gagal", "Data gagal dihapus karena ada data yang sedang terhubung dengan data ini, silahkan aktifkan 'Penghapusan Tanpa Validasi' pada pengaturan website jika ingin tetap menghapus data ini dengan resiko seluruh data terhubung juga akan terhapus", "error");
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

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
                  Data KKM Satuan Pendidikan
                </h3>
                <a onclick="return edit(0)" class="btn btn-info" style="color:#FFF; float:right;">(+) Tambah KKM</a>
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
                <table id="tKkm" class="table table-bordered table-striped">
                  <thead style="background-color:#17a2b8; color:#fff;">
                  <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Mata Pelajaran</th>
                    <th>KKM</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>

                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Mata Pelajaran</th>
                    <th>KKM</th>
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
  <div class="modal fade" id="modal_data_kkm" data-backdrop="static">
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
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">KKM Satuan Pendidikan <span class="error-tab1"></span></a>
                    </li>
                  </ul>
                </div>
                <form class="form-horizontal" method="post" id="f_kkm" name="f_kkm">
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <div class="card-body">
                        <div class="form-group">
                          <!-- -->
                          <input type="hidden" name="_id" id="_id" value="">
                          <input type="hidden" name="_mode" id="_mode" value="">
                          <!-- -->
                          <label for="idkelas">Kelas</label>
                          <div class="error-message1"></div>
                          <?=form_dropdown('',$list_kelas,'',$list_kelas_attribute)?>
                        </div>
                        <div class="form-group">
                          <label for="idmata_pelajaran">Mata Pelajaran</label>
                          <div class="error-message2"></div>
                          <?=form_dropdown('',$list_mapel,'',$list_mapel_attribute)?>
                        </div>
                        <div class="form-group">
                          <label for="k_kkm">KKM</label>
                          <div class="error-message3"></div>
                          <input type="number" name="k_kkm" class="form-control" id="k_kkm" placeholder="" value="" required>
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
  var idkelas = $('#idkelas').val();
  var idmata_pelajaran = $('#idmata_pelajaran').val();
  var k_kkm = $('#k_kkm').val();

  if ($.trim(idkelas)==''){
    showToast('Kelas tidak boleh kosong !',1000,'error');
    $(".error-message1").append('<div class="font-italic text-danger" id="error-message1"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(idmata_pelajaran)==''){
    showToast('Mata pelajaran tidak boleh kosong !',1000,'error');
    $(".error-message2").append('<div class="font-italic text-danger" id="error-message2"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(k_kkm)=='' || $.trim(k_kkm)<=0){
    showToast('KKM tidak boleh kosong !',1000,'error');
    $(".error-message3").append('<div class="font-italic text-danger" id="error-message3"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else {
    return true;
  }
}

function removeErrorMessages()
{
  $("#error-message1").remove();
  $("#error-message2").remove();
  $("#error-message3").remove();
}

$(document).ready(function(){
  fDatatables("tKkm","<?=base_url('administrator/Kkm/ajax_list')?>","ASC");

  $("#f_kkm").on("submit", function(e) {
    e.preventDefault();
    removeErrorMessages();
    if(formValidation()){
      $('#btn-save').prop('disabled',true);
      var data    = $(this).serialize();
      $.ajax({
          type: "POST",
          data: data,
          url: base_url+"Kkm/save",
          success: function(r) {
              if (r.status == "gagal") {
                  showToast('Data gagal disimpan !',1000,'error');
                  $('#modal_data_kkm').modal('hide');
              } else if (r.status == "ok") {
                  $("#modal_data_kkm").modal('hide');
                  showToast('Data berhasil disimpan !',1000,'success');
                  fDatatables("tKkm","<?=base_url('administrator/Kkm/ajax_list')?>","ASC");
              } else {
                  showToast('Data sudah ada !',1000,'warning');
                  $('#modal_data_kkm').modal('hide');
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
  $('#modal_data_kkm').modal('show');
  $.ajax({
      type: "GET",
      url: base_url+"Kkm/edit/"+id,
      success: function(result) {
          $("#_id").val(result.data.idkkm);
          $("#idkelas").val(result.data.idkelas);
          $("#idmata_pelajaran").val(result.data.idmata_pelajaran);
          $("#k_kkm").val(result.data.k_kkm);
          $('#btn-save').prop('disabled',false);
      }
  });
  return false;
}

function delete_data(id,data,kelas) {
  if (id == 0) {
    showToast('Silahkan pilih data yang akan dihapus !',1000,'error');
  }
  swal({
      title: "Lanjut menghapus ..?",
      text: "Apakah anda yakin akan menghapus data "+data+" kelas "+kelas+" ? Data yang telah dihapus tidak dapat dikembalikan",
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
        url: base_url+"Kkm/delete/"+id,
        success: function(r) {
          if (r.status == 'ok'){
            swal("Dihapus", "Data berhasil dihapus", "success");
            fDatatables("tKkm","<?=base_url('administrator/Kkm/ajax_list')?>","ASC");
          } else {
            swal("Gagal", "Data gagal dihapus karena KKM digunakan untuk menentukan predikat nilai rapor siswa dan terhubung ke Interval Predikat, silahkan aktifkan fitur 'Penghapusan Tanpa Validasi' pada pengaturan website apabila tetap ingin menghapus data dengan resiko seluruh data yang terhubung dengan data ini juga akan ikut terhapus", "error");
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

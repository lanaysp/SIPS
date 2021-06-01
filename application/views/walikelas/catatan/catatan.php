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
                  Input Catatan Wali Kelas
                </h3>
                <a onclick="return edit(0)" class="btn btn-info" style="color:#FFF; float:right;">(+) Tambah Data Catatan</a>
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
                <table id="tCatatan" class="table table-bordered table-striped table-hover">
                  <thead style="background-color:#17a2b8; color:#fff;">
                  <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Nama</th>
                    <th>Catatan</th>
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
                    <th>Catatan</th>
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
  <div class="modal fade" id="modal_data_catatan" data-backdrop="static">
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
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Catatan <span class="error-tab1"></span></a>
                    </li>
                  </ul>
                </div>
                <form class="form-horizontal" method="post" id="f_catatan" name="f_catatan">
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <div class="card-body">
                        <div class="form-group">
                          <!-- -->
                          <input type="hidden" name="_id" id="_id" value="">
                          <input type="hidden" name="_mode" id="_mode" value="">
                          <!-- -->
                          <label for="idsiswa">Siswa</label>
                          <div class="error-message1"></div>
                          <?=form_dropdown('',$list_siswa,'',$list_siswa_attribute)?>
                        </div>
                        <div class="form-group">
                          <label for="catatan">catatan</label>
                          <div class="error-message2"></div>
                          <textarea class="form-control" name="catatan" id="catatan" required placeholder="Catatan anda"></textarea>
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
  var idsiswa = $('#idsiswa').val();
  var catatan = $('#catatan').val();

  if ($.trim(idsiswa)==''){
    showToast('Siswa tidak boleh kosong !',1000,'error');
    $(".error-message1").append('<div class="font-italic text-danger" id="error-message1"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(catatan)==''){
    showToast('Catatan tidak boleh kosong !',1000,'error');
    $(".error-message2").append('<div class="font-italic text-danger" id="error-message2"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else {
    return true;
  }
}

function removeErrorMessages()
{
  $("#error-message1").remove();
  $("#error-message2").remove();
}

$(document).ready(function(){
  fDatatables("tCatatan","<?=base_url('walikelas/Catatan/ajax_list')?>","ASC");

  $('.select2bs4').select2({
    theme: 'bootstrap4'
  });

  $("#modal_data_catatan").on('hide.bs.modal', function () {
    $("#f_catatan")[0].reset();
    $("#idsiswa").trigger('change.select2');
  });

  $("#f_catatan").on("submit", function(e) {
    e.preventDefault();
    removeErrorMessages();
    if(formValidation()){
      $('#btn-save').prop('disabled',true);
      var data    = $(this).serialize();
      $.ajax({
          type: "POST",
          data: data,
          url: base_url+"Catatan/save",
          success: function(r) {
              if (r.status == "gagal") {
                  showToast('Data gagal disimpan !',1000,'error');
              } else if (r.status == "ok") {
                  $("#modal_data_catatan").modal('hide');
                  showToast('Data berhasil disimpan !',1000,'success');
                  fDatatables("tCatatan","<?=base_url('walikelas/Catatan/ajax_list')?>","ASC");
              } else {
                  showToast('Data sudah ada !',1000,'warning');
                  $('#modal_data_catatan').modal('hide');
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
  $('#modal_data_catatan').modal('show');
  $.ajax({
      type: "GET",
      url: base_url+"Catatan/edit/"+id,
      success: function(result) {
          $("#_id").val(result.data.idcatatan);
          $("#catatan").val(result.data.catatan);
          $("#idsiswa").val(result.data.idsiswa).trigger('change');
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
      title: "Lanjut hapus ..?",
      text: "Apakah anda yakin ingin menghapus catatan siswa "+data+"..? [PENTING] Data yang telah dihapus tidak dapat dikembalikan",
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
        url: base_url+"Catatan/delete/"+id+"/"+data,
        success: function(r) {
          if (r.status == 'ok'){
            showToast('Data berhasil dihapus !',1000,'success');
            fDatatables("tCatatan","<?=base_url('walikelas/Catatan/ajax_list')?>","ASC");
          } else {
            showToast('Data gagal dihapus !',1000,'error');
          }
        }
        });
        return false;
      } else {
        swal("Dibatalkan", "Hapus data dibatalkan", "error");
      }
    })
}

</script>

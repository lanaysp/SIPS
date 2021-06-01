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
                  Data Butir Sikap
                </h3>
                <a onclick="return edit(0)" class="btn btn-info" style="color:#FFF; float:right;">(+) Tambah Butir Sikap</a>
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
                <table id="tButir" class="table table-bordered table-striped">
                  <thead style="background-color:#17a2b8; color:#fff;">
                  <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Kode</th>
                    <th>Butir Sikap</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>

                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Kode</th>
                    <th>Butir Sikap</th>
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
  <div class="modal fade" id="modal_data_butir" data-backdrop="static">
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
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Butir Sikap <span class="error-tab1"></span></a>
                    </li>
                  </ul>
                </div>
                <form class="form-horizontal" method="post" id="f_butir" name="f_butir">
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <div class="card-body">
                        <div class="form-group">
                          <!-- -->
                          <input type="hidden" name="_id" id="_id" value="">
                          <input type="hidden" name="_mode" id="_mode" value="">
                          <!-- -->
                          <label for="bs_kategori">Kategori</label>
                          <div class="error-message1"></div>
                          <select class="form-control" name="bs_kategori" id="bs_kategori" required>
                            <option value="" hidden>- Pilih Kategori -</option>
                            <option value="Spiritual">Spiritual</option>
                            <option value="Sosial">Sosial</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="bs_keteranga">Indikator/Kode</label>
                          <div class="error-message2"></div>
                          <input type="text" name="bs_kode" class="form-control" id="bs_kode" placeholder="" value="" required>
                        </div>
                        <div class="form-group">
                          <label for="bs_keterangan">Butir Sikap</label>
                          <div class="error-message3"></div>
                          <input type="text" name="bs_keterangan" class="form-control" id="bs_keterangan" placeholder="" value="" required>
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
  var bs_kategori = $('#bs_kategori').val();
  var bs_kode = $('#bs_kode').val();
  var bs_keterangan = $('#bs_keterangan').val();

  if ($.trim(bs_kategori)==''){
    showToast('Kategori tidak boleh kosong !',1000,'error');
    $(".error-message1").append('<div class="font-italic text-danger" id="error-message1"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(bs_kode)==''){
    showToast('Indikator/Kode tidak boleh kosong !',1000,'error');
    $(".error-message2").append('<div class="font-italic text-danger" id="error-message2"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(bs_keterangan)==''){
    showToast('Keterangan tidak boleh kosong !',1000,'error');
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
  fDatatables("tButir","<?=base_url('administrator/Butir_sikap/ajax_list')?>","DESC");

  $("#f_butir").on("submit", function(e) {
    e.preventDefault();
    removeErrorMessages();
    if(formValidation()){
      $('#btn-save').prop('disabled',true);
      var data    = $(this).serialize();
      $.ajax({
          type: "POST",
          data: data,
          url: base_url+"Butir_sikap/save",
          success: function(r) {
              if (r.status == "gagal") {
                  showToast('Data gagal disimpan !',1000,'error');
              } else if (r.status == "ok") {
                  $("#modal_data_butir").modal('hide');
                  showToast('Data berhasil disimpan !',1000,'success');
                  fDatatables("tButir","<?=base_url('administrator/Butir_sikap/ajax_list')?>","DESC");
              } else {
                  showToast('Data sudah ada !',1000,'warning');
                  $('#modal_data_butir').modal('hide');
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
  $('#modal_data_butir').modal('show');
  $.ajax({
      type: "GET",
      url: base_url+"Butir_sikap/edit/"+id,
      success: function(result) {
          $("#_id").val(result.data.idbutir_sikap);
          $("#bs_kategori").val(result.data.bs_kategori);
          $("#bs_kode").val(result.data.bs_kode);
          $("#bs_keterangan").val(result.data.bs_keterangan);
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
      text: "Apakah anda yakin akan menghapus data "+data+" ? [PERINGATAN] Apabila mode 'Penghapusan Tanpa Validasi' aktif maka seluruh data penilaian, perencanaan terhadap nilai sikap siswa juga akan ikut terhapus, data yang telah dihapus tidak dapat dikembalikan, silahkan non aktifkan mode 'Penghapusan Tanpa Validasi' terlebih dahulu jika anda hanya ingin menghapus satu data tanpa menghapus data yang terhubung",
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
        url: base_url+"Butir_sikap/delete/"+id,
        success: function(r) {
          if (r.status == 'ok'){
            swal("Dihapus", "Data berhasil dihapus", "success");
            fDatatables("tButir","<?=base_url('administrator/Butir_sikap/ajax_list')?>","DESC");
          } else {
            swal("Gagal", "Data gagal dihapus karena data butir sikap digunakan untuk melakukan penilaian sikap spiritual dan sosial siswa juga perencanaaan terhadap penilaian sikap, jika ingin tetap menghapus silahkan aktifkan 'Penghapusan Tanpa Validasi' pada pengaturan website, namun hati-hati apabila anda telah mengaktifkan fitur ini, silahkan matikan kembali jika sudah selesai", "error");
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

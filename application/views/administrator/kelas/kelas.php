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
                  Data Kelas <i data-toggle="modal" data-target="#modal_info" class='fas fa-info-circle'></i>
                </h3>
                <a onclick="return edit(0)" class="btn btn-info" style="color:#FFF; float:right;">(+) Tambah Kelas</a>
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
                <table id="tKelas" class="table table-bordered table-striped">
                  <thead style="background-color:#17a2b8; color:#fff;">
                  <tr>
                    <th>No</th>
                    <th>Wali Kelas</th>
                    <th>Tingkat</th>
                    <th>Romawi</th>
                    <th>Keterangan</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>

                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Wali Kelas</th>
                    <th>Tingkat</th>
                    <th>Romawi</th>
                    <th>Keterangan</th>
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
  <div class="modal fade" id="modal_data_kelas" data-backdrop="static">
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
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Kelas <span class="error-tab1"></span></a>
                    </li>
                  </ul>
                </div>
                <form class="form-horizontal" method="post" id="f_kelas" name="f_kelas">
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <div class="card-body">
                        <div class="form-group">
                          <!-- -->
                          <input type="hidden" name="_id" id="_id" value="">
                          <input type="hidden" name="_mode" id="_mode" value="">
                          <!-- -->
                          <label for="idmata_pelajaran">Wali Kelas</label>
                          <div class="error-message1"></div>
                          <?=form_dropdown('',$list_users,'',$list_users_attribute)?>
                        </div>
                        <div class="form-group">
                          <label for="k_tingkat">Tingkat</label>
                          <div class="error-message2"></div>
                          <input type="number" name="k_tingkat" class="form-control" id="k_tingkat" placeholder="" value="" required>
                        </div>
                        <div class="form-group">
                          <label for="k_romawi">Romawi</label>
                          <div class="error-message3"></div>
                          <input type="text" name="k_romawi" class="form-control" id="k_romawi" placeholder="" value="" required>
                        </div>
                        <div class="form-group">
                          <label for="k_keterangan">Keterangan</label>
                          <div class="error-message4"></div>
                          <input type="text" name="k_keterangan" class="form-control" id="k_keterangan" placeholder="" value="" required>
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
    </div>
  </div>

  <div class="modal fade" id="modal_info">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#293D55; color:white;">
          <h6 class="modal-title">[Info]</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>
            Data kelas terhubung dengan beberapa data dibawah ini, jika ingin menghapus salah satu data yang ada, pastikan seluruh data pada kategori dibawah ini tidak ada satupun yang menggunakan data tersebut.
            Hal ini bertujuan untuk mencegah hilangnya data secara massal jika validasi penghapusan tidak dilakukan dan tanpa/dengan sengaja menghapus suatu data.
            <br/> Namun jika anda tetap ingin menghapus data secara paksa, silahkan aktifkan 'Penghapusan Tanpa Validasi' pada pengaturan website, namun hal ini tidak disarankan karena sebaiknya data tidak dihapus untuk dijadikan arsip.
          </p>
          <p>
            1. Data kelas yang diampu guru.<br/>
            2. Data pengaturan kompetensi dasar berdasarkan kelas.<br/>
            3. Data pengaturan KKM satuan pendidikan berdasarkan kelas.<br/>
            4. Data nilai keterampilan berdasarkan kelas.<br/>
            5. Data nilai pengetahuan berdasarkan kelas.<br/>
            6. Data nilai PTS dan PAS pengetahuan berdasarkan kelas.<br/>
            7. Data nilai sikap spiritual berdasarkan kelas.<br/>
            8. Data nilai sikap sosial berdasarkan kelas.<br/>
            9. Data deskripsi nilai sikap spiritual berdasarkan kelas.<br/>
            10. Data deskripsi nilai sikap sosial berdasarkan kelas.<br/>
            11. Data deskripsi nilai keterampilan berdasarkan kelas.<br/>
            12. Data deskripsi nilai pengetahuan berdasarkan kelas.<br/>
            13. Data rencana butir sikap spiritual berdasarkan kelas.<br/>
            14. Data rencana butir sikap sosial berdasarkan kelas.<br/>
            15. Data rencana KD keterampilan berdasarkan kelas.<br/>
            16. Data rencana KD pengetahuan berdasarkan kelas.<br/>
            17. Data siswa berdasarkan kelas.<br/>
            18. Data siswa yang diampu walikelas berdasarkan kelas.<br/>
          </p>
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript">
function formValidation()
{
  var idusers = $('#idusers').val();
  var k_tingkat = $('#k_tingkat').val();
  var k_romawi = $('#k_romawi').val();
  var k_keterangan = $('#k_keterangan').val();

  if ($.trim(idusers)==''){
    showToast('Wali kelas tidak boleh kosong !',1000,'error');
    $(".error-message1").append('<div class="font-italic text-danger" id="error-message1"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(k_tingkat)=='' || k_tingkat<=0 || k_tingkat==9999){
    showToast('Tingkat kelas tidak boleh kosong atau kurang dari 1 !',1000,'error');
    $(".error-message2").append('<div class="font-italic text-danger" id="error-message2"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(k_romawi)=='' || $.trim(k_romawi)=='LULUS'){
    showToast('Angka romawi kelas tidak boleh kosong atau kurang dari 1 !',1000,'error');
    $(".error-message3").append('<div class="font-italic text-danger" id="error-message3"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if ($.trim(k_keterangan)=='' || $.trim(k_keterangan)=='LULUS'){
    showToast('Keterangan kelas tidak boleh kosong atau kurang dari 1 !',1000,'error');
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
  fDatatables("tKelas","<?=base_url('administrator/Kelas/ajax_list')?>","ASC");

  $("#f_kelas").on("submit", function(e) {
    e.preventDefault();
    removeErrorMessages();
    if(formValidation()){
      $('#btn-save').prop('disabled',true);
      var data    = $(this).serialize();
      $.ajax({
          type: "POST",
          data: data,
          url: base_url+"Kelas/save",
          success: function(r) {
              if (r.status == "gagal") {
                  showToast('Data gagal disimpan !',1000,'error');
              } else if (r.status == "ok") {
                  $("#modal_data_kelas").modal('hide');
                  showToast('Data berhasil disimpan !',1000,'success');
                  fDatatables("tKelas","<?=base_url('administrator/Kelas/ajax_list')?>","ASC");
              } else {
                  showToast('Data sudah ada !',1000,'warning');
                  $('#modal_data_kelas').modal('hide');
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
  $('#modal_data_kelas').modal('show');
  $.ajax({
      type: "GET",
      url: base_url+"Kelas/edit/"+id,
      success: function(result) {
          $("#_id").val(result.data.idkelas);
          $("#idusers").val(result.data.idusers);
          $("#k_tingkat").val(result.data.k_tingkat);
          $("#k_romawi").val(result.data.k_romawi);
          $("#k_keterangan").val(result.data.k_keterangan);
          $('#btn-save').prop('disabled',false);
          if (result.data.k_keterangan=='LULUS' || result.data.k_keterangan=='PINDAH'){
            $("#k_tingkat").prop('readonly',true);
            $("#k_romawi").prop('readonly',true);
            $("#k_keterangan").prop('readonly',true);
          } else {
            $("#k_tingkat").prop('readonly',false);
            $("#k_romawi").prop('readonly',false);
            $("#k_keterangan").prop('readonly',false);
          }
      }
  });
  return false;
}

function delete_data(id,data,wali) {
  if (id == 0) {
    showToast('Silahkan pilih data yang akan dihapus !',1000,'error');
  }
  swal({
      title: "Lanjut menghapus ..?",
      text: "Apakah anda yakin akan menghapus data "+data+" dengan wali "+wali+" ? Data yang telah dihapus tidak dapat dikembalikan",
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
          url: base_url+"Kelas/delete/"+id,
          success: function(r) {
            if (r.status == 'ok'){
              swal("Dihapus", "Data berhasil dihapus", "success");
              fDatatables("tKelas","<?=base_url('administrator/Kelas/ajax_list')?>","ASC");
            } else {
              swal("Gagal", "Data gagal dihapus karena ada data yang sedang terhubung atau memakai kelas ini, silahkan klik logo info disebelah label Data Kelas untuk melihat info data yang terhubung dengan data ini", "error");
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

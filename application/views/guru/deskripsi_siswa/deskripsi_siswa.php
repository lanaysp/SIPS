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
                  Proses Deskripsi Siswa
                </h3>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
        <div class="row">
          <div class="col-12">
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
                <tr>
                  <td style="vertical-align:middle;">Mata Pelajaran</td>
                  <td>
                    <div class="error-message2"></div>
                    <?=form_dropdown('',$list_mapel,'',$list_mapel_attribute)?>
                  </td>
                </tr>
              </tbody>
            </table>
            </div><br/>
            <!-- /.card -->
            <div class="card" id="divDeskripsi" style="display:none;">
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="tDeskripsi" class="table table-bordered table-striped">
                  <thead style="background-color:#17a2b8; color:#fff;">
                  <tr>
                    <th rowspan="2" width="3%" style="vertical-align:middle;"><center>No</center></th>
                    <th rowspan="2" width="30%" style="vertical-align:middle;"><center>Nama Siswa</center></th>
                    <th colspan="3"><center>Pengetahuan <br/><small><i>(2*Rata-rata seluruh nilai tiap KD + UTS + UAS)/4</i></small></center></th>
                    <th colspan="3"><center>Keterampilan <br/><small><i>Rata-rata seluruh nilai tiap KD</i></small></center></th>
                  </tr>
                  <tr>
                    <th width="5%">Angka</th>
                    <th width="5%">Predikat</th>
                    <th width="25%">Deskripsi</th>
                    <th width="5%">Angka</th>
                    <th width="5%">Predikat</th>
                    <th width="25%">Deskripsi</th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>
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

  <div class="modal fade" id="modal_edit_deskripsi" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#293D55; color:white;">
          <h6 class="modal-title">[Lengkapi Deskripsi]</h6>
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
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Deskripsi <span class="error-tab1"></span></a>
                    </li>
                  </ul>
                </div>
                <form class="form-horizontal" name="f_deskripsi" id="f_deskripsi">
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <div class="card-body">
                        <div class="form-group">
                          <label for="deskripsi">Deskripsi</label>
                          <div class="error-message1"></div>
                          <input type="hidden" name="iddeskripsi" class="form-control" id="iddeskripsi">
                          <input type="hidden" name="idsiswa" class="form-control" id="idsiswa">
                          <input type="hidden" name="tipe_deskripsi" class="form-control" id="tipe_deskripsi">
                          <input type="text" name="deskripsi" class="form-control" id="deskripsi" required>
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
function edit_deskripsi(id,deskripsi,idsiswa,tipe)
{
  $('#modal_edit_deskripsi').modal('show');
  $('#iddeskripsi').val(id);
  $('#deskripsi').val(deskripsi);
  $('#idsiswa').val(idsiswa);
  if (tipe=='pengetahuan')
  {
    $('#tipe_deskripsi').val('pengetahuan');
  } else if (tipe=='keterampilan') {
    $('#tipe_deskripsi').val('keterampilan');
  }
}

function formValidation()
{
  var idkelas = $('#idkelas').val();
  var idmata_pelajaran = $('#idmata_pelajaran').val();

  if ($.trim(idkelas)==''){
    showToast('Silahkan pilih kelas !',1000,'error');
    $(".error-message1").append('<div class="font-italic text-danger" id="error-message1"><small>* silahkan isi sesuai format yang diminta</small></div>');
    $('#jumlah_ph').val('');
  } else if ($.trim(idmata_pelajaran)==''){
    showToast('Silahkan pilih mata pelajaran !',1000,'error');
    $(".error-message2").append('<div class="font-italic text-danger" id="error-message2"><small>* silahkan isi sesuai format yang diminta</small></div>');
    $('#jumlah_ph').val('');
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
  $("#idkelas").on("change", function( ) {
    $('#idmata_pelajaran').val('');
    $('#divDeskripsi').fadeOut();
  });

  $("#idmata_pelajaran").on("change", function( ) {
    removeErrorMessages();
    if(formValidation()){
      var idkelas = $('#idkelas').val();
      var idmata_pelajaran = $('#idmata_pelajaran').val();

      $('#divDeskripsi').fadeIn();
      fDatatables("tDeskripsi","<?=base_url('guru/Deskripsi_siswa/ajax_list/')?>"+idkelas+"/"+idmata_pelajaran,"ASC");
      return false;
    };
  });

  $(document).delegate("#nilai_harian","change",function( ) {
    var nilai = $(this).val();
    if (nilai<0){
      showToast('Nilai tidak boleh min (kurang dari 0)',2000,'warning');
      $(this).val(0);
    } else if (nilai>100){
      showToast('Nilai tidak boleh lebih dari 100',2000,'warning');
      $(this).val(0);
    }
  });

  $("#btn-save").on("click", function(e) {
    e.preventDefault();
    var idkelas = $('#idkelas').val();
    var idmata_pelajaran = $('#idmata_pelajaran').val();
    var iddeskripsi = $('#iddeskripsi').val();
    var tipe_deskripsi = $('#tipe_deskripsi').val();
    var deskripsi = $('#deskripsi').val();
    var idsiswa = $('#idsiswa').val();
      $.ajax({
          type: "POST",
          data: {iddeskripsi:iddeskripsi,tipe_deskripsi:tipe_deskripsi,deskripsi:deskripsi,idsiswa:idsiswa,idmata_pelajaran:idmata_pelajaran,idkelas:idkelas},
          url: base_url+"Deskripsi_siswa/update_deskripsi",
          success: function(r) {
            if (r.status=='ok')
            {
              $('#modal_edit_deskripsi').modal('hide');
              fDatatables("tDeskripsi","<?=base_url('guru/Deskripsi_siswa/ajax_list/')?>"+idkelas+"/"+idmata_pelajaran,"ASC");
              showToast('Deskripsi berhasil dilengkapi !',2000,'success');
            } else {
              $('#modal_edit_deskripsi').modal('hide');
              showToast('Deskripsi gagal dilengkapi !',2000,'error');
            }
            
          }
      });
  });

})

</script>

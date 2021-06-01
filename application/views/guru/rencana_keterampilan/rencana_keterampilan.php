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
                  Rencana Nilai Keterampilan
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
                <tr>
                  <td style="vertical-align:middle;">Jumlah Penilaian Harian (PH)</td>
                  <td>
                    <div class="error-message3"></div>
                    <?=form_dropdown('',$list_ph,'',$list_ph_attribute)?>
                  </td>
                </tr>
              </tbody>
            </table>
            </div><br/>
            <!-- /.card -->
            <div class="card" id="divKeterampilan" style="display:none;">
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="tKeterampilan" class="table table-bordered table-striped">
                  <thead style="background-color:#17a2b8; color:#fff;">
                  <tr>
                    <th>No</th>
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

<script type="text/javascript">
function formValidation()
{
  var idkelas = $('#idkelas').val();
  var idmata_pelajaran = $('#idmata_pelajaran').val();
  var jumlah_ph = $('#jumlah_ph').val();

  if ($.trim(idkelas)==''){
    showToast('Silahkan pilih kelas !',1000,'error');
    $(".error-message1").append('<div class="font-italic text-danger" id="error-message1"><small>* silahkan isi sesuai format yang diminta</small></div>');
    $('#jumlah_ph').val('');
  } else if ($.trim(idmata_pelajaran)==''){
    showToast('Silahkan pilih mata pelajaran !',1000,'error');
    $(".error-message2").append('<div class="font-italic text-danger" id="error-message2"><small>* silahkan isi sesuai format yang diminta</small></div>');
    $('#jumlah_ph').val('');
  } else if ($.trim(jumlah_ph)==''){
    showToast('Silahkan pilih jumlah penilaian harian !',1000,'error');
    $(".error-message3").append('<div class="font-italic text-danger" id="error-message3"><small>* silahkan isi sesuai format yang diminta</small></div>');
    $('#jumlah_ph').val('');
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
  $("#idkelas").on("change", function( ) {
    $('#idmata_pelajaran').val('');
    $('#jumlah_ph').val('');
    $('#divKeterampilan').fadeOut();
  });

  $("#idmata_pelajaran").on("change", function( ) {
    removeErrorMessages();
    var idkelas = $('#idkelas').val();
    var idmata_pelajaran = $(this).val();

    $.ajax({
        type: "POST",
        data: {idkelas:idkelas,idmata_pelajaran:idmata_pelajaran},
        url: base_url+"Rencana_keterampilan/check_ph",
        success: function(r) {
            if (r.status == "y") {
              $('#jumlah_ph').val(r.data.rkdk_penilaian_harian);
              $('#divKeterampilan').fadeIn();
              fDatatables("tKeterampilan","<?=base_url('guru/Rencana_keterampilan/ajax_list/')?>"+idmata_pelajaran+"/"+idkelas,"ASC");
            } else if (r.status == "n") {
              $('#jumlah_ph').val(r.data.rkdk_penilaian_harian);
              $('#divKeterampilan').fadeOut();
            }
        }
    });
    return false;
  });

  $("#jumlah_ph").on("change", function( ) {
    removeErrorMessages();
    if(formValidation()){
      $('#divKeterampilan').fadeIn();
      var idkelas = $('#idkelas').val();
      var idmata_pelajaran = $('#idmata_pelajaran').val();
      var jumlah_ph = $('#jumlah_ph').val();

      $.ajax({
          type: "POST",
          data: {idkelas:idkelas,idmata_pelajaran:idmata_pelajaran,jumlah_ph:jumlah_ph},
          url: base_url+"Rencana_keterampilan/save",
          success: function(r) {
              if (r.status == "update") {
                  showToast('Data diupdate !',1000,'success');
                  fDatatables("tKeterampilan","<?=base_url('guru/Rencana_keterampilan/ajax_list/')?>"+idmata_pelajaran+"/"+idkelas,"ASC");
              } else if (r.status == "insert") {
                  showToast('Data berhasil disimpan !',1000,'success');
                  fDatatables("tKeterampilan","<?=base_url('guru/Rencana_keterampilan/ajax_list/')?>"+idmata_pelajaran+"/"+idkelas,"ASC");
              }
          }
      });
      return false;
    };
  });
})

$(document).delegate("#kd_status","click",function( ) {
  var idkompetensi = $(this).attr('data-id');
  var kd_status = $(this).val();
  var idmata_pelajaran = $('#idmata_pelajaran').val();
  var idkelas = $('#idkelas').val();
  $.ajax({
      type: "POST",
      data: {idkompetensi:idkompetensi,kd_status:kd_status},
      url: base_url+"Rencana_keterampilan/update_status",
      success: function(r) {
          if (r.status == "gagal") {
              showToast('Data gagal disimpan !',1000,'error');
          } else if (r.status == "ok") {
              showToast('Data berhasil disimpan !',1000,'success');
              fDatatables("tKeterampilan","<?=base_url('guru/Rencana_keterampilan/ajax_list/')?>"+idmata_pelajaran+"/"+idkelas,"ASC");
          }
      }
  });
  return false;
});

</script>

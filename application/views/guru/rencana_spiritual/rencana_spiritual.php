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
                  Rencana Nilai Sikap Spiritual
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
                    <input type="hidden" name="_idrencana_bs_spiritual" id="_idrencana_bs_spiritual" value="">
                    <input type="hidden" name="_idbutir_sikap" id="_idbutir_sikap" value="">

                    <?=form_dropdown('',$list_kelas,'',$list_kelas_attribute)?>
                  </td>
                </tr>
                <tr>
                  <td style="vertical-align:middle;">Jumlah Penilaian Harian (PH)</td>
                  <td>
                    <div class="error-message2"></div>
                    <?=form_dropdown('',$list_ph,'',$list_ph_attribute)?>
                  </td>
                </tr>
              </tbody>
            </table>
            </div><br/>
            <!-- /.card -->
            <div class="card" id="divSpiritual" style="display:none;">
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <div class="float-right"><small><i>* jika kotak yang telah dicentang tidak tersimpan setelah klik tombol simpan silahkan refresh halaman ini kemudian coba kembali</i></small></div>
                <table id="tSpiritual" class="table table-bordered table-striped">
                  <thead style="background-color:#17a2b8; color:#fff;">
                  <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Indikator/Kode</th>
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
                    <th>Indikator/Kode</th>
                    <th>Butir Sikap</th>
                    <th><center><a class="btn btn-info text-light" id="btn-save"> Simpan </a></center></th>
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
  var jumlah_ph = $('#jumlah_ph').val();

  if ($.trim(idkelas)==''){
    showToast('Silahkan pilih kelas !',1000,'error');
    $(".error-message1").append('<div class="font-italic text-danger" id="error-message1"><small>* silahkan isi sesuai format yang diminta</small></div>');
    $('#jumlah_ph').val('');
  } else if ($.trim(jumlah_ph)==''){
    showToast('Silahkan pilih jumlah penilaian harian !',1000,'error');
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
    $('#divSpiritual').fadeOut();
    var idkelas = $('#idkelas').val();

    $.ajax({
        type: "POST",
        data: {idkelas:idkelas},
        url: base_url+"Rencana_spiritual/check_penilaian",
        success: function(r) {
            if (r.status == "y") {
              $('#jumlah_ph').val(r.data.rbs_sp);
              $('#_idrencana_bs_spiritual').val(r.data.idrencana_bs_spiritual);
              $('#_idbutir_sikap').val(r.data.rbs_sp_kd);
              $('#divSpiritual').fadeIn();
              fDatatables("tSpiritual","<?=base_url('guru/Rencana_spiritual/ajax_list/')?>"+idkelas,"ASC");
            } else if (r.status == "n") {
              $('#jumlah_ph').val(r.data.rbs_sp);
              $('#_idrencana_bs_spiritual').val(r.data.idrencana_bs_spiritual);
              $('#_idbutir_sikap').val(r.data.rbs_sp_kd);
              $('#divSpiritual').fadeOut();
            }
        }
    });
    return false;
  });

  $("#jumlah_ph").on("change", function( ) {
    removeErrorMessages();
    if(formValidation()){
      $('#divSpiritual').fadeIn();
      var idkelas = $('#idkelas').val();
      var jumlah_ph = $('#jumlah_ph').val();

      $.ajax({
          type: "POST",
          data: {idkelas:idkelas,jumlah_ph:jumlah_ph},
          url: base_url+"Rencana_spiritual/save",
          success: function(r) {
              if (r.status == "update") {
                  showToast('Data diupdate !',1000,'success');
                  fDatatables("tSpiritual","<?=base_url('guru/Rencana_spiritual/ajax_list/')?>"+idkelas,"ASC");
              } else if (r.status == "insert") {
                  showToast('Data berhasil disimpan !',1000,'success');
                  fDatatables("tSpiritual","<?=base_url('guru/Rencana_spiritual/ajax_list/')?>"+idkelas,"ASC");
              }
          }
      });
      return false;
    };
  });

  $("#btn-save").on("click", function( ) {
    var idrencana_bs_spiritual = $("#_idrencana_bs_spiritual").val();
    var idbutir_sikap = $("#_idbutir_sikap").val();
    var idkelas = $('#idkelas').val();
    $.ajax({
        type: "POST",
        data: {idbutir_sikap:idbutir_sikap,idrencana_bs_spiritual:idrencana_bs_spiritual},
        url: base_url+"Rencana_spiritual/update_rencana_spiritual",
        success: function(r) {
            if (r.status == "ok") {
                showToast('Data diupdate !',1000,'success');
                fDatatables("tSpiritual","<?=base_url('guru/Rencana_spiritual/ajax_list/')?>"+idkelas,"ASC");
            }
        }
    });
    return false;
  });

})

$(document).delegate("#kd_status","click",function( ) {
  var idbutir_sikap = $(this).val();
  var idbutir_sikap_con = idbutir_sikap + ',';
  var current_butir_sikap = $("#_idbutir_sikap").val();
  var new_id = current_butir_sikap + idbutir_sikap_con;

  if ($(this).is(':checked')){
    $("#_idbutir_sikap").val(new_id);
  } else {
    var str = $("#_idbutir_sikap").val();
    var new_current = str.replace(idbutir_sikap+',','');
    $("#_idbutir_sikap").val(new_current);
  }

});

</script>

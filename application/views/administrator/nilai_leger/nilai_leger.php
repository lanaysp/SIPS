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
                  Nilai Leger
                </h3>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
        <div class="row">
          <div class="col-12 col-sm-12">
            <div class="col-8">
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
                    <td style="vertical-align:middle;">Pengetahuan dan Keterampilan</td>
                    <td>
                        <div class="error-message2"></div>
                        <a class="btn btn-info text-light" id="btn-cetak-pk">Cetak</a>
                    </td>
                    </tr>
                </tbody>
                </table>
            </div>
          </div>
        </div>
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
        var tipe = $('#list_tipe').val();
        if ($.trim(idkelas)==''){
            showToast('Silahkan pilih kelas !',1000,'error');
            $(".error-message1").append('<div class="font-italic text-danger" id="error-message1"><small>* silahkan isi sesuai format yang diminta</small></div>');
            $('#jumlah_ph').val('');
        } else {
            return true;
        }
    }
    
    function removeErrorMessages()
    {
    $("#error-message1").remove();
    }

    $(document).ready(function(){
        $("#btn-cetak-pk").on("click", function( ) {
          var idkelas = $('#idkelas').val();
          if ($.trim(idkelas)==''){
            showToast('Silahkan pilih kelas !',2000,'warning');
          } else {
            var win = window.open(base_url+'nilai_leger/print/'+idkelas, '_blank');
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
          }
        });
    })
    
</script>

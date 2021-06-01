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
                  Cetak Rapor
                </h3>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
        <div class="row">
          <div class="col-12">
            <!-- /.card -->
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
              </tbody>
            </table>
            </div><br/>
            <div class="card" id="divSiswa" style="display:none;">
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="tSiswa" class="table table-bordered table-striped">
                  <thead style="background-color:#17a2b8; color:#fff;">
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NISN</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>

                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NISN</th>
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
$('#opsi_kelas').on('change', function (){
  $('#divSiswa').fadeIn();
  var k_tingkat = $('#opsi_kelas option:selected').val();
  if (k_tingkat==''){
    $('#divSiswa').fadeOut();
  } else {
    fDatatablesP("tSiswa","<?=base_url('administrator/Cetak_rapor/ajax_list/')?>"+k_tingkat,"ASC");
  }
});

function sampul(id)
{
    var win = window.open(base_url+'rapor/sampul/'+id, '_blank');
      if (win) {
          //Browser has allowed it to be opened
          win.focus();
      } else {
          //Browser has blocked it
          alert('Please allow popups for this website');
      }
}

function biodata(id)
{
    var win = window.open(base_url+'rapor/biodata/'+id, '_blank');
      if (win) {
          //Browser has allowed it to be opened
          win.focus();
      } else {
          //Browser has blocked it
          alert('Please allow popups for this website');
      }
}

function rapor(id)
{
    var win = window.open(base_url+'rapor/rapor/'+id, '_blank');
      if (win) {
          //Browser has allowed it to be opened
          win.focus();
      } else {
          //Browser has blocked it
          alert('Please allow popups for this website');
      }
}
</script>

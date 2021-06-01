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
                  Nilai Sikap
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
            <div class="card" id="divDeskripsi" style="display:none;">
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="tDeskripsi" class="table table-bordered table-striped">
                  <thead style="background-color:#17a2b8; color:#fff;">
                  <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Deskripsi/Kesimpulan Spiritual</th>
                    <th>Deskripsi/Kesimpulan Sosial</th>
                  <tbody>

                  </tbody>
                </table>
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
          <h6 class="modal-title">[Kesimpulan/Lengkapi Deskripsi]</h6>
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
$('#opsi_kelas').on('change', function (){
  $('#divDeskripsi').fadeIn();
  var k_tingkat = $('#opsi_kelas option:selected').val();
  if (k_tingkat==''){
    $('#divDeskripsi').fadeOut();
  } else {
    fDatatablesP("tDeskripsi","<?=base_url('administrator/Nilai_sikap/ajax_list/')?>"+k_tingkat,"ASC");
  }
});
</script>

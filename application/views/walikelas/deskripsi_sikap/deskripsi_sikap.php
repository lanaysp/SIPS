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
                  Proses Deskripsi Sikap : Kelas <?=$kelas?>
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
            <div class="card" id="divDeskripsi">
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <span class="float-right">
                <input type="hidden" id="_idsiswa" value=""/>
                <input type="hidden" id="_s_nama" value=""/>
                <input type="hidden" id="_idkelas" value=""/>
                <small><i>* pada tiap kolom spiritual dan sosial merupakan hasil penilaian oleh seluruh guru</i></small><br/>
                <small><i>* kolom deskripsi/kesimpulan merupakan rangkuman penilaian anda yang akan ditampilkan pada rapor</i></small>
                </span>
                <table id="tDeskripsi" class="table table-bordered table-striped table-hover">
                  <thead style="background-color:#17a2b8; color:#fff;">
                  <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Spiritual</th>
                    <th>Meningkat</th>
                    <th>Deskripsi/Kesimpulan</th>
                    <th>Sosial</th>
                    <th>Meningkat</th>
                    <th>Deskripsi/Kesimpulan</th>
      
            
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
                        <a class="btn btn-info float-right text-light" id="btn-auto-generate"><i class="fas fa-redo"></i></a>
                        <a class="btn btn-success float-right text-light" data-toggle="modal" data-target="#modal_show_chart">Grafik Nilai</a>
                        <div class="form-group">
                          <label for="deskripsi">Deskripsi</label>
                          <div class="error-message1"></div>
                          <input type="hidden" name="iddeskripsi" class="form-control" id="iddeskripsi">
                          <input type="hidden" name="idsiswa" class="form-control" id="idsiswa">
                          <input type="hidden" name="tipe_deskripsi" class="form-control" id="tipe_deskripsi">
                          <input type="hidden" name="nilai_sikap_auto" class="form-control" id="nilai_sikap_auto">
                          <textarea rows="4" name="deskripsi" class="form-control" id="deskripsi" required>
                          </textarea>
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
    <?php 
      if (empty($tahunpelajaran_dipilih['tp_tahun'])){
        redirect (base_url('auth/logout/'));
      }
      $tahun_explode = explode('-',$tahunpelajaran_dipilih['tp_tahun']);
      $p_tahun = $tahun_explode[0];
      $p_semester = $tahun_explode[1];
    ?>
    <!-- MODAL -->
    <div class="modal fade" id="modal_show_chart" data-backdrop="static">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#293D55; color:white;">
          <h6 class="modal-title">Grafik Deskripsi Sikap <?=$p_tahun?> (Semester <?=$p_semester?>)</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer justify-content-between">
          <button onclick="return printCanvas('spiritualChart','spiritualMeningkatChart','sosialChart','sosialMeningkatChart');" type="button" class="btn-info ml-auto"><i class="fa fa-edit"></i> Print</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!-- END MODAL -->

<script type="text/javascript">
$(window).on('load',function () {
  $('#sidemenu-button').click();
});

function show_chart(idsiswa,snama,idkelas)
{
  $('#_idsiswa').val(idsiswa);
  $('#_s_nama').val(snama);
  $('#_idkelas').val(idkelas);
  $('#modal_show_chart').modal('show');
}

$('#modal_show_chart').on('show.bs.modal', function () {
  var idsiswa = $('#_idsiswa').val();
  var snama = $('#_s_nama').val();
  var idkelas = $('#_idkelas').val();
  var token = 'access';
  
  $.ajax({
    url: "<?=base_url('walikelas/Deskripsi_sikap/nilai_siswa_chart/')?>",
    type: "post",
    data: {token:token,idsiswa:idsiswa,snama:snama,idkelas:idkelas},
    success: function(data){
      $("#modal_show_chart").find(".modal-body").html(data);
    }
  });
});

function edit_deskripsi(id,deskripsi,idsiswa,tipe,snama,idkelas,nilai_sikap_auto)
{
  $('#modal_edit_deskripsi').modal('show');
  $('#iddeskripsi').val(id);
  $('#deskripsi').val(deskripsi);
  $('#nilai_sikap_auto').val(nilai_sikap_auto);
  $('#idsiswa').val(idsiswa);

  $('#_idsiswa').val(idsiswa);
  $('#_s_nama').val(snama);
  $('#_idkelas').val(idkelas);
  if (tipe=='spiritual') {
    $('#tipe_deskripsi').val('spiritual');
  } else if (tipe=='sosial') {
    $('#tipe_deskripsi').val('sosial');
  }
}

$(document).ready(function(){
  fDatatables("tDeskripsi","<?=base_url('walikelas/Deskripsi_sikap/ajax_list/')?>","ASC");

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

  $("#btn-auto-generate").on("click",function(){
    var nilai_sikap_auto = $("#nilai_sikap_auto").val();
    $("#deskripsi").val(nilai_sikap_auto);
  });

  $("#btn-auto-generate-so").on("click",function(){
    var nilai_spiritual = $("#nilai_spiritual").val();
    $("#deskripsi").val(nilai_spiritual);
  });

  $("#btn-save").on("click", function(e) {
    e.preventDefault();
    var iddeskripsi = $('#iddeskripsi').val();
    var tipe_deskripsi = $('#tipe_deskripsi').val();
    var deskripsi = $('#deskripsi').val();
    var idsiswa = $('#idsiswa').val();
      $.ajax({
          type: "POST",
          data: {iddeskripsi:iddeskripsi,tipe_deskripsi:tipe_deskripsi,deskripsi:deskripsi,idsiswa:idsiswa},
          url: base_url+"Deskripsi_sikap/update_deskripsi",
          success: function(r) {
            if (r.status=='ok')
            {
              $('#modal_edit_deskripsi').modal('hide');
              fDatatables("tDeskripsi","<?=base_url('walikelas/Deskripsi_sikap/ajax_list/')?>","ASC");
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

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
                  Input Nilai Sikap Spiritual
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
                    <input type="hidden" name="_jumlah_nilai" id="_jumlah_nilai" value="">
                    <input type="hidden" name="_jumlah_data" id="_jumlah_data" value="">
                    <input type="hidden" name="_nilai_spiritual" id="_nilai_spiritual" value="">
                    <input type="hidden" name="_nilai_spiritual_meningkat" id="_nilai_spiritual_meningkat" value="">
                    <input type="hidden" name="_idnilai_spiritual" id="_idnilai_spiritual" value="">
                    <?=form_dropdown('',$list_kelas,'',$list_kelas_attribute)?>
                  </td>
                </tr>
              </tbody>
            </table>
            </div><br/>
            <!-- /.card -->
            <div class="card" id="divSpiritual" style="display:none;">
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <div class="float-right"><small><i>* jika kolom input sikap kosong / tidak ada berarti anda belum melakukan rencana penilaian sikap spiritual</i></small></div>
                <div class="float-right"><small><i>* jika ada nama siswa anda yang tidak ada dalam daftar, silahkan klik tambah data atau reset data pada bagian bawah tabel</i></small></div>
                <table id="tSpiritual" class="table table-bordered table-striped">
                  <thead style="background-color:#17a2b8; color:#fff;">
                  <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Selalu Dilakukan</th>
                    <th>Mulai Meningkat</th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>

                  <tfoot>
                  <tr>
                    <th colspan="4"><a class="btn btn-info text-light float-right col-md-2" id="btn-save"> Simpan </a></th>
                  </tr>
                  </tfoot>
                </table><br/>
                <a href="#" onclick="return reset_data();" class="btn btn-danger float-left text-light ml-auto col-2"><i class="fa fa-window-close"></i> Reset Data</a>
                <a href="#" onclick="return tambah_siswa();" class="btn btn-primary float-right text-light ml-auto col-2"><i class="fa fa-plus"></i> Tambah Siswa</a>
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
<!-- MODAL -->
<div class="modal fade" id="modal_tambah_siswa" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#293D55; color:white;">
          <h6 class="modal-title">[Tambah Siswa]</h6>
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
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Data Siswa <span class="error-tab1"></span></a>
                    </li>
                  </ul>
                </div>
                <form class="form-horizontal" method="post" name="f_siswa" id="f_siswa">
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <div class="card-body">
                        <small class="float-right"><i>* gunakan fitur ini hanya jika ada siswa kelas anda namun namanya tidak tercantum dalam daftar penilaian</i></small>
                        <div class="form-group">
                          <label for="old">Pilih Siswa</label>
                          <div class="error-message1"></div>
                          <?=form_dropdown('',$list_siswa,'',$list_siswa_attribute)?>
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
          <button type="submit" class="btn btn-primary" id="btn-tambah-siswa">Simpan</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /.modal-content -->
<script type="text/javascript">
function tambah_siswa()
{
  $('#modal_tambah_siswa').modal('show');
}
function formValidation()
{
  var idkelas = $('#idkelas').val();

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

$(document).delegate("#nilai_spiritual_meningkat","change",function( ) {
  var idnilai = $(this).attr('data-id');
  var nilai = $(this).val();
  var status = 'meningkat';
    $.ajax({
        type: "POST",
        data: {idnilai:idnilai,nilai:nilai,status:status},
        url: base_url+"Nilai_spiritual/update_nilai",
    });
});

$(document).ready(function(){
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  });

  $("#modal_tambah_siswa").on('hide.bs.modal', function () {
    $("#f_siswa")[0].reset();
    $("#list_siswa").trigger('change.select2');
  });

  $("#idkelas").on("change", function( ) {
    var idkelas = $('#idkelas').val();
    $('#divSpiritual').fadeIn();
    fDatatables("tSpiritual","<?=base_url('guru/Nilai_spiritual/ajax_list/')?>"+idkelas,"ASC");
    fDuplicate("tSpiritual","nth-child(2)");
    $.ajax({
          type: "GET",
          url: base_url+"Nilai_spiritual/jumlah_nilai/"+idkelas,
          success: function(result) {
              $("#_jumlah_nilai").val(result.data._jumlah_nilai);
              $("#_jumlah_data").val(result.data._jumlah_data);
              // if (result.data.new_batch=='Y'){
              //     showToast('Input data siswa baru untuk pertama kali telah terdeteksi, sehingga halaman harus direload',4000,'success');
              //     <?php $this->session->unset_userdata('new_batch') ?>
              //     setTimeout(function(){ location.reload(); }, 4000);
              //   }
          }
    });
    return false;
  });

  $("#f_siswa").on("submit", function(e) {
    e.preventDefault();
    var idkelas = $('#idkelas').val();
    var list_siswa = $('#list_siswa').val();
    if (idkelas==''){
      showToast('Kelas belum dipilih!',2000,'warning');
    } else if (list_siswa==''){
      showToast('Siswa belum dipilih!',2000,'warning');
    } else {
      $.ajax({
          type: "POST",
          data: {idkelas:idkelas,idsiswa:list_siswa},
          url: base_url+"Nilai_spiritual/add_one_siswa",
          success: function(r) {
              if (r.status=='ok'){
                $('#f_siswa')[0].reset();
                $('#modal_tambah_siswa').modal('hide');
                showToast('Siswa berhasil ditambah!',2000,'success');
                fDatatables("tSpiritual","<?=base_url('guru/Nilai_spiritual/ajax_list/')?>"+idkelas,"ASC");
                fDuplicate("tSpiritual","nth-child(2)");
              } else if (r.status=='ada') {
                $('#f_siswa')[0].reset();
                $('#modal_tambah_siswa').modal('hide');
                showToast('Siswa sudah ada !',2000,'warning');
              } else if (r.status=='kelas') {
                $('#f_siswa')[0].reset();
                $('#modal_tambah_siswa').modal('hide');
                showToast('Siswa bukan dari kelas yang anda ampu !',2000,'error');
              }
          }
      });
      return false;
    }
  });

  $("#btn-save").on("click", function( ) {
    var jumlah_nilai = $("#_jumlah_nilai").val();
    var jumlah_data = $("#_jumlah_data").val();
    var nilai_spiritual = $('select[name="nilai_spiritual[]"]').map(function(){return $(this).val();}).get();
    var idnilai_spiritual = $('select[name="nilai_spiritual[]"]').map(function(){return $(this).attr('data-id');}).get();
    var status = 'rutin';
    var p = 0;
    var q = 0;
    var semua_nilai = '';
    var idnilai_spiritual_new = '';
    var total_data = jumlah_nilai * jumlah_data;

    //$(".loading").fadeIn("slow");

    for (i=0;i<total_data;i++) {
      p++;
      var index = (total_data + p) - (total_data);
      $("#_nilai_spiritual").val(nilai_spiritual[index - 1]);
      var current_nilai = $("#_nilai_spiritual").val();
      semua_nilai = semua_nilai + current_nilai + ',';
      $("#_nilai_spiritual").val(semua_nilai);

      $("#_idnilai_spiritual").val(idnilai_spiritual[index - 1]);
      idnilai_spiritual_new = $("#_idnilai_spiritual").val();

      if(((semua_nilai.split(',').length) - 1) == jumlah_nilai){
        $.ajax({
            type: "POST",
            data: {semua_nilai:semua_nilai,idnilai_spiritual_new:idnilai_spiritual_new,status:status},
            url: base_url+"Nilai_spiritual/update_nilai",
        });
        $("#_nilai_spiritual").val('');
        $("#_idnilai_spiritual").val('');
        semua_nilai = '';
        idnilai_spiritual_new = '';
      }
      if (p == total_data){
        $(".loading").fadeOut("slow");
        showToast('Data berhasil disimpan !',1000,'success');
      }
    }
  });

})

function reset_data() {
  var idkelas = $('#idkelas').val();
  if (confirm('Apakah anda yakin ingin mereset seluruh data..? ** PENTING ** Seluruh data penilaian akan direset menjadi 0')) {
    $.ajax({
    type: "GET",
    url: base_url+"Nilai_spiritual/reset_data/"+idkelas,
    success: function(r) {
      if (r.status == 'ok'){
        showToast('Data berhasil direset !',1000,'success');
        fDatatables("tSpiritual","<?=base_url('guru/Nilai_spiritual/ajax_list/')?>"+idkelas,"ASC");
        fDuplicate("tSpiritual","nth-child(2)");
      } else {
        showToast('Data gagal direset !',1000,'error');
      }
    }
    });
  }
  return false;
}

</script>

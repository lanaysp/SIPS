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
                  Input Nilai Keterampilan
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
                    <input type="hidden" name="_nilai_harian" id="_nilai_harian" value="">
                    <input type="hidden" name="_idnilai_harian" id="_idnilai_harian" value="">
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
                  <td style="vertical-align:middle;">Pilih Penilaian</td>
                  <td>
                    <div class="error-message3"></div>
                    <?=form_dropdown('',$list_kd,'',$list_kd_attribute)?>
                  </td>
                </tr>
              </tbody>
            </table>
            </div><br/>
            <!-- /.card -->
            <div class="card" id="divKeterampilan" style="display:none;">
              <!-- /.card-header -->
              <div class="card-body table-responsive">
              <div class="float-right"><small><i>* jika ada nama siswa anda yang tidak ada dalam daftar, silahkan klik tambah data atau reset data pada bagian bawah tabel</i></small></div>
                <table id="tKeterampilan" class="table table-bordered table-striped">
                  <thead style="background-color:#17a2b8; color:#fff;">
                  <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Nilai Harian <i class="float-right" style="font-size:12px;">(* jika penilaian sudah cukup dan masih ada kolom tersisa, silahkan input angka 1 untuk melewati penilaian)</i></th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>

                  <tfoot>
                  <tr>
                    <th colspan="3"><a class="btn btn-info float-right text-light col-md-2" id="btn-save"> Simpan </a></th>
                  </tr>
                  </tfoot>
                </table><br/>
                <a href="#" onclick="return reset_harian();" class="btn btn-danger float-left text-light ml-auto col-2"><i class="fa fa-window-close"></i> Reset Data</a>
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
  var idmata_pelajaran = $('#idmata_pelajaran').val();
  var idkompetensi_dasar = $('#idkompetensi_dasar').val();

  if ($.trim(idkelas)==''){
    showToast('Silahkan pilih kelas !',1000,'error');
    $(".error-message1").append('<div class="font-italic text-danger" id="error-message1"><small>* silahkan isi sesuai format yang diminta</small></div>');
    $('#jumlah_ph').val('');
  } else if ($.trim(idmata_pelajaran)==''){
    showToast('Silahkan pilih mata pelajaran !',1000,'error');
    $(".error-message2").append('<div class="font-italic text-danger" id="error-message2"><small>* silahkan isi sesuai format yang diminta</small></div>');
    $('#jumlah_ph').val('');
  } else if ($.trim(idkompetensi_dasar)==''){
    showToast('Silahkan pilih penilaian KD !',1000,'error');
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
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  });

  $("#modal_tambah_siswa").on('hide.bs.modal', function () {
    $("#f_siswa")[0].reset();
    $("#list_siswa").trigger('change.select2');
  });

  $("#idkelas").on("change", function( ) {
    $('#idmata_pelajaran').val('');
    $('#idkompetensi_dasar').val('');
    $('#divKeterampilan').fadeOut();
  });

  $("#idmata_pelajaran").on("change", function( ) {
    var idmata_pelajaran = $(this).val();
    var idkelas = $('#idkelas').val();

    $.ajax({
        type: "POST",
        data: {idmata_pelajaran:idmata_pelajaran,idkelas:idkelas},
        url: base_url+"Nilai_keterampilan/check_kd",
        success: function(data) {
            $('#idkompetensi_dasar').html(data);
        }
    });
    return false;
  });

  $("#idkompetensi_dasar").on("change", function( ) {
    removeErrorMessages();
    if(formValidation()){
      var idkelas = $('#idkelas').val();
      var idmata_pelajaran = $('#idmata_pelajaran').val();
      var idkompetensi_dasar = $('#idkompetensi_dasar').val();

      $('#divKeterampilan').fadeIn();
      fDatatables("tKeterampilan","<?=base_url('guru/Nilai_keterampilan/ajax_list/')?>"+idkelas+"/"+idmata_pelajaran+"/"+idkompetensi_dasar,"ASC");
      fDuplicate("tKeterampilan","nth-child(2)");
      $.ajax({
          type: "GET",
          url: base_url+"Nilai_keterampilan/jumlah_nilai/"+idkelas+"/"+idmata_pelajaran+"/"+idkompetensi_dasar,
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
    };
  });

  $("#f_siswa").on("submit", function(e) {
    e.preventDefault();
    var idmata_pelajaran = $('#idmata_pelajaran').val();
    var idkelas = $('#idkelas').val();
    var list_siswa = $('#list_siswa').val();
    var idkompetensi_dasar = $('#idkompetensi_dasar').val();
    if (idmata_pelajaran==''){
      showToast('Mata pelajaran belum dipilih!',2000,'warning');
    } else if (idkelas==''){
      showToast('Kelas belum dipilih!',2000,'warning');
    } else if (list_siswa==''){
      showToast('Siswa belum dipilih!',2000,'warning');
    } else if (idkompetensi_dasar==''){
      showToast('Penilaian belum dipilih!',2000,'warning');
    } else {
      $.ajax({
          type: "POST",
          data: {idmata_pelajaran:idmata_pelajaran,idkelas:idkelas,idsiswa:list_siswa,idkompetensi_dasar:idkompetensi_dasar},
          url: base_url+"Nilai_keterampilan/add_one_siswa",
          success: function(r) {
              if (r.status=='ok'){
                $('#f_siswa')[0].reset();
                $('#modal_tambah_siswa').modal('hide');
                showToast('Siswa berhasil ditambah!',2000,'success');
                fDatatables("tKeterampilan","<?=base_url('guru/Nilai_keterampilan/ajax_list/')?>"+idkelas+"/"+idmata_pelajaran+"/"+idkompetensi_dasar,"ASC");
                fDuplicate("tKeterampilan","nth-child(2)");
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

  $("#btn-save").on("click", function( ) {
    //$(".loading").fadeIn("slow");

    var jumlah_nilai = $("#_jumlah_nilai").val();
    var jumlah_data = $("#_jumlah_data").val();
    var nilai_harian = $('input[name="nilai_harian[]"]').map(function(){return $(this).val();}).get();
    var idnilai_harian = $('input[name="nilai_harian[]"]').map(function(){return $(this).attr('data-id');}).get();

    var p = 0;
    var semua_nilai = '';
    var idnilai_keterampilan = '';
    var total_data = jumlah_nilai * jumlah_data;

    for (i=0;i<total_data;i++) {
      p++;
      var index = (total_data + p) - (total_data);
      $("#_nilai_harian").val(nilai_harian[index - 1]);
      var current_nilai = $("#_nilai_harian").val();
      semua_nilai = semua_nilai + current_nilai + ',';
      $("#_nilai_harian").val(semua_nilai);

      $("#_idnilai_harian").val(idnilai_harian[index - 1]);
      idnilai_keterampilan = $("#_idnilai_harian").val();

      if(((semua_nilai.split(',').length) - 1) == jumlah_nilai){

        $.ajax({
            type: "POST",
            data: {semua_nilai:semua_nilai,idnilai_keterampilan:idnilai_keterampilan},
            url: base_url+"Nilai_keterampilan/update_nilai",
        });
        $("#_nilai_harian").val('');
        $("#_idnilai_harian").val('');
        semua_nilai = '';
        idnilai_keterampilan = '';
      }
      if (p == total_data){
        $(".loading").fadeOut("slow");
        showToast('Data berhasil disimpan !',1000,'success');
      }
    }
  });

})

function reset_harian() {
  var idkelas = $('#idkelas').val();
  var idmata_pelajaran = $('#idmata_pelajaran').val();
  var idkompetensi_dasar = $('#idkompetensi_dasar').val();
  if (confirm('Apakah anda yakin ingin mereset seluruh data..? ** PENTING ** Seluruh data penilaian akan direset menjadi 0')) {
    $.ajax({
    type: "GET",
    url: base_url+"Nilai_keterampilan/reset_harian/"+idkelas+"/"+idmata_pelajaran+"/"+idkompetensi_dasar,
    success: function(r) {
      if (r.status == 'ok'){
        showToast('Data berhasil direset !',1000,'success');
        fDatatables("tKeterampilan","<?=base_url('guru/Nilai_keterampilan/ajax_list/')?>"+idkelas+"/"+idmata_pelajaran+"/"+idkompetensi_dasar,"ASC");
        fDuplicate("tKeterampilan","nth-child(2)");
      } else {
        showToast('Data gagal direset !',1000,'error');
      }
    }
    });
  }
  return false;
}

</script>

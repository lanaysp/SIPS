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
                  Data Tahun Pelajaran <i data-toggle="modal" data-target="#modal_info" class='fas fa-info-circle'></i>
                </h3>
                <a onclick="return edit(0)" class="btn btn-info" style="color:#FFF; float:right;">(+) Tambah Tahun Pelajaran</a>
                <a href="#" data-toggle="modal" data-target="#modal_import_data" class="btn btn-info float-right" style="margin-right:5px;"><i class="fa fa-download"></i> Import Data</a>
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
                <table id="tTahunpelajaran" class="table table-bordered table-striped">
                  <thead style="background-color:#17a2b8; color:#fff;">
                  <tr>
                    <th>No</th>
                    <th>Tahun Pelajaran</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>

                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Tahun Pelajaran</th>
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
    </section>
  </div>

  <div class="modal fade" id="modal_data_tahun" data-backdrop="static">
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
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Tahun Pelajaran <span class="error-tab1"></span></a>
                    </li>
                  </ul>
                </div>
                <form class="form-horizontal" method="post" id="f_tahun" name="f_tahun">
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <div class="card-body">
                        <div class="form-group">
                          <!-- -->
                          <input type="hidden" name="_id" id="_id" value="">
                          <input type="hidden" name="_mode" id="_mode" value="">
                          <!-- -->
                          <label for="e_ekstra">Tahun Pelajaran</label>
                          <div class="error-message1"></div>
                          <input type="text" name="tp_tahun" class="form-control" id="tp_tahun" placeholder="format: 2xxx/2xxx-x" value="" required>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="float-right">
                  <small><i>*catatan: format penulisan 2xxx/2xxx-x berarti xxx adalah digit angka tahun pelajaran dan -x merupakan digit semester</i></small><br/>
                  <small><i>*contoh: misalkan kita input 2020/2021-1 berarti tahun pelajaran 2020/2021 semester 1, dan seterusnya</i></small>
                  </div>
                </div>
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
            Data tahun pelajaran terhubung dengan beberapa data dibawah ini, jika ingin menghapus salah satu data yang ada, pastikan seluruh data pada kategori dibawah ini tidak ada satupun yang menggunakan data tersebut.
            Hal ini bertujuan untuk mencegah hilangnya data secara massal jika validasi penghapusan tidak dilakukan dan tanpa/dengan sengaja menghapus suatu data.
            <br/> Namun jika anda tetap ingin menghapus data secara paksa, silahkan aktifkan 'Penghapusan Tanpa Validasi' pada pengaturan website, namun hal ini tidak disarankan karena sebaiknya data tidak dihapus untuk dijadikan arsip.
          </p>
          <p>
            1. Data kompetensi dasar.<br/>
            2. Data nilai kehadiran siswa.</br>
            3. Data nilai ekstrakurikuler siswa.<br/>
            4. Data nilai kesehatan siswa.<br/>
            5. Data nilai keterampilan.</br>
            6. Data nilai pengetahuan.</br>
            7. Data nilai PTS dan PAS pengetahuan.<br/>
            8. Data nilai sikap spiritual.</br>
            9. Data nilai sikap sosial.<br/>
            10. Data nilai prestasi siswa.<br/>
            11. Data deskripsi nilai keterampilan.</br>
            12. Data deskripsi nilai pengetahuan.</br>
            13. Data deskripsi nilai spiritual.<br/>
            14. Data deskripsi nilai sosial.<br/>
            15. Data profile sekolah.<br/>
            16. Data rencana butir sikap sosial.<br/>
            17. Data rencana butir sikap spiritual.<br/>
            18. Data rencana kompetensi dasar pengetahuan.<br/>
            19. Data rencana kompetensi dasar keterampilan.<br/>
            20. Data siswa pada peserta didik guru kelas / wali kelas.
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL -->
  <div class="modal fade" id="modal_import_data" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#293D55; color:white;">
          <h6 class="modal-title">Import Tahun Pelajaran</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="<?php print site_url();?>phpspreadsheet/upload" id="f_import_data" enctype="multipart/form-data" method="post" accept-charset="utf-8">
          <div class="row padall">
            <div class="form-group order-lg-1">
              <div class="small-box bg-primary">
                <div class="inner">
                  <ol>
                    <li>Silahkan download template terlebih dahulu, kemudian isi data pada template sesuai dengan format yang diminta.</li>
                    <li>Setelah data selesai diisi, upload kembali file template pada kolom telusuri disebelah tombol download template, kemudian klik import.</li>
                  </ol>
                </div>
              </div>
            </div>
            <div class="form-group order-lg-1">
              <a href="<?=base_url('assets/template/template-tahun-pelajaran.xlsx')?>" class="btn btn-info">Download Template</a>
            </div><br/>
            <div class="col-lg-4 order-lg-2">
              <input type="file" class="form-control" id="validatedCustomFile" name="fileURL">
            </div>
            <div class="col-lg-2 order-lg-3">
              <button type="submit" name="import" id="btn-import" class="float-right btn btn-primary">Import</button>
            </div>
          </div>
        </form>
         <div id="import_result"></div>
        </div>
      </div>
    </div>
  </div>
  <!-- END MODAL -->

<script type="text/javascript">
$("#f_import_data").on('submit',function(e){
  e.preventDefault();
  $('#btn-import').hide();
  var import_length = document.getElementById('validatedCustomFile').files.length;
  if (import_length<1){
    showToast("Silahkan pilih file yang akan diimport",1000,'error');
    $('#btn-import').show();
  } else {
    var form = $('#f_import_data')[0];
    var data = new FormData(form);
    var import_data = $('#validatedCustomFile')[0].files[0];
    data.append("fileURL",import_data);
    $.ajax({
      type: "POST",
      data: data,
      cache:false,
      contentType: false,
      processData: false,
      url: "<?=base_url('administrator/Tahun_pelajaran/upload')?>",
      success: function(r) {
          if (r.status == "ok") {
              $('#btn-import').show();
              showToast("sukses import",1000,'success');
              fDatatables("tTahunpelajaran","<?=base_url('administrator/tahun_pelajaran/ajax_list')?>","ASC");
              $("#f_import_data")[0].reset();
              $.each(r.dataInfo, function(i, item) {
                $("#import_result").append('<tr><td>['+i+']</td><td>'+item.tp_tahun+'</td></tr>');
              });
          } else if (r.status == "validasi"){
              $('#btn-import').show();
              showToast("file tidak boleh kosong",1000,'error');
          } else if (r.status == "tipe_file"){
              $('#btn-import').show();
              showToast("file tidak sesuai",1000,'error');
          } else {
              showToast("gagal import",1000,'error');
              $('#btn-import').show();
          }
      }
    });
    return false;
  }
});

$('#modal_import_data').on('hidden.bs.modal', function () {
  $("#import_result").load(" #import_result");
})

function formValidation()
{
  var re = new RegExp(/^(\d{4})\/(\d{4})-(\d{1})$/);

  var tp_tahun = $('#tp_tahun').val();

  if ($.trim(tp_tahun)==''){
    showToast('Tahun pelajaran tidak boleh kosong !',1000,'error');
    $(".error-message1").append('<div class="font-italic text-danger" id="error-message1"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if (!re.test(tp_tahun)){
    showToast('Format tahun pelajaran salah !',1000,'error');
    $(".error-message1").append('<div class="font-italic text-danger" id="error-message1"><small>* silahkan isi sesuai format yang diminta</small></div>');
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
  fDatatables("tTahunpelajaran","<?=base_url('administrator/tahun_pelajaran/ajax_list')?>","ASC");

  $("#f_tahun").on("submit", function(e) {
    e.preventDefault();
    removeErrorMessages();
    if(formValidation()){
      $('#btn-save').prop('disabled',true);
      var data    = $(this).serialize();
      $.ajax({
          type: "POST",
          data: data,
          url: base_url+"tahun_pelajaran/save",
          success: function(r) {
              if (r.status == "gagal") {
                  showToast('Data gagal disimpan !',1000,'error');
              } else if (r.status == "ok") {
                  $("#modal_data_tahun").modal('hide');
                  showToast('Data berhasil disimpan !',1000,'success');
                  fDatatables("tTahunpelajaran","<?=base_url('administrator/tahun_pelajaran/ajax_list')?>","ASC");
              } else {
                  showToast('Data sudah ada !',1000,'warning');
                  $('#modal_data_tahun').modal('hide');
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
  $('#modal_data_tahun').modal('show');
  $.ajax({
      type: "GET",
      url: base_url+"tahun_pelajaran/edit/"+id,
      success: function(result) {
          $("#_id").val(result.data.idtahun_pelajaran);
          $("#tp_tahun").val(result.data.tp_tahun);
          $('#btn-save').prop('disabled',false);
      }
  });
  return false;
}

function delete_data(id,data) {
  if (id == 0) {
    showToast('Silahkan pilih data yang akan dihapus !',1000,'error');
  }
  swal({
      title: "Lanjut menghapus ..?",
      text: "Apakah anda yakin akan menghapus data "+data+" ? Data yang telah dihapus tidak dapat dikembalikan",
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
          url: base_url+"tahun_pelajaran/delete/"+id,
          success: function(r) {
            if (r.status == 'ok'){
              swal("Dihapus", "Data berhasil dihapus", "success");
              fDatatables("tTahunpelajaran","<?=base_url('administrator/tahun_pelajaran/ajax_list')?>","ASC");
            } else if (r.status == 'profile'){
              swal("Gagal", "Data masih terhubung dengan profile sekolah, silahkan ganti tahun pelajaran pada profile sekolah terlebih dahulu", "error");
            } else {
              swal("Gagal", "Data gagal dihapus karena ada data yang sedang terhubung atau memakai tahun pelajaran ini, silahkan klik logo info disebelah label Data Tahun Pelajaran untuk melihat info data yang terhubung dengan data ini", "error");
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

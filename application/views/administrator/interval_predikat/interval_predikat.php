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
                  Data Interval Predikat
                </h3>
                <a onclick="return edit(0)" class="btn btn-info" style="color:#FFF; float:right;">(+) Tambah Interval Predikat</a>
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
                <table id="tInterval" class="table table-bordered table-striped">
                  <thead style="background-color:#17a2b8; color:#fff;">
                  <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Mata Pelajaran</th>
                    <th>KKM</th>
                    <th>Interval</th>
                    <th>A (Sangat Baik)</th>
                    <th>B (Baik)</th>
                    <th>C (Cukup)</th>
                    <th>D (Butuh Bimbingan)</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>

                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Mata Pelajaran</th>
                    <th>KKM</th>
                    <th>Interval</th>
                    <th>A (Sangat Baik)</th>
                    <th>B (Baik)</th>
                    <th>C (Cukup)</th>
                    <th>D (Butuh Bimbingan)</th>
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
  <div class="modal fade" id="modal_data_interval" data-backdrop="static">
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
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Interval Predikat <span class="error-tab1"></span></a>
                    </li>
                  </ul>
                </div>
                <form class="form-horizontal" method="post" id="f_interval" name="f_interval">
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <div class="card-body">
                        <div class="form-group">
                          <!-- -->
                          <input type="hidden" name="_id" id="_id" value="">
                          <input type="hidden" name="_mode" id="_mode" value="">
                          <!-- -->
                          <label for="kkm">Data KKM</label>
                          <div class="error-message1"></div>
                          <?=form_dropdown('',$edit_kkm,'',$edit_kkm_attr)?>
                        </div>
                        <div class="form-group">
                          <div id="interval_result"></div>
                        </div>
                        <div class="form-group">
                          <label for="amax">A (Sangat Baik)</label>
                          <div class="error-message2"></div>
                          Min <input type="number" name="amin" class="col-sm-2" id="amin" placeholder="min" value="" required> -
                          <input type="number" name="amax" class="col-sm-2" id="amax" placeholder="max" value="" required> Max
                        </div>
                        <div class="form-group">
                          <label for="bmax">B (Baik)</label>
                          <div class="error-message3"></div>
                          Min <input type="number" name="bmin" class="col-sm-2" id="bmin" placeholder="min" value="" required> -
                          <input type="number" name="bmax" class="col-sm-2" id="bmax" placeholder="max" value="" required> Max
                        </div>
                        <div class="form-group">
                          <label for="cmax">C (Cukup)</label>
                          <div class="error-message4"></div>
                          Min <input type="number" name="cmin" class="col-sm-2" id="cmin" placeholder="min" value="" required> -
                          <input type="number" name="cmax" class="col-sm-2" id="cmax" placeholder="max" value="" required> Max
                        </div>
                        <div class="form-group">
                          <label for="dmax">D (Perlu Bimbingan)</label>
                          <div class="error-message5"></div>
                          Min <input type="number" name="dmin" class="col-sm-2" id="dmin" placeholder="min" value="0" required> -
                          <input type="number" name="dmax" class="col-sm-2" id="dmax" placeholder="max" value="" required> Max
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
$('#kkm').on('change', function (){
  var idkkm = $('#kkm option:selected').val();
  $.ajax({
    url: '<?=base_url('administrator/Interval_predikat/read_interval/')?>'+idkkm,
    dataType: 'html',
    success: function(data){
      $('#interval_result').show();
      $('#interval_result').html(data);
    }
  });
});

$('#modal_data_interval').on('hidden.bs.modal', function (e) {
  $('#interval_result').hide();
});

function formValidation()
{
  var kkm = $('#kkm').val();
  var amax = parseInt($('#amax').val());
  var bmax = parseInt($('#bmax').val());
  var cmax = parseInt($('#cmax').val());
  var dmax = parseInt($('#dmax').val());
  var amin = parseInt($('#amin').val());
  var bmin = parseInt($('#bmin').val());
  var cmin = parseInt($('#cmin').val());
  var dmin = parseInt($('#dmin').val());

  if ($.trim(kkm)==''){
    showToast('Data KKM tidak boleh kosong !',2000,'error');
    $(".error-message1").append('<div class="font-italic text-danger" id="error-message1"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if (amax>100 || amax<=amin){
    showToast('Nilai maksimal A tidak boleh lebih dari 100 atau kurang dari sama dengan nilai minimum A !',2000,'error');
    $(".error-message2").append('<div class="font-italic text-danger" id="error-message2"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if (bmax>=amin || bmax<=bmin){
    showToast('Nilai maksimal B tidak boleh lebih dari sama dengan nilai A minimum atau kurang dari sama dengan nilai minimum B !',2000,'error');
    $(".error-message3").append('<div class="font-italic text-danger" id="error-message3"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if (cmax>=bmin || cmax<=cmin){
    showToast('Nilai maksimal C tidak boleh lebih dari sama dengan nilai B minimum atau kurang dari sama dengan nilai minimum C !',2000,'error');
    $(".error-message4").append('<div class="font-italic text-danger" id="error-message4"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if (dmax>=cmin || dmax<=dmin){
    showToast('Nilai maksimal D tidak boleh lebih dari sama dengan nilai C minimum atau kurang dari sama dengan nilai minimum D !',2000,'error');
    $(".error-message5").append('<div class="font-italic text-danger" id="error-message5"><small>* silahkan isi sesuai format yang diminta</small></div>');
  } else if (amax<0 || bmax<0 || cmax<0 || dmax<0 || amin<0 || bmin<0 || cmin<0 || dmin<0){
    showToast('Tidak boleh ada nilai yang minus atau kurang dari 0 !',2000,'error');
  } else {
    return true;
  }
}

function removeErrorMessages()
{
  $("#error-message1").remove();
  $("#error-message2").remove();
  $("#error-message3").remove();
  $("#error-message4").remove();
  $("#error-message5").remove();
}

$(document).ready(function(){
  fDatatables("tInterval","<?=base_url('administrator/Interval_predikat/ajax_list')?>","ASC");

  $("#f_interval").on("submit", function(e) {
    e.preventDefault();
    removeErrorMessages();
    if(formValidation()){
      $('#btn-save').prop('disabled',true);
      var data    = $(this).serialize();
      $.ajax({
          type: "POST",
          data: data,
          url: base_url+"Interval_predikat/save",
          success: function(r) {
              if (r.status == "gagal") {
                  showToast('Data gagal disimpan !',1000,'error');
              } else if (r.status == "ok") {
                  $("#modal_data_interval").modal('hide');
                  showToast('Data berhasil disimpan !',1000,'success');
                  fDatatables("tInterval","<?=base_url('administrator/Interval_predikat/ajax_list')?>","ASC");
              } else {
                  showToast('Data sudah ada !',1000,'warning');
                  $('#modal_data_interval').modal('hide');
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
      $('#interval_result').show();
  }
  $('#f_interval')[0].reset();
  $('#modal_data_interval').modal('show');
  $.ajax({
      type: "GET",
      url: base_url+"Interval_predikat/edit/"+id,
      success: function(result) {
          $("#_id").val(result.data.idinterval_predikat);
          $("#kkm").val(result.data.idkkm);
          $("#amax").val(result.data.amax);
          $("#bmax").val(result.data.bmax);
          $("#cmax").val(result.data.cmax);
          $("#dmax").val(result.data.dmax);
          $("#amin").val(result.data.amin);
          $("#bmin").val(result.data.bmin);
          $("#cmin").val(result.data.cmin);
          $("#dmin").val(result.data.dmin);
          $('#btn-save').prop('disabled',false);
      }
  });
  return false;
}

function delete_data(id,data,kelas) {
  if (id == 0) {
    showToast('Silahkan pilih data yang akan dihapus !',1000,'error');
  }
  if (confirm('Apakah anda yakin ingin menghapus data interval '+data+' kelas '+kelas+'..? ')) {
    $.ajax({
    type: "GET",
    url: base_url+"Interval_predikat/delete/"+id,
    success: function(r) {
      if (r.status == 'ok'){
        showToast('Data berhasil dihapus !',1000,'success');
        fDatatables("tInterval","<?=base_url('administrator/Interval_predikat/ajax_list')?>","ASC");
      } else {
        showToast('Data gagal dihapus !',1000,'error');
      }
    }
    });
  }
  return false;
}

</script>

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
                  Radar Nilai Rapor
                </h3>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
        <div class="row">
          <div class="col-12 col-sm-12">
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
                    </tr>
                </tbody>
                </table>
            </div><br/>

            <div class="card card-primary card-tabs" id="divAkhir" style="display:none;">
              <div class="card-header p-0 pt-1" style="background:#17a2b8;">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-rincian-tab" data-toggle="pill" href="#custom-tabs-one-rincian" role="tab" aria-controls="custom-tabs-one-rincian" aria-selected="true">Rincian Nilai Rapor</a>
                  </li>
                  <li class="nav-item ml-auto">
                    <a class="btn btn-primary" data-toggle="modal" data-target="#modal_show_all_chart">Grafik Seluruh Siswa</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-rincian" role="tabpanel" aria-labelledby="custom-tabs-one-rincian-tab">
                    <div class="row">
                      <div class="col-12">
                        <!-- /.card -->
                        <div class="card">
                          <!-- /.card-header -->
                          <div class="card-body table-responsive">
                            <table id="tRincian" class="table table-bordered table-striped">
                              <div class="float-right">
                                <input type="hidden" id="_idmapel" value=""/>
                                <input type="hidden" id="_idsiswa" value=""/>
                                <input type="hidden" id="_s_nama" value=""/>
                                <input type="hidden" id="_idkelas" value=""/>
                                <small><i>* Simbol (..) berarti kriteria nilai kolom tersebut seperti kkm atau interval predikat masih kosong dan belum diinput oleh administrator</i></small><br/>
                                <small><i>* Apabila baris kosong atau tidak ada data apapun berarti penilaian belum dilakukan oleh guru yang bersangkutan</i></small>
                              </div>
                              <thead style="background-color:#2D5E89; color:#fff;">
                                <tr>
                                    <th rowspan="2" width="3%" style="vertical-align:middle;"><center>No</center></th>
                                    <th rowspan="2" width="30%" style="vertical-align:middle;"><center>Nama Siswa</center></th>
                                    <th rowspan="2" width="50%" style="vertical-align:middle;"><center>Mata Pelajaran</center></th>
                                    <th rowspan="2" width="3%" style="vertical-align:middle;"><center>KKM</center></th>
                                    <th colspan="3"><center>Pengetahuan</center></th>
                                    <th colspan="3"><center>Keterampilan</center></th>
                                </tr>
                                <tr>
                                    <th>Angka</th>
                                    <th>Predikat</th>
                                    <th>Keterangan</th>
                                    <th>Angka</th>
                                    <th>Predikat</th>
                                    <th>Keterangan</th>
                                </tr>
                              </thead>
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
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
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
          <h6 class="modal-title">Grafik Nilai Siswa Tahun Pelajaran <?=$p_tahun?> (Semester <?=$p_semester?>)</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer justify-content-between">
          <button onclick="return printCanvas('pengetahuanChart','keterampilanChart','ptspasChart');" type="button" class="btn-info ml-auto"><i class="fa fa-edit"></i> Print</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!-- END MODAL -->

  <!-- MODAL -->
  <div class="modal fade" id="modal_show_all_chart" data-backdrop="static">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#293D55; color:white;">
          <h6 class="modal-title">Grafik Nilai Seluruh Siswa Tahun Pelajaran <?=$p_tahun?> (Semester <?=$p_semester?>)</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer justify-content-between float-right">
          <button onclick="return printCanvas('allChart');" type="button" class="btn-info ml-auto"><i class="fa fa-edit"></i> Print</button>
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

    function show_chart(idmapel,idsiswa,snama,idkelas)
    {
      $('#_idmapel').val(idmapel);
      $('#_idsiswa').val(idsiswa);
      $('#_s_nama').val(snama);
      $('#_idkelas').val(idkelas);
      $('#modal_show_chart').modal('show');
    }

    $('#modal_show_chart').on('show.bs.modal', function () {
      var idmapel = $('#_idmapel').val();
      var idsiswa = $('#_idsiswa').val();
      var snama = $('#_s_nama').val();
      var idkelas = $('#_idkelas').val();
      var token = 'access';
      
      $.ajax({
        url: "<?=base_url('administrator/Nilai_rapor/nilai_siswa_chart/')?>",
        type: "post",
        data: {token:token,idmapel:idmapel,idsiswa:idsiswa,snama:snama,idkelas:idkelas},
        success: function(data){
          $("#modal_show_chart").find(".modal-body").html(data);
        }
      });
    });

    $('#modal_show_all_chart').on('show.bs.modal', function () {
      $('#modal_show_all_chart').find(".modal-body").html("<center>Mohon ditunggu, data sedang diproses ..</center>"); 
      var idkelas = $('#idkelas').val();
      var token = 'access';
      $.ajax({
        url: "<?=base_url('administrator/Nilai_rapor/nilai_seluruh_siswa_chart/')?>",
        type: "post",
        data: {token:token,idkelas:idkelas},
        success: function(data){
          $("#modal_show_all_chart").find(".modal-body").html(data);
        }
      });
    });

    function print_rapor(id)
    {
      var win = window.open(base_url+'rapor/print/'+id, '_blank');
      if (win) {
          //Browser has allowed it to be opened
          win.focus();
      } else {
          //Browser has blocked it
          alert('Please allow popups for this website');
      }
    }

    function formValidation()
    {
        var idkelas = $('#idkelas').val();
        if ($.trim(idkelas)==''){
            $('#divAkhir').fadeOut();
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
        $("#idkelas").on("change", function( ) {
            removeErrorMessages();
            if(formValidation()){
            var idkelas = $('#idkelas').val();

            $('#divAkhir').fadeIn();
            fDatatables("tRincian","<?=base_url('administrator/Nilai_rapor/ajax_list/')?>"+idkelas,"ASC");
            return false;
            };
        });
    })
</script>

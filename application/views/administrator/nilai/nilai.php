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
                  Hasil Pengolahan Nilai
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
                    <td style="vertical-align:middle;">Mata Pelajaran</td>
                    <td>
                        <div class="error-message2"></div>
                        <?=form_dropdown('',$list_mapel,'',$list_mapel_attribute)?>
                    </td>
                    </tr>
                    <tr>
                    <td style="vertical-align:middle;">Tipe Penilaian</td>
                    <td>
                        <div class="error-message3"></div>
                        <?=form_dropdown('',$list_tipe,'',$list_tipe_attribute)?>
                    </td>
                    </tr>
                </tbody>
                </table>
            </div><br/>

            <div class="card card-primary card-tabs" id="divPengetahuan" style="display:none;">
              <div class="card-header p-0 pt-1" style="background:#17a2b8;">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-rincian-tab" data-toggle="pill" href="#custom-tabs-one-rincian" role="tab" aria-controls="custom-tabs-one-rincian" aria-selected="true">Rincian Nilai Siswa</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-perkd-tab" data-toggle="pill" href="#custom-tabs-one-perkd" role="tab" aria-controls="custom-tabs-one-perkd" aria-selected="false">Pengolahan Nilai Per KD</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-rapor-tab" data-toggle="pill" href="#custom-tabs-one-rapor" role="tab" aria-controls="custom-tabs-one-rapor" aria-selected="false">Nilai Rapor</a>
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
                                <small><i>* Apabila ada nilai yang kosong atau 0 maka nilai akan dianggap 0 (pastikan input nilai telah dilakukan)</i></small>
                              </div>
                              <thead style="background-color:#2D5E89; color:#fff;">
                              <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th width="30%">Kompetensi Dasar <small>(Rencana Penilaian)</small></th>
                                <th>Penilaian Harian</th>
                                <th>Nilai UTS</th>
                                <th>Nilai UAS</th>
                              </tr>
                              </thead>
                              <tbody>

                              </tbody>

                              <tfoot>
                              <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th width="30%">Kompetensi Dasar <small>(Rencana Penilaian)</small></th>
                                <th>Penilaian Harian</th>
                                <th>Nilai UTS</th>
                                <th>Nilai UAS</th>
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
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-perkd" role="tabpanel" aria-labelledby="custom-tabs-one-perkd-tab">
                    <div class="row">
                      <div class="col-12">
                        <!-- /.card -->
                        <div class="card">
                          <!-- /.card-header -->
                          <div class="card-body table-responsive">
                            <table id="tPengolahan" class="table table-bordered table-striped">
                              <div class="float-right">
                                <small><i>* Nilai Akhir KD = Rata-rata nilai tiap KD berdasarkan PH dan Rencana Penilaian</i></small><br/>
                                <small><i>* Apabila terdapat kolom yang kosong berarti admin belum menginput data interval predikat atau KKM</i></small>
                              </div>
                              <thead style="background-color:#2D5E89; color:#fff;">
                              <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th width="30%">Kompetensi Dasar</th>
                                <th>Nilai Akhir KD</th>
                                <th>Predikat</th>
                              </tr>
                              </thead>
                              <tbody>

                              </tbody>

                              <tfoot>
                              <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th width="30%">Kompetensi Dasar</th>
                                <th>Nilai Akhir KD</th>
                                <th>Predikat</th>
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
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-rapor" role="tabpanel" aria-labelledby="custom-tabs-one-rapor-tab">
                    <div class="row">
                      <div class="col-12">
                        <!-- /.card -->
                        <div class="card">
                          <!-- /.card-header -->
                          <div class="card-body table-responsive">
                            <table id="tRapor" class="table table-bordered table-striped">
                              <div class="float-right">
                                <small><i>* Nilai Angka = (2 x Rata-rata nilai seluruh KD + UTS + UAS)/4</i></small>
                              </div>
                              <thead style="background-color:#2D5E89; color:#fff;">
                              <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Angka</th>
                                <th>Predikat</th>
                                <th>Deskripsi</th>
                              </tr>
                              </thead>
                              <tbody>

                              </tbody>

                              <tfoot>
                              <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Angka</th>
                                <th>Predikat</th>
                                <th>Deskripsi</th>
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
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>

            <div class="card card-primary card-tabs" id="divKeterampilan" style="display:none;">
              <div class="card-header p-0 pt-1" style="background:#17a2b8;">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-rinciank-tab" data-toggle="pill" href="#custom-tabs-one-rinciank" role="tab" aria-controls="custom-tabs-one-rinciank" aria-selected="true">Rincian Nilai Siswa</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-perkdk-tab" data-toggle="pill" href="#custom-tabs-one-perkdk" role="tab" aria-controls="custom-tabs-one-perkdk" aria-selected="false">Pengolahan Nilai Per KD</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-rapork-tab" data-toggle="pill" href="#custom-tabs-one-rapork" role="tab" aria-controls="custom-tabs-one-rapork" aria-selected="false">Nilai Rapor</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-rinciank" role="tabpanel" aria-labelledby="custom-tabs-one-rinciank-tab">
                    <div class="row">
                      <div class="col-12">
                        <!-- /.card -->
                        <div class="card">
                          <!-- /.card-header -->
                          <div class="card-body table-responsive">
                            <table id="tRincianK" class="table table-bordered table-striped">
                              <div class="float-right">
                                <small><i>* Apabila ada nilai yang kosong atau 0 maka nilai akan dianggap 0 (pastikan input nilai telah dilakukan)</i></small>
                              </div>
                              <thead style="background-color:#2D5E89; color:#fff;">
                              <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th width="30%">Kompetensi Dasar <small>(Rencana Penilaian)</small></th>
                                <th>Penilaian Harian</th>
                              </tr>
                              </thead>
                              <tbody>

                              </tbody>

                              <tfoot>
                              <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th width="30%">Kompetensi Dasar <small>(Rencana Penilaian)</small></th>
                                <th>Penilaian Harian</th>
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
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-perkdk" role="tabpanel" aria-labelledby="custom-tabs-one-perkdk-tab">
                    <div class="row">
                      <div class="col-12">
                        <!-- /.card -->
                        <div class="card">
                          <!-- /.card-header -->
                          <div class="card-body table-responsive">
                            <table id="tPengolahanK" class="table table-bordered table-striped">
                              <div class="float-right">
                                <small><i>* Nilai Akhir KD = Rata-rata nilai tiap KD berdasarkan PH dan Rencana Penilaian</i></small><br/>
                                <small><i>* Apabila terdapat kolom yang kosong berarti admin belum menginput data interval predikat atau KKM</i></small>
                              </div>
                              <thead style="background-color:#2D5E89; color:#fff;">
                              <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th width="30%">Kompetensi Dasar</th>
                                <th>Nilai Akhir KD</th>
                                <th>Predikat</th>
                              </tr>
                              </thead>
                              <tbody>

                              </tbody>

                              <tfoot>
                              <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th width="30%">Kompetensi Dasar</th>
                                <th>Nilai Akhir KD</th>
                                <th>Predikat</th>
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
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-rapork" role="tabpanel" aria-labelledby="custom-tabs-one-rapork-tab">
                    <div class="row">
                      <div class="col-12">
                        <!-- /.card -->
                        <div class="card">
                          <!-- /.card-header -->
                          <div class="card-body table-responsive">
                            <table id="tRaporK" class="table table-bordered table-striped">
                              <div class="float-right">
                                <small><i>* Nilai Angka = (2 x Rata-rata nilai seluruh KD + UTS + UAS)/4</i></small>
                              </div>
                              <thead style="background-color:#2D5E89; color:#fff;">
                              <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Angka</th>
                                <th>Predikat</th>
                                <th>Deskripsi</th>
                              </tr>
                              </thead>
                              <tbody>

                              </tbody>

                              <tfoot>
                              <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Angka</th>
                                <th>Predikat</th>
                                <th>Deskripsi</th>
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
        } else if ($.trim(idmata_pelajaran)==''){
            showToast('Silahkan pilih mata pelajaran !',1000,'error');
            $(".error-message2").append('<div class="font-italic text-danger" id="error-message2"><small>* silahkan isi sesuai format yang diminta</small></div>');
            $('#jumlah_ph').val('');
        } else if ($.trim(tipe)==''){
            showToast('Silahkan pilih tipe penilaian !',1000,'error');
            $(".error-message3").append('<div class="font-italic text-danger" id="error-message3"><small>* silahkan isi sesuai format yang diminta</small></div>');
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
        $("#idkelas").on("change", function( ) {
            $('#idmata_pelajaran').val('');
            $('#divNilai').fadeOut();
        });

        $("#idmata_pelajaran").on("change", function( ) {
            $('#list_tipe').val('');
            $('#divNilai').fadeOut();
        });


        $("#list_tipe").on("change", function( ) {
            removeErrorMessages();
            if(formValidation()){
            var idkelas = $('#idkelas').val();
            var idmata_pelajaran = $('#idmata_pelajaran').val();
            var tipe = $(this).val();

            if (tipe=='pengetahuan'){
                $('#divKeterampilan').fadeOut();
                $('#divPengetahuan').fadeIn();
                fDatatables("tRincian","<?=base_url('administrator/Hasil_pengetahuan/ajax_list_rincian/')?>"+idkelas+"/"+idmata_pelajaran,"ASC");
                fDatatables("tPengolahan","<?=base_url('administrator/Hasil_pengetahuan/ajax_list_pengolahan/')?>"+idkelas+"/"+idmata_pelajaran,"ASC");
                fDatatables("tRapor","<?=base_url('administrator/Hasil_pengetahuan/ajax_list_rapor/')?>"+idkelas+"/"+idmata_pelajaran,"ASC");
            } else if (tipe=='keterampilan'){
                $('#divPengetahuan').fadeOut();
                $('#divKeterampilan').fadeIn();
                fDatatables("tRincianK","<?=base_url('administrator/Hasil_keterampilan/ajax_list_rincian/')?>"+idkelas+"/"+idmata_pelajaran,"ASC");
                fDatatables("tPengolahanK","<?=base_url('administrator/Hasil_keterampilan/ajax_list_pengolahan/')?>"+idkelas+"/"+idmata_pelajaran,"ASC");
                fDatatables("tRaporK","<?=base_url('administrator/Hasil_keterampilan/ajax_list_rapor/')?>"+idkelas+"/"+idmata_pelajaran,"ASC");
            }
            return false;
            };
        });

    })
</script>

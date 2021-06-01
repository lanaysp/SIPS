<!-- Content Wrapper. Contains page content -->
<div id="refresh"></div>
<div class="content-wrapper" id="refresh_content">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <section class="col-lg-12 connectedSortable">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h5><?=$nama_aplikasi?></h5>
                <p><?=$ket_aplikasi?></p>
                <button id="btn-show-covid" type="button" class="btn-sm btn-danger animate__animated animate__backInRight animate__delay-1s" data-toggle="modal" data-target="#modal_corona">Waspada Corona <i class="ion ion-stats-bars"></i></button>
                <div class="icon">
                  <i class="ion ion-ribbon-b"></i>
                </div>
              </div>
            </div>
         </section>
        </div>
        
        <!-- MODAL -->
        <div class="modal fade" id="modal_corona" data-backdrop="static">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-header" style="background-color:#293D55; color:white;">
                  <h6 class="modal-title">INFO PERKEMBANGAN COVID 19 REALTIME</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  
                </div>
                </form>
              </div>
            </div>
          </div>
        <!-- END MODAL -->

        <!-- /.row -->
        <div class="row" id="info-data">
          <div class="col-lg-4 col-6">
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?=$total_siswa?> <sup style="font-size: 20px"><small>Siswa</small></sup></h3>
                <p>Total Siswa Diampu</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?=base_url('walikelas/nilai_akhir/')?>" class="small-box-footer">Radar Nilai Rapor <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-6">
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?=$total_kelas?> <sup style="font-size: 20px"><small>Kelas Diampu</small></sup></h3>
                <p><?=$kelas_diampu?></p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?=base_url('walikelas/deskripsi_sikap/')?>" class="small-box-footer">Proses Deskripsi Sikap <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-6">
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?=$total_mapel?> <sup style="font-size: 20px"><small>Mata Pelajaran Diampu</small></sup></h3>
                <p><?=$mapel_diampu?></p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?=base_url('walikelas/nilai_akhir/')?>" class="small-box-footer">Radar Nilai Rapor <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-md-4">
            <!-- Profile Image -->
            <div class="card card-primary card-outline" style="border-top:3px solid #2D5E89;">
              <div class="card-body box-profile">
                <div class="text-center">
                  <a href="<?=base_url('assets/upload/profile/')?><?=$logo_aplikasi?>" data-toggle="lightbox" data-title="<?=$logo_aplikasi?>">
                  <img class="profile-user-img img-fluid img-circle"
                       src="<?=base_url('assets/upload/profile/thumbnails/')?><?=$logo_aplikasi?>"
                       alt="User profile picture">
                  </a>
                </div>

                <h3 class="profile-username text-center"><?=$nama?></h3>

                <p class="text-muted text-center">Tahun Pelajaran <?=$tahun_pelajaran?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>NPSN</b> <a class="float-right"><?=$npsn?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Status</b> <a class="float-right"><?=$status?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Bentuk Pendidikan</b> <a class="float-right"><?=$bentuk_pendidikan?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Status Kepemilikan</b> <a class="float-right"><?=$status_kepemilikan?></a>
                  </li>
                  <li class="list-group-item">
                    <b>SK Pendirian Sekolah</b> <a class="float-right"><?=$sk_pendirian?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Tanggal SK  Pendirian</b> <a class="float-right"><?=date('d-M-Y',strtotime($tanggal_sk_pendirian))?></a>
                  </li>
                  <li class="list-group-item">
                    <b>SK Izin Operasional</b> <a class="float-right"><?=$sk_izin?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Tanggal SK Izin Operasional</b> <a class="float-right"><?=date('d-M-Y',strtotime($tanggal_sk_izin))?></a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
          </div>

          <div class="col-lg-8">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card card-primary">
              <div class="card-header" style="background-color:#2D5E89; color:#fff;">
                <i class="fas fa-edit"></i> <span>Data Profil Sekolah</span>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Nama</strong>

                <p class="text-muted">
                  <?=$nama?>
                </p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Tahun Pelajaran</strong>

                <p class="text-muted"><?=$p_tahun_pelajaran?></p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>

                <p class="text-muted"><?=$alamat?>, <?=$provinsi?>, <?=$kota?>, <?=$kecamatan?>, <?=$kodepos?></p>

                <hr>

                <strong><i class="fas fa-phone mr-1"></i> No Telepon</strong>

                <p class="text-muted">
                  <?=$telepon?>
                </p>

                <hr>

                <strong><i class="far fa-envelope mr-1"></i> Email</strong>

                <p class="text-muted"><?=$email?></p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
<!-- /.modal -->
<script type="text/javascript">
  $('#modal_corona').on('show.bs.modal', function () { 
    $("#modal_corona").find(".modal-body").html("<center>Mohon ditunggu, data sedang diproses ..</center>");
    $.ajax({
      url: "<?=base_url('walikelas/Dashboard/corona/')?>",
      type: "post",
      success: function(data){
        $("#modal_corona").find(".modal-body").html(data);
      }
    });
  });
</script>
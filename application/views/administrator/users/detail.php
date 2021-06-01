<!-- Content Wrapper. Contains page content -->
<!-- REFRESH -->
<div id="refresh_content"></div>
<!-- REFRESH -->
<div id="refresh" class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
         <section class="col-lg-12 connectedSortable">
            <!-- small box -->
            <a href="<?=base_url('administrator/users')?>" class="btn btn-warning text-light"><b><i class="far fa-arrow-alt-circle-left"></i> kembali</b></a>
            <div class="small-box bg-primary">
              <div class="inner">
                <center><h5><?=$u_nama_awal?> <?=$u_nama_akhir?></h5></center>
              </div>
            </div>
         </section>
        </div>
        <div class="row">
          <!-- Left col -->
          <div class="col-md-4">
            <!-- Profile Image -->
            <div class="card card-primary card-outline" style="border-top:3px solid #2D5E89;">
              <div class="card-body box-profile">
                <div class="text-center">
                  <a href="<?=base_url('assets/upload/guru/')?><?=$u_photo_users?>" data-toggle="lightbox" data-title="<?=$u_nama_awal?> <?=$u_nama_akhir?>">
                  <img class="profile-user-img img-fluid img-circle"
                       src="<?=base_url('assets/upload/guru/thumbnails/')?><?=$u_photo_users?>"
                       alt="User profile picture">
                  </a>
                </div>

                <h3 class="profile-username text-center"><?=$u_nama_awal?> <?=$u_nama_akhir?></h3>

                <p class="text-muted text-center"><?=$users_status?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Nama Lengkap</b> <a class="float-right"><?=$u_nama_awal?> <?=$u_nama_akhir?></a>
                  </li>
                  <li class="list-group-item">
                    <b>NBM/NIP</b> <a class="float-right"><?=$u_nbm_nip?></a>
                  </li>
                  <li class="list-group-item">
                    <b>NUPTK/NUKS</b> <a class="float-right"><?=$u_nuptk_nuks?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Tempat Lahir</b> <a class="float-right"><?=$u_provinsi_lahir?>, <?=$u_kota_lahir?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Tanggal Lahir</b> <a class="float-right"><?= date('d-m-Y',strtotime($u_tanggal_lahir))?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Jenis Kelamin</b> <a class="float-right"><?=$u_jk?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Status Kepegawaian</b> <a class="float-right"><?=$u_status_pegawai?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Tugas Tambahan</b> <a class="float-right"><?=$u_tugas_tambahan?></a>
                  </li>
                  <li class="list-group-item">
                    <b>No Telepon</b> <a class="float-right"><?=$u_telepon?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Email Aktif</b> <a class="float-right"><?=$u_email?></a>
                  </li>
                </ul>

                <center><a href="#" class="btn btn-primary col-lg-5" onclick="return edit();"><b>Ubah Data</b></a>
                <a href="#" class="btn btn-warning col-lg-6" onclick="return edit_password();"><b>Ubah Password</b></a></center>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="col-lg-8">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card card-primary card-tabs">
              <div class="card-header" style="background-color:#2D5E89;">
                <i class="fas fa-edit"></i> <span>Data User : <?=$u_nama_awal?> <?=$u_nama_akhir?></span>
              </div>
              <div class="card-header p-0 pt-1" style="background:#17a2b8;">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-1-tab" data-toggle="pill" href="#custom-tabs-one-1" role="tab" aria-controls="custom-tabs-one-1" aria-selected="true">Profil</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-2-tab" data-toggle="pill" href="#custom-tabs-one-2" role="tab" aria-controls="custom-tabs-one-2" aria-selected="false">Diklat</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-3-tab" data-toggle="pill" href="#custom-tabs-one-3" role="tab" aria-controls="custom-tabs-one-3" aria-selected="false">Mata Pelajaran</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-1" role="tabpanel" aria-labelledby="custom-tabs-one-1-tab">

                    <strong><i class="fas fa-book mr-1"></i> Ijazah Terakhir</strong>
                    <div class="text-muted">Jenjang : <?=$u_jenjang?></div>
                    <div class="text-muted">Jurusan : <?=$u_jurusan?></div>
                    <div class="text-muted">Nama Perguruan Tinggi : <?=$u_perguruan_tinggi?></div>
                    <div class="text-muted">Tahun Lulus : <?=$u_tahun_lulus?></div>
                    <hr>
                    <strong><i class="fas fa-book mr-1"></i> Tunjangan APBD</strong>
                    <p class="text-muted">
                      <?=$u_apbd?>
                    </p>
                    <hr>
                    <strong><i class="fas fa-book mr-1"></i> NPWP</strong>
                    <p class="text-muted">
                      <?=$u_npwp?>
                    </p>
                    <hr>
                    <strong><i class="fas fa-book mr-1"></i> Sertifikasi</strong>
                    <div class="text-muted">Status : <?=$u_sertifikasi_status?></div>
                    <div class="text-muted">Tahun Lulus : <?=$u_sertifikasi_tahun?></div>
                    <hr>

                    <strong><i class="fas fa-book mr-1"></i> Prestasi Kerja</strong>
                    <p class="text-muted">
                      <?=$u_prestasi?>
                    </p>
                    <hr>
                    <strong><i class="fas fa-book mr-1"></i> Nominal Honor</strong>
                    <p class="text-muted">
                      Rp. <?=number_format($u_nominal_honor)?>
                    </p>
                    <hr>
                    <strong><i class="fas fa-book mr-1"></i> Pekerjaan Suami/Istri</strong>
                    <p class="text-muted">
                      <?=$u_kerja_pasangan?>
                    </p>
                    <hr>
                    <strong><i class="fas fa-book mr-1"></i> Alamat Tempat Tinggal</strong>
                    <p class="text-muted">
                      <?=$u_alamat_tinggal?>
                    </p>
                    <hr>

                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-2" role="tabpanel" aria-labelledby="custom-tabs-one-2-tab">

                    <strong><i class="fas fa-book mr-1"></i> Diklat Yang Pernah Diikuti</strong>
                    <a href="#" onclick="return edit_diklat(0)" class="btn btn-sm btn-primary text-light float-right">(+) Tambah Diklat</a>
                    <p></p>
                    <?php
                    if ($diklat!=''):
                    foreach($diklat as $row): ?>
                    <div class="text-muted">Nama Diklat : <?=$row->d_nama?> </div>
                    <div class="text-muted">Penyelenggara : <?=$row->d_penyelenggara?></div>
                    <div class="text-muted">Tahun : <?=$row->d_tahun?></div>
                    <a href="#" onclick="return edit_diklat(<?=$row->iddiklat?>)" class="btn btn-sm btn-info text-light"><i class="fa fa-edit"></i></a>
                    <a href="#" onclick="return delete_diklat('<?=$row->iddiklat?>','<?=htmlspecialchars($row->d_nama)?>')" class="btn btn-sm btn-danger text-light"><i class="fa fa-window-close"></i></a>
                    <hr>
                  <?php endforeach; endif;?>

                  </div>

                  <div class="tab-pane fade" id="custom-tabs-one-3" role="tabpanel" aria-labelledby="custom-tabs-one-3-tab">

                    <strong><i class="fas fa-book mr-1"></i> Mata Pelajaran Yang Diajarkan</strong>
                    <a href="#" onclick="return edit_mapel(0)" class="btn btn-sm btn-primary text-light float-right">(+) Tambah Mapel</a>
                    <p></p>
                    <?php
                    $i = 0;
                    if ($mapel!=''):
                    foreach($mapel as $row):
                    $i ++;
                    ?>
                    <p class="text-muted"><?=$i?>. <?=$row->mp_kode?> - <?=$row->mp_nama?>
                    <span class="float-right">
                    <a href="#" onclick="return edit_mapel(<?=$row->idmata_pelajaran_guru?>)" class="btn btn-sm btn-info text-light"><i class="fa fa-edit"></i></a>
                    <a href="#" onclick="return delete_mapel('<?=$row->idmata_pelajaran_guru?>','<?=htmlspecialchars($row->mp_nama)?>')" class="btn btn-sm btn-danger text-light"><i class="fa fa-window-close"></i></a></span>
                    </p>
                  <?php endforeach; endif;?>
                    <hr>

                    <strong><i class="fas fa-book mr-1"></i> Kelas Yang Diampu</strong>
                    <a href="#" onclick="return edit_kelas(0)" class="btn btn-sm btn-primary text-light float-right">(+) Tambah Kelas</a>
                    <p></p>
                    <?php
                    if ($kelas!=''):
                    foreach($kelas as $row): ?>
                    <p class="text-muted"><?=$row->k_romawi?> (<?=$row->k_keterangan?>)
                    <span class="float-right">
                    <a href="#" onclick="return edit_kelas(<?=$row->idkelas_guru?>)" class="btn btn-sm btn-info text-light"><i class="fa fa-edit"></i></a>
                    <a href="#" onclick="return delete_kelas('<?=$row->idkelas_guru?>','<?=htmlspecialchars($row->k_keterangan)?>')" class="btn btn-sm btn-danger text-light"><i class="fa fa-window-close"></i></a></span></p>
                  <?php endforeach; endif;?>
                    <hr>

                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>

              <!-- /.card-header -->

            <!-- /.card -->

          </section>
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <div class="modal fade" id="modal_data_profil" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#293D55; color:white;">
          <h5 class="modal-title">Ubah Profil Administrator</h5>
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
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Profil <span class="error-tab1"></span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-one-photo-tab" data-toggle="pill" href="#custom-tabs-one-photo" role="tab" aria-controls="custom-tabs-one-photo" aria-selected="true">Photo <span class="error-tab2"></span></a>
                    </li>
                  </ul>
                </div>
                <form class="form-horizontal" method="post" name="f_data" id="f_data" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <div class="card-body">
                        <input type="hidden" name="idusers" id="idusers" value="<?=$idusers?>">
                        <?=form_input($current_kota);?>
                        <div class="form-group">
                          <label for="u_nama_awal">Nama awal</label>
                          <div class="error-message1"></div>
                          <input type="text" name="u_nama_awal" class="form-control" id="u_nama_awal" placeholder="<?=$u_nama_awal?>" value="<?=$u_nama_awal?>" required="">
                        </div>
                        <div class="form-group">
                          <label for="u_nama_akhir">Nama akhir</label>
                          <div class="error-message2"></div>
                          <input type="text" name="u_nama_akhir" class="form-control" id="u_nama_akhir" placeholder="<?=$u_nama_akhir?>" value="<?=$u_nama_akhir?>">
                        </div>
                        <div class="form-group">
                          <label for="u_jenis_kelamin">Status User</label>
                          <div class="error-message21"></div>
                          <?=form_dropdown('',$edit_groups,$edit_groups_select,$edit_groups_attr)?>
                        </div>
                        <div class="form-group">
                          <label for="u_nbm_nip">NBM/NIP</label>
                          <div class="error-message3"></div>
                          <input type="text" name="u_nbm_nip" class="form-control" id="u_nbm_nip" placeholder="<?=$u_nbm_nip?>" value="<?=$u_nbm_nip?>" required="">
                        </div>
                        <div class="form-group">
                          <label for="u_nuptk_nuks">NUPTK/NUKS</label>
                          <div class="error-message4"></div>
                          <input type="text" name="u_nuptk_nuks" class="form-control" id="u_nuptk_nuks" placeholder="<?=$u_nuptk_nuks?>" value="<?=$u_nuptk_nuks?>">
                        </div>
                        <div class="form-group">
                          <label for="$u_tempat_lahir">Tempat Lahir</label>
                          <div class="error-message5"></div>
                          <?=form_dropdown('',$edit_provinsi,$edit_provinsi_select,$edit_provinsi_attribute)?><br/>
                          <?=form_dropdown('',$edit_kota,$edit_kota_select,$edit_kota_attribute)?><br/>
                        </div>
                        <div class="form-group">
                          <label for="u_tanggal_lahir">Tanggal Lahir</label>
                          <div class="error-message6"></div>
                          <input type="date" name="u_tanggal_lahir" class="form-control" id="u_tanggal_lahir" placeholder="<?=$u_tanggal_lahir?>" value="<?=$u_tanggal_lahir?>" required="">
                        </div>
                        <div class="form-group">
                          <label for="u_jenis_kelamin">Jenis Kelamin</label>
                          <div class="error-message7"></div>
                          <?=form_dropdown('',$edit_jenis_kelamin,$edit_jenis_kelamin_select,$edit_jenis_kelamin_attr)?>
                        </div>
                        <div class="form-group">
                          <label for="u_status_pegawai">Status Kepegawaian</label>
                          <div class="error-message8"></div>
                          <input type="text" name="u_status_pegawai" class="form-control" id="u_status_pegawai" placeholder="<?=$u_status_pegawai?>" value="<?=$u_status_pegawai?>" required="">
                        </div>
                        <div class="form-group">
                          <label for="u_tugas_tambahan">Tugas Tambahan</label>
                          <div class="error-message9"></div>
                          <input type="text" name="u_tugas_tambahan" class="form-control" id="u_tugas_tambahan" placeholder="<?=$u_tugas_tambahan?>" value="<?=$u_tugas_tambahan?>">
                        </div>
                        <div class="form-group">
                          <label for="u_telepon">No Telepon</label>
                          <div class="error-message10"></div>
                          <input type="number" name="u_telepon" class="form-control" id="u_telepon" placeholder="<?=$u_telepon?>" value="<?=$u_telepon?>" required="">
                        </div>
                        <div class="form-group">
                          <label for="u_email">Email Aktif</label>
                          <div class="error-message11"></div>
                          <input type="email" name="u_email" class="form-control" id="u_email" placeholder="<?=$u_email?>" value="<?=$u_email?>" required="">
                        </div>
                        <div class="form-group">
                          <label for="u_jenjang">Ijazah Terakhir</label>
                          <div class="error-message12"></div>
                          <input type="text" name="u_jenjang" class="form-control" id="u_jenjang" placeholder="<?=$u_jenjang?>" value="<?=$u_jenjang?>" required=""><br/>
                          <input type="text" name="u_perguruan_tinggi" class="form-control" id="u_perguruan_tinggi" placeholder="<?=$u_perguruan_tinggi?>" value="<?=$u_perguruan_tinggi?>" required=""><br/>
                          <input type="text" name="u_jurusan" class="form-control" id="u_jurusan" placeholder="<?=$u_jurusan?>" value="<?=$u_jurusan?>"><br/>
                          <input type="number" name="u_tahun_lulus" class="form-control" id="u_tahun_lulus" placeholder="<?=$u_tahun_lulus?>" value="<?=$u_tahun_lulus?>" required="">
                        </div>
                        <div class="form-group">
                          <label for="u_tunjangan">Tunjangan APBD</label>
                          <div class="error-message13"></div>
                          <input type="text" name="u_tunjangan" class="form-control" id="u_tunjangan" placeholder="<?=$u_tunjangan?>" value="<?=$u_tunjangan?>">
                        </div>
                        <div class="form-group">
                          <label for="u_npwp">NPWP</label>
                          <div class="error-message14"></div>
                          <input type="text" name="u_npwp" class="form-control" id="u_npwp" placeholder="<?=$u_npwp?>" value="<?=$u_npwp?>">
                        </div>
                        <div class="form-group">
                          <label for="u_sertifikasi">Sertifikasi</label>
                          <div class="error-message15"></div>
                          <select class="form-control" name="u_sertifikasi" id="u_sertifikasi">
                            <option value="" hidden>- Pilih Status -</option>
                            <option value="Sudah" <?php if($u_sertifikasi_status=='Sudah'){echo "selected";}?>>Sudah</option>
                            <option value="Belum" <?php if($u_sertifikasi_status=='Belum'){echo "selected";}?>>Belum</option>
                          </select><br/>
                          <?php if($u_sertifikasi_status=='Sudah'){ ?>
                            <input type="number" name="u_sertifikasi_tahun" class="form-control" id="u_sertifikasi_tahun" placeholder="<?=$u_sertifikasi_tahun?>" value="<?=$u_sertifikasi_tahun?>">
                          <?php } else { ?>
                            <input type="number" name="u_sertifikasi_tahun" class="form-control" id="u_sertifikasi_tahun" placeholder="" value="" style="display:none;">
                          <?php } ?>
                        </div>
                        <div class="form-group">
                          <label for="u_prestasi">Prestasi Kerja</label>
                          <div class="error-message16"></div>
                          <input type="text" name="u_prestasi" class="form-control" id="u_prestasi" placeholder="<?=$u_prestasi?>" value="<?=$u_prestasi?>">
                        </div>
                        <div class="form-group">
                          <label for="u_nominal_honor">Nominal Honor</label>
                          <div class="error-message17"></div>
                          <input type="number" name="u_nominal_honor" class="form-control" id="u_nominal_honor" placeholder="<?=$u_nominal_honor?>" value="<?=$u_nominal_honor?>" required="">
                        </div>
                        <div class="form-group">
                          <label for="u_kerja_pasangan">Pekerjaan Suami/Istri</label>
                          <div class="error-message18"></div>
                          <input type="text" name="u_kerja_pasangan" class="form-control" id="u_kerja_pasangan" placeholder="<?=$u_kerja_pasangan?>" value="<?=$u_kerja_pasangan?>">
                        </div>
                        <div class="form-group">
                          <label for="u_alamat_tinggal">Alamat Tinggal</label>
                          <div class="error-message19"></div>
                          <input type="text" name="u_alamat_tinggal" class="form-control" id="u_alamat_tinggal" placeholder="<?=$u_alamat_tinggal?>" value="<?=$u_alamat_tinggal?>" required="">
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade show" id="custom-tabs-one-photo" role="tabpanel" aria-labelledby="custom-tabs-one-photo-tab">
                      <div class="card-body">
                        <div class="form-group">
                            <label for="u_photo_users" class="col-sm-3 control-label">Photo</label>
                            <div class="error-message20"></div>
                            <div class="col-sm-12">
                              <input type="file" name="u_photo_users" id="u_photo_users" class="form-control-file"><br/>
                              <div id="uploadPreview"></div>
                              <?php
                                  echo "<img style='max-width:60%;' data-image='$u_photo_users' src='".base_url('assets/upload/guru/')."$u_photo_users' class='thumb img-responsive current-img-remove'> ";
                              ?>
                            </div>
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
  <!-- PASSWORD -->
  <div class="modal fade" id="modal_data_password" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#293D55; color:white;">
          <h5 class="modal-title">Ubah Password</h5>
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
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Password <span class="error-tab1"></span></a>
                    </li>
                  </ul>
                </div>
                <form class="form-horizontal" method="post" name="f_password" id="f_password">
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <div class="card-body">
                        <div class="form-group">
                          <label for="old">Password Lama</label>
                          <div class="error-message-p1"></div>
                          <input type="hidden" name="identity" class="form-control" id="identity" value="<?=$u_email?>" required>
                          <input type="hidden" name="u_status" class="form-control" id="u_status" value="users" required>
                          <input type="password" name="old" class="form-control" id="old" required>
                        </div>
                        <div class="form-group">
                          <label for="new">Password Baru</label>
                          <div class="error-message-p2"></div>
                          <input type="password" name="new" class="form-control" id="new" required>
                        </div>
                        <div class="form-group">
                          <label for="new_confirm">Konfirmasi Password Baru</label>
                          <div class="error-message-p3"></div>
                          <input type="password" name="new_confirm" class="form-control" id="new_confirm" required>
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
          <button type="submit" class="btn btn-primary" id="btn-save-password">Simpan</button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- PASSWORD -->
  <!-- DIKLAT -->
  <div class="modal fade" id="modal_data_diklat" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#293D55; color:white;">
          <h5 class="modal-title">Ubah Diklat</h5>
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
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Diklat <span class="error-tab1"></span></a>
                    </li>
                  </ul>
                </div>
                <form class="form-horizontal" method="post" name="f_diklat" id="f_diklat">
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <div class="card-body">
                        <div class="form-group">
                          <!-- -->
                          <input type="hidden" name="_id_diklat" id="_id_diklat" value="">
                          <input type="hidden" name="_mode_diklat" id="_mode_diklat" value="">
                          <input type="hidden" name="idusers" id="idusers" value="<?=$idusers?>">
                          <!-- -->
                          <label for="d_nama">Nama Diklat</label>
                          <div class="error-message-d1"></div>
                          <input type="text" name="d_nama" class="form-control" id="d_nama" placeholder="" value="" required>
                        </div>
                        <div class="form-group">
                          <label for="u_status_pegawai">Penyelenggara</label>
                          <div class="error-message-d2"></div>
                          <input type="text" name="d_penyelenggara" class="form-control" id="d_penyelenggara" placeholder="" value="" required>
                        </div>
                        <div class="form-group">
                          <label for="u_status_pegawai">Tahun</label>
                          <div class="error-message-d3"></div>
                          <input type="text" name="d_tahun" class="form-control" id="d_tahun" placeholder="" value="" required>
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
          <button type="submit" class="btn btn-primary" id="btn-save-diklat">Simpan</button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- DIKLAT -->
  <!-- MAPEL -->
  <div class="modal fade" id="modal_data_mapel" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#293D55; color:white;">
          <h5 class="modal-title">Ubah Mata Pelajaran</h5>
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
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Mata Pelajaran <span class="error-tab1"></span></a>
                    </li>
                  </ul>
                </div>
                <form class="form-horizontal" method="post" name="f_mapel" id="f_mapel">
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <div class="card-body">
                        <div class="form-group">
                          <!-- -->
                          <input type="hidden" name="_id_mapel" id="_id_mapel" value="">
                          <input type="hidden" name="_mode_mapel" id="_mode_mapel" value="">
                          <input type="hidden" name="idusers" id="idusers" value="<?=$idusers?>">
                          <!-- -->
                          <label for="mata_pelajaran">Mata Pelajaran</label>
                          <div class="error-message-m1"></div>
                          <?=form_dropdown('',$edit_mapel,'',$edit_mapel_attr)?>
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
          <button type="submit" class="btn btn-primary" id="btn-save-mapel">Simpan</button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- MAPEL -->
  <!-- KELAS -->
  <div class="modal fade" id="modal_data_kelas" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#293D55; color:white;">
          <h5 class="modal-title">Ubah Kelas</h5>
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
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Kelas <span class="error-tab1"></span></a>
                    </li>
                  </ul>
                </div>
                <form class="form-horizontal" method="post" name="f_kelas" id="f_kelas">
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <div class="card-body">
                        <div class="form-group">
                          <!-- -->
                          <input type="hidden" name="_id_kelas" id="_id_kelas" value="">
                          <input type="hidden" name="_mode_kelas" id="_mode_kelas" value="">
                          <input type="hidden" name="idusers" id="idusers" value="<?=$idusers?>">
                          <!-- -->
                          <label for="kelas">Kelas</label>
                          <div class="error-message-k1"></div>
                          <?=form_dropdown('',$edit_kelas,'',$edit_kelas_attr)?>
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
          <button type="submit" class="btn btn-primary" id="btn-save-kelas">Simpan</button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- KELAS -->
<!-- /.modal -->

<script type="text/javascript">
  function readImage(file) {
    var reader = new FileReader();
    var image  = new Image();

    reader.readAsDataURL(file);
    reader.onload = function(_file) {
      image.src = _file.target.result; // url.createObjectURL(file);
      image.onload = function() {
        var w = this.width,
            h = this.height,
            t = file.type, // ext only: // file.type.split('/')[1],
            n = file.name,
            s = ~~(file.size/1024) +'KB';
      $('#uploadPreview').append('<img style="max-width:150px" src="' + this.src + '" class="thumb img-responsive img-remove"> ');
        $(".img-remove").click(function(){
          $(".img-remove").attr('src', '').hide();
          $("#u_photo_users").val('');
        });
      };

      image.onerror= function() {
        alert('Invalid file type: '+ file.type);
      };
    };
  }

  $(".current-img-remove").click(function(){
    $(".current-img-remove").attr('src', '').hide();
    $(".current-img-remove").attr('data-image', '').hide();
    $("#u_photo_users").val('');
  });

  $("#u_photo_users").change(function (e) {
    if(this.disabled) {
      return alert('File upload not supported!');
    }
    var F = this.files;
    if (F.length > 1){
      $("#u_photo_users").val('');
      return alert('Gambar tidak boleh lebih dari 1');
    }
    if (F[0]) {
      for (var i = 0; i < F.length; i++) {
      $(".img-remove").attr('src', '').hide();
      $(".current-img-remove").attr('src', '').hide();
      $(".current-img-remove").attr('data-image', '').hide();
        readImage(F[i]);
      }
    }
  });

  $('#u_email').on('change', function (e){
    e.preventDefault();
    var email = $(this).val();
    $.ajax({
        type: "POST",
        data: {u_email:email},
        url: base_url+"Users/check_email",
        success: function(r) {
            if (r.status == "gagal") {
              $('#u_email').val('');
              showToast('Email sudah dipakai, silahkan gunakan email lainnya',1000,'error');
            }
        }
    });
    return false;
  });

  $('#u_telepon').on('change', function (e){
    e.preventDefault();
    var telepon = $(this).val();
    if (telepon<0){
      $('#s_telepon').val(0);
      showToast('No telepon tidak boleh bernilai minus',1000,'error');
      return false;
    }
    $.ajax({
        type: "POST",
        data: {u_telepon:telepon},
        url: base_url+"Users/check_telepon",
        success: function(r) {
            if (r.status == "gagal") {
              $('#u_telepon').val('');
              showToast('No telepon sudah dipakai, silahkan gunakan nomor lainnya',1000,'error');
            }
        }
    });
    return false;
  });

  function formValidationData()
  {
    var u_nama_awal = $('#u_nama_awal').val();
    var u_nama_akhir = $('#u_nama_akhir').val();
    var u_nbm_nip = $('#u_nbm_nip').val();
    var u_tempat_lahir = $('#u_tl_idkota').val();
    var u_tanggal_lahir = $('#u_tanggal_lahir').val();
    var u_jenis_kelamin = $('#u_jenis_kelamin').val();
    var u_status_pegawai = $('#u_status_pegawai').val();
    var u_telepon = $('#u_telepon').val();
    var u_email = $('#u_email').val();
    var u_jenjang = $('#u_jenjang').val();
    var u_perguruan_tinggi = $('#u_perguruan_tinggi').val();
    var u_tahun_lulus = $('#u_tahun_lulus').val();
    var u_sertifikasi = $('#u_sertifikasi').val();
    var u_sertifikasi_tahun = $('#u_sertifikasi_tahun').val();
    var u_nominal_honor = $('#u_nominal_honor').val();
    var u_alamat_tinggal = $('#u_alamat_tinggal').val();
    var users_groups = $('#users_groups').val();

    var re = new RegExp(/^(\d{4})$/);
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

    var images_length = document.getElementById('u_photo_users').files.length;
    var images = $('#u_photo_users')[0].files[0];
    var current_images = $(".current-img-remove").attr('data-image');

    if ($.trim(u_nama_awal)==''){
      showToast('Nama awal tidak boleh kosong !',1000,'error');
      $(".error-message1").append('<div class="font-italic text-danger" id="error-message1"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(users_groups)==''){
      showToast('Status user tidak boleh kosong !',1000,'error');
      $(".error-message21").append('<div class="font-italic text-danger" id="error-message21"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_nbm_nip)==''){
      showToast('NBM/NIP tidak boleh kosong !',1000,'error');
      $(".error-message3").append('<div class="font-italic text-danger" id="error-message3"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_tempat_lahir)==''){
      showToast('Tempat lahir tidak boleh kosong !',1000,'error');
      $(".error-message5").append('<div class="font-italic text-danger" id="error-message5"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_tanggal_lahir)==''){
      showToast('Tanggal lahir tidak boleh kosong !',1000,'error');
      $(".error-message6").append('<div class="font-italic text-danger" id="error-message6"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_jenis_kelamin)==''){
      showToast('Jenis kelamin tidak boleh kosong !',1000,'error');
      $(".error-message7").append('<div class="font-italic text-danger" id="error-message7"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_status_pegawai)==''){
      showToast('Status pegawai tidak boleh kosong !',1000,'error');
      $(".error-message8").append('<div class="font-italic text-danger" id="error-message8"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_telepon)==''){
      showToast('Telepon tidak boleh kosong !',1000,'error');
      $(".error-message10").append('<div class="font-italic text-danger" id="error-message10"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_email)=='' || !emailReg.test(u_email)){
      showToast('Email tidak boleh kosong atau tidak sesuai format !',1000,'error');
      $(".error-message11").append('<div class="font-italic text-danger" id="error-message11"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_jenjang)==''){
      showToast('Jenjang tidak boleh kosong !',1000,'error');
      $(".error-message12").append('<div class="font-italic text-danger" id="error-message12"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_perguruan_tinggi)==''){
      showToast('Perguruan tinggi tidak boleh kosong !',1000,'error');
      $(".error-message12").append('<div class="font-italic text-danger" id="error-message12"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_tahun_lulus)=='' || !re.test(u_tahun_lulus)){
      showToast('Tahun lulus tidak boleh kosong atau tidak sesuai format !',1000,'error');
      $(".error-message12").append('<div class="font-italic text-danger" id="error-message12"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_sertifikasi)=='Sudah' && $.trim(u_sertifikasi_tahun)=='' || $.trim(u_sertifikasi)=='Sudah' && !re.test(u_sertifikasi_tahun)){
      showToast('Tahun sertifikasi tidak boleh kosong !',1000,'error');
      $(".error-message15").append('<div class="font-italic text-danger" id="error-message15"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_nominal_honor)==''){
      showToast('Nominal honor tidak boleh kosong !',1000,'error');
      $(".error-message16").append('<div class="font-italic text-danger" id="error-message16"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(u_alamat_tinggal)==''){
      showToast('Alamat tinggal tidak boleh kosong !',1000,'error');
      $(".error-message19").append('<div class="font-italic text-danger" id="error-message19"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if (images_length<1 && current_images==''){
      showToast('Foto tidak boleh kosong !',1000,'error');
      $(".error-message20").append('<div class="font-italic text-danger" id="error-message20"><small>* silahkan isi sesuai format yang diminta</small></div>');
      $(".error-tab2").append('<span id="badge-danger-tab2" class="badge badge-danger">!</span>');
    } else {
      return true;
    }
  }

  function formValidationPassword()
  {
    var new_password = $('#new').val();
    var new_confirm = $('#new_confirm').val();

    if (new_confirm!=new_password){
      showToast('Konfirmasi password tidak sama !',1000,'error');
      $(".error-message-p3").append('<div class="font-italic text-danger" id="error-message-p3"><small>* konfirmasi password tidak sama</small></div>');
    } else {
      return true;
    }
  }

  function formValidationDiklat()
  {
    var d_nama = $('#d_nama').val();
    var d_penyelenggara = $('#d_penyelenggara').val();
    var d_tahun = $('#d_tahun').val();

    var re = new RegExp(/^(\d{4})$/);

    if ($.trim(d_nama)==''){
      showToast('Nama diklat tidak boleh kosong !',1000,'error');
      $(".error-message-d1").append('<div class="font-italic text-danger" id="error-message-d1"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(d_penyelenggara)==''){
      showToast('Penyelenggara diklat tidak boleh kosong !',1000,'error');
      $(".error-message-d2").append('<div class="font-italic text-danger" id="error-message-d2"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if ($.trim(d_tahun)==''){
      showToast('Tahun tidak boleh kosong !',1000,'error');
      $(".error-message-d3").append('<div class="font-italic text-danger" id="error-message-d3"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else if (!re.test(d_tahun)){
      showToast('Format tahun salah !',1000,'error');
      $(".error-message-d3").append('<div class="font-italic text-danger" id="error-message-d3"><small>* format tahun salah</small></div>');
    } else {
      return true;
    }
  }

  function formValidationMapel()
  {
    var mata_pelajaran = $('#mata_pelajaran').val();

    if ($.trim(mata_pelajaran)==''){
      showToast('Mata pelajaran tidak boleh kosong !',1000,'error');
      $(".error-message-m1").append('<div class="font-italic text-danger" id="error-message-m1"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else {
      return true;
    }
  }

  function formValidationKelas()
  {
    var kelas = $('#kelas').val();

    if ($.trim(kelas)==''){
      showToast('Kelas tidak boleh kosong !',1000,'error');
      $(".error-message-k1").append('<div class="font-italic text-danger" id="error-message-k1"><small>* silahkan isi sesuai format yang diminta</small></div>');
    } else {
      return true;
    }
  }

  function removeErrorMessagesData()
  {
    $("#error-message1").remove();
    $("#error-message2").remove();
    $("#error-message3").remove();
    $("#error-message4").remove();
    $("#error-message5").remove();
    $("#error-message6").remove();
    $("#error-message7").remove();
    $("#error-message8").remove();
    $("#error-message9").remove();
    $("#error-message10").remove();
    $("#error-message11").remove();
    $("#error-message12").remove();
    $("#error-message13").remove();
    $("#error-message14").remove();
    $("#error-message15").remove();
    $("#error-message16").remove();
    $("#error-message17").remove();
    $("#error-message18").remove();
    $("#error-message19").remove();
    $("#error-message20").remove();
    $("#error-message21").remove();
  }

  function removeErrorMessagesPassword()
  {
    $("#error-message-p3").remove();
  }

  function removeErrorMessagesDiklat()
  {
    $("#error-message-d1").remove();
    $("#error-message-d2").remove();
    $("#error-message-d3").remove();
  }

  function removeErrorMessagesMapel()
  {
    $("#error-message-m1").remove();
  }

  function removeErrorMessagesKelas()
  {
    $("#error-message-k1").remove();
  }

  function edit(id)
  {
    $("#modal_data_profil").modal('show');
  }

  function edit_password(id)
  {
    $("#modal_data_password").modal('show');
  }

  function edit_diklat(id)
  {
    if (id == 0) {
        $("#_mode_diklat").val('add');
    } else {
        $("#_mode_diklat").val('edit');
    }
    $('#modal_data_diklat').modal('show');
    $.ajax({
        type: "GET",
        url: base_url+"Users/edit_diklat/"+id,
        success: function(result) {
            $("#_id_diklat").val(result.data.iddiklat);
            $("#d_nama").val(result.data.d_nama);
            $("#d_penyelenggara").val(result.data.d_penyelenggara);
            $("#d_tahun").val(result.data.d_tahun);
            $('#btn-save-diklat').prop('disabled',false);
        }
    });
    return false;
  }

  function edit_mapel(id)
  {
    if (id == 0) {
        $("#_mode_mapel").val('add');
    } else {
        $("#_mode_mapel").val('edit');
    }
    $('#modal_data_mapel').modal('show');
    $.ajax({
        type: "GET",
        url: base_url+"Users/edit_mapel/"+id,
        success: function(result) {
            $("#_id_mapel").val(result.data.idmata_pelajaran_guru);
            $("#mata_pelajaran").val(result.data.idmata_pelajaran);
            $('#btn-save-mapel').prop('disabled',false);
        }
    });
    return false;
  }

  function edit_kelas(id)
  {
    if (id == 0) {
        $("#_mode_kelas").val('add');
    } else {
        $("#_mode_kelas").val('edit');
    }
    $('#modal_data_kelas').modal('show');
    $.ajax({
        type: "GET",
        url: base_url+"Users/edit_kelas/"+id,
        success: function(result) {
            $("#_id_kelas").val(result.data.idkelas_guru);
            $("#kelas").val(result.data.idkelas);
            $('#btn-save-kelas').prop('disabled',false);
        }
    });
    return false;
  }

  $('#u_tl_idprovinsi').on('change', function(){
    var idprovinsi = $('#u_tl_idprovinsi').val();
    $.ajax({
      url: '<?=base_url('administrator/data/read_kota/')?>'+idprovinsi,
      dataType: 'html',
      success: function(data){
        $('#u_tl_idkota').html(data);
      }
    });
  });

  $(document).ready(function(){
    $("#f_data").on("submit", function(e) {
      e.preventDefault();
      removeErrorMessagesData();
      if(formValidationData()){
        $('#btn-save').prop('disabled',true);
        var form = $('#f_data')[0];
        var data = new FormData(form);
        var images = $('#u_photo_users')[0].files[0];
        var u_sertifikasi = $('#u_sertifikasi').val();
        var u_sertifikasi_tahun = $('#u_sertifikasi_tahun').val();
        if (u_sertifikasi == 'Belum'){
          data.append("u_sertifikasi_tahun",'');
        } else {
          data.append("u_sertifikasi_tahun",u_sertifikasi_tahun);
        }
        if (images===undefined){
          data.append("attach",'N');
        } else {
          data.append("attach",'Y');
          data.append("files",images);
        }
        $.ajax({
            type: "POST",
            data: data,
            cache:false,
            contentType: false,
            processData: false,
            url: base_url+"Users/update_data",
            success: function(r) {
                if (r.status == "gagal") {
                    showToast('Data gagal disimpan !',1000,'error');
                    $('#btn-save').prop('disabled',false);
                } else if (r.status == "ok") {
                    $("#modal_data_profil").modal('hide');
                    showToast('Data berhasil disimpan !',1000,'success');
                    $("#refresh_content").load(" #refresh");
                    $("#refresh").hide();
                    $('#btn-save').prop('disabled',false);
                } else {
                    $("#modal_data_profil").modal('hide');
                    showToast('Data sudah ada !',1000,'warning');
                }
            }
        });
        return false;
      }
    });

    $("#f_password").on("submit", function(e) {
      e.preventDefault();
      removeErrorMessagesPassword();
      if(formValidationPassword()){
        $('#btn-save-password').prop('disabled',true);
        var data = $(this).serialize();
        $.ajax({
            type: "POST",
            data: data,
            url: auth_url+"change_password",
            success: function(r) {
                if (r.status == "gagal") {
                    showToast('Password gagal diubah, silahkan periksa lebih detail password lama dan kesamaan password baru yang akan diganti! Password baru tidak boleh kurang dari 8 karakter',4000,'error');
                    $('#btn-save-password').prop('disabled',false);
                } else if (r.status == "ok") {
                    $("#modal_data_password").modal('hide');
                    showToast('Password berhasil diubah !',1000,'success');
                    $('#btn-save-password').prop('disabled',false);
                }
            }
        });
        return false;
      }
    });

    $("#f_diklat").on("submit", function(e) {
      e.preventDefault();
      removeErrorMessagesDiklat();
      if(formValidationDiklat()){
        $('#btn-save-diklat').prop('disabled',true);
        var data = $(this).serialize();
        $.ajax({
            type: "POST",
            data: data,
            url: base_url+"Users/save_diklat",
            success: function(r) {
                if (r.status == "gagal") {
                    showToast('Data gagal disimpan !',1000,'error');
                    $('#btn-save-diklat').prop('disabled',false);
                } else if (r.status == "ok") {
                    $("#modal_data_diklat").modal('hide');
                    showToast('Data berhasil disimpan !',1000,'success');
                    $("#refresh_content").load(" #refresh");
                    $("#refresh").hide();
                } else {
                    $("#modal_data_diklat").modal('hide');
                    showToast('Data sudah ada !',1000,'warning');
                }
            }
        });
        return false;
      }
    });

    $("#f_mapel").on("submit", function(e) {
      e.preventDefault();
      removeErrorMessagesMapel();
      if(formValidationMapel()){
        $('#btn-save-mapel').prop('disabled',true);
        var data = $(this).serialize();
        $.ajax({
            type: "POST",
            data: data,
            url: base_url+"Users/save_mapel",
            success: function(r) {
                if (r.status == "gagal") {
                    showToast('Data gagal disimpan !',1000,'error');
                    $('#btn-save-mapel').prop('disabled',false);
                } else if (r.status == "ok") {
                    $("#modal_data_mapel").modal('hide');
                    showToast('Data berhasil disimpan !',1000,'success');
                    $("#refresh_content").load(" #refresh");
                    $("#refresh").hide();
                } else {
                    $("#modal_data_mapel").modal('hide');
                    showToast('Data sudah ada !',1000,'warning');
                }
            }
        });
        return false;
      }
    });

    $("#f_kelas").on("submit", function(e) {
      e.preventDefault();
      removeErrorMessagesKelas();
      if(formValidationKelas()){
        $('#btn-save-kelas').prop('disabled',true);
        var data = $(this).serialize();
        $.ajax({
            type: "POST",
            data: data,
            url: base_url+"Users/save_kelas",
            success: function(r) {
                if (r.status == "gagal") {
                    showToast('Data gagal disimpan !',1000,'error');
                    $('#btn-save-kelas').prop('disabled',false);
                } else if (r.status == "ok") {
                    $("#modal_data_kelas").modal('hide');
                    showToast('Data berhasil disimpan !',1000,'success');
                    $("#refresh_content").load(" #refresh");
                    $("#refresh").hide();
                } else {
                    $("#modal_data_kelas").modal('hide');
                    showToast('Data sudah ada !',1000,'warning');
                }
            }
        });
        return false;
      }
    });

    $("#u_sertifikasi").on("change", function(e) {
      e.preventDefault();
      var status = $('#u_sertifikasi').val();
      if(status=='Sudah'){
        $('#u_sertifikasi_tahun').show();
      } else {
        $('#u_sertifikasi_tahun').hide();
      }
    });

  })

  function delete_diklat(id,data) {
    if (id == 0) {
      showToast('Silahkan pilih data yang akan dihapus !',1000,'error');
    }
    if (confirm('Apakah anda yakin ingin menghapus diklat '+data+'..? ')) {
      $.ajax({
      type: "GET",
      url: base_url+"Users/delete_diklat/"+id,
      success: function(r) {
        if (r.status == 'ok'){
          showToast('Data berhasil dihapus !',1000,'success');
          $("#refresh_content").load(" #refresh");
          $("#refresh").hide();
        } else {
          showToast('Data gagal dihapus !',1000,'error');
        }
      }
      });
    }
    return false;
  }

  function delete_mapel(id,data) {
    if (id == 0) {
      showToast('Silahkan pilih data yang akan dihapus !',1000,'error');
    }
    if (confirm('Apakah anda yakin ingin menghapus mata pelajaran '+data+'..? ')) {
      $.ajax({
      type: "GET",
      url: base_url+"Users/delete_mapel/"+id,
      success: function(r) {
        if (r.status == 'ok'){
          showToast('Data berhasil dihapus !',1000,'success');
          $("#refresh_content").load(" #refresh");
          $("#refresh").hide();
        } else {
          showToast('Data gagal dihapus !',1000,'error');
        }
      }
      });
    }
    return false;
  }

  function delete_kelas(id,data) {
    if (id == 0) {
      showToast('Silahkan pilih data yang akan dihapus !',1000,'error');
    }
    if (confirm('Apakah anda yakin ingin menghapus kelas '+data+'..? ')) {
      $.ajax({
      type: "GET",
      url: base_url+"Users/delete_kelas/"+id,
      success: function(r) {
        if (r.status == 'ok'){
          showToast('Data berhasil dihapus !',1000,'success');
          $("#refresh_content").load(" #refresh");
          $("#refresh").hide();
        } else {
          showToast('Data gagal dihapus !',1000,'error');
        }
      }
      });
    }
    return false;
  }
</script>

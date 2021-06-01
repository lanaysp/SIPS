<div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-outline" style="background-color:#2D5E89; color:#fff;">
              <div class="card-header">
                <h3 class="card-title" style="padding-top:8px;">
                  <i class="fas fa-edit"></i>
                  Konfigurasi Website
                </h3>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body table-responsive">
                <!-- Bootstrap Switch -->
                <div class="card card-secondary">
                    <div class="card-header" style="background-color:#17a2b8;">
                        <h3 class="card-title">Pengaturan & Database</h3>
                    </div>
                    <div class="card-body">
                        <label for="naik_kelas">Kenaikan Kelas</label><br/>
                        <input type="checkbox" name="naik_kelas" id="naik_kelas" <?php if($naik_kelas=='1'){echo "checked";} ?> data-value="<?=$naik_kelas?>" data-bootstrap-switch data-off-color="danger" data-on-color="success">
                    </div>
                    <div class="card-body">
                        <label for="check_rapor">Check Rapor</label><br/>
                        <input type="checkbox" name="check_rapor" id="check_rapor" <?php if($check_rapor=='1'){echo "checked";} ?> data-value="<?=$check_rapor?>" data-bootstrap-switch data-off-color="danger" data-on-color="success">
                    </div>
                    <div class="card-body">
                        <label for="reset_password">Reset Password Guru / Guru Kelas</label><br/>
                        <input type="checkbox" name="reset_password" id="reset_password" <?php if($reset_password=='1'){echo "checked";} ?> data-value="<?=$reset_password?>" data-bootstrap-switch data-off-color="danger" data-on-color="success">
                    </div>
                    <div class="card-body">
                        <label for="new_version">MODE PENILAIAN K13 SD-SMP-SMA EDISI REVISI 2016 <small><i style="color:red;">(silahkan matikan jika ingin mode penilaian K13 MTs)</i></small></label><br/>
                        <input type="checkbox" name="new_version" id="new_version" <?php if($new_version=='1'){echo "checked";} ?> data-value="<?=$new_version?>" data-bootstrap-switch data-off-color="danger" data-on-color="success">
                    </div>
                    <div class="card-body border border-primary col-12 col-md-4">
                        <label for="backup_database">Backup Database</label><br/>
                        <a href="<?=base_url('administrator/database/backup_database')?>" target="_blank" class="btn btn-primary text-light">Backup Database</a>
                        <br/><br/>
                        <label for="backup_database">Restore Database</label><br/>
                        <?php echo form_open_multipart(base_url('administrator/database/upload_database_restore'),array('id'=>'f_restore'));?>
                        <input type="file" name="userfile" id="userfile" size="20" required/>
                        <br/><br/>
                        <input type="submit" value="Restore Database" class="btn btn-info text-light" id="btn-restore"/>
                        <?=form_close()?>
                    </div>
                    <div class="card-body">
                        <label for="no_validate_delete">Penghapusan Tanpa Validasi <small><i style="color:red"><br/>* hati-hati ketika mengaktifkan fitur ini, gunakan bila anda sudah mempertimbangkan dengan matang resiko yang akan terjadi, seluruh data terhubung akan terhapus</i></small></label><br/>
                        <input type="checkbox" name="no_validate_delete" id="no_validate_delete" <?php if($no_validate_delete=='1'){echo "checked";} ?> data-value="<?=$no_validate_delete?>" data-bootstrap-switch data-off-color="danger" data-on-color="success">
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<script type="text/javascript">
    $("input[data-bootstrap-switch]").each(function(){
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

    $(document).ready(function(){
        $("#f_restore").on("submit", function() {
          $('#btn-restore').prop('disabled',true);
        });

        $("#userfile").on("change", function() {
          $('#btn-restore').prop('disabled',false);
        });

        $('#naik_kelas').on('switchChange.bootstrapSwitch',function () {
            var config_name = 'naik_kelas';

            $.ajax({
              type: "POST",
              data: {config_name:config_name},
              url: "<?=base_url('administrator/Web_config/change_value/')?>",
              success: function(r) {
                if (r.status == "ok") {
                  showToast('Status berhasil diubah',1000,'success');
                } else {
                  showToast('Status gagal diubah',1000,'error');
                }
              }
            });
            return false;
        });

        $('#check_rapor').on('switchChange.bootstrapSwitch',function () {
            var config_name = 'check_rapor';

            $.ajax({
              type: "POST",
              data: {config_name:config_name},
              url: "<?=base_url('administrator/Web_config/change_value/')?>",
              success: function(r) {
                if (r.status == "ok") {
                  showToast('Status berhasil diubah',1000,'success');
                } else {
                  showToast('Status gagal diubah',1000,'error');
                }
              }
            });
            return false;
        });

        $('#reset_password').on('switchChange.bootstrapSwitch',function () {
            var config_name = 'reset_password';

            $.ajax({
              type: "POST",
              data: {config_name:config_name},
              url: "<?=base_url('administrator/Web_config/change_value/')?>",
              success: function(r) {
                if (r.status == "ok") {
                  showToast('Status berhasil diubah',1000,'success');
                } else {
                  showToast('Status gagal diubah',1000,'error');
                }
              }
            });
            return false;
        });

        $('#new_version').on('switchChange.bootstrapSwitch',function () {
            var config_name = 'new_version';

            $.ajax({
              type: "POST",
              data: {config_name:config_name},
              url: "<?=base_url('administrator/Web_config/change_value/')?>",
              success: function(r) {
                if (r.status == "ok") {
                  showToast('Status berhasil diubah',1000,'success');
                } else {
                  showToast('Status gagal diubah',1000,'error');
                }
              }
            });
            return false;
        });

        $('#no_validate_delete').on('switchChange.bootstrapSwitch',function () {
            var config_name = 'no_validate_delete';

            $.ajax({
              type: "POST",
              data: {config_name:config_name},
              url: "<?=base_url('administrator/Web_config/change_value/')?>",
              success: function(r) {
                if (r.status == "ok") {
                  showToast('Status berhasil diubah',1000,'success');
                } else {
                  showToast('Status gagal diubah',1000,'error');
                }
              }
            });
            return false;
        });
    });
</script>

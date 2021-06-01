<!DOCTYPE html>
<html lang="en">
  <?php $this->load->view('auth/_partials/header'); ?>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background:#000;">
					<span class="login100-form-title-1">
						Ubah Password Baru
					</span>
				</div>

				<div class="login100-pic js-tilt" data-tilt>
					<img src="<?=base_url('assets/login/')?>images/dikdasmen.png" alt="IMG">
					<h3 style="color:#FFF; text-align:center;">SEKOLAH DASAR</h3>
					<p style="color:#FFF; text-align:center;">Sistem Informasi Penilaian Siswa</p>
				</div>
        <?php echo form_open("auth/reset_password/" . $code,  array('class'=>'login100-form validate-form'));?>
          <div class="wrap-input100 validate-input" data-validate = "Password is required">
            <?php echo form_input($new_password);?>
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-lock" aria-hidden="true"></i>
            </span>
          </div>
          <div class="wrap-input100 validate-input" data-validate = "Password is required">
						<?php echo form_input($new_password_confirm);?>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					<?php echo form_input($user_id);?>
					<?php echo form_hidden($csrf); ?>
          <div id="infoMessage"><?php echo $message;?></div>
					<div class="container-login100-form-btn">
						<?php echo form_submit('submit', 'Ubah Password',array('class'=>'login100-form-btn'));?>
					</div>
				<?php echo form_close();?>
			</div>
		</div>
	</div>

  <?php $this->load->view('auth/_partials/footer'); ?>

</body>
</html>

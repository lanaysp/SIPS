<!DOCTYPE html>
<html lang="en">
  <?php $this->load->view('auth/_partials/header'); ?>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background:#000;">
					<span class="login100-form-title-1">
						<?=$nama_sekolah?>
					</span>
				</div>

				<div class="login100-pic js-tilt" data-tilt>
					<img style="padding-left:5%; padding-bottom:3%;" src="<?=base_url('assets/upload/profile/thumbnails/')?><?=$logo_aplikasi?>" alt="IMG">
					<h4 style="color:#FFF; text-align:center;"><?=strtoupper($nama_aplikasi)?></h4>
					<p style="color:#FFF; text-align:center;"><?=strtoupper($nama_sekolah)?><br/><?=$alamat_sekolah?><br/>(<i class="fa fa-phone"></i>) <?=$telepon_sekolah?></p>
				</div>

				<div class="login100-form validate-form" id="choose-menu">
					<div class="wrap-input100 validate-input"><br/>
						<a class="login100-form-btn text-light" id="btn-check-rapor">Check E-Rapor</a><br/>
						<a class="login100-form-btn text-light" id="btn-login-guru">Login USER</a><br/>
						<a class="login100-form-btn text-light" data-toggle="modal" data-target="#modal_info">LANDASAN DASAR</a>
					</div>
				</div>

				<div class="login100-form validate-form" style="background-color:#eee8e8; display:none" id="check-rapor">
					<div class="wrap-input100 validate-input">
						<?php echo form_dropdown('',$tahun,'',$tahun_attribut); ?>
					</div>
					<span id="input-nisn">
						<input class="form-control col-md-12" style="padding-bottom:4px;" type="text" placeholder="NISN" id="nisn" required/>
						<br/><a class="btn btn-sm btn-info text-light" id="btn-send-code">Kirim Kode OTP</a>
					</span>
					<span id="input-verify-code" style="display:none;">
						<input class="col-md-6" style="padding-bottom:4px;" type="text" placeholder="Kode verifikasi" id="verify-code" required/>
						<a class="btn btn-sm btn-info text-light" id="btn-validate-code">Check Rapor</a><br/>
						<a href="#" class="text-dark"><small>Belum menerima kode? <span id="countdown"></span> <span id="resend-code"><u>kirim ulang</u></span></small></a>
					</span>	
				</div>

				<?php echo form_open("auth/login",array('class'=>'login100-form validate-form','id'=>'f_login','style'=>'display:none;'));?>
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: abcd@abcd.com">
						<?php echo form_input($identity);?>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<?php echo form_input($password);?>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input">
						<?php echo form_dropdown('',$level,'',$level_attribut); ?>
					</div>

					<div class="wrap-input100 validate-input">
						<?php echo form_dropdown('',$tahun,'',$tahun_attribut); ?>
					</div>
					<p><?php echo $captcha ?></p>
					<?php echo $script_captcha; // javascript recaptcha ?>
					<div id="infoMessage"><?php echo $message;?></div>
          			<a href="<?=base_url('auth/forgot_password')?>">lupa password ? klik ini</a>
					<div class="container-login100-form-btn">
						<?php echo form_submit('submit', lang('login_submit_btn'),array('class'=>'login100-form-btn'));?>
					</div>
				<?php echo form_close();?>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal_info">
		<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="background-color:#293D55; color:white;">
			<h6 class="modal-title">[Landasan Dasar Pembuatan Aplikasi]</h6>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			</div>
			<div class="modal-body">
			<h5>Data, Informasi dan Referensi Dalam Perancangan Aplikasi</h5>
			<small><i>Penelitian @ Ghaly Fadhillah 15.12.8378</i></small><br/><br/>
			Download => <a href="<?=base_url('assets/panduan/panduan-penilaian-k13-2016-revisi-sd.pdf')?>">panduan-penilaian-k13-2016-revisi-sd</a><br/>
			Download => <a href="<?=base_url('assets/panduan/panduan-penilaian-k13-2016-revisi-smp.pdf')?>">panduan-penilaian-k13-2016-revisi-smp</a><br/>
			Download => <a href="<?=base_url('assets/panduan/panduan-penilaian-k13-2016-revisi-sma.pdf')?>">panduan-penilaian-k13-2016-revisi-sma</a><br/>
			Download => <a href="<?=base_url('assets/panduan/permendikbud-no-24-tahun-2016-tentang-ki-kd-sd-smp-dan-sma.pdf')?>">permendikbud-no-24-tahun-2016-tentang-ki-kd-sd-smp-dan-sma</a><br/>
			Download => <a href="<?=base_url('assets/panduan/permendikbud-no-81a-2013.pdf')?>">permendikbud-no-81a-2013</a><br/>
			Download => <a href="<?=base_url('assets/panduan/surat keputusan jenderal pendidikan islam no 5161 tahun 2018.pdf')?>">surat keputusan jenderal pendidikan islam no 5161 tahun 2018</a><br/>
			Download => <a href="<?=base_url('assets/panduan/surat keputusan jenderal pendidikan islam no 5162 tahun 2018.pdf')?>">surat keputusan jenderal pendidikan islam no 5162 tahun 2018</a><br/><br/>
			
			Data Percobaan Penilaian => <a href="<?=base_url('assets/panduan/data_nilai/rapor-kelas-5-semester-1-sdmuhammadiyah-bendo.xlsx')?>">rapor-kelas-5-semester-1-sdmuhammadiyah-bendo</a><br/>
			Data Percobaan Penilaian => <a href="<?=base_url('assets/panduan/data_nilai/smpn177-jkt-bahasa-indonesia.pdf')?>">smpn177-jkt-bahasa-indonesia</a><br/>
			Data Percobaan Penilaian => <a href="<?=base_url('assets/panduan/data_nilai/smpn177-jkt-bahasa-inggris.pdf')?>">smpn177-jkt-bahasa-inggris</a><br/>
			Data Percobaan Penilaian => <a href="<?=base_url('assets/panduan/data_nilai/smpn177-jkt-seni-budaya.pdf')?>">smpn177-jkt-seni-budaya</a><br/>
			</div>
		</div>
		</div>
	</div>

  <?php $this->load->view('auth/_partials/footer'); ?>
</body>
</html>

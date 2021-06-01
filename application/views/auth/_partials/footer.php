<!--===============================================================================================-->	
<script src="<?=base_url('assets/login/')?>vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=base_url('assets/login/')?>vendor/bootstrap/js/popper.js"></script>
	<script src="<?=base_url('assets/login/')?>vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=base_url('assets/login/')?>vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=base_url('assets/login/')?>vendor/tilt/tilt.jquery.min.js"></script>
	<!-- SWEETALERT -->
	<script src="<?=base_url('assets/https/sweetalert.min.js')?>"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="<?=base_url('assets/login/')?>js/main.js"></script>
	<script>
		$('#f_login').on('submit',function(e){
			e.preventDefault();
			var data = $(this).serialize();
			if(grecaptcha.getResponse() == "") {
				swal("Recaptcha","Silahkan validasi recaptcha", "warning");
			} else {
				$.ajax({
				type: "POST",
				data: data,
				url: "<?=base_url('auth/login')?>",
				success: function(r) {
					if (r.status == "ok") {
						window.location.href="<?=base_url('auth/')?>";
					} else if (r.status == "gagal") {
						window.location.href="<?=base_url('auth/login')?>";
					}
				}
			});
			return false;
			}
		});
	</script>
	<script type="text/javascript">
		$('#btn-check-rapor').on('click',function(){
			$('#choose-menu').hide();
			$('#check-rapor').fadeIn();
		});

		$('#btn-login-guru').on('click',function(){
			$('#choose-menu').hide();
			$('#f_login').fadeIn();
		});

		$('#btn-send-code').on('click',function(){
			$(this).hide();
			var nisn = $('#nisn').val();
			var tahun = $('#tahun').val();
			if ($.trim(tahun)==''){
				swal("Tahun Pelajaran","Silahkan pilih tahun pelajaran", "warning");
				$('#btn-send-code').show();
			} else if ($.trim(nisn)=='') {
				swal("NISN","Silahkan input NISN", "warning");
				$('#btn-send-code').show();
			} else {
				$.ajax({
				type: "POST",
				data: {nisn:nisn},
				url: "<?=base_url('check_rapor/check_nisn/')?>",
				success: function(r) {
					if (r.status == "ok") {
						swal("OTP Terkirim","Kode verifikasi telah dikirim ke email anda, silahkan periksa email anda", "success");
						$('#input-verify-code').fadeIn();
						$('#btn-send-code').hide();
						$('#nisn').hide();
					} else if (r.status == "email") {
						swal("Gagal","Email tidak terkirim, silahkan coba lagi", "error");
						$('#btn-send-code').show();
					} else if (r.status == "gagal") {
						swal("Gagal","NISN tidak ditemukan", "error");
						$('#btn-send-code').show();
					} else if (r.status == "rapor") {
						swal("Maaf","Belum saatnya melakukan check E-Rapor", "warning");
						$('#btn-send-code').show();
					}
				}
				});
				return false;
			}
		});

		$('#resend-code').on('click',function(){
			var nisn = '';
			$.ajax({
			type: "POST",
			data: {nisn:nisn},
			url: "<?=base_url('check_rapor/check_nisn/')?>",
				success: function(r) {
					if (r.status == "ok") {
						swal("OTP Terkirim","Kode verifikasi telah dikirim ke email anda, silahkan periksa email anda", "success");
					} else {
						swal("Gagal","Email tidak terkirim, silahkan coba lagi", "error");
					}
				}
			});
			$(this).hide();
			$('#countdown').show();
			var timer2 = "0:20";
			var interval = setInterval(function() {
			var timer = timer2.split(':');
			//by parsing integer, I avoid all extra string processing
			var minutes = parseInt(timer[0], 10);
			var seconds = parseInt(timer[1], 10);
			--seconds;
			minutes = (seconds < 0) ? --minutes : minutes;
			if (minutes < 0){
				clearInterval(interval);
				$('#countdown').hide();
				$('#resend-code').show();
			}
			seconds = (seconds < 0) ? 20 : seconds;
			seconds = (seconds < 10) ? seconds : seconds;
			//minutes = (minutes < 10) ?  minutes : minutes;
			$('#countdown').html(seconds);
			timer2 = minutes + ':' + seconds;
			}, 1000);
		});

		$('#btn-validate-code').on('click',function(){
			var code = $('#verify-code').val();
			var tahun = $('#tahun').val();
			if ($.trim(nisn)==''){
				swal("NISN","Silahkan input NISN", "warning");
			} else if ($.trim(tahun)=='') {
				swal("Tahun Pelajaran","Silahkan pilih tahun pelajaran", "warning");
			} else if ($.trim(code)=='') {
				swal("Kode OTP","Silahkan input kode OTP / verifikasi yang dikirim ke email anda", "warning");
			} else {
				$.ajax({
				type: "POST",
				data: {code:code,tahun:tahun},
				url: "<?=base_url('check_rapor/encrypt_id/')?>",
				success: function(r) {
					if (r.status == "ok") {
						window.location.href="<?=base_url('check_rapor/rapor/')?>"+r.tahun+'/'+r.nisn+'/'+r.code;
					} else if (r.status == "gagal") {
						swal("Error","Kode salah atau sudah tidak berlaku lagi", "error");
					}
				}
				});
				return false;
			}
		});
	</script>
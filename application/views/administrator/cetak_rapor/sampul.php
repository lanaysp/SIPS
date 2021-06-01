<!DOCTYPE html>
<html>
<head>
	<title>SIPS | Cetak Sampul</title>
	<style type="text/css">
		body {font-family: arial; font-size: 12pt; border: solid 3px #000; padding-bottom: 100px}
		.table {border-collapse: collapse; border: solid 1px #999; width:100%}
		.table tr td, .table tr th {border:  solid 1px #999; padding: 3px; font-size: 12px}
		.rgt {text-align: right;}
		.ctr {text-align: center;}
	</style>
	<style type="text/css" media="print">
		@media print {
			@page { margin: 0; }
			body { margin: 1cm; }
		}
	</style>
	<link rel="icon" href="<?=base_url('assets/upload/profile/favicon/')?><?=$logo_aplikasi?>" type="image/gif">
</head>
<body onload="window.print()">
	<center>
		<br>
		<img src="<?= base_url('assets/rapor/logo_garuda.jpg') ?>"><br><br><br>
		<span style="font-size: 14pt"><b style="font-size: 18pt">LAPORAN</b><br>
		HASIL PENCAPAIAN KOMPETENSI PESERTA DIDIK<br>
		<?= strtoupper($nama_sekolah) ?>
		</span>
		<br>
		<br>
		<br>
		<br>
		<img style="-webkit-filter: grayscale(100%); filter: grayscale(100%);" src="<?= base_url('assets/upload/profile/thumbnails/')?><?=$logo_aplikasi?>" width="25%;"><br>
		<br>
		<br>
		<br>
		<p>Nama Peserta Didik</p>
		<div style="display: inline-block; font-weight: bold; padding: 15px; width: 300px; border: solid 1px #000"><?= $siswa['s_nama'] ?></div><br>
		<p>NIK / NISN</p>
		<div style="display: inline-block; font-weight: bold; padding: 15px; width: 300px; border: solid 1px #000"><?= $siswa['s_nik'] ?> / <?= $siswa['s_nisn'] ?></div><br>
		<br>
		<br>
		<?=strtoupper($alamat)?>, <?=strtoupper($kecamatan)?><br>
		<?=strtoupper($kota)?>, <?=strtoupper($provinsi)?>
	</center>
</body>
</html>
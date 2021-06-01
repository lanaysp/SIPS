<!DOCTYPE html>
<html>
<head>
	<title>SIPS | Cetak Biodata</title>
	<style type="text/css">
		body {font-family: arial; font-size: 12pt; border: solid 3px #000; padding: 30px 10px; padding-bottom:240px;}
		.table {border-collapse: collapse; border: solid 1px #999; width:100%}
		.table tr td, .table tr th {border:  solid 1px #999; padding: 3px; font-size: 12px}
		.rgt {text-align: right;}
		.ctr {text-align: center;}
		table tr td {vertical-align: top}
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
	<table>
		<tr>
			<td width="10%">
			<img style="-webkit-filter: grayscale(100%); filter: grayscale(100%); width: 110px; filter:brightness(0%)" src="<?= base_url('assets/upload/profile/thumbnails/')?><?=$logo_aplikasi?>">
			</td>
			<td style="text-align: center"><b><?=strtoupper($sekolah->pr_nama_aplikasi)?><br>
			<?=strtoupper($sekolah->pr_ket_aplikasi)?><br>
			<?= strtoupper($sekolah->pr_nama) ?><br></b>
			<span style="font-size: 10pt">Alamat : <?= $sekolah->pr_alamat ?>. <br>
			Telp : <?= $sekolah->pr_telepon ?> | Website : <?=base_url()?></span>
			</td>
		</tr>
		<tr><td colspan="2"><hr style="border: solid 2px #000"></td></tr>
		<tr><td colspan="2" style="text-align: center; font-weight: bold; font-size: 14pt">KETERANGAN DIRI PESERTA DIDIK</td></tr>
		<tr><td colspan="2">
			
			<table width="100%">
				<tr><td width="3%">1.</td><td width="40%">Nama Peserta Didik (Lengkap)</td><td width="2%">:</td><td width="55%"><?= $siswa['s_nama'] ?></td></tr>
				<tr><td>2.</td><td>Nomor Induk</td><td>:</td><td><?= $siswa['s_nik'] ?></td></tr>
				<tr><td>3.</td><td>NISN</td><td>:</td><td><?= $siswa['s_nisn'] ?></td></tr>
				<tr><td>4.</td><td>Tempat, Tanggal Lahir</td><td>:</td><td><?= $siswa['city_name'].", ".tanggal($siswa['s_tanggal_lahir'],"l"); ?></td></tr>
                <?php 
                    if ($siswa['s_jenis_kelamin']=='L'){
                        $jk = 'Laki-laki';
                    } else {
                        $jk = 'Perempuan';
                    }
                ?>
                <tr><td>5.</td><td>Jenis Kelamin</td><td>:</td><td><?=$jk?></td></tr>
				<tr><td>6.</td><td>Anak Ke</td><td>:</td><td> </td></tr>
				<tr><td>7.</td><td>Status dalam Keluarga</td><td>:</td><td> </td></tr>
				<tr><td>8.</td><td>Alamat Peserta Didik</td><td>:</td><td><?=ucwords(strtolower($siswa['s_dusun']))?>, <?=ucwords(strtolower($siswa['s_desa']))?>, <?=ucwords(strtolower($siswa['s_kecamatan']))?></td></tr>
				<tr><td>9.</td><td>Diterima di Sekolah ini</td><td>:</td><td></td></tr>
				<tr><td></td><td>a. Di Kelas</td><td>:</td><td></td></tr>
				<tr><td></td><td>b. Pada Tanggal</td><td>:</td><td></td></tr>
				<tr><td></td><td>c. Semester</td><td>:</td><td></td></tr>
				<tr><td>10.</td><td>Madrasah/Sekolah Asal</td><td>:</td><td></td></tr>
				<tr><td></td><td>a. Nama Madrasah / Sekolah</td><td>:</td><td></td></tr>
				<tr><td></td><td>b. Alamat</td><td>:</td><td></td></tr>
				<tr><td>11.</td><td>Orang Tua / Wali</td><td>:</td><td></td></tr>
				<tr><td></td><td>a. Nama Ayah</td><td>:</td><td><?=$siswa['s_wali']?></td></tr>
				<tr><td></td><td>b. Nama Ibu</td><td>:</td><td></td></tr>
				<tr><td>12.</td><td>Pekerjaan Orang Tua / Wali</td><td>:</td><td></td></tr>
				<tr><td></td><td>a. Ayah</td><td>:</td><td></td></tr>
				<tr><td></td><td>b. Ibu</td><td>:</td><td></td></tr>
			</table>
		</td>
		</tr>		
	</table>
	<br><br>
	<div style="margin-left: 20%; display: inline; float: left; width: 3cm; height: 3.7cm; border: solid 1px #000"></div>
	<div style="margin-left: 120px; display: inline; float: left;">
		<?=$sekolah->city_name?>, <?php echo tanggal(date('Y-m-d'),'l'); ?><br>
		Kepala Sekolah<br>
		<br>
		<br>
		<br>
		<br>
		<b><u><?= $sekolah->pr_kepala_sekolah ?></u></b><br>
		NIP. <?= $sekolah->pr_kepala_nbmnip ?>
	</div>
</body>
</html>
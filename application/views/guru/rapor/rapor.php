<!DOCTYPE html>
<html>
<head>
	<title>Cetak Raport</title>
	<style type="text/css">
		body {font-family: arial; font-size: 11pt; width: 8.5in}
		.table {border-collapse: collapse; border: solid 1px #999; width:100%}
		.table tr td, .table tr th {border:  solid 1px #000; padding: 3px;}
		.table tr th {font-weight: bold; text-align: center}
		.rgt {text-align: right;}
		.ctr {text-align: center;}
		.tbl {font-weight: bold}

		table tr td {vertical-align: top}
		.font_kecil {font-size: 12px}
	</style>
    <script type="text/javascript">
        function PrintWindow() {                    
           window.print();            
           CheckWindowState();
        }
    
        function CheckWindowState()    {           
            if(document.readyState=="complete") {
                window.close(); 
            } else {           
                setTimeout("CheckWindowState()", 1000)
            }
        }
        //PrintWindow();
    </script> 
</head>
<body>
	<table>
		<thead><!-- biar bisa ganti lembar otomatis --></thead>

		<tbody>
		<tr>
			<td colspan="6" style="text-align: center; font-weight: bold"><p><h3>HASIL PENCAPAIAN KOMPETENSI PESERTA DIDIK</h3></p></td>
		</tr>
		<tr>
			<td width="20%">Nama Sekolah</td><td width="1%">:</td><td width="39%" class="tbl"><?= $nama_sekolah ?></td>
			<td width="20%">Kelas</td><td width="1%">:</td><td width="19%" class="tbl"><?= $siswa['s_nisn'] ?></td>
		</tr>
		<tr>
			<td>Alamat Sekolah</td><td>:</td><td class="tbl"><?= $alamat ?></td>
			<td>Semester</td><td>:</td><td class="tbl"><?= $siswa['s_nisn'] ?></td>
		</tr>
		<tr>
			<td>Nama Siswa</td><td>:</td><td class="tbl"><?= $siswa['s_nama'] ?></td>
			<td>Tahun Pelajaran</td><td>:</td><td class="tbl"><?= $tahun_pelajaran ?></td>
		</tr>
		<tr>
			<td>NIS / NISN</td><td>:</td><td class="tbl"><?= $siswa['s_nisn'] ?></td>
			<td colspan="3"></td>
		</tr>
		<tr><td colspan="6"><br><br></td></tr>
		<tr><td colspan="6"><b>A. Sikap</b></td></tr>
		<tr><td colspan="6">
			<table style="margin-left: 15px">
				<tr><td width="3%"><b>1.</b></td><td width="97%"><b>Sikap Spiritual</b></td></tr>
				<tr><td></td><td style="border: solid 1px #000; padding: 10px"><?=$siswa['s_nama']?> <?= $nilai_spiritual ?> dan sudah mampu meningkatkan <?= $nilai_spiritual_meningkat ?></td></tr>
				<tr><td width="3%"><b>2.</b></td><td width="97%"><b>Sikap Sosial</b></td></tr>
				<tr><td></td><td style="border: solid 1px #000; padding: 10px"><?=$siswa['s_nama']?> <?= $nilai_sosial ?> dan sudah mampu meningkatkan <?= $nilai_sosial_meningkat ?></td></tr>
			</table>
		</td></tr>
		<tr><td colspan="6"><b>B. Pengetahuan dan Keterampilan</b></td></tr>
		<tr><td colspan="6">
			<table class="table">
				<thead>
				<tr>
					<th colspan="2" rowspan="2" width="30%">Mata Pelajaran</th>
					<th rowspan="2">KKM</th>
					<th colspan="3">Pengetahuan</th>
					<th colspan="3">Keterampilan</th>
				</tr>
				<tr>
					<th width="5%">Angka</th>
					<th width="5%">Predikat</th>
					<th width="25%">Deskripsi</th>
					<th width="5%">Angka</th>
					<th width="5%">Predikat</th>
					<th width="25%">Deskripsi</th>
				</tr>
				
				</thead>
				<tbody>
				<?php echo $nilai_pengetahuan_keterampilan; ?>
				</tbody>
			</table>
		</td></tr>
		<tr><td colspan="6"><br><b>C. Ekstrakurikuler</b></td></tr>
		<tr><td colspan="6">
			<table class="table">
				<thead>
					<tr>
						<th width="5%">No</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="10%">Nilai</th>
						<th width="55%">Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?= $nilai_ekstrakurikuler ?>
				</tbody>
			</table>
		</td></tr>
		<tr><td colspan="6"><br><b>D. Ketidakhadiran</b></td></tr>
		<tr>
			<td colspan="6">
				<table width="100%">
					<tr>
						<td width="40%">
							<table class="table" width="100%">
								<tr><td width="60%">Sakit</td><td width="40%" class="ctr"><?= $nilai_kehadiran_sakit ?> &nbsp; hari</td></tr>
								<tr><td>Izin</td><td class="ctr"><?= $nilai_kehadiran_izin ?> &nbsp; hari</td></tr>
								<tr><td>Tanpa Keterangan</td><td class="ctr"><?= $nilai_kehadiran_tk ?> &nbsp; hari</td></tr>
							</table>
						</td>
						<td width="60%">
						</td>
					</tr>
				</table>
			</td>
		</tr>		
		<tr><td colspan="6"><br><b>E. Catatan Wali Kelas</b></td></tr>
		<tr>
			<td colspan="6">
				<div style="border: solid 1px; padding: 10px;">
            	    <?= $nilai_catatan ?>
        	    </div>
			</td>
		</tr>
		<tr><td colspan="6"><br><b>F. Periodik Siswa</b></td></tr>
		<tr><td colspan="6">
			<table class="table">
				<thead>
					<tr>
						<th width="5%">No</th>
						<th width="30%">Aspek Penilaian</th>
						<th width="55%">Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?= $nilai_periodik ?>
				</tbody>
			</table>
		</td></tr>
		<tr><td colspan="6"><br><b>G. Kondisi Kesehatan</b></td></tr>
		<tr><td colspan="6">
			<table class="table">
				<thead>
					<tr>
						<th width="5%">No</th>
						<th width="30%">Aspek Fisik</th>
						<th width="55%">Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?= $nilai_kesehatan ?>
				</tbody>
			</table>
		</td></tr>
		
		<tr><td colspan="6"><br><b>H. Prestasi</b></td></tr>
		<tr><td colspan="6">
			<table class="table">
				<thead>
					<tr>
						<th width="5%">No</th>
						<th width="30%">Jenis Prestasi</th>
						<th width="55%">Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?= $nilai_prestasi ?>
				</tbody>
			</table>
		</td></tr>
		<?php 
		if (2 == 2) {
		?>
		<tr>
		    <td colspan="6">
		        <?php 
		        $naik_kelas = 1;
		        $kelas_now = 2;
		        
			    if ($kelas_now != 9) {
		        ?>
		        
		        <div style="border: solid 1px; padding: 10px; margin-top: 40px">
            		<b>Keputusan : </b>
            	    <p>Berdasarkan pencapaian kompetensi pada semester ke-1 dan ke-2, peserta didik ditetapkan *) :<br>
            	    <div style="display: block">
                	    <div style="diplay: inline; float: left; width: 200px">naik ke kelas </div>
                	    <div style="diplay: inline; float: left; font-weight: bold">WKWKKW</div>
            	    </div><br>
            	    <div style="display: block">
                	    <div style="diplay: inline; float: left; width: 200px"><strike>tinggal di kelas</strike> </div>
                	    <div style="diplay: inline; float: left; font-weight: bold"><strike>WKWKWK</strike></div>
                    </div> 
                    <br><br>
            	    *) Coret yang tidak perlu
        	    </div>
        	    
        	    <?php } else { ?>
        	    <div style="border: solid 1px; padding: 10px; margin-top: 40px">
            		<b>Keputusan : </b>
            	    <p>Berdasarkan pencapaian kompetensi pada kelas 7, 8 dan 9, maka, peserta didik dinyatakan : *) :<br>
            	    <div style="display: block; font-weight: bold">
                	    LULUS / <strike>TIDAK LULUS</strike>
            	    </div><br><br>
            	    *) Coret yang tidak perlu
        	    </div>
        	    
        	    <?php } ?>
		    </td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="6">
				<br><br>
				<table width="100%">
					<tr>
						<td width="8%"></td>
						<td width="20%">
							Mengetahui : <br>
							Orang Tua/Wali, <br>
							<br><br><br><br>
							<u>..........................</u>
						</td>
						<td width="8%"></td>
						<td width="25%">
							<br>
							Wali Kelas <br>
							<br><br><br><br>
							<u><b><?= $walikelas ?></b></u><br>
							NIP. <?= $walikelas_nbmnip ?>
						</td>
						<td width="8%"></td>
						<td width="29%">
							<?= $kota ?>, <?= tanggal(date('Y-m-d'),"l"); ?><br>
							Kepala <?= $nama ?> <br>
							<br><br><br><br>
							<u><b><?= $kepala_sekolah ?></b></u><br>
							NIP. <?= $kepala_nbmnip ?>
						</td>
					</tr>
				</table>

			</td>
		</tr>

		</tbody>
	</table>
</body>
</html>
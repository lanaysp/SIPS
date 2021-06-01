<!DOCTYPE html>
<html>
<head>
	<title>SIPS | Cetak Leger</title>
	<style type="text/css">
		body {font-family: arial; font-size: 12pt}
		.table {border-collapse: collapse; border: solid 1px #999; width:100%}
		.table tr td, .table tr th {border:  solid 1px #999; padding: 3px; font-size: 12px}
		.rgt {text-align: right;}
		.ctr {text-align: center;}
	</style>
    <style type="text/css" media="print">
		@media print {
			@page { margin: 0; 
			-webkit-transform: rotate(-90deg); 
			-moz-transform:rotate(-90deg);
			filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
			}
			body { margin: 0.5cm; }
		}
	</style>
	<!-- Theme style -->
	<link rel="stylesheet" href="<?=base_url('assets/main/')?>dist/css/adminlte.min.custom.css">
    <link rel="icon" href="<?=base_url('assets/upload/profile/favicon/')?><?=$logo_aplikasi?>" type="image/gif">
</head>
<body onload="window.print()">
	<?= $cetak_leger; ?>
</body>
</html>
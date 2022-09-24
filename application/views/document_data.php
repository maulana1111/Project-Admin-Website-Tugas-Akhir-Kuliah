<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<style type="text/css">
		th, td{
			padding: 10px;
		}
	</style>
</head>
<body>
<h3 align="center">-- Data Donatur --</h3>
<p>Dari Tanggal = <?php echo $from ?></p>
<p>Sampai Tanggal = <?php echo $to ?></p>
<p>Opsi Data = <?php echo $opsi ?></p>
<table border="1">
	<tr>
		<th>Nama</th>
		<th>Nomor Rekening</th>
		<th>Jumlah</th>
		<th>Organisasi</th>
		<th>Gmail</th>
	</tr>
	<?php foreach($data as $row) { ?>
		<tr>
			<td>
				<?php echo $row['pemilik_rekening'] ?>
			</td>
			<td>
				<?php echo $row['no_rekening'] ?>
			</td>
			<td>
				<?php echo $row['jumlah'] ?>
			</td>
			<td>
				<?php echo $row['organisasi'] ?>
			</td>
			<td>
				<?php echo $row['gmail'] ?>
			</td>
		</tr>
	<?php } ?>
</table>
</body>
</html>
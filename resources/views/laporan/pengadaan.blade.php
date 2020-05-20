<html>
<style>
	html {
		width: 100%;
	}
	.center {
		display: block;
		margin-left: auto;
		margin-right: auto;
		width: 100%;
	}

	h1 {
		text-align: center;
	}

	.column {
		flex: 50%;
	}
	table{
		border-collapse: collapse;
		font-family: arial;
    }

	table th {
		border: 2px solid black;
	}

	table td {
		border: 2px solid black;
	}
</style>
<body>
<div class='center'> 
	<!-- <img src="http://127.0.0.1:8002/assets/img/logo.png" style="width:100%"> -->
	<hr>
	<h1>Laporan Pengadaan Tahunan</h1>
	<p align="left" class="font">Tahun : {{$tahun ?? ''}} </p>
	<hr>
	<table  style='width: 80%'>
		<thead>
			<tr>
				<th>No</th>
				<th>Bulan</th>
				<th>Jumlah Pengeluaran</th>
			</tr>
		</thead>
    	<?php $no=1; ?>
	  	<?php foreach($pengadaan as $p): ?>
		<tr>
			<td  style='text-align:center'><?php echo $no ?></td>
			<td	 style='text-align:center'><?php echo  \Carbon\Carbon::parse($p->bulan)->translatedFormat('F') ?></td>
			<td  style='text-align:center'><?php echo $subtotal ?></td>
    	</tr>
		<?php $no++; ?>
	  	<?php endforeach; ?>
	</table>
	<br>
	<hr>
	<div style='display:flex; text-align:right'>
		<div class='column'>
			<p>TOTAL : <?php echo $subtotal ?? ''?>
			</p>
		</div>
	</div>
	
</div>
<div>
<p align="right">Dicetak tanggal <?php echo $dt ?? '' ?></p></div>
</body>
</html>
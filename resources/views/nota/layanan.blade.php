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

	table th+th {
		border-left: 2px solid black;
	}

	table td+td {
		border-left: 2px solid black;
	}
</style>
<body>
<div class='center'> 
	<!-- <img src="http://127.0.0.1:8002/assets/img/logo.png" style="width:100%"> -->
	<hr>
	<h1>Nota Lunas</h1>
	<p style='text-align:right'><?php echo $transaksi->tanggal_transaksi ?></p>
	<p style='text-align:left'><?php echo $transaksi->id_transaksi ?></p>
	<div style='display:flex;'>
		<div class='column' style='text-align:left'>
			<p>Member : <?php echo $hewan?$hewan->customer->nama:"guest"; 
						$member = $hewan?$hewan->nama."-".$hewan->jenisHewan->nama:"guest";
							echo " (".$member.")"?></p>
			<?php echo $hewan?"<p>Telepon : ".$hewan->customer->telepon."</p>":""?>
		</div>
		<div class='column' style='text-align:right'>
			<p>CS : <?php echo $transaksi->cs ?></p>
			<p>Kasir : <?php echo $transaksi->kasir ?></p>
		</div>
	</div>
	<hr>
	<h2 style='text-align:center'><?php echo "Jasa Layanan" ?></h2>
	<hr>
	<table  style='width: 100%'>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Jasa</th>
				<th>Harga</th>
				<th>Jumlah</th>
				<th>Sub Total</th>
			</tr>
		</thead>
    	<?php $no=1; ?>
	  	<?php foreach($details as $d): ?>
		<tr>
			<td  style='text-align:center'><?php echo $no ?></td>
			<td  style='text-align:center' ><?php echo $d->layanan->nama; 
												echo " " ;
												echo $hewan?$hewan->jenisHewan->nama:"";
												echo " " ;
												echo $layanan->ukuranHewan->nama?></td>
			<td  style='text-align:center'><?php echo $d->layanan->harga ?></td>
			<td  style='text-align:center'><?php echo 1 ?></td>
			<td  style='text-align:center'><?php echo $d->subtotal ?></td>
    	</tr>
		<?php $no++; ?>
	  	<?php endforeach; ?>
	</table>
	<br>
	<hr>
	<div style='display:flex; text-align:right'>
		<div class='column'>
			<p>Sub Total : <?php echo $transaksi->total_harga ?></p>
			<p>Diskon : <?php echo $transaksi->diskon ?></p>
			<p>TOTAL : <?php 
							$hasil_final= $transaksi->total_harga-$transaksi->diskon;
							echo $hasil_final 
							?>
			</p>
		</div>
	</div>
	
</div>
</body>
</html>
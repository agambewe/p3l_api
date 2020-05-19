<html>
<style>
	html {
		width: 100%;
	}

	body {
		font-family: Arial, Helvetica, sans-serif normal;
		border: 2px solid;
		padding: 50px;
	}

	.center {
		display: block;
		margin-left: auto;
		margin-right: auto;
		width: 100%;
	}

	h3 {
		text-align: center;
	}

	.column {
		flex: 50%;
	}

	.lef {
		position: relative;
		right: 0%;
		left: 80%;
		margin-bottom: -90px;
	}
	
	hr {
		/* height:5px solid;
		border-width:0;
		color:gray;
		background-color:gray */
	}

	table{
		border:1px solid;
		border-collapse:collapse;
		margin-top: 25px;
		/* margin:0 auto; */
	}
	td, tr, th{
		padding:5px;
		border:1px solid;
	}

	th {
		text-align: left;
	}
</style>
<head>
	<title>Nota Transaksi Layanan</title>
	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
</head>
<body>
<?php
	function rupiah($angka){
		$hasil = "Rp. " . number_format($angka,2,',','.');
		$hasil = explode(",", $hasil);
		return $hasil[0].",-";
	}
?>
<div class='center'> 
	<!-- <img src="{{ asset('img/kop.jpg') }}" style="width:100%"/> -->
	<!-- <img src="{{ public_path('img/kop.jpg') }}" > -->
	@php use App\Custom\Archivos; @endphp <img src="{{Archivos::imagenABase64('assets/img/kop.jpg')}}" width="100%" >
	<hr>
	<h3>Nota Lunas</h3>
	<p style='text-align:right'><?php
			echo \Carbon\Carbon::parse($transaksi->created_at)->translatedFormat('d F Y h:i')
			?></p>
	<p style='text-align:left'><?php echo $transaksi->id_transaksi ?></p>
	<div style='display:flex;'>
		<div class='column' style='text-align:left'>
			<p>Member : <?php echo $hewan?$hewan->customer->nama:"guest"; 
						$member = $hewan?$hewan->nama."-".$hewan->jenisHewan->nama:"guest";
							echo " (".$member.")"?></p>
			<?php echo $hewan?"<p>Telepon : ".$hewan->customer->telepon."</p>":""?>
		</div>
		<div class='column lef' style='text-align:left'>
			<p>CS : <?php echo $transaksi->cs ?></p>
			<p>Kasir : <?php echo $transaksi->kasir ?></p>
		</div>
	</div>
	<hr>
		<h3 style='text-align:center'><?php echo "Jasa Layanan" ?></h3>
	<hr>

	<table class='table table-bordered' style='width: 100%'>
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
		<tbody>
			<tr>
				<td  style='text-align:center'><?php echo $no ?></td>
				<td  style='text-align:center' ><?php echo $d->layanan->nama; 
													echo " " ;
													echo $hewan?$hewan->jenisHewan->nama:"";
													echo " " ;
													echo $layanan->ukuranHewan->nama?></td>
				<td  style='text-align:center'><?php echo rupiah($d->layanan->harga) ?></td>
				<td  style='text-align:center'><?php echo 1 ?></td>
				<td  style='text-align:center'><?php echo rupiah($d->subtotal) ?></td>
			</tr>
		<?php $no++; ?>
	  	<?php endforeach; ?>
		</tbody>
	</table>
	<br>
	<hr>
	<div style='display:flex; text-align:right'>
		<div class='column'>
			<p>Sub Total : <?php echo rupiah($transaksi->total_harga) ?></p>
			<p>Diskon : <?php echo rupiah($transaksi->diskon) ?></p>
			<p><strong>TOTAL : <?php 
							$hasil_final= $transaksi->total_harga-$transaksi->diskon;
							echo rupiah($hasil_final)
							?>
			</strong></p>
		</div>
	</div>
	
</div>
</body>
</html>
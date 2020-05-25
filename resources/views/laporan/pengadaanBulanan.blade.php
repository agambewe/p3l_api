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

	body {
		font-family: Arial, Helvetica, sans-serif normal;
		border: 2px solid;
		padding: 50px;
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
<?php
	function rupiah($angka){
		$hasil = "Rp. " . number_format($angka,2,',','.');
		$hasil = explode(",", $hasil);
		return $hasil[0].",-";
	}
?>
<div class='center'> 
	<center>
		@php use App\Custom\Archivos; @endphp <img src="{{Archivos::imagenABase64('assets/img/kop.jpg')}}" width="100%" >
		<hr>
	</center>
		<h1>Laporan Pengadaan Bulanan</h1>        
        <p align="left" class="font"> <b> Bulan : <?php echo  \Carbon\Carbon::parse($pengadaan->tanggal_restock)->translatedFormat('F') ?> </b></p>
    	<p align="left" class="font"> <b> Tahun : <?php echo  \Carbon\Carbon::parse($pengadaan->tanggal_restock)->translatedFormat('Y') ?> </b></p>
	<table  style='width: 100%' align="center">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Produk</th>
				<th>Jumlah Pengeluaran</th>
			</tr>
		</thead>
    	<?php $no=1; ?>
        <?php $hasil_final = 0 ?>
		<?php foreach($details as $p): ?>
		<tr>
			<td  style='text-align:center'><?php echo $no ?></td>
			<td	 style='text-align:center'><?php echo $p->nama ?></td>
			<td  style='text-align:center'><?php echo rupiah ($p->total_bayar)  ?></td>
    	</tr>
		
		<?php $no++; ?>
        <?php $hasil_final = $hasil_final + $p->total_bayar?></b></p>
		<?php endforeach; ?>
	</table>
	<br>
	<div style='display:flex; text-align:right'>
		<div class='column'>
			<p style='text-align:right'> <b> TOTAL : <?php echo rupiah($hasil_final)?>
			
		</div>
	</div>
	<div class="container">
		<p style='text-align:right'>Dicetak Tanggal <?php echo  \Carbon\Carbon::parse($p->dt)->translatedFormat('d F Y') ?> </p>
	</div>
	
</div>
</body>
</html>
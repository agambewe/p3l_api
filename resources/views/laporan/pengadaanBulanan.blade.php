<html>
<style>
	html {
		width: 100%;
	}

	body {
		font-family: Arial, Helvetica, sans-serif normal;
		font-size: 14px;
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
		left: 70%;
		margin-bottom: -25px;
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
		text-align: left;
	}

	th {
		text-align: center;
	}

	.sup {
		border: 2px dashed;
		padding: 1px 15px 1px 15px;
		max-width: 40%;
		margin-bottom: 50px;
	}

	.footer {
    /* display:flex;  */
    text-align:right; 
    bottom: -35;
    position: absolute;
    
  }
</style>
<head>
	<title>LAPORAN PENDAPATAN BULANAN</title>
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
	<h3>LAPORAN PENGADAAN BULANAN   </h3>
	<?php echo "Bulan : ",$bulan; ?>
	<br><br>
	<?php echo "Tahun : ",$tahun; ?>
	
	<br>
	<table class='table table-bordered' style='width: 100%'>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Produk</th>
				<th>Harga</th>
			</tr>
		</thead>
		<br>

		<?php  
			$no=1; 
			$tempP=0;

			for($a=0; $a < count($data); $a++)
			{
				print "<tr>";
				// penomeran otomatis
				print "<td>".$no."</td>";
				print "<td>".$data[$a]->nama."</td>";
				print "<td>".rupiah($data[$a]->subtotal)."</td>";
				$tempP=$tempP+$data[$a]->subtotal;
				print "</tr>";
				$no++;
				
			}
			
  		?> 
		  </table>
  <div style='display:flex; text-align:right'>
		<div class='column'>
			<p><strong>TOTAL : <?php 
							echo rupiah($tempP);
							?>
			</strong></p>
		</div>
	</div>
</div>
<div class="footer">
	<p>Dicetak tanggal <?php echo \Carbon\Carbon::now()
							->setTimezone('Asia/Jakarta')
							->translatedFormat('d F Y') 
	?></p>
</div>
</body>
</html>
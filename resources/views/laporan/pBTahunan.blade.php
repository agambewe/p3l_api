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

	.dicetak {
		/* display:flex;  */
		text-align:right; 
		position: static;
		bottom: 0;
	}
</style>
<head>
	<title>LAPORAN PENDAPATAN TAHUNAN </title>
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
	<h3>LAPORAN PENDAPATAN TAHUNAN   </h3>
	<?php echo "Tahun : ",$tahun; ?>
	<br>
	<table class='table table-bordered' style='width: 100%'>
		<thead>
			<tr>
				<th>No</th>
				<th>Bulan</th>
				<th>Produk</th>
				<th>Jasa Layanan</th>
				<th>Total</th>
			</tr>
		</thead>
		
		<?php  
  $no=1; 
$temp=0;
   for($a=0; $a < count($data); $a++)
   {
    print "<tr>";
    // penomeran otomatis
	print "<td>".$no."</td>";
	print "<td>".$data[$a]->Bulan."</td>";
	print "<td>".rupiah($data[$a]->Produk)."</td>";
	print "<td>".rupiah($data[$a]->Layanan)."</td>";
	print "<td>".rupiah($data[$a]->Total)."</td>";
	$temp=$temp+$data[$a]->Total;


	
    print "</tr>";
    $no++;
   }
  ?>

	</table>
	<br>
	<div style='display:flex; text-align:right'>
		<div class='column'>
			<p><strong>TOTAL : <?php 
							echo rupiah($temp);
							?>
			</strong></p>
		</div>
	</div>

	<div class="dicetak">
		<p>Dicetak tanggal <?php echo \Carbon\Carbon::now()
								->setTimezone('Asia/Jakarta')
								->translatedFormat('d F Y') 
							?></p>
	</div>
	
</div>
</body>
</html>
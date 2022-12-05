<style type="text/css">
*{
font-family: Arial;
font-size: 12px;
margin:0px;
padding:0px;
}
@page {
 margin-left:3cm 2cm 2cm 2cm;
}
.container{
	margin-top: 10px;
	width: 800px;
	margin-left: auto;
	margin-right: auto;
}
table.grid{
width:20.4cm ;
font-size: 9pt;
border-collapse:collapse;
}
table.grid th{
padding-top:1mm;
padding-bottom:1mm;
}
table.grid th{
background: #F0F0F0;
border: 0.2mm solid #000;
text-align:center;
padding-left:0.2cm;
}
table.grid tr td{
padding-top:0.5mm;
padding-bottom:0.5mm;
padding-left:2mm;
border:0.2mm solid #000;
}
h1{
font-size: 18pt;
}
h2{
font-size: 14pt;
}
h3{
font-size: 10pt;
}
.header{
display: block;
width:20.4cm ;
margin-bottom: 0.3cm;
text-align: center;
margin-top: 10px;
}
.attr{
font-size:9pt;
width: 100%;
padding-top:2pt;
padding-bottom:2pt;
border-top: 0.2mm solid #000;
border-bottom: 0.2mm solid #000;
}
.pagebreak {
width:20cm ;
page-break-after: always;
margin-bottom:10px;
}
.akhir {
width:20cm ;
}
.page {
font-size:13px;
padding-top: 20px;
}
.footer{
	padding-top: 20px;
	margin-left: 600px;
}
</style>
<?php
session_start();
include '../koneksi.php';
include_once '../functions.php';

// tampilkan data toko
$qrytoko = mysqli_query($conn, "SELECT * FROM perusahaan WHERE kd_perusahaan = '1'");
$per = mysqli_fetch_array($qrytoko);

$namaper = $per['nama_perusahaan'];
$alamat = $per['alamat'];
$pemilik = $per['pemilik'];
$kota = $per['kota'];
$judul_H = "LAPORAN PROFIT PENJUALAN <br>";
$tgl = date('d-m-Y');
$namapetugas = $_SESSION['nama'];
function myheader($judul_H,$namaper,$alamat){
echo  "<div class='header'>
					<h1 align='left'>$namaper</h1>
					<p align='left'>$alamat</p><br/><br/>
		  		<h2>".$judul_H."</h2>";
				if(!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
					echo "<p>All time periode</p>";
				} else {
				 echo "<p>Tanggal ".tgl_indo($_GET['tgl1'])." s.d ".tgl_indo($_GET['tgl2'])."</p>";
				}
		 echo "</div>
		<table class='grid'>
		<tr>
			<th width='3%'>No</th>
			<th>Kode Penjualan</th>
			<th>Tgl Penjualan</th>
			<th>Barang</th>
			<th>Satuan</th>
			<th>Jumlah</th>
			<th>Harga Beli</th>
			<th>Harga Jual</th>
			<th>Profit</th>
		</tr>";		
}
function myfooter(){
	echo "</table>";
}

if (isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
	$bln1 = $_GET['tgl1'];
	$bln2 = $_GET['tgl2'];
	$qry = mysqli_query($conn, "SELECT * FROM penjualan pen
				JOIN d_penjualan dpen ON pen.kd_penjualan = dpen.kd_penjualan
				JOIN barang bar ON dpen.kd_barang = bar.kd_barang 
				WHERE pen.tgl_penjualan BETWEEN '$bln1' AND '$bln2'");
	$jum = mysqli_num_rows($qry);
	echo "<div class='container' align='center'>";
	myheader($judul_H, $namaper, $alamat);
	$gtotal =0;
	$no = 1;
	while ($data = mysqli_fetch_array($qry)) {
		$modal = $data['jumlah'] * $data['harga_beli'];
		$penjualan = $data['jumlah'] * $data['harga_jual'];
		$total = $penjualan - $modal;
		$gtotal = $gtotal + $total;
		
		echo "<tr>
				<td align='center'>".$no++."</td>
				<td align='center'>$data[kd_penjualan]</td>
				<td align='left'>".date_format(date_create($data['tgl_penjualan']),'d-m-Y')."</td>
				<td align='left'>$data[nama_barang]</td>
				<td align='left'>$data[satuan]</td>
				<td align='center'>$data[jumlah]</td>
				<td align='left'>Rp. ".number_format($data['harga_beli'])."</td>
				<td align='left'>Rp. ".number_format($data['harga_jual'])."</td>
				<td align='left'>Rp. ".number_format($total)."</td>
				</tr>";
	}
			echo "<tr><td colspan='8' align='center'><b>Total</b></td><td><b>Rp. ".number_format($gtotal)."</td></tr>";
		myfooter();
	echo "<div class='footer'>
			<div>".$kota, tgl_indo(date('Y-m-d'))."</div>
			<div style='margin-top:60px; margin-right:5px;'>".$namapetugas."</div>
		</div>";
	echo "</div>";
	
}else{
	$qry = mysqli_query($conn, "SELECT * FROM penjualan pen
				JOIN d_penjualan dpen ON pen.kd_penjualan = dpen.kd_penjualan
				JOIN barang bar ON dpen.kd_barang = bar.kd_barang ");
	echo "<div class='container' align='center'>";
	myheader($judul_H, $namaper, $alamat);
	$gtotal =0;
	$no = 1;
	while ($data = mysqli_fetch_array($qry)) {
		$modal = $data['jumlah'] * $data['harga_beli'];
		$penjualan = $data['jumlah'] * $data['harga_jual'];
		$total = $penjualan - $modal;
		$gtotal = $gtotal + $total;
		
		echo "<tr>
				<td align='center'>".$no++."</td>
				<td align='center'>$data[kd_penjualan]</td>
				<td align='left'>".date_format(date_create($data['tgl_penjualan']),'d-m-Y')."</td>
				<td align='left'>$data[nama_barang]</td>
				<td align='left'>$data[satuan]</td>
				<td align='center'>$data[jumlah]</td>
				<td align='left'>Rp. ".number_format($data['harga_beli'])."</td>
				<td align='left'>Rp. ".number_format($data['harga_jual'])."</td>
				<td align='left'>Rp. ".number_format($total)."</td>
				</tr>";
	}
			echo "<tr><td colspan='8' align='center'><b>Total</b></td><td><b>Rp. ".number_format($gtotal)."</td></tr>";
		myfooter();
	echo "<div class='footer'>
			<div>".$kota."".', '." ".tgl_indo(date('Y-m-d'))."</div>
			<div style='margin-top:60px; margin-right:5px;'>".$namapetugas."</div>
		</div>";
	echo "</div>";
}

	
?>
<script type="text/javascript">
	window.print();
</script>
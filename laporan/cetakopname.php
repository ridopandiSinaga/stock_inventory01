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

$qryperusahaan = mysqli_query($conn, "SELECT * FROM perusahaan WHERE kd_perusahaan = '1'");
$per = mysqli_fetch_assoc($qryperusahaan);
$namaper = $per['nama_perusahaan'];
$alamat = $per['alamat'];
$pemilik = $per['pemilik'];
$kota = $per['kota'];
$judul_H = "LAPORAN STOK BARANG <br>";
$namana = $_SESSION['nama'];
function myheader($judul_H,$namaper,$alamat){
echo  "<div class='header'>
					<h1 align='left'>$namaper</h1>
					<p align='left'>$alamat</p><br/><br/>
		  		<h2>".$judul_H."</h2>
				<p>Kondisi Per ".tgl_indo(date('Y-m-d'))."</p>
				
		</div>";		
}
function myfooter(){
	echo "</table>";
}
function nextheader(){
	echo "<table class='grid'>
		<tr>
			<th width='3%'>No</th>
			<th>Kode Barang</th>
			<th>Nama Barang</th>
			<th>Satuan</th>
			<th>Harga Beli</th>
			<th>Stok</th>
			<th>Jumlah</th>
		</tr>";
}
	echo "<div class='container' align='center'>";
	$page =1;
	$gtotal =0;
	$no = 1;
	
	myheader($judul_H,$namaper,$alamat);
	// buat query menampilkan seluruh data barang
	$qry = mysqli_query($conn, "SELECT * FROM barang ORDER BY nama_barang ASC");
	while ($data = mysqli_fetch_array($qry)) {
		$kodebarang = $data['kd_barang'];
		$namabarang = $data['nama_barang'];
		$satuan = $data['satuan'];
		$hargabeli = $data['harga_beli'];
		$stok = $data['stok'];
		$jumlah = $data['harga_beli']*$data['stok'];
		$gtotal = $gtotal + $jumlah;
		if(($no % 50) == 1){
		   	if($no > 1){
		        myfooter();
		        echo "<div class='pagebreak'>
				<div class='page' align='center'>Halaman - $page</div>
				</div>";
				$page++;
		  	}
		nextheader();
		}
		echo "<tr>
				<td align='center'>".$no++."</td>
				<td align='center'>".$kodebarang."</td>
				<td align='left'>".$namabarang."</td>
				<td align='center'>".$satuan."</td>
				<td align='left'>Rp. ".number_format($hargabeli)."</td>
				<td align='center'>".$stok."</td>
				<td align='left'>Rp. ".number_format($jumlah)."</td>
				</tr>";
	}
			echo "<tr><td colspan='6' align='center'><b>Total Value</b></td><td><b>Rp. ".number_format($gtotal)."</td></tr>";
		myfooter();
	echo "<div class='footer'>
			<div>$kota, ".tgl_indo(date('Y-m-d'))."</div>
			<div style='margin-top:70px; margin-right:5px;'>$namana</div>
		</div>";
	echo "<div class='page' align='center'>Halaman - ".$page."</div>";
	echo "</div>";
?>
<script type="text/javascript">
	window.print();
</script>
<?php  
	include "../koneksi.php";
	$kd = $_GET['kdbarang'];
	//cek kode barang udah ada atau belum
	$query = "SELECT kd_barang FROM barang WHERE kd_barang='$kd'";
	$result = mysqli_query($conn, $query);
	$jum = mysqli_num_rows($result);
	if ($jum >= 1) {
		echo "<span style='color:red; padding-left:4px;'><i class='fa fa-warning'></i> Kode Barang ini sudah ada di database</span>";
	}
	else{
		echo "";
	}
?>
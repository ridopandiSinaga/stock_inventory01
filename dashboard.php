<div class="row">
  <div class="col-md-12">
    <h2>Inventory Barang Toko Kita</h2>   
    <h5>Aplikasi Pencatatan Keluar Masuk Barang</h5>
  </div>
</div>
<hr />
<?php 
	// menghitung penjualan hari ini 
		include "koneksi.php";
		$hari = date("Y-m-d");
		$qry = mysqli_query($conn, "SELECT * FROM penjualan WHERE tgl_penjualan = '$hari'");
		$hitungpenjualan = mysqli_num_rows($qry);
		
	// menghitung pembelian hari ini
		$qry2 = mysqli_query($conn, "SELECT * FROM pembelian WHERE tgl_pembelian = '$hari'");
		$hitungpembelian = mysqli_num_rows($qry2);
?>
<div class="row">
	<div class="col-md-6 col-sm-6 col-xs-6">           
		<div class="panel panel-back noti-box">
            <span class="icon-box bg-color-green set-icon">
                <i class="fa fa-money"></i>
            </span>
           	<div class="text-box" >
                <p class="main-text"><?php echo $hitungpenjualan; ?> New</p>
                <p class="text-muted">Penjualan Hari Ini</p>
            </div>
        </div>
		</div>
	<div class="col-md-6 col-sm-6 col-xs-6">           
		<div class="panel panel-back noti-box">
            <span class="icon-box bg-color-red set-icon">
                <i class="fa fa-download"></i>
            </span>
        	<div class="text-box" >
                <p class="main-text"><?php echo $hitungpembelian; ?> New</p>
                <p class="text-muted">Pembelian Hari Ini</p>
            </div>
        </div>
	</div>
</div>
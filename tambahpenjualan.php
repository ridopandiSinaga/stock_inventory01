<?php 
include "koneksi.php";
	// buat dulu kode otomatis
	$qry = mysqli_query($conn, "SELECT MAX(kd_penjualan) AS kode FROM penjualan");
	$pecah = mysqli_fetch_array($qry);
	$kod = substr($pecah['kode'], 3,5);
	$jum = $kod + 1;
	if ($jum < 10) {
		$kode = "PEN0000".$jum;
	}
	else if($jum >= 10 && $jum < 100){
		$kode = "PEN000".$jum;
	}
	else if($jum >= 100 && $jum < 1000){
		$kode = "PEN00".$jum;
	}
	else{
		$kode = "PEN0".$jum;
	}
	
	// hitung subtotal dulu
	$qry2 = mysqli_query($conn, "SELECT sum(total) as jumlah FROM penjualan_sementara WHERE kd_penjualan = '$kode'");
	$pecah = mysqli_fetch_array($qry2);
	$qrycekdatabarang = mysqli_query($conn, "SELECT * FROM penjualan_sementara WHERE kd_penjualan = '$kode'");
	$hitung = mysqli_num_rows($qrycekdatabarang);
	if ($hitung >=1) {
		$subtotal = $pecah['jumlah'];
	}
	else{
		$subtotal = 0;
	}
	
	// cek barang
	$qrycek = mysqli_query($conn, "SELECT * FROM penjualan_sementara WHERE kd_penjualan = '$kode'");
	$hitung = mysqli_num_rows($qrycek);
	if ($hitung >=1) {
		$cekbarang = true;
	}
	else{
		$cekbarang = false;
	}
	
	
	if (isset($_POST['tambah'])) {
		$item = $_POST['item'];
		$kodebarang = $_GET['proses'];
		$qry = mysqli_query($conn, "SELECT * FROM barang WHERE kd_barang = '$kodebarang'");
			$dbr = mysqli_fetch_assoc($qry);
			$jumitem = $dbr['stok'];
			if ($item < $jumitem+1) {
				$cekitem = true;
			}
			else{
				echo "<script>bootbox.alert('Item tidak cukup, $jumitem tersisa di gudang!', function(){
					window.location='index.php?page=tambahpenjualan';
				});</script>";
			}
		if ($cekitem === true) {
			$qry = mysqli_query($conn, "SELECT * FROM barang WHERE kd_barang = '$kodebarang'");
			$bar = mysqli_fetch_assoc($qry);
			$namabr = $bar['nama_barang'];
			$satuan = $bar['satuan'];
			$harga = $bar['harga_jual'];
			$total = $harga * $item;
			mysqli_query($conn, "INSERT INTO penjualan_sementara(kd_penjualan, kd_barang, nama_barang, satuan, harga, item, total) 
				VALUES('$kode','$kodebarang','$namabr','$satuan','$harga','$item','$total')");
			// update barang
			$kurang = $bar['stok'] - $item;
			mysqli_query($conn, "UPDATE barang SET stok = '$kurang' WHERE kd_barang = '$kodebarang'");
			echo "<script>location='index.php?page=tambahpenjualan';</script>";
		}
	}
	if (isset($_POST['save'])) {
		$tglpenjualan = $_POST['tglpenjualan'];
		$totalbayar = $_POST['totalbayar'];
		if ($totalbayar < $subtotal ) {
			echo "<script>bootbox.alert('Total Bayar Tidak Cukup!', function(){

			});</script>";
		}else{
			//insert penjualan
			$kdadmin = $_SESSION['kd_admin'];
			mysqli_query($conn, "INSERT INTO penjualan(kd_penjualan,tgl_penjualan,kd_admin,dibayar,total_penjualan) 
				VALUES('$kode','$tglpenjualan','$kdadmin','$totalbayar','$subtotal')");
			
			//insert d penjualan
			mysqli_query($conn, "INSERT INTO d_penjualan(kd_penjualan,kd_barang,jumlah,subtotal) 
				SELECT kd_penjualan, kd_barang,item,total FROM penjualan_sementara WHERE kd_penjualan='$kode'");
			//hapus semua penjualan sementera
			mysqli_query($conn, "DELETE FROM penjualan_sementara WHERE kd_penjualan = '$kode'");
			$kem = $totalbayar - $subtotal;
			$kembalian = number_format($kem);
			echo "<script>
				bootbox.confirm('Kembalian Rp. $kembalian, Lanjutkan Cetak Nota!', function(confirmed){
	        	if (confirmed) {
	        	  	window.open('./nota/cetaknotapenjualan.php?kdpenjualan=$kode', '_blank');window.location='index.php?page=tambahpenjualan';
	        	}else{
	        		window.location ='index.php?page=tambahpenjualan';
	        	}
	        });
			</script>";
		}
		
	}
	if (isset($_GET['hapus'])) {
		$kd = $_GET['hapus'];
		//update barang, di kembalikan ke setok semula
			$qry = mysqli_query($conn, "SELECT * FROM penjualan_sementara WHERE id_penjualan_sementara = '$kd'");
			$pecah = mysqli_fetch_assoc($qry);
			$jumlahitempen = $pecah['item'];
			$kodebar = $pecah['kd_barang'];
			// ambil data barang
			$qrybarang = mysqli_query($conn, "SELECT * FROM barang WHERE kd_barang = '$kodebarang'");
			$dbarang = mysqli_fetch_assoc($qrybarang);
			$stokbarang = $dbarang['stok'];
			$stoksemula = $stokbarang + $jumlahitempen;
			mysqli_query($conn, "UPDATE barang SET stok ='$stoksemula' WHERE kd_barang = '$kodebar'");
			//hapus
			mysqli_query($conn, "DELETE FROM penjualan_sementara WHERE id_penjualan_sementara = '$kd'");
		echo "<script>location='index.php?page=tambahpenjualan';</script>";
	}
	$kdbar = "";
	$namabr = "";
	if (isset($_GET['proses'])) {
		$kdbar = $_GET['proses'];
		$qry = mysqli_query($conn, "SELECT * FROM barang WHERE kd_barang = '$kdbar'");
		$pecah = mysqli_fetch_assoc($qry);
		$namabr = $pecah['nama_barang'];
		
	}
?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Barang
			</div>
			<div class="panel-body">
				<form method="POST">
					<div class="form-group">
						<label>Kd Barang</label>
						<input type="text" class="form-control" id="kdbarang" name="kdbarang" disabled="disabled" value="<?php echo $kdbar; ?>">
					</div>
					<div class="form-group">
						<label>Nama Barang</label>
						<input type="text" class="form-control" disabled="disabled" value="<?php echo $namabr; ?>">
					</div>
					<div class="form-group">
						<label>Jumlah Item</label>
						<input type="number" class="form-control" name="item" id="item" max="10000" min="0">
					</div>

			</div>
			<div class="panel-footer">
			<?php if ($kdbar === ""): ?>				
				<button class="btn btn-info" name="tambah" id="tambah" disabled="disabled"><i class="fa fa-plus"></i> Tambah</button>
			<?php endif ?>
			<?php if ($kdbar !== ""): ?>
				<button class="btn btn-info" name="tambah" id="tambah"><i class="fa fa-plus"></i> Tambah</button>
			<?php endif ?>
			</div>
				</form>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Penjualan
			</div>
			<div class="panel-body">
				<!--Form-->
				<form method="POST">
					<div class="form-group">
						<label>Kode Penjualan</label>
						<input type="text" class="form-control" name="kdpenjualan" id="kdpenjualan" maxlength="8" readonly="true" value="<?php echo $kode; ?>">
					</div>
					<div class="form-group">
						<label>Tanggal Penjualan</label>
						<input type="date" class="form-control" name="tglpenjualan" id="tglpenjualan">
					</div>
					<div class="form-group">
						<label>Total Bayar</label>
						<input type="number" class="form-control" name="totalbayar" id="totalbayar">
					</div>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="panel-footer" align="center">
		<?php if ($cekbarang === true): ?>
			<button id="formbtn" class="btn btn-primary" name="save"><i class="fa fa-save"></i> Simpan</button>
		<?php endif ?>
		<?php if ($cekbarang === false): ?>
			<button id="formbtn" class="btn btn-primary" name="save" disabled="disabled"><i class="fa fa-save"></i> Simpan</button>
		<?php endif ?>
		</div>				
				</form><!--End Form-->
	</div>
	<div class="col-md-12">
		<table class="table table-bordered table-responsive table-hover">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Barang</th>
					<th>Satuan</th>
					<th>Harga</th>
					<th>Jumlah</th>
					<th>Total</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php  
					if ($cekbarang === false) {
						echo "<tr><td colspan='7' align='center'>Data saat ini kosong</td></tr>";
					}
					else{
					$no = 1;
					$qry = mysqli_query($conn, "SELECT * FROM penjualan_sementara WHERE kd_penjualan = '$kode'");
					$hitung = mysqli_num_rows($qry);
					if ($hitung < 1) {
						error_reporting(0);
					} else {
						while ($data = mysqli_fetch_array($qry)) { ?>
					
						<tr>
							<td><?php echo $no++; ?></td>
							<td><?php echo $data['nama_barang']; ?></td>
							<td><?php echo $data['satuan']; ?></td>
							<td><?php echo number_format($data['harga']); ?></td>
							<td><?php echo $data['item']; ?></td>
							<td><?php echo number_format($data['total']); ?></td>
							<td>
								<a href="index.php?page=tambahpenjualan&hapus=<?php echo $data['id_penjualan_sementara']; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a>
							</td>
						</tr>
					
					<?php	
						}
					}}
					
				?>
				
				<tr class="active">
					<td colspan="5" align="center"><strong>Subtotal</strong></td>
					<td colspan="2"><?php echo number_format($subtotal); ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<!--data barangnya-->
<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Barang
            </div>
            <div class="panel-body">
                <div class="table">
                    <table class="table table-striped table-bordered table-hover" id="tabelku">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama</th>
                                <th>Satuan</th>
                                <th>Harga Jual</th>
								<th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
								$nourut = 1;
                                $qry = mysqli_query($conn, "SELECT * FROM barang WHERE stok > 0 ORDER BY nama_barang ASC");
								while ($data = mysqli_fetch_array($qry)) { ?>
							
									<tr class="odd gradeX">
										<td><?php echo $nourut++; ?></td>
										<td><?php echo $data['kd_barang']; ?></td>
										<td><?php echo $data['nama_barang']; ?></td>
										<td><?php echo $data['satuan']; ?></td>
										<td><?php echo number_format($data['harga_jual']); ?></td>
										<td><?php echo $data['stok']; ?></td>
										<td>
											<a href="index.php?page=tambahpenjualan&proses=<?php echo $data['kd_barang']; ?>" class="btn btn-success btn-xs"><i class="fa fa-download"></i> Prosess</a>
										</td>
									</tr>
							
							<?php
								}
                            ?>
                            
                        </tbody>
                    </table>
                </div>   
            </div>
        </div>
        <!--End Advanced Tables -->
    </div>
</div>
<?php  
	if (isset($_GET['proses'])) {
		echo "<script>
			$('#item').focus();
		</script>";
	}
?>
<script>
	//upper
	$(function(){
    	$('#satuan').focusout(function() {
        	// Uppercase-ize contents
        	this.value = this.value.toLocaleUpperCase();
    	});
	});
	//fungsi hide div
	$(function(){
		setTimeout(function(){$("#divAlert").fadeOut(900)}, 500);
	});
	//validasi form
	function validateText(id){
		if ($('#'+id).val()== null || $('#'+id).val()== "") {
			var div = $('#'+id).closest('div');
			div.addClass("has-error has-feedback");
			return false;
		}
		else{
			var div = $('#'+id).closest('div');
			div.removeClass("has-error has-feedback");
			return true;	
		}
	}
	$(document).ready(function(){
		$("#formbtn").click(function(){
			if (!validateText('tglpenjualan')) {
				$('#tglpenjualan').focus();
				return false;
			}
			else if (!validateText('totalbayar')) {
				$('#totalbayar').focus();
				return false;
			}
			return true;
		});
	});
	$(document).ready(function(){
		$("#tambah").click(function(){
			if (!validateText('item')) {
				$('#item').focus();
				return false;
			}
			return true;
		});
	});
</script>
<div class="row">
<?php 
	include "koneksi.php";
	// buat kode otomatis
	$qrykode = mysqli_query($conn, "SELECT MAX(kd_pembelian) AS kode FROM pembelian");
	$pecah = mysqli_fetch_array($qrykode);
	$kode = substr($pecah['kode'], 3,5);
	$jum = $kode + 1;
	if ($jum < 10) {
		$kodeotomatis = "PEM0000".$jum;
	}
	else if($jum >= 10 && $jum < 100){
		$kodeotomatis = "PEM000".$jum;
	}
	else if($jum >= 100 && $jum < 1000){
		$kodeotomatis = "PEM00".$jum;
	}
	else{
		$kodeotomatis = "PEM0".$jum;
	}
	
	
	// hitung total sementara (subtotal)
	$qryts = mysqli_query($conn, "SELECT sum(total) as jumlah FROM barangp_sementara WHERE kd_pembelian = '$kodeotomatis'");
	$pecah = mysqli_fetch_array($qryts);
	// cek data barang pembelian
	$qrycbp = mysqli_query($conn, "SELECT * FROM barangp_sementara WHERE kd_pembelian = '$kodeotomatis'");
	$hitung = mysqli_num_rows($qrycbp);
	if ($hitung >=1) {
		$subtotal = $pecah['jumlah'];
	}
	else{
		$subtotal = 0;
	}
	
	// cek data barang pembelian
	$qrycekbarangpem = mysqli_query($conn, "SELECT * FROM barangp_sementara WHERE kd_pembelian = '$kodeotomatis'");
	$hitung = mysqli_num_rows($qrycekbarangpem);
	if ($hitung >=1) {
		$cekbarang = true;
	}
	else{
		$cekbarang = false;
	}
	
	if (isset($_POST['tambah'])) {
		$namabarang = mysqli_real_escape_string($conn, $_POST['nama']);
		$satuanbarang = mysqli_real_escape_string($conn, $_POST['satuan']);
		$hargabarang = $_POST['hargab'];
		$jumlahitem = $_POST['item'];
		$tot = $jumlahitem * $hargabarang;
		$tambah = mysqli_query($conn, "INSERT INTO barangp_sementara(kd_pembelian,nama_barangp, satuan,harga_barangp,item,total) 
			VALUES('$kodeotomatis','$namabarang','$satuanbarang','$hargabarang','$jumlahitem','$tot')");
		echo "<script>location='index.php?page=tambahpembelian';</script>";
	}
	if (isset($_POST['save'])) {
		//insert pembelian
		$kdpembelian = $_POST['kdpembelian'];
		$kdadmin = $_SESSION['kd_admin'];
		$tglpembelian = $_POST['tglpembelian'];
		$supplier = $_POST['supplier'];
		mysqli_query($conn, "INSERT INTO pembelian(kd_pembelian,tgl_pembelian,kd_admin,kd_supplier,total_pembelian) 
			VALUES('$kdpembelian','$tglpembelian','$kdadmin','$supplier','$subtotal')");
		
		//insert data barang
		mysqli_query($conn, "INSERT INTO barang_pembelian(kd_pembelian,nama_barang_beli,satuan,harga_beli,item,total) 
			SELECT kd_pembelian,nama_barangp,satuan,harga_barangp,item,total FROM barangp_sementara");
		//insert detail pembelian
		mysqli_query($conn, "INSERT INTO d_pembelian(kd_pembelian,kd_barang_beli,jumlah,subtotal) 
			SELECT kd_pembelian, kd_barang_beli,item,total FROM barang_pembelian WHERE kd_pembelian='$kdpembelian'");
		//hapus data barang pembelian sementara
		mysqli_query($conn, "DELETE FROM barangp_sementara WHERE kd_pembelian='$kodeotomatis'");
		echo "<script>
			bootbox.confirm('Lanjutkan Cetak Nota!', function(confirmed){
        	if (confirmed) {
        	  	window.open('./nota/cetaknotapembelian.php?kdpembelian=$kodeotomatis', '_blank');window.location ='index.php?page=tambahpembelian';
        	}else{
        		window.location ='index.php?page=tambahpembelian';
        	}
        });
		</script>";
	}

	if (isset($_GET['hapusbs'])) {
		$hapus = mysqli_real_escape_string($conn, $_GET['hapusbs']);
		mysqli_query($conn, "DELETE FROM barangp_sementara WHERE id_barangp ='$hapus'");
		echo "<script>location='index.php?page=tambahpembelian';</script>";
	}
?>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Barang
			</div>
			<div class="panel-body">
				<form method="POST">
					<div class="form-group">
						<label>Nama Barang</label>
						<input type="text" class="form-control" name="nama" id="nama" placeholder="Masukan Nama Barang">
					</div>
					<div class="form-group">
						<label>Satuan</label>
						<input type="text" style="text-transform:uppercase" class="form-control" name="satuan" id="satuan" placeholder="Masukan Satuan">
					</div>
					<div class="form-group">
						<label>Harga Beli</label>
						<input type="number" class="form-control" name="hargab" id="hargab" min="0">
					</div>
					<div class="form-group">
						<label>Jumlah Item</label>
						<input type="number" class="form-control" name="item" id="item" max="10000" min="0">
					</div>

			</div>
			<div class="panel-footer">
				<button class="btn btn-info" name="tambah" id="tambah"><i class="fa fa-plus"></i> Tambah</button>
			</div>
				</form>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Pembelian Dan Supplier
			</div>
			<div class="panel-body">
				<!--Form-->
				<form method="POST">
					<div class="form-group">
						<label>Kode Pembelian</label>
						<input type="text" class="form-control" name="kdpembelian" id="kdpembelian" maxlength="8" readonly="true" value="<?php echo $kodeotomatis; ?>">
					</div>
					<div class="form-group">
						<label>Tanggal Pembelian</label>
						<input type="date" class="form-control" name="tglpembelian" id="tglpembelian">
					</div>
					<div class="form-group">
						<label>Supplier</label>
						<select class="form-control" name="supplier" id="supplier">
							<option value="">Pilih Supplier</option>
							<?php  
								$qrysup = mysqli_query($conn, "SELECT * FROM supplier");
								while ($pecah = mysqli_fetch_array($qrysup)) {
								?>
								<option value="<?php echo $pecah['kd_supplier']; ?>"><?php echo $pecah['nama_supplier']; ?></option>
								<?php
								}
								?>
						</select>
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
					$nomor = 1;
					$qrytmpsementara = mysqli_query($conn, "SELECT * FROM barangp_sementara WHERE kd_pembelian = '$kodeotomatis'");
					while ($data = mysqli_fetch_array($qrytmpsementara)) { ?>
						<tr>
							<td><?php echo $nomor++; ?></td>
							<td><?php echo $data['nama_barangp']; ?></td>
							<td><?php echo $data['satuan']; ?></td>
							<td><?php echo number_format($data['harga_barangp']); ?></td>
							<td><?php echo $data['item']; ?></td>
							<td><?php echo number_format($data['total']); ?></td>
							<td>
								<a href="index.php?page=tambahpembelian&hapusbs=<?php echo $data['id_barangp']; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a>
							</td>
						</tr>
				<?php 
					} } 
				?>
				<tr class="active">
					<td colspan="5" align="center"><strong>Subtotal</strong></td>
					<td colspan="2"><?php echo number_format($subtotal); ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
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
			if (!validateText('tglpembelian')) {
				$('#tglpembelian').focus();
				return false;
			}
			else if (!validateText('supplier')) {
				$('#supplier').focus();
				return false;
			}
			return true;
		});
	});
	$(document).ready(function(){
		$("#tambah").click(function(){
			if (!validateText('nama')) {
				$('#nama').focus();
				return false;
			}
			else if (!validateText('satuan')) {
				$('#satuan').focus();
				return false;
			}
			else if (!validateText('hargab')) {
				$('#hargab').focus();
				return false;
			}
			else if (!validateText('item')) {
				$('#item').focus();
				return false;
			}
			return true;
		});
	});
</script>
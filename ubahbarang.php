<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title" style="padding-top:0; margin-top:0; color:#f00;">Ubah Barang</h3>
			</div>
			<hr/>
			<div class="box-body">	
				<?php 
				include "koneksi.php";
				$id = mysqli_real_escape_string($conn, $_GET['id']);
					if (isset($_POST['save'])) {
						$nama = mysqli_real_escape_string($conn, $_POST['nama']);
						$satuan = mysqli_real_escape_string($conn, $_POST['satuan']);
						$hargaj = $_POST['hargaj'];
						$hargab = $_POST['hargab'];
						$stok = $_POST['stok'];
						mysqli_query($conn, "UPDATE barang SET nama_barang='$nama', satuan='$satuan', harga_jual='$hargaj',harga_beli='$hargab',stok='$stok' WHERE kd_barang = '$id' ");
						echo "<script>bootbox.alert('Data Barang berhasil dirubah', function(){
							window.location = 'index.php?page=barang';
						});</script>";
					}
					
					// ambil dulu data barang
					$qry = mysqli_query($conn, "SELECT * FROM barang WHERE kd_barang = '$id'");
					$brg = mysqli_fetch_assoc($qry);
				?>	
				<form method="POST" id="forminput" enctype="multipart/form-data">
					<div class="form-group">
						<label>Nama Barang</label>
						<input type="text" class="form-control" name="nama" id="nama"  value="<?php echo $brg['nama_barang']; ?>" placeholder="Masukan Nama Barang">
					</div>
					<div class="form-group">
						<label>Satuan</label>
						<input type="text" style="text-transform:uppercase" class="form-control" name="satuan" id="satuan"  value="<?php echo $brg['satuan']; ?>" placeholder="Masukan Satuan">
					</div>
					<div class="form-group">
						<label>Harga Jual</label>
						<input type="number" class="form-control" name="hargaj" id="hargaj" value="<?php echo $brg['harga_jual']; ?>" min="0">
					</div>
					<div class="form-group">
						<label>Harga Beli</label>
						<input type="number" class="form-control" name="hargab" id="hargab" value="<?php echo $brg['harga_beli']; ?>" min="0">
					</div>
					<div class="form-group">
						<label>Stok</label>
						<input type="number" class="form-control" name="stok" id="stok" value="<?php echo $brg['stok']; ?>" min="0" max="10000">
					</div>
					<button id="formbtn" class="btn btn-primary" name="save"><i class="fa fa-save"></i> Simpan</button>
					<a href="index.php?page=barang" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back to barang</a>
				</form>
			</div>
		</div>
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
			if (!validateText('nama')) {
				$('#nama').focus();
				return false;
			}
			if (!validateText('satuan')) {
				$('#satuan').focus();
				return false;
			}
			if (!validateText('hargaj')) {
				$('#hargaj').focus();
				return false;
			}
			if (!validateText('hargab')) {
				$('#hargab').focus();
				return false;
			}
			if (!validateText('stok')) {
				$('#stok').focus();
				return false;
			}
			return true;
		});
	});
</script>

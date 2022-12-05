<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title" style="padding-top:0; margin-top:0; color:#f00;">Ubah Admin</h3>
			</div>
			<hr/>
			<div class="box-body">	
				<?php
				include "koneksi.php";
				// ambil dulu id nya
				$id = $_GET['id'];
				
					if (isset($_POST['save'])) {
						$email = mysqli_real_escape_string($conn, $_POST['email']);
						$pass = mysqli_real_escape_string($conn, $_POST['pass']);
						$nama = mysqli_real_escape_string($conn, $_POST['nama']);
						$filelama = $_POST['filelama'];
						
						// proses file
						$namafile = $_FILES['file']['name'];
						$ukuranFile = $_FILES['file']['size'];
						$error = $_FILES['file']['error'];
						$tmpName = $_FILES['file']['tmp_name'];
						
						if($error === 4 AND !empty($filelama)) {
							mysqli_query($conn, "UPDATE admin SET nama='$nama', email='$email', password='$pass', gambar='$filelama' WHERE kd_admin='$id'");
						} else {
							// cek apakah yang diupload adalah file gambar
							$ekstensiFileValid = ['jpg','png'];
							$ekstensiFile = explode('.', $namafile);
							$ekstensiFile = strtolower(end($ekstensiFile));

							if(!in_array($ekstensiFile, $ekstensiFileValid)) {
								echo "
									<script>
										alert('File yang diizinkan hanya berekstensi JPG!');
										window.history.back();
									</script>";
							exit;
							}

							if($ukuranFile > 1000000) {
								echo "
									<script>
										alert('Ukuran file maksimal 1 MB!');
										window.history.back();
									</script>";
							exit;
							}

							// Jika semua syarat terpenuhi
							$namaFileBaru = uniqid();
							$namaFileBaru .= ".";
							$namaFileBaru .= $ekstensiFile;
							
							mysqli_query($conn, "UPDATE admin SET nama='$nama', email='$email', password='$pass', gambar='$namaFileBaru' WHERE kd_admin='$id'");
							move_uploaded_file($tmpName, 'gambar_admin/'. $namaFileBaru);
							unlink('gambar_admin/'.$filelama);
						}
						
						echo "<script>bootbox.alert('Data Terubah', function(){
							window.location = 'index.php?page=admin';
						});</script>";
					}
				
				// tampilkan dulu data admin berdasarkan id 
				$qry = mysqli_query($conn, "SELECT * FROM admin WHERE kd_admin='$id'");
				$adm = mysqli_fetch_array($qry);
				
				?>	
				<form method="POST" id="forminput" enctype="multipart/form-data">
					<div class="form-group">
						<label>Email</label>
						<input type="email" class="form-control" name="email" id="formemail" value="<?php echo $adm['email']; ?>" placeholder="Masukan Email">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control" name="pass" id="formpass" value="<?php echo $adm['password']; ?>" placeholder="Masukan Password">
					</div>
					<div class="form-group">
						<label>Nama</label>
						<?php 
						if($adm['nama'] === "admin") { ?>
						<input type="text" class="form-control" name="nama" id="formnama" value="<?php echo $adm['nama']; ?>" readonly>
						<?php	
						} else { ?>
						<input type="text" class="form-control" name="nama" id="formnama" value="<?php echo $adm['nama']; ?>" placeholder="Masukan Nama">
						<?php } ?>
						
					</div>
					<div class="form-group">
					<input type="hidden" class="form-control" name="filelama" value="<?= $adm['gambar']; ?>">
					</div>
					<div class="form-group">
						<label>Gambar</label>
						<img src="gambar_admin/<?php echo $adm['gambar']; ?>" width="50" class="img-responsive">
						
						<input type="file" class="form-control" name="file" id="formgambar">
					</div>
					<button id="formbtn" class="btn btn-primary" name="save"><i class="fa fa-save"></i> Simpan</button>
					<a href="index.php?page=admin" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back to admin</a>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
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
			if (!validateText('formemail')) {
				$('#formemail').focus();
				return false;
			}
			if (!validateText('formpass')) {
				$('#formpass').focus();
				return false;
			}
			if (!validateText('formnama')) {
				$('#formnama').focus();
				return false;
			}
			return true;
		});
	});
</script>
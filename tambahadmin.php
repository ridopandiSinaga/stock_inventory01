<?php include "koneksi.php"; ?>
<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title" style="padding-top:0; margin-top:0; color:#f00;">Tambah Admin</h3>
			</div>
			<hr/>
			<div class="box-body">	
				<?php 
					if (isset($_POST['save'])) {
						$email = mysqli_real_escape_string($conn, $_POST['email']);
						$pass = mysqli_real_escape_string($conn, $_POST['pass']);
						$nama = mysqli_real_escape_string($conn, $_POST['nama']);
						
						$namafile = $_FILES['file']['name'];
					$ukuranFile = $_FILES['file']['size'];
					$error = $_FILES['file']['error'];
					$tmpName = $_FILES['file']['tmp_name'];

					// cek apakah ada file yang diupload
					if($error === 4) {
						echo "
							<script>
								alert('Anda belum memilih file!');
								window.history.back();
							</script>";
					exit;
					}

					// cek apakah yang diupload adalah file gambar
					$ekstensiFileValid = ['jpg','PNG','png'];
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
					
					mysqli_query($conn, "INSERT INTO admin(email,password,nama,gambar) VALUES('$email','$pass','$nama','$namaFileBaru')");
					move_uploaded_file($tmpName, 'gambar_admin/'.$namaFileBaru);
						
						echo "<div class='alert alert-info alert-dismissable' id='divAlert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                                Data Tersimpan
                                </div>";
					}
				?>	
				<form method="POST" id="forminput" enctype="multipart/form-data">
					<div class="form-group">
						<label>Email</label>
						<input type="email" class="form-control" name="email" id="formemail" placeholder="Masukan Email">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control" name="pass" id="formpass" placeholder="Masukan Password">
					</div>
					<div class="form-group">
						<label>Nama</label>
						<input type="text" class="form-control" name="nama" id="formnama" placeholder="Masukan Nama">
					</div>
					<div class="form-group">
						<label>Gambar</label>
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
			if (!validateText('formgambar')) {
				$('#formgambar').focus();
				return false;
			}
			return true;
		});
	});
</script>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title" style="padding-top:0; margin-top:0; color:#f00;">Setting Perusahaan</h3>
            </div>
            <hr/>
            <div class="box-body">  
                <?php 
				include "koneksi.php";
                    if (isset($_POST['save'])) {
						$nama = mysqli_real_escape_string($conn, $_POST['nama']);
						$alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
						$pemilik = mysqli_real_escape_string($conn, $_POST['pemilik']);
						$kota = mysqli_real_escape_string($conn, $_POST['kota']);
                        mysqli_query($conn, "UPDATE perusahaan SET nama_perusahaan='$nama', alamat='$alamat', pemilik='$pemilik', kota='$kota' WHERE kd_perusahaan='1'");
                        echo "<script>bootbox.alert('Tersimpan!', function(){
                            window.location = 'index.php?page=perusahaan';
                        });</script>";
                    }
                    
					// tampilkan dulu data perusahaan atau data toko
					$qry = mysqli_query($conn, "SELECT * FROM perusahaan");
					$per = mysqli_fetch_array($qry);
                ?>  
                <form method="POST" id="forminput" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Nama Perusahaan</label>
                        <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $per['nama_perusahaan']; ?>" placeholder="Masukan Nama Perusahaan">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" name="alamat" id="alamat" value="<?php echo $per['alamat']; ?>" placeholder="Masukan Alamat Perusahaan">
                    </div>
                    <div class="form-group">
                        <label>Nama Pemilik</label>
                        <input type="text" class="form-control" name="pemilik" id="pemilik" value="<?php echo $per['pemilik']; ?>" placeholder="Masukan Nama Pemilik Perusahaan">
                    </div>
                    <div class="form-group">
                        <label>Kota</label>
                        <input type="text" class="form-control" name="kota" id="kota" value="<?php echo $per['kota']; ?>" placeholder="Masukan Kota Perusahaan">
                    </div>
                    <button id="formbtn" class="btn btn-primary" name="save"><i class="fa fa-save"></i> Simpan</button>
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
            if (!validateText('nama')) {
                $('#nama').focus();
                return false;
            }
            if (!validateText('alamat')) {
                $('#alamat').focus();
                return false;
            }
            if (!validateText('pemilik')) {
                $('#pemilik').focus();
                return false;
            }
            if (!validateText('kota')) {
                $('#kota').focus();
                return false;
            }
            return true;
        });
    });
</script>

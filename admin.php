<?php
include "koneksi.php";  
    if (isset($_GET['hapus'])) {
		$hapus = mysqli_real_escape_string($conn, $_GET['hapus']);
		// tampilkan dulu data admin
		$select = mysqli_query($conn, "SELECT * FROM admin WHERE kd_admin='$hapus'");
		$dataadmin = mysqli_fetch_array($select);
		unlink('gambar_admin/'.$dataadmin['gambar']);
        $qryhapus = mysqli_query($conn, "DELETE FROM admin WHERE kd_admin= '$hapus'");
        echo "<script>location='index.php?page=admin';</script>";
    }
?>
<div class="row">
    <div class="col-md-12">
    <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Admin
            </div>
            <div class="panel-body">
                <div class="table">
                    <table class="table table-striped table-bordered table-hover" id="tabelku">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
							$no = 1;
                                $qry = mysqli_query($conn, "SELECT * FROM admin");
								while ($data = mysqli_fetch_array($qry)) { ?>
								
								<tr class="odd gradeX">
									<td><?php echo $no++; ?></td>
									<td><?php echo $data['nama']; ?></td>
									<td><?php echo $data['email']; ?></td>
									<td><?php echo $data['password']; ?></td>
									<td>
										<img src="gambar_admin/<?php echo $data['gambar']; ?>" width="90">
									</td>
									<td>
										<a href="index.php?page=ubahadmin&id=<?php echo $data['kd_admin']; ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit</a>
										<?php 
										// jika namanya admin, tombol hapus jangan dimunculkan
										if ($data['nama'] === "admin") {
											echo "&nbsp;";
										} else { ?>
											<a href="index.php?page=admin&hapus=<?php echo $data['kd_admin']; ?>" class="btn btn-danger btn-xs" id="alertHapus"><i class="fa fa-trash"></i> Hapus</a>
										<?php
										}
										?>
									</td>
								</tr>
							<?php } ?>
							
                        </tbody>
                    </table>
                </div>   
            </div>
            <div class="panel-footer">
                <a href="index.php?page=tambahadmin" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Admin</a>
            </div>
        </div>
        <!--End Advanced Tables -->
    </div>
</div>
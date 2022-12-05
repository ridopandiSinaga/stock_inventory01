<?php  
	include "koneksi.php";
	// cek jika pada parameter halaman ada parameter hapus
    if (isset($_GET['hapus'])) {
		$kdpembelian = mysqli_real_escape_string($conn, $_GET['hapus']);
        $q1 = mysqli_query($conn, "DELETE FROM pembelian WHERE kd_pembelian='$kdpembelian'");
		$q2 = mysqli_query($conn, "DELETE FROM barang_pembelian WHERE kd_pembelian='$kdpembelian' AND status='1'");
        echo "<script>location='index.php?page=pembelian';</script>";
    }

?>
<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Pembelian
            </div>
            <div class="panel-body">
                <div class="table">
                    <table class="table table-striped table-bordered table-hover" id="tabelku">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kd Pembelian</th>
                                <th>Tgl Pembelian</th>
                                <th>Kd Supplier</th>
                                <th>Nama Supplier</th>
                                <th>Jumlah Pembelian</th>
                                <th>Total Pembelian</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
								// tampilkan data pembelian
								$no = 1;
								$tampil = mysqli_query($conn, "SELECT * FROM pembelian p JOIN supplier s ON p.kd_supplier=s.kd_supplier ORDER BY kd_pembelian DESC");
								// cek ada atau tidak ada yang bisa ditampilkan
								$jum = mysqli_num_rows($tampil);
								if ($jum < 1) {
									error_reporting(0);
								} else {
									while ($data = mysqli_fetch_array($tampil)) {
										// buat variabel untuk dipakai di parameter link pengecekan penghapusan di bawah
										$kd = $data['kd_pembelian'];
										// hitung item pembelian
										$item = mysqli_query($conn, "SELECT count(*) as jumlah FROM d_pembelian WHERE kd_pembelian='$kd'");
										$jumlahitem = mysqli_fetch_array($item); ?>
										
										<tr class="odd gradeX">
											<td><?php echo $no++; ?></td>
											<td><?php echo $data['kd_pembelian']; ?></td>
											<td><?php echo $data['tgl_pembelian']; ?></td>
											<td><?php echo $data['kd_supplier']; ?></td>
											<td><?php echo $data['nama_supplier']; ?></td>
											<td><?php echo $jumlahitem['jumlah']; ?></td>
											<td>Rp. <?php echo number_format($data['total_pembelian']); ?></td>
											<td>
												<a href="nota/cetakdetailpembelian.php?kdpembelian=<?php echo $data['kd_pembelian']; ?>" target="_BLANK" class="btn btn-info btn-xs"><i class="fa fa-search"></i> Detail</a>
												
												<?php 
												$cekhapus = mysqli_query($conn, "SELECT * FROM barang_pembelian WHERE kd_pembelian = '$kd' AND status ='0'");
												$hitung = mysqli_num_rows($cekhapus);
												if ($hitung > 0) {
													$cek = false;
												}
												else{
													$cek = true;
												}
												
												if ($cek === true): ?>
												<a href="index.php?page=pembelian&hapus=<?php echo $data['kd_pembelian']; ?>" class="btn btn-danger btn-xs" id="alertHapus"><i class="fa fa-trash"></i> Hapus</a>                                        
												<?php endif ?>
												<?php if ($cek === false): ?>
												<a href="index.php?page=pembelian&hapus=<?php echo $data['kd_pembelian']; ?>" class="btn btn-danger btn-xs" id="alertHapus" disabled="disabled"><i class="fa fa-trash"></i> Hapus</a>
												<?php endif ?>
											</td>
										</tr>
										
								<?php
									}
								}
                            ?>
                        </tbody>
                    </table>
                </div>   
            </div>
        </div		>
        <!--End Advanced Tables -->
    </div>
</div>
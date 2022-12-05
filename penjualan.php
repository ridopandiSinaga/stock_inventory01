<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Penjualan
            </div>
            <div class="panel-body">
                <div class="table">
                    <table class="table table-striped table-bordered table-hover" id="tabelku">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kd Penjualan</th>
                                <th>Tgl Penjualan</th>
                                <th>Item</th>
                                <th>Total Penjualan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                                include "koneksi.php";
								$no = 1;
								$qry = mysqli_query($conn, "SELECT * FROM penjualan ORDER BY kd_penjualan DESC");
								$hitung = mysqli_num_rows($qry);
								if ($hitung < 1) {
									error_reporting(0);
								} else {
									while ($data = mysqli_fetch_array($qry)) {
										$kdpenjualan = $data['kd_penjualan'];
										$qrypen = mysqli_query($conn, "SELECT count(*) as jumlah FROM d_penjualan WHERE kd_penjualan = '$kdpenjualan'");
										$d = mysqli_fetch_array($qrypen);
										$jumlahb = $d['jumlah']; ?>
										
										<tr class="odd gradeX">
											<td><?php echo $no++; ?></td>
											<td><?php echo $data['kd_penjualan']; ?></td>
											<td><?php echo $data['tgl_penjualan']; ?></td>
											<td><?php echo $jumlahb; ?></td>
											<td>Rp. <?php echo number_format($data['total_penjualan']); ?></td>
											<td>
												<a href="nota/cetakdetailpenjualan.php?kdpenjualan=<?php echo $data['kd_penjualan']; ?>" target="_BLANK" class="btn btn-info btn-xs"><i class="fa fa-search"></i> Detail</a>
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
        </div>
        <!--End Advanced Tables -->
    </div>
</div>
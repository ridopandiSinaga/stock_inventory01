<?php 
include "koneksi.php";
?>
<div class="row">
	<div class="col-md-12">
		<h2>Laporan Profit Penjualan</h2>
	</div>
	<br/><br/>
	<hr/>
	<br/>
	<div class="col-md-12">
		<form method="POST" class="form-inline">
			<div class="form-group">
				<input type="date" id="tgl1" class="form-control" name="tgl1">
			</div>
			<div class="form-group">
				<label>  Sampai  </label>
				<input type="date" id="tgl2" class="form-control" name="tgl2">
			</div>
			<div class="form-group">
				<button id="formbtn" name="prosess" class="btn btn-primary"><i class="fa fa-play-circle-o"></i> Prosess</button>
				<button class="btn btn-success" name="semua"><i class="fa fa-play-circle-o"></i> Semua Data</button>
			</div>
		</form>
	</div>
</div>
<hr/>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading" align="center">
				<?php if (isset($_POST['prosess'])): ?>
					<a href="laporan/cetaklaporanprofit.php?tgl1=<?php echo $_POST['tgl1']; ?>&tgl2=<?php echo $_POST['tgl2']; ?>" target="_BLANK" class="btn btn-info"><i class="fa fa-print"></i> Cetak</a>
				<?php endif ?>
				<?php if (isset($_POST['semua'])): ?>
					<a href="laporan/cetaklaporanprofit.php?semua" target="_BLANK" class="btn btn-info"><i class="fa fa-print"></i> Cetak</a>
				<?php endif ?>
				<?php if (!isset($_POST['prosess']) && !isset($_POST['semua'])): ?>
					<a href="#" class="btn btn-info" disabled="disabled"><i class="fa fa-print"></i> Cetak</a>
				<?php endif ?>
			</div>
			<div class="panel-body">
				<table class="table table-bordered table-hover">
					<thead>
						<tr class="active">
							<th>No</th>
							<th>Kode Penjualan</th>
							<th>Tgl Penjualan</th>
							<th>Barang</th>
							<th>Satuan</th>
							<th>Jumlah</th>
							<th>Harga Beli</th>
							<th>Harga Jual</th>
							<th>Profit</th>
						</tr>
					</thead>
					<tbody>
					<?php  
						if (isset($_POST['prosess'])) {
							$no = 1;
							$untung = 0;
							$bln1 = $_POST['tgl1'];
							$bln2 = $_POST['tgl2'];
							// hitung total penjualan selama periode bulan yang dipilih
							$qry = mysqli_query($conn, "SELECT sum(dpen.subtotal) as jumlah FROM penjualan pen
								JOIN d_penjualan dpen ON pen.kd_penjualan = dpen.kd_penjualan
								JOIN barang bar ON dpen.kd_barang = bar.kd_barang
								WHERE pen.tgl_penjualan BETWEEN '$bln1' AND '$bln2'");
							$pecah = mysqli_fetch_array($qry);
							$total = $pecah['jumlah'];
							
							
							// cek penjualan selama periode bulan yang dipilih
							$qry2 = mysqli_query($conn, "SELECT * FROM penjualan pen
								JOIN d_penjualan dpen ON pen.kd_penjualan = dpen.kd_penjualan
								JOIN barang bar ON dpen.kd_barang = bar.kd_barang
								WHERE pen.tgl_penjualan BETWEEN '$bln1' AND '$bln2'");
							$hitung = mysqli_num_rows($qry2);
							if ($hitung < 1) {
								echo "<tr><td colspan='8' align='center'>Data Kosong</td></tr>";
							}
							else {
								$qry = mysqli_query($conn, "SELECT * FROM penjualan pen
									JOIN d_penjualan dpen ON pen.kd_penjualan = dpen.kd_penjualan
									JOIN barang bar ON dpen.kd_barang = bar.kd_barang 
									WHERE pen.tgl_penjualan BETWEEN '$bln1' AND '$bln2'");
								$hitung = mysqli_num_rows($qry);
								if ($hitung < 1) {
									error_reporting(0);
								} else {
									while ($data = mysqli_fetch_array($qry)) { 
									$modal = $data['jumlah'] * $data['harga_beli'];
									$profit = $data['subtotal'] - $modal;
									?>
								
									<tr>
										<td><?php echo $no++; ?></td>
										<td><?php echo $data['kd_penjualan']; ?></td>
										<td><?php echo date_format(date_create($data['tgl_penjualan']),'d-m-Y'); ?></td>
										<td><?php echo $data['nama_barang']; ?></td>
										<td><?php echo $data['satuan']; ?></td>
										<td><?php echo $data['jumlah']; ?></td>
										<td>Rp. <?php echo number_format($data['harga_beli']); ?></td>
										<td>Rp. <?php echo number_format($data['harga_jual']); ?></td>
										<td>Rp. <?php echo number_format($profit); ?></td>
									</tr>
								
								<?php
								$untung += $profit;
									}
								}
								
							}
							
					?>
						<tr>
							<td colspan="8" align="center">TOTAL</td>
							<td>Rp. <?php echo number_format($untung); ?></td>
						</tr>
					<?php
					} else if (isset($_POST['semua'])) {
							// hitung dulu total penjualan
							$no = 1;
							$untung = 0;
							$qry = mysqli_query($conn, "SELECT sum(dpen.subtotal) as jumlah FROM penjualan pen
								JOIN d_penjualan dpen ON pen.kd_penjualan = dpen.kd_penjualan
								JOIN barang bar ON dpen.kd_barang = bar.kd_barang");
							$pecah = mysqli_fetch_array($qry);
							$total = $pecah['jumlah'];
							
							// cek penjualan keseluruhan
							$qrypen = mysqli_query($conn, "SELECT * FROM penjualan pen
								JOIN d_penjualan dpen ON pen.kd_penjualan = dpen.kd_penjualan
								JOIN barang bar ON dpen.kd_barang = bar.kd_barang");
							$hitung = mysqli_num_rows($qrypen);
							if ($hitung < 1) {
								echo "<tr><td colspan='8' align='center'>Data Kosong</td></tr>";
							} else {
								while ($data = mysqli_fetch_array($qrypen)) { 
								$modal = $data['jumlah'] * $data['harga_beli'];
								$profit = $data['subtotal'] - $modal;
								?>
									
									<tr>
										<td><?php echo $no++; ?></td>
										<td><?php echo $data['kd_penjualan']; ?></td>
										<td><?php echo date_format(date_create($data['tgl_penjualan']),'d-m-Y'); ?></td>
										<td><?php echo $data['nama_barang']; ?></td>
										<td><?php echo $data['satuan']; ?></td>
										<td><?php echo $data['jumlah']; ?></td>
										<td>Rp. <?php echo number_format($data['harga_beli']); ?></td>
										<td>Rp. <?php echo number_format($data['harga_jual']); ?></td>
										<td>Rp. <?php echo number_format($profit); ?></td>
									</tr>
									
							<?php 
							$untung += $profit;
							} ?>
						<tr>
							<td colspan="8" align="center">TOTAL</td>
							<td>Rp. <?php echo number_format($untung); ?></td>
						</tr>
					<?php
					}
					} else {
					?>
						<tr>
							<td colspan="8" align="center">Pilih Opsi Tampil</td>
						</tr>
						<tr>
							<td colspan="8" align="center">TOTAL</td>
							<td></td>
						</tr>
					<?php
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
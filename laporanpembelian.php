<?php  
include "koneksi.php";
?>
<div class="row">
	<div class="col-md-12">
		<h2>Laporan Pembelian</h2>
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
					<a href="laporan/cetaklaporanpembelian.php?tgl1=<?php echo $_POST['tgl1']; ?>&tgl2=<?php echo $_POST['tgl2']; ?>" target="_BLANK" class="btn btn-info"><i class="fa fa-print"></i> Cetak</a>
				<?php endif ?>
				<?php if (isset($_POST['semua'])): ?>
					<a href="laporan/cetaklaporanpembelian.php?semua" target="_BLANK" class="btn btn-info"><i class="fa fa-print"></i> Cetak</a>
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
							<th>Kode Pembelian</th>
							<th>Tgl Pembelian</th>
							<th>Supplier</th>
							<th>Barang</th>
							<th>Satuan</th>
							<th>Jumlah</th>
							<th>Harga</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
					<?php  
						if (isset($_POST['prosess'])) {
							// hitung total pembelian berdasarkan range tanggal
							$no = 1;
							$bln1 = mysqli_real_escape_string($conn, $_POST['tgl1']);
							$bln2 = mysqli_real_escape_string($conn, $_POST['tgl2']);
							$qry = mysqli_query($conn, "SELECT sum(dpem.subtotal) as jumlah FROM supplier sup
								JOIN pembelian pem ON sup.kd_supplier = pem.kd_supplier
								JOIN d_pembelian dpem ON pem.kd_pembelian = dpem.kd_pembelian
								JOIN barang_pembelian barpem ON dpem.kd_barang_beli = barpem.kd_barang_beli 
								WHERE pem.tgl_pembelian BETWEEN '$bln1' AND '$bln2'");
							$pecah = mysqli_fetch_array($qry);
							$total = $pecah['jumlah'];
							
							// cek data pembelian berdasarkan range tanggal 
							$qrypem = mysqli_query($conn, "SELECT * FROM supplier sup
								JOIN pembelian pem ON sup.kd_supplier = pem.kd_supplier
								JOIN d_pembelian dpem ON pem.kd_pembelian = dpem.kd_pembelian
								JOIN barang_pembelian barpem ON dpem.kd_barang_beli = barpem.kd_barang_beli 
								WHERE pem.tgl_pembelian BETWEEN '$bln1' AND '$bln2'");
							$hitung = mysqli_num_rows($qry);
							if ($hitung >=1) {
								$cek = true;
							}
							else{
								$cek = false;
							}
							
							if ($cek === false) {
								echo "<tr><td colspan='8' align='center'>Data Kosong</td></tr>";
							} else {
							$qrytampil = mysqli_query($conn, "SELECT * FROM supplier sup
									JOIN pembelian pem ON sup.kd_supplier = pem.kd_supplier
									JOIN d_pembelian dpem ON pem.kd_pembelian = dpem.kd_pembelian
									JOIN barang_pembelian barpem ON dpem.kd_barang_beli = barpem.kd_barang_beli 
									WHERE pem.tgl_pembelian BETWEEN '$bln1' AND '$bln2'");
							while ($data = mysqli_fetch_array($qrytampil)) { ?>
							
								<tr>
									<td><?php echo $no++; ?></td>
									<td><?php echo $data['kd_pembelian']; ?></td>
									<td><?php echo date_format(date_create($data['tgl_pembelian']),'d-m-Y'); ?></td>
									<td><?php echo $data['nama_supplier']; ?></td>
									<td><?php echo $data['nama_barang_beli']; ?></td>
									<td><?php echo $data['satuan']; ?></td>
									<td><?php echo $data['jumlah']; ?></td>
									<td>Rp. <?php echo number_format($data['harga_beli']); ?></td>
									<td>Rp. <?php echo number_format($data['subtotal']); ?></td>
								</tr>
							
							<?php
							} }
					?>
						<tr>
							<td colspan="8" align="center">TOTAL</td>
							<td>Rp. <?php echo number_format($total); ?></td>
						</tr>
					<?php
					} elseif (isset($_POST['semua'])) {
							// hitung dulu total pembelian (all time periode)
							$no = 1;
							$qry = mysqli_query($conn, "SELECT sum(dpem.subtotal) as jumlah FROM supplier sup
								JOIN pembelian pem ON sup.kd_supplier = pem.kd_supplier
								JOIN d_pembelian dpem ON pem.kd_pembelian = dpem.kd_pembelian
								JOIN barang_pembelian barpem ON dpem.kd_barang_beli = barpem.kd_barang_beli");
							$pecah = mysqli_fetch_array($qry);
							$total = $pecah['jumlah'];
							
							// lakukan cek data pembelian
							$qrycekpem = mysqli_query($conn, "SELECT * FROM supplier sup
								JOIN pembelian pem ON sup.kd_supplier = pem.kd_supplier
								JOIN d_pembelian dpem ON pem.kd_pembelian = dpem.kd_pembelian
								JOIN barang_pembelian barpem ON dpem.kd_barang_beli = barpem.kd_barang_beli");
							$hitung = mysqli_num_rows($qrycekpem);
							if ($hitung >=1) {
								$cek = true;
							}
							else{
								$cek = false;
							}
							
							if ($cek === false) {
								echo "<tr><td colspan='8' align='center'>Data Kosong</td></tr>";
							} else {
							// tampilkan data pembelian 
							$qrytampilpem = mysqli_query($conn, "SELECT * FROM supplier sup
								JOIN pembelian pem ON sup.kd_supplier = pem.kd_supplier
								JOIN d_pembelian dpem ON pem.kd_pembelian = dpem.kd_pembelian
								JOIN barang_pembelian barpem ON dpem.kd_barang_beli = barpem.kd_barang_beli");
							while ($data = mysqli_fetch_array($qrytampilpem)) { ?>
							
							<tr>
								<td><?php echo $no++; ?></td>
								<td><?php echo $data['kd_pembelian']; ?></td>
								<td><?php echo date_format(date_create($data['tgl_pembelian']),'d-m-Y'); ?></td>
								<td><?php echo $data['nama_supplier']; ?></td>
								<td><?php echo $data['nama_barang_beli']; ?></td>
								<td><?php echo $data['satuan']; ?></td>
								<td><?php echo $data['jumlah']; ?></td>
								<td>Rp. <?php echo number_format($data['harga_beli']); ?></td>
								<td>Rp. <?php echo number_format($data['subtotal']); ?></td>
							</tr>
						<?php 
							} }
					?>
						<tr>
							<td colspan="8" align="center">TOTAL</td>
							<td>Rp. <?php echo number_format($total); ?></td>
						</tr>
					<?php
						} else {
					?>
						<tr>
							<td colspan="9" align="center">Pilih Opsi Tampil</td>
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
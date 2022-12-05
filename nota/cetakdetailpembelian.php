<?php
	include "../koneksi.php";
	$kdpembelian = mysqli_real_escape_string($conn, $_GET['kdpembelian']);
	$qry = mysqli_query($conn, "SELECT * FROM supplier sup 
				JOIN pembelian pem ON pem.kd_supplier = sup.kd_supplier
				JOIN admin adm ON adm.kd_admin = pem.kd_admin
				JOIN d_pembelian dpem ON pem.kd_pembelian = dpem.kd_pembelian
				JOIN barang_pembelian bpem ON dpem.kd_pembelian = bpem.kd_pembelian
				WHERE pem.kd_pembelian = '$kdpembelian'");
	$tam = mysqli_fetch_assoc($qry);
  
  // tampilkan data toko
  $qryper = mysqli_query($conn, "SELECT * FROM perusahaan WHERE kd_perusahaan = '1'");
	$per = mysqli_fetch_assoc($qryper);
?>

<style type="text/css">
.st_total {
	font-size: 9pt;
	font-weight: bold;
	font-family:Verdana, Arial, Helvetica, sans-serif;
}
.cetak{
  margin-top:40px; 
  text-align:center;
}
@media print{
  .no-print{
    display:none !important;
  }
}
.style6 {
	color: #000000;
	font-size: 9pt;
	font-weight: bold;
	font-family: Arial;
}
.style9 {
	color: #000000;
	font-size: 9pt;
	font-weight: normal;
	font-family: Arial;
}
.style9b {
	color: #000000;
	font-size: 9pt;
	font-weight: bold;
	font-family: Arial;
}
.style19b {
	color: #000000;
	font-size: 11pt;
	font-weight: bold;
	font-family: Arial;
}
.style10b {
	color: #000000;
	font-size: 11pt;
	font-weight: bold;
	font-family: Arial;
}
.par{
  color: #000000;
  font-size: 9pt;
  font-weight: normal;
  font-family: Arial;
  margin-top: 3;
}
</style>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="7">
      <div align="center">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="69%" rowspan="3" valign="top" class="style19b">
            <?php echo $per['nama_perusahaan']; ?>
            <br/><p class="par"><?php echo $per['alamat']; ?></p>
            </td>
            <td colspan="3"><div align="center" class="style9b">
              <div align="left" class="style19b"><strong><u>FAKTUR PEMBELIAN</u></strong></div>
            </div></td>
            </tr>
          <tr>
            <td width="11%" height="18" class="style9">Nomor </td>
            <td width="1%" class="style9"><div align="center">:</div></td>
            <td width="14%" class="style9"><?php echo $tam['kd_pembelian']; ?></td>
          </tr>
          <tr>
            <td class="style9">Tanggal</td>
            <td><div align="center">:</div></td>
            <td><span class="style9">
              <?php echo date_format(date_create($tam['tgl_pembelian']),'d-m-Y');?>
            </span></td>
          </tr>
          <tr >
          	<td colspan="1"></td>
            <td class="style9">Supplier</td>
            <td><div align="center">:</div></td>
            <td><span class="style9">
              <?php echo $tam['nama_supplier'];?>
            </span></td>
          </tr>

        </table>
          </div>
       </td>
    </tr>
  </table>
   </br>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="7">
      <hr />      </td>
    </tr>
    <tr>
    	<td width="24" class="style6"><div align="center">No</div></td>
      <td width="150" class="style6"><div align="left">Kode Barang</div></td>
      <td width="203" class="style6"><div align="left">Nama Barang</div></td>
      <td width="60" class="style6"><div align="left">Satuan</div></td>
      <td width="94" class="style6"><div align="left">Jumlah</div></td>
      <td width="117" class="style6"><div align="left">Harga</div></td>
      <td width="117" class="style6"><div align="right">Total</div></td>
    </tr>
      <tr>
      <td colspan="7">
      <hr />      </td>
      </tr>
		<?php
		$no = 1;
      	$qry = mysqli_query($conn, "SELECT * FROM supplier sup 
				JOIN pembelian pem ON pem.kd_supplier = sup.kd_supplier
				JOIN admin adm ON adm.kd_admin = pem.kd_admin
				JOIN d_pembelian dpem ON pem.kd_pembelian = dpem.kd_pembelian
				JOIN barang_pembelian bpem ON dpem.kd_barang_beli = bpem.kd_barang_beli
				WHERE pem.kd_pembelian = '$kdpembelian'");
			$jumdata = mysqli_num_rows($qry);
			if($jumdata < 1) {
				error_reporting(0);
			} else {
				while ($data = mysqli_fetch_array($qry)) { ?>
					
					<tr>
						<td class="style9" align="center"><?php echo $no++;?>.</td>
						<td class="style9"><?php echo $data['kd_barang_beli'];?></td>
						<td class="style9"><?php echo $data['nama_barang_beli'];?></td>
						<td class="style9" align="left"><?php echo $data['satuan'];?></td>
						<td class="style9" align="left"><?php echo $data['item'];?></td>
						<td class="style9" align="left">Rp. <?php echo number_format($data['harga_beli']);?></td>
						<td class="style9" align="right">Rp. <?php echo number_format($data['subtotal']);?></td>
					</tr>
					
			<?php
				}
			}		
	  ?>
      <tr>
      <td colspan="7">
      <hr />      </td>
      </tr>
  </table>
 
  <table width="98%" align="center">
   
    <tr>
      <td colspan="6" align="center" class="st_total">TOTAL</td>
      <td width="152" align="right"><div id="total" class="st_total" align="right">Rp. 
      <?php echo number_format($tam['total_pembelian']); ?>
      </div></td>
    </tr>
  </table>
  
   <table width="98%" border="0" align="center">
   <tr>
     <td colspan="3">&nbsp;</td>
     <td colspan="3">&nbsp;</td>
     <td colspan="3">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="3"><div align="center" class="style9"><?php echo $tam['nama']; ?></div></td>
     <td colspan="3">&nbsp;</td>
     <td colspan="3"></td>
   </tr>
   <tr>
     <td colspan="3">&nbsp;</td>
     <td colspan="3">&nbsp;</td>
     <td colspan="3">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="3">&nbsp;</td>
     <td colspan="3">&nbsp;</td>
     <td colspan="3">&nbsp;</td>
   </tr>
   <tr>
     <td width="82"><div align="right">(</div></td>
     <td width="89">
     <div align="center" class="style9"></div></td>
     <td width="76">)</td>
   </tr>
 </table>
 <div class="cetak no-print">
   <a href="" onclick="print();">(Cetak)</a>
 </div>
<?php
	include "../koneksi.php";
	$kd = mysqli_real_escape_string($conn, $_GET['kdpenjualan']);
	$qry = mysqli_query($conn, "SELECT * FROM penjualan pen
				JOIN admin adm ON adm.kd_admin = pen.kd_admin
				JOIN d_penjualan dpen ON pen.kd_penjualan = dpen.kd_penjualan
				JOIN barang bar ON dpen.kd_barang = bar.kd_barang
				WHERE pen.kd_penjualan = '$kd'");
	$tam = mysqli_fetch_assoc($qry);
    $qry2 = mysqli_query($conn, "SELECT * FROM perusahaan WHERE kd_perusahaan = '1'");
	$per = mysqli_fetch_assoc($qry2);
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
              <div align="left" class="style19b"><strong><u>NOTA PENJUALAN</u></strong></div>
            </div></td>
            </tr>
          <tr>
            <td width="11%" height="18" class="style9">Nomor </td>
            <td width="1%" class="style9"><div align="center">:</div></td>
            <td width="14%" class="style9"><?php echo $tam['kd_penjualan']; ?></td>
          </tr>
          <tr>
            <td class="style9">Tanggal</td>
            <td><div align="center">:</div></td>
            <td><span class="style9">
              <?php echo date_format(date_create($tam['tgl_penjualan']),'d-m-Y');?>
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
      <hr />      
      </td>
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
      	$qry = mysqli_query($conn, "SELECT * FROM penjualan pen
				JOIN admin adm ON adm.kd_admin = pen.kd_admin
				JOIN d_penjualan dpen ON pen.kd_penjualan = dpen.kd_penjualan
				JOIN barang bar ON dpen.kd_barang = bar.kd_barang
				WHERE pen.kd_penjualan = '$kd'");
			$hitung = mysqli_num_rows($qry);
			if ($hitung < 1) {
				error_reporting(0);
			} else {
				while ($data = mysqli_fetch_array($qry)) { ?>
				
				<tr>
					<td class="style9" align="center"><?php echo $no++;?>.</td>
					<td class="style9"><?php echo $data['kd_barang'];?></td>
					<td class="style9"><?php echo $data['nama_barang'];?></td>
					<td class="style9" align="left"><?php echo $data['satuan'];?></td>
					<td class="style9" align="left"><?php echo $data['jumlah'];?></td>
					<td class="style9" align="left">Rp. <?php echo number_format($data['harga_jual']);?></td>
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
      <td colspan="6" align="right" class="st_total">TOTAL</td>
      <td width="200" align="right"><div id="total" class="st_total" align="right">Rp. 
      <?php echo number_format($tam['total_penjualan']); ?>
      </div></td>
    </tr>
    <tr>
      <td colspan="6" align="right" class="st_total">DIBAYAR</td>
      <td width="200" align="right"><div id="total" class="st_total" align="right">Rp. 
      <?php echo number_format($tam['dibayar']); ?>
      </div></td>
    </tr>
    <?php  
      $kembali = $tam['dibayar'] - $tam['total_penjualan'];
    ?>
    <tr>
      <td colspan="6" align="right" class="st_total">KEMBALI</td>
      <td width="200" align="right"><div id="total" class="st_total" align="right">Rp. 
      <?php echo number_format($kembali); ?>
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

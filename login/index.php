<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>App Inventory</title>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <script src="js/prefixfree.min.js"></script>
  </head>
  <body>
    <div id="logo"> 
      <h1><i>APP INVENTORY</i></h1>
    </div> 
	
  <section class="stark-login">
    <form method="POST" action="">	
      <div id="fade-box">
        <input type="text" name="username" id="username" placeholder="Masukan Email" required>
        <input type="password" name="password" placeholder="Masukan Password" required>
        <input type="submit" name="login" value="Masuk"> 
      </div>
    </form>
        <div class="hexagons">
        </div>      
  </section> 
  <div id="circle1">
    <div id="inner-cirlce1">
      <h2></h2>
    </div>
  </div>
    <script src="js/index.js"></script>
  </body>
</html>
<?php  
if(isset($_POST['login'])) :
session_start();
include "../koneksi.php";

$username = mysqli_real_escape_string($conn, $_POST['username']);
$p = mysqli_real_escape_string($conn, $_POST['password']);

$sql = "select * from admin where email='$username' and password='$p' limit 1";
$hasil = mysqli_query ($conn,$sql);
$jumlah = mysqli_num_rows($hasil);


	if ($jumlah>0) {
		$row = mysqli_fetch_assoc($hasil);
		$_SESSION["kd_admin"]=$row["kd_admin"];
		$_SESSION["nama"]=$row["nama"];
		$_SESSION["email"]=$row["email"];
		$_SESSION["gambar"]=$row["gambar"];
	?>
    <script>window.location="../index.php";</script>
<?php	
	} else { ?>
		<script>alert("Login gagal, email atau password salah!");</script>
	<?php }
endif;
?>


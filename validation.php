<?php 

session_start();

echo "entre";

$connection = mysqli_connect('localhost:3306', 'administrador', '123');
mysqli_select_db($connection, 'pyme');

$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

$query = "SELECT * FROM usuario WHERE correo = '$correo' AND contrasena = '$contrasena'";
$result = mysqli_query($connection, $query);
$count = mysqli_num_rows($result);

if($count == 1){
	$row = mysqli_fetch_assoc($result);
	if($row['posicion'] == 1){
		$_SESSION['correo'] = $correo;
		header('location:adminhome.php');
	}else{
		$_SESSION['correo'] = $correo;
		header('location:home.php');
	}
}else{
	header('location:login.php');
}

 ?>
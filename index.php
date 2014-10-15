<?php 

session_start();



if (isset($_GET['logout'])) {

	session_destroy();

	echo "<meta http-equiv='refresh' content='0; url=index.php'>";

}

 ?>

<!DOCTYPE html>

<html>

<head>

	<title>Homecel - Inicio</title>

	<meta charset="utf-8">

	<link rel="stylesheet" type="text/css" href="css/style.css">

</head>

<body>



<div id="header"></div>

<form action="index.php" method="post">

<div id="login">

	<img src="img/logo.png">

	<h1>Inicio de Sesión</h1>

	<input type="text" placeholder="Clave de Empleado" name="user">

	<input type="password" placeholder="Contraseña" name="pass">



	<?php 

	if (isset($_POST['login'])) {

		include 'conex.php';

		$login = "SELECT count(*) A FROM hcempleado WHERE usuario ='".$_POST['user']."' AND password = '".md5($_POST['pass'])."'";

		$resultado = mysqli_query($con, $login);

		$r=$resultado->fetch_assoc();



		if ($r['A']==0) {

			

		}else{

			$login = "SELECT * FROM hcempleado WHERE usuario ='".$_POST['user']."' AND password = '".md5($_POST['pass'])."'";

			$reslogin = mysqli_query($con, $login);

			$rl=$reslogin->fetch_assoc();

			echo "<meta http-equiv='refresh' content='0; url=ventas.php?a=v'>";

			$_SESSION['usuario']=$rl['usuario'];

			$_SESSION['idTienda']=$rl['idTienda'];

			$_SESSION['idEmpleado']=$rl['idEmpleado'];

			$_SESSION['idPerfil']=$rl['idPerfil'];



			//Permisos

			$permisos = "SELECT editarIMEI, agregarInventario, eliminarCliente, crearUsuario, verReporte, darDescuento

						FROM hcperfil WHERE idPerfil = (SELECT idPerfil FROM hcempleado WHERE idEmpleado =" . $_SESSION['idEmpleado'] . ")";

			$resPermisos = mysqli_query($con, $permisos);

			$per = $resPermisos->fetch_assoc();

			$_SESSION['editarIMEI']        = $per['editarIMEI'];

			$_SESSION['agregarInventario'] = $per['agregarInventario'];

			$_SESSION['eliminarCliente']   = $per['eliminarCliente'];

			$_SESSION['crearUsuario']      = $per['crearUsuario'];

			$_SESSION['verReporte']        = $per['verReporte'];

			$_SESSION['darDescuento']      = $per['darDescuento'];

		}







	}

?>



	<input type="submit" class="boton" value="Entrar" name="login">



	<footer><img src="img/telcel.jpg"><br><p>Distribuidor Autorizado Telcel &copy;</p></footer>

</div>

</form>





</body>

</html>
<?php 

	session_start();

	if(isset($_SESSION['usuario']) && $_SESSION['crearUsuario'] == 1) {

		include 'conex.php';

		// include 'captura-apartado.php';

?>



<!DOCTYPE html>

<html>

<head>

	<title>Homecel - AdministradorS</title>

	<meta charset="utf-8">

	<link rel="stylesheet" type="text/css" href="css/style.css">

	<script type="text/javascript" src="js/javascript.js"></script>

<script type="text/javascript" src="shortcut.js"></script>

</head>

<body>



<?php include 'menu.php'; 

	

	$verPerfiles = "SELECT idPerfil, nombrePerfil FROM hcperfil ORDER BY 1;";

	$resPerfiles = mysqli_query($con, $verPerfiles);



	$verSucursales = "SELECT idTienda, nombreTienda, direccion, estado FROM hctienda ORDER BY 4, 3, 2;";

	$resSucursales = mysqli_query($con, $verSucursales);



	if(isset($_POST['agregarEmpleado'])) {

		$nuevoEmpleado = "INSERT INTO hcempleado(usuario, password, idPerfil, idTienda) VALUES('" . $_POST['nuevoEmpleado'] . "', '" 

			. md5($_POST['nuevaContrasena']) . "', " . $_POST['perfil'] . ", " . $_POST['sucursal'] . ");";

		$con->query($nuevoEmpleado);

		$mensaje = "Empleado agregado corretamente.";

	}



	if(isset($_POST['agregarSucursal'])) {

		$nuevaSucursal = "INSERT INTO hctienda(nombreTienda, direccion, estado) VALUES('".utf8_decode($_POST['nuevoNombreSuc'])."', '"

			.utf8_decode($_POST['nuevaDireccion'])."', '".utf8_decode($_POST['estado']) ."');";

		$con->query($nuevaSucursal);

		$mensaje = "Sucursal agregada correctamente.";

	}



	if(isset($_POST['editarPass'])) {

		if($_POST['passNueva1'] == $_POST['passNueva2']) {

			$pass = "SELECT password FROM hcempleado WHERE idempleado = " . $_SESSION['idEmpleado'] . ";";

			$resPass = mysqli_query($con, $pass);

			$resultado = $resPass->fetch_assoc();

			if($resultado['password'] == md5($_POST['passActual'])) {

				$cambiarPass = "UPDATE hcempleado SET password = '" . md5($_POST['passNueva1']) . "' WHERE idempleado = " . $_SESSION['idEmpleado'] . ";";

				$con->query($cambiarPass);

				$mensaje = "Contraseña cambiada corretamente.";

			} else {

				$mensaje = "La contraseña actual no es correcta";

			}

		} else {

			$mensaje = "Las contraseñas nuevas no coinciden";

		}

	}



?>







<section style="width:95%;">
	
	<div id="tabs">

		<a href="administrador.php?a=ad"><div class="tab activo">Administrador</div></a>

		<!-- <a href="agregar-accesorios.php"><div class="tab">Agregar Accesorios</div>

		<a href="agregar-chips.php?a=i"><div class="tab">Agregar Empleados</div></a>

		<a href="agregar-tarjetas.php?a=i"><div class="tab">Agregar Sucursal</div></a>

		<a href="agregar-imei.php?a=i"><div class="tab"><p>Telefonos sin IMEI</p> <span id="no-imei"> </span></div></a>

		<a href="ver-inventario.php?a=i"><div class="tab">Ver Todo</div></a>
 -->
	</div>

	<div id="inventario">



	<h1>Administrador</h1>



	<?php if(isset($mensaje)) echo $mensaje . "<br />"; ?>


	<div class="tercio">
	<h2>Cambiar contraseña para <?php echo $_SESSION['usuario'] ?></h2>

	<form action="#" method="POST">

		<table class="modulitos">

			<tr><td>Contraseña actual</td><td><input class="mod-inp" type="password" name="passActual" size="50" /></td></tr>

			<tr><td>Contraseña nueva</td><td><input class="mod-inp" type="password" name="passNueva1" size="50" /></td></tr>

			<tr><td>Confirmar contraseña nueva</td><td><input class="mod-inp" type="password" name="passNueva2" size="50" /></td></tr>

			<tr><td><td><input type="submit" name="editarPass" class="boton-azul grande" value="Guardar" /></td></td></tr>

		</table>

	</form>
	</div>




	<div class="tercio">
	<h2>Agregar Empleado</h2>

	<form action="#" method="POST">

		<table class="modulitos">

			<tr><td>Clave de Empleado</td><td><input  class="mod-inp" type="text" name="nuevoEmpleado" size="50" /></td></tr>

			<tr><td>Contraseña</td><td><input  class="mod-inp" type="password" name="nuevaContrasena" size="50" /></td></tr>

			<tr><td>Perfil</td><td>

				<select name="perfil"  class="mod-inp">

				<?php while($perfiles = $resPerfiles->fetch_assoc()) { ?>

					<option value="<?php echo $perfiles['idPerfil'] ?>" <?php if($perfiles['nombrePerfil'] == "Cajero") echo "selected"; ?>><?php echo $perfiles['nombrePerfil'] ?></option>					

				<?php } ?>

				</select>

			</td></tr>

			<tr><td>Sucursal</td><td>

				<select name="sucursal" class="mod-inp">

				<?php while($sucursales = $resSucursales->fetch_assoc()) { ?>

					<option value="<?php echo $sucursales['idTienda'] ?>"><?php echo utf8_encode($sucursales['nombreTienda']) ." - ".utf8_encode($sucursales['direccion']) ?>, <?php echo utf8_encode($sucursales['estado']) ?></option>					

				<?php } ?>

				</select>

			</td></tr>

			<tr><td><td><input type="submit" name="agregarEmpleado" class="boton-azul grande" value="Agregar" /></td></td></tr>

		</table>

	</form>
	</div>


	<div class="tercio">

	<h2>Agregar Sucursal</h2>

	<form action="#" method="POST">

		<table class="modulitos">

			<tr><td>Sucursal</td><td><input class="mod-inp" type="text" name="nuevoNombreSuc" size="50" /></td></tr>			

			<tr><td>Dirección</td><td><input  class="mod-inp"type="text" name="nuevaDireccion" size="50" /></td></tr>

			<tr><td>Estado</td><td>

				<select name="estado" class="mod-inp">

					<option value="Aguascalientes">Aguascalientes</option>

					<option value="Baja California">Baja California</option>

					<option value="Baja California Sur">Baja California Sur</option>

					<option value="Campeche">Campeche</option>

					<option value="Chiapas">Chiapas</option>

					<option value="Chihuahua">Chihuahua</option>

					<option value="Coahuila">Coahuila</option>

					<option value="Colima">Colima</option>

					<option value="Distrito Federal">Distrito Federal</option>

					<option value="Durango">Durango</option>

					<option value="Estado de México">Estado de México</option>

					<option value="Guanajuato">Guanajuato</option>

					<option value="Guerrero">Guerrero</option>

					<option value="Hidalgo">Hidalgo</option>

					<option value="Jalisco">Jalisco</option>

					<option value="Michoacán">Michoacán</option>

					<option value="Morelos">Morelos</option>

					<option value="Nayarit">Nayarit</option>

					<option value="Nuevo León">Nuevo León</option>

					<option value="Oaxaca">Oaxaca</option>

					<option value="Puebla">Puebla</option>

					<option value="Querétaro">Querétaro</option>

					<option value="Quintana Roo">Quintana Roo</option>

					<option value="San Luis Potosí" selected="selected">San Luis Potosí</option>

					<option value="Sinaloa">Sinaloa</option>

					<option value="Sonora">Sonora</option>

					<option value="Tabasco">Tabasco</option>

					<option value="Tamaulipas">Tamaulipas</option>

					<option value="Tlaxcala">Tlaxcala</option>

					<option value="Veracruz">Veracruz</option>

					<option value="Yucatán">Yucatán</option>

					<option value="Zacatecas">Zacatecas</option>

				</select>

			</td></tr>

			<tr><td><td><input type="submit" name="agregarSucursal" value="Agregar" class="boton-azul grande" /></td></td></tr>

		</table>

	</form>

	

	</div>

	

</section>



</body>

</html>



<?php } else { ?>

	<meta http-equiv="refresh" content="0; url=index.php">

<?php } ?>
<?php 
	session_start();
	if(isset($_SESSION['usuario']) && $_SESSION['crearUsuario'] == 1) {
		include 'conex.php';
		// include 'captura-apartado.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Homecel - Administrador</title>
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

	<!-- <div id="tabs">
		<a href="apartado.php"><div class="tab">Agregar Apartado</div></a>
		<a href="agregar-accesorios.php"><div class="tab">Agregar Accesorios</div>
		<a href="ver-apartados.php"><div class="tab activo">Ver Apartados</div></a>
	</div> -->
	
	<div id="inventario">
	<h1>Administrador</h1>

	<?php if(isset($mensaje)) echo $mensaje . "<br />"; ?>

	<p>Cambiar contraseña para <?php echo $_SESSION['usuario'] ?></p>
	<form action="#" method="POST">
		<table style="max-width:200px;">
			<tr><td>Contraseña actual</td><td><input type="password" name="passActual" size="50" /></td></tr>
			<tr><td>Contraseña nueva</td><td><input type="password" name="passNueva1" size="50" /></td></tr>
			<tr><td>Confirmar contraseña nueva</td><td><input type="password" name="passNueva2" size="50" /></td></tr>
			<tr><td><td><input type="submit" name="editarPass" /></td></td></tr>
		</table>
	</form>

	<p>Agregar Empleado</p>

	<form action="#" method="POST">
		<table style="max-width:200px;">
			<tr><td>Clave de Empleado</td><td><input type="text" name="nuevoEmpleado" size="50" /></td></tr>
			<tr><td>Contraseña</td><td><input type="password" name="nuevaContrasena" size="50" /></td></tr>
			<tr><td>Perfil</td><td>
				<select name="perfil">
				<?php while($perfiles = $resPerfiles->fetch_assoc()) { ?>
					<option value="<?php echo $perfiles['idPerfil'] ?>" <?php if($perfiles['nombrePerfil'] == "Cajero") echo "selected"; ?>><?php echo $perfiles['nombrePerfil'] ?></option>					
				<?php } ?>
				</select>
			</td></tr>
			<tr><td>Sucursal</td><td>
				<select name="sucursal">
				<?php while($sucursales = $resSucursales->fetch_assoc()) { ?>
					<option value="<?php echo $sucursales['idTienda'] ?>"><?php echo utf8_encode($sucursales['nombreTienda']) ." - ".utf8_encode($sucursales['direccion']) ?>, <?php echo utf8_encode($sucursales['estado']) ?></option>					
				<?php } ?>
				</select>
			</td></tr>
			<tr><td><td><input type="submit" name="agregarEmpleado" /></td></td></tr>
		</table>
	</form>

	<p>Agregar Sucursal</p>

	<form action="#" method="POST">
		<table style="max-width:400px;">
			<tr><td>Sucursal</td><td><input type="text" name="nuevoNombreSuc" size="50" /></td></tr>			
			<tr><td>Dirección</td><td><input type="text" name="nuevaDireccion" size="50" /></td></tr>
			<tr><td>Estado</td><td>
				<select name="estado">
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
			<tr><td><td><input type="submit" name="agregarSucursal" /></td></td></tr>
		</table>
	</form>
	
	</div>
	
</section>

</body>
</html>

<?php } else { ?>
	<meta http-equiv="refresh" content="0; url=index.php">
<?php } ?>
<?php 
	if (isset($_POST['nombre'])) {
		
		$nombre = utf8_decode($_POST['nombre']);
		$direccion = utf8_decode($_POST['direccion']);
		$ciudad = utf8_decode($_POST['ciudad']);
		$estado = utf8_decode($_POST['estado']);
		$telefono = utf8_decode($_POST['telefono']);
		$correo = utf8_decode($_POST['correo']);
		$rfc = utf8_decode($_POST['rfc']);

		$insertar = "INSERT INTO 
					hccliente (nombre, direccion, ciudad, estado, telefono, email, rfc) 
					VALUES
					('".$nombre."', '".$direccion."', '".$ciudad."', '".$estado."', '".$telefono."', '".$correo."', '".$rfc."')";
		mysqli_query($con, $insertar);
	}
 ?>
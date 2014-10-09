<?php 
	session_start();
	if(isset($_SESSION['usuario'])) {
	
		$_SESSION['precioTotal']=0;
		include 'conex.php';
		include 'captura-cliente.php';

?>

<!DOCTYPE html>
<html>
<head>
	<title>Homecel - Clientes</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/javascript.js"></script>
<script type="text/javascript" src="shortcut.js"></script>
</head>
<body>



<?php include 'menu.php'; ?>


<section style="width:95%;">

	<div id="tabs">
		<div class="tab activo">Agregar Cliente</div>
		<!-- <a href="agregar-accesorios.php"><div class="tab">Agregar Accesorios</div> -->
		<a href="ver-clientes.php?a=c"><div class="tab">Ver Clientes</div></a>
		<!-- <a href="agregar-imei.php"><div class="tab"><p>Telefonos sin IMEI</p> <span id="no-imei"> </span></div></a> -->
	</div>
	<form method="post" action="clientes.php">
	<div id="inventario">
	<h1>Agregar Cliente</h1>
		<table>
			<tr>
				<td colspan="2"><input type="text" placeholder="NOMBRE COMPLETO" name="nombre" autofocus></td>
				<td><input type="text" placeholder="TELEFONO" name="telefono"></td>
				<td><input type="email" placeholder="E-MAIL" name="correo"></td>
			</tr>

			<tr>
				<td><input type="text" placeholder="DIRECCION" name="direccion"></td>
				<td><input type="text" placeholder="CIUDAD" name="ciudad"></td>
				<td><input type="text" placeholder="ESTADO" name="estado"></td>
				<td><input type="text" placeholder="RFC" name="rfc"></td>
			</tr>

			<tr>
				
			</tr>

			<!-- <tr>
				<td><input type="text" placeholder="FOLIO FACTURA" name="folio"></td>
				<td><select name="tipo">
					<optgroup label="TELEFONIA">
						<option value="movil">movil</option>
						<option value="fijo">fijo</option>
						<option value="reconstruido">reconstruido</option>
					</optgroup>
					<optgroup label="ACCESORIOS">
						<option value="manos libres">Manos Libres</option>
						<option value="fundas">Fundas</option>
						<option value="carcasas">Carcasas</option>
					</optgroup>
				</td>
				<td><input type="text" placeholder="DISEÑO" name="diseno"></td>
			</tr>

			<tr>
				<td><input type="number" placeholder="GARANTIA" min="0" name="garantia"></td>
				<td><input type="text" placeholder="PROVEEDOR" name="proveedor"></td>
				<td><input type="text" placeholder="PRECIO" name="precio"></td>
			</tr> -->
		</table>
		<input type="submit" class="boton-azul grande" value="Agregar">
	</div>
	</form>
</section>


<script type="text/javascript">
	window.addEventListener('load', contadorIMEI, false);
</script>


</body>
</html>

<?php } else { ?>
	<meta http-equiv="refresh" content="0; url=index.php">
<?php } ?>
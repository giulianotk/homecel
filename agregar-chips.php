<?php 
	session_start();

	if(isset($_SESSION['usuario'])) {
		$_SESSION['precioTotal']=0;
		include 'conex.php';

		$idTienda = $_SESSION['idTienda'];

		include 'captura-chip.php';

?>

<!DOCTYPE html>
<html>
<head>
	<title>Homecel - Inventario</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/javascript.js"></script>
<script type="text/javascript" src="shortcut.js"></script>
</head>
<body>



<?php include 'menu.php'; ?>



<section style="width:95%;">

	<div id="tabs">
		<a href="inventario.php?a=i"><div class="tab">Agregar Celulares y Accesorios</div></a>
		<!-- <a href="agregar-accesorios.php"><div class="tab">Agregar Accesorios</div> -->
		<a href="agregar-chips.php?a=i"><div class="tab activo">Agregar Chips</div>
		<a href="agregar-tarjetas.php?a=i"><div class="tab">Agregar Tarjetas</div>
		<a href="agregar-imei.php?a=i"><div class="tab"><p>Telefonos sin IMEI</p> <span id="no-imei"> </span></div></a>
		<a href="ver-inventario.php?a=i"><div class="tab">Ver Todo</div></a>

	</div>
	<form method="post" action="agregar-chips.php">
	<div id="inventario">
	<h1>Agregar Chips</h1>
	<div id="agregar-celulares"><p>Cantidad para agregar:</p> <input type="number" placeholder="CANT." min="1" value="1" name="cantidad"></div>
		<table>
			<tr>
				<td colspan="3"><input type="text" placeholder="IMEI" name="codigo" required="required"></td>
			</tr>

			<tr>
				<td><input type="text" placeholder="PROVEEDOR" name="proveedor"></td>
				<td>
				<select name="modelo">
					<option value="" disabled selected style='display:none;'>MODELO</option>
					<option value="Amigo">Amigo</option>
					<option value="Amigo Micro">Amigo Micro</option>
					<option value="Reconstruido (KIT 3)">Reconstruido (KIT 3)</option>
					<option value="PIP">PIP</option>
				</select>
				</td>
				<td><input type="text" placeholder="PRECIO" name="precio" required="required"></td>
			</tr>

			<tr>
				<td><input type="text" placeholder="FOLIO FACTURA" name="folio" required="required"></td>
				
			</tr>

			
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
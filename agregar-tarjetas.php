<?php 
	session_start();

	if(isset($_SESSION['usuario'])) {
		$_SESSION['precioTotal']=0;
		include 'conex.php';

		$idTienda = $_SESSION['idTienda'];

		include 'captura-tarjeta.php';

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
		<a href="agregar-chips.php?a=i"><div class="tab">Agregar Chips</div>
		<a href="agregar-tarjetas.php?a=i"><div class="tab activo">Agregar Tarjetas</div>
		<a href="agregar-imei.php?a=i"><div class="tab"><p>Telefonos sin IMEI</p> <span id="no-imei"> </span></div></a>
		<a href="ver-inventario.php?a=i"><div class="tab">Ver Todo</div></a>

	</div>
	<form method="post" action="agregar-tarjetas.php">
	<div id="inventario">
	<h1>Agregar Tarjetas de Recarga</h1>
	<div id="agregar-celulares"><p>Cantidad para agregar:</p> <input type="number" placeholder="CANT." min="1" value="1" name="cantidad"></div>
		<table>
			<tr>
				<td colspan="3"><input type="text" placeholder="CODIGO DE BARRAS" name="codigo" required="required"></td>
			</tr>

			<tr>
				<td><input type="text" placeholder="FOLIO FACTURA" name="folio"></td>

				<td><input type="text" placeholder="FOLIO TARJETA" name="folioTarjeta"></td>
				
				<td><input type="text" placeholder="MONTO" name="montoTarjeta" required="required"></td>
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
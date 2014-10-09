<?php 
	session_start();
	if(isset($_SESSION['usuario'])) {	
		$_SESSION['precioTotal']=0;
		include 'conex.php';

		$idTienda = $_SESSION['idTienda'];

		include 'captura-multiples.php';

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
		<a href="agregar-tarjetas.php?a=i"><div class="tab">Agregar Tarjetas</div>
		<a href="agregar-imei.php?a=i"><div class="tab activo"><p>Telefonos sin IMEI</p> <span id="no-imei"> </span></div></a>
		<a href="ver-inventario.php?a=i"><div class="tab">Ver Todo</div></a>

	</div>
	
	<div id="inventario">
	<h1>Teléfonos sin IMEI</h1>
	<table>

	<tr >
		<th>Marca</th>
		<th>Modelo</th>
		<th>Color</th>
		<th>Precio</th>
		<th>IMEI</th>
		<th>CHIP</th>
		<th>CAPTURAR</th>
	</tr>

	<?php 
		$contadorIMEI ="SELECT * FROM hcarticulo WHERE IMEI IS NULL AND idTipoArt IN (SELECT idTipoArt FROM hctipoart WHERE categoria LIKE 'E') AND idTienda = ".$idTienda."";
		$res = mysqli_query($con, $contadorIMEI);
		while ($r=$res->fetch_assoc()) {
	?>
		
			<tr>
				<td><?php echo $r['marca']; ?></td>
				<td><?php echo $r['modelo']; ?></td>
				<td><?php echo $r['color']; ?></td>
				<td>$<?php echo $r['precio']; ?></td>
				<td><input type="text" placeholder="IMEI" id="imei-<?php echo $r['idArticulo']; ?>"></td>
				<td><input type="text" placeholder="CODIGO CHIP" id="chip-<?php echo $r['idArticulo']; ?>"></td>
				<td><button class="boton-azul chico" onclick="capturarImei('<?php echo $r['idArticulo']; ?>')">Capturar</button></td>
			</tr>
		
	<?php
		}
	?>
	</table>
	</div>
</section>


<script type="text/javascript">
	window.addEventListener('load', contadorIMEI, false);
</script>


</body>
</html>

<?php } else { ?>
	<meta http-equiv="refresh" content="0; url=index.php">
<?php } ?>
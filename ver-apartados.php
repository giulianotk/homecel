<?php 
	session_start();
	if(isset($_SESSION['usuario'])) {
		include 'conex.php';
		// include 'captura-apartado.php';

		$idTienda = $_SESSION['idTienda'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Homecel - Apartado</title>
	
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/javascript.js"></script>
<script type="text/javascript" src="shortcut.js"></script>
</head>
<body>



<?php include 'menu.php'; ?>



<section style="width:95%;">

	<div id="tabs">
		<a href="apartado.php?a=a"><div class="tab">Agregar Apartado</div></a>
		<!-- <a href="agregar-accesorios.php"><div class="tab">Agregar Accesorios</div> -->
		<a href="ver-apartados.php?a=a"><div class="tab activo">Ver Apartados</div></a>
	</div>
	
	<div id="inventario">
	<h1>Apartados</h1>
	<table>

	<tr>
		<th>Cliente</th>
		<th>Art&iacute;culo</th>
		<th>Fecha Apartado</th>
		<th>Fecha Vencimiento</th>
		<th>Total</th>
		<th>Abonado</th>
		<th>Restante</th>
		<th>Abono</th>
		<th></th>
	</tr>

	<?php 
		$contadorIMEI ="SELECT a.`idApartado`, a.`idTienda`, a.`idEmpleado`, c.`nombre`, e.`marca`, e.`modelo`, DATE_FORMAT(a.`fechaApartado`, '%d/%m/%y') fechaApartado, DATE_FORMAT((SELECT DATE_ADD(a.`fechaApartado`, INTERVAL 1 MONTH)), '%d/%m/%y') fechaVencimiento, e.precio, (SELECT SUM(p.cantidadPago) FROM `hcpagos` p WHERE p.idApartado = a.`idApartado`) abonado, (e.`precio` - (SELECT SUM(p.cantidadPago) FROM `hcpagos` p WHERE p.idApartado = a.`idApartado`)) restante
						FROM hcapartado a, `hccliente` c, hcarticulo e
						WHERE a.`idCliente` = c.`idCliente`
						AND a.`idArticulo` = e.`idArticulo`
						AND a.idTienda = ".$idTienda."
						ORDER BY fechaApartado";

		$res = mysqli_query($con, $contadorIMEI);
		while ($r=mysqli_fetch_array($res)) {
			if($r['abonado'] == null ) { $abonado = 0; } else { $abonado = $r['abonado']; }
	?>
		
			<tr>
				<td><?php echo $r['nombre']; ?></td>
				<td><?php echo $r['marca'] . " " . $r['modelo']; ?></td>
				<td><?php echo $r['fechaApartado']; ?></td>
				<td><?php echo $r['fechaVencimiento'];?></td>
				<td class="total"><?php echo "$" . $r['precio']; ?></td>
				<td class="abonado"><?php echo "$" . $abonado; ?></td>
				<td class="restante"><?php echo "$" . ($r['precio'] - $abonado); ?></td>
				<td><input type="text" placeholder="$0.00" id="cantidadAbono-<?php echo $r['idApartado']; ?>"></td>
				<td><button class="boton-azul chico" onclick="capturarAbono('<?php echo $r['idApartado']; ?>')">Abonar</button></td>
			</tr>
		
	<?php
		}
	?>
	</table>
	</div>
	
</section>

</body>
</html>

<?php } else { ?>
	<meta http-equiv="refresh" content="0; url=index.php">
<?php } ?>
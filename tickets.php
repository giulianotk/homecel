<?php 
	session_start();
	if(isset($_SESSION['usuario'])) {
		include 'conex.php';
		// include 'captura-apartado.php';

		$calcularFecha = "SELECT DATE_FORMAT(curdate(), '%d/%m/%Y') fecha FROM dual;";
		$resFecha = mysqli_query($con, $calcularFecha);
		$fecha = $resFecha->fetch_assoc();
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

	<!-- <div id="tabs">
		<a href="apartado.php"><div class="tab">Agregar Apartado</div></a>
		<a href="agregar-accesorios.php"><div class="tab">Agregar Accesorios</div>
		<a href="ver-apartados.php"><div class="tab activo">Ver Apartados</div></a>
	</div> -->
	
	<div id="inventario">
	<h1>Tickets de Hoy (<?php echo $fecha['fecha']; ?>)</h1>

	<?php 
		$queryTickets = "SELECT idTicket FROM hcticket WHERE fecha = (SELECT curdate() FROM dual);";
		$resultadoTickets = mysqli_query($con, $queryTickets);
	 ?>

	<?php while($tickets = $resultadoTickets->fetch_assoc()) { ?>

	<div class="mini-ticket">

		<table>
			<tr>
				<th colspan="6">FOLIO: <?php echo $tickets['idTicket'] ?></th>
			</tr>
			<tr>
				<th>Producto</th>
				<th>Modelo</th>
				<th>IMEI</th>
				<th>Color</th>
				<th>Diseño</th>
				<th>Precio</th>
			</tr>
			<?php  
				$total = 0;

				$queryTicket = "SELECT t.`idTicket`, a.marca, a.modelo, a.color, a.imei, a.diseno, a.precio, t.iva, t.total 
								FROM hcticket t, hcventa v, hcarticulo a
								WHERE t.`idTicket` = v.`idTicket`
								AND t.`idTienda` = v.`idTienda`
								AND t.`idEmpleado` = v.`idEmpleado`
								AND t.`idCliente` = v.`idCliente`
								AND t.`idTienda` = a.`idTienda`
								AND v.`idTienda` = a.`idTienda`
								AND v.`idArticulo` = a.`idArticulo`
								AND t.`idTicket` = ".$tickets['idTicket']."
								ORDER BY 1, t.`fecha` DESC";
				$resultadoTicket = mysqli_query($con, $queryTicket);

				while($ticket = $resultadoTicket->fetch_assoc()) {
			?>
			<tr>
				<td><?php echo $ticket['marca'] ?></td>
				<td><?php echo $ticket['modelo'] ?></td>
				<td><?php echo $ticket['imei'] ?></td>
				<td><?php echo $ticket['color'] ?></td>
				<td><?php echo $ticket['diseno'] ?></td>
				<td>$<?php echo $ticket['precio']; $total += $ticket['precio']; ?></td>
			</tr>

			<?php } ?>

			<tr>
				<td colspan="4"></td>
				<td>Total</td>
				<td>$<?php echo $total; ?></td>
			</tr>

		</table>
		
	</div>

	<?php } ?>
	
	</div>
	
</section>

</body>
</html>

<?php } else { ?>
	<meta http-equiv="refresh" content="0; url=index.php">
<?php } ?>
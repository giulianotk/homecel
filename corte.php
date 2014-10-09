<?php 
	session_start();
	if(isset($_SESSION['usuario'])) {
		include 'conex.php';
		$idTienda = $_SESSION['idTienda'];
		// $idEmpleado = $_SESSION['idEmpleado'];
	
		$totalEquipos = 0;
		$totalAccesorios = 0;
		$totalChips = 0;
		$totalTarjetas = 0;

		$obtenerFecha = "SELECT DATE_FORMAT(NOW(), '%H:%i %d/%m/%Y') fecha";
		$resFecha = mysqli_query($con, $obtenerFecha);
		$fecha = $resFecha->fetch_assoc();
	
		$corteEquipos = "SELECT v.`idArticulo`, a.marca, a.modelo, a.imei, a.color, a.precio
					FROM hcticket t, hcventa v, hcarticulo a
					WHERE t.`idTicket` = v.`idTicket`
					AND t.idTienda = ".$_SESSION['idTienda']."
					AND t.idEmpleado = ".$_SESSION['idEmpleado']."
					AND v.`idArticulo` = a.`idArticulo`
					AND t.`fecha` = (SELECT CURDATE() FROM DUAL)
					AND a.idTipoArt IN (SELECT idtipoArt FROM hctipoart WHERE categoria = 'E')";
		$corteE = mysqli_query($con, $corteEquipos);	
 ?>

 	<p>Corte para <?php echo utf8_decode($_SESSION['usuario']); ?></p>
 	<p>Sucursal: <?php echo utf8_decode($_SESSION['sucursal']); ?></p>
 	<p>Fecha: <?php echo $fecha['fecha']; ?></p>

	<h1>Equipos</h1>
	<?php
		if($corteE->num_rows == 0) {
			echo "No se vendieron equipos<br />";
		} else {
	?>
	<table>
		<tr><td>Marca</td><td>Modelo</td><td>IMEI</td><td>Color</td><td>Precio</td></tr>
		<?php while ($c = $corteE -> fetch_assoc()) { ?>
			<tr><td><?php echo $c['marca'] ?></td><td><?php echo $c['modelo'] ?></td><td><?php echo preg_replace("/^(\d{6})(\d{2})(\d{6})(\d{1})$/", "$1-$2-$3-$4", $c['imei']); ?></td><td><?php echo $c['color'] ?></td><td><?php echo "$" . $c['precio']; $totalEquipos += $c['precio']; ?></td></tr>
			<?php } ?>
	</table>
	<p>Total Equipos: $<?php echo $totalEquipos ?></p>
	<?php } ?>

<?php 

	$corteAccesorios = "SELECT v.`idArticulo`, a.marca, a.modelo, a.diseno, a.precio
						FROM hcticket t, hcventa v, hcarticulo a
						WHERE t.`idTicket` = v.`idTicket`
						AND t.idTienda = ".$_SESSION['idTienda']."
						AND t.idEmpleado = ".$_SESSION['idEmpleado']."
						AND v.`idArticulo` = a.`idArticulo`
						AND t.`fecha` = (SELECT CURDATE() FROM DUAL)
						AND a.idTipoArt IN (SELECT idtipoArt FROM hctipoart WHERE categoria = 'A')";
	$corteA = mysqli_query($con, $corteAccesorios);

?>
	<hr>
	<h1>Accesorios</h1>
	<?php 
		if($corteA->num_rows == 0) {
			echo "No se vendieron accesorios<br />";
		} else {
	?>
	<table>
		<tr><td>Marca</td><td>Modelo</td><td>Dise&ntilde;o</td><td>Precio</td>
		<?php while ($c = $corteA -> fetch_assoc()) { ?>
			<tr><td><?php echo $c['marca'] ?></td><td><?php echo $c['modelo'] ?></td><td><?php echo $c['diseno'] ?></td><td><?php echo "$" . $c['precio']; $totalAccesorios += $c['precio']; ?></td></tr>
			<?php } ?>
	</table>
	<p>Total Accesorios: $<?php echo $totalAccesorios; ?></p>
	<?php } ?>


<?php 

	$corteSIM = "SELECT v.`idArticulo`, a.imei, a.modelo, a.precio
				FROM hcticket t, hcventa v, hcarticulo a
				WHERE t.`idTicket` = v.`idTicket`
				AND t.idTienda = ".$_SESSION['idTienda']."
				AND t.idEmpleado = ".$_SESSION['idEmpleado']."
				AND v.`idArticulo` = a.`idArticulo`
				AND t.`fecha` = (SELECT CURDATE() FROM DUAL)
				AND a.idTipoArt IN (SELECT idtipoArt FROM hctipoart WHERE tipoArt = 'SIM')";
	$corteS = mysqli_query($con, $corteSIM);

?>

	<hr>
	<h1>Chips</h1>
	<?php 
		if($corteS->num_rows == 0) {
			echo "No se vendieron chips<br />";
		} else {
	?>
	<table>
		<tr><td>IMEI</td><td>Tipo</td><td>Precio</td>
		<?php while ($c = $corteS -> fetch_assoc()) { ?>
			<tr><td><?php echo $c['imei'] ?></td><td><?php echo $c['modelo'] ?></td><td><?php echo "$" . $c['precio']; $totalChips += $c['precio']; ?></td></tr>
			<?php } ?>
	</table>
	<p>Total Chips: $<?php $totalChips; ?></p>
	<?php } ?>

	<hr>

<?php 

	$corteTarjeta = "SELECT v.`idArticulo`, a.folioTarjeta, a.montoTarjeta
				FROM hcticket t, hcventa v, hcarticulo a
				WHERE t.`idTicket` = v.`idTicket`
				AND t.idTienda = ".$_SESSION['idTienda']."
				AND t.idEmpleado = ".$_SESSION['idEmpleado']."
				AND v.`idArticulo` = a.`idArticulo`
				AND t.`fecha` = (SELECT CURDATE() FROM DUAL)
				AND a.idTipoArt IN (SELECT idtipoArt FROM hctipoart WHERE tipoArt = 'Tarjeta Recarga')";
	$corteT = mysqli_query($con, $corteTarjeta);

?>

	<h1>Tarjetas de Recarga</h1>
	<?php 
		if($corteT->num_rows == 0) {
			echo "No se vendieron tarjetas de recarga<br />";
		} else {
	?>
	<table>
		<tr><td>Folio</td><td>Monto</td>
		<?php while ($c = $corteT -> fetch_assoc()) { ?>
			<tr><td><?php echo $c['folioTarjeta'] ?></td><td><?php echo "$" . $c['montoTarjeta']; $totalTarjetas += $c['montoTarjeta']; ?></td>
			<?php } ?>
	</table>
	<p>Total Tarjetas: $<?php echo $totalTarjetas; ?></p>
	<?php } ?>

	<hr>

	<?php 
		$pagoEfectivo = "SELECT SUM(total) total
						FROM hcticket t
						WHERE formaPago = 1
						AND t.idTienda = ".$_SESSION['idTienda']."
						AND t.idEmpleado = ".$_SESSION['idEmpleado']."
						AND fecha = (SELECT curdate() FROM dual)";
		$resEfectivo = mysqli_query($con, $pagoEfectivo);
		$efectivo = $resEfectivo->fetch_assoc();

		$pagosTarjeta = "SELECT SUM(total) total
						FROM hcticket t
						WHERE formaPago = 2
						AND t.idTienda = ".$_SESSION['idTienda']."
						AND t.idEmpleado = ".$_SESSION['idEmpleado']."
						AND fecha = (SELECT curdate() FROM dual)";
		$resTarjeta = mysqli_query($con, $pagosTarjeta);
		$tarjeta = $resTarjeta->fetch_assoc();

		$abonosApartados = "SELECT SUM(cantidadPago) total
							FROM hcpagos
							WHERE fechaPago = (SELECT curdate() FROM dual)";
		$resAbonos = mysqli_query($con, $abonosApartados);
		$abonos = $resAbonos->fetch_assoc();
	 ?>

	 <br />
	 <h1>Pagos</h1>
	<table>
		<tr><td>Efectivo</td><td style="text-align:right;">$<?php echo $efectivo['total'] ?></td></tr>
		<tr><td>Tarjeta</td><td style="text-align:right;">$<?php echo $tarjeta['total'] ?></td></tr>
		<tr><td>Total</td><td style="text-align:right;">$<?php echo $efectivo['total'] + $tarjeta['total'] ?></td></tr>
	</table>

	<h1>Abonos</h1>
	<table>
		<tr><td>Total</td><td>$<?php if($abonos['total'] > 0) { echo $abonos['total']; } else { echo "0.0"; }?></td></tr>
	</table>

<?php } else { ?>
	<meta http-equiv="refresh" content="0; url=index.php">
<?php } ?>
<?php 
	session_start();
	if(isset($_SESSION['usuario']) && $_SESSION['verReporte'] == 1) {
		include 'conex.php';
		// include 'captura-apartado.php';

?>

<!DOCTYPE html>
<html>
<head>
	<title>Homecel - Reportes</title>
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
	<h1>Reportes</h1>

	<a href="reportes/existencias_por_equipo_imei.php" class="reporte" target="_blank">Existencias por Equipo e IMEI</a>
	<a href="reportes/ventas_por_equipo.php" class="reporte" target="_blank">Ventas por Equipo</a>
	<a href="reportes/top_ventas.php" class="reporte" target="_blank">Top Ventas Equipos</a>
	<a href="reportes/ventas_general.php" class="reporte" target="_blank">Reporte de Ventas General</a>
	<a href="reportes/ventas_detalle.php" class="reporte" target="_blank">Reporte de Ventas Detallado</a>
	<a href="tickets.php?a=r" class="reporte" target="_blank">Ver Tickets del Día</a>
	
	</div>
	
</section>

</body>
</html>

<?php } else { ?>
	<meta http-equiv="refresh" content="0; url=index.php">
<?php } ?>
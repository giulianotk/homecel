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
		<a href="agregar-tarjetas.php?a=i"><div class="tab ">Agregar Tarjetas</div>
		<a href="agregar-imei.php?a=i"><div class="tab"><p>Telefonos sin IMEI</p> <span id="no-imei"> </span></div></a>
		<a href="ver-inventario.php?a=i"><div class="tab activo">Ver Todo</div></a>

	</div>
	<div id="inventario">
	<h1>INVENTARIO</h1>

	<input type="text" placeholder="BUSCAR POR TIPO, MODELO O MARCA" class="codigo" onkeyup="buscarInventario()" id="codigo-inventario"> 
	<div id="busqueda-inventario">
	<table>
		<tr>
			<th>Marca</th>
			<th>Modelo</th>
			<th>Color</th>
			<th>Tipo</th>
			<th>Diseño</th>
			<th>Precio</th>
			<th>IMEI</th>
			<th></th>
		</tr>
		<?php
		$todoInventario = "SELECT * FROM hcarticulo WHERE idTienda = ".$idTienda." AND existencia = 1 ORDER BY 2 DESC, 4 DESC, 5 DESC";
		$todo = mysqli_query($con, $todoInventario);
		$inter = "";
		while ($r = $todo -> fetch_assoc()) {

			$imei = $r['IMEI'];
			$imei_guiones = preg_replace("/^(\d{6})(\d{2})(\d{6})(\d{1})$/", "$1-$2-$3-$4", $imei);

			$tipoArticulo = "SELECT tipoArt FROM hctipoart WHERE idTipoArt = ". $r['idTipoArt'];
			$resTipo= mysqli_query($con, $tipoArticulo);

			$tipo = $resTipo -> fetch_assoc();

		?>

			<tr class="<?php echo $inter; ?>">
				<td><?php echo utf8_encode($r['marca']); ?></td>
				<td><?php echo utf8_encode($r['modelo']); ?> </td>
				<td><?php echo utf8_encode($r['color']); ?></td>
				<td><?php echo utf8_encode($tipo['tipoArt']); ?></td>
				<td><?php echo utf8_encode($r['diseno']); ?></td>
				<td>$<?php echo $r['precio']; ?> </td>
				<td><?php if ($r['IMEI']!="") {echo $imei_guiones; } else{ echo "NA";}  ?> </td>
				
				<td><button class="boton-azul" onclick="darBaja('<?php echo $r['idArticulo']; ?>')">Dar de Baja</button></td>
			</tr>
		<?
			
		}

		if ($inter == "") {
			$inter = "inter";
		}else{
			$inter = "";
		} ?>

	</div>
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
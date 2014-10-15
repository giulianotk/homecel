<?php 
	session_start();
	if(isset($_SESSION['usuario'])) {	
		$_SESSION['precioTotal']=0;
		include 'conex.php';
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
		<a href="inventario.php?a=i"><div class="tab activo">Traspasos</div></a>
		<!-- <a href="agregar-accesorios.php"><div class="tab">Agregar Accesorios</div> -->
		<!-- <a href="agregar-chips.php?a=i"><div class="tab">Agregar Chips</div>
		<a href="agregar-tarjetas.php?a=i"><div class="tab">Agregar Tarjetas</div>
		<a href="agregar-imei.php?a=i"><div class="tab"><p>Telefonos sin IMEI</p> <span id="no-imei"> </span></div></a>
		<a href="ver-inventario.php?a=i"><div class="tab">Ver Todo</div></a> -->

	</div>
	<form method="get" action="traspasos.php" >
	<div id="inventario">
		<h1>Traspasos</h1>
		<?php 

		 	if(isset($_REQUEST['producto'])) {
		 		$arreglo = $_REQUEST['producto'];
				foreach ($arreglo as $a) {
					$update = "UPDATE hcarticulo SET idTienda =" . $_REQUEST['tienda'] . " WHERE idArticulo =" . $a;
					$con->query($update);
				}
			}
		?>
		<h2>Para seleccionar varios articulos por traspaso, manten presionada la tecla Ctrl mientras seleccionas los articulos.</h2>

		<div class="half">
			<h2>Matriz</h2>
			<select multiple class="listas" name="producto[]">
				<?php 
				$todoInventario = "SELECT * FROM hcarticulo ORDER BY 2 DESC,4 DESC,5 DESC";
				$todo = mysqli_query($con, $todoInventario);
				while ($r = $todo -> fetch_assoc()) {
					$imei = $r['IMEI'];
					$imei_guiones = preg_replace("/^(\d{6})(\d{2})(\d{6})(\d{1})$/", "$1-$2-$3-$4", $imei);

					$tipoArticulo = "SELECT tipoArt FROM hctipoart WHERE idTipoArt = ". $r['idTipoArt'];
					$resTipo= mysqli_query($con, $tipoArticulo);
					$tipo = $resTipo -> fetch_assoc();
				?>

			<option value="<?php echo utf8_encode($r['idArticulo']); ?>">

				<?php echo utf8_encode($r['marca']); ?>
				<?php echo utf8_encode($r['modelo']); ?> 
				<?php echo utf8_encode($r['color']); ?>
				<?php echo utf8_encode($tipo['tipoArt']); ?>
				<?php echo utf8_encode($r['diseno']); ?>
				$<?php echo $r['precio']; ?> 
			<?php		
				}

			?>

			</option>

			</select>


			</div>

			<div class="half">
				<h2>Sucursal</h2>

				<select multiple class="listas" name="tienda">
				<?php 
				$todoTiendas = "SELECT * FROM hctienda ORDER BY 2 DESC";
				$todoT = mysqli_query($con, $todoTiendas);
				while ($r = $todoT -> fetch_assoc()) {
					
				?>

			<option value="<?php echo utf8_encode($r['idTienda']); ?>">

				<?php echo utf8_encode($r['direccion']); ?>
				<?php echo utf8_encode($r['estado']); ?> 				
				<?php		
				}
				?>

			</option>

			</select>

			<input type="submit" class="boton-azul grande" value="Traspasar">

			</div>

			
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
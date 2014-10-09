<?php 
	session_start();
	if(isset($_SESSION['usuario'])) {	
		$_SESSION['precioTotal']=0;
		include 'conex.php';
		// include 'captura-apartado.php';

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
		<div class="tab activo">Agregar Apartado</div>
		<!-- <a href="agregar-accesorios.php"><div class="tab">Agregar Accesorios</div> -->
		<a href="ver-apartados.php?a=a"><div class="tab">Ver Apartados</div></a>
	</div>
	<!-- <form method="get" action="apartado.php"> -->
	<div id="inventario">
	<h1>Agregar Apartado</h1>
		<table>
			<tr>
				<td colspan="3"><b>Selecciona un cliente:</b>
				<select name="cliente" id="cliente">
					<?php 
						$clientes = "SELECT * FROM hccliente";
						$res = mysqli_query($con, $clientes);
						

						while ($r = mysqli_fetch_array($res)) {
					?>
						<option value="<?php echo $r['idCliente']; ?>"> <?php echo $r['nombre']; ?> - 
						<?php echo $r['direccion']; ?> <?php echo $r['ciudad']; ?>, <?php echo $r['estado']; ?>  </option>
					<?php
						}
					?>
				</select></td>
			</tr>
			<tr>
				<td colspan="3"><input type="text" placeholder="IMEI O DESCRIPCION" name="codigo" onkeyup="buscarApartado()" id="codigo"></td>
			</tr>

		</table>

		<table id="apartado-tabla">
			<tr>
				<th colspan="5" style="text-align:center">ART&Iacute;CULOS APARTADOS</th>
			</tr>
			<tr>
				<th>Marca</th>
				<th>Modelo</th>
				<th>IMEI</th>
				<th>Color</th>
				<th>Precio</th>
			</tr>
		</table>

		<!-- </form> -->

		<div id="respuesta-busqueda" style="margin-top:-10px;"></div>


		<input type="submit" class="boton-azul grande" value="Apartar" onclick="apartar()">
	</div>
	
</section>

</body>
</html>

<?php } else { ?>
	<meta http-equiv="refresh" content="0; url=index.php">
<?php } ?>
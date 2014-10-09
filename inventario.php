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
		<a href="inventario.php?a=i"><div class="tab activo">Agregar Celulares y Accesorios</div></a>
		<!-- <a href="agregar-accesorios.php"><div class="tab">Agregar Accesorios</div> -->
		<a href="agregar-chips.php?a=i"><div class="tab">Agregar Chips</div>
		<a href="agregar-tarjetas.php?a=i"><div class="tab">Agregar Tarjetas</div>
		<a href="agregar-imei.php?a=i"><div class="tab"><p>Telefonos sin IMEI</p> <span id="no-imei"> </span></div></a>
		<a href="ver-inventario.php?a=i"><div class="tab">Ver Todo</div></a>

	</div>
	<form method="post" action="inventario.php" enctype="multipart/form-data">
	<div id="inventario">
	<h1>Agregar Celulares y Accesorios</h1>
	<div id="agregar-celulares"><p>Cantidad para agregar:</p> <input type="number" placeholder="CANT." name="cantidad" required="required" value="1"></div>
		<table>
			<tr>
				<td colspan="3"><input type="text" placeholder="IMEI" name="codigo"></td>
			</tr>

			<tr>
				<td><input type="text" placeholder="MARCA" name="marca"></td>
				<td><input type="text" placeholder="MODELO" name="modelo"></td>
				<td><input type="text" placeholder="COLOR" name="color"></td>
			</tr>

			<tr>
				<td><input type="text" placeholder="FOLIO FACTURA" name="folio" required="required"></td>
				<td><select name="tipo" required="required">
					<option value="" disabled selected style='display:none;'>TIPO DE ARTICULO</option>
					<optgroup label="TELEFONOS">
						<?php  
						$telefonos = "SELECT * FROM hctipoart WHERE categoria = 'E'";
						$resT = mysqli_query($con, $telefonos);
						while ($rt = $resT -> fetch_assoc()) {
						?>
							<option value="<?php echo $rt['idTipoArt'] ?>"><?php echo utf8_encode($rt['tipoArt']); ?></option>
						<?php
						}
						?>					
					</optgroup>
					<optgroup label="ACCESORIOS">
						<?php  
						$accesorios = "SELECT * FROM hctipoart WHERE categoria = 'A'";
						$resA = mysqli_query($con, $accesorios);
						while ($rA = $resA -> fetch_assoc()) {
						?>
							<option value="<?php echo $rA['idTipoArt'] ?>"><?php echo utf8_encode($rA['tipoArt']); ?></option>
						<?php
						}
						?>							
					</optgroup>
					
				</td>
				<td><input type="text" placeholder="DISEÑO" name="diseno"></td>
			</tr>

			<tr>
				<td><input type="text" placeholder="MESES DE GARANTIA" name="garantia" required="required"></td>
				<td><input type="text" placeholder="PRECIO" name="precio" required="required"></td>
				<td></td>
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
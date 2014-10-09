<?php 
	session_start();
	if(isset($_SESSION['usuario'])) {
		$_SESSION['precioTotal']=0;
		include 'conex.php';
		include 'captura-cliente.php';

?>

<!DOCTYPE html>
<html>
<head>
	<title>Homecel - Clientes</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/javascript.js"></script>
<script type="text/javascript" src="shortcut.js"></script>
</head>
<body>



<?php include 'menu.php'; ?>



<section style="width:95%;">

	<div id="tabs">
		<a href="clientes.php?a=c"><div class="tab">Agregar Cliente</div></a>
		<!-- <a href="agregar-accesorios.php"><div class="tab">Agregar Accesorios</div> -->
		<a href="ver-clientes.php"><div class="tab activo">Ver Clientes</div></a>
		<!-- <a href="agregar-imei.php"><div class="tab"><p>Telefonos sin IMEI</p> <span id="no-imei"> </span></div></a> -->
	</div>
	<form method="post" action="clientes.php">
	<div id="inventario">
	<h1>Clientes</h1>
		<table>
		<tr>
			<th>Nombre</th>
			<th>Dirección</th>
			<th>Contacto</th>
			<th></th>
			
		</tr>

		<?php 
		$clientes ="SELECT * FROM hccliente";
		$res = mysqli_query($con, $clientes);
		$inter = "";
		while ($r=mysqli_fetch_array($res)) {
		?>

			<tr class="<?php echo $inter; ?>">
				<td>
				<?php echo $r['nombre']; ?>
				</td>
				<td>
				<?php echo $r['direccion']; ?> ;
				<?php echo $r['ciudad']; ?>,
				<?php echo $r['estado']; ?>
				</td>
				<td>
				<?php echo $r['telefono']; ?> ó <?php echo $r['email']; ?>
				</td>

				<td>
					<button onclick="eliminarCliente(<?php echo $r['idCliente']; ?>)" class="boton-mini-eliminar">X</button>
					<button onclick="editarCliente(<?php echo $r['idCliente']; ?>)" class="boton-mini-editar">Editar</button>
				</td>
			</tr>

		<?php 

			if ($inter == "") {
				$inter = "inter";
			}else{
				$inter = "";
			}
		}
		?>
		</table>
	</div>
	</form>
</section>
</body>
</html>

<?php } else { ?>
	<meta http-equiv="refresh" content="0; url=index.php">
<?php } ?>
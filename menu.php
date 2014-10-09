<?php 
	$a = $_GET['a'];
	switch ($a) {
		case 'v':
			$ventas = "actual";
			break;
		case 'a':
			$apartado = "actual";
			break;
		case 'i':
			$inventario = "actual";
			break;
		case 'c':
			$clientes = "actual";
			break;
		case 'ad':
			$administrador = "actual";
			break;	
		case 'r':
			$reportes = "actual";
			break;
		default:
			break;
	}
?>

<div id="menu">
	<ul>
		<a href="ventas.php?a=v"><li class="<?php echo $ventas; ?>">
			<center><img src="img/ventas.png"></center>
			<p>Ventas</p>
			<small>Ctrl + 1</small>
		</li></a>

		<a href="apartado.php?a=a"><li class="<?php echo $apartado; ?>">
			<center><img src="img/apartado.png"></center>
			<p>Apartado</p>
			<small>Ctrl + 2</small>
		</li></a>

		<a href="inventario.php?a=i"><li class="<?php echo $inventario; ?>">
			<center><img src="img/inventario.png"></center>
			<p>Inventario</p>
			<small>Ctrl + 3</small>
		</li></a>
		
		<a href="clientes.php?a=c"><li class="<?php echo $clientes; ?>">
			<center><img src="img/admin.png"></center>
			<p>Clientes</p>
			<small>Ctrl + 4</small>
		</li></a>
		<a href="administrador.php?a=ad" style="display:<?php if($_SESSION['crearUsuario'] == 1) { echo "inline-block"; } else { echo "none"; } ?>"><li class="<?php echo $administrador; ?>">
			<center><img src="img/admin.png"></center>
			<p>Administrador</p>
			<small>Ctrl + 5</small>
		</li></a>

		<a href="reportes.php?a=r" style="display:<?php if($_SESSION['verReporte'] == 1) { echo "inline-block"; } else { echo "none"; } ?>"><li class="<?php echo $reportes; ?>">
			<center><img src="img/admin.png"></center>
			<p>Reportes</p>
			<small>Ctrl + 5</small>
		</li></a>
	</ul>

	<div id="usuario">
		<p><b><?php echo $_SESSION['usuario']; ?> </b> - 
		<?php 
			$tienda = "SELECT * FROM hctienda WHERE idTienda = ".$_SESSION['idTienda'];
			$resTienda = mysqli_query($con, $tienda);
			$rt = $resTienda->fetch_assoc();
			$_SESSION['sucursal'] = utf8_encode($rt['nombreTienda']) . ", " . utf8_encode($rt['estado']);
			echo $_SESSION['sucursal'];
			?><a href="index.php?logout" class="logout">Salir</a></p>
		<p id="hora"></p>
	</div>
</div>
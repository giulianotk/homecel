<?php 
	session_start();

	include '../conex.php';

	$_SESSION['precioTotal']=0;

	$carritoLimpio = explode("_", $_SESSION['carrito']);

	foreach ($carritoLimpio as $articulo) {
		if($articulo != '') {
			$regresar = "UPDATE HCArticulo SET existencia = 1 WHERE idArticulo = " . $articulo;
			$con->query($regresar);
		}
	}
 ?>


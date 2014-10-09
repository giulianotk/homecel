<?php 

	session_start();
	include '../conex.php';

	$abono = $_GET['cantidadAbono'];
	$idApartado = $_GET['idApartado'];

	$insert = "INSERT INTO hcpagos(idApartado, fechaPago, cantidadPago) VALUES(" . $idApartado . ", (SELECT CURDATE() FROM DUAL), " . $abono . ");";

	$con->query($insert);
?>
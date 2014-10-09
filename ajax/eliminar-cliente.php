<?php 
	session_start();

	include 'conex.php';

	$idCliente = $_GET['idCliente'];

	echo $borrarCliente = "DELETE from hccliente
						WHERE idCliente = ".$idCliente;
    mysqli_query($con, $borrarCliente);
 ?>


<?php 

session_start();

include '../conex.php';

$imei = $_GET['imei'];

$chip = $_GET['chip'];

$idArticulo = $_GET['idArticulo'];

echo $capturarImei = "UPDATE hcarticulo set IMEI = '".$imei. "', SIM = '".$chip. "' WHERE idArticulo = ".$idArticulo;

mysqli_query($con, $capturarImei);

 ?>
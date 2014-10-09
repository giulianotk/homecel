<?php 
session_start();

include '../conex.php';

echo $idQuitar = $_GET['idQuitar']."_";

echo "<br>";

$_SESSION['carrito'] = str_replace($idQuitar, "_", $_SESSION['carrito']);

echo $_SESSION['carrito'];

$cambioExistencia = "UPDATE hcarticulo set existencia = 1 WHERE idArticulo = ".$_GET['idQuitar'];
mysqli_query($con, $cambioExistencia);

$precio = "SELECT precio FROM hcarticulo WHERE idArticulo = ".$_GET['idQuitar'];
$res = mysqli_query($con, $precio);
$r = $res->fetch_assoc();

$_SESSION['precioTotal'] = $_SESSION['precioTotal'] - $r['precio'];

?>
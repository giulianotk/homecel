<?php 

session_start();
include '../conex.php';

$idTienda = $_SESSION['idTienda'];
$idEmpleado = $_SESSION['idEmpleado'];
$idCliente = $_GET['c'];


$carritoApartado = $_SESSION['carritoApartado']; /* Compremos el artículo 11, el 115, el 9 y el 6. Porque somos ricos y millonarios. */
$carritoApartadoNuevo = explode("_", $carritoApartado);

	foreach ($carritoApartadoNuevo as $articulo) {
		if($articulo != '') {
			// $precioArt = "SELECT precio FROM hcarticulo WHERE idArticulo =".$articulo;
			// $precioRes = mysqli_query($con, $precioArt);
			// $st = $precioRes -> fetch_assoc();
			// $subtotal = $st['precio'];

			echo $apartado = "INSERT INTO hcapartado(idTienda, idEmpleado, idCliente, idArticulo, fechaApartado) 
			VALUES(".$idTienda.", ".$idEmpleado.", ".$idCliente.", ".$articulo.", (SELECT CURDATE() FROM DUAL))";
			mysqli_query($con, $apartado);
		} 
	}


$_SESSION['carritoApartado']="";

 ?>
<?php 
	session_start();
	include '../conex.php';
	$idTienda = $_SESSION['idTienda'];
	$idEmpleado = $_SESSION['idEmpleado'];
	$idCliente = $_GET['c'];
	$iva = $_GET['iva'];
	$formaPago = $_GET['fp'];
	$total = $_GET['total'];
	$totalArray = explode(",", $total);
	foreach ($totalArray as $digito) {
		$totalLimpio.=$digito;
	}
	$idDescuento = 1;

	// INSERTAR EN HCTICKET EL GENERAL DE LA COMPRA
	$ticket = "INSERT into hcticket(idTienda, idEmpleado, idCliente, fecha, iva, total, formaPago)
				VALUES(".$idTienda.", ".$idEmpleado.", ".$idCliente.", (SELECT CURDATE() FROM DUAL), ".$iva.", ".$totalLimpio.", ".$formaPago.")";
	mysqli_query($con, $ticket);

	// SELECCIONAR EL IDTICKET DE LA VENTA QUE SE INSERTÓ
	$idTicket = "SELECT idTicket FROM hcticket WHERE idTienda = (".$idTienda.") AND idEmpleado = (".$idEmpleado.") AND idCliente = (".$idCliente.
	") AND fecha = (SELECT CURDATE() FROM DUAL) AND total = (".$totalLimpio.")";
	$resIT = mysqli_query($con, $idTicket);
	$idT = $resIT->fetch_assoc();
	$idTick = $idT['idTicket'];

	$carrito = $_SESSION['carrito']; /* Compremos el artículo 11, el 115, el 9 y el 6. Porque somos ricos y millonarios. */
	$carritoNuevo = explode("_", $carrito);

	foreach ($carritoNuevo as $articulo) {
		if($articulo != '') {
			$precioArt = "SELECT precio FROM hcarticulo WHERE idArticulo =".$articulo;
			$precioRes = mysqli_query($con, $precioArt);
			$st = $precioRes -> fetch_assoc();
			$subtotal = $st['precio'];

			$venta = "INSERT INTO hcventa(idTienda, idEmpleado, idCliente, idArticulo, idTicket, idDescuento, subtotal) 
			VALUES(".$idTienda.", ".$idEmpleado.", ".$idCliente.", ".$articulo.", ".$idTick.", ".$idDescuento.", ".$subtotal.")";
			mysqli_query($con, $venta);
		} 
	}

	echo "¡Gracias por su Compra!";

?>
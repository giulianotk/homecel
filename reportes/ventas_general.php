<?php 
	session_start();

	include("../conex.php");

	$idTienda = $_SESSION['idTienda'];

	if($_SERVER['SERVER_NAME'] == "homecel.net") {
		$imagen = "http://" . $_SERVER['SERVER_NAME'] . "/img/logo.png";
	} else {
		$imagen = "http://" . $_SERVER['SERVER_NAME'] . "/homecel/img/logo.png";
	}

	if($_SESSION['idPerfil'] == 1) {
		$filtro = " AND a.idTienda IN (SELECT DISTINCT(idTienda) FROM hctienda) ";
	} else {
		$filtro = " AND a.idTienda = (SELECT idTienda FROM hcempleado WHERE idEmpleado = ". $_SESSION['idEmpleado'] .")";
	}

	#$reporteEquipos = "SELECT COUNT(a.`idArticulo`) total, a.marca a, a.modelo b, a.precio c
	#					FROM hcticket t, hcventa v, hcarticulo a
	#					WHERE t.`idTicket` = v.`idTicket`
	#					AND v.`idArticulo` = a.`idArticulo`
	#					AND a.idTipoArt IN (SELECT idtipoArt FROM hctipoart WHERE categoria = 'E')
	#					GROUP BY a.marca, a.modelo, a.precio
	#					ORDER BY 2, 3";

	$reporteEquipos = "SELECT COUNT(idArticulo) total, a.marca a, a.modelo b, a.precio c 
						FROM hcarticulo a
						WHERE a.`idTipoArt` IN (SELECT idtipoArt FROM hctipoart WHERE categoria = 'E')
						AND a.`existencia` = 0
						AND a.`idArticulo` NOT IN (SELECT idArticulo FROM hcapartado)
						AND a.idTienda = ".$idTienda."
						GROUP BY a.`marca`, a.`modelo`, a.precio
						ORDER BY 1, 2";

	$resultadoE = mysqli_query($con, $reporteEquipos);

	$reporteAccesorios = "SELECT COUNT(v.`idArticulo`) total, i.`tipoArt`, a.diseno, a.precio
							FROM hcticket t, hcventa v, hcarticulo a, `hctipoart` i
							WHERE t.`idTicket` = v.`idTicket`
							AND v.`idArticulo` = a.`idArticulo`
							AND a.`idTipoArt` = i.idTipoArt
							AND a.idTipoArt IN (SELECT idtipoArt FROM hctipoart WHERE categoria = 'A')
							AND a.idTienda = ".$idTienda."
							GROUP BY a.marca, a.modelo, a.diseno, a.precio
							ORDER BY 2, 3, 4";

	$resultadoA = mysqli_query($con, $reporteAccesorios);

	$reporteSIMs = "SELECT COUNT(v.`idArticulo`) total, a.modelo, a.precio
					FROM hcticket t, hcventa v, hcarticulo a
					WHERE t.`idTicket` = v.`idTicket`
					AND v.`idArticulo` = a.`idArticulo`
					AND a.idTipoArt IN (SELECT idtipoArt FROM hctipoart WHERE tipoArt = 'SIM')
					AND a.idTienda = ".$idTienda."
					GROUP BY  a.modelo, a.precio
					ORDER BY 2, 3";

	$resultadoS = mysqli_query($con, $reporteSIMs);

	$reporteTarjetas = "SELECT COUNT(v.`idArticulo`) total, a.modelo, a.montoTarjeta
						FROM hcticket t, hcventa v, hcarticulo a
						WHERE t.`idTicket` = v.`idTicket`
						AND v.`idArticulo` = a.`idArticulo`
						AND a.idTipoArt IN (SELECT idtipoArt FROM hctipoart WHERE tipoArt ='Tarjeta Recarga')
						AND a.idTienda = ".$idTienda."
						GROUP BY  a.modelo, a.precio
						ORDER BY 2, 3";

	$resultadoT = mysqli_query($con, $reporteTarjetas);

	require_once('fpdf.php');

	class PDF extends FPDF{

	}

	$pdf = new PDF();
	$pdf->AddPage();
	$pdf->Image($imagen, 85, 5, 45, 0);
	$pdf->Ln(25);
	$pdf->SetFont('Helvetica','B',11);
	$pdf->Cell(187, 10, "Homecel, La Casa del Celular", 0, 1, 'C');
	$pdf->SetFont('Helvetica','',11);
	$pdf->Cell(187, 10, "Sucursal: " . utf8_decode($_SESSION['sucursal']), 0, 1, 'C');
	$pdf->Ln(5);
	$pdf->SetFont('Helvetica','I',11);
	$pdf->Cell(187, 10, "Reporte de Ventas General", 0, 1, 'L');
	// EQUIPOS
	$pdf->Ln(3);
	$pdf->SetFont('Helvetica','',11);
	$pdf->Cell(187, 10, "Equipos", 0, 1, 'L');
	$pdf->SetFont('Helvetica','B',11);
	$pdf->Cell(30, 10, "Vendidos", 0, 0, 'C');
	$pdf->Cell(67, 10, "Marca", 0, 0, 'L');
	$pdf->Cell(57, 10, "Modelo", 0, 0, 'L');
	$pdf->Cell(25, 10, "Precio", 0, 1, 'C');
	$pdf->SetFont('Helvetica','',11);
	while($ventasE = $resultadoE->fetch_assoc()) {
		$pdf->Cell(30, 10, $ventasE['total'], 0, 0, 'C');
		$pdf->Cell(67, 10, $ventasE['a'], 0, 0, 'L');
		$pdf->Cell(57, 10, $ventasE['b'], 0, 0, 'L');
		$pdf->Cell(25, 10, "$" . $ventasE['c'], 0, 1, 'C');
	}
	// ACCESORIOS
	$pdf->Ln(3);
	$pdf->SetFont('Helvetica','',11);
	$pdf->Cell(187, 10, "Accesorios", 0, 1, 'L');
	$pdf->SetFont('Helvetica','B',11);
	$pdf->Cell(30, 10, "Vendidos", 0, 0, 'C');
	$pdf->Cell(47, 10, "Tipo", 0, 0, 'L');
	$pdf->Cell(77, 10, "Diseno", 0, 0, 'L');
	$pdf->Cell(25, 10, "Precio", 0, 1, 'C');
	$pdf->SetFont('Helvetica','',11);
	while($ventasA = $resultadoA->fetch_assoc()) {
		$pdf->Cell(30, 10, $ventasA['total'], 0, 0, 'C');
		$pdf->Cell(47, 10, $ventasA['tipoArt'], 0, 0, 'L');
		$pdf->Cell(77, 10, $ventasA['diseno'], 0, 0, 'L');
		$pdf->Cell(25, 10, "$" . $ventasA['precio'], 0, 1, 'C');
	}
	//SIMs
	$pdf->Ln(3);
	$pdf->SetFont('Helvetica','',11);
	$pdf->Cell(187, 10, "SIMs", 0, 1, 'L');
	$pdf->SetFont('Helvetica','B',11);
	$pdf->Cell(30, 10, "Vendidos", 0, 0, 'C');
	$pdf->Cell(75, 10, "Tipo", 0, 0, 'C');
	$pdf->Cell(74, 10, "Precio", 0, 1, 'C');
	$pdf->SetFont('Helvetica','',11);
	while($ventasS = $resultadoS->fetch_assoc()) {
		$pdf->Cell(30, 10, $ventasS['total'], 0, 0, 'C');
		$pdf->Cell(75, 10, $ventasS['modelo'], 0, 0, 'C');
		$pdf->Cell(74, 10, "$" . $ventasS['precio'], 0, 1, 'C');
	}
	//Tarjetas de Recarga
	$pdf->Ln(3);
	$pdf->SetFont('Helvetica','',11);
	$pdf->Cell(187, 10, "Tarjetas de Recarga", 0, 1, 'L');
	$pdf->SetFont('Helvetica','B',11);
	$pdf->Cell(30, 10, "Vendidos", 0, 0, 'C');
	$pdf->Cell(75, 10, "Modelo", 0, 0, 'C');
	$pdf->Cell(74, 10, "Monto de la Tarjeta", 0, 1, 'C');
	$pdf->SetFont('Helvetica','',11);
	while($ventasT = $resultadoT->fetch_assoc()) {
		$pdf->Cell(30, 10, $ventasT['total'], 0, 0, 'C');
		$pdf->Cell(75, 10, $ventasT['modelo'], 0, 0, 'C');
		$pdf->Cell(74, 10, "$" . $ventasT['montoTarjeta'], 0, 1, 'C');
	}
	$pdf->Output();

?>
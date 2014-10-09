<?php 
	session_start();

	include("../conex.php");

	if($_SERVER['SERVER_NAME'] == "homecel.net") {
		$imagen = "http://" . $_SERVER['SERVER_NAME'] . "/img/logo.png";
	} else {
		$imagen = "http://" . $_SERVER['SERVER_NAME'] . "/homecel/img/logo.png";
	}

	$idTienda = $_SESSION['idTienda'];

	if($_SESSION['idPerfil'] == 1) {
		$filtro = " AND a.idTienda IN (SELECT DISTINCT(idTienda) FROM hctienda) ";
	} else {
		$filtro = " AND a.idTienda = (SELECT idTienda FROM hcempleado WHERE idEmpleado = ". $_SESSION['idEmpleado'] .")";
	}

	$reporteEquipos = "SELECT COUNT(idArticulo) total, a.marca, a.modelo, a.precio
						FROM hcarticulo a
						WHERE a.`idTipoArt` IN (SELECT idtipoArt FROM hctipoart WHERE categoria = 'E')
						AND a.`existencia` = 0
						AND a.`idArticulo` NOT IN (SELECT idArticulo FROM hcapartado)
						AND a.idTienda = ".$idTienda."
						GROUP BY a.`marca`, a.`modelo`, a.precio
						ORDER BY 2, 3";

	$resultadoE = mysqli_query($con, $reporteEquipos);

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
	$pdf->Cell(187, 10, "Reporte de Ventas Detallado", 0, 1, 'L');
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
		$pdf->Cell(67, 10, $ventasE['marca'], 0, 0, 'L');
		$pdf->Cell(57, 10, $ventasE['modelo'], 0, 0, 'L');
		$pdf->Cell(25, 10, "$" . $ventasE['precio'], 0, 1, 'C');

		$consultaEquipo = "SELECT a.idArticulo, a.marca, a.modelo, a.imei, a.precio, a.color
							FROM hcarticulo a
							WHERE a.marca = '".$ventasE['marca']."' AND modelo = '".$ventasE['modelo']."' 
							AND a.`idTipoArt` IN (SELECT idtipoArt FROM hctipoart WHERE categoria = 'E')
							AND a.`existencia` = 0
							AND a.`idArticulo` NOT IN (SELECT idArticulo FROM hcapartado)
							AND a.idTienda = ".$idTienda."
							ORDER BY 1, 2;";
		$resEquipo = mysqli_query($con, $consultaEquipo);
		while($resE = $resEquipo->fetch_assoc()) {
			$pdf->Cell(30, 10, "", 0, 0, 'C');
			$pdf->Cell(67, 10, "Color: " . $resE['color'], 0, 0, 'L');
			$pdf->Cell(82, 10, "IMEI: " . preg_replace("/^(\d{6})(\d{2})(\d{6})(\d{1})$/", "$1-$2-$3-$4", $resE['imei']), 0, 1, 'L');
		}
		$pdf->Ln(7);
	}
	$pdf->Output();

?>
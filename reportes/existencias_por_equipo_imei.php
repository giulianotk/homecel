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

	$existencias = "SELECT a.`marca` a, a.`modelo` b, a.`IMEI` c, a.precio d, a.color e
					FROM hcarticulo a
					WHERE a.`idTipoArt` IN (SELECT idtipoArt FROM hctipoart WHERE categoria = 'E')
					AND a.`existencia` = 1
					AND a.`IMEI` IS NOT NULL"
					.$filtro.
					"ORDER BY 1, 2, 3;";

	$resultado = mysqli_query($con, $existencias);

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
	$pdf->Cell(187, 10, "Existencias por Equipo", 0, 1, 'L');
	$pdf->SetFont('Helvetica','B',11);
	$pdf->Cell(40, 10, "Marca", 0, 0, 'L');
	$pdf->Cell(40, 10, "Modelo", 0, 0, 'L');
	$pdf->Cell(40, 10, "Color", 0, 0, 'C');
	$pdf->Cell(40, 10, "IMEI", 0, 0, 'C');
	$pdf->Cell(27, 10, "Precio", 0, 1, 'C');
	$pdf->SetFont('Helvetica','',11);
	while($inventario = $resultado->fetch_assoc()) {
		$pdf->Cell(40, 10, $inventario['a'], 0, 0, 'L');
		$pdf->Cell(40, 10, $inventario['b'], 0, 0, 'L');
		$pdf->Cell(40, 10, $inventario['e'], 0, 0, 'C');
		$pdf->Cell(40, 10, preg_replace("/^(\d{6})(\d{2})(\d{6})(\d{1})$/", "$1-$2-$3-$4", $inventario['c']), 0, 0, 'C');
		$pdf->Cell(27, 10, "$" . $inventario['d'], 0, 1, 'C');
	}
	$pdf->Output();

?>
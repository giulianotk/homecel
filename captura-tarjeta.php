<?php 
	if (isset($_POST['codigo'])) {
		$idTienda=$_SESSION['idTienda'];

		$codigo = $_POST['codigo'];

		$marca = "";
		$modelo = "Tarjeta de Recarga";
		$color = "";

		$folioTarjeta = $_POST['folioTarjeta'];

		$folioFactura = $_POST['folio'];
		$tipo = "11";
		$diseno = "";

		$garantia = "";
		$proveedor = "";
		$precio = "";

		$monto = $_POST['montoTarjeta'];

		$imagen = "temporal";
		$existencia = "1";		

		$cantidad = $_POST['cantidad'];

		$i=0;
		
		while ($i<$cantidad) {
			$insertar = "INSERT INTO 
						hcarticulo (idTienda, modelo, codigo, folioTarjeta, folioFactura, idTipoArt, garantia, montoTarjeta, existencia, precio) 
						VALUES
						(".$idTienda.", '".$modelo."', '".$codigo."',  '".$folioTarjeta."', '".$folioFactura."', '".$tipo."', '0', ".$monto.", ".$existencia.", ".$monto.")";
			mysqli_query($con, $insertar);
			$i++;
		}
	}

 ?>
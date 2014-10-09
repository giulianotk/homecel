<?php 
	if (isset($_POST['codigo'])) {
		$idTienda=$_SESSION['idTienda'];

		$codigo = $_POST['codigo'];

		$marca = "";
		$modelo = $_POST['modelo'];
		$color = "";

		$folioFactura = $_POST['folio'];
		$tipo = "10";
		$diseno = "";

		$garantia = "";
		$proveedor = $_POST['proveedor'];
		$precio = $_POST['precio'];

		$monto = $_POST['montoTarjeta'];

		$imagen = "temporal";
		$existencia = "1";		

		$cantidad = $_POST['cantidad'];

		$i=0;
		
		while ($i<$cantidad) {
			$insertar = "INSERT INTO 
						hcarticulo (idTienda, IMEI, marca, modelo, color, folioFactura, idTipoArt, diseno, garantia, proveedorT, precio, imagen, existencia, montoTarjeta) 
						VALUES
						(".$idTienda.", '".$codigo."', '".$marca."', '".$modelo."', '".$color."', '".$folioFactura."', '".$tipo."', '".$diseno."', '0', '".$proveedor."', ".$precio.", '".$imagen."', ".$existencia.", '".$monto."')";
			mysqli_query($con, $insertar);
			$i++;
		}
	}

 ?>
<?php 
	if (isset($_POST['folio'])) {
		$idTienda=$_SESSION['idTienda'];

		$IMEI = $_POST['codigo'];

		$marca = utf8_decode($_POST['marca']);
		$modelo = utf8_decode($_POST['modelo']);
		$color = utf8_decode($_POST['color']);

		$folioFactura = $_POST['folio'];
		$tipo = $_POST['tipo'];
		$diseno = utf8_decode($_POST['diseno']);

		$garantia = $_POST['garantia'];
		$proveedor = utf8_decode($_POST['proveedor']);
		$precio = $_POST['precio'];

		$imagen = "temporal";
		$existencia = "1";		

		$cantidad = $_POST['cantidad'];

		if(($_FILES["imagen"]["size"] < 500000) && ($_FILES["imagen"]["size"] > 0))
	    {
	        if ($_FILES["imagen"]["error"] > 0)
	        {
	            echo "Return Code: " . $_FILES["imagen"]["error"] . "<br />";
	        }
	        else
	        {                
	            move_uploaded_file($_FILES["imagen"]["tmp_name"], "img/" . $_FILES["imagen"]["name"]);
	            $img = "http://localhost/homecel/img/" . $_FILES["imagen"]["name"];             
	        }

	    	$imagen = $img;            
	    }	

	    // SI ES IGUAL A NADA, ES UN ARTICULO
	    if ($IMEI == "") {

	    	$i=0;
		
			while ($i<$cantidad) {
			$insertar = "INSERT INTO 
						hcarticulo (idTienda, marca, modelo, color, folioFactura, idTipoArt, diseno, garantia, proveedorT, precio, imagen, existencia) 
						VALUES
						(".$idTienda.", '".$marca."', '".$modelo."', '".$color."', '".$folioFactura."', '".$tipo."', '".$diseno."', '".$garantia."', '".$proveedor."', ".$precio.", '".$imagen."', ".$existencia.")";
			mysqli_query($con, $insertar);
			$i++;
			}	
		}else{

			$insertar = "INSERT INTO 
						hcarticulo (idTienda, marca, modelo, color, folioFactura, idTipoArt, diseno, garantia, proveedorT, precio, imagen, existencia, IMEI) 
						VALUES
						(".$idTienda.", '".$marca."', '".$modelo."', '".$color."', '".$folioFactura."', '".$tipo."', '".$diseno."', '".$garantia."', '".$proveedor."', ".$precio.", '".$imagen."', ".$existencia.", '".$IMEI."')";
			mysqli_query($con, $insertar);

		}
	    			
	}

 ?>
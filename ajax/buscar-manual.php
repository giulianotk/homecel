<?php 

session_start();

include '../conex.php';

$idTienda = $_SESSION['idTienda'];

$desc = strtolower($_GET['desc']);

if (strlen($desc)<2) {

	

	}else{

		$buscar = "SELECT * FROM hcarticulo 
		WHERE (lower(marca) like '%".$desc."%' OR IMEI like '".$desc."' OR lower(modelo) like '%".$desc."%' OR lower(diseno) like '%".$desc."%') 
		AND existencia = 1
		AND idTienda = ".$idTienda."
		ORDER BY 2, 1";
	
		$resultado = mysqli_query($con, $buscar);

		$existe = "SELECT count(*) AS ex FROM hcarticulo 
		WHERE (lower(marca) like '%".$desc."%' OR IMEI like '".$desc."' OR lower(modelo) like '%".$desc."%' OR lower(diseno) like '%".$desc."%') 
		AND existencia = 1
		";

		$resExiste = mysqli_query($con, $existe);

		$rE = $resExiste -> fetch_assoc();

		?>

		<table>
		<tr>
			<th>Modelo</th>
			<th>Marca</th>
			<th>Color</th>
			<th>Precio</th>
			<th>IMEI</th>
			<th></th>
		</tr>

		<?php

		if ($rE['ex']==0) {
			?>
			<tr>
				<td style="text-align:center" colspan="5">No hay coincidencias, busca nuevamente.</td>
			</tr>
			<?php
		}

		$inter = "";

		while($r = $resultado->fetch_assoc()){

			$imei = $r['IMEI'];
			$imei_guiones = preg_replace("/^(\d{6})(\d{2})(\d{6})(\d{1})$/", "$1-$2-$3-$4", $imei);

		?>

			<tr class="<?php echo $inter; ?>">
				<td><?php echo $r['modelo']; ?> </td>
				<td><?php echo $r['marca']; ?></td>
				<td><?php echo $r['color']; ?></td>
				<td>$<?php echo $r['precio']; ?> </td>
				<td><?php if ($r['IMEI']!="") {echo $imei_guiones; } else{ echo "NA";}  ?> </td>
				
				<td><button class="boton-azul" onclick="agregarManual('<?php echo $r['idArticulo']; ?>')">Agregar</button></td>
			</tr>
<?php 

	if ($inter == "") {
		$inter = "inter";
	}else{
		$inter = "";
	}
	}

	?>

	</table>

	<?php
}
?>

<?php 

session_start();

include '../conex.php';

$desc = strtolower($_GET['desc']);

$idTienda = $_SESSION['idTienda'];

if (strlen($desc)<2) {

	

	}else{

		$existe = "SELECT count(*) AS ex FROM hcarticulo 
		WHERE (lower(marca) like '%".$desc."%' OR codigo like '%".$desc."%' OR lower(modelo) like '%".$desc."%' OR lower(diseno) like '%".$desc."%') 
		AND existencia = 1
		AND idTienda = ".$idTienda." ";
		$resExiste = mysqli_query($con, $existe);

		$rE = $resExiste -> fetch_assoc();
		
		$buscar = "SELECT * FROM hcarticulo 
		WHERE (lower(marca) like '%".$desc."%' OR codigo like '%".$desc."%' OR lower(modelo) like '%".$desc."%' OR lower(idTipoArt) like '%".$desc."%' OR lower(diseno) like '%".$desc."%') 
		AND existencia = 1
		AND idTienda = ".$idTienda."";
	
		$resultado = mysqli_query($con, $buscar);

		?>

		<table>
		<tr>
			<th colspan="6">Resultados de la busqueda</th>
		</tr>

		<tr class="<?php echo $inter; ?>">
			<th>Marca</th>
			<th>Modelo</th>			
			<th>IMEI</th>
			<th>Color</th>
			<th colspan="2">Precio</th>
			
		</tr>

		<?php

		if ($rE['ex']==0) {
			?>
			<tr>
				<td style="text-align:center" colspan="6">No hay coincidencias, busca nuevamente.</td>
			</tr>
			<?php
			}
		
		$inter = "";

		while($r = $resultado->fetch_assoc()){

		?>

			<tr class="<?php echo $inter; ?>">
				<td><?php echo $r['modelo']; ?> </td>
				<td><?php echo $r['marca']; ?></td>
				<td><?php echo $r['IMEI']; ?>s</td>
				<td><?php echo $r['color']; ?></td>
				<td>$<?php echo $r['precio']; ?> </td>
				<td><button type="button" class="boton-azul" onclick="agregarApartado('<?php echo $r['idArticulo']; ?>')">Agregar</button></td>
				
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

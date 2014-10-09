<?php 

session_start();

include '../conex.php';

$desc = strtolower($_GET['desc']);

if (strlen($desc)<2) {

	

	}else{

		$buscar = "SELECT a.idArticulo, a.marca, a.modelo, a.color, t.tipoArt, a.precio, a.IMEI, a.diseno
			FROM hcarticulo a, hctipoart t
			WHERE a.idTipoArt = t.idTipoArt
			AND (lower(marca) like '%".$desc."%' OR lower(modelo) like '%".$desc."%' OR lower(diseno) like '%".$desc."%' OR IMEI like '%".$desc."%') 
			AND existencia = 1 
			UNION 
			SELECT a.idArticulo, a.marca, a.modelo, a.color, t.tipoArt, a.precio, a.imei, a.diseno
			FROM hcarticulo a, hctipoart t
			WHERE a.idTipoArt = t.idTipoArt
			AND a.idTipoArt in (SELECT idTipoArt FROM hctipoart WHERE LOWER(tipoArt) like '%".$desc."%') 
			AND existencia = 1 
			 
			ORDER BY 5, 2, 3";
	
		$resultado = mysqli_query($con, $buscar);

		$existe ="SELECT count(a.idArticulo) AS ex
			FROM hcarticulo a, hctipoart t
			WHERE a.idTipoArt = t.idTipoArt
			AND (lower(marca) like '%".$desc."%' OR lower(modelo) like '%".$desc."%' OR lower(diseno) like '%".$desc."%' OR IMEI like '%".$desc."%') 
			AND existencia = 1";

		$existe2 = "SELECT count(a.idArticulo) AS ex2
			FROM hcarticulo a, hctipoart t
			WHERE a.idTipoArt = t.idTipoArt
			AND a.idTipoArt in (SELECT idTipoArt FROM hctipoart WHERE LOWER(tipoArt) like '%".$desc."%') 
			AND existencia = 1";

		$resExiste = mysqli_query($con, $existe);

		$rE = $resExiste -> fetch_assoc();

		$resExiste2 = mysqli_query($con, $existe2);

		$rE2 = $resExiste2 -> fetch_assoc();

		?>

		<table>
		<tr>
			<th>Marca</th>
			<th>Modelo</th>
			<th>Color</th>
			<th>Tipo</th>
			<th>Diseño</th>
			<th>Precio</th>
			<th>IMEI</th>
			<th></th>
		</tr>

		<?php

		if ($rE['ex']==0 && $rE2['ex2']==0) {
			?>
			<tr>
				<td style="text-align:center" colspan="6">No hay coincidencias, busca nuevamente.</td>
			</tr>
			<?php
		}

		$inter = "";

		while($r = $resultado->fetch_assoc()){

			$imei = $r['IMEI'];
			$imei_guiones = preg_replace("/^(\d{6})(\d{2})(\d{6})(\d{1})$/", "$1-$2-$3-$4", $imei);

		?>

			<tr class="<?php echo $inter; ?>">
				<td><?php echo utf8_encode($r['modelo']); ?> </td>
				<td><?php echo utf8_encode($r['marca']); ?></td>
				<td><?php echo utf8_encode($r['color']); ?></td>
				<td><?php echo utf8_encode($r['tipoArt']); ?></td>
				<td><?php echo utf8_encode($r['diseno']); ?></td>
				<td>$<?php echo $r['precio']; ?> </td>
				<td><?php if ($r['IMEI']!="") {echo $imei_guiones; } else{ echo "NA";}  ?> </td>
				
				<td><button class="boton-azul" onclick="darBaja('<?php echo $r['idArticulo']; ?>')">Dar de Baja</button></td>
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

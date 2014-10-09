<?php 

session_start();

include '../conex.php';

$idArticulo = $_GET['id'];

$_SESSION['carritoApartado'].=$idArticulo."_";

$buscar = "SELECT * FROM hcarticulo WHERE idArticulo = '".$idArticulo."'";
	
$resultado = mysqli_query($con, $buscar);

$r = $resultado->fetch_assoc();

$cambioExistencia = "UPDATE hcarticulo set existencia = 0 WHERE idArticulo = ".$idArticulo;
mysqli_query($con, $cambioExistencia);

$imei = $r['IMEI'];
$imei_guiones = preg_replace("/^(\d{6})(\d{2})(\d{6})(\d{1})$/", "$1-$2-$3-$4", $imei);

?>
	<tr>
		<td><?php echo $r['marca']; ?></td>
		<td><?php echo $r['modelo']; ?></td>
		<td><?php echo $imei; ?></td>
		<td><?php echo $r['color']; ?></td>
		<td><?php echo $r['precio']; ?></td>
		<input type="hidden" value="<?php echo $r['idArticulo']; ?>" name="idA">
	</tr>
<?php 

session_start();

include 'conex.php';

$idArticulo = $_GET['id'];

$_SESSION['carrito'].=$idArticulo."_";

$buscar = "SELECT * FROM hcarticulo WHERE idArticulo = '".$idArticulo."'";
	
$resultado = mysqli_query($con, $buscar);

$r = $resultado->fetch_assoc();

$precioActual = $r['precio'];

if (!isset($_SESSION['precioTotal'])) {
	$_SESSION['precioTotal']=$precioActual;
}else{
	$_SESSION['precioTotal']+=$precioActual;
}

$cambioExistencia = "UPDATE hcarticulo set existencia = 0 WHERE idArticulo = ".$idArticulo;
mysqli_query($con, $cambioExistencia);

$imei = $r['IMEI'];
$imei_guiones = preg_replace("/^(\d{6})(\d{2})(\d{6})(\d{1})$/", "$1-$2-$3-$4", $imei);

?>


	<tr id="<?php echo $idArticulo; ?>">
		<td class="nombre">
			<b><?php echo $r['modelo']; ?> <?php echo $r['marca']; ?></b><br>
			<b>IMEI: </b><?php echo $imei_guiones; ?><br>
			<b>CHIP: </b><?php echo $r['SIM'];; ?><br>
		</td>
		<td class="precio">$<?php echo $r['precio']; ?> </td>
		<td><button class="quitar" onclick="quitar('<?php echo $idArticulo; ?>')">X</button></td>
		</tr>
			
<?php $_SESSION['totalDefinitivo'] = $_SESSION['precioTotal'] ?>


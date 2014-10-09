<?php 

session_start();

include '../conex.php';

$codBar = $_GET['codBar'];

if ($codBar != "") {


	$buscar = "SELECT COUNT(*) existe FROM hcarticulo WHERE codigo = '".$codBar."'";

	$resultado = mysqli_query($con, $buscar);

	$r = $resultado->fetch_assoc();

	if ($r['existe']==0) {	

	?>
		
		<tr>
			<td class="nombre"><b class="error">Error, el producto no está registrado.</b></td>
			<td class="precio"></td>
		</tr>

	<?php 
		

	}else{

		$buscar = "SELECT * FROM hcarticulo WHERE codigo = '".$codBar."' AND existencia = 1" ;
	
		$resultado = mysqli_query($con, $buscar);

		$r = $resultado->fetch_assoc();

		$precioActual = $r['precio'];

		if (!isset($_SESSION['precioTotal'])) {
			$_SESSION['precioTotal']=$precioActual;
		}
		else{
			$_SESSION['precioTotal']+=$precioActual;
		}

		?>

			<tr>
				<td class="nombre">
					<b><?php echo $r['modelo']; ?> <?php echo $r['marca']; ?></b><br>
					<b>IMEI: </b><?php echo $r['IMEI'];; ?><br>
					<b>CHIP: </b><?php echo $r['SIM'];; ?><br>
				</td>
				<td class="precio">$<?php echo $r['precio']; ?> </td>
			</tr>
			
			<?php $_SESSION['totalDefinitivo'] = $_SESSION['precioTotal'] ?>
			

<?php 
	}
}
?>

<?php 
	session_start();
	if(isset($_SESSION['usuario'])) {	
		$_SESSION['precioTotal']=0;
		$_SESSION['carrito']="";
		include 'conex.php';
?>


<!DOCTYPE html>
<html>
<head>
	<title>Homecel - Ventas</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/javascript.js"></script>
<script type="text/javascript" src="shortcut.js"></script>
</head>
<body onunload="gariet()">

<script>
    window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
</script>



<?php include 'menu.php'; ?>

<section>
	<h1 class="bienvenido">Bienvenido</h1>
	<input type="text" placeholder="IMEI O DESCRIPCIÓN" autofocus onkeyup="buscar()" id="codigo" class="codigo" autocomplete="off"><br>

	<div id="respuesta-busqueda"></div>

</section>

<aside>
<h1>Ticket</h1>

	
	<table class="ticket-producto">
		<tr>
			<th class="nombre">Nombre</th>
			<th class="precio">Precio</th>
		</tr>
	</table>
	
	<div id="ticket">
		<table id="ticket-contenido" class="ticket-producto-agregado">
			
		</table>		
	</div>

	<table class="ticket-producto-total">
			<tr>
				<!-- <th class="nombre">SUBTOTAL:</th> -->
				<th class="nombre">SUBTOTAL:</th>

				<th class="precio" id="total" style="text-align:right">$0</th>
			</tr>
	</table>
	
	<div id="controles">
		
		<div id="dickbutt">
			<button onclick="comprar()" class="comprar disabled" disabled>Comprar</button>	
			<button onclick="borrar()" class="borrar">Borrar Todo</button>
			<a href="corte.php" class="comprar" target="_new">Corte</a>
		</div>
		

	</div>

</aside>

<div id="overlay"></div>

<div id="compra">
	<h1>Resumen de Compra</h1>
	<table>
		<tr>
			<td>Subtotal:</td>
			<td class="precio-resumen">$<input type="text" id="subtotal-resumen" disabled></td>
		</tr>
		<tr>
			<td>I.V.A.:</td>
			<td class="precio-resumen">$<input type="text" id="iva-resumen" disabled></td>
		</tr>

		<tr>
			<td>Comisión <sub>(2.5%)</sub>:</td>
			<td class="precio-resumen">$<input type="text" id="comision" disabled value="0"></td>
		</tr>

		<tr>
			<td>Total:</td>
			<td class="precio-resumen">$<input type="text" id="total-resumen" disabled></td>
		</tr>
		<tr>
			<td>Recibido:</td>
			<td class="precio-resumen">$<input onkeyup="calcularCambio()" id="recibido" type="text" placeholder=""></td>
		</tr>
		<tr>
			<td>Cambio:</td>
			<td class="precio-resumen">$<input type="text" id="cambio" disabled value="0.00"></td>
		</tr>
		

		<tr>
			<td>Cliente:</td>
			<td class="precio-resumen">
				<select name="cliente" id="cliente">
					<?php 
						$clientes = "SELECT * FROM hccliente";
						$res = mysqli_query($con, $clientes);
						

						while ($r = mysqli_fetch_array($res)) {
					?>
						<option value="<?php echo $r['idCliente']; ?>"> <?php echo $r['nombre']; ?> - 
						<?php echo $r['direccion']; ?> <?php echo $r['ciudad']; ?>, <?php echo $r['estado']; ?>  </option>
					<?php
						}
					?>
				</select>
			</td>
		</tr>

		<tr>
			<td>Forma de Pago:</td>
			<td class="precio-resumen">
				<select id="formaPago" onchange="calcularComision()">
					<option value="1">Efectivo</option>
					<option value="2">Tarjeta</option>
				</select>
			</td>
		</tr>

		<tr>
			<td colspan="2" class="separador"></td>
		</tr>

		<tr>
			<td></td>
			<td class="precio-resumen">
				<button class="comprar chico" onclick="terminarCompra()" id="comprar">Comprar</button>
				<button class="comprar chico" onclick="cerrarTodo()" id="finalizar">Salir</button>
				<button class="comprar chico" onclick="cerrar()" id="salir">Salir</button>
			</td>
		</tr>

		<tr>
			<td colspan="2" style="text-align:center" id="respuesta-compra">
				
			</td>
		</tr>
	</table>
</div>

</body>
</html>

<?php } else { ?>
	<meta http-equiv="refresh" content="0; url=index.php">
<?php } ?>
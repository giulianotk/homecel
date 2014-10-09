<?php 
	include '../conex.php';
	$contadorIMEI ="SELECT count(*) AS cant FROM hcarticulo WHERE IMEI is null AND (idTipoArt=1 OR idTipoArt =2 OR idTipoArt =3)";
	$res = mysqli_query($con, $contadorIMEI);
	$r = $res -> fetch_assoc();
	echo $r['cant'];
 ?>
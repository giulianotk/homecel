// FUNCION BORRAR TODO
function borrar () {
	buscarAjax = new XMLHttpRequest();
	buscarAjax.onreadystatechange = function(){
		if (buscarAjax.readyState==4) {
		document.getElementById('ticket-contenido').innerHTML=buscarAjax.responseText;
		document.getElementById('total').innerHTML="$0";
		window.location.assign("ventas.php?a=v")
		};
	}	
	buscarAjax.open('GET','ajax/borrar.php',true);
	buscarAjax.send();
}

//FUNCION BUSCAR EN VENTA

function buscar () {		
	busqueda=document.getElementById('codigo').value;
	manualAjax = new XMLHttpRequest();
	manualAjax.onreadystatechange=function(){
		if (manualAjax.readyState==4) {
			document.getElementById('respuesta-busqueda').innerHTML=manualAjax.responseText;
			
		};
	}
	manualAjax.open('GET','ajax/buscar-manual.php?desc='+busqueda,true);
	manualAjax.send();		
}

//AGREGAR MANUALMENTE AL TICKET

function agregarManual(idArticulo){
	// alert(idArticulo);
	document.getElementById('codigo').focus();
	agregarAjax = new XMLHttpRequest();
	document.getElementById('dickbutt').innerHTML = "<button onclick='comprar()'' class='comprar'>Comprar</button> 	<button onclick='borrar()' class='borrar'>Borrar Todo</button>";
	agregarAjax.onreadystatechange=function(){
		if (agregarAjax.readyState==4) {
			document.getElementById('ticket-contenido').innerHTML+=agregarAjax.responseText;
			document.getElementById('codigo').value="";

			document.getElementById('respuesta-busqueda').innerHTML="";
			//ACUTALIZAR EL TOTAL
			totalAjax = new XMLHttpRequest();
			totalAjax.onreadystatechange = function(){
				if (totalAjax.readyState==4) {
					totalTicket = totalAjax.responseText;
					// tt = totalTicket.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
					document.getElementById('total').innerHTML="$" + totalTicket;
				};
			}	
			totalAjax.open('GET','ajax/total.php',true);
			totalAjax.send();
		};
	};
	agregarAjax.open('GET', 'ajax/agregar-manual.php?id='+idArticulo, true);
	agregarAjax.send();
}

//FUNCION BUSCAR EN APARTADO

function buscarApartado() {		
	busqueda=document.getElementById('codigo').value;
	manualAjax = new XMLHttpRequest();
	manualAjax.onreadystatechange=function(){
		if (manualAjax.readyState==4) {
			document.getElementById('respuesta-busqueda').innerHTML=manualAjax.responseText;			
		};
	}
	manualAjax.open('GET','ajax/buscar-apartado.php?desc='+busqueda,true);
	manualAjax.send();		
}


//AGREGAR PRODUCTO A APARTADO 

function agregarApartado(idArticulo){
	// alert(idArticulo);
	// document.getElementById('codigo').focus()S;
	agregarAjax = new XMLHttpRequest();
	agregarAjax.onreadystatechange=function(){
		if (agregarAjax.readyState==4) {
			document.getElementById('apartado-tabla').innerHTML+=agregarAjax.responseText;
			document.getElementById('codigo').value="";
			// alert(agregarAjax.responseText);
			document.getElementById('respuesta-busqueda').innerHTML="";
			};
	};
	agregarAjax.open('GET', 'ajax/agregar-apartado.php?id='+idArticulo, true);
	agregarAjax.send();
}

//FINALIZAR APARTADO

function apartar(){

	var cliente = document.getElementById("cliente");
	var c = cliente.options[cliente.selectedIndex].value;
	apartarAjax = new XMLHttpRequest();
	apartarAjax.onreadystatechange=function(){
		if (apartarAjax.readyState == 4) {
			// document.getElementById('respuesta-busqueda').innerHTML=apartarAjax.responseText; 
			window.location.assign('apartado.php?a=a')
		};
	}
	apartarAjax.open('GET', 'ajax/apartar.php?c='+c, true);
	apartarAjax.send();


}

//CONTADOR DE TELEFONOS SIN IMEI

function contadorIMEI(){
	imei = new XMLHttpRequest();
	imei.onreadystatechange=function(){
		if (imei.readyState==4) {
			document.getElementById('no-imei').innerHTML=imei.responseText;
		};
	}
	imei.open('GET', 'ajax/contadorIMEI.php', true);
	imei.send();
}

//QUITAR DEL TICKET DE COMPRA

function quitar(idQuitar){
	var idQuitar = idQuitar;
	quitarAjax = new XMLHttpRequest();
	quitarAjax.onreadystatechange=function(){
		if (quitarAjax.readyState==4) {
			document.getElementById(idQuitar).style.display="none";
			// alert('quitado');
			//ACUTALIZAR EL TOTAL
			totalAjax = new XMLHttpRequest();
			totalAjax.onreadystatechange = function(){
				if (totalAjax.readyState==4) {
					document.getElementById('total').innerHTML=totalAjax.responseText;
				};
			}	
			totalAjax.open('GET','ajax/total.php',true);
			totalAjax.send();
		};
	}
	quitarAjax.open('GET', 'ajax/quitar.php?idQuitar='+idQuitar, true);
	quitarAjax.send();
}

//CAPTURA DE IMEI A TELEFONOS SIN IMEI

function capturarImei(idArticulo){
	imei = document.getElementById('imei-'+idArticulo).value;
	chip = document.getElementById('chip-'+idArticulo).value;

	capturarImeiAjax = new XMLHttpRequest();
	capturarImeiAjax.onreadystatechange=function(){
		if (capturarImeiAjax.readyState==4) {
			// alert(capturarImeiAjax.responseText);
			window.location.assign("agregar-imei.php?a=i")
		}
	}

	capturarImeiAjax.open('GET', 'ajax/capturar-imei.php?imei='+imei+'&chip='+chip+'&idArticulo='+idArticulo, true);
	capturarImeiAjax.send();
}


//COMPRAR

function comprar(){
	document.getElementById('overlay').style.display="block";
	document.getElementById('compra').style.display="block";	
	totalResumen = new XMLHttpRequest();
	totalResumen.onreadystatechange=function(){
		if (totalResumen.readyState==4) {
			total = totalResumen.responseText;
			//TOTAL
			t = parseInt(total);

			//SIN IBA (SUBTOTAL)
			subtotal = t / 1.16;

			//IVA
			iva = subtotal * .16;
			ivaT = Math.floor(iva * 100) / 100;
			
			//IMPRIMIR
			document.getElementById('subtotal-resumen').value=subtotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
			document.getElementById('total-resumen').value = t.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
			document.getElementById('iva-resumen').value = ivaT.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
		};
	}
	totalResumen.open('GET', 'ajax/total.php', true);
	totalResumen.send();
}

//CALCULAR CAMBIO

function calcularCambio(){
	recibido = document.getElementById('recibido').value;
	
	cambio = recibido-total;

	document.getElementById('cambio').value = "$"+cambio.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

}

//
function calcularComision(){

	var formaPago = document.getElementById("formaPago");
	var fp = formaPago.options[formaPago.selectedIndex].value;

	if (fp == 1) {		
		comision = 0;		
	};

	if (fp == 2) {		
		comision = total*.025;		
	};

	document.getElementById('comision').value = comision.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
	document.getElementById('total-resumen').value = (parseFloat(total) + parseFloat(comision)).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');;

}

//terminar compra, insertar en ticket

function terminarCompra(){

	var cliente = document.getElementById("cliente");
	var c = cliente.options[cliente.selectedIndex].value;
	var formaPago = document.getElementById("formaPago");
	var fp = formaPago.options[formaPago.selectedIndex].value;
	// var iva = document.getElementById('iva-resumen').value;
	var total = document.getElementById('total-resumen').value;
	// alert(total)

	compra = new XMLHttpRequest();
	compra.onreadystatechange = function(){
		if (compra.readyState == 4) {
			document.getElementById('respuesta-compra').innerHTML=compra.responseText;
			document.getElementById('comprar').style.display="none";
			document.getElementById('salir').style.display="none";
			document.getElementById('finalizar').style.display="block";
		};
	}
	compra.open('GET', 'ajax/comprar.php?c='+c+'&fp='+fp+'&iva='+ivaT+'&total='+total, true);
	compra.send();

}

//CERRAR RESUMEN DE VENTA

function cerrar(){
	document.getElementById('overlay').style.display="none";
	document.getElementById('compra').style.display="none";
	// window.location.assign('ventas.php');
}

function cerrarTodo(){
	document.getElementById('overlay').style.display="none";
	document.getElementById('compra').style.display="none";
	window.location.assign('ventas.php?a=v');
}

//FUNCION BUSCAR EN INVENTARIO

function buscarInventario () {		
	busqueda=document.getElementById('codigo-inventario').value;
	busquedaInventario = new XMLHttpRequest();
	busquedaInventario.onreadystatechange=function(){
		if (busquedaInventario.readyState==4) {
			document.getElementById('busqueda-inventario').innerHTML=busquedaInventario.responseText;
			
		};
	}
	busquedaInventario.open('GET','ajax/buscar-inventario.php?desc='+busqueda,true);
	busquedaInventario.send();		
}

//CAPTURA DE ABONADO
function capturarAbono(idApartado) {
	abono = document.getElementById('cantidadAbono-' + idApartado).value;
	// alert(abono);
	abonoAjax = new XMLHttpRequest();
	abonoAjax.onreadystatechange = function(){
		if(abonoAjax.readyState == 4) {
			window.location.assign('ver-apartados.php?a=a');
		}
	}
	abonoAjax.open('GET', 'ajax/capturar-abono.php?cantidadAbono=' + abono + '&idApartado=' + idApartado, true);
	abonoAjax.send();
}

//ELIMINAR CLIENTE:

function eliminarCliente(idCliente) {
	eliminarClienteAjax = new XMLHttpRequest();
	eliminarClienteAjax.onreadystatechange = function(){
		if(eliminarClienteAjax.readyState == 4) {
			window.location.assign('ver-clientes.php?a=a');
		}
	}
	eliminarClienteAjax.open('GET', 'ajax/eliminar-cliente.php?idCliente=' + idCliente, true);
	eliminarClienteAjax.send();
}

function editarCliente(idCliente) {
	editarClienteAjax = new XMLHttpRequest();
	// editarClienteAjax.onreadystatechange = function(){
	// 	if(editarClienteAjax.readyState == 4) {
	// 		window.location.assign('ver-clientes.php?a=a');
	// 	}
	// }
	// editarClienteAjax.open('GET', 'ajax/editar-cliente.php?idCliente=' + idCliente, true);
	// editarClienteAjax.send();
	var att=document.createAttribute("contenteditable");
	// att.value="democlass";
	document.getElementById("nombre-"+idCliente)[0].setAttributeNode(att);
}

//RELOJ FUNCIONAL

window.addEventListener('load', reloj, false);


function reloj()
{
    setTimeout("reloj()", 1000);        
    fecha = new Date();
    if (fecha.getMinutes()<10) {
    	minutos = '0'+fecha.getMinutes();
    }else{
    	minutos = fecha.getMinutes();
    }

    if (fecha.getSeconds()<10) {
    	segundos = '0'+fecha.getSeconds();
    }else{
    	segundos = fecha.getSeconds();
    }

    if (fecha.getMonth()<10) {
    	mes = '0'+fecha.getMonth();
    }else{
    	mes = fecha.getMonth();
    }

    tiempoDisplay = fecha.getDate()+"/"+mes+"/"+fecha.getFullYear()+" - "+fecha.getHours() +':'+ minutos +':'+ segundos;
    document.getElementById('hora').innerHTML = tiempoDisplay;

}


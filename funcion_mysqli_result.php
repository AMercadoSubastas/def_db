<?php
// Inicia la sesión aquí antes de enviar cualquier salida
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Verifica si ya existe una sesión iniciada
if(isset($_SESSION['id'])){
  // La sesión ya está iniciada, puedes realizar otras acciones si es necesario.
} else {
  // La sesión no está iniciada, redirige al usuario a la página de inicio de sesión.
  header('Location: login');
  exit; // Termina la ejecución del script después de la redirección.
}
?>


<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" type="text/css" href="customs_css/customs.css">
<script language="javascript" src="cal2.js"></script>
<script language="javascript" src="cal_conf2.js"></script>
<script src="funcion_mysqli_result.js"></script>
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema interno</title>
<?php

function mysqli_result($res,$row=0,$col=0){
    $numrows = mysqli_num_rows($res);
    if ($numrows && $row <= ($numrows-1) && $row >=0){
        mysqli_data_seek($res,$row);
        $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
        if (isset($resrow[$col])){
            return $resrow[$col];
        }
    }
    return false;
}

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = addslashes($theValue);
  switch ($theType) {
	case "text":
	  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
	  break;    
	case "long":
	case "int":
	  $theValue = ($theValue != "") ? intval($theValue) : "NULL";
	  break;
	case "double":
	  $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
	  break;
	case "date":
	  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
	  break;
	case "defined":
	  $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
	  break;
  }
  return $theValue;
}

function validoUsu($codUsuario, $amercado) {

  $valido = sprintf("SELECT * FROM usuarios where codnum = $codUsuario");
  $consulta = mysqli_query($amercado, $valido);

  if ($consulta && mysqli_num_rows($consulta) > 0) {
    // Si la consulta devuelve filas, el usuario es válido.
    return true;
  }
  return false; 
  
}
?>
<script>
function alertaError(informe){
  
  Swal.fire({
			icon: "Error",
			title: "Oops...",
			text: informe,
			footer: '<a href="https://amtickets.adrianmercado.com.ar" target="_blank" rel="noopener noreferrer">Mandanos un ticket</a>'
		  });

}


function alertaConfirmado(informe) {
	 Swal.fire({
			icon: "Enviado",
			title: "Muy bien!",
			text: informe,
			footer: '<a href="https://amtickets.adrianmercado.com.ar" target="_blank" rel="noopener noreferrer">Mandanos un ticket</a>'
		  });
}

function preguntame(form){
  // Previene el envío automático del formulario
  event.preventDefault();

  // Referencia al formulario, reemplaza 'form' con el ID o la clase de tu formulario
  var form = document.querySelector('form');

  Swal.fire({
    title: "Estas seguro de enviar?",
    text: "No pódes revertir una vez enviado!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, re seguro"
  }).then((result) => {
    if (result.isConfirmed) {

      // Envía el formulario manualmente aquí
      form.submit();
    }
  });

}





function footerSupport (){

	document.addEventListener('DOMContentLoaded', function() {
    // Crear elementos
    var footer = document.createElement('div');
    var opciones = document.createElement('div');
    var opcion1 = document.createElement('a');
    var opcion2 = document.createElement('a');
    var opcion3 = document.createElement('a');

    // Establecer contenido y atributos
    opcion1.textContent = 'Ricardito';
    opcion2.textContent = 'Dieguito';
    opcion3.textContent = 'Luchito';
    opcion1.href = '#opcion1';
    opcion2.href = '#opcion2';
    opcion3.href = '#opcion3';

    // Estilos del footer
    footer.style.position = 'fixed';
    footer.style.rigth = '0';
    footer.style.bottom = '0';
    footer.style.backgroundImage = "url('monoenfermo_n.jpg')";
	footer.style.backgroundSize = "100%";
	footer.style.borderRadius = '50%';
	footer.style.width = '60px';
	footer.style.height = '60px';
    footer.style.color = 'white';
    footer.style.padding = '20px';
	

    // Estilos de las opciones
    opciones.style.display = 'none';
    opciones.style.backgroundColor = '#444';
	opciones.style.width = '90px';
    opciones.style.padding = '10px';
	opciones.style.marginLeft = '-5px';
    opciones.style.marginTop = '-120px';


    // Estilos de los enlaces
    [opcion1, opcion2, opcion3].forEach(function(opcion) {
        opcion.style.display = 'block';
        opcion.style.color = 'white';
        opcion.style.textDecoration = 'none';
        opcion.style.margin = '5px 0';

        opcion.onmouseover = function() {
            this.style.textDecoration = 'underline';
        };
        opcion.onmouseout = function() {
            this.style.textDecoration = 'none';
        };
    });

    // Agregar elementos a las opciones
    opciones.appendChild(opcion1);
    opciones.appendChild(opcion2);
    opciones.appendChild(opcion3);

    footer.appendChild(opciones);

    // Agregar footer al cuerpo del documento
    document.body.appendChild(footer);

    // Evento para mostrar/ocultar opciones
    footer.addEventListener('click', function() {
        opciones.style.display = opciones.style.display === 'none' ? 'block' : 'none';
    });
});


}



// validacion para consultas de impuestos // reportes// etc


function validoRP($idForm, $campos){

  document.getElementById($idForm).addEventListener('submit', function(event) {
  var remateNum = document.getElementById($campos).value;
  
  // Validación del campo remate_num para asegurarse de que no esté vacío
  if(remateNum === "") {
    alertaError('Por favor, selecciona un número de remate.');
    event.preventDefault(); // Detiene el envío del formulario
  }

  // Aquí puedes añadir más validaciones según sea necesario

});

}

</script>

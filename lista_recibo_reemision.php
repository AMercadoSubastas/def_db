<?php 
require_once('funcion_mysqli_result.php'); 
require_once('Connections/amercado.php');
 ?>
<script language="javascript">
function agregarOpciones(form) {

    var selec = form.tipos;

    if (selec.selectedIndex == 0) {
        form.text_serie.value = ""; // Limpiar el valor del campo de texto
        form.tcomp.value = "";
        form.serie.value = "";
    }

    if (selec.selectedIndex == 1) {
        form.text_serie.value = "RECIBO DE COBRANZAS";
        form.tcomp.value = 2;
        form.serie.value = 3;
    }

    if (selec.selectedIndex == 2) {
        form.text_serie.value = "RECIBO INTERNO";
        form.tcomp.value = 140;
        form.serie.value = 58;
    }


var tcomp = form.tcomp.value;
var serie = form.serie.value;

// Hacer una solicitud AJAX usando fetch
fetch('validando_datos.php?recibotcomp=' + encodeURIComponent(tcomp) + '&serie=' + encodeURIComponent(serie))
    .then(response => response.json())
    .then(data => {
        // Verificar si data es un array
        if (Array.isArray(data)) {
          var select = document.getElementById("ncomp");
          select.innerHTML = '<option value="">Selecciona una opción...</option>';
            // Si es un array, iterar sobre los elementos utilizando forEach
            data.forEach(function(opcion) {
                var option = document.createElement("option");
                option.value = opcion.valor;
                option.text = opcion.texto;
                select.add(option);
            });
        } else {
            // Si no es un array, mostrar un mensaje de error
            console.error("Los datos recibidos no son un array:", data);
        }
    })
    .catch(error => {
        // Errores del AJAX
        alert('Error en la solicitud: ' + error); // Mostrar mensaje de error básico
    });
  }

</script>

</head>
<body>
<form name="form1" class="container-specific" method="post" action="rp_recibo.php">
  <table border="0" align="left" cellpadding="1" cellspacing="1">
    <tr>
      <td colspan="2" background="images/fondo_titulos.jpg" align="center"></td>
    </tr>
    <tr>
    </tr>
    <tr>
      <td width="150" >Tipo del Comprobante  : </td>
      <td width="50" ><select name="tipos" onchange="agregarOpciones(this.form)">
	    <option value="0">[ELIJA TIPO DE COMPROBANTE]</option>
        <option value="1">     RECIBO DE COBRANZAS    </option>
		<option value="2">     RECIBO INTERNO    </option>
		
      </select></td>
    </tr>
    <tr>
      <td >Serie del Comprobante : </td>
      <td ><input name="text_serie" type="text" size="40"  />
      </td>
    </tr>
    <tr>
      <td >Nro.  del Comprobante : </td>
      <td width="100"><select name="ncomp" id="ncomp">
          </select></td>
    </tr>
    <tr>
      <td ><label>Tipo Comp&nbsp;</label><input id="tcomp" name="tcomp" type="text"  size="2" /></td>
      <td ><label>Serie Comp&nbsp;</label><input id="serie" name="serie" type="text" size="2"  /></td>
    </tr>
    <tr>
      <!-- <td width="181">&nbsp;</td> -->
      <td width="132"><input type="submit" name="Submit" value="Enviar" /></td>
      <!-- <td width="69">&nbsp;</td> -->
    </tr>
  </table>
</form>
</body>
</html>
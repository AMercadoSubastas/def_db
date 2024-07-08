<script language="javascript">
function agregarOpciones(form) {
	var selec = form.tipos.options;

    if (selec[0].selected == true) {
	    var seleccionar = new Option("<-- esperando selección","","","");
    	combo[0] = seleccionar;
    }

    if (selec[1].selected == true) {
	    form1.text_serie.value = "FACTURA ELECTRONICA B0002-";
    	form1.ftcomp.value = 6;
	 	form1.fpvta.value = 2;
    }

	
	
	if (selec[2].selected == true) {
     	form1.text_serie.value = "NOTA DE CRED ELECTRONICA B0002-";
     	form1.ftcomp.value = 8;
	 	form1.fpvta.value = 2;
    }
	
	if (selec[3].selected == true) {
     	form1.text_serie.value = "NOTA DE DEB ELECTRONICA B0002-";
     	form1.ftcomp.value = 7;
	 	form1.fpvta.value = 2;
    }
	
	
	
}
</script>
<?php 
    require_once('Connections/amercado.php');  
    require_once "funcion_mysqli_result.php";
?>
</head>

<body>
<form id="form1" name="form1" class="container-specific" method="get" action="rp_facncB_consultar.php">
  <table width="727" height="203" border="1" align="left" cellpadding="1" cellspacing="1">
    
    <tr>

    </tr>
    <tr>
      <td width="298" >Tipo del Cbte Afip : </td>
      <td width="422" ><select name="tipos" onChange="agregarOpciones(this.form)">
	    <option value="0">[ELIJA TIPO DE COMPROBANTE]</option>
        <option value="1">FACTURA ELECTRONICA  B0002</option>
        <option value="2">NOTA CREDITO ELECTRONICA B0002</option>
        <option value="3">NOTA DEBITO ELECTRONICA B0002</option>
		
      </select></td>
    </tr>
    <tr>
      <td >Punto de Venta : </td>
      <td ><input name="text_serie" type="text" size="45"  />
      </td>
    </tr>
    <tr>
      <td >Nro.  del Comprobante : </td>
      <td ><input name="fncomp" type="text" id="fncomp" size="45"/></td>
    </tr>
    <tr>
      <td ><label>Tipo Cbte afip&nbsp;</label><input name="ftcomp" type="text"  size="2" /></td>
      <td ><label>Punto de Venta&nbsp;</label><input name="fpvta" type="text" size="2"  /></td>
    </tr>
    <tr>
      <td width="298">&nbsp;</td>
      <td width="422"><input type="submit" name="Submit" value="Enviar" /></td>
    </tr>
  </table>
</form>
</body>
</html>

<?php require_once('funcion_mysqli_result.php');?>

<script language="javascript">
function agregarOpciones(form) {
	var selec = form.tipos.options;

    if (selec[0].selected == true) {
	    var seleccionar = new Option("<-- esperando seleccion","","","");
    	combo[0] = seleccionar;
    }

    if (selec[1].selected == true) {
	    form1.text_serie.value = "FACTURA ELECTRONICA B0002-";
    	form1.ftcomp.value = 116;
	 	form1.fserie.value = 53;
    }

		
	if (selec[2].selected == true) {
     	form1.text_serie.value = "NOTA DE CRED ELECTRONICA B0002-";
     	form1.ftcomp.value = 120;
	 	form1.fserie.value = 53;
    }

	if (selec[3].selected == true) {
     	form1.text_serie.value = "NOTA DE DEB ELECTRONICA B0002-";
     	form1.ftcomp.value = 123;
	 	form1.fserie.value = 53;
    }

	
	
}
</script>
</head>
<body>
<form id="form1" name="form1" class="container-specific" method="get" action="rp_facncB.php">
  <table width="727" height="203" border="1" align="left" cellpadding="1" cellspacing="1">
    
    
    <tr>
      <td width="298" >Tipo del Comprobante  : </td>
      <td width="422" ><select name="tipos" onChange="agregarOpciones(this.form)">
	    <option value="0">[ELIJA TIPO DE COMPROBANTE]</option>
        <option value="1">FACTURA ELECTRONICA B0002</option>
        <option value="2">NOTA CREDITO ELECTRONICA B0002</option>
        <option value="3">NOTA DEBITO ELECTRONICA B0002</option>
		
      </select></td>
    </tr>
    <tr>
      <td >Serie del Comprobante : </td>
      <td ><input name="text_serie" type="text" size="45"  />
      </td>
    </tr>
    <tr>
      <td >Nro.  del Comprobante : </td>
      <td ><input name="fncomp" type="text" id="fncomp" size="45"/></td>
    </tr>
    <tr>
      <td ><label>Tipo Comp&nbsp;</label><input name="ftcomp" type="text"  size="2" /></td>
      <td ><label>Serie Comp&nbsp;</label><input name="fserie" type="text" size="2" /></td>
    </tr>
    <tr>
      <td width="298">&nbsp;</td>
      <td width="422"><input type="submit" name="Submit" value="Enviar" /></td>
    </tr>
  </table>
</form>
</body>
</html>
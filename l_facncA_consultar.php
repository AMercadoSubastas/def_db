<script language="javascript">
function agregarOpciones(form) {
	var selec = form.tipos.options;

    if (selec[0].selected == true) {
	    var seleccionar = new Option("<-- esperando seleccion","","","");
    	combo[0] = seleccionar;
    }

    if (selec[1].selected == true) {
	    form1.text_serie.value = "FACTURA ELECTRONICA A0002-";
		form1.ftcomp.value = 1;
	 	form1.fpvta.value = 2;
	}
		
	if (selec[2].selected == true) {
     	form1.text_serie.value = "NOTA DE CRED ELECTRONICA A0002-";
		form1.ftcomp.value = 3;
		form1.fpvta.value = 2;
    }

	if (selec[3].selected == true) {
     	form1.text_serie.value = "NOTA DE DEB ELECTRONICA A0002-";
     	form1.ftcomp.value = 2;
	 	form1.fpvta.value = 2;
    }

	    
    if (selec[4].selected == true) {
     	form1.text_serie.value = "FACTURA MIPYME A0005-";
     	form1.ftcomp.value = 201;
	 	form1.fpvta.value = 5;
    }
    if (selec[5].selected == true) {
     	form1.text_serie.value = "N CRED  MIPYME A0005-";
     	form1.ftcomp.value = 203;
	 	form1.fpvta.value = 5;
    }
  
}
</script>
<?php 
      require_once "funcion_mysqli_result.php";
      require_once('Connections/amercado.php');     
?>
</head>

<body>
<form id="form1" class="container-specific" name="form1" method="get" action="rp_facncA_consultar.php">
  <table width="727" height="203" border="1" align="left" cellpadding="1" cellspacing="1">
    <tr>
    </tr>
    <tr>
    </tr>
    <tr>
      <td width="298" >Tipo del Cbte Afip  : </td>
      <td width="422" ><select name="tipos" onChange="agregarOpciones(this.form)">
	    <option value="0">[ELIJA TIPO DE COMPROBANTE]</option>
        <option value="1">FACTURA ELECTRONICA A0002</option>
        <option value="2">NOTA CREDITO ELECTRONICA A0002</option>
        <option value="3">NOTA DEBITO ELECTRONICA A0002</option>
		<option value="4">FACTURA ELECTRONICA MIPyME A0005</option>
          <option value="5">N CRED MIPyME A0005</option>
        
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
      <td ><label>Tipo Comp&nbsp;</label><input name="ftcomp" type="text"  size="2" /></td>
      <td ><label>Serie Comp&nbsp;</label><input name="fpvta" type="text" size="2"  /></td>
    </tr>
    <tr>
      <td width="298">&nbsp;</td>
      <td width="422"><input type="submit" name="Submit" value="Enviar" /></td>
    </tr>
  </table>
</form>
</body>
</html>

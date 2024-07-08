<?php 
 require_once('Connections/amercado.php');
 require_once('funcion_mysqli_result.php');
?>

</head>
<script language="javascript" src="cal2.js" >
</script>
<script language="javascript" src="cal_conf2.js"></script>
<body>
<form  name="libros" method="post" class="container-specific-1" action="rp_ivaventas.php">
  <table width="392" height="179" border="0" align="left" cellpadding="1" cellspacing="1">
    <tr>
    </tr>

    
    <tr>
      <td width="181" height="39">Desde: </td>

      <td width="132"><input name="fecha_desde" type="text" size="11" /></td>
      <td width="69"><a href="javascript:showCal('Calendar14')"><img src="calendar/img.gif" width="20" height="14"  border="0"/></a></td>
    </tr>
    <tr>
      <td width="181">Hasta</td>
      <td width="132"><input name="fecha_hasta" type="text" size="11" /></td>
      <td width="69"><a href="javascript:showCal('Calendar15')"><img src="calendar/img.gif" width="20" height="14"  border="0"/></a></td>
    </tr>
      <tr>
      <td width="48%" height="29" ><span class="ewTableHeader">Salida pdf</span></td>
      <td width="52%" ><input name="GrupoOpciones1" type="radio"  value=1   checked="checked" /></td>
    </tr>
    <tr>
      <td height="27" ><span class="ewTableHeader">Salida txt</span></td>
      <td ><input name="GrupoOpciones1" type="radio" value=0  /></td>
    </tr>
    <tr>
      <td width="181">&nbsp;</td>
      <td width="132"><input type="submit" class="btn" name="Submit" value="Enviar" /></td>
      <td width="69">&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>


<?php	
 require_once('funcion_mysqli_result.php');
 ?>
 
</head>
<script language="javascript" src="cal2.js" >
</script>
<script language="javascript" src="cal_conf2.js"></script>
<body>
<form  name="libros" class="container-specific-1" method="post" action="rp_citicompras_alic.php">
  <table width="423" height="241" border="0" align="left" cellpadding="1" cellspacing="1">
    <tr>
    </tr>

    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td width="183">Desde  : </td>
      <td width="135"><input name="fecha_desde" type="text" size="11" /></td>
      <td width="49"><a href="javascript:showCal('Calendar14')"><img src="calendar/img.gif" width="20" height="14"  border="0"/></a></td>
    </tr>
    <tr>
      <td width="183">Hasta :</td>
      <td width="135"><input name="fecha_hasta" type="text" size="11" /></td>
      <td width="49"><a href="javascript:showCal('Calendar15')"><img src="calendar/img.gif" width="20" height="14"  border="0"/></a></td>
    </tr>
    <tr>
      <td width="183">&nbsp;</td>
      <td width="135"><input type="submit" class="btn" name="Submit" value="Enviar" /></td>
      <td width="49">&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>

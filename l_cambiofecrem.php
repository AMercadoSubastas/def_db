<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>

<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php 
 require_once('Connections/amercado.php');  
 include_once "ewcfg11.php" ;
 include_once "ewmysql11.php" ;
 include_once "phpfn11.php" ; 
 include_once "userfn11.php" ;
 include_once "usuariosinfo.php" ; ?>
 <?php
    $editFormAction = $_SERVER['PHP_SELF'];
    if (isset($_SERVER['QUERY_STRING'])) {
	   $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
    }
    if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "libros")) {
        mysqli_select_db($amercado, $database_amercado);

        // Leo los par�metros del formulario
        $remate    	 = $_POST['remate_num'];
        $fecha_tope  = $_POST['fecha_desde'];

        $nueva_fecha =  "\"".substr($fecha_tope,6,4)."-".substr($fecha_tope,3,2)."-".substr($fecha_tope,0,2)."\"";
        
        // Modifico la fecha tope del remate
        $query_rem = sprintf("UPDATE `remates` SET `fecest` = %s WHERE `ncomp`  = %s ", $nueva_fecha, $remate);
        $cabecerarem = mysqli_query($amercado, $query_rem) ;
         mysqli_close($amercado);

}
require_once('Connections/amercado.php');  
mysqli_select_db($amercado, $database_amercado);
$query_Recordset1 = "SELECT * FROM `remates` ORDER BY `ncomp` desc";
$Recordset1 = mysqli_query($amercado, $query_Recordset1) or die(mysqli_error($amercado));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
//echo $totalRows_Recordset1;
 ?>
</head>   
<script language="javascript" src="cal2.js" >
</script>
<script language="javascript" src="cal_conf2.js"></script>
<body>
<form id="libros" name="libros" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="706" height="152" border="0" align="left" cellpadding="1" cellspacing="1">
    <tr>
      <td colspan="2" background="images/nada.gif" align="center"><img src="images/nada.gif" width="222" height="30" /></td>
    </tr>
    <tr>
      <td width="234">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="234">Remate N&uacute;mero : </td>
      <td height="10" class="ewTableHeader"> </td>
          <td><select name="remate_num" id="remate_num">
            <option value="">Remate</option>
		
            <?php
				do {  
			?>
            		<option value="<?php echo $row_Recordset1['ncomp']?>"><?php echo $row_Recordset1['ncomp']?><?php echo " - "?><?php echo $row_Recordset1['direccion']?><?php echo " - "?><?php echo $row_Recordset1['fecest']?></option>
            <?php
				} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
  				$rows = mysqli_num_rows($Recordset1);
  				if($rows > 0) {
      				mysqli_data_seek($Recordset1, 0);
	  				$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
  				}
			?>
          </select></td>
      
    </tr>
    <tr>
      <td width="234">&nbsp;</td>
      <td width="420">&nbsp;</td>
    </tr>
       <tr>
      <td width="227" height="49">Fecha tope: </td>
      <td width="132"><input name="fecha_desde" type="text" size="11" /></td>
      <td width="69"><a href="javascript:showCal('Calendar14')"><img src="calendar/img.gif" width="20" height="14"  border="0"/></a></td>
    </tr>
    <tr>
      <td width="234">&nbsp;</td>
      <td width="420"><input type="submit" name="Submit" value="Enviar" /></td>
        <input type="hidden" name="MM_insert" value="libros">
    </tr>
  </table>
</form>
</body>
</html>
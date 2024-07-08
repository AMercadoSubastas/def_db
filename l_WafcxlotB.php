<?php
require_once "funcion_mysqli_result.php";
require_once('Connections/amercado.php');
mysqli_select_db($amercado, $database_amercado);
//$query_Recordset1 = "SELECT * FROM `remates` ORDER BY `ncomp` desc";
//$query_Recordset1 = sprintf("SELECT * FROM `remates` WHERE `fecest` >= NOW() ORDER BY `ncomp` desc");
$query_Recordset1 = "SELECT * FROM remates WHERE servicios IS NOT NULL AND gastos IS NOT NULL AND codcli != 940  ORDER BY `ncomp` desc";
$Recordset1 = mysqli_query($amercado, $query_Recordset1) or die("ERROR LEYENDO REMATES");
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$cod_usuario = $_SESSION['id'];

?>

<body>
<form id="form1" name="form1" class="container" method="post" action="WafcautxlotB.php">
  <table width="706" height="152" border="0" align="left" cellpadding="1" cellspacing="1">
    <tr>
    </tr>
    <tr>
      <td width="234">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="234">Remate a facturar: </td>
      <td height="10" class="ewTableHeader"> </td>
          <td><select name="remate_num" id="remate_num">
            <option value="">Remate</option>
		
            <?php
				do {  
			?>
            		<option value="<?php echo $row_Recordset1['ncomp']?>"><?php echo $row_Recordset1['ncomp']?><?php echo " - "?><?php echo $row_Recordset1['direccion']?></option>
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
		<td><input name="codusu" id="codusu" type="hidden"  size="12" value="<?php echo $cod_usuario?>" /></td>
      <td width="420">&nbsp;</td>
    </tr>
    <tr>
      <td width="234">&nbsp;</td>
      <td width="420"><input type="submit" name="Submit" value="Enviar" /></td>
    </tr>
  </table>
</form>
</body>
</html>

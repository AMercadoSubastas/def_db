<?php
require_once('Connections/amercado.php');
require_once('funcion_mysqli_result.php');
mysqli_select_db($amercado, $database_amercado);
$query_Recordset1 = "SELECT * FROM `remates` ORDER BY `ncomp` desc";
$Recordset1 = mysqli_query($amercado, $query_Recordset1) or die(mysqli_error($amercado));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
//echo $totalRows_Recordset1;
 ?>

<body>
<form id="libros" class="container-specific" name="libros" method="post" action="rp_facturasliq.php">
  <table width="706" height="152" border="0" align="left" cellpadding="1" cellspacing="1">
    <tr>
    </tr>
    <td width="264">&nbsp;</td>
      <td>&nbsp;</td>
    <tr>
      <td width="234">Subasta N&uacute;mero : </td>
          <td><select name="remate_num" id="remate_num">
            <option value="">Subasta</option>
		
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
      <td width="266">Desde  : </td>
      <td width="119"><input name="fecha_desde" type="text" size="11" /></td>
      <td width="43"><a href="javascript:showCal('Calendar14')"><img src="calendar/img.gif" width="20" height="14"  border="0"/></a></td>
    </tr>
    <tr>
      <td width="266">Hasta</td>
      <td width="119"><input name="fecha_hasta" type="text" size="11" /></td>
      <td width="43"><a href="javascript:showCal('Calendar15')"><img src="calendar/img.gif" width="20" height="14"  border="0"/></a></td>
    </tr>
    <tr>
      <td width="234">&nbsp;</td>
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

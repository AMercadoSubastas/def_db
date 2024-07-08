<?php
require_once('funcion_mysqli_result.php');
require_once('Connections/amercado.php');  
mysqli_select_db($amercado, $database_amercado);
$query_Recordset1 = "SELECT * FROM `remates` ORDER BY `ncomp` desc";
$Recordset1 = mysqli_query($amercado, $query_Recordset1) or die(mysqli_error($amercado));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
//echo $totalRows_Recordset1;
 ?>

<body>
<form id="form1" class="container" name="form1" method="post" action="rp_boletase.php">
  <table width="500" height="304" border="0" align="left" cellpadding="1" cellspacing="1">
    <tr>
    </tr>
    <tr>
      <td width="234">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="34" style=texto bgcolor="#CFCFCF">Remate N&uacute;mero : </td>
      <td height="27" class="ewTableHeader"><select name="remate_num" id="remate_num">
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
          <td>&nbsp;</td>
      
    </tr>
    <tr>
              <td width="48%" height="29" bgcolor="#CFCFCF">&nbsp;<span class="ewTableHeader">Triplicado Si</span></td>
              <td width="52%" bgcolor="#CFCFCF"><input name="GrupoOpciones1" type="radio" value=1  /></td>
            </tr>
            <tr>
              <td height="27" bgcolor="#CFCFCF">&nbsp;<span class="ewTableHeader">Triplicado No</span></td>
              <td bgcolor="#CFCFCF"><input name="GrupoOpciones1" type="radio" value=0   checked="checked" /></td>
            </tr>
    <tr>
     		<tr>
              <td width="48%" height="27" bgcolor="#CFCFCF">&nbsp;<span class="ewTableHeader">Gs Administrativos Si</span></td>
              <td width="52%" bgcolor="#CFCFCF"><input name="GrupoOpciones2" type="radio" value=1 checked="checked"  /></td>
            </tr>
            <tr>
              <td height="27" bgcolor="#CFCFCF">&nbsp;<span class="ewTableHeader">Gs Administrativos No</span></td>
              <td bgcolor="#CFCFCF"><input name="GrupoOpciones2" type="radio" value=0   /></td>
            </tr>
            
            <tr>
              <td width="48%" height="25" bgcolor="#CFCFCF">&nbsp;<span class="ewTableHeader">Seña 30 % Si</span></td>
              <td width="52%" bgcolor="#CFCFCF"><input name="GrupoOpciones3" type="radio" value=1  /></td>
            </tr>
            <tr>
              <td height="27" bgcolor="#CFCFCF">&nbsp;<span class="ewTableHeader">Seña 30 % No</span></td>
              <td bgcolor="#CFCFCF"><input name="GrupoOpciones3" type="radio" value=0   checked="checked" /></td>
            </tr>
	   <tr>
              <td width="48%" height="25" bgcolor="#CFCFCF">&nbsp;<span class="ewTableHeader">Lotes No</span></td>
              <td width="52%" bgcolor="#CFCFCF"><input name="GrupoOpciones4" type="radio" value=0  /></td>
            </tr> 
            <tr>
              <td height="27" bgcolor="#CFCFCF">&nbsp;<span class="ewTableHeader">Lotes Si</span></td>
              <td bgcolor="#CFCFCF"><input name="GrupoOpciones4" type="radio" value=1   checked="checked" /></td>
            </tr>
    <tr>
      <td width="234">&nbsp;</td>
      <td width="420">&nbsp;</td>
    </tr>
    <tr>
      <td width="234">&nbsp;</td>
      <td width="420"><input type="submit" style= bottom alt=""name="Submit" value="Generar PDF" /></td>
    </tr>
  </table>
</form>
</body>
</html>

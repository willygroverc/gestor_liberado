<?php
if (isset($_REQUEST['retornar']))
{	header("location:lista.php");
	if ($op == 3) header("location: listans.php");
	else if ($op == 2) header("location: listae.php");
		else
		{
			if($tipificacion == 1)
			{
				header("location: lista_tipos.php?pg=$pg&Naveg=Ordenes de Trabajo"); 
			}else
			{
				header("location: lista.php?pg=$pg&Naveg=Ordenes de Trabajo"); 
			}
		}
}
include("top.php");
require_once('funciones.php');
$id_orden=SanitizeString($_GET['id_orden']);
$sql4="SELECT *, DATE_FORMAT(fecha_conf, '%d/%m/%Y') AS fecha_conf FROM conformidad WHERE id_orden='$id_orden'";
$result4=mysql_db_query($db,$sql4,$link);
$row=mysql_fetch_array($result4);
?>
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" name="form1" onKeyPress="return Form()">
<input name="tipificacion" type="hidden" value="<?php=$tipificacion?>">
<input name="pg" type="hidden" value="<?php=$pg?>">

  <table width="73%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
    <tr bgcolor="#0000CC"> 
    	<th background="images/main-button-tileR1.jpg" height="20"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF">CONFORMIDAD Y OBSERVACIONES DEL CLIENTE</font></th>
   </tr>

    <tr> 
      <td height="222"> 
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="4">
          <tr align="center"> 
            <td colspan="2"><strong> <font size="2">Nro Orden de Trabajo :</font></strong><font size="2"> 
              <?php echo $id_orden;?> </font></td>
          </tr>
          <tr> 
            <td height="40" colspan="2"> 
              <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif"><br>
                CONFORMIDAD DEL CLIENTE</font></strong></div></td>
          </tr>
          <tr> 
            <td width="31%"><font size="2"><strong>Fecha:</strong> <?php echo $row['fecha_conf'];?> 
              </font></td>
            <td width="69%"><font size="2"><strong>Hora:</strong> <?php echo $row['hora_conf'];?> 
              </font></td>
          </tr>
          <tr> 
            <td><font size="2"><strong>Tiempo de solucion:</strong></font> <font size="2"> 
              <?php if ($row['tiemposol_conf']==1) echo "1 (Malo)";?>
              <?php if ($row['tiemposol_conf']==2) echo "2 (Bueno)";?>
              <?php if ($row['tiemposol_conf']==3) echo "3 (Excelente)";?>
              </font></td>
            <td><font size="2"><strong>Calidad de atencion:</strong></font> <font size="2"> 
              <?php if ($row['calidaten_conf']==1) echo "1 (Malo)";?>
              <?php if ($row['calidaten_conf']==2) echo "2 (Bueno)";?>
              <?php if ($row['calidaten_conf']==3) echo "3 (Excelente)";?>
              </font> 
			  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <font size="2"><strong>Tipo de Conformidad:</strong>
			<?php if ($row['tipo_conf']==2) echo "2 (Disconforme)";
				   else echo "1 (Conforme)";
			?>
              
			  </font></td>
          </tr>
          <tr> 
            <td colspan="2"><div align="center"><font size="2"><strong><font face="Arial, Helvetica, sans-serif"><br>
                OBSERVACIONES DEL CLIENTE</font></strong></font></div></td>
          </tr>
          <tr> 
            <td colspan="2"> <div align="center"><font size="2"><?php echo $row['obscli_conf'];?> 
                </font></div></td>
          </tr>
          <tr align="center"> 
            <td colspan="2"><br> <input name="retornar" type="submit" value="RETORNAR"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php include("top_.php");?>
<?php
if ($RETORNAR){header("location: lista_agenda.php");}

else 
{ include ("top.php");
?>
<?php 
	include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("num","Numero de Registro");
/*	$help->AddHelp("tipo","Tipo de Cliente... A:admin, T:tecnico, C:cliente");
	$help->AddHelp("conf","Conformidad de ...");
	$help->AddHelp("solu","Solucion a las ordenes de trabajo ...");
	$help->AddHelp("incidencia","Incidencia se refiere a...");**/
	print $help->ToHtml();
 ?>
<table border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
    <td height="68" valign="top"><table width="850" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="14" bgcolor="#006699"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">FORMATO 
            DE MINUTA DE REUNION</font></th>
        </tr>
        <tr align=\"center\"> 
          <th width="79" rowspan="2" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA</font></th>
          <th width="69" rowspan="2" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">CODIGO</font></th>
          <th width="41" rowspan="2" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1"><?php print $help->AddLink("num", "N&deg;"); ?></font></th>
          <th width="161" rowspan="2" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">ELABORADO 
            POR </font></th>
          <th width="65" rowspan="2" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">TIPO 
            DE REUNION</font></th>
          <th width="148" rowspan="2" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">LUGAR</font></th>
        </tr>
        <tr align=\"center\"> 
          <th width="79" height="13" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">MODIFICAR</font></th>

        </tr>
        <?php
$sql = "SELECT * FROM minuta ORDER BY id_minuta DESC";
$result=mysql_db_query($db,$sql,$link);
while ($row=mysql_fetch_array($result)) 
{
  	echo "<tr align=\"center\">";
	echo "<td><font size=\"1\">&nbsp;$row[en_fecha]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[codigo]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[num_codigo]</td>";
	echo "<td><font size=\"1\">&nbsp;$row[elab_por]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[tipo]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[lugar]</font></td>";	
		
	$sql3 = "SELECT * FROM minuta WHERE id_minuta='$row[id_minuta]' GROUP BY id_minuta";
    $result3 = mysql_db_query($db,$sql3,$link);
	$row3 = mysql_fetch_array($result3);
	echo "<td><font size=\"1\">&nbsp;<a href=\"minuta_last.php?verif=0&id_minuta=$row3[id_minuta]\">MODIFICAR</a></font></td>";

						

}
echo "</tr>";
?>
      </table></td>
  </tr>
</table>
  
  
<form name="form1" method="post" action="">
  <div align="center">
    <input name="RETORNAR" type="submit" id="reg_form3" value="RETORNAR">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  </div>
</form>

 <?php } ?>
  <?php include("top_.php");?> 
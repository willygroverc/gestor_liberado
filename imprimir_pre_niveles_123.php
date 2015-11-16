<?php
include("conexion.php");
$sql="SELECT * FROM area ORDER BY area_nombre ASC";
$datos=mysql_db_query($db,$sql,$link);
?>
<html>
<head>
<title>Impresion</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>

<body>
<div align="center">
<form action="" name="form1" method="get">
  <table width="75%" border="1" background="images/fondo.jpg">
    <tr> 
      <th colspan="4" bgcolor="#006699"><div align="center"><strong><font color="#FFFFFF">IMPRESION</font></strong></div></th>
    </tr>
	<tr>
		<td colspan="4">&nbsp;</td></tr>
    <tr> 
      <td width="25%"><div align="right" class="normal"><strong>Nivel 1:</strong></div></td>
      <td width="25%"> 
	  <select name="txtarea" id="txtarea" onChange="cambiar(this.value)">
		  	<option value="0">GENERAL</option>
			<?php while($area=mysql_fetch_array($datos)){?>
	    	<option value="<?php=$area[area_cod];?>" <?php if($id_area==$area[area_cod]) echo "selected"?>><?php echo $area[area_nombre]; ?></option>
			<?php }?>
      </select></td>
      <td width="21%"><div align="right" class="normal"><strong>Nivel 2:</strong></div></td>
      <td width="29%"> 
	  <select name="dominio" id="dominio">
		  <?php 
		  $sql_sen="SELECT * FROM dominio WHERE id_area='$id_area'";
		  $data=mysql_db_query($db,$sql_sen,$link);
		  echo "<option value=\"0\">GENERAL</option>";
		  while($domi=mysql_fetch_array($data)){?>
				<option value="<?php=$domi[id_dominio];?>"><?php echo $domi[dominio]; ?></option>
		  <?php }?>
      </select> </td>
    </tr>
	<tr>
		
      <td colspan="4"><div align="center"><br>
          <input name="IMPRESION" type="button" id="IMPRESION" value="IMPRESION" onClick="imprimir()">
        </div></td>
	</tr>
  </table>
  </form>
</div>
</body>
</html>
<script language="JavaScript" type="text/JavaScript">
<!--
function imprimir(){
	if(document.form1.txtarea.value == "0")
	{
		open("impresion_niveles.php","Boris",'width=800,height=600,status=yes,resizable=yes,top=50,left=50,scrollbars=yes,toolbars=yes,dependent=yes,alwaysRaised=yes')
		close();
	}
	else{
		open("imprimir_objetivo.php?cod1="+document.form1.txtarea.value+"&cod="+document.form1.dominio.value,"Boris",'width=800,height=600,status=yes,resizable=yes,top=50,left=50,scrollbars=yes,toolbars=yes,dependent=yes,alwaysRaised=yes')
		close();
	}
}
function cambiar(valor){
	dir="imprimir_pre_niveles.php?id_area="+valor
	self.location=dir
}
-->
</script>
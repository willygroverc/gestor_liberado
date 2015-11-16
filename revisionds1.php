<?php
if ($RETORNAR){header("location: lista_ordenrev1.php");}
if (isset($reg_form3))
{	include("conexion.php");

if($elegido1==""){$elegido1="No";}
if($elegido2==""){$elegido2="No";}
if($elegido3==""){$elegido3="No";}
if($elegido4==""){$elegido4="No";}
if($elegido5==""){$elegido5="No";}
if($elegido6==""){$elegido6="No";}
if($elegido7==""){$elegido7="No";}
if($elegido8==""){$elegido8="No";}
if($elegido9==""){$elegido9="No";}
if($elegido10==""){$elegido10="No";}
if($elegido11==""){$elegido11="No";}
if($elegido12==""){$elegido12="No";}	
if($elegido13==""){$elegido13="No";}
if($elegido14==""){$elegido14="No";}
  $ver2=1;
  $sql0 = "SELECT * FROM detaller WHERE id_orden='$VarPas'";
  $result0 = mysql_db_query($db,$sql0,$link);
  $row0 = mysql_fetch_array($result0);
  if (!$row0[id_orden]){		
  
  $sql1 = "INSERT INTO detaller (id_orden,numero,descripcion,elegido,observ) VALUES ('$VarPas','$ver2','Control de Numero de Registro','$elegido1','$observaciones1')";
  mysql_db_query($db,$sql1,$link);
  $ver2=$ver2+1;		

  $sql2 = "INSERT INTO detaller (id_orden,numero,descripcion,elegido,observ) VALUES ('$VarPas','$ver2','Correctitud en el llenado de campos','$elegido2','$observaciones2')";
  mysql_db_query($db,$sql2,$link);
  $ver2=$ver2+1;		

  $sql3 = "INSERT INTO detaller (id_orden,numero,descripcion,elegido,observ) VALUES ('$VarPas','$ver2','Comunicacion al Propietario del recurso','$elegido3','$observaciones3')";
  mysql_db_query($db,$sql3,$link);
  $ver2=$ver2+1;		
  
  $sql4 = "INSERT INTO detaller (id_orden,numero,descripcion,elegido,observ) VALUES ('$VarPas','$ver2','Problema Recurrente','$elegido4','$observaciones4')";
  mysql_db_query($db,$sql4,$link);
  $ver2=$ver2+1;		
  
  $sql5 = "INSERT INTO detaller (id_orden,numero,descripcion,elegido,observ) VALUES ('$VarPas','$ver2','Diagnostico Adecuado','$elegido5','$observaciones5')";
  mysql_db_query($db,$sql5,$link);
  $ver2=$ver2+1;		
  
  $sql6 = "INSERT INTO detaller (id_orden,numero,descripcion,elegido,observ) VALUES ('$VarPas','$ver2','Asignacion del Responsable de resoluciòn','$elegido6','$observaciones6')";
  mysql_db_query($db,$sql6,$link);
  $ver2=$ver2+1;		
  
  $sql7 = "INSERT INTO detaller (id_orden,numero,descripcion,elegido,observ) VALUES ('$VarPas','$ver2','Tiempos Adecuados','$elegido7','$observaciones7')";
  mysql_db_query($db,$sql7,$link);
  $ver2=$ver2+1;		
  
  $sql8 = "INSERT INTO detaller (id_orden,numero,descripcion,elegido,observ) VALUES ('$VarPas','$ver2','Prioridad establecida','$elegido8','$observaciones8')";
  mysql_db_query($db,$sql8,$link);
  $ver2=$ver2+1;		
  
  $sql9 = "INSERT INTO detaller (id_orden,numero,descripcion,elegido,observ) VALUES ('$VarPas','$ver2','Impacto Determinado','$elegido9','$observaciones9')";
  mysql_db_query($db,$sql9,$link);
  $ver2=$ver2+1;		
  
  $sql10 = "INSERT INTO detaller (id_orden,numero,descripcion,elegido,observ) VALUES ('$VarPas','$ver2','Control de Logs de Operaciones','$elegido10','$observaciones10')";
  mysql_db_query($db,$sql10,$link);
  $ver2=$ver2+1;		
  
  $sql11 = "INSERT INTO detaller (id_orden,numero,descripcion,elegido,observ) VALUES ('$VarPas','$ver2','Control de Logs de error','$elegido11','$observaciones11')";
  mysql_db_query($db,$sql11,$link);
  $ver2=$ver2+1;		
  
  $sql12 = "INSERT INTO detaller (id_orden,numero,descripcion,elegido,observ) VALUES ('$VarPas','$ver2','Control de Pistas de Auditorìa','$elegido12','$observaciones12')";
  mysql_db_query($db,$sql12,$link);
  $ver2=$ver2+1;		
  
  $sql13 = "INSERT INTO detaller (id_orden,numero,descripcion,elegido,observ) VALUES ('$VarPas','$ver2','Control de Cambios','$elegido13','$observaciones13')";
  mysql_db_query($db,$sql13,$link);
  $ver2=$ver2+1;		
  
  $sql14 = "INSERT INTO detaller (id_orden,numero,descripcion,elegido,observ) VALUES ('$VarPas','$ver2','Pruebas de Aceptacion','$elegido14','$observaciones14')";
  mysql_db_query($db,$sql14,$link);
  $ver2=$ver2+1;		
  }
  header("location: revisionds.php?id_orden=$VarPas&cont=14");
  
}

else { 
include("top.php");
$VarPas=($_GET['id_orden']);
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

<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" bgcolor="#EAEAEA" background="images/fondo.jpg">   
   	<form name="form1" method="post" action="<?php echo $PHP_SELF ?>" onKeyPress="return Form()">
		<input name="VarPas" type="hidden" value="<?php echo $VarPas;?>">
		
  <table width="95%" border="2" align="center" background="images/fondo.jpg">
    <tr> 
      <td colspan="5" bgcolor="#006699"><div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">REVISION 
          DEL DIA SIGUIENTE</font></strong></div></td>
    </tr>
    <tr> 
      <td colspan="5"><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
        &nbsp;Descripcion de la Incidencia:</font></strong> <font size="2" face="Arial, Helvetica, sans-serif"> 
        <?php 
	  	$sql="SELECT desc_inc FROM ordenes WHERE id_orden=$id_orden";
		$rs=mysql_fetch_array(mysql_db_query($db, $sql, $link));
		print $rs[desc_inc];
	   ?>
        </font></td>
    </tr>
    <tr> 
      <td width="3%" bgcolor="#006699"><div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordm;</font></strong></div></td>
      <td width="33%" bgcolor="#006699"> <div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">DESCRIPCION</font></strong></div></td>
      <td width="3%" bgcolor="#006699"> <div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">SI</font></strong></div></td>
      <td width="3%" bgcolor="#006699"> <div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">NO</font></strong></div></td>
      <td width="58%" bgcolor="#006699"> <div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></strong></div></td>
    </tr>
    <tr> 
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">1</font></div></td>
      <td><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Control 
          de Numero de Registro</font></div></td>
      <td align="center" > <input type="radio" name="elegido1" value="Si" id="radio"></td>
      <td align="center"> <input name="elegido1" type="radio" value="No" checked ></td>
      <td  align="center"><input name="observaciones1" type="text" value="" size="80" maxlength="75"></td>
    </tr>
    <tr> 
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">2</font></div></td>
      <td><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Correctitud 
          en el llenado de Campos</font></div></td>
      <td height="26" align="center" > <input type="radio" name="elegido2" value="Si" id="radio"></td>
      <td align="center" > <input name="elegido2" type="radio" value="No" checked></td>
      <td  align="center"><input name="observaciones2" type="text" value="" size="80" maxlength="75"></td>
    </tr>
    <tr> 
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">3</font></div></td>
      <td><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Comunicacion 
          al Propietario del recurso</font></div></td>
      <td height="26" align="center" > <input type="radio" name="elegido3" value="Si" id="radio"></td>
      <td align="center" > <input name="elegido3" type="radio" value="No" checked></td>
      <td  align="center"><input name="observaciones3" type="text" value="" size="80" maxlength="75"></td>
    </tr>
    <tr> 
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">4</font></div></td>
      <td><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Problema 
          Recurrente </font></div></td>
      <td height="26" align="center" > <input type="radio" name="elegido4" value="Si" id="radio"></td>
      <td align="center" > <input name="elegido4" type="radio" value="No" checked></td>
      <td  align="center"><input name="observaciones4" type="text" value="" size="80" maxlength="75"></td>
    </tr>
    <tr> 
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">5</font></div></td>
      <td><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Diagnostico 
          Adecuado </font></div></td>
      <td height="26" align="center" > <input type="radio" name="elegido5" value="Si" id="radio"></td>
      <td align="center" ><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"> 
        <input name="elegido5" type="radio" value="No" checked>
        </font></font></font></font> </td>
      <td><div align="center"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"> 
          <input name="observaciones5" type="text" value="" size="80" maxlength="75">
          </font></font></font></font></div></td>
    </tr>
    <tr> 
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">6</font></div></td>
      <td><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Asignacion 
          del responsable de resolucion</font></div></td>
      <td height="26" align="center" > <input type="radio" name="elegido6" value="Si" id="radio"></td>
      <td align="center" > <input name="elegido6" type="radio" value="No" checked></td>
      <td><div align="center"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"> 
          <input name="observaciones6" type="text" value="" size="80" maxlength="75">
          </font></font></font></font></div></td>
    </tr>
    <tr> 
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">7</font></div></td>
      <td><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Tiempos 
          Adecuados</font></div></td>
      <td height="26" align="center" > <input type="radio" name="elegido7" value="Si" id="radio"></td>
      <td align="center" > <input name="elegido7" type="radio" value="No" checked></td>
      <td><div align="center"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"> 
          <input name="observaciones7" type="text" value="" size="80" maxlength="75">
          </font></font></font></font></div></td>
    </tr>
    <tr> 
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">8</font></div></td>
      <td><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Prioridad 
          Establecida </font></div></td>
      <td height="26" align="center" > <input type="radio" name="elegido8" value="Si" id="radio"></td>
      <td align="center" > <input name="elegido8" type="radio" value="No" checked></td>
      <td><div align="center"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"> 
          <input name="observaciones8" type="text" value="" size="80" maxlength="75">
          </font></font></font></font></div></td>
    </tr>
    <tr> 
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">9</font></div></td>
      <td><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Impacto 
          Determinado </font></div></td>
      <td height="26" align="center" > <input type="radio" name="elegido9" value="Si" id="radio"></td>
      <td align="center" > <input name="elegido9" type="radio" value="No" checked></td>
      <td><div align="center"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"> 
          <input name="observaciones9" type="text" value="" size="80" maxlength="75">
          </font></font></font></font></div></td>
    </tr>
    <tr> 
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">10</font></div></td>
      <td><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Control 
          de logs de Operaciones</font></div></td>
      <td height="26" align="center" > <input type="radio" name="elegido10" value="Si" id="radio"></td>
      <td align="center" > <input name="elegido10" type="radio" value="No" checked></td>
      <td><div align="center"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"> 
          <input name="observaciones10" type="text" value="" size="80" maxlength="75">
          </font></font></font></font></div></td>
    </tr>
    <tr> 
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">11</font></div></td>
      <td><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Control 
          de Logs de error</font></div></td>
      <td height="26" align="center" > <input type="radio" name="elegido11" value="Si" id="radio"></td>
      <td align="center" > <input name="elegido11" type="radio" value="No" checked></td>
      <td><div align="center"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"> 
          <input name="observaciones11" type="text" value="" size="80" maxlength="75">
          </font></font></font></font></div></td>
    </tr>
    <tr> 
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">12</font></div></td>
      <td><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Control 
          de Pistas de Auditoria</font></div></td>
      <td height="26" align="center" > <input type="radio" name="elegido12" value="Si" id="radio"></td>
      <td align="center" > <input name="elegido12" type="radio" value="No" checked></td>
      <td><div align="center"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"> 
          <input name="observaciones12" type="text" value="" size="80" maxlength="75">
          </font></font></font></font></div></td>
    </tr>
    <tr> 
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">13</font></div></td>
      <td><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Control 
          de Cambios</font></div></td>
      <td height="26" align="center" > <input type="radio" name="elegido13" value="Si" id="radio"></td>
      <td align="center" > <input name="elegido13" type="radio" value="No" checked></td>
      <td><div align="center"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"> 
          <input name="observaciones13" type="text" value="" size="80" maxlength="75">
          </font></font></font></font></div></td>
    </tr>
    <tr> 
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">14</font></div></td>
      <td><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Pruebas 
          de Aceptacion</font></div></td>
      <td height="26" align="center" > <input name="elegido14" type="radio" id="radio" value="Si" ></td>
      <td align="center" > <input name="elegido14" type="radio" value="No" checked></td>
      <td><div align="center"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"> 
          <input name="observaciones14" type="text" value="" size="80" maxlength="75">
          </font></font></font></font></div></td>
    </tr>
    <?php
		$sql17 = "SELECT * FROM detaller ";
		$result17=mysql_db_query($db,$sql17,$link);
		$cont=15;
		while($row17=mysql_fetch_array($result17)) 
  		{
		 ?>
    <?php 
		 }
		 ?>
    <tr> 
      <td colspan="11"> <div align="center"><br>
          <input name="reg_form3" type="submit"  id="reg_form3" value="GUARDAR Y CONTINUAR">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
        </div></td>
    </tr>
  </table>
  <font size="1" face="Arial, Helvetica, sans-serif"> </font> 
  <p>&nbsp;</p>
  </form>
<?php } include("top_.php");?>

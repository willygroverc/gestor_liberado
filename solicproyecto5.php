<?php 
// Version: 	2.0
// Objetivo: 	Sanitizacion de variables para evitar ataques de SQL injection
// Fecha: 		02/OCT/2013
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
if (isset($_REQUEST['RETORNAR']))
{header("location: lista_solicproyecto.php");}
elseif (isset($_REQUEST['reg_form']))
{   include("conexion.php");
	require_once('funciones.php');
        $var=$_REQUEST['var'];
	$Responsabilid=$_REQUEST['Responsabilid'];
	$Actividades=$_REQUEST['Actividades'];
	$Aprobacion=$_REQUEST['Aprobacion'];
	$Observac=$_REQUEST['Observac'];
        
	$var=_clean($var);
	$Responsabilid=_clean($Responsabilid);
	$Actividades=_clean($Actividades);
	$Aprobacion=_clean($Aprobacion);
	$Observac=_clean($Observac);
	
	$var=SanitizeString($var);
	$Responsabilid=SanitizeString($Responsabilid);
	$Actividades=SanitizeString($Actividades);
	$Aprobacion=SanitizeString($Aprobacion);
	$Observac=SanitizeString($Observac);
	$sql="INSERT INTO ".
	"solicproycontrol (Codigo,Responsabilid,Actividades,Aprobacion,Observac,Fecha_cont) ".
	"VALUES ('$var','$Responsabilid','$Actividades','$Aprobacion','$Observac','".date("Y-m-d")."')";
	mysql_db_query($db,$sql,$link);
	header("location: solicproyecto5.php?Codigo=$var");
}
else { 
include("top.php");
require_once('funciones.php');
$Codigo=SanitizeString($_GET['Codigo']);
		$sql0 = "SELECT * FROM solicproydatos WHERE Codigo='$Codigo'";
		$result0=mysql_db_query($db,$sql0,$link);
		$row0=mysql_fetch_array($result0);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "Responsabilid",  "No existen mas Actividades para registrar. \\n \\nMensaje generado por GesTor F1." );
$valid->addIsTextNormal ( "Actividades",  "Ejecucion, $errorMsgJs[expresion]" );
$valid->addLength( "Observac",  "Observaciones, $errorMsgJs[length]" );
print $valid->toHtml();
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

  
<table width="95%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $Codigo;?>">
	<tr> 
      <td> 
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
            <td><div align="center"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif"><strong>SOLICITUD 
                DE PROYECTOS - FASE DE CONTROL</strong></font></div></td>
          </tr>
        </table>
        <table width="100%" border="1" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="82%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;REQUERIMIENTO 
              : <?php echo $row0['Requerimiento'];?> </font></td>
            <td width="18%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;CODIGO 
              : <?php echo $row0['Codigo'];?></font></td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Descripcion 
              del Proyecto : <?php echo $row0['DescProyecto'];?> </font></td>
          </tr>
        </table>
        <table width="100%" border="1" align="center" cellpadding="1" cellspacing="2" background="images/fondo.jpg">
          <tr> 
            <th width="175" rowspan="2" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">ACTIVIDADES</font></th>
            <th width="300" rowspan="2" nowrap bgcolor="#006699"><p><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">CONTROL<br>
                (Analisis de Factibilidad) </font></p></th>
            <th colspan="3" nowrap bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">APROBACION</font></div></th>
            <th rowspan="2" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">FECHA</font></th>
          </tr>
          <tr> 
            <th width="28" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">SI</font></th>
            <th width="30" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">NO</font></th>
            <th nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></th>
          </tr>
          <?php
			
		$sql = "SELECT *,DATE_FORMAT(Fecha_cont, '%d/%m/%Y') AS Fecha_cont FROM solicproycontrol WHERE Codigo='$Codigo'";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr align="center"> 
            <td><div align="center">&nbsp;<?php echo $row['Responsabilid']?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['Actividades']?>&nbsp;</div></div> 
            </td>
            <?php if  ($row['Aprobacion']>="SI") {echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";
												 echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";}
			  elseif ($row['Aprobacion']>="NO"){echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";
				   							       echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}?>
            <td><div align="center">&nbsp;<?php echo $row['Observac']?></div></td>
			<td><div align="center">&nbsp;<?php echo $row['Fecha_cont']?></div></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="8" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td height="7" nowrap><div align="center"><strong> </strong><strong> 
                <font size="2" face="Arial, Helvetica, sans-serif"> 
                <select name="Responsabilid">
                  <?php 
			      
			  $sql = "SELECT * FROM solicproyejecucion WHERE Codigo='$Codigo'";
			  $result = mysql_db_query($db,$sql,$link);
			  while ($row = mysql_fetch_array($result)) 
				{
				$sql2 = "SELECT * FROM solicproycontrol WHERE Codigo='$Codigo' AND Responsabilid='$row[Responsabilid]'";
				$result2 = mysql_db_query($db,$sql2,$link);
			  	$row2 = mysql_fetch_array($result2); 
				if (!$row2['Responsabilid'])
				{echo "<option value=\"$row[Responsabilid]\"> $row[Responsabilid] </option>";}
	            }
			   				               
			   ?>
                </select>
                </font> </strong> </div></td>
            <td width="300" nowrap height="7"><div align="center"><strong> 
                <input name="Actividades" type="text" size="50" maxlength="50">
                <font size="2" face="Arial, Helvetica, sans-serif"> </font> </strong></div></td>
            <td height="7" colspan="2" nowrap> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
                SI &nbsp; 
                <input type="radio" name="Aprobacion" value="SI">
                <br>
                NO 
                <input type="radio" name="Aprobacion" value="NO" checked>
                </font> </strong></div></td>
            <td width="282" height="7" nowrap><div align="center"> 
                <textarea name="Observac" cols="35"></textarea>
              </div></td>
            <td width="52" nowrap><div align="center"> <?php echo date("d/m/Y");?></div></td>
          </tr>
          <tr> 
            <td height="28" colspan="8" nowrap> <div align="center"><br>
                <input name="reg_form" type="submit" id="reg_form3" value="INSERTAR DATOS ACTIVIDAD" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div></td>
          </tr>
        </table>
        
        
      </td>
    </tr></form>
  </table>
  <?php } ?>
<?php include("top_.php");?>

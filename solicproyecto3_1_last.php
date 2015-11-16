<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		23/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
else{
	header('location:login.php');
}


if (isset($RETORNAR))
	header("location: solicproyecto3_last.php?Codigo=$var");

if (isset($reg_form))
{   include("conexion.php");
	$sql="INSERT INTO ".
	"solicproyplanif (Codigo,Responsabilid,Actividades,Aprobacion,Observac,Fecha_planif) ".
	"VALUES ('$var','$Responsabilid','$Actividades','$Aprobacion','$Observac','".date("Y-m-d")."')";
	mysql_query($sql);
	header("location: solicproyecto3_last.php?Codigo=$var");
}
else { 
include("top.php");
$Codigo=($_GET['Codigo']);
		$sql0 = "SELECT * FROM solicproydatos WHERE Codigo='$Codigo'";
		$result0=mysql_query($sql0);
		$row0=mysql_fetch_array($result0);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsTextNormal ( "Responsabilid",  "Actividades, $errorMsgJs[expresion]" );
$valid->addIsTextNormal ( "Actividades",  "Planificacion, $errorMsgJs[expresion]" );
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
  <form name="form2" method="post" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $Codigo;?>">
	<tr> 
      <td height="221"> 
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
            <td><div align="center"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif"><strong>SOLICITUD 
                DE PROYECTOS - MODIFICACION FASE DE PLANIFICACION </strong></font></div></td>
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
              del Proyecto : 
              <?php echo $row0['DescProyecto'];?>
              </font></td>
          </tr>
        </table>
        <table width="100%" border="1" align="center" cellpadding="1" cellspacing="2" background="images/fondo.jpg">
          <tr> 
            <th colspan="6" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">Grupo 
              para la implemectacion del Proyecto</font></th>
          </tr>
          <tr> 
            <th width="180" rowspan="2" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">ACTIVIDADES</font></th>
            <th width="300" rowspan="2" nowrap bgcolor="#006699"><p><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">PLANIFICACION 
                <br>
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
			
		$sql = "SELECT *,DATE_FORMAT(Fecha_planif, '%d/%m/%Y') AS Fecha_planif FROM solicproyplanif WHERE Codigo='$Codigo'";
		$result=mysql_query($sql);
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
			<td><div align="center">&nbsp;<?php echo $row['Fecha_planif']?></div></td>
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
                <input name="Responsabilid" type="text" size="30" maxlength="40">
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
            <td width="278" height="7" nowrap><div align="center"> 
                <textarea name="Observac" cols="35"></textarea>
              </div></td>
            <td width="52" nowrap><div align="center"> <?php echo date("d/m/Y");?></div></td>
          </tr>
          <tr> 
            <td height="28" colspan="8" nowrap> <div align="center"> 
                <input name="reg_form" type="submit" id="reg_form3" value="INSERTAR DATOS"  <?php print $valid->onSubmit(); ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="RETORNAR" value="RETORNAR">
              </div></td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
  <?php } ?>
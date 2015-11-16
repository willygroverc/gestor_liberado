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
if (isset($_REQUEST['RETORNAR'])) {$var=$_REQUEST['var'];header("location: solicproyecto1_last.php?Codigo=$var");}
elseif (isset($_REQUEST['reg_form']))
	{	require("conexion.php");
                $var=$_REQUEST['var'];
                $Responsabilid=$_REQUEST['Responsabilid'];
                $Actividades=$_REQUEST['Actividades'];
                $Aprobacion=$_REQUEST['Aprobacion'];
                $Observac=$_REQUEST['Observac'];
		$sql6= "SELECT * FROM solicproycierre WHERE Codigo='$var' AND Responsabilid='$Responsabilid'";
		$result6=mysql_query($sql6);
		$row6=mysql_fetch_array($result6);
		
		if(!$row6['Codigo'] && !$row6['Responsabilid'])
		{	$sql="INSERT INTO ".
			"solicproycierre (Codigo,Responsabilid,Actividades,Aprobacion,Observac) ".
			"VALUES ('$var','$Responsabilid','$Actividades','$Aprobacion','$Observac')";
			mysql_query($sql);
			header("location: solicproyecto6_last.php?Codigo=$var");
		}
		else
		{	$sql="UPDATE solicproycierre SET Actividades='$Actividades',Aprobacion='$Aprobacion',".
				"Observac='$Observac' WHERE Codigo='$var' AND Responsabilid='$Responsabilid'";
			mysql_query($sql);
			header("location: solicproyecto6_last.php?Codigo=$var");
		}	
}
else { 
include("top.php");
$Codigo=($_GET['Codigo']);
if (isset($_GET['Respon']))
	$Respon=($_GET['Respon']);
$sql0 = "SELECT * FROM solicproydatos WHERE Codigo='$Codigo'";
$result0=mysql_query($sql0);
$row0=mysql_fetch_array($result0);

require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "Responsabilid",  "Actividades, $errorMsgJs[empty]" );
$valid->addIsTextNormal ( "Actividades",  "Cierre, $errorMsgJs[expresion]" );
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
                DE PROYECTOS - MODIFICACION FASE DE CIERRE</strong></font></div></td>
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
            <th width="300" rowspan="2" nowrap bgcolor="#006699"><p><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">CIERRE</font><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><br>
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
			
		$sql = "SELECT *,DATE_FORMAT(Fecha_cier, '%d/%m/%Y') AS Fecha_cier FROM solicproycierre WHERE Codigo='$Codigo'";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr align="center"> <?php echo "<td><a href=\"solicproyecto6_last.php?Codigo=$Codigo&Respon=".$row['Responsabilid']."\">".$row['Responsabilid']."</a></td>";?> 
            <td><div align="center">&nbsp;<?php echo $row['Actividades']?>&nbsp;</div></div> 
            </td>
            <?php if  ($row['Aprobacion']>="SI") {echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";
												 echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";}
			  elseif ($row['Aprobacion']>="NO"){echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";
				   							       echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}?>
            <td><div align="center">&nbsp;<?php echo $row['Observac']?></div></td>
			<td><div align="center">&nbsp;<?php echo $row['Fecha_cier']?></div></td>
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
                  <option value="0"></option>
                  <?php 
			  $sql4 = "SELECT *,DATE_FORMAT(Fecha_cier, '%d/%m/%Y') AS Fecha_cier FROM solicproycierre WHERE Codigo='$Codigo' AND Responsabilid='$Respon'";
			  $result4 = mysql_query($sql4);
			  $row4 = mysql_fetch_array($result4); 
			  
			  $sql = "SELECT * FROM solicproycontrol WHERE Codigo='$Codigo'";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{
				if ($row4['Responsabilid']==$row['Responsabilid'])
					echo '<option value="'.$row['Responsabilid'].'" selected> $row[Responsabilid] </option>';
				else
					echo '<option value="'.$row['Responsabilid'].'">'.$row['Responsabilid'].'</option>';
	            }
				?>
                </select>
                </font> </strong> </div></td>
            <td width="300" nowrap height="7"><div align="center"><strong> 
                <input name="Actividades" type="text" value="<?php echo $row4['Actividades']?>" size="50" maxlength="50">
                <font size="2" face="Arial, Helvetica, sans-serif"> </font> </strong></div></td>
            <td height="7" colspan="2" nowrap> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
                SI &nbsp; 
                <input type="radio" name="Aprobacion" value="SI" <?php if ($row4['Aprobacion']=="SI") echo "checked";?>>
                <br>
                NO 
                <input name="Aprobacion" type="radio" value="NO" 
				<?php if ($row4['Aprobacion']=="NO") 
				{echo "checked";}
				if (!$row4['Aprobacion']) 
				{echo "checked";}
				?>>
                </font> </strong></div></td>
            <td width="290" height="7" nowrap><div align="center"> 
                <textarea name="Observac" cols="35"><?php echo $row4['Observac']?></textarea>
              </div></td>
            <td width="52" nowrap><div align="center"> 
                <?php if (!isset($Respon)){echo date("d/m/Y");} else {echo $row4['Fecha_cier'];}?>
              </div></td>
          </tr>
          <tr> 
            <td height="28" colspan="8" nowrap> <div align="center"><br>
                <input name="reg_form" type="submit" id="reg_form3" value="MODIFICAR DATOS ACTIVIDAD" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
              </div></td>
          </tr>
        </table>
        
        
      </td>
    </tr></form>
  </table>
  <?php } ?>
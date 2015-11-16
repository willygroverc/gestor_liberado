<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		14/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($RETORNAR)){header("location: lista_controltemp.php");}
if (isset($GUARDATOS))
{   require("conexion.php");
$fecha="$Ano-$Mes-$Dia";
$hora="$a";

   	$sql6="UPDATE controltemp SET numero='$a2',hora='$hora',fecha='$fecha',temperatura='$temperatura',hr='$hr',nombresp='$nombresp',observ='$observ'".
	"WHERE numero='$var'";
	mysql_query($sql6);
	header("location: lista_controltemp.php");
}
include("top.php");
$id_infAST=($_GET['numero']);
$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM controltemp WHERE numero='$numero'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
?> 
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsTime ( "horas","minutos" ,"Hora $errorMsgJs[time]" );
$valid->addIsDate   ( "Dia", "Mes", "Ano", "Fecha, $errorMsgJs[date]" );
$valid->addIsNumber ( "temperatura",  "Temperatura, $errorMsgJs[number]" );
$valid->addIsNumber ( "hr",  "Humedad Relativa, $errorMsgJs[number]" );
$valid->addIsNotEmpty ( "nombresp",  "Nombre Responsable, $errorMsgJs[empty]" );
$valid->addLength ( "observ",  "Observaciones, $errorMsgJs[length]" );
$valid->addFunction ( "verifica_temperatura", "" );
$valid->addFunction ( "verifica_humedad", "" );
print $valid->toHtml ();
?>  
<script language="JavaScript">
<!--
function verifica_temperatura () {
	var form = document.form1;
  	if ( form.temperatura ) {
		if (form.temperatura.value > 45)
			{ alert ("Temperatura, debe ser menor a 45ºC.\n \nMensaje generado por GesTor F1.");
			return false;}
		return true;	  
	}
}
function verifica_humedad () {
	var form = document.form1;
  	if ( form.hr ) {
		if (form.hr.value > 100)
			{ alert ("Humedad Relativa, debe ser menor a 100.\n \nMensaje generado por GesTor F1.");
			return false;} 
		return true;	  
	}
}
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
<form name="form1" method="post" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
  <input name="var" type="hidden" value="<?php echo $numero;?>">
  <table width="83%" border="2" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
    <tr> 
      <td colspan="7" bgcolor="#006699" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">CONTROL 
          DE TEMPERATURA Y HUMEDAD RELATIVA</font></div></td>
    </tr>
    <tr bgcolor="#006699"> 
      <td background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">N</font></div></td>
      <td background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">HORA</font></div></td>
      <td background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA</font></div></td>
      <td background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">TEMPERATURA</font></div></td>
      <td background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">HUMEDAD 
          RELATIVA</font></div></td>
      <td background="images/main-button-tileR2.jpg"> <div align="center"><font color="#FFFFFF" size="1">NOMBRE RESPONSABLE</font></div></td>
      <td background="images/main-button-tileR2.jpg"> <div align="center"><font color="#FFFFFF" size="1">OBSERVACIONES</font></div></td>
    </tr>
    <tr> 
      <td><div align="center">&nbsp;<?php echo $row['numero'];?></div></td>
      <td><div align="center">&nbsp;<?php echo $row['hora'];?></div></td>
      <td><div align="center">&nbsp;<?php echo $row['fecha'];?></div></td>
      <td><div align="center">&nbsp;<?php echo $row['temperatura'];?></div></td>
      <td><div align="center">&nbsp;<?php echo $row['hr'];?></div>

        </td>
      <td><div align="center"><?php echo $row['nombresp'];?>&nbsp;</div></td>
      <td colspan="7"><div align="center"><?php echo $row['observ'];?>&nbsp;</div>
        </td>
    </tr>
    <tr> 
      <td colspan="7">&nbsp;</td>
    </tr>
  </table>
  <table width="83%" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <td width="32%" height="19" background="images/main-button-tileR2.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">HORA</font></div></td>
      <td width="27%" background="images/main-button-tileR2.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA</font></div></td>
      <td width="41%" background="images/main-button-tileR2.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">TEMPERATURA 
          (&ordm;C) </font></div></td>
    </tr>
    <tr> 
      <td><div align="center"> 
          <div align="center"><?php echo $row['hora'];?></div>
        </div></td>
      <td><div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
          <select name="Dia" id="select9">
            <?php  $a2=substr($row['fecha'],5,4);
					$m2=substr($row['fecha'],3,2);
					$d2=substr($row['fecha'],0,2);
				for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($d2=="$i")echo "selected";echo">$i</option>";
				}
				?>
          </select>
          <select name="Mes" id="select10">
            <?php
				for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m2=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
          </select>
          <select name="Ano" id="select11">
            <?php for($i=2004;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a2=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
          </select>
          </font><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
          </font></strong></div></td>
      <td><div align="center"> 
          <input name="temperatura" type="text" value="<?php echo $row['temperatura'];?>" size="10" maxlength="3" >
        </div></td>
    </tr>
    <tr> 
      <td background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">HUMEDAD 
          RELATIVA (%)</font></div></td>
      <td background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">NOMBRE 
          RESPONSABLE</font></div></td>
      <td background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></div></td>
    </tr>
    <tr> 
      <td> <div align="center"> 
          <input name="hr" type="text" value="<?php echo $row['hr'];?>" size="10" maxlength="3">
        </div></td>
      <td> <div align="center"> 
          <select name="nombresp" id="select12">
            <option value="0"></option>
            <?php 
			  $link = mysql_connect($host,$user,$pass) or die ("Error durante la conexion a la base de datos"); 
			  $sql8 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			  $result8 = mysql_query($sql8);
			  while ($row8 = mysql_fetch_array($result8)) 
				{
				echo "<option value=\"$row8[login_usr]\"";
				if ($row8['login_usr']==$row['nombresp']) echo "selected";
				echo " >$row8[apa_usr] $row8[ama_usr] $row8[nom_usr]</option>";
	            }
			   ?>
          </select>
        </div></td>
      <td> <div align="center"> 
          <textarea name="observ" cols="20"><?php echo $row['observ'];?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td colspan="3"><div align="center">
	  <br>
          <input type="submit" name="GUARDATOS" value="GUARDAR CAMBIOS" <?php print $valid->onSubmit() ?>>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input type="submit" name="RETORNAR" value="RETORNAR">
          <input type="hidden" name="a" value="<?php echo $row['hora'];?>">
          <input type="hidden" name="a2" value="<?php echo $row['numero'];?>">
        </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p align="center">&nbsp; </p>
  <tr>
    <td colspan="1"><blockquote>
        
</form>
<strong> </strong><br>
  <script language="JavaScript">
		<!-- 
		 var form="form1";
		 var cal = new calendar1(document.forms[form].elements['Dia'], document.forms[form].elements['Mes'], document.forms[form].elements['Ano']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
//-->
</script>
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
{   include("conexion.php");	
	$fecha="$Ano-$Mes-$Dia";
	 $hora="$horas:$minutos";
   	$sql2= "INSERT INTO controltemp (hora,fecha,temperatura,hr,nombresp,observ)".
	"VALUES ('$hora','$fecha','$temperatura','$hr','$nombresp','$observ')";
	mysql_query($sql2);
	header("location: controltemp.php?varia1=$var");
}
//else{
include("top.php");
$numero=($_GET['varia1']);
?> 
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsTime ( "horas","minutos" ,"Hora, $errorMsgJs[time]" );
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
  <table width="83%" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <td colspan="6" background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>CONTROL 
          DE TEMPERATURA Y HUMEDAD RELATIVA</strong></font></div></td>
    </tr>
    <tr> 
      <td width="14%" background="images/main-button-tileR1.jpg"> <div align="center"></div>
        <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">HORA</font></div></td>
      <td width="14%" background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA</font></div></td>
      <td width="13%" background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">TEMPERATURA</font></div></td>
      <td width="19%" background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">HUMEDAD 
          RELATIVA</font></div></td>
      <td width="19%" background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">NOMBRE 
          RESPONSABLE</font></div></td>
      <td width="21%" background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></div>
        <div align="center"></div></td>
    </tr>
   
	 <?php
		$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM controltemp WHERE numero>='$numero' ORDER BY numero ASC";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
		  <tr> 
         <td>&nbsp;<?php echo $row['hora'];?></td>
      <td>&nbsp;<?php echo $row['fecha'];?></td>
       <td>&nbsp;<?php echo $row['temperatura'];?></td>
      <td>&nbsp;<?php echo $row['hr'];?></td>
	<?php	 $sql5 = "SELECT * FROM users WHERE login_usr='$row[nombresp]'";
		 $result5 = mysql_query($sql5);
		 $row5 = mysql_fetch_array($result5);
		 echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";?>
    <td>&nbsp;<?php echo $row['observ'];?></td>
    </tr>
	  <?php 
		 }
		 ?>
    <tr> 
      <td colspan="6">&nbsp;</td>
    </tr>
  </table>
  
  <table width="83%" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <td width="32%" height="19" background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">HORA</font></div></td>
      <td width="27%" background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA</font></div></td>
      <td width="41%" background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">TEMPERATURA 
          (&ordm;C) </font></div></td>
    </tr>
    <tr> 
      <td><div align="center"> 
          <div align="center"></div>
          <div align="center"> 
            <input name="horas" type="text" value="<?php echo date("H"); ?>" size="2" maxlength="2" >
            <strong>:</strong> 
            <input name="minutos" type="text" value="<?php echo date("i");?>" size="2" maxlength="2">
          </div>
        </div></td>
      <td><div align="center"> 
	   <?php $fsist=date("Y-m-d"); ?>
          <select name="Dia" >
            <?php
  				$a1=substr($fsist,0,4);
				$m1=substr($fsist,5,2);
				$d1=substr($fsist,8,2);
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
					}
				?>
          </select>
          <select name="Mes">
            <?php
				for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
				?>
          </select>
          <select name="Ano">
            <?php
				for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
          </select>
          <font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></div></td>
      <td><div align="center"> 
          <input name="temperatura" type="text" size="5" maxlength="3">
        </div></td>
    </tr>
    <tr> 
      <td background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">HUMEDAD 
          RELATIVA (%)</font></div></td>
      <td background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">NOMBRE 
          RESPONSABLE</font></div></td>
      <td background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></div></td>
    </tr>
    <tr> 
      <td> <div align="center"> 
          <input name="hr" type="text" size="5" maxlength="3">
        </div></td>
      <td> <div align="center"> 
          <select name="nombresp" id="select">
            <option value="0"></option>
            <?php 
			  require ("conexion.php");
			  $sql1 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			  $result1 = mysql_query($sql1);
			  while ($row1 = mysql_fetch_array($result1)) 
				{
				echo "<option value=\"$row1[login_usr]\">$row1[apa_usr] $row1[ama_usr] $row1[nom_usr]</option>";
	            }
			   ?>
          </select>
        </div></td>
      <td> <div align="center"> 
          <textarea name="observ" cols="20"></textarea>
        </div></td>
    </tr>
    <tr> 
      <td colspan="3"><div align="center"> 
	  <br> 
          <input name="GUARDATOS" type="submit" id="GUARDATOS" value="INSERTAR" <?php print $valid->onSubmit() ?>>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input type="submit" name="RETORNAR" value="RETORNAR">
        </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p align="center">&nbsp;</p>
  <tr>
    <td colspan="1"><blockquote>
  <?php //} ?>       
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
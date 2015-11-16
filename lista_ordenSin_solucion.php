<?php
session_start();
$login_usr = $_SESSION["login"]; 

include("top.php");


?><head>
<meta http-equiv="content-type" content="text/xml; charset=utf-8" />
<title>The Coolest DHTML Calendar - Online Demo</title>
<link rel="stylesheet" type="text/css" media="all" href="fecha/calendar-win2k-1.css" title="win2k-1" />
<style type="text/css">
<!--
body          {font-family: Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}
th            {font-family: Arial, Helvetica, sans-serif; font-size: small; font-weight: bolder; color: #FFFFFF; background-color: #006699}
.th2           {font-family: Arial, Helvetica, sans-serif; font-size: 10; font-weight: bolder; color: #FFFFFF; background-color: #006699}
td            {font-family: Arial, Helvetica, sans-serif; font-size: xx-small;}
form          {font-family: Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}
input         {font-family: Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}
select        {font-family: Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}
textarea	  {font-family: Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}
.menu 	  	  {font-family: Arial, Helvetica, sans-serif; font-size: xx-small; color: #FFFFFF; background-color: #006699}		
.menu2 	  	  {font-family: Arial, Helvetica, sans-serif; font-size: xx-small; color: #999999; background-color: #006699}		
.normal       {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}

//-->
</style>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$fecha_a=
print $valid->toHtml ();
$alerta=$alerta;
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
 <input name="var2" type="hidden" value="<?php echo $var2;?>">
 <?php

//$result = mysql_query("SELECT * FROM conformidad WHERE tipo_conf != '1' and tipo_conf != '2'", $link);
/*$sql = mysql_query("SELECT solucion.id_orden, users.email FROM solucion, users WHERE (solucion.id_orden NOT IN (SELECT conformidad.id_orden FROM conformidad)) and users.login_usr = solucion.login_usr", $link);*/

$result = mysql_query("SELECT DISTINCT (a.id_orden) AS ordenes, b.email, a.fecha_asig, asig, diagnos, fechaestsol_asig FROM asignacion a, users b WHERE (a.asig = b.login_usr) AND id_orden NOT IN (SELECT id_orden FROM solucion)", $link);

//$row: es la fecha de las ordenes

?> 
 <table width="80%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg">
		<tr align="center">
    <th colspan="12">LISTA DE ORDENES SIN CONFORMIDAD </th>
  </tr>
        <tr>
          <td width="5%" class="menu" align="center">ID-ORDEN</td>
		  <td width="17%" class="menu" align="center">E-MAIL</td>
          <td width="12%" class="menu" align="center">FECHA DE ASIGNACION</td>
          <td width="16%" class="menu" align="center">FECHA ESTIMADA DE SOLUCION</td>
          <td width="38%" class="menu" align="center">DIAGNOSTICO</td>
	      <td width="12%" class="menu" align="center">FECHA ESTIMADA DE SOLUCION</td>
   </tr>
		 <?php
		 $cont=0;
		 $color="bgcolor=\"#FFFF00\"";
		 while($datos=mysql_fetch_array($result))
		 {
		 $cont++;
		 echo "<tr align=\"center\">";
		 echo "<td ".$color.">&nbsp;$datos[0]</td>";
		 echo "<td>&nbsp;$datos[1]</td>";
		 echo "<td>&nbsp;$datos[2]</td>";
		 echo "<td>&nbsp;$datos[3]</td>";
		 echo "<td>&nbsp;$datos[4]</td>";
		 echo "<td>&nbsp;$datos[5]</td>";
		 echo "</tr>";
		 }
		 ?>	
		 <tr>
		 	 <td colspan="6"><div align="center"><br>
				<input type="button" value="ENVIAR CORREOS" onClick=" window.location.href='lista_ordenSin_sol.php' ">
			 </div></td>
		 </tr>			  
</table>

<?php include("top_.php");
?> 

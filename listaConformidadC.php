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

$result = mysql_query("SELECT users.email, solucion.id_orden, solucion.detalles_sol, solucion.fecha_sol, solucion.hora_sol, solucion.login_sol FROM solucion, users WHERE (solucion.id_orden NOT IN (SELECT conformidad.id_orden FROM conformidad)) and (users.login_usr = solucion.login_sol)", $link);

//$row: es la fecha de las ordenes

?> 
 <table width="80%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg">
		<tr align="center">
    <th colspan="12">LISTA DE SOLUCIONES SIN CONFORMIDAD</th>
  </tr>
        <tr>
          <td width="6%" class="menu" align="center">ID-ORDEN</td>
		  <td width="14%" class="menu" align="center">E-MAIL</td>
          <td width="50%" class="menu" align="center">DETALLE SOLUCION</td>
          <td width="11%" class="menu" align="center">FECHA DE SOLUCION</td>
          <td width="11%" class="menu" align="center">HORA SOLUCION</td>
	      <td width="25%" class="menu" align="center">USUARIO SOLUCION</td>
  	     </tr>
		 <?php
		 while($datos=mysql_fetch_array($result))
		 {
		 ?>
		 <tr>
		 	<td align="center"><?php echo $datos[1]; ?> </td>
			<td align="center"><?php echo $datos[0]; ?> </td>
			<td align="center"><?php echo $datos[2]; ?> </td>
			<td align="center"><?php echo $datos[3]; ?> </td>
			<td align="center"><?php echo $datos[4]; ?> </td>
			<td align="center"><?php echo $datos[5]; ?> </td>
		 </tr>
		 <?php
		 }
		 ?>	
		 <tr>
		 	 <td colspan="6"><div align="center"><br>
				<input type="button" value="ENVIAR CORREOS" onClick=" window.location.href='listaconformidad.php' ">
			 </div></td>
		 </tr>			  
</table>

<?php include("top_.php");
?> 

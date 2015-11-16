<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
require('conexion.php');
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($_REQUEST['cmdnuevo'])) { header("location:area_nuevo.php?pg=$pg"); }

if(isset($_REQUEST['elim']) && $_REQUEST['elim']=='ok')
{
    $area_cod=$_REQUEST['area_cod'];
	//echo "<br>codigo : ".$area_cod;
	/*$acon = "select *from dominio where id_area=$area_cod ";
	$aresult = mysql_query($acon);
	$numarea = mysql_num_rows($aresult); 
	if($numarea == 0)
	{*/
	
			$sql_eli="DELETE FROM area WHERE area_cod='$area_cod'";
			mysql_query($sql_eli);
			
			$cont="NULL";
			$sql="SELECT * FROM dominio WHERE id_area ='$area_cod'";
			$res=mysql_query($sql);
			while($row=mysql_fetch_array($res)){
				$cont.=", '$row[id_dominio]'";
			}
			
			$cont=str_replace("NULL, ","",$cont);
			$sql_eli1="DELETE FROM dominio WHERE id_area='$area_cod'";
			mysql_query($sql_eli1);
			$sql_eli2="DELETE FROM objetivos WHERE id_dominio IN ($cont)";
			mysql_query($sql_eli2);
	//}
	/*else
	{ 
		$msg = "Hubo un error";
		header("location: area.php?msg=$msg");	
	}*/

}
include('top.php');
include ("menu_tipo.php");
?>
<html>
<head>
<title>Areas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<div align="center">
  
<table  width="80%" border="1" background="images/fondo.jpg" >
   
  <tr bgcolor="#006699"> 
    <th colspan="5" background="images/main-button-tileR1.jpg" height="22"><div align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">NIVEL 1</font></div></th>
  </tr>
  <tr bgcolor="#006699"> 
    <td  class="menu" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">Nro.</font></div></td>
    <td class="menu" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">NOMBRE</font></div></td>
    <td class="menu" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">DESCRIPCION</font></div></td>
    <td class="menu" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">MODIFICAR</font></div></td>
    <td class="menu" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">ELIMINAR</font></div></td>
  </tr>
  <?php
	$i=1;
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);
	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}
	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM area";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);
	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM area";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);
	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	$sql="SELECT * FROM area LIMIT $_pagi_inicial,$_pagi_cuantos";
	$datos=mysql_query($sql);
	while ($area=mysql_fetch_array($datos)) {
	?>
  <tr> 
  
    <td><div align="center"><?php echo $i; ?></div></td>
    <td><div align="center"><?php echo $area['area_nombre']; ?></div></td>
    <td><div align=""><span>&nbsp;<?php echo $area['area_desc']; ?></span></div></td>
    <td><div align="center"><?php echo "<a href=area_nuevo.php?Naveg=Modificacion%20Areas&cod=".$area['area_cod']."&pg=".@$pg."><img src=images/editar.gif width=16 height=14 border=0></a>"; ?></div></td>
    <td><div align="center"><?php echo "<a href=area.php?elim=ok&Naveg=Areas&area_cod=".$area['area_cod']."&pg=".@$pg." onclick=\"return elimina('$area[area_cod]','$area[area_nombre]')\"><img src=images/eliminar.gif width=16 height=14 border=0></a>"; ?></div></td>
	
  </tr>
  <?php
	$i++;
	}
	?>
</table>
  <form name="form" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
    
  <table width="75%" border="0">
    <tr> 
      <td width="47%"> <div align="center"> 
          <input name="cmdnuevo" type="submit" id="cmdnuevo" value="NUEVO NIVEL">
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input name="IMPRIMIR" type="button" id="IMPRIMIR" value="IMPRIMIR" onClick="imprimir()">
        </div></td>
    </tr>
  </table>
  </form>
  <p><strong>P&aacute;gina(s):</strong> 
    <?php
//La idea es pasar tambi�n en los enlaces las variables hayan llegado por url.
$_pagi_enlace = $_SERVER['PHP_SELF'];
$_pagi_query_string = "?";
if(isset($_GET)){
	//Si ya se han pasado variables por url, escribimos el query string concatenando
	//los elementos del array $_GET excepto la variable $_GET['pg'] si es que existe.
	$_pagi_variables = $_GET;
	foreach($_pagi_variables as $_pagi_clave => $_pagi_valor){
		if($_pagi_clave != 'pg'){
			$_pagi_query_string .= $_pagi_clave."=".$_pagi_valor."&";
		}
	}
}

//A�adimos el query string a la url.
$_pagi_enlace .= $_pagi_query_string;

//La variable $_pagi_navegacion contendr� los enlaces a las p�ginas.
$_pagi_navegacion = '';

if ($_pagi_actual != 1){
	//Si no estamos en la p�gina 1. Ponemos el enlace "anterior"
	$_pagi_url = $_pagi_actual - 1;//ser� el n�mero de p�gina al que enlazamos
	$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_url."'>&laquo; Anterior</a>&nbsp;";
}
//Enlaces a n�meros de p�gina:
for ($_pagi_i = 1; $_pagi_i<=$_pagi_totalPags; $_pagi_i++){//Desde p�gina 1 hasta �ltima p�gina ($_pagi_totalPags)
    if ($_pagi_i == $_pagi_actual) {
		//Si el n�mero de p�gina es la actual ($_pagi_actual). Se escribe el n�mero, pero sin enlace y en negrita.
        $_pagi_navegacion .= "<b>&nbsp;$_pagi_i&nbsp;</b>";
    }else{
		//Si es cualquier otro. Se escibe el enlace a dicho n�mero de p�gina.
        $_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_i."'>".$_pagi_i."</a>&nbsp;";
    }
}

if ($_pagi_actual < $_pagi_totalPags){
	//Si no estamos en la �ltima p�gina. Ponemos el enlace "Siguiente"
    $_pagi_url = $_pagi_actual + 1;//ser� el n�mero de p�gina al que enlazamos
    $_pagi_navegacion .="<a href='".$_pagi_enlace."pg=".$_pagi_url."'>Siguiente &raquo;</a>";
}
print $_pagi_navegacion;
//Hasta ac� hemos completado la "barra de navegaci�n"
?>
  </p>
</div>
</body>
</html>
<script language="JavaScript" type="text/JavaScript">
<!--
function elimina(id,num){
	if(confirm("Esto eliminar� todos los subniveles asociados al �rea elegida \nDesea realmente eliminar el �rea "+num+" y todos los subniveles? .\n \nMensaje generado por GesTor F1. "))
	{return true;
	}else{ return false;}
}
function imprimir(){
	open("imprimir_area.php","boris",'width=800,height=600,status=yes,resizable=yes,top=50,left=50,scrollbars=yes,toolbars=yes,dependent=yes,alwaysRaised=yes')
}
-->
</script>

<script language="JavaScript">
		<!-- 
		<?php if (isset($msg)) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GestorF1.\");\n";
		} ?>
		-->
</script>

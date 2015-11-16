<?php 
if (isset($RETORNAR)){header("location: pistas_auditoria.php?Naveg=Cambios >> Administracion de Fuentes >> Pistas de Auditoria");}
include ("top.php");
?>
<table width="80%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
    <td height="68" valign="top">
	<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="6" background="images/main-button-tileR1.jpg" height="22">PISTAS DE AUDITORIA</th>
        </tr>
        <tr align=\"center\"> 
          <th class="menu" width="50" align="center" background="images/main-button-tileR1.jpg" height="22">Nro. DE PISTA</th>
		  <th class="menu" width="100" align="center" background="images/main-button-tileR1.jpg" height="22">FECHA</th>
  		  <th class="menu" width="100" align="center" background="images/main-button-tileR1.jpg" height="22">HORA</th>
   		  <th class="menu" width="200" align="center" background="images/main-button-tileR1.jpg" height="22">NOMBRE DEL ARCHIVO</th>
   		  <th class="menu" width="200" align="center" background="images/main-button-tileR1.jpg" height="22">DESCRIPCION</th>
   		  <th class="menu" width="50" align="center" background="images/main-button-tileR1.jpg" height="22">RESTAURAR</th>
        </tr>
        <?php
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_db_query($db,$sql11,$link);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos = 20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM registro_pistas";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;

$fechahoy=date("Y-m-d");
$sql = "SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM registro_pistas ORDER BY id_pista DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
$result=mysql_db_query($db,$sql,$link); 
while ($row=mysql_fetch_array($result)) {
  	echo "<tr align=\"center\">";
	echo "<td><font size=\"1\">&nbsp;$row[id_pista]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[fecha_pista2]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[hora_pista2]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[nombre_pista]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[desc_pista]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"pistas_fuentes3.php?id_pista=".$row['id_pista']."\"><img src=\"images/ver.gif\" border=\"0\" alt=\"Ver\"></a></font></td>";
}
?>
      </table></td>
  </tr>
</table>
  
<br>
  <form name="form1" method="post" action="">
  <table width="75%" border="0" align="center">
    <tr> 
      <td><div align="center"> 
          <p><font size="2"><strong> Pagina(s) :&nbsp; 
            <?php
//La idea es pasar también en los enlaces las variables hayan llegado por url.
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

//Anadimos el query string a la url.
$_pagi_enlace .= $_pagi_query_string;

//La variable $_pagi_navegacion contendrá los enlaces a las páginas.
$_pagi_navegacion = '';

if ($_pagi_actual != 1){
	//Si no estamos en la página 1. Ponemos el enlace "anterior"
	$_pagi_url = $_pagi_actual - 1;//será el numero de página al que enlazamos
	$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_url."'>&laquo; Anterior</a>&nbsp;";
}
//Enlaces a numeros de página:
for ($_pagi_i = 1; $_pagi_i<=$_pagi_totalPags; $_pagi_i++){//Desde página 1 hasta ultima página ($_pagi_totalPags)
    if ($_pagi_i == $_pagi_actual) {
		//Si el numero de página es la actual ($_pagi_actual). Se escribe el numero, pero sin enlace y en negrita.
        $_pagi_navegacion .= "<b>&nbsp;$_pagi_i&nbsp;</b>";
    }else{
		//Si es cualquier otro. Se escibe el enlace a dicho numero de página.
        $_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_i."'>".$_pagi_i."</a>&nbsp;";
    }
}

if ($_pagi_actual < $_pagi_totalPags){
	//Si no estamos en la ultima página. Ponemos el enlace "Siguiente"
    $_pagi_url = $_pagi_actual + 1;//será el numero de página al que enlazamos
    $_pagi_navegacion .="<a href='".$_pagi_enlace."pg=".$_pagi_url."'>Siguiente &raquo;</a>";
}
print $_pagi_navegacion;
//Hasta acá hemos completado la "barra de navegacion"
?>
        </font></strong> <font size="2"><strong>&nbsp;</strong></font></div></td>
  </tr>
</table>
<br>
<form name="form3" method="post" action="">
<table width="90%" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="46%"> <div align="center">
          <input type="submit" name="RETORNAR" value="RETORNAR">
        </div></td>
    </tr>
</table>
</form>
<?php 
	include("top_.php");
?> 

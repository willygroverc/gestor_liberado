<?php
include ( "conexion.php" );
session_start();
$login = $_SESSION["login"];
if (isset($retornar)){ header("location: admi_fuentes.php?Naveg=Cambios >> Administracion de Fuentes");}
if (isset($nuevo)){ header("location:backups.php");}
if(!isset($orden))
{$orden = "id_back DESC";}
include("top.php");
include ( "funciones.inc.php" );
?>	
<table width="90%" align="center" background="images/fondo.jpg" border="1">
    <tr bgcolor="#006699"> 
      <td colspan="9" align="center" background="images/main-button-tileR1.jpg"><font size="3" color="#FFFFFF" face="VERADNA, Helvetica, sans-serif"><strong>
	  	LISTADO DE BACKUPS</strong></font>
	  </td>	 
    </tr>
	<tr>
		<td width="28" align="center" background="images/main-button-tileR2.jpg">		
			<a class="menu" href="lista_backups.php?orden=id_back">
			<font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">Nro.</font>
			<?php if($orden == "id_back") echo "<img src=\"images/asc_order.gif\" border=0 width=7 height=7>"; ?>
			</a>								
		</td>
		<td width="182"  align="center" background="images/main-button-tileR2.jpg">
			<a class="menu" href="lista_backups.php?orden=nom_back">
			NOMBRE BACKUP 
			<?php if($orden=="nom_back") echo "<img src=\"images/asc_order.gif\" border=0 width=7 height=7 >"; ?>
			</a>		
		</td>
		<td width="128" align="center" background="images/main-button-tileR2.jpg">
			<a  href="lista_backups.php?orden=tipo_back" class="menu">
			TIPO DE BACKUP
			<?php if($orden == "tipo_back") echo "<img src=\"images/asc_order.gif\" border=0 width=7 height=7>"; ?>
			</a>				
		
		</td>
		<td width="101"  align="center" background="images/main-button-tileR2.jpg" >
			<a class="menu" href="lista_backups.php?orden=fecha_creacion">
			<font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">FECHA CREACION</FONT>
			<?php if($orden=="fecha_creacion") 
			echo "<img src=\"images/asc_order.gif\" border=0 width=7 height=7>";?>			
			</a>
		</td>
		<td width="69" align="center" background="images/main-button-tileR2.jpg" CLASS="menu">
			<font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">	FECHA DEL</font>	
		</td>
		<td width="53" align="center" background="images/main-button-tileR2.jpg" CLASS="menu">
			<font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">	FECHA AL</font>	
		</td>
		<td width="90" align="center" background="images/main-button-tileR2.jpg" CLASS="menu">
			<font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF"><center>MEDIO</center></font>	
		</td>						
		<td width="119" align="center" background="images/main-button-tileR2.jpg" CLASS="menu">
			<font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">RESPONSABLE</font>	
		</td>
		<td width="50" align="center" background="images/main-button-tileR2.jpg" CLASS="menu">
			<font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">IMPRIMIR</font>
		</td>				
	</tr>		
<?php 
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_db_query($db,$sql11,$link);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM backups";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	
//=====end Pag.

$sql = "SELECT *, DATE_FORMAT(fecha_creacion, '%d/%m/%Y') AS fecha_creacion, DATE_FORMAT(fec_del_back, '%d/%m/%Y') AS fec_del_back, DATE_FORMAT(fec_al_back, '%d/%m/%Y') AS fec_al_back, c.tipo_medio as medio FROM backups as b, controlinvent as c
		WHERE b.id_medio = c.Codigo  ORDER BY $orden LIMIT $_pagi_inicial,$_pagi_cuantos";
	//echo $sql;
$res = mysql_db_query($db, $sql, $link);
while ( $fila = mysql_fetch_array($res))
{	$sql2 = "SELECT CONCAT(apa_usr, ' ', ama_usr, ' ',nom_usr ) AS nombre FROM users WHERE login_usr='$fila[login_back]'";
	$res2 = mysql_db_query($db, $sql2, $link);
	$row2 = mysql_fetch_array($res2);	
	if ( $fila['fec_del_back'] == "00/00/0000" ) $fila['fec_del_back'] = "&nbsp;";
	if ( $fila['fec_al_back'] == "00/00/0000" ) $fila['fec_al_back'] = "&nbsp;";
	echo "<tr align='center'>";
	echo "<td>$fila[id_back]</td>";
	echo "<td>$fila[nom_back]</td>";
	echo "<td>$fila[tipo_back] </td>";
	echo "<td>$fila[fecha_creacion]</td>";
	echo "<td>$fila[fec_del_back]</td>";
	echo "<td>$fila[fec_al_back]</td>";
	echo "<td>$fila[medio]</td>";
	echo "<td>$row2[nombre]</td>";
	echo "<td><a href=\"ver_backups.php?id_back=$fila[id_back]\" target=\"_blank\">";
	echo "<img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir Archivo\"></a></td>";		
	echo "</tr>";
} 
?>
</tr>
</table>
<br>
<table width="85%" border="0" align="center">
  <tr> 
    <td> <div align="center"><strong><font size="2">Pagina(s) :&nbsp; 
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

<center>
<form action="lista_backups.php" method="post" name="form1">
    <input type="submit" value="NUEVO BACKUP" name="nuevo">
    &nbsp;&nbsp;&nbsp; 
    <input type="button" value="IMPRIMIR" name="imprimir" onClick="Mostrar()">&nbsp;&nbsp;&nbsp;

</form>	
</center>
<?php 
include("top_.php");
?> 
<script language="JavaScript">
<!--
function Mostrar() {
	window.open("ver_backups_todos.php");
}
</script>				
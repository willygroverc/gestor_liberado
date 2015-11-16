<?php
require_once("funciones.php");
if (valida("Usuarios")=="bad") {header("location: pagina_error.php");}
if (isset($_REQUEST['RETORNAR'])){header("location: seguridad_opt.php?Naveg=Seguridad");}
if (isset($_REQUEST['NueUsuario']))
{ 	include("conexion.php");
	$sql5="SELECT MAX(IdControl) AS IdCont FROM control_usr";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);
	$IdC=$row5['IdCont']+1; 
	header("location: control_usr1.php?IdControl=$IdC");
}
include ("top.php");
?> 
<?php 
	include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("num","Numero");
	$help->AddHelp("numident","Numero de identificaciones");
/*	$help->AddHelp("conf","Conformidad de ...");
	$help->AddHelp("solu","Solucion a las ordenes de trabajo ...");
	$help->AddHelp("incidencia","Incidencia se refiere a...");*/
	print $help->ToHtml();
 ?>

<table width="80%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
    <td height="68" valign="top">
	<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
            <th colspan="7">LISTA DE CONTROL DE USUARIOS</font></th>
        </tr>
        <tr align=\"center\"> 
		<th class="menu"><?php print $help->AddLink("num", "Nro."); ?></th>
		<th class="menu">USUARIO</th>
		<th class="menu"><?php print $help->AddLink("numident", "Nro. DE IDENTIFICADORES"); ?></th>
		  <th class="menu">INSERTAR NUEVA APLICACION</th>
		<?php if ($tipo=="A" or $tipo=="B") {?>
		<th class="menu">MODIFICAR</th>
		          <?php }?>
		<th class="menu">IMPRIMIR</th>

        </tr>
        <?php   
		$sql11 = "SELECT num_ord_pag FROM control_parametros";
		$result11=mysql_db_query($db,$sql11,$link);
		$row11=mysql_fetch_array($result11);

		if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
		else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

		if (empty($_GET['pg'])){$_pagi_actual = 1;}
		else{$_pagi_actual = $_GET['pg'];}

		$_pagi_sqlConta = "SELECT COUNT(DISTINCT IdControl) AS pagi_totalReg FROM control_usr";
		$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
		$row9=mysql_fetch_array($result9);
		
		$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
		
		$sql3 = "SELECT * FROM control_usr GROUP BY IdControl DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
		$result3=mysql_db_query($db,$sql3,$link);
		while($row3=mysql_fetch_array($result3)){
		
			echo "<tr align=\"center\">";
			$sql5 = "SELECT * FROM users WHERE login_usr='$row3[NombreUsr]'";
	    	$result5 = mysql_db_query($db,$sql5,$link);
	    	$row5 = mysql_fetch_array($result5);
			if ($row5['tipo_usr'] =="INTERNO" AND $row5['bloquear']==0)   // INTERNO
			$color="bgcolor=\"#00CC00\"";
			elseif ($row5['tipo_usr']=="EXTERNO" AND $row5['bloquear']==0) // EXTERNO
			{$color="bgcolor=\"#FFFF00\"";}
			elseif ($row5['bloquear']==1) // BLOQUEADO
			{$color="bgcolor=\"#A5BBF5\"";}	
			elseif ($row5['bloquear']==2) // ELIMINADO
			{$color="bgcolor=\"#FF6666\"";}	
			else {$color="bgcolor=\"#00CC00\"";} // SI NO ENCUENTRA
			
			echo "<td ".$color." nowrap><font size=\"1\">$row3[IdControl]</font></td>";
			echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";
		 	$sql4 = "SELECT COUNT(*) AS Num FROM control_usr WHERE IdControl='$row3[IdControl]'";
			$result4=mysql_db_query($db,$sql4,$link);
			$row4=mysql_fetch_array($result4);
			echo "<td><font size=\"1\">$row4[Num]</font></td>";
			echo "<td><font size=\"1\"><a href=\"control_usr1.php?IdControl=".$row3['IdControl']."\"><img src=\"images/nuevo.gif\" border=\"0\" alt=\"Nueva Aplicacion\"></a></font></td>";
			if ($tipo=="A" or $tipo=="B")
			{echo "<td><font size=\"1\"><a href=\"control_usr_last.php?IdControl=".$row3['IdControl']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></font></td>";}
			echo "<td><font size=\"1\"><a href=\"ver_controlusr.php?variable=".$row3['IdControl']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";			
			echo "</tr>";
			}
?>
      </table></td>
  </tr>
</table>
<br>
<table width="85%" border="0" align="center">
  <tr> 
    <td> <div align="center"><strong><font size="2">Pagina(s) :&nbsp; 
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

//Anadimos el query string a la url.
$_pagi_enlace .= $_pagi_query_string;

//La variable $_pagi_navegacion contendr� los enlaces a las p�ginas.
$_pagi_navegacion = '';

if ($_pagi_actual != 1){
	//Si no estamos en la p�gina 1. Ponemos el enlace "anterior"
	$_pagi_url = $_pagi_actual - 1;//ser� el numero de p�gina al que enlazamos
	$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_url."'>&laquo; Anterior</a>&nbsp;";
}
//Enlaces a numeros de p�gina:
for ($_pagi_i = 1; $_pagi_i<=$_pagi_totalPags; $_pagi_i++){//Desde p�gina 1 hasta ultima p�gina ($_pagi_totalPags)
    if ($_pagi_i == $_pagi_actual) {
		//Si el numero de p�gina es la actual ($_pagi_actual). Se escribe el numero, pero sin enlace y en negrita.
        $_pagi_navegacion .= "<b>&nbsp;$_pagi_i&nbsp;</b>";
    }else{
		//Si es cualquier otro. Se escibe el enlace a dicho numero de p�gina.
        $_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_i."'>".$_pagi_i."</a>&nbsp;";
    }
}

if ($_pagi_actual < $_pagi_totalPags){
	//Si no estamos en la ultima p�gina. Ponemos el enlace "Siguiente"
    $_pagi_url = $_pagi_actual + 1;//ser� el numero de p�gina al que enlazamos
    $_pagi_navegacion .="<a href='".$_pagi_enlace."pg=".$_pagi_url."'>Siguiente &raquo;</a>";
}
print $_pagi_navegacion;
//Hasta ac� hemos completado la "barra de navegacion"
?>
        </font></strong> <font size="2"><strong>&nbsp;</strong></font></div></td>
  </tr>
</table>
<p>
<table width="80%" border="1" align="center">
  <tr> 
    <td width="15%" height="28"> 
      <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">USUARIO 
        CON CUENTA BLOQUEADA</font></div></td>
    <td width="5%" bgcolor="#A5BBF5">&nbsp;</td>
    <td width="5%">&nbsp;</td>
    <td width="15%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">USUARIO 
        INTERNO </font></div></td>
    <td width="5%" bgcolor="#00CC00">&nbsp;</td>
    <td width="5%">&nbsp;</td>
    <td width="15%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">USUARIO 
        EXTERNO </font></div></td>
    <td width="5%" bgcolor="#FFFF00">&nbsp;</td>
    <td width="5%">&nbsp;</td>
    <td width="15%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">USUARIO 
        ELIMINADO </font></div></td>
    <td width="5%" bgcolor="#FF6666">&nbsp;</td>
  </tr>
</table>
<form name="form1" method="post" action="">
  <input name="NueUsuario" type="submit" value="NUEVO USUARIO">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" name="IMPRIMIR" value="IMPRIMIR" onClick="openStat_1()">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</form>
<script language="JavaScript">
<!--
<?php
if($msg) print "alert(\"$msg\\n\\nMensaje generado por GesTor F1.\");"?>
function openStat_1() {	
	window.open("impresion_usr.php",'USR', 'width=600,height=160,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
-->
</script>
<?php include("top_.php");?>
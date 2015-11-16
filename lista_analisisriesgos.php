<?php 
// version: 	1.0
// Tipo: 		Perfectivo, Correctivo
// Objetivo:	Control acceso directo No autorizado.
//				Modificacion funciones php obsoletas para version 5.3
// Fecha:		22/NOV/2012 
// Autor:		Cesar Cuenca
//____________________________________________________________________________

@session_start();
$tipo=$_SESSION["tipo"];
if (isset($_REQUEST['Contrato']))
{ header("location: AnalisisRiesgoDat.php");}
	include ("top.php");
?>
<?php 
	include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("num","Numero de Formulario");
	print $help->ToHtml();
 ?>
<table width="90%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
    <td height="68" valign="top"><table width="100%" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="7" background="images/main-button-tileR1.jpg" height="24" bgcolor="#006699"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">PROYECTOS 
            - LISTA ANALISIS DE RIESGOS</font></th>
        </tr>
        <tr align=\"center\"> 
          <th width="48" background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><?php print $help->AddLink("num", "Nro. DE FORM."); ?></font></th>
          <th width="301" background="images/main-button-tileR2.jpg"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">NOMBRE 
            DEL PROYECTO</font></th>
          <th width="194" colspan="1" background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong> 
            NOMBRE DEL RESPONSABLE</strong></font></th>
          <th width="178" background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">DOCUMENTACION 
            DE REFERENCIA</font></th>
          <th width="62" background="images/main-button-tileR2.jpg" align="center"><p><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong>FECHA</strong></font></p></th>
           <?php if ($tipo=="A" or $tipo=="B") {?>
		  <th width="67" background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong>MODIFICAR</strong></font><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"></font></th>
		<?php }?>
		  <th width="67" background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong>IMPRIMIR</strong></font><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"></font></th>
        </tr>
        <?php
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM analisisriesgdatos";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	
    $fechahoy=date("Y-m-d");
	$sql = "SELECT *, DATE_FORMAT(FechaAnalisis, '%d/%m/%Y') AS FechaAnalisis FROM analisisriesgdatos ORDER BY IdAnalisis DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
	$result=mysql_query($sql); 
	while ($row=mysql_fetch_array($result)) {
  	echo '<tr align="center">';
	echo '<td><font size="1">&nbsp;'.$row['IdAnalisis'].'</font></td>';
	echo '<td><font size="1">&nbsp;'.$row['NombProy'].'</font></td>';
	$sql2 = "SELECT * FROM users WHERE login_usr='".$row['NombResp']."'";
	$result2 = mysql_query($sql2);
	$row2 = mysql_fetch_array($result2); 
	echo '<td><font size="1">&nbsp;'.$row2['nom_usr'].' '.$row2['apa_usr'].' '.$row2['ama_usr'].'</font></td>';
	echo '<td><font size="1">&nbsp;'.$row['DocuRef'].'</font></td>';
	echo '<td><font size="1">&nbsp;'.$row['FechaAnalisis'].'</font></td>';
	if($tipo=="A" or $tipo=="B")
	{echo "<td><font size=\"1\"><a href=\"AnalisisRiesgoDat_last.php?IdAnalisis=".$row['IdAnalisis']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></font></td>";}
	echo "<td><font size=\"1\"><a href=\"ver_anariesgos.php?variable=".$row['IdAnalisis']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";
	//echo "<td><font size=\"1\"><a href=\"ver_AdmyAseg.php?IdAdmyAseg=".$row[IdAdmyAseg]."&Tip=".$row[Tipo]."\">IMPRIMIR</a></font></td>";
}?>
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
<form name="form1" method="post" action="">
  <table width="90%" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="44%"> <div align="right">
          <input type="submit" name="Contrato" value="NUEVO FORMULARIO">
        </div>
        <div align="center"> </div></td>
      <td width="10%">&nbsp;</td>
      <td width="46%"> <div align="left">
          <input type="submit" name="RETORNAR" value="RETORNAR">
        </div></td>
    </tr>
  </table>
    </form>
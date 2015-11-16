<?php
if (empty($_REQUEST['a'])) { $_REQUEST['a']="";} else { $_REQUEST['a']=$_REQUEST['a'];}
if (empty($_REQUEST['d'])) { $_REQUEST['d']="";} else { $_REQUEST['d']=$_REQUEST['d'];}
if (empty($_REQUEST['pg'])) { $_REQUEST['pg']="";} else { $_REQUEST['pg']=$_REQUEST['pg'];}
$a=$_REQUEST['a'];
$d=$_REQUEST['d'];
$pg=$_REQUEST['pg'];
//if (isset($cmdvolver)) { header("location:lista_parametros_audi.php?Naveg=Par�metros de Auditor�a"); }
if (isset($_REQUEST['cmdnuevo']))
{
	header("location:objcon_nuevo.php?a=$a&d=$d&pg=$pg"); 
}
include('conexion.php');
if(isset($_REQUEST['elim'])=='ok'){
        $id_objetivo=$_REQUEST['id_objetivo'];
	$sql_eli="DELETE FROM objetivos WHERE id_objetivo='$id_objetivo'";
	mysql_db_query($db,$sql_eli,$link);
}
include('top.php');
include ("menu_tipo.php");
?>
<html>
<head>
<title>Objetivos de Control</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
-->
</script>
</head>

<body>
<div align="center"> 
  <form name="form1" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
    <table width="75%" border="1" background="images/fondo.jpg">
      <tr> 
        <th colspan="4" background="images/main-button-tileR1.jpg" height="22"><div align="center"><strong>NIVEL 3</strong></div></th>
      </tr>
      <tr> 
        <td width="25%"><div align="right" class="normal"><strong>Nivel 1:</strong></div></td>
        <td width="25%">
		<select name="txtarea" id="txtarea" onChange="MM_jumpMenu('parent',this,0)">
		<?php
		if ($a=='') { echo "<option>Seleccione una opci�n</option>"; }
		$sql_area="SELECT * FROM area ORDER BY area_nombre ASC";
		$datos_area=mysql_db_query($db,$sql_area,$link);
		while($area=mysql_fetch_array($datos_area)) {
		?>
			<option value=<?php echo "lista_objetivo.php?a=".$area['area_cod']; if ($a==$area['area_cod']) { echo " selected"; } ?> ><?php echo $area['area_nombre']; ?></option>
		<?php
		}
		?>
          </select></td>
        <td width="21%"><div align="right" class="normal"><strong>Nivel 2:</strong></div></td>
        <td width="29%">
		<select name="txtdominio" id="txtdominio" onChange="MM_jumpMenu('parent',this,0)">
		<?php
		if ($a=='' || $d=='') { echo "<option>Seleccione una opci�n</option>"; }
		$sql_dominio="SELECT * FROM dominio WHERE id_area='$a'";
		$datos_dominio=mysql_db_query($db,$sql_dominio,$link);
		while ($dominio=mysql_fetch_array($datos_dominio)) {
		?>
			<option value=<?php echo "lista_objetivo.php?d=".$dominio['id_dominio']."&a=".$a; if($d==$dominio['id_dominio']) { echo " selected"; } ?> ><?php echo $dominio['dominio']; ?></option>
		<?php
		}
		?>
        </select>
		</td>
      </tr>
    </table>
    
  <table width="75%" border="1" background="images/fondo.jpg">
    <tr bgcolor="#006699"> 
      <td width="9%" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">Nro.</font></div></td>
      <td width="78%" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">NOMBRE</font></div></td>
      <td width="13%" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">MODIFICAR</font></div></td>
      <td width="13%" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">ELIMINAR</font></div></td>
    </tr>
    <?php
	$i=1;  
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_db_query($db,$sql11,$link);
	$row11=mysql_fetch_array($result11);
	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}
	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM objetivos WHERE id_dominio='$d'";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);
	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	$sql_objetivo="SELECT * FROM objetivos WHERE id_dominio='$d' LIMIT $_pagi_inicial,$_pagi_cuantos";
	$datos_obj=mysql_db_query($db,$sql_objetivo,$link);
	while($objetivo=mysql_fetch_array($datos_obj)) {
	?>
    <tr> 
      <td width="9%"><div align="center"><?php echo $i; ?></div></td>
      <td width="78%"><div align="left">&nbsp;<?php echo $objetivo['objetivo']; ?></div></td>
      <td width="13%"><div align="center"><?php echo "<a href=objcon_nuevo.php?a=".$a."&d=".$d."&cod=".$objetivo['id_objetivo']."&pg=$pg><img src=images/editar.gif width=16 height=14 border=0></a>"; ?></div></td>
      <td width="13%"><div align="center"><?php echo "<a href=lista_objetivo.php?elim=ok&id_objetivo=".$objetivo['id_objetivo']."&d=".$d."&a=".$a."&pg=".$pg."    onclick=\"return elimina('$objetivo[id_objetivo]','$objetivo[objetivo]')\"><img src=images/eliminar.gif width=16 height=14 border=0></a>"; ?></div></td>
    </tr>
    <?php
	$i++;
	}
	?>
  </table>
    
  <p> 
    <input name="pg" type="hidden" id="pg" value="<?php=$pg?>">
    <input name="d" type="hidden" id="d" value="<?php=$d?>">
    <input name="a" type="hidden" id="a" value="<?php=$a?>">
  </p>
	<table width="75%" border="0">
      <tr> 
	  <td width="59%"> <div align="center">
        <?php
			if($d){
			?>
            <input name="cmdnuevo" type="submit" id="cmdnuevo" value="NUEVO NIVEL">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php }?>
			<input name="IMPRIMIR" type="button" id="IMPRIMIR" value="IMPRIMIR" onClick="imprimir()">
		</div>
		</td>
      </tr>
    </table>
  </form>
  <strong>P&aacute;gina(s):</strong> 
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
  <?php
include('top_.php');
?>
</div>
</body>
</html>
<script language="JavaScript" type="text/JavaScript">
<--
function elimina(id,num){
	if(confirm("Se va a eliminar "+num+".\n Mensaje generado por GesTor F1. "))
	{return true;}
	else{return false;}
}
function imprimir(){
	open("imprimir_pre_objetivo.php","nivel3",'width=600,height=170,status=no,resizable=yes,top=230,left=250,scrollbars=no,toolbars=no,dependent=yes,alwaysRaised=yes')
}
-->
</script>

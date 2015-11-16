<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
require('conexion.php');
//$_REQUEST['cod']=0;
if (empty($_REQUEST['pg'])) { $_REQUEST['pg']="";} else { $_REQUEST['pg']=$_REQUEST['pg'];}
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (empty($_REQUEST['pg'])) { $_REQUEST['pg']="";} else { $_REQUEST['pg']=$_REQUEST['pg'];}
//$pg=$_REQUEST['pg'];
if (isset($_REQUEST['cmdvolver'])) { header("location:lista_parametros_audi.php?Naveg=Parametros de Auditoria"); }
if (isset($_REQUEST['cmdnuevo'])) {	header("location:dominio_nuevo.php?cod=$_REQUEST[cod]&pg=$_REQUEST[pg]");  }

if(isset($_REQUEST['elim']) && $_REQUEST['elim']=='ok'){
    $id_dominio=$_REQUEST['id_dominio'];
	$sql_eli="DELETE FROM dominio WHERE id_dominio='$id_dominio'";
	mysql_query($sql_eli);
	$sql_eli2="DELETE FROM objetivos WHERE id_dominio='$id_dominio'";
	mysql_query($sql_eli2);
}
include('top.php');
include ("menu_tipo.php");
$sql="SELECT * FROM area ORDER BY area_nombre ASC";
$datos=mysql_query($sql);
?>
<html>
<head>
<title>Segundo Nivel</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
<!--

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>

<body>
<div align="center">
<form name="form1" method="post" action="">
    
  <table width="75%" border="1" background="images/fondo.jpg">
    <tr> 
      <th colspan="5" background="images/main-button-tileR1.jpg" height="22"><div align="center"><strong>NIVEL 2</strong></div></th>
    </tr>
    <tr> 
      <td colspan="5"> <div align="center"class="normal"><strong>Nivel 1:</strong> 
          <select name="select" id="select" onChange="MM_jumpMenu('parent',this,0)">
            <?php
            
                          if ($_REQUEST['cod']=='') { echo "<option value='0'>Seleccione una opcion</option>"; }else{ echo "selected";;}
			  	while($area=mysql_fetch_array($datos)) {
                            ?>
                            <option value=<?php echo "lista_dominio.php?cod=".$area['area_cod']; 
                            if (empty($_REQUEST['cod'])) { $_REQUEST['cod']="";} else { $_REQUEST['cod']=$_REQUEST['cod'];}
                            //echo '<br>'.$_REQUEST['cod'];
                            if ($_REQUEST['cod']==$area['area_cod']) { echo "selected"; } ?>><?php echo $area['area_nombre'];?></option>
            <?php
			  }
            ?>
          </select>
          <input name="cod" type="hidden" value="<?php echo $_REQUEST['cod']?>">
        </div>
      </td>
    </tr>
    <tr bgcolor="#006699"> 
      <td width="6%" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">Nro.</div></td>
      <td width="21%" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">NOMBRE</font></div></td>
      <td width="46%" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">DESCRIPCION</font></div></td>
      <td width="13%" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">MODIFICAR</font></div></td>
      <td width="14%" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">ELIMINAR</font></div></td>
    </tr>
    <?php
    if (empty($_REQUEST['cod'])) { $_REQUEST['cod']="";} else { $_REQUEST['cod']=$_REQUEST['cod'];}
        $cod= $_REQUEST['cod'];
	$i=1;
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);
	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}
	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}
	@$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM dominio WHERE id_area='$cod'";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);
	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	@$sql="SELECT * FROM dominio WHERE id_area='$cod' LIMIT $_pagi_inicial,$_pagi_cuantos";
	$datos=mysql_query($sql);
	while ($dominio=mysql_fetch_array($datos)) {
	?>
    <tr> 
      <td><div align="center"><?php echo $i; ?></div></td>
      <td><div align="center"><?php echo $dominio['dominio']; ?></div></td>
      <td><div><span>&nbsp;<?php echo $dominio['descripcion']; ?></span></div></td>
      <td><div align="center"><?php echo "<a href=dominio_nuevo.php?a=".$dominio['id_area']."&cod=".$dominio['id_dominio']."&pg=".@$pg."&mod=1><img src=images/editar.gif width=16 height=14 border=0></a>"; ?></div></td>
      <td width="14%"><div align="center"><?php echo "<a href=lista_dominio.php?elim=ok&cod=".$_REQUEST['cod']."&id_dominio=".$dominio['id_dominio']."&pg=".@$pg." onclick=\"return elimina('$dominio[id_dominio]','$dominio[dominio]')\"><img src=images/eliminar.gif width=16 height=14 border=0></a>"; ?></div></td>
    </tr>
    <?php
	$i++;
	}
	?>
  </table>
    <table width="75%" border="0">
      <tr>  
	  <td width="47%"><br>
       <div align="center">
	  <?php 
          if (empty($_REQUEST['cod'])) { $_REQUEST['cod']="";} else { $_REQUEST['cod']=$_REQUEST['cod'];}
          if($_REQUEST['cod']){?>	  		
		   <input name="pg" type="hidden" id="pg" value="<?php=$_REQUEST['pg']?>">
          <input name="cod" type="hidden" id="cod" value="<?php=$_REQUEST['cod']?>">
          <input name="cmdnuevo" type="submit" id="cmdnuevo" value="NUEVO NIVEL">
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php }?>
		<input name="IMPRIMIR" type="button" id="IMPRIMIR" value="IMPRIMIR" onClick="imprimir()">
        </div>
		</td> </tr>
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
</div>
</body>
</html>
<script language="JavaScript">

function elimina(id,num){
	if(confirm("Se va a eliminar "+num+".\n Mensaje generado por GesTor F1. "))
	return true;
	else return false;
}
function imprimir(){
	open("imprimir_pre_dominio.php","imprimir",'width=300,height=250,status=no,resizable=yes,top=230,left=350,scrollbars=no,toolbars=no,dependent=yes,alwaysRaised=yes');
}

</script>
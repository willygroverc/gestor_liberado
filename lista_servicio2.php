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
if (isset($cmdvolver)) { header("location:lista_parametros_audi.php?Naveg=Parámetros de Auditoría"); }
if (isset($cmdnuevo)) {	header("location:servicio2_nuevo.php?cod=$cod&pg=$pg");  }

if(isset($elim) && $elim=='ok'){
	$sql_eli="DELETE FROM t_servicio2 WHERE id_serv2='$id_dominio'";
	mysql_query($sql_eli);
}
include('top.php');
include ("menu_servicio.php");
$sql="SELECT * FROM t_servicio ORDER BY servicio_nombre ASC";
$datos=mysql_query($sql);
?>
<html>
<head>
<title>Actulalizar servicios - Gestor TI</title>
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
      <th colspan="5" background="images/main-button-tileR1.jpg" height="22"><div align="center"><strong>REGISTRO SERVICIO</strong></div></th>
    </tr>
    <tr> 
      <td colspan="5"> <div align="center"class="normal"><strong>Nivel 1:</strong> 
          <select name="select" id="select" onChange="MM_jumpMenu('parent',this,0)">
            <?php
			  if ($cod=='') { echo "<option value='0'>Seleccione una opción</option>"; }
			  	while($servicio=mysql_fetch_array($datos)) {
			  ?>
            <option value=<?php echo "lista_servicio2.php?cod=".$servicio['servicio_cod']; if($cod==$servicio['servicio_cod']) { echo " selected"; } ?> ><?php echo $servicio['servicio_nombre'];?></option>
            <?php
			  }
		      ?>
          </select>
          <input name="cod" type="hidden" value="<?php echo $cod?>">
        </div>
      </td>
    </tr>
    <tr bgcolor="#006699"> 
      <td width="6%" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">Nro.</div></td>
      <td width="21%" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">NOMBRE</font></div></td>
      <td width="46%" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">DESCRIPCION</font></div></td>
      <!--<td width="13%" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">MODIFICAR</font></div></td>-->
      <td width="14%" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">ELIMINAR</font></div></td>
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
	@$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM t_servicio2 WHERE servicio_cod ='$cod'";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);
	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	$sql="SELECT * FROM t_servicio2 WHERE servicio_cod='$cod' LIMIT $_pagi_inicial,$_pagi_cuantos";
	
	$datos=mysql_query($sql);
	while ($servicio=mysql_fetch_array($datos)) {
	?>
    <tr> 
      <td><div align="center"><?php echo $i; ?></div></td>
      <td><div align="center"><?php echo $servicio['servicio2']; ?></div></td>
      <td><div><span>&nbsp;<?php echo $servicio['servicio2_desc']; ?></span></div></td>
      <!--<td><div align="center"><?php echo "<a href=servicio2_nuevo.php?a=".$servicio['servicio_cod ']."&cod=".$servicio['id_serv2 ']."&pg=".@$pg."&mod=1><img src=images/editar.gif width=16 height=14 border=0></a>"; ?></div></td>-->
      <td width="14%"><div align="center"><?php echo "<a href=lista_dominio.php?elim=ok&cod=".$cod."&id_serv2 =".$servicio['v']."&pg=".@$pg." onclick=\"return elimina('$servicio[servicio_cod]','$servicio[servicio2]')\"><img src=images/eliminar.gif width=16 height=14 border=0></a>"; ?></div></td>
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
	  <?php if($cod){?>	  		
		   <input name="pg" type="hidden" id="pg" value="<?php=$pg?>">
          <input name="cod" type="hidden" id="cod" value="<?php=$cod?>">
          <input name="cmdnuevo" type="submit" id="cmdnuevo" value="NUEVO NIVEL">
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php }?>
		
        </div>
		</td> </tr>
    </table>
  </form>
  <strong>P&aacute;gina(s):</strong> 
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

//Añadimos el query string a la url.
$_pagi_enlace .= $_pagi_query_string;

//La variable $_pagi_navegacion contendrá los enlaces a las páginas.
$_pagi_navegacion = '';

if ($_pagi_actual != 1){
	//Si no estamos en la página 1. Ponemos el enlace "anterior"
	$_pagi_url = $_pagi_actual - 1;//será el número de página al que enlazamos
	$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_url."'>&laquo; Anterior</a>&nbsp;";
}
//Enlaces a números de página:
for ($_pagi_i = 1; $_pagi_i<=$_pagi_totalPags; $_pagi_i++){//Desde página 1 hasta última página ($_pagi_totalPags)
    if ($_pagi_i == $_pagi_actual) {
		//Si el número de página es la actual ($_pagi_actual). Se escribe el número, pero sin enlace y en negrita.
        $_pagi_navegacion .= "<b>&nbsp;$_pagi_i&nbsp;</b>";
    }else{
		//Si es cualquier otro. Se escibe el enlace a dicho número de página.
        $_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_i."'>".$_pagi_i."</a>&nbsp;";
    }
}

if ($_pagi_actual < $_pagi_totalPags){
	//Si no estamos en la última página. Ponemos el enlace "Siguiente"
    $_pagi_url = $_pagi_actual + 1;//será el número de página al que enlazamos
    $_pagi_navegacion .="<a href='".$_pagi_enlace."pg=".$_pagi_url."'>Siguiente &raquo;</a>";
}
print $_pagi_navegacion;
//Hasta acá hemos completado la "barra de navegación"
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
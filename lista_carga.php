<?php
// Version:		1.0
// Objetivo:	Modificacion funciones php obsoletas para version 5.3
//				Control de acceso directo NO autorizado
// Fecha:		20/NOV/12
// Autor:		Cesar Cuenca
//____________________________________________________________________________
// Version:		2.0
// Autor:		Alvaro ROdriguez
// Objetivo:	Se ha corrgido el vista de los caracteres especiales y 
// 				se ha cambiado el formato de fecha.
//_________________________________________________________________________________
header('Content-Type: text/html; charset=iso-8859-1');
	@session_start();
	if ($_SESSION['tipo']=='C')
		header('location:pagina_inicio.php');
	include ("top.php");
	include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("numasi","Numero de Asignacion");
	$help->AddHelp("numsol","Numero de Solucion");
/*	$help->AddHelp("conf","Conformidad de ...");
	$help->AddHelp("solu","Solucion a las ordenes de trabajo ...");
	$help->AddHelp("incidencia","Incidencia se refiere a...");*/
	print $help->ToHtml();
	include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("num","Numero");
	$help->AddHelp("numident","Numero de identificaciones");
/*	$help->AddHelp("conf","Conformidad de ...");
	$help->AddHelp("solu","Solucion a las ordenes de trabajo ...");
	$help->AddHelp("incidencia","Incidencia se refiere a...");*/
	print $help->ToHtml();
	
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM users WHERE bloquear<>2 and (tipo2_usr='T' or tipo2_usr='A')";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
?>

<table width="812" border="1" cellpadding="0" cellspacing="2" background="images/fondo.jpg">
  <tr align="center"> 
      <th colspan="9" background="windowsvista-assets1/main-button-tile.jpg" height="30px"> CARGA DE ASIGNACIONES</th>
   </tr>
  <tr> 
   <tr align="center"> 
          <th width="57" background="images/main-button-tileR2.jpg" class="menu">LOGIN</th>
          <th width="81" background="images/main-button-tileR2.jpg" class="menu">NOMBRE</th>
          <th width="97" background="images/main-button-tileR2.jpg" class="menu">APELLIDOS</th>
          <th width="41" background="images/main-button-tileR2.jpg" class="menu">TIPO</th>
          <th width="62" background="images/main-button-tileR2.jpg" class="menu"><?php print $help->AddLink("numasi", "# DE ASIGNACIONES"); ?></th>
          <th width="64" background="images/main-button-tileR2.jpg" class="menu"><?php print $help->AddLink("numsol", "# DE SOLUCIONES"); ?></th>
          <th width="104" background="images/main-button-tileR2.jpg" class="menu">PENDIENTES DE SOLUCION</th>
          <th width="125" background="images/main-button-tileR2.jpg" class="menu">PENDIENTES DE CONFORMIDAD</th>
          <th width="141" background="images/main-button-tileR2.jpg" class="menu">CERRADAS POR ADMINISTRADOR</th>
    </tr>
<?php
$sql = "SELECT * FROM users WHERE bloquear<>2 and (tipo2_usr='T' or tipo2_usr='A') ORDER BY login_usr ASC LIMIT $_pagi_inicial,$_pagi_cuantos";
$result=mysql_db_query($db,$sql,$link);

while ($row=mysql_fetch_array($result)) {
	$sumat=0;
  	echo "<tr align=\"center\">";
	echo "<td>$row[login_usr]</td>"; 
	echo "<td>$row[nom_usr]</td>"; 
	echo "<td>".$row['apa_usr']." ".$row['ama_usr']."</td>"; 
	echo "<td>".$row['tipo2_usr']."</td>"; 

	$asig=array();
	$sql1a = "SELECT MAX(id_asig) AS id_asig1 FROM asignacion GROUP BY id_orden";
	$res1a=mysql_query($sql1a);
	while($row1a=mysql_fetch_array($res1a)) array_push($asig,$row1a['id_asig1']);
	if($asig==array()) $asig2="NULL";
	else $asig2=implode(", ",$asig);
	$solu = array();
	$sql1="SELECT id_orden FROM asignacion WHERE id_asig IN ($asig2) AND asig='".$row['login_usr']."'";
	$result1=mysql_query($sql1);
	while($row1=mysql_fetch_array($result1)){
		$sumat++;
		array_push($solu,"'".$row1['id_orden']."'");
	}
	echo "<td>$sumat</td>"; 

	$sql1 = "SELECT count(*) AS sum FROM solucion WHERE login_sol='".$row['login_usr']."'";
	$result1=mysql_query($sql1);
	$row1=mysql_fetch_array($result1);
	echo "<td>".$row1['sum']."</td>"; 
///////
	if($solu==array()) $solu2="NULL";
	else $solu2=implode(", ",$solu);
	$sql_psol="SELECT count(*) AS numero FROM solucion WHERE id_orden IN ($solu2)";
	$res_psol=mysql_query($sql_psol);
	$row_psol=mysql_fetch_array($res_psol);
	$psol=$sumat-$row_psol['numero'];
	echo "<td>$psol</td>"; 
///
	$sql_total="SELECT count(*) AS numero FROM ordenes a, solucion b WHERE a.id_orden=b.id_orden AND cod_usr='".$row['login_usr']."'";
	$res_total=mysql_query($sql_total);
	$row_total=mysql_fetch_array($res_total);
	$sql_pconf="SELECT count(*) AS numero FROM ordenes a, solucion b, conformidad c WHERE a.id_orden=b.id_orden AND b.id_orden=c.id_orden AND cod_usr='".$row['login_usr']."'";
	$res_pconf=mysql_query($sql_pconf);
	$row_pconf=mysql_fetch_array($res_pconf);
	$pconf=$row_total['numero']-$row_pconf['numero'];
	
///
	$sql_sad="SELECT count(*) AS numero FROM solucion WHERE id_orden IN ($solu2) AND login_sol='admin'";
	$res_sad=mysql_query($sql_sad);
	$row_sad=mysql_fetch_array($res_sad);

	echo "<td>$pconf</td>"; 
	echo "<td>".$row_sad['numero']."</td>"; 
	echo "</tr>";
}

?>

</table><br>
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
<script>
<!--
function pagina () {
	window.open ("carga_print.php");
}
-->
</script>
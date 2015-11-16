<?php
require_once("funciones.php");
if (valida("Ejecucion")=="bad") {header("location: pagina_error.php");}
if ($RETORNAR){header("location: lista_contingencia.php?Naveg=Contingencia");}
include ("top.php");
?>
<?php 
	include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("num","Numero Orden de Mesa");
	print $help->ToHtml();
 ?>
<table width="90%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
    <td height="68" valign="top"><table width="100%" height="66" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="7">LISTA DE RECUPERACION / EJECUCION DE PRUEBAS</font></th>
        </tr>
<tr align=\"center\"> 
		  <th class="menu" width="5%"><?php print $help->AddLink("num", "Nro ORD MESA");?></th>
		  <th width="15%" class="menu">FECHA Y HORA</th>
  		  <th width="50%" class="menu">INCIDENCIA</th>
  		  <th class="menu">PRUEBA DE RECUPERACION</th>
		  <?php if ($tipo=="A" or $tipo=="B") {?>
  		  <th class="menu" width="8%">MODIFICAR</th><?php }?>
  		  <th width="9%" class="menu">IMPRIMIR</th>
</tr>
        <?php
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_db_query($db,$sql11,$link);
	$row11=mysql_fetch_array($result11);

	if(empty($row11[num_ord_pag])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11[num_ord_pag] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM planprueba";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9[pagi_totalReg] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;


		
$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ordenes o, planprueba p WHERE o.id_orden=p.ordayuda ORDER BY id_orden DESC,Time DESC LIMIT $_pagi_inicial,$_pagi_cuantos";

$result=mysql_db_query($db,$sql,$link);
while ($row=mysql_fetch_array($result)) {

	$sql2= "SELECT *, DATE_FORMAT(fecpru, '%d/%m/%Y') AS fecpru FROM pruebrecup WHERE ord_ayu='$row[id_orden]'";
	$result2=mysql_db_query($db,$sql2,$link);
	$row2=mysql_fetch_array($result2);

  	echo "<tr align=\"center\">";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"ver_orden.php?id_orden=".$row[id_orden]."\" target=\"_blank\">".$row[id_orden]."</a></font></td>";
	echo "<td><font size=\"1\">$row[fecha] $row[time]</font></td>";
	echo "<td><font size=\"1\">$row[desc_inc]</td>";

	if (!$row2[ord_ayu])
	{	echo "<td><font size=\"1\"><a href=\"pruebrecup.php?action=new&ord_ayu=".$row[id_orden]."\" >LLENAR</a></font></td>";}
	else
	{	echo "<td><font size=\"1\">$row2[fecpru]</a></font></td>";}
 if ($tipo=="A" or $tipo=="B") 		
{
	if (!$row2[ord_ayu])
	{	echo "<td><font size=\"1\">NO MODIFICABLE</font></td>";}
	if ($row2[ord_ayu])
	{	echo "<td><font size=\"1\"><a href=\"pruebrecup_mod.php?action=edit&idState=new&id_pru=".$row2[id_pru]."&ord_ayu=".$row2[ord_ayu]."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></a></font></td>";}
}	
	if ($row2[ord_ayu])
	{	echo "<td><font size=\"1\"><a href=\"ver_pruebrecup.php?id_pru=$row2[id_pru]&ord_ayu=".$row[id_orden]."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";}
	else
	{	echo "<td><font size=\"1\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></font></td>";}

}



?>
      </table></td>
  </tr>
</table>
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
<br>
<form name="form1" method="post" action="">
  <div align="center">
    <input type="submit" name="RETORNAR" value="RETORNAR">
  </div>
</form>

<?php include("top_.php"); ?> 
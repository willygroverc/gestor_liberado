<?php
require_once("funciones.php");
if(isset($elim_ficha)){
	include("conexion.php");
	$sql="UPDATE datfichatec SET Elim=1 WHERE IdFicha='$elim_ficha'";
	mysql_db_query($db,$sql,$link);
}
if (valida("FichasTecnicas")=="bad") {header("location: pagina_error.php");}
if ($RETORNAR){header("location: lista1_ficha.php?Naveg=Soporte Tecnico");}
if ($NueFicha){ header("location: ficha_tecnica.php");}
include ("top.php");
include_once ("help.class.php");
$help=new Help();
$help->AddHelp("codigo","Codigo Adicional USI");
$help->AddHelp("fechaRecepcion","Fecha de Recepcion.");
$help->AddHelp("fechaDevolucion","Fecha de Devolucion.");
print $help->ToHtml();
?>
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
<?php $hqt=($_GET['hqt']);
$campo1=($_GET['campo']);
$busqueda1=($_GET['busqueda']);
?>
<form name="form1" method="post" action="" onKeyPress="return Form()">
  <table width="80%" align="center">
    <tr>
      <td bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Busqueda 
          de ficha tecnica :</strong></font> 
          <select name="campo">
            <option value="TpRegFicha"<?php if ($campo=="TpRegFicha" OR $campo==""){echo "selected";}?>>TIPO REGISTRO</option>
            <option value="CodActFijo" <?php if ($campo=="CodActFijo"){echo "selected";}?>>COD. ACTIVO FIJO</option>
            <option value="Modelo" <?php if ($campo=="Modelo"){echo "selected";}?>>MODELO</option>
            <option value="AdicUSI" <?php if ($campo=="AdicUSI"){echo "selected";}?>>CODIGO ADICIONAL</option>
          </select>
          &nbsp;&nbsp;&nbsp; 
          <input name="busqueda" type="text" size="40" value="<?php echo trim($busqueda);?>">
          &nbsp;&nbsp;&nbsp;&nbsp; 
          <input name="BUSCAR" type="submit" id="BUSCAR" value="BUSCAR">
        </div></td>
    </tr>
  </table>
  </form>
  <table width="95%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
      <td height="68" valign="top"> 
        <table width="100%" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="15" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF">REGISTRO 
            DE FICHAS TECNICAS</font></th>
        </tr>
        <tr> 
          <th width="30" rowspan="2" align="\&quot;center\&quot;" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">N° 
            FICHA</font></th>
          <th width="64" rowspan="2" align="\&quot;center\&quot;" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">FECHA 
            REALIZACION</font></th>
          <th width="90" rowspan="2" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">TIPO<br>
            REGISTRO</font></th>
          <th width="70" rowspan="2" align="\&quot;center\&quot;" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">CODIGO 
              ACTIVO FIJO</font></th>
          <th width="70" rowspan="2" align="\&quot;center\&quot;" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">CODIGO 
              ADICIONAL</font></th>
          <th width="68" rowspan="2" align="\&quot;center\&quot;" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">MODELO</font></th>
          <th width="82" rowspan="2" align="\&quot;center\&quot;" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">ASIGNADO 
            A </font></th>
          <th width="60" rowspan="2" align="\&quot;center\&quot;" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"> 
            <?php print $help->AddLink("fechaRecepcion","FECHA RECEPCION"); ?></font></th>
          <th width="71" rowspan="2" align="\&quot;center\&quot;" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"> 
            <?php print $help->AddLink("fechaDevolucion","FECHA DEVOLUCION") ?></font></th>
          <?php if ($tipo=="A" or $tipo=="B") {?>
		  <th width="62" rowspan="2" align="\&quot;center\&quot;" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">MODIFICAR 
            FICHA </font></th>
          <?php } ?>
          <th width="80" rowspan="2" align="\&quot;center\&quot;" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">MANTENIMIENTO 
            </font></th>
          <th width="70" rowspan="2" align="\&quot;center\&quot;" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">CRONOGRAMA</font></th>
          <th height="13" colspan="2" align="\&quot;center\&quot;" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">VISTA 
            DE IMPRESION</font></th>
			<th width="68" rowspan="2" align="\&quot;center\&quot;" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">DAR DE BAJA</font></th>
        </tr>
        <tr align=\"center\"> 
          <th width="65" height="24" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FICHA 
            TECNICA </font></th>
          <th width="67" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">CUSTODIO</font></th>
        </tr>
		
<?php
	$sql11 = "SELECT num_ord_pag FROM control_parametros";
	$result11=mysql_db_query($db,$sql11,$link);
	$row11=mysql_fetch_array($result11);

	if(empty($row11[num_ord_pag])){	$_pagi_cuantos = 20 ; }
	else{$_pagi_cuantos = $row11[num_ord_pag];}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

if ($hqt=="1" and !$BUSCAR)
{	$hqt1="0";
	$busqueda1=trim($busqueda1);
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM datfichatec WHERE $campo1 LIKE '%$busqueda1%' AND Elim<>'1'";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9[pagi_totalReg] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;

    $sql="SELECT * FROM datfichatec WHERE $campo1 LIKE '%$busqueda1%' AND Elim<>'1' ORDER BY IdFicha DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
}	
elseif ($BUSCAR){
	$hqt="1";
	$hqt1="1";	
	$_pagi_actual="1";
	$busqueda=trim($busqueda);
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM datfichatec WHERE $campo LIKE '%$busqueda%' AND Elim<>'1'";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9[pagi_totalReg] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;

    $sql="SELECT * FROM datfichatec WHERE $campo LIKE '%$busqueda%' AND Elim<>'1' ORDER BY IdFicha DESC LIMIT $_pagi_inicial,$_pagi_cuantos";}
else {
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM datfichatec WHERE Elim<>'1'";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9[pagi_totalReg] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
    $sql = "SELECT *, DATE_FORMAT(FechPruFunc, '%d/%m/%Y') AS FechPruFunc FROM datfichatec WHERE Elim<>'1' ORDER BY IdFicha DESC LIMIT $_pagi_inicial,$_pagi_cuantos";}

$result=mysql_db_query($db,$sql,$link);
while ($row=mysql_fetch_array($result)) {
  	echo "<tr align=\"center\">";
	echo "<td><font size=\"1\">&nbsp;$row[IdFicha]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[FechPruFunc]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[TpRegFicha]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[CodActFijo]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[AdicUSI]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[Modelo]</font></td>";
	$sql2 = "SELECT MAX(IdCust) AS ID FROM asigcustficha WHERE IdFicha='$row[IdFicha]'";
    $result2 = mysql_db_query($db,$sql2,$link);
	$row2 = mysql_fetch_array($result2);
	$sql3 = "SELECT *, DATE_FORMAT(Fecha, '%d/%m/%Y') AS Fecha FROM asigcustficha WHERE IdCust='$row2[ID]'"; //HERE
    $result3 = mysql_db_query($db,$sql3,$link);
	$row3 = mysql_fetch_array($result3);
	if (($row3[Tipo]=="Asignado" AND $row3[Tipo1]=="Devuelto")OR(!$row3[Tipo] AND !$row3[Tipo1]))
	{	echo "<td><font size=\"1\">&nbsp;Disponible</font></td>";	
		echo "<td><font size=\"1\">&nbsp;<a href=\"fichatec_recep.php?IdFicha=".$row[IdFicha]."\"><img src=\"images/usuario.gif\" border=\"0\" alt=\"Asignar\"></a></font></td>";
		echo "<td><font size=\"1\">&nbsp;DEVOLUCION</font></td>";}
	else if ($row3[Tipo]=="Asignado" AND $row3[Tipo1]=="")
	{	
		$sql7="SELECT * FROM users WHERE login_usr='$row3[NombAsig]'";
		$result7=mysql_db_query($db,$sql7,$link);
		$row7=mysql_fetch_array($result7);	
		echo "<td><font size=\"1\">&nbsp;$row7[nom_usr] $row7[apa_usr] $row7[ama_usr]</font></td>";	
		echo "<td><font size=\"1\">&nbsp;$row3[Fecha]</font></td>"; //HERE
		echo "<td><font size=\"1\">&nbsp;<a href=\"fichatec_devol.php?IdFicha=".$row[IdFicha]."&IdCust=".$row2[ID]."\"><img src=\"images/mano.gif\" border=\"0\" alt=\"Devolucion\"></a></font></td>";}
		if ($tipo=="A" or $tipo=="B")
		{echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;<a href=\"ficha_tecnica_last.php?IdFicha=".$row[IdFicha]."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></font></td>";}
		$sql5="SELECT MAX(id_regPC) AS Id FROM pcontrol";
		$result5=mysql_db_query($db,$sql5,$link);
		$row5=mysql_fetch_array($result5);
		$r=$row5[Id]+1; 
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;<a href=\"controlmanten.php?CodActFijo=".$row[CodActFijo]."&varia1=".$r."\"><img src=\"images/dispositivo.gif\" border=\"0\" alt=\"Realizar Mantenimiento Fuera\"></a></font></td>";
		$sql6="SELECT MAX(id_cmant) AS Id FROM calenmantplanif";
		$result6=mysql_db_query($db,$sql6,$link);
		$row6=mysql_fetch_array($result6);
		$rr=$row6[Id]+1; 
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;<a href=\"calendarizacion.php?CodActFijo=".$row[CodActFijo]."&varia=".$rr."&varia1=".$rr."\"><img src=\"images/cal.gif\" border=\"0\" alt=\"Realizar Cronograma\"></a></font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;<a href=\"ver_fichatecnica.php?IdFicha=".$row[IdFicha]."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir Ficha Tecnica\"></a></font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;<a href=\"ver_fichatecnica_custodio.php?IdFicha=".$row[IdFicha]."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir Custodio\"></a></font></td>";
//////
	echo "<td onclick=\"eliminar_ficha('$row[IdFicha]')\">&nbsp;<img src=\"images/eliminar.gif\" border=\"0\" alt=\"Eliminar Ficha\"></font></td>";
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
$_pagi_enlace = $_SERVER['PHP_SELF'];
$_pagi_query_string = "?";
if(isset($_GET)){
	$_pagi_variables = $_GET;
	foreach($_pagi_variables as $_pagi_clave => $_pagi_valor){
		if($_pagi_clave != 'pg'){
			$_pagi_query_string .= $_pagi_clave."=".$_pagi_valor."&";
		}
	}
}


$_pagi_enlace .= $_pagi_query_string;

$_pagi_navegacion = '';

if ($_pagi_actual != 1)
{
	//Si no estamos en la página 1. Ponemos el enlace "anterior"
	$_pagi_url = $_pagi_actual - 1;//será el numero de página al que enlazamos
	if ($hqt=="1" and $hqt1=="1")
	{$_pagi_navegacion .= "<a href='lista_ficha.php?pg=".$_pagi_url."&hqt=".$hqt."&campo=".$campo."&busqueda=".$busqueda."'>&laquo; Anterior</a>&nbsp;";}
	else
	{$_pagi_navegacion .= "<a href='lista_ficha.php?pg=".$_pagi_url."&hqt=".$hqt."&campo=".$campo1."&busqueda=".$busqueda1."'>&laquo; Anterior</a>&nbsp;";}
}
//Enlaces a numeros de página:
for ($_pagi_i = 1; $_pagi_i<=$_pagi_totalPags; $_pagi_i++){//Desde página 1 hasta ultima página ($_pagi_totalPags)
    if ($_pagi_i == $_pagi_actual) {
		//Si el numero de página es la actual ($_pagi_actual). Se escribe el numero, pero sin enlace y en negrita.
        $_pagi_navegacion .= "<b>&nbsp;$_pagi_i&nbsp;</b>";
    }else{
		//Si es cualquier otro. Se escibe el enlace a dicho numero de página.
     if ($hqt=="1" and $hqt1=="1")  
	    {$_pagi_navegacion .= "<a href='lista_ficha.php?pg=".$_pagi_i."&hqt=".$hqt."&campo=".$campo."&busqueda=".$busqueda."'>".$_pagi_i."</a>&nbsp;";}
     else
	    {$_pagi_navegacion .= "<a href='lista_ficha.php?pg=".$_pagi_i."&hqt=".$hqt."&campo=".$campo1."&busqueda=".$busqueda1."'>".$_pagi_i."</a>&nbsp;";}
	}
}

if ($_pagi_actual < $_pagi_totalPags){
	//Si no estamos en la ultima página. Ponemos el enlace "Siguiente"
    $_pagi_url = $_pagi_actual + 1;//será el numero de página al que enlazamos
    if ($hqt=="1" and $hqt1=="1")
	 {$_pagi_navegacion .="<a href='lista_ficha.php?pg=".$_pagi_url."&hqt=".$hqt."&campo=".$campo."&busqueda=".$busqueda."'>Siguiente &raquo;</a>";}
	else
  	 {$_pagi_navegacion .="<a href='lista_ficha.php?pg=".$_pagi_url."&hqt=".$hqt."&campo=".$campo1."&busqueda=".$busqueda1."'>Siguiente &raquo;</a>";}
}
print $_pagi_navegacion;
//Hasta acá hemos completado la "barra de navegacion"
?>
        </font></strong> <font size="2"><strong>&nbsp;</strong></font></div></td>
  </tr>
</table>
<a href="lista_ficha_baja.php">&lt;&lt;&lt; Ver Fichas Normales</a> 
<form name="form2" method="post" action="">
  <div align="center"><br>
    <input name="NueFicha" type="submit" id="NueFicha" value="NUEVA FICHA" >
    &nbsp;&nbsp;&nbsp;
    <input type="button" name="IMPRIMIR" value="IMPRIMIR" onClick="openStat_2()" >
    &nbsp;&nbsp;&nbsp; 
    <input type="submit" name="RETORNAR" value="RETORNAR">
  </div>
</form>
<script language="JavaScript">
<!--
function openStat_2() {
	window.open("impresion_ficha.php",'Impresion', 'width=590,height=160,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
};

function ir_comprobar() {
	window.open("comprobar.php",'Comprobar', 'width=590,height=160,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
function eliminar_ficha(x){
	if(confirm("Desea dar de baja a la ficha técnica "+x+" ?\n\nMensaje generado por GesTor F1")){
		dir="lista_ficha.php?elim_ficha="+x
		self.location=dir
	}
}
-->
</script>
<?php include("top_.php");?> 
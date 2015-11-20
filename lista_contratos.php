<?php 
session_start();
require_once("funciones.php");
if (valida("Contratos")=="bad") {header("location: pagina_error.php");}
if (isset($_REQUEST['RETORNAR'])){echo "<script type=\"text/javascript\">
           history.go(-2);
       </script>";}
if (isset($_REQUEST['Resumen'])){ header("location: contratos_resumen.php");}
if (isset($_REQUEST['Contrato'])){ header("location: contrato1.php");}
include ("top.php");
$IdContra=  isset($_GET['IdContra']);
$Ejecuc=  isset($_GET['Ejec']);
$Cierre=  isset($_GET['Cierre']);

if ($Ejecuc<>"")
{	$sql3="UPDATE contratodatos SET Ejecucion='$_GET[Ejec]' WHERE IdContra='$_GET[IdContra]'";
	
        mysql_db_query($db,$sql3,$link);
}
if ($Cierre<>"")
{	$sql3="UPDATE contratodatos SET Cierre='$_GET[Cierre]' WHERE IdContra='$_GET[IdContra]'";
        
	mysql_db_query($db,$sql3,$link);
}
if ($Cierre==0){
	$sql4="UPDATE contratodatos SET motivo_cierre='' WHERE IdContra='$IdContra'";
        
	mysql_db_query($db,$sql4,$link);
}
	include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("num","Numero de Contrato");
	$help->AddHelp("fechav","Fecha de vencimiento");
	print $help->ToHtml();
	$sql = "SELECT IdProv, NombProv FROM proveedor";
		$rs = mysql_db_query($db,$sql,$link);
		while ($tmp = mysql_fetch_array($rs)) {
			$lstProveedor[$tmp['IdProv']]=$tmp['NombProv'];
	}
?>
<form action="" method="get" name="form2" id="form2" >
    <input name="opc" type="hidden" value="<?php echo isset($_REQUEST['opc']);?>">
  <table width="80%" border="1" align="center" bgcolor="#006699">
    <tr> 
      <td width="60%" background="windowsvista-assets1/main-button-tile.jpg" height="30px"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Busqueda 
          por :</strong></font> 
          <select name="menu" id="menu">
              <?php $menu=  isset($_REQUEST['menu']);
              $text=  isset($_REQUEST['text']);?>
            <option value="" <?php if ($menu==""){echo "selected";}?>>GENERAL</option>		  
            <option value="cod" <?php if ($menu=="cod"){echo "selected";}?>>Codigo Legal</option>
            <option value="emp" <?php if ($menu=="emp"){echo "selected";}?>>Empresa Contratada</option>
			 <option value="ncc" <?php if ($menu=="ncc"){echo "selected";}?>>Nro. Contrato</option>
          </select>
          &nbsp;&nbsp;&nbsp; 
          <input name="text" type="text" id="text" value="<?php echo $text?>">
          &nbsp;&nbsp;&nbsp; 
          <input name="BUSCAR" type="submit" id="BUSCAR" value="BUSCAR">
        </div></td>
	    </tr>
  </table>
</form>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
    <td height="68" valign="top">
	<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="12" background="images/main-button-tileR2.jpg" height="30">LISTA DE CONTRATOS</font></th>
        </tr>
        <tr align="center"> 
          <td class="menu" width="5%" background="images/main-button-tileR2.jpg"><?php print $help->AddLink("num", "Nro CONT."); ?></td>
          <td width="27%" background="images/main-button-tileR2.jpg" class="menu">TIPO DE CONTRATO</td>
          <td width="9%" background="images/main-button-tileR2.jpg" class="menu">CODIGO LEGAL </td>
          <td width="14%" background="images/main-button-tileR2.jpg" colspan="1" class="menu">EMPRESA CONTRATADA</td>
          <td width="8%" background="images/main-button-tileR2.jpg" class="menu"><?php print $help->AddLink("fechav", "FECHA VENC."); ?></td>
          <?php if ($tipo=="A" or $tipo=="B") {?>
          <td background="images/main-button-tileR2.jpg" class="menu" width="8%">MODIFICAR CONTRATO</td>
          <?php } ?>
          <td background="images/main-button-tileR2.jpg" class="menu" width="9%">VISTA IMPRESION</td>
          <td background="images/main-button-tileR2.jpg" class="menu" width="9%">EN EJECUCION</td>
		  <td background="images/main-button-tileR2.jpg" class="menu" width="11%">CERRAR CONTRATO</td>
          <td background="images/main-button-tileR2.jpg" class="menu" width="11%">AREA</td>
          <td background="images/main-button-tileR2.jpg" class="menu" width="11%">ADJUNTAR ARCHIVOS</td>
        </tr>
        <?php
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_db_query($db,$sql11,$link);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

switch($menu){
case "cod":
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM contratodatos WHERE CodLegalContra LIKE '%$text%'";
	break;
case "ncc":
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM contratodatos WHERE IdContra='$text'";
	break;
case "emp":
	$auxbox='NULL';
	$sqlemp="SELECT IdProv FROM proveedor WHERE NombProv LIKE '%$text%'";
	$resultemp=mysql_db_query($db, $sqlemp, $link);
	while ($rowemp = mysql_fetch_array($resultemp)) {
				$auxbox=$auxbox.", ".$rowemp['IdProv'];
					}
				$auxbox=str_replace('NULL,','', $auxbox);
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM contratodatos WHERE PartCont IN ($auxbox)";
	break;
default:
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM contratodatos";
	break
;}
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;

$fechahoy=date("Y-m-d");

switch($menu){
case "cod":
	$sql = "SELECT *, DATE_FORMAT(FechAl, '%d/%m/%Y') AS FechAl2 FROM contratodatos WHERE CodLegalContra LIKE '%$text%' ORDER BY IdContra DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
	break;
case "ncc":
	$sql = "SELECT *, DATE_FORMAT(FechAl, '%d/%m/%Y') AS FechAl2 FROM contratodatos WHERE IdContra='$text' LIMIT $_pagi_inicial,$_pagi_cuantos";
	break;
case "emp":
	$sql = "SELECT *, DATE_FORMAT(FechAl, '%d/%m/%Y') AS FechAl2 FROM contratodatos WHERE PartCont IN ($auxbox) ORDER BY IdContra DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
	break;
default:
	$sql = "SELECT *, DATE_FORMAT(FechAl, '%d/%m/%Y') AS FechAl2 FROM contratodatos ORDER BY IdContra DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
	break;}
$result=mysql_db_query($db,$sql,$link);

while ($row=mysql_fetch_array($result)){
  	if ($fechahoy <= $row['FechAl'] AND $row['Cierre']=="0"){
            $color="bgcolor=\"#00CC66\"";            
        }   // VIGENTE
	elseif ($row['FechAl']<$fechahoy AND $row['Ejecucion']=="0" AND $row['Cierre']=="0"){
            $color="bgcolor=\"#FF6666\"";            
        } // VENCIDO
	elseif ($row['FechAl']<$fechahoy AND $row['Ejecucion']=="1" AND $row['Cierre']=="0"){
            $color="bgcolor=\"#FFFF00\"";            
        } //VENCIDO PERO EN EJECUCION
	elseif ($row['Cierre']=="1"){
            $color="bgcolor=\"#A5BBF5\"";            
        } //EN CIERRE
		
	echo "<tr align=\"center\">";
	echo "<td ".$color.">&nbsp;$row[IdContra]</td>";
	echo "<td>&nbsp;$row[TipoContra]</td>";
	echo "<td>&nbsp;$row[CodLegalContra]</td>";
	echo "<td>&nbsp;".$lstProveedor[$row['PartCont']]."</td>";
	echo "<td>&nbsp;$row[FechAl2]</td>";
	$sqlArea="SELECT * FROM datos_adicionales WHERE id_dadicional='$row[area]'";
	$resultArea=mysql_query($sqlArea);
	$filaArea=mysql_fetch_array($resultArea);
    if ($tipo=="A" or $tipo=="B"){
        echo "<td><a href=\"contrato1_last.php?IdContra=".$row['IdContra']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></td>";
    }
        echo "<td><a href=\"ver_fichaleg.php?IdContra=".$row['IdContra']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></td>";
    if ($row['Cierre']=="0"){	
        if ($row['FechAl'] >= $fechahoy){
            echo "<td>VIGENTE</td>";
            if ($tipo=="A" or $tipo=="B"){
                echo "<td><a href=\"cerrar_contrato.php?IdContra=".$row['IdContra']."\">CERRAR</a></td>";
		echo "<td>&nbsp;$filaArea[nombre_dadicional]</td>";
		if ($row['file']==""){
                    echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTAR</a></td>";
		}
            else{
                    echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTADOS</a></td>";
                    //  echo "<td><a href=\"archivos adjuntos/".$row[file]."\" target=\"_blank\">$row[file]</a></td>";
		}			 
            }
	else{
                echo "<td>SIN CIERRE</td>";
		include("conexion.php");
		$sqlArea="SELECT * FROM datos_adicionales WHERE id_dadicional='$row[area]'";
		$resultArea=mysql_query($sqlArea);
		$filaArea=mysql_fetch_array($resultArea);
		echo "<td>&nbsp;$filaArea[nombre_dadicional]</td>";
                    if ($row['file']==""){
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTAR</a></td>";
                    }
		else{
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTADOS</a></td>";
//			echo "<td><a href=\"archivos adjuntos/".$row[file]."\" target=\"_blank\">$row[file]</a></td>";
                    }
            }
			 
	}
		else
		{	if ($row['Ejecucion']=="0")
				{if ($tipo=="A" or $tipo=="B")
					{echo "<td><a href=\"lista_contratos.php?IdContra=".$row['IdContra']."&Ejec=1\">EJECUTAR</a></td>";
					 echo "<td><a href=\"cerrar_contrato.php?IdContra=".$row['IdContra']."\">CERRAR</a></td>";
					 echo "<td>&nbsp;$filaArea[nombre_dadicional]</td>";
					 if ($row['file']==""){
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTAR</a></td>";
		}
		else {
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTADOS</a></td>";
//			echo "<td><a href=\"archivos adjuntos/".$row[file]."\" target=\"_blank\">$row[file]</a></td>";
		}
					 
					 }
					 
				else{echo "<td><font color=\"#666666\">SIN EJECUCION</font></td>";
					 echo "<td>SIN CIERRE</td>";
					 echo "<td>&nbsp;$filaArea[nombre_dadicional]</td>";
					 if ($row['file']==""){
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTAR</a></td>";
		}
		else {
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTADOS</a></td>";
//			echo "<td><a href=\"archivos adjuntos/".$row[file]."\" target=\"_blank\">$row[file]</a></td>";
		}
					 }}
			elseif ($row['Ejecucion']=="1")
				{if ($tipo=="A" or $tipo=="B")
					{echo "<td><a href=\"lista_contratos.php?IdContra=".$row['IdContra']."&Ejec=0\">QUITAR EJECUCION</a></td>";
					 echo "<td><a href=\"cerrar_contrato.php?IdContra=".$row['IdContra']."\">CERRAR</a></td>";
					 echo "<td>&nbsp;$filaArea[nombre_dadicional]</td>";
					 if ($row['file']==""){
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTAR</a></td>";
		}
		else {
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTADOS</a></td>";
//			echo "<td><a href=\"archivos adjuntos/".$row[file]."\" target=\"_blank\">$row[file]</a></td>";
		}
					 }
				else{echo "<td>EN EJECUCION</td>";
					 echo "<td>SIN CIERRE</td>";
					 echo "<td>&nbsp;$filaArea[nombre_dadicional]</td>";
					 if ($row['file']==""){
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTAR</a></td>";
		}
		else {
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTADOS</a></td>";
//			echo "<td><a href=\"archivos adjuntos/".$row[file]."\" target=\"_blank\">$row[file]</a></td>";
		}
					 }}
		}
    }
    elseif ($row['Cierre']=="1"){print_r($tipo);//exit;
		if ($row['FechAl'] >= $fechahoy)
		{
                    echo "<td>SIN EJECUCION</td>";
                    if ($tipo=="A" or $tipo=="B"){
                        echo "<td><a href=\"lista_contratos.php?IdContra=".$row['IdContra']."&Cierre=0\">REESTABLECER CONTRATO</a></td>";
                        }
                    else{echo "<td>CERRADO</td>";
                        }
		}
		else{	
                    if ($row['Ejecucion']=="0" OR $row['Ejecucion']=="1")
                        {
				if ($tipo=="A" or $tipo=="B")
                                    {   echo "<td><font color=\"#666666\">SIN EJECUTAR</font></td>";
					echo "<td><a href=\"lista_contratos.php?IdContra=".$row['IdContra']."&Cierre=0\">REESTABLECER CONTRATO</a></td>";
					echo "<td>&nbsp;$filaArea[nombre_dadicional]</td>";
					if ($row['file']=="")
                                          {
                                            echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTAR</a></td>";
                                          }
                                      else{
                                            echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTADOS</a></td>";
//                                          echo "<td><a href=\"archivos adjuntos/".$row[file]."\" target=\"_blank\">$row[file]</a></td>";
                                          }
                                    }
				else{echo "<td><font color=\"#666666\">SIN EJECUCION</font></td>";
					 echo "<td><font color=\"#666666\">CERRADO</font></td>";
					  echo "<td>&nbsp;$filaArea[nombre_dadicional]</td>";
					if ($row['file']==""){
                                            echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTAR</a></td>";
                                        }
                                    else{
                                            echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTADOS</a></td>";
//                                          echo "<td><a href=\"archivos adjuntos/".$row[file]."\" target=\"_blank\">$row[file]</a></td>";
                                        }
                                    }                                    
                        }
                    }
    }
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
<form name="form1" method="post" action="">
    
  <table width="90%" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="27%"><div align="center"> 
          <input type="submit" name="Contrato" value="NUEVO CONTRATO">
        </div></td>
      <td width="25%"> <div align="center">
          <input type="button" name="Resumen" value="RESUMEN GLOBAL" onClick="pagina()">
        </div></td>
      <td width="25%"><div align="center"> 
          <input type="submit" name="ESTADISTICAS" value="ESTADISTICAS" onClick="openStat_1()">
        </div></td>
    </tr>
  </table>
    </form>
  
<table width="85%" border="1" align="center">
  <tr> 
    <td width="16%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">CONTRATOS 
        VENCIDOS O CADUCADOS</font></div></td>
    <td width="6%" bgcolor="#FF6666">&nbsp;</td>
    <td width="6%">&nbsp;</td>
    <td width="16%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">CONTRATOS 
        VENCIDOS <strong>PERO</strong> EN EJECUCION</font></div></td>
    <td width="6%" bgcolor="#FFFF00">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="12%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">CONTRATOS 
        EN VIGENCIA</font></div></td>
    <td width="6%" bgcolor="#00CC66">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="11%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">CONTRATO 
        CERRADO </font></div></td>
    <td width="7%" bgcolor="#A5BBF5">&nbsp;</td>
  </tr>
</table>
<script language="JavaScript">
<!--
function pagina() {
	window.open("ver_contratos_resumen.php");
}
function openStat_1() {
	window.open("report_contratos.php",'Estadìsticas', 'width=650,height=290,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
-->
</script>
<?php include("top_.php");?> 
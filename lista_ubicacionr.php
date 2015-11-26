<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		14/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require_once("funciones.php");
include ('funciones.inc.php');
if (valida("UbicacRespal")=="bad") {header("location: pagina_error.php");}
//if (isset($RETORNAR)){header("location: lista_produccion.php?Naveg=Produccion");}
if (isset($_REQUEST['NAcuerdo'])){  header("location: ubicacionresp.php");}
include ("top.php");
if(isset($_REQUEST['enviar'])) $enviar=$_REQUEST['enviar']; else $enviar=NULL;
if(isset($_REQUEST['Sistema'])) $Sistema=$_REQUEST['Sistema']; else $Sistema=NULL;
if(isset($_REQUEST['Negocio'])) $Negocio=$_REQUEST['Negocio']; else $Negocio=NULL;
if(isset($_REQUEST['SE1'])) $SE1=$_REQUEST['SE1']; else $SE1=NULL;
if(isset($_REQUEST['SE2'])) $SE2=$_REQUEST['SE2']; else $SE2=NULL;
if(isset($_REQUEST['General'])) $General=$_REQUEST['General']; else $General=NULL;


?>

<form action="lista_ubicacionr.php" name="frmu" method="post">
  <table width='80%' align='center' bordercolor="#006699" bgcolor="#006699">
    <tr>
		<td width="7%"  height="7" align="center"   nowrap >
		</td>
		<td width="22%" height="7" align="center"  nowrap>
			<FONT color="#FFFFFF" size="1" face="Verdana, Arial, Helvetica, sans-serif">Seleccion por ubicacion:</FONT>
		</td>
		
 <?php
  	  echo "<td width='12%' height='7'  nowrap>";
	 	   
 	  if (!isset($Sistema))
	      echo " <input type='checkbox' name='Sistema' VALUE='1'> ";
	  else
	  	  echo " <input type='checkbox' name='Sistema' VALUE='1' checked>";
	  echo "<FONT color='#FFFFFF' size='1' face='Verdana, Arial, Helvetica, sans-serif'>SISTEMA</FONT>";		  
	  echo "</td>";
      echo "<td width='12%' height='7'  nowrap>";
	  
	  if (!isset($Negocio))	
      echo "<input type='checkbox' name='Negocio' VALUE='1' >";
	  else 
      echo "<input type='checkbox' name='Negocio' VALUE='1' checked>";      
	  echo "<FONT color='#FFFFFF' size='1' face='Verdana, Arial, Helvetica, sans-serif'>NEGOCIO</FONT>";	
	  echo "</td>";        
      echo "<td width='13%' height='7' align='center'  nowrap >";
	  
	  if (!isset($SE1))
	  echo " <input type='checkbox' name='SE1' VALUE='1'> ";
	  else
	  echo " <input type='checkbox' name='SE1' VALUE='1' checked> ";
	  echo "<FONT color='#FFFFFF' size='1' face='Verdana, Arial, Helvetica, sans-serif'>EXTERNO1</FONT></td>";
      echo " <td width='11%' align='center'  nowrap >";
	  
	  if (!isset($SE2))
	  echo " <input type='checkbox' name='SE2' VALUE='1'>";
	  else
	  echo " <input type='checkbox' name='SE2' VALUE='1' checked>";
	  echo "<FONT color='#FFFFFF' size='1' face='Verdana, Arial, Helvetica, sans-serif'>EXTERNO2</FONT>";
	  echo "</td>";	  
      echo "<td width='11%' align='center'  nowrap>&nbsp;&nbsp;";	  
	  if (!isset($General)) 
	    if  (isset($enviar))
	  	echo "<input type='checkbox' name='General' VALUE='1'>";	  
		else
		echo "<input type='checkbox' name='General' VALUE='1' checked>";
	  else
	  echo "<input type='checkbox' name='General' VALUE='1' checked>";
	  echo "<FONT color='#FFFFFF' size='1' face='Verdana, Arial, Helvetica, sans-serif'>GENERAL</FONT>";
	  echo "</td>";
?>
      <td width="22%">&nbsp; <input type="submit" name="enviar" value="Buscar " ></td>		
</tr>		
</table>
</form>

<table width="80%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699" >
  <tr> 
    <td height="68" valign="top">
	<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="7" background="windowsvista-assets1/main-button-tile.jpg" height="30">UBICACION DE RESPALDOS</th>
        </tr>
        <tr align=\"center\"> 
		  <th width="9%" class="menu" height="20" background="images/main-button-tileR1.jpg">CODIGO</th>
		  <th width="12%" class="menu" background="images/main-button-tileR1.jpg">TIPO</th>
	  	  <th width="9%" class="menu" background="images/main-button-tileR1.jpg">FECHA</th>
	  	  <th width="20%" class="menu" background="images/main-button-tileR1.jpg">CONTENIDO</th>
		  <th width="25%" class="menu" background="images/main-button-tileR1.jpg">UBICACION</th>
          <?php if ($tipo=="A" or $tipo=="B") {?>
	  	  <th width="10%" class="menu" background="images/main-button-tileR1.jpg">MODIFICAR</th>
          <?php }?>
	  	  <th width="10%" class="menu" background="images/main-button-tileR1.jpg">IMPRIMIR</th>
        </tr>
        <?php
		$sql11 = "SELECT num_ord_pag FROM control_parametros";
		$result11 = mysql_query($sql11);
		$row11=mysql_fetch_array($result11);

		if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
		else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

		if (empty($_GET['pg'])){$_pagi_actual = 1;}
		else{$_pagi_actual = $_GET['pg'];}
		
	if (isset($enviar))
	{		
			if (!isset($Sistema)) {$Sistema = "0";}
			if (!isset($Negocio)) {$Negocio = "0";}
			if (!isset($SE1)) {$SE1 = "0";}
			if (!isset($SE2)) {$SE2 = "0";}
		
 		if ( $General=="1" or ($Sistema=="0" and $Negocio=="0" and $SE1=="0" and $SE2=="0"))
		{ //echo "todo cero";
		$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM ubicacionresp";}
		else		
		{ 	
			 //echo "alguno";
			 $_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM ubicacionresp WHERE ubi_sistema='$Sistema' AND ubi_negocio='$Negocio' AND ubi_SE1='$SE1' AND ubi_SE2='$SE2'";
		 }
		
  		$result9=mysql_query($_pagi_sqlConta);
		$row9=mysql_fetch_array($result9);
		
		$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos; 
 						
	    if ( ($Sistema=="0" and $Negocio=="0" and $SE1=="0" and $SE2=="0" and $General=="0") or $General =="1" )
		{ //echo "todo cero otra vez";
			$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp ORDER BY codigo DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
		}
		else
		{   $limit = "LIMIT $_pagi_inicial,$_pagi_cuantos";
			if  ($Sistema == "1" && $Negocio=="0" && $SE1=="0" && $SE2=="0")	
				$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_sistema='$Sistema'  ORDER BY codigo DESC $limit";			
				
			if ($Sistema == "1" && $Negocio=="1" && $SE1=="0" && $SE2=="0")
				$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 	
				WHERE ubi_sistema='$Sistema' AND ubi_Negocio='$Negocio' ORDER BY codigo DESC $limit";			
			if ($Sistema == "1" && $Negocio=="1" && $SE1=="1" && $SE2=="0")
				$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_sistema='$Sistema' AND ubi_Negocio='$Negocio'  AND ubi_SE1='$SE1' ORDER BY codigo DESC $limit";			
			if ($Sistema == "1" && $Negocio=="1" && $SE1=="1" && $SE2=="1")
				$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_sistema='$Sistema' AND ubi_Negocio='$Negocio'  AND ubi_SE1='$SE1' AND ubi_SE2='$SE2' ORDER BY codigo DESC $limit";			
			
			if  ($Negocio == "1" && $Sistema=="0" && $SE1=="0" && $SE2=="0")	
				$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_Negocio='$Negocio' ORDER BY codigo DESC $limit";				
		
			if  ( $SE1 == "1" && $Sistema=="0" && $Negocio=="0" && $SE2=="0")	
				$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_SE1='$SE1' ORDER BY codigo DESC $limit";				

			if  ( $SE2 == "1" && $Sistema=="0" && $Negocio=="0" && $SE1=="0")	
				$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_SE2='$SE2' ORDER BY codigo DESC $limit";				

			if ($Sistema == "1" && $Negocio=="0" && $SE1=="1" && $SE2=="0")
				$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_sistema='$Sistema'  AND ubi_SE1='$SE1' ORDER BY codigo DESC $limit";				
							
			if ($Sistema == "1" && $Negocio=="0" && $SE1=="0" && $SE2=="1")
				$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_sistema='$Sistema'  AND ubi_SE2='$SE2' ORDER BY codigo DESC $limit";				
			
			if ($Negocio == "1" && $Sistema=="0" && $SE1=="1" && $SE2=="0")
				$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_Negocio='$Negocio' AND ubi_SE1='$SE1' ORDER BY codigo DESC $limit";				
			
			if ($Negocio == "1" && $Sistema=="0" && $SE1=="0" && $SE2=="1")
				$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_Negocio='$Negocio' AND ubi_SE2='$SE2' ORDER BY codigo DESC $limit";				
			
			if ($SE1 == "1" && $Sistema=="0" && $Negocio=="1" && $SE2=="0")
				$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_SE1='$SE1' AND  ubi_Negocio='$Negocio' ORDER BY codigo DESC $limit";				
			
			if ($SE1 == "1" && $Sistema=="0" && $Negocio=="0" && $SE2=="1")
				$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_SE1='$SE1' AND ubi_SE2='$SE2' ORDER BY codigo DESC $limit";				
			
			if ($SE2 == "1" && $Sistema=="0" && $SE1=="0" && $Negocio=="1")
				$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_SE2='$SE2' AND ubi_Negocio='$Negocio' ORDER BY codigo DESC $limit";				
			
			if ($SE2 == "1" && $Sistema=="1" && $SE1=="0" && $Negocio=="0")
				$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_SE2='$SE2' AND ubi_sistema='$Sistema' ORDER BY codigo DESC $limit";							
				
			if ($Sistema == "1" && $Negocio=="0" && $SE1=="1" && $SE2=="1")
				$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_SE2='$SE2' AND ubi_sistema='$Sistema' AND ubi_SE1='$SE1' ORDER BY codigo DESC $limit";							
				
			if ($Sistema == "1" && $Negocio=="1" && $SE1=="0" && $SE2=="1")
				$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_SE2='$SE2' AND ubi_sistema='$Sistema' AND ubi_Negocio='$Negocio' ORDER BY codigo DESC $limit";
				
			if ($Sistema == "0" && $Negocio=="1" && $SE1=="1" && $SE2=="1")
				$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_SE2='$SE2' AND ubi_SE1='$SE1' AND ubi_Negocio='$Negocio' ORDER BY codigo DESC $limit";											
		   
		  // $sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp WHERE ubi_sistema='$Sistema' AND ubi_negocio='$Negocio' AND ubi_SE1='$SE1' AND ubi_SE2='$SE2' ORDER BY codigo DESC $limit";
		 }
		
	} else {
		$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM ubicacionresp";
		$result9=mysql_query($_pagi_sqlConta);
		$row9=mysql_fetch_array($result9);
		
		$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos; 
		$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp ORDER BY codigo DESC LIMIT $_pagi_inicial,$_pagi_cuantos";}
		
	$result=mysql_query($sql);
   	while ($row=mysql_fetch_array($result)) 
	{	
			echo "<tr align=\"center\">";
			echo "<td><font size=\"1\">&nbsp;$row[codigo]</font></td>";
			$sql0="SELECT * FROM controlinvent WHERE codigo_usu='$row[codigo]'";
			$result0=mysql_query($sql0);
			$row0=mysql_fetch_array($result0);
			
			echo '<td><font size="1">&nbsp;'.$row0['tipo_medio'].'</font></td>';
			echo "<td><font size=\"1\">&nbsp;$row[fecha]</font></td>";
			echo "<td><font size=\"1\">&nbsp;$row[contenido]</td>";		
			if ($row['ubi_sistema']=="1"){$Sis="Sistema";} else {$Sis="";} 
			if ($row['ubi_negocio']=="1"){$Neg="Negocio";} else {$Neg="";}
			if ($row['ubi_SE1']=="1"){$Ext1="Externo 1";} else {$Ext1="";}
			if ($row['ubi_SE2']=="1"){$Ext2="Externo 2";} else {$Ext2="";}
			echo "<td><font size=\"1\">&nbsp".$Sis." ".$Neg." ".$Ext1." &nbsp;".$Ext2."</td>";
			if (isset($tipo) && $tipo=="A" or $tipo=="B")
			{echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;<a href=\"ubicaionr_last.php?codub=".$row['codub']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></font></td>";}
			echo "<td><font size=\"1\"><a href=\"ver_respaldos.php?codub=".$row['codub']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";
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

if (isset($enviar))
{	 $_pagi_query_string .= "enviar=$enviar&";
	if (!(empty($Sistema))) $_pagi_query_string .= "Sistema=$Sistema&";
	if (!(empty($Negocio))) $_pagi_query_string .= "Negocio=$Negocio&";
	if (!(empty($SE1))) $_pagi_query_string .= "SE1=$SE1&";
	if (!(empty($SE2))) $_pagi_query_string .= "SE2=$SE2&";
	if (!(empty($General))) $_pagi_query_string .= "General=$General&";
	
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
  <table>
    <tr> 
      <td> <input type="submit" name="NAcuerdo" value="NUEVO REGISTRO"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
      </td>
      <td> <input name="IMTODO" type="button" id="RETORNAR2" value="IMPRIMIR TODO" onClick="pagina()"> 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
      </td>
      <td> <!--<input name="RETORNAR" type="submit" id="RETORNAR3" value="RETORNAR"> -->
      </td>
    </tr>
  </table>
</form>
<br>
<script language="JavaScript">
<!--
function pagina() {
	//window.open("ver_respaldostodo.php");
	window.open("ver_respaldostodo_pre.php",'GesTorF1', 'width=575,height=102,status=no,resizable=no,top=250,left=180,dependent=yes,alwaysRaised=no');	
}
-->
</script>
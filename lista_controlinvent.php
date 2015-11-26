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
//if (isset($RETORNAR)){header("location:lista_produccion.php?Naveg=Produccion");}
if (valida("ControlInvent")=="bad") {header("location:pagina_error.php");}   
   
if (isset($_REQUEST['NAcuerdo']))   
{   include("conexion.php");   
    $sql5="SELECT MAX(Codigo) AS Id FROM controlinvent";   
    $result5=mysql_query($sql5);   
    $row5=mysql_fetch_array($result5);   
    $r=$row5['Id']+1;    
    header("location: controlinventario.php?varia1=$r");   
}   
include ("top.php");  
?>   
<HTML>
<HEAD>
<STYLE>
select {FONT-SIZE: 8pt; Font-Family: Arial, Verdana;}
.label {FONT-SIZE: 8pt; Font-Family: Arial, Verdana;}
</STYLE>
</HEAD> 
</BODY>
<?php
	require_once ( "ValidatorJs.php"); 
	if(isset($_REQUEST['varia2'])) $varia2=$_REQUEST['varia2']; else $varia2="";
	if(isset($_REQUEST['varia3'])) $varia3=$_REQUEST['varia3']; else $varia3="";
	if(isset($_REQUEST['varia4'])) $varia4=$_REQUEST['varia4']; else $varia4="";
	
	$valid = new Validator ( "formfiltro" );
	$valid->addIsDate   ( "DA", "MA", "AA", "Fecha Al, $errorMsgJs[date]" );
	$valid->addIsDate   ( "DE", "ME	", "AE", "Fecha Del , $errorMsgJs[date]" );
	$valid->addCompareDates ( "DA", "MA", "AA", "DE", "ME", "AE", "$errorMsgJs[compareDates]" );
	print $valid->toHtml();	 
if(!isset($varia2)){$varia2="G";}
if(!isset($varia3)){$varia3="G";}
if(!isset($varia4)){$varia4="G";}
if(isset($fece) OR isset($obse)){$varia2="G"; $varia3="G"; $varia4="G";}
?>
<form action="lista_controlinvent.php" name="formfiltro" method="post">
<input name="varia2" type="hidden" value="<?php if (isset($varia2)) echo $varia2;?>">
<input name="varia3" type="hidden" value="<?php if (isset($varia3))echo $varia3;?>">
<input name="varia4" type="hidden" value="<?php if (isset($varia4))echo $varia4;?>">
  <table width='100%' align='center' background = "images\fondo.jpg" bordercolor="#006699">
    <tr>          
      <td width="33%" class="menu" background="windowsvista-assets1/main-button-tile2.jpg">&nbsp;<font size="1" face="Verdana, Arial, Helvetica, sans-serif">Codigo:</font> 
        <select name="codigo_usu" onChange="tip_dat(this.value,'<?php if (isset($varia3)) echo $varia3;?>','<?php if (isset($varia4)) echo $varia4;?>')">
          <option value="G" <?php if(isset ($varia2) && $varia2=="G"){echo "selected";}?>>TODO</option>
		  <option value="INF" <?php if(isset ($varia2) && $varia2=="INF"){echo "selected";}?>>INF</option>
          <option value="FRL" <?php if(isset ($varia2) && $varia2=="FRL"){echo "selected";}?>>FRL</option>
          <option value="SBF" <?php if(isset ($varia2) && $varia2=="SBF"){echo "selected";}?>>SBF</option>
        </select>
        <select name="tipo_medio" onChange="tip_dat1('<?php if (isset($varia2)) echo $varia2;?>',this.value,'<?php if (isset($varia4)) echo $varia4;?>')">
          <option value="G" <?php if(isset($varia3) && $varia3=="G"){echo "selected";}?>>TODO</option>
		   <option value="CDL" <?php if(isset ($varia3) && $varia3=="CDL"){echo "selected";}?>>CDL</option>
		   <option value="CDT" <?php if(isset ($varia3) && $varia3=="CDT"){echo "selected";}?>>CDT</option>
           <option value="DCD" <?php if(isset ($varia3) && $varia3=="DCD"){echo "selected";}?>>DCD</option>
           <option value="DVD" <?php if(isset ($varia3) && $varia3=="DVD"){echo "selected";}?>>DVD</option>
           <option value="DSK" <?php if(isset ($varia3) && $varia3=="DSK"){echo "selected";}?>>DSK</option>
           <option value="HDD" <?php if(isset ($varia3) && $varia3=="HDD"){echo "selected";}?>>HDD</option>
        </select>
        <select name="tipo_dato" onChange="tip_dat2('<?php if (isset($varia2)) echo $varia2;?>','<?php if (isset($varia3)) echo $varia3;?>',this.value)">
          <option value="G" <?php if(isset($varia4) && $varia4=="G"){echo "selected";}?>>TODO</option>
		  <?php if(isset($varia2) && ($varia2=="INF" OR $varia2=="FRL")){?>
          <option value="APP" <?php if(isset($varia4) && $varia4=="APP"){echo "selected";}?>>APP</option>
          <option value="BCK" <?php if(isset($varia4) && $varia4=="BCK"){echo "selected";}?>>BCK</option>
		  <option value="BIC" <?php if(isset($varia4) && $varia4=="BIC"){echo "selected";}?>>BIC</option>
		  <option value="DAT" <?php if(isset($varia4) && $varia4=="DAT"){echo "selected";}?>>DAT</option>
          <option value="DRI" <?php if(isset($varia4) && $varia4=="DRI"){echo "selected";}?>>DRI</option>
		  <option value="OFI" <?php if(isset($varia4) && $varia4=="OFI"){echo "selected";}?>>OFI</option>
          <option value="SOP" <?php if(isset($varia4) && $varia4=="SOP"){echo "selected";}?>>SOP</option>
          <option value="VAR" <?php if(isset($varia4) && $varia4=="VAR"){echo "selected";}?>>VAR</option>
          <?php }else{?>
          <option value="CCR" <?php if(isset($varia4) && $varia4=="CCR"){echo "selected";}?>>CCR</option>
          <option value="DAT" <?php if(isset($varia4) && $varia4=="DAT"){echo "selected";}?>>DAT</option>
          <option value="EJC" <?php if(isset($varia4) && $varia4=="EJC"){echo "selected";}?>>EJC</option>
          <option value="JUI" <?php if(isset($varia4) && $varia4=="JUI"){echo "selected";}?>>JUI</option>
          <option value="PER" <?php if(isset($varia4) && $varia4=="PER"){echo "selected";}?>>PER</option>
          <option value="VAR" <?php if(isset($varia4) && $varia4=="VAR"){echo "selected";}?>>VAR</option>
          <?php }?>
        </select> 
        <input type="submit" name="tipos" value="Buscar"></td>      
       
      <td width="37%" class="menu" background="windowsvista-assets1/main-button-tile2.jpg">&nbsp;&nbsp;<font size=1 face="Verdana, Arial, Helvetica, sans-serif">Fecha 
        de Alta Del:</font> 
        <script language="JavaScript" src="calendar.js"></script>
        <select name="DA" id="select5">
          <?php
				$fsist=date("Y-m-d");				
  				$ano=substr($fsist,0,4);
				$mes=substr($fsist,5,2);
				$dia=substr($fsist,8,2);				
					for($i=1;$i<=31;$i++)
					{	if ( isset ($DA) )						
		                {echo "<option value=\"$i\""; if($DA=="$i") echo "selected"; echo">$i</option>";}
						else
						{echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
					}
				?>
        </select> 
        <select name="MA" id="select9">
                <?php
				for($i=1;$i<=12;$i++)
				{	if ( isset($MA) )
    	            {echo "<option value=\"$i\""; if($MA=="$i") echo "selected"; echo">$i</option>";}
					else
					{echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
              </select>
        <select name="AA" id="select6">
          <?php
				for( $i=2002;$i<=2020;$i++ ) 
				{	if ( isset($AA) )
        	        {echo "<option value=\"$i\""; if($AA=="$i") echo "selected"; echo">$i</option>";}
					else
					{echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
        </select>
        <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
        <a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong> 
        <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Al: 
        <select name="DE" id="select7">
                <?php
				$fsist=date("Y-m-d");
				
  				$ano=substr($fsist,0,4);
				$mes=substr($fsist,5,2);
				$dia=substr($fsist,8,2);				

				for($i=1;$i<=31;$i++)
				{	if (isset($DE))
	                {echo "<option value=\"$i\""; if($DE=="$i") echo "selected"; echo">$i</option>";}
					else
					{echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
              </select>
        <select name="ME" id="select2">
          <?php
				for($i=1;$i<=12;$i++)
				{	if (isset($ME))
    	            {echo "<option value=\"$i\""; if($ME=="$i") echo "selected"; echo">$i</option>";}
					else
					{echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
        </select>
        <select name="AE" id="select4">
          <?php
				for($i=2002;$i<=2020;$i++)
				{	
					if (isset($AE))
					{echo "<option value=\"$i\""; if( $AE=="$i" ) echo "selected"; echo">$i</option>";}
					else
        	        {echo "<option value=\"$i\""; if( $ano=="$i" ) echo "selected"; echo">$i</option>";}
				}
				?>
        </select>
        <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
        <a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong> 
        <input type="submit" id ="fece"  name="fece" value="Buscar" <?php  print $valid->onSubmit()?> > 
      </td>   
         
       
      <td width="30%" class="menu" background="windowsvista-assets1/main-button-tile2.jpg">&nbsp;&nbsp; <font size=1 face="Verdana, Arial, Helvetica, sans-serif"> 
        Por Observ.:</font> 
        <?php 
		 if (isset($cadena))echo "<input name='cadena' type='text' size='20' maxlength='50' class='label' VALUE='$cadena'>";
		 else echo "<input name='cadena' type='text' size='20' maxlength='50' class='label'>";		  
       ?>
        <input type="submit" name="obse" value="Buscar">   
       </td>   
    </tr>   
</table>   
</form>      
<table width="846" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699">
  <tr>    
    <td width="815" height="42" valign="top">   
    <table width="846" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="8" background="windowsvista-assets1/main-button-tile.jpg" height="30">LISTA DE INVENTARIO DE MEDIOS<br>
            <?php if (isset($tipos)) $tituloc = " BUSQUEDA POR CODIGO";
		     if (isset($fece)) $tituloc = " BUSQUEDA POR FECHA:&nbsp;&nbsp;&nbsp;DEL".$DA."-".$MA."-".$AA."&nbsp;&nbsp;AL: ".$DE."-".$ME."-".$AE;
			 if (isset($obse)) $tituloc = "BUSQUEDA POR OBSERVACIONES";
			 if (isset($tituloc))
				echo "<font face=arial size=1>".$tituloc."</font>";
		  ?>
          </th>
        </tr>
        <tr align="center"> 
          <th width="150" class="menu">CODIGO</th>
          <th width="90" class="menu">FECHA ALTA</th>
          <th width="230" class="menu">OBSERVACIONES</th>
          <th width="90" class="menu">FECHA BAJA</th>
          <th width="160" class="menu">FECHA DESTRUCCION</th>
		  <?php
		  if ($tipo == "A" OR $tipo=="B") {?>
          <th width="30" class="menu">MODIFICAR</th>
		  <?php }?>
          <th width="30" class="menu">IMPRIMIR</th>
        </tr>
        <?php    
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}
   
    $_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM controlinvent";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	
$sql = "SELECT * , DATE_FORMAT(FechaAlta, '%d/%m/%Y') AS FechaAlta, DATE_FORMAT(FechaBaja, '%d/%m/%Y') AS FechaBaja, DATE_FORMAT(FechaDestruc, '%d/%m/%Y') AS FechaDestruc   
	FROM controlinvent ORDER BY Codigo DESC LIMIT $_pagi_inicial,$_pagi_cuantos";         

if (isset($tipos)){
	if($varia2!="G"){$var1="codigo_usu='$varia2' AND ";}
	if($varia3!="G"){$var2="tipo_medio='$varia3' AND ";}
	if($varia4!="G"){$var3="tipo_dato='$varia4' AND ";}
	if(!empty($var2)) $var_t=$var1.$var2.$var3." 1=1";

		$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM controlinvent WHERE $var_t";
		$result9 = mysql_query($_pagi_sqlConta);
		$row9 = mysql_fetch_array($result9);
		$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;    
		$sql = "SELECT * , DATE_FORMAT(FechaAlta, '%d/%m/%Y') AS FechaAlta, DATE_FORMAT(FechaBaja, '%d/%m/%Y') AS FechaBaja, DATE_FORMAT(FechaDestruc, '%d/%m/%Y') AS FechaDestruc   
				FROM controlinvent WHERE $var_t ORDER BY codigo_usu ASC, tipo_medio ASC, tipo_dato ASC, nro_corre DESC, Codigo DESC LIMIT $_pagi_inicial,$_pagi_cuantos";          
}
if ( isset( $fece ) )               
	{	if (strlen($DA) == 1){ $DA = "0".$DA; }
		 if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
         $fec_al = $AA."-".$MA."-".$DA;   
		 if (strlen($DE) == 1){ $DE = "0".$DE; }
		 if (strlen($ME) == 1){ $ME = "0".$ME; }
		 $fec_del = $AE."-".$ME."-".$DE; 
		  $_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM controlinvent  WHERE FechaAlta BETWEEN '$fec_al' AND '$fec_del'";
		  $result9=mysql_query($_pagi_sqlConta);
		  $row9=mysql_fetch_array($result9);

		  $_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
		  $_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;   
		  
          $sql = "SELECT * , DATE_FORMAT(FechaAlta, '%d/%m/%Y') AS FechaAlta, DATE_FORMAT(FechaBaja, '%d/%m/%Y') AS FechaBaja, DATE_FORMAT(FechaDestruc, '%d/%m/%Y') AS FechaDestruc   
          FROM controlinvent WHERE FechaAlta BETWEEN '$fec_al' AND '$fec_del'  ORDER BY Codigo DESC LIMIT $_pagi_inicial,$_pagi_cuantos";                
}   
if ( isset($obse) )               
{	if ( !empty($cadena) )
	{	  $_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM controlinvent WHERE Observ LIKE '%$cadena%'";
		  $result9=mysql_query($_pagi_sqlConta);
		  $row9=mysql_fetch_array($result9);

		  $_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
		  $_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos; 
		  
		$sql = "SELECT * , DATE_FORMAT(FechaAlta, '%d/%m/%Y') AS FechaAlta, DATE_FORMAT(FechaBaja, '%d/%m/%Y') AS FechaBaja, DATE_FORMAT(FechaDestruc, '%d/%m/%Y') AS FechaDestruc   
        FROM controlinvent WHERE Observ LIKE '%$cadena%' ORDER BY Codigo DESC LIMIT $_pagi_inicial,$_pagi_cuantos"; 				
	}
}   
	$result=mysql_query($sql);   
	while ($row=mysql_fetch_array($result))   
	{ 	echo "<tr align='center'>";   
		echo "<td>$row[codigo_usu] - $row[tipo_medio] - $row[tipo_dato] - $row[nro_cds] - $row[nro_corre]</td>";   
		echo "<td>&nbsp;$row[FechaAlta]</td>";   
		echo "<td>&nbsp;$row[Observ]</td>";   
		if ($row['FechaBaja']=="00/00/0000")  // here   
		{	echo "<td><a href=\"controlinventario_baja.php?Codigo=".$row['Codigo']."\">DAR DE BAJA</a></td>";   
			echo "<td>&nbsp;DAR DE BAJA ANTES</td>";
		}   
		else 
		{	echo "<td>&nbsp;$row[FechaBaja]</td>";   
			 if ($row['FechaDestruc']=="00/00/0000") //here 0000-00-00   
			 {echo "<td>&nbsp;<a href=\"controlinventario_destruc.php?Codigo=".$row['Codigo']."\">DESTRUIR</a></td>";}   
			 else {	echo "<td>&nbsp;$row[FechaDestruc]</td>";}}// here
		  	if ($tipo == "A" OR $tipo=="B") 
			{
		 		echo "<td>&nbsp;<font size=\"1\"><a href=\"lista_controlinvent_modi.php?Codigo=".$row['Codigo']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></font></td>";    
		 	}
		 echo "<td>&nbsp;<font size=\"1\"><a href=\"ver_controlinventario.php?Codigo=".$row['Codigo']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";   
		 echo "</tr>";   
	   }
?>
      </table>   
      
    </td>   
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
if (isset($tipos))
{ $_pagi_query_string .= "tipos=$tipos&varia2=$varia2&varia3=$varia3&varia4=$varia4&";}
if (isset($fece))
{ $_pagi_query_string .= "fece=$fece&DA=$DA&MA=$MA&AA=$AA&DE=$DE&ME=$ME&AE=$AE&"; }
if (isset($obse))
{ $_pagi_query_string .= "obse=$obse&cadena=$cadena&"; }

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
		// $_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_i."&tipos=$tipos&sfecha=$sfecha&sw=1'>".$_pagi_i."</a>&nbsp;";
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
<form action="" method="get">
<table><tr>
    <td>
	
    <input type="submit" name="NAcuerdo" value="NUEVO CONTROL DE MEDIOS">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;        
    </td>    
	<td>    
	<input name="IMTODO" type="button" id="IMTODO" value="IMPRIMIR TODO" onClick="pagina()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
    </td>
	<td>
	<!--<input type="submit" name="RETORNAR" value="RETORNAR"> -->	
  	</td> 
	</tr>
</table>  
</form> 
<script language="JavaScript">   
		 var form="formfiltro";
		 var cal = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		var cal1 = new calendar1(document.forms[form].elements['DE'], document.forms[form].elements['ME'], document.forms[form].elements['AE']);
		 	cal1.year_scroll = true;
			cal1.time_comp = false;

function pagina(){
		window.open("ver_controlinventariotodo_pre.php",'GesTorF1','width=560,height=90,status=no,resizable=no,top=200,left=180,dependent=no,alwaysRaised=no');
}

	function irapagina_c(pagina)
	{         
 		 if (pagina!="") {self.location = pagina;}
	}
	function tip_dat(co,med,dat)
	{        
		irapagina_c("lista_controlinvent.php?varia2="+co+"&varia3="+med+"&varia4="+dat); 
	}
	function tip_dat1(co,med,dat)
	{        
		irapagina_c("lista_controlinvent.php?varia2="+co+"&varia3="+med+"&varia4="+dat); 
	}
	function tip_dat2(co,med,dat)
	{        
		irapagina_c("lista_controlinvent.php?varia2="+co+"&varia3="+med+"&varia4="+dat); 
	}
	<?php	if (isset($msg) && $msg=="si"){?>
		alert ("El Activo fue modificado con exito.\n \n Mensaje generado por GesTor F1.");
	<?php }?>
</script>   
</BODY>
</HTML>
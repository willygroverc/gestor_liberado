<?php 
include ("conexion.php"); 

	
$verif=$_GET['verif'];
$id_minuta=$_GET['id_minuta'];
if(isset($_REQUEST['var']))
{	$var=$_REQUEST['var'];
	unset($num_cod);
	if(isset($_REQUEST['codigo']))
		$datos = $codigo.":".$eano."/".$emes."/".$edia.":".$ano."/".$mes."/".$dia.":".$elab_por.":".$tipo_min.":".$h."/".$m.":".$lugar.":".$comentario;
	$sql2 = "SELECT * FROM agenda WHERE id_agenda='$var'";
	$result2 = mysql_db_query($db,$sql2,$link);
	$row2 = mysql_fetch_array($result2);
	$sql28 = "SELECT MAX(num_codigo) AS ncod FROM minuta WHERE codigo='$row2[codigo]'";	
	$result28=mysql_db_query($db,$sql28,$link);
	$row28 = mysql_fetch_array($result28);
	$num_cod = $row28['ncod']+1;
}
if (isset($_REQUEST['RETORNAR'])){
	if($verif=="2"){
		//echo "$row28[ncod]";
	}
	header("location: lista_agenda.php?id_minuta=$var");
}
if (isset($_REQUEST['ATEMA'])){
	if ( $insertado == "2" ) $insertado = "0";	
	else   $insertado = "1";	
	header("location: atema.php?id_minuta=$var&dato=$datos&insertado=$insertado&num_cod=$num_cod");
}
if (isset($_REQUEST['PROPOSICIONES'])){
	if ( $insertado == "2" ) $insertado = "0";	
	else   $insertado = "1";	
	header("location: proposiciones.php?id_minuta=$var&dato=$datos&insertado=$insertado&num_cod=$num_cod");
}
if (isset($_REQUEST['VTEMA'])){
	if ( $insertado == "2" ) $insertado = "0";	
	else   $insertado = "1";
	header("location: vtema.php?id_minuta=$var&dato=$datos&insertado=$insertado&num_cod=$num_cod");
}
if (isset($_REQUEST['RESULTADOS'])){
	if ( $insertado == "2" ) $insertado = "0";	
	else   $insertado = "1";	
	header("location: resultados.php?id_minuta=$var&dato=$datos&insertado=$insertado&num_cod=$num_cod");
}
if (isset($_REQUEST['ACCIONES'])){
	if ( $insertado == "2" ) $insertado = "0";	
	else   $insertado = "1";		
	header("location: acciones.php?id_minuta=$var&dato=$datos&insertado=$insertado&num_cod=$num_cod");
}
if (isset($_REQUEST['GUARDAR'])){
	if ( $insertado == "2" )
	{ 	$en_fecha = "$eano-$emes-$edia";
		$fecha = "$ano-$mes-$dia";
		$hora = "$h:$m";	
		require_once('funciones.php');
		$codigo=_clean($codigo);
	$elab_por=_clean($elab_por);
	$en_fecha=_clean($en_fecha);
	$comentario=_clean($comentario);
	$fecha=_clean($fecha);
	$hora=_clean($hora);
	$lugar=_clean($lugar);
	$comentario=_clean($comentario);
	$recau=_clean($recau);
	$prop=_clean($prop);
	
	$codigo=SanitizeString($codigo);
	$elab_por=SanitizeString($elab_por);
	$en_fecha=SanitizeString($en_fecha);
	$comentario=SanitizeString($comentario);
	$fecha=SanitizeString($fecha);
	$hora=SanitizeString($hora);
	$lugar=SanitizeString($lugar);
	$comentario=SanitizeString($comentario);
	$recau=SanitizeString($recau);
	$prop=SanitizeString($prop);
		$sql = "UPDATE minuta SET codigo='$codigo',elab_por='$elab_por',en_fecha='$en_fecha',tipo_min='$tipo_min',
		fecha='$fecha', hora='$hora',lugar='$lugar', comentario='$comentario', recau='$recau', prop='$prop' WHERE id_minuta='$var'";
		//echo $sql;
		mysql_db_query($db,$sql,$link);
	}
	else
	{	$en_fecha = "$eano-$emes-$edia";
		$fecha = "$ano-$mes-$dia";
		$hora = "$h:$m";
		$sql28 = "SELECT MAX(num_codigo) AS ncod FROM minuta WHERE codigo='$codigo' ";	
		$result28=mysql_db_query($db,$sql28,$link);
		$row28=mysql_fetch_array($result28);
		$num_codigo=$row28['ncod']+1;
		require_once('funciones.php');
		$codigo=_clean($codigo);
		$elab_por=_clean($elab_por);
		$en_fecha=_clean($en_fecha);
		$tipo_min=_clean($tipo_min);
		$fecha=_clean($fecha);
		$hora=_clean($choraodigo);
		$lugar=_clean($lugar);
		$var=_clean($var);
		$num_codigo=_clean($num_codigo);
		$comentario=_clean($comentario);
		$recau=_clean($recau);
		$prop=_clean($prop);
		
		$codigo=SanitizeString($codigo);
		$elab_por=SanitizeString($elab_por);
		$en_fecha=SanitizeString($en_fecha);
		$tipo_min=SanitizeString($tipo_min);
		$fecha=SanitizeString($fecha);
		$hora=SanitizeString($hora);
		$lugar=SanitizeString($lugar);
		$var=SanitizeString($var);
		$num_codigo=SanitizeString($num_codigo);
		$comentario=SanitizeString($comentario);
		$recau=SanitizeString($recau);
		$prop=SanitizeString($prop);
		$sql="INSERT INTO ".
		"minuta (codigo,elab_por,en_fecha,tipo_min,fecha,hora,lugar,id_minuta,num_codigo,comentario,recau,prop)".
		"VALUES ('$codigo','$elab_por','$en_fecha','$tipo_min','$fecha','$hora','$lugar','$var','$num_codigo','$comentario','$recau','$prop')";
		mysql_db_query($db,$sql,$link);
	}	
	header("location: lista_agenda.php");
}
if (isset($_REQUEST['VASISTENTE'])){ 
	//echo "*".$insertado;
	if ( $insertado == "2" ) $insertado = "0";	
	else   $insertado = "1";
	header("location: vasistente.php?id_minuta=$var&dato=$datos&insertado=$insertado&num_cod=$num_cod");
}
if (isset($_REQUEST['AASISTENTE'])){
	if ( $insertado == "2" ) $insertado = "0";	
	else   $insertado = "1";
	header("location: aasistente.php?id_minuta=$var&dato=$datos&insertado=$insertado&num_cod=$num_cod");
}
if (isset($_REQUEST['AASISTENTE_EXT'])){
	if ( $insertado == "2" ) $insertado = "0";	
	else   $insertado = "1";
	header("location: aasistente_ext.php?id_minuta=$var&dato=$datos&insertado=$insertado&num_cod=$num_cod");
}
else{
include ("top.php") ;
$sql2 = "SELECT *,DATE_FORMAT(en_fecha, '%d/%m/%Y') AS en_fecha1,DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha1 FROM agenda WHERE id_agenda='$id_minuta'";
$result2 = mysql_db_query($db,$sql2,$link);
$row2 = mysql_fetch_array($result2);

if ( !(empty($cad)) )
{ 	$sql2 = "SELECT *,DATE_FORMAT(en_fecha, '%d/%m/%Y') AS en_fecha1,DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha1 FROM minuta WHERE id_minuta='$id_minuta'";
	$result2 = mysql_db_query($db,$sql2,$link);
	$row2 = mysql_fetch_array($result2);	
	$row2[tipo_reu] = $row2[tipo_min]; 
}
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsNotEmpty ( "elab_por",  "Elaborado por, $errorMsgJs[empty]" );
$valid->addIsDate   ( "edia", "emes", "eano", "En Fecha, $errorMsgJs[date]" );
$valid->addIsNumber  ( "recau", "Recaudacion, $errorMsgJs[number]" );
$valid->addIsNumber  ( "prop", "Proposicion, $errorMsgJs[number]" );
$valid->addIsDate   ( "dia", "mes", "ano", "Fecha de Reunion, $errorMsgJs[date]" );
$valid->addCompareDates   ( "edia", "emes", "eano", "dia", "mes", "ano", "En Fecha y Fecha de Reunion, $errorMsgJs[compareDates]" );
$valid->addIsTime ("h", "m", "Hora,  $errorMsgJs[time]");
$valid->addExists ( "lugar",  "Lugar, $errorMsgJs[empty]" );
print $valid->toHtml ();
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
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr> 
    <td> 
      <form name="form1" method="post" action="<?php echo $PHP_SELF ?>" onKeyPress="return Form()">
	  <input name="var" type="hidden" value="<?php echo $id_minuta;?>">	
	  <input name="verif" type="hidden" value="<?php echo $verif;?>">	  
	  <input name="codigo" type="hidden" value="<?php echo $row2[codigo];?>">
	  <input name="insertado" type="hidden" value="<?php echo $insertado;?>">	 	  
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
           
		    <td><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
                <strong>MINUTA DE REUNION</strong></font></div></td>
          </tr>
        </table>
                
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td> </td>
          </tr>
          <tr>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;
             <strong> Codigo :</strong></font>&nbsp;  <font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php 
				if($row2['codigo']=="CSI"){echo "&nbsp;&nbsp;&nbsp;$row[codigo] (Comite de Sistemas)";}
				elseif($row2['codigo']=="CCP"){echo "&nbsp;&nbsp;&nbsp;$row[codigo] (Comite de Cambios en Prod.)";}
				elseif($row2['codigo']=="CRC"){echo "&nbsp;&nbsp;&nbsp;$row[codigo] (Comite de Recup. y Conting.)";}
				elseif($row2['codigo']=="OTRO"){echo "&nbsp;&nbsp;&nbsp;$row[codigo]";}
			  
			  echo "&nbsp;&nbsp;&nbsp;".$row2['codigo'];?>
              </font><font size="2" face="Arial, Helvetica, sans-serif"> 
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <strong>Elaborado 
              por :</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong> 
              <select name="elab_por" id="select10">
                <option value="0"></option>
                <?php 
			  $sql21 = "SELECT * FROM users WHERE tipo2_usr='T' ORDER BY apa_usr ASC";
			  $result21 = mysql_db_query($db,$sql21,$link);
			  while ($row21 = mysql_fetch_array($result21)) 
			  {
				if ($row2['elab_por']==$row21['login_usr'])
					echo "<option value=\"$row21[login_usr]\" selected>$row21[nom_usr] $row21[apa_usr] $row21[ama_usr]</option>";
				else
					echo "<option value=\"$row21[login_usr]\">$row21[nom_usr] $row21[apa_usr] $row21[ama_usr]</option>";
	            }
			   ?>
              </select>
              </strong></td>
          </tr>
          <tr> 
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td><div align="center"> 
                <p align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;
                  <strong>En fecha :</strong></font>&nbsp; <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                  <select name="edia" >
                    <?php
							
				$vfecha=date("Y-m-d");
				$a1=substr($vfecha,0,4);
				$m1=substr($vfecha,5,2);
				$d1=substr($vfecha,8,2);
  				
				if($verif==1)
				{				
  				$a1=substr($row2[en_fecha],0,4);
				$m1=substr($row2[en_fecha],5,2);
				$d1=substr($row2[en_fecha],8,2);
				}
				else
				{	  $a1=substr($row2[en_fecha],0,4);
				      $m1=substr($row2[en_fecha],5,2);
				      $d1=substr($row2[en_fecha],8,2);
				}
				
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
					}
			  ?>
                  </select>
                  <select name="emes">
                    <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
                  </select>
                  <select name="eano">
                    <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
                  </select>
                  </font><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                  </font></strong></p>
              </div></td>
            <td colspan="2"><div align=""> 
                <p><font size="2" face="Arial, Helvetica, sans-serif"><strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				Tipo de 
                  Reunion  :&nbsp;&nbsp;&nbsp; </strong><font size="2" face="Arial, Helvetica, sans-serif"> 
                  <select name="tipo_min">
                    <option value="Ordinaria" <?php if ($row2[tipo_reu]=="Ordinaria") echo "selected";?>>Ordinaria</option>
                    <option value="Extraordinaria" <?php if ($row2[tipo_reu]=="Extraordinaria") echo "selected";?>>Extraordinaria</option>
                    <option value="Emergencia" <?php if ($row2[tipo_reu]=="Emergencia") echo "selected";?>>Emergencia</option>
                    <option value="Otros" <?php if ($row2[tipo_reu]=="Otros") echo "selected";?>>Otros</option>
                  </select>
                  </font> </font></p>
              </div></td>
          </tr>
          <tr> 
            <td width="36%" height="62">
<div align="center"> 
                <p align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp; 
                  <strong>Fecha de Reunion:</strong></font>&nbsp; <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                  <select name="dia" >
                    <?php
				
				
				$v2fecha=date("Y-m-d");
				$a1=substr($v2fecha,0,4);
				$m1=substr($v2fecha,5,2);
				$d1=substr($v2fecha,8,2);
  					
				if($verif==1)
				{					
  				$a1=substr($row2[fecha],0,4);
				$m1=substr($row2[fecha],5,2);
				$d1=substr($row2[fecha],8,2);
				}
				else
				{     $a1=substr($row2[fecha],0,4);
				      $m1=substr($row2[fecha],5,2);
				      $d1=substr($row2[fecha],8,2);				
				}
				
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
					}
			  ?>
                  </select>
                  <select name="mes">
                    <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
                  </select>
                  <select name="ano">
                    <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
                  </select>
                  </font><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                  </font></strong></p>
                <p>&nbsp;</p>
              </div></td>
            <td width="25%"><p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <strong>Hora :</strong></font> 
                <?php
				
				
				$vhora=date("H:i:s");
				$h1=substr($vhora,0,2);
				$mi1=substr($vhora,3,2);
  							  
				if($verif==1)
				{			
  				$h1=substr($row2[hora],0,2);
				$mi1=substr($row2[hora],3,2);
				}
				else
				{			
  				$h1=substr($row2[hora],0,2);
				$mi1=substr($row2[hora],3,2);
				}
			?>
                <font size="2">
<select name="h" id="h">
                  <option value="00" <?php if($h1=="00") echo "selected"?>>00</option>
                  <option value="01"<?php if($h1=="01") echo " selected"?>>01</option>
                  <option value="02"<?php if($h1=="02") echo " selected"?>>02</option>
                  <option value="03"<?php if($h1=="03") echo " selected"?>>03</option>
                  <option value="04"<?php if($h1=="04") echo " selected"?>>04</option>
                  <option value="05"<?php if($h1=="05") echo " selected"?>>05</option>
                  <option value="06"<?php if($h1=="06") echo " selected"?>>06</option>
                  <option value="07"<?php if($h1=="07") echo " selected"?>>07</option>
                  <option value="08"<?php if($h1=="08") echo " selected"?>>08</option>
                  <option value="09"<?php if($h1=="09") echo " selected"?>>09</option>
                  <option value="10"<?php if($h1=="10") echo " selected"?>>10</option>
                  <option value="11"<?php if($h1=="11") echo " selected"?>>11</option>
                  <option value="12"<?php if($h1=="12") echo " selected"?>>12</option>
                  <option value="13"<?php if($h1=="13") echo " selected"?>>13</option>
                  <option value="14"<?php if($h1=="14") echo " selected"?>>14</option>
                  <option value="15"<?php if($h1=="15") echo " selected"?>>15</option>
                  <option value="16"<?php if($h1=="16") echo " selected"?>>16</option>
                  <option value="17"<?php if($h1=="17") echo " selected"?>>17</option>
                  <option value="18"<?php if($h1=="18") echo " selected"?>>18</option>
                  <option value="19"<?php if($h1=="19") echo " selected"?>>19</option>
                  <option value="20"<?php if($h1=="20") echo " selected"?>>20</option>
                  <option value="21"<?php if($h1=="21") echo " selected"?>>21</option>
                  <option value="22"<?php if($h1=="22") echo " selected"?>>22</option>
                  <option value="23"<?php if($h1=="23") echo " selected"?>>23</option>
                </select>
                </font> <strong>:</strong> <font size="2">
<select name="m" id="select2">
                  <option value="00" <?php if($mi1=="00") echo "selected"?>>00</option>
                  <option value="15"<?php if($mi1=="15") echo " selected"?>>15</option>
                  <option value="30"<?php if($mi1=="30") echo " selected"?>>30</option>
                  <option value="45"<?php if($mi1=="45") echo " selected"?>>45</option>
                </select></font>
              </p>
              <p>&nbsp; </p></td>
            <td width="39%"><div align="center"> 
                <p><font size="2" face="Arial, Helvetica, sans-serif"><strong>Lugar:</strong> </font>
                  <input name="lugar" type="text" value="<?php echo $row2[lugar];?>" size="35" maxlength="150">
                </p>
                <p>&nbsp;</p>
                </div></td>
          </tr>
        </table>
               
        <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
            <td><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
                <strong>ASISTENTES</strong></font></div></td>
          </tr>
        </table>
	   
	    <table width="90%" border="2" align="center" cellpadding="0" cellspacing="0">
          <tr bgcolor="#006699"> 
            <td width="6%" height="21"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>N&ordf;</strong></font></div></td>
            <td width="30%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">NOMBRE</font></strong></font></div></td>
            <td width="12%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">CARGO/ROL</font></strong></font></div></td>
          </tr>
		            <?php
		$cont=0;	
		$sql24 = "SELECT * FROM asistentes WHERE id_minuta='$id_minuta'";
		$result24=mysql_db_query($db,$sql24,$link);
		while($row24=mysql_fetch_array($result24)) 
  		{
		$cont=$cont+1;
		 ?>
          <tr align="center">
            <td >&nbsp;<?php echo $cont?></td>
			<?php 	$sql5 = "SELECT * FROM users WHERE login_usr='$row24[nombre]'";
		    	$result5 = mysql_db_query($db,$sql5,$link);
		    	$row5 = mysql_fetch_array($result5);
				if (!$row5[login_usr])
				{echo "<td>&nbsp;$row24[nombre]</td>";}
				else
				{echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";}?>
            <td>&nbsp;<?php echo $row24[cargo]?></td>
          </tr>
		            <?php 
		
		 }
		 ?>
          <tr> 
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr> 
	
            <td colspan="3"> <div align="center"> 
                <input type="submit" name="VASISTENTE" value="VERIFICAR ASISTENTES">
                <br>
                <input type="submit" name="AASISTENTE" value="AGREGAR ASISTENTES INTERNOS">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="AASISTENTE_EXT" value="AGREGAR ASISTENTES EXTERNOS">
              </div></td>
          </tr>
        </table>
	    <br>
        <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
            <td><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
                <strong>TEMAS DISCUTIDOS</strong></font></div></td>
          </tr>
        </table>
                
        <table width="90%" border="2" align="center" cellpadding="0" cellspacing="0">
          <tr bgcolor="#006699"> 
            <td width="6%" height="22"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>N&ordf;</strong></font></div></td>
            <td width="30%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">TEMA</font></strong></font></div></td>
            <td width="12%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">RESPONSABLE</font></strong></font></div></td>
            <td width="12%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">DURACION 
                (min)</font></strong></font></div></td>
          </tr>
		  
		<?php
		$cont=0;
		$ttotal=0;	
		$sql27 = "SELECT * FROM temad WHERE id_minuta='$id_minuta'";
		$result27=mysql_db_query($db,$sql27,$link);
		while($row27=mysql_fetch_array($result27)) 
  		{
		$cont=$cont+1;
		 ?>
          <tr align="center"> 
            <td>&nbsp;<?php echo $cont?></td>
            <?php 	$sql5 = "SELECT * FROM temas WHERE id_tema='$row27[tema]' AND id_agenda='$id_minuta'";
		    	$result5 = mysql_db_query($db,$sql5,$link);
		    	$row5 = mysql_fetch_array($result5);
				if (!$row5[id_tema])
				{echo "<td>&nbsp;$row27[tema]</td>";}
				else
				{echo "<td>&nbsp;$row5[tema]</td>";}
					
				$sql5 = "SELECT * FROM users WHERE login_usr='$row27[responsable]'";
		    	$result5 = mysql_db_query($db,$sql5,$link);
		    	$row5 = mysql_fetch_array($result5);
				if (!$row5[login_usr])
				{echo "<td>&nbsp;$row27[responsable]</td>";}
				else
				{echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";}?>
			<td >&nbsp;<?php echo $row27[duracion];$ttotal+=$row27[duracion];?></td>
          </tr>
		  
		  <?php }?>
		  <tr bgcolor="#CCCCCC"> 
            <td colspan="3"><div align="right"><font color="#000000" face="Arial, Helvetica, sans-serif"><strong>TOTAL 
                =</strong></font></div></td>
            <td align="center"><font color="#000000" face="Arial, Helvetica, sans-serif"><strong>&nbsp; 
              <?php 
			  $minutos=$ttotal%60;
			  $ttotal-=$minutos;
			  $horas=$ttotal/60;
			  if($horas > 0) echo $horas." hrs. ".$minutos." min.";
			  else echo $minutos." min.";?>
              </strong></font></td>
          </tr>
          <tr> 
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="4"> <div align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="VTEMA" value="VERIFICAR TEMAS">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="ATEMA" value="AGREGAR TEMAS">
              </div></td>
          </tr>
        </table>
               
  
        <br>
        <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr>
            <td><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>RESULTADOS 
                POR TEMA</strong></font></div></td>
          </tr>
        </table>
		<table width="90%" border="2" align="center" cellpadding="0" cellspacing="0">
          <tr bgcolor="#006699"> 
            <td width="6%" height="21"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>N&ordf;</strong></font></div></td>
            <td> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>RESULTADO</strong></font></div></td>
          </tr>
          <?php
		$sql27 = "SELECT * FROM rtema WHERE id_minuta='$id_minuta' ORDER BY id_tema ASC";
		$result27=mysql_db_query($db,$sql27,$link);
		while($row27=mysql_fetch_array($result27)) 
  		{
		?>
          <tr align="center"> 
            <td>&nbsp;<?php echo $row27[id_tema] ;?></td>
            <td >&nbsp;<?php echo $row27[resultado]?>&nbsp;&nbsp;</td>
          </tr>
          <?php }?>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2"> <div align="center"><input type="submit" name="RESULTADOS" value="AGREGAR RESULTADOS"></div></td>
          </tr>
        </table>
        <br>
        <table width="100%" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td>
			<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
                <tr>
            <td><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>ACCIONES 
                POR TEMA</strong></font></div></td>
          </tr>
        </table>
		      <table width="90%" border="2" align="center" cellpadding="0" cellspacing="0">
                <tr bgcolor="#006699"> 
            <td width="10%" height="21"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>N&ordf;</strong></font></div></td>
                  <td width="46%" bgcolor="#006699"> 
                    <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">ACCION</font></strong></font></div></td>
            <td width="22%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">RESPONSABLE</font></strong></font></div></td>
            <td width="22%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">FECHA 
                LIMITE </font></strong></font></div></td>
          </tr>
		  
		<?php
		$cont=0;	
		$sql27 = "SELECT *, DATE_FORMAT(flimite, '%d/%m/%Y') AS flimite FROM atema WHERE id_minuta='$id_minuta' ORDER BY id_tema ASC";
		$result27=mysql_db_query($db,$sql27,$link);
		while($row27=mysql_fetch_array($result27)) 
  		{
		$cont=$cont+1;
		 ?>
          <tr align="center"> 
           <td >&nbsp;<?php echo $row27[id_tema]?></td>
            <td >&nbsp;<?php echo $row27[accion]?></td>
			<?php	$sql5 = "SELECT * FROM users WHERE login_usr='$row27[responsable]'";
		    $result5 = mysql_db_query($db,$sql5,$link);
		    $row5 = mysql_fetch_array($result5);
			echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";?>
            <td >&nbsp;<?php echo $row27[flimite];?></td>
          </tr>
		  
		  <?php }?>
          <tr> 
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr align="center"> 
            <td colspan="4"><input type="submit" name="ACCIONES" value="AGREGAR ACCIONES"></td>
          </tr>
        </table>
		<br>
        <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr>
            <td><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>COMENTARIOS</strong></font></div></td>
          </tr>
        </table>
              <p align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp; 
                </font><font size="2" face="Arial, Helvetica, sans-serif"> 
                <textarea name="comentario" cols="100"><?php echo $row2[comentario];?></textarea>
                </font>
                <br>
                <br>
                <br>
                <table width="75%" border="0">
                  <tr> 
                    <td width="50%"><div align="right"><strong><font size="2" face="Arial, Helvetica, sans-serif">Recaudacion 
                        :</font></strong> </div></td>
                    <td width="50%"> <div align="left">
                        <input name="recau" type="text" id="recau" value="0" size="6">
                        <strong><font size="2" face="Arial, Helvetica, sans-serif"> 
                        Bs.</font></strong> </div></td>
                  </tr>
                </table>
              </div>
              <p align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp; 
                </font><font size="2" face="Arial, Helvetica, sans-serif"> </font> 
            </td>
          </tr>
          <tr> 
            <td><div align="center"><br>
                <input type="submit" name="GUARDAR" value="GUARDAR" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="RETORNAR" value="RETORNAR">
              </div></td>
          </tr>
        </table>
        </form>
      
    </td>
  </tr>
</table>
  <script language="JavaScript">
		<!-- 
		 var form="form1";
		 var cal = new calendar1(document.forms[form].elements['edia'], document.forms[form].elements['emes'], document.forms[form].elements['eano']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		var cal1 = new calendar1(document.forms[form].elements['dia'], document.forms[form].elements['mes'], document.forms[form].elements['ano']);
		 	cal1.year_scroll = true;
			cal1.time_comp = false;
//-->
</script>
 <?php } ?> 
<?php include("top_.php");?>
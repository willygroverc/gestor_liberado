<?php 
include ("conexion.php");
if ($RETORNAR){	header("location: lista_agenda.php?id_minuta=$var");}
 $id = $id_minuta;
if ($ATEMA){if(verif==1){header("location: atema_last.php?id_minuta=$var");}
	else
	{$en_fecha="$eano-$emes-$edia";
	$fecha="$ano-$mes-$dia";
	$hora="$h:$m";
	$sql="UPDATE minuta SET codigo='$codigo',elab_por='$elab_por',en_fecha='$en_fecha',tipo_min='$tipo_min', ".
		"fecha='$fecha',hora='$hora',lugar='$lugar' WHERE id_minuta='$var'";
  	mysql_db_query($db,$sql,$link);
	header("location: atema_last.php?id_minuta=$var");
	}
}
if ($PROPOSICIONES){
	if(verif==1){header("location: proposiciones_last.php?id_minuta=$var");}
	else
	{$en_fecha="$eano-$emes-$edia";
	$fecha="$ano-$mes-$dia";
	$hora="$h:$m";
	$sql="UPDATE minuta SET codigo='$codigo',elab_por='$elab_por',en_fecha='$en_fecha',tipo_min='$tipo_min', ".
		"fecha='$fecha',hora='$hora',lugar='$lugar' WHERE id_minuta='$var'";
  	mysql_db_query($db,$sql,$link);
	header("location: proposiciones_last.php?id_minuta=$var");
	}
}
if ($VTEMA)
{	
	if(verif==1){header("location: vtema_last.php?id_minuta=$var");}
	else
	{$en_fecha="$eano-$emes-$edia";
	$fecha="$ano-$mes-$dia";
	$hora="$h:$m";
	$sql="UPDATE minuta SET codigo='$codigo',elab_por='$elab_por',en_fecha='$en_fecha',tipo_min='$tipo_min', ".
		"fecha='$fecha',hora='$hora',lugar='$lugar' WHERE id_minuta='$var'";
  	mysql_db_query($db,$sql,$link);
	header("location: vtema_last.php?id_minuta=$var");
	}
}
if ($RESULTADOS)
{	
	if(verif==1){header("location: resultados_last.php?id_minuta=$var");}
	else
	{$en_fecha="$eano-$emes-$edia";
	$fecha="$ano-$mes-$dia";
	$hora="$h:$m";
	$sql="UPDATE minuta SET codigo='$codigo',elab_por='$elab_por',en_fecha='$en_fecha',tipo_min='$tipo_min', ".
		"fecha='$fecha',hora='$hora',lugar='$lugar' WHERE id_minuta='$var'";
  	mysql_db_query($db,$sql,$link);
	header("location: resultados_last.php?id_minuta=$var");
	}
}
if ($ACCIONES)
{	
	if(verif==1){header("location: acciones_last.php?id_minuta=$var");}
	else
	{$en_fecha="$eano-$emes-$edia";
	$fecha="$ano-$mes-$dia";
	$hora="$h:$m";
	$sql="UPDATE minuta SET codigo='$codigo',elab_por='$elab_por',en_fecha='$en_fecha',tipo_min='$tipo_min', ".
		"fecha='$fecha',hora='$hora',lugar='$lugar' WHERE id_minuta='$var'";
  	mysql_db_query($db,$sql,$link);
	header("location: acciones_last.php?id_minuta=$var");
	}
}
if ($GUARDAR)
{	include("conexion.php");
	$en_fecha="$eano-$emes-$edia";
	$fecha="$ano-$mes-$dia";
	$hora="$h:$m";
	$sql="UPDATE minuta SET codigo='$codigo',elab_por='$elab_por',en_fecha='$en_fecha',tipo_min='$tipo_min', ".
		"fecha='$fecha',hora='$hora',lugar='$lugar',recau='$recau',comentario='$comentario' WHERE id_minuta='$var'";
  	mysql_db_query($db,$sql,$link);
	header("location: lista_agenda.php");
}

if ($VASISTENTE)
{	$en_fecha="$eano-$emes-$edia";
	$fecha="$ano-$mes-$dia";
	$hora="$h:$m";
	$sql="UPDATE minuta SET codigo='$codigo',elab_por='$elab_por',en_fecha='$en_fecha',tipo_min='$tipo_min', ".
		"fecha='$fecha',hora='$hora',lugar='$lugar' WHERE id_minuta='$var'";
  	mysql_db_query($db,$sql,$link);
	header("location: vasistente_last.php?id_minuta=$var");
}
if ($AASISTENTE)
{	$en_fecha="$eano-$emes-$edia";
	$fecha="$ano-$mes-$dia";
	$hora="$h:$m";
	$sql="UPDATE minuta SET codigo='$codigo',elab_por='$elab_por',en_fecha='$en_fecha',tipo_min='$tipo_min', ".
		"fecha='$fecha',hora='$hora',lugar='$lugar' WHERE id_minuta='$var'";
  	mysql_db_query($db,$sql,$link);
	header("location: aasistente_last.php?id_minuta=$var");
}
if ($AASISTENTE_EXT)
{	$en_fecha="$eano-$emes-$edia";
	$fecha="$ano-$mes-$dia";
	$hora="$h:$m";
	$sql="UPDATE minuta SET codigo='$codigo',elab_por='$elab_por',en_fecha='$en_fecha',tipo_min='$tipo_min', ".
		"fecha='$fecha',hora='$hora',lugar='$lugar' WHERE id_minuta='$var'";
  	mysql_db_query($db,$sql,$link);
	header("location: aasistente_ext_last.php?id_minuta=$var");
}
include ("top.php") ;?>
<script language="JavaScript">
<!--
function confirmLink(theLink, usuario)
{
    var is_confirmed = confirm("Desea Realmente Eliminar "+ ' :\n' + usuario);
    if (is_confirmed) {
        theLink.href += '&accion=elimina';
    }
    return is_confirmed;
} // end of the 'confirmLink()' function
//-->
</script>
<?php $verif=($_GET['verif']);
$id_minuta=($_GET['id_minuta']);
$nom=($_GET['nom']);
$tema=($_GET['tema']);
$rtema=($_GET['rtema']);
$atema=($_GET['atema']);
$accion=($_GET['accion']);

if ($accion=="elimina" AND $nom<>"")
	{ $sql="DELETE FROM asistentes WHERE nombre='$nom' AND id_minuta='$id_minuta'";
 	mysql_db_query($db,$sql,$link);}
if ($accion=="elimina" AND $tema<>"")
	{ $sql="DELETE FROM temad WHERE id_tema='$tema' AND id_minuta='$id_minuta'";
 	mysql_db_query($db,$sql,$link);
	
	$sql="DELETE FROM rtema WHERE id_tema='$tema' AND id_minuta='$id_minuta'";
 	mysql_db_query($db,$sql,$link);
	
	$sql="DELETE FROM atema WHERE id_tema='$tema' AND id_minuta='$id_minuta'";
 	mysql_db_query($db,$sql,$link);}
if ($accion=="elimina" AND $rtema<>"")
	{$sql="DELETE FROM rtema WHERE id_tema='$rtema' AND id_minuta='$id_minuta'";
 	mysql_db_query($db,$sql,$link);
	
	$sql="DELETE FROM atema WHERE id_tema='$rtema' AND id_minuta='$id_minuta'";
 	mysql_db_query($db,$sql,$link);}

if ($accion=="elimina" AND $atema<>"")
	{$sql="DELETE FROM atema WHERE id_tema='$atema' AND id_minuta='$id_minuta'";
 	mysql_db_query($db,$sql,$link);}


$sql2 = "SELECT * FROM minuta WHERE id_minuta='$id_minuta'";
$result2=mysql_db_query($db,$sql2,$link);
$row2=mysql_fetch_array($result2);
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsNotEmpty ( "elab_por",  "Elaborado por, $errorMsgJs[empty]" );
$valid->addIsDate   ( "edia", "emes", "eano", "En Fecha, $errorMsgJs[date]" );
$valid->addIsDate   ( "dia", "mes", "ano", "Fecha de Minuta, $errorMsgJs[date]" );
$valid->addCompareDates   ( "edia", "emes", "eano", "dia", "mes", "ano", "En Fecha y Fecha de Reunion, $errorMsgJs[compareDates]" );
$valid->addIsTime ("h", "m", "Hora,  $errorMsgJs[time]");
$valid->addExists ( "lugar",  "Lugar, $errorMsgJs[empty]" );
$valid->addIsNumber  ( "recau", "Recaudacion, $errorMsgJs[number]" );
$valid->addIsNumber  ( "prop", "Proposicion, $errorMsgJs[number]" );
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
<table width="95%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr> 
    <td> 
      <form name="form1" method="post" action="<?php echo $PHP_SELF ?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $id_minuta;?>">	
		<input name="verif" type="hidden" value="<?php echo $verif;?>">	  
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
           
		    <td><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
                <strong>MINUTA DE REUNION</strong></font></div></td>
          </tr>
        </table>
                
        <br>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td colspan="2"> </td>
          </tr>
          <tr> 
            <td width="33%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp; 
              <strong>Codigo :</strong></font>&nbsp; <strong> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <select name="codigo">
                <?php
				$sql_cod1="SELECT agenda_cod FROM agenda_cod ORDER BY agenda_cod";
				$res_cod1=mysql_db_query($db,$sql_cod1,$link);
				while($row_cod1=mysql_fetch_array($res_cod1)){ ?>
                <option value="<?php=$row_cod1[agenda_cod]?>" <?php if ($row_cod1[agenda_cod]==$row2[codigo]) echo "selected"; ?> > 
                <?php=$row_cod1[agenda_cod]?>
                </option>
<!--			  <option value="CAI" <?php if ($row2[codigo]=='CAI') { echo "selected"; } ?> >CAI</option>
				  <option value="CGR" <?php if ($row2[codigo]=='CGR') { echo "selected"; } ?> >CGR</option>
				  <option value="OTRO" <?php if ($row2[codigo]=='OTRO') { echo "selected"; } ?> >OTRO</option>	  -->
                <?php //} 
				}
				?>
              </select>
              </font></strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><strong> 
              </strong></td>
            <td width="67%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Elaborado 
              por:</strong> </font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              <select name="elab_por" id="select">
                <option value="0"></option>
                <?php 
			  $sql21 = "SELECT * FROM users WHERE tipo2_usr='T' ORDER BY apa_usr ASC";
			  $result21 = mysql_db_query($db,$sql21,$link);
			  while ($row21 = mysql_fetch_array($result21)) 
				{
				if ($row2[elab_por]==$row21[login_usr])
							echo "<option value=\"$row21[login_usr]\" selected> $row21[apa_usr] $row21[ama_usr] $row21[nom_usr]</option>";
						else
							echo "<option value=\"$row21[login_usr]\">$row21[apa_usr] $row21[ama_usr] $row21[nom_usr]</option>";
	            }
			   ?>
              </select>
              </strong></strong></td>
          </tr>
          <tr> </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td height="26">
<div align="center"> 
                <p align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;<strong>En 
                  fecha :</strong></font>&nbsp; <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                  <select name="edia" >
                    <?php
			
		
  				
							
  				$a1=substr($row2[en_fecha],0,4);
				$m1=substr($row2[en_fecha],5,2);
				$d1=substr($row2[en_fecha],8,2);
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
            <td colspan="2"><div align="center"> 
                <p align="left"><font size="2" face="Arial, Helvetica, sans-serif"> <strong>
                  Tipo de Reunion  : <font size="2" face="Arial, Helvetica, sans-serif"> 
                  <select name="tipo_min">
                    <option value="Ordinaria" <?php if ($row2[tipo_min]=="Ordinaria") echo "selected";?>>Ordinaria</option>
                    <option value="Extraordinaria" <?php if ($row2[tipo_min]=="Extraordinaria") echo "selected";?>>Extraordinaria</option>
                    <option value="Emergencia" <?php if ($row2[tipo_min]=="Emergencia") echo "selected";?>>Emergencia</option>
                    <option value="Otros" <?php if ($row2[tipo_min]=="Otros") echo "selected";?>>Otros</option>
                  </select>
                  </font> </strong></font></p>
              </div></td>
          </tr>
          <tr> 
            <td width="33%" height="41"> 
              <div align="center"> 
                <p align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp; <strong>
                  Fecha de Minuta :</strong></font>&nbsp; <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                  <select name="dia" >
                    <?php
			
  				$a1=substr($row2[fecha],0,4);
				$m1=substr($row2[fecha],5,2);
				$d1=substr($row2[fecha],8,2);
				
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
              </div></td>
            <td width="23%"><p><font size="2" face="Arial, Helvetica, sans-serif"><strong>Hora:</strong> 
                </font> 
                <?php
			
  				$h1=substr($row2[hora],0,2);
				$mi1=substr($row2[hora],3,2);
		
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
                </select>
                </font> </p>
              </td>
            <td width="44%"><div align="center"> 
                <p><font size="2" face="Arial, Helvetica, sans-serif"><strong>Lugar:</strong></font>
                  <input name="lugar" type="text" value="<?php echo $row2[lugar];?>" size="40" maxlength="150">
                  <br>
                </p>
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
            <td width="10%" height="21"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>N&ordf;</strong></font></div></td>
            <td width="48%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">NOMBRE</font></strong></font></div></td>
            <td width="26%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">CARGO/ROL</font></strong></font></div></td>
            <td width="16%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>ELIMINAR</strong></font></div></td>
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
				{	echo "<td>&nbsp;$row24[nombre]</td>";
					$usuar=$row24[nombre];
					$sql_uext="SELECT b.nombre FROM us_ext_user a, us_ext_mod b WHERE a.id_mod=b.id_mod AND a.nombre='$row24[nombre]'";
					$row_uext=mysql_fetch_array(mysql_db_query($db,$sql_uext,$link));
					$mod_ext=" - ".$row_uext[nombre];
				}
				else
				{echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";
				$usuar="$row5[4] $row5[5] $row5[6]";}?>
            <td>&nbsp;<?php echo $row24[cargo].$mod_ext;?></td>
            <?php echo "<td nowrap><a href=\"minuta_last.php?nom=".$row24[nombre]."&verif=0&id_minuta=$id_minuta\" onClick=\"return confirmLink(this,'$usuar')\">ELIMINAR</a>&nbsp;</td>";?> 
		  </tr>
          <?php 
		
		 }
		 ?>
          <tr> 
            <td colspan="8"><br>
              <div align="center"> 
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
            <td width="6%" height="21"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>N&ordf;</strong></font></div></td>
            <td width="34%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">TEMA</font></strong></font></div></td>
            <td width="34%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">RESPONSABLE</font></strong></font></div></td>
            <td width="15%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">DURACION 
                (min)</font></strong></font></div></td>
            <td width="11%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>ELIMINAR</strong></font></div></td>
          </tr>
          <?php
		$ttotal=0;
		$sql27 = "SELECT * FROM temad WHERE id_minuta='$id_minuta' ORDER BY id_tema ASC";
		
		$result27=mysql_db_query($db,$sql27,$link);
		while($row27=mysql_fetch_array($result27)) 
  		{
		 ?>
          <tr align="center"> 
            <td>&nbsp;<?php echo  $row27[id_tema]?></td>
            <?php 	$sql5 = "SELECT * FROM temas WHERE id_tema='$row27[tema]'  AND id_agenda='$id_minuta'";
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
            <?php echo "<td nowrap><a href=\"minuta_last.php?tema=".$row27[id_tema]."&verif=0&id_minuta=$id_minuta\" onClick=\"return confirmLink(this,'$row27[tema]')\">ELIMINAR</a>&nbsp;</td>";?> 
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
			  <td>&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="9">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="9"> <div align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
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
            <td width="82%"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>RESULTADO</strong></font></div></td>
            <td width="12%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>ELIMINAR</strong></font></div></td>
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
           <?php echo "<td nowrap><a href=\"minuta_last.php?rtema=".$row27[id_tema]."&verif=0&id_minuta=$id_minuta\" onClick=\"return confirmLink(this,'$row27[tema]')\">ELIMINAR</a>&nbsp;</td>";?> 
          </tr>
          <?php }?>
		  
          <tr> 
            <td colspan="7">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="7"><div align="center"><input type="submit" name="RESULTADOS" value="MODIFICAR RESULTADOS"></div></td>
          </tr>
        </table>
        <br>
		<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr>
            <td><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>ACCIONES 
                POR TEMA</strong></font></div></td>
          </tr>
        </table>
		<table width="90%" border="2" align="center" cellpadding="0" cellspacing="0">
          <tr bgcolor="#006699"> 
            <td width="5%" height="21"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>N&ordf;</strong></font></div></td>
            <td width="39%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">ACCION</font></strong></font></div></td>
            <td width="31%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">RESPONSABLE</font></strong></font></div></td>
            <td width="16%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">FECHA 
                LIMITE </font></strong></font></div></td>
            <td width="9%"><div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">ELIMINAR</font></strong></font></div></td>
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
            <?php 	$sql5 = "SELECT * FROM users WHERE login_usr='$row27[responsable]'";
		    	$result5 = mysql_db_query($db,$sql5,$link);
		    	$row5 = mysql_fetch_array($result5);
				echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";?>
            <td >&nbsp;<?php echo $row27[flimite];?></td>
            <?php echo "<td nowrap><a href=\"minuta_last.php?atema=".$row27[id_tema]."&verif=0&id_minuta=$id_minuta\" onClick=\"return confirmLink(this,'$row27[tema]')\">ELIMINAR</a>&nbsp;</td>";?> 
          </tr>
          <?php }?>
          <tr> 
            <td colspan="9">&nbsp;</td>
          </tr>
          <tr align="center"> 
            <td colspan="9"><input type="submit" name="ACCIONES" value="MODIFICAR ACCIONES"></td>
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
          </font><br><br>
		
        </div>
              <div align="center">
                <br><br>
          <table width="75%" border="0">
            <tr> 
              <td width="50%"><div align="right"><strong><font size="2" face="Arial, Helvetica, sans-serif">Costo 
                  :</font></strong> </div></td>
              <td width="50%"><input name="recau" type="text" id="recau" value="<?php=$row2[recau]?>" size="6"> 
                <strong><font size="2" face="Arial, Helvetica, sans-serif"> Bs.</font></strong> 
              </td>
            </tr>
          </table>
        </div>
              
        <div align="center"><br><br>
          <input name="GUARDAR" type="submit" id="GUARDAR" value="GUARDAR CAMBIOS" <?php print $valid->onSubmit() ?>>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input type="submit" name="RETORNAR" value="RETORNAR">
        </div>
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
<?php include("top_.php");?>
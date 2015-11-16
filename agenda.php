<?php
include ("conexion.php"); 
if (isset($_REQUEST['RETORNAR'])){ header("location: lista_agenda.php"); }
if (isset($_REQUEST['TEMA']) or isset($_REQUEST['EXTERNO']) or isset($_REQUEST['INTERNO']))
{	
    if($verif=="1")
	  {
   	$en_fecha="$eano-$emes-$edia";
	$fecha="$ano-$mes-$dia";
	$hora="$h:$m";
	  	$sql="UPDATE agenda SET codigo='$codigo',elab_por='$elab_por',en_fecha='$en_fecha',tipo_reu='$tipo_reu',comentario='$comentario', ".
		"fecha='$fecha',hora='$hora',lugar='$lugar' WHERE id_agenda='$var'";
	  	mysql_query($sql);
	   if ($TEMA){header("location: tema.php?id_agenda=$var");}
	   elseif ($EXTERNO){header("location: iiexterno.php?id_agenda=$var");}
	   elseif ($INTERNO){header("location: iinterno.php?id_agenda=$var");}
	  }
	else
	 {
   	   $en_fecha="$eano-$emes-$edia";
	   $fecha="$ano-$mes-$dia";
	   $hora="$h:$m";
	
       $sql28 = "SELECT MAX(num_codigo) AS ncod FROM agenda WHERE codigo='$codigo'";
       $result28=mysql_db_query($db,$sql28,$link);
       $row28=mysql_fetch_array($result28);
       $num=$row28['ncod']+1;
	
	   $sql="INSERT INTO ".
	   "agenda (codigo,elab_por,en_fecha,tipo_reu,fecha,hora,lugar,comentario,num_codigo,observacion,file) ".
	   "VALUES ('$codigo','$elab_por','$en_fecha','$tipo_reu','$fecha','$hora','$lugar','','$num','','')";
  	   mysql_db_query($db,$sql,$link);
	
       $sql10 = "SELECT MAX(id_agenda) AS ID FROM agenda ";
       $result10=mysql_query($sql10);
       $row10=mysql_fetch_array($result10);
	   $id_agenda=$row10['ID'];
	   if ($TEMA){header("location: tema.php?id_agenda=$row10[ID]");}
	   elseif ($EXTERNO){header("location: iiexterno.php?id_agenda=$row10[ID]");}
	   elseif ($INTERNO){header("location: iinterno.php?id_agenda=$row10[ID]");}
     }
}
if (isset($_REQUEST['GUARDAR'])) 
{   if ($verif=="1")
    {
   	$en_fecha="$eano-$emes-$edia";
	$fecha="$ano-$mes-$dia";
	$hora="$h:$m";
	//$sql="UPDATE agenda SET comentario='$comentario' WHERE id_agenda='$var'";
	$sql="UPDATE agenda SET codigo='$codigo',elab_por='$elab_por',en_fecha='$en_fecha',tipo_reu='$tipo_reu',comentario='$comentario', ".
		"fecha='$fecha',hora='$hora',lugar='$lugar' WHERE id_agenda='$var'";
  	mysql_db_query($db,$sql,$link);
	}else{
   	$en_fecha="$eano-$emes-$edia";
	$fecha="$ano-$mes-$dia";
	$hora="$h:$m";
	
    $sql28 = "SELECT MAX(num_codigo) AS ncod FROM agenda WHERE codigo='$codigo'";
    $result28=mysql_db_query($db,$sql28,$link);
    $row28=mysql_fetch_array($result28);
    $num=$row28['ncod']+1;
	
	$sql="INSERT INTO ".
	   "agenda (codigo,elab_por,en_fecha,tipo_reu,fecha,hora,lugar,comentario,num_codigo,observacion,file) ".
	   "VALUES ('$codigo','$elab_por','$en_fecha','$tipo_reu','$fecha','$hora','$lugar','','$num','','')";
  	mysql_db_query($db,$sql,$link);
	}
	header("location: lista_agenda.php");
}
include ("top.php");
$verif=($_GET['verif']);
$id_agenda=($_GET['id_agenda']);
if($verif=="1") {
	$sql2 = "SELECT *,DATE_FORMAT(en_fecha, '%d/%m/%Y') AS en_fecha,DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM agenda WHERE id_agenda='$id_agenda'";
	$result2=mysql_db_query($db,$sql2,$link);
	$row2=mysql_fetch_array($result2);
}
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsNotEmpty ( "elab_por",  "Elaborado por, $errorMsgJs[empty]" );
$valid->addIsDate   ( "edia", "emes", "eano", "En Fecha, $errorMsgJs[date]" );
$valid->addIsDate   ( "dia", "mes", "ano", "Fecha de Reunion, $errorMsgJs[date]" );
$valid->addCompareDates   ( "edia", "emes", "eano", "dia", "mes", "ano", "En Fecha y Fecha de Reunion, $errorMsgJs[compareDates]" );
$valid->addIsTime ("h", "m", "Hora,  $errorMsgJs[time]");
$valid->addExists ( "lugar",  "Lugar, $errorMsgJs[empty]" );
$valid->addLength ( "comentario",  "Comentarios, $errorMsgJs[length]" );
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
      <form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
		    <td><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
                <strong> 
                <input name="var" type="hidden" value="<?php echo $id_agenda;?>">
                <input name="verif" type="hidden" value="<?php echo $verif;?>">
                AGENDA DE REUNION</strong></font></div></td>
          </tr>
        </table>
                
        <br>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td colspan="2"> </td>
          </tr>
          <tr> 
            <td width="41%" height="24"> 
              <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<strong>Codigo 
                :</strong></font>&nbsp; <font size="2" face="Arial, Helvetica, sans-serif"> 
                <?php /*if ($verif==1) {print $row2[codigo];}
				else {*/ ?>
                <select name="codigo">
				<?php
				$sql_cod1="SELECT agenda_cod FROM agenda_cod ORDER BY agenda_cod";
				$res_cod1=mysql_db_query($db,$sql_cod1,$link);
				while($row_cod1=mysql_fetch_array($res_cod1)){ ?>
				<option value="<?php=$row_cod1['agenda_cod']?>" <?php if ($row_cod1['agenda_cod']=='CAI') { echo "selected"; } ?> ><?php=$row_cod1['agenda_cod']?></option>
<!--                  <option value="CAI" <?php if ($row2['codigo']=='CAI') { echo "selected"; } ?> >CAI</option>
				  <option value="CGR" <?php if ($row2['codigo']=='CGR') { echo "selected"; } ?> >CGR</option>
				  <option value="OTRO" <?php if ($row2['codigo']=='OTRO') { echo "selected"; } ?> >OTRO</option>	  -->
                <?php //} 
				}
				?>
                </select>
                </font></strong></div></td>
            <td width="59%"><strong></strong><font size="2" face="Arial, Helvetica, sans-serif"><strong>Elaborado 
              por :</strong></font>&nbsp;  <font size="2">
              <?php /*if ($verif==1) 
				{  $sql20 = "SELECT nom_usr,apa_usr,ama_usr FROM users WHERE login_usr='$row2[elab_por]'";
			       $result20 = mysql_db_query($db,$sql20,$link);
			       $row20 = mysql_fetch_array($result20); 
			       echo "$row20[nom_usr] $row20[apa_usr] $row20[ama_usr]";
				}
				else { */?>
              <select name="elab_por" id="select">
                <option value="0"></option>
                <?php 
				   $sql21 = "SELECT * FROM users WHERE bloquear=0 AND tipo2_usr='T' ORDER BY apa_usr ASC";
			       $result21 = mysql_db_query($db,$sql21,$link);
			       while ($row21 = mysql_fetch_array($result21)) 
				   { echo "<option value=\"$row21[login_usr]\""; if ($row2['elab_por']==$row21['login_usr']) { echo "selected"; } echo ">$row21[apa_usr] $row21[ama_usr] $row21[nom_usr]</option>";}
			      ?>
              </select>
              <?php //} ?>
              </strong></font></td>
          </tr>
        </table>
        <table width="100%" height="52" cellpadding="0" cellspacing="0">
          <tr> 
            <td height="24"> 
              <div align="center"> 
                <p align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<strong>En 
                  Fecha:</strong> </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                 <?php /*if($verif==1) { print $row2[en_fecha];}
				else { */?>
				<select name="edia" >
                <?php
				if ($verif==0) { $vfecha=date("d-m-Y"); }
				else {$vfecha=$row2['en_fecha']; }
				$a1=substr($vfecha,6,4);
				$m1=substr($vfecha,3,2);
				$d1=substr($vfecha,0,2);
				/*$a1=substr($vfecha,0,4);
				$m1=substr($vfecha,5,2);
				$d1=substr($vfecha,8,2);*/
  	
					for($i=1;$i<=31;$i++)
					{echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";}
			  ?>
                  </select>
                  <select name="emes">
                    <?php for($i=1;$i<=12;$i++)
					  { echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   ?>
                  </select>
                  <select name="eano">
                    <?php for($i=2003;$i<=2020;$i++)
				      {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				?>
                  </select>
			   
                  </font><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"><?php //} ?></a></font></strong></font></strong></font></strong></font></strong></p>
              </div></td>
            <td colspan="2"><div align="center"> 
                <p align="left"><font size="2" face="Arial, Helvetica, sans-serif"> <strong>
                  Tipo Reunion: </strong><font size="2" face="Arial, Helvetica, sans-serif"> 
                  <?php /*if ($verif==1) {print $row2[tipo_reu];}
				     else {*/ ?>
                  <select name="tipo_reu">
                    <option value="Ordinaria" <?php if ($row2['tipo_reu']=='Ordinaria') { echo "selected"; } ?> >Ordinaria</option>
                    <option value="Extraordinaria" <?php if ($row2['tipo_reu']=='Extraordinaria') { echo "selected"; } ?> >Extraordinaria</option>
                    <option value="Emergencia" <?php if ($row2['tipo_reu']=='Emergencia') { echo "selected"; } ?> >Emergencia</option>
                    <option value="Otros" <?php if ($row2['tipo_reu']=='Otros') { echo "selected"; } ?> >Otros</option>
                  </select>
                  <?php //} ?>
                  </font></strong></font></p>
              </div></td>
          </tr>
          <tr> 
            <td width="41%" height="24"> 
              <div align="center"> 
                <p align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<strong>Fecha de Reunion :</strong> 
                 </font>&nbsp; <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                  <?php /*if($verif==1) { print $row2[fecha];}
				else { */?>
				  <select name="dia" >
                    <?php
					if ($verif==0) { $vfecha=date('d-m-Y'); }
					else { $vfecha=$row2['fecha']; }
					$a1=substr($vfecha,6,4);
					$m1=substr($vfecha,3,2);
					$d1=substr($vfecha,0,2);
					for($i=1;$i<=31;$i++)
					{echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";}
			        ?>
                  </select>
                  <select name="mes">
                    <?php for($i=1;$i<=12;$i++)
					  {echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			        ?>
                  </select>
                  <select name="ano">
                    <?php for($i=2003;$i<=2020;$i++)
				      {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				    ?>
                  </select>
                  </font><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"><?php //} ?></a></font></strong></font></strong></font></strong></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                  </font></strong></p>
              </div></td>
            <td width="17%"><p><font size="2" face="Arial, Helvetica, sans-serif"><strong>Hora:</strong></font> 
                <font size="2"> 
                <?php /*if($verif==1) { print $row2[hora];}
				else { */ 
				//$vhora=date("H:i:s");
				$vhora=$row2['hora'];
				$h1=substr($vhora,0,2);
				$mi1=substr($vhora,3,2);
  		?>
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
                : 
                <select name="m" id="select2">
                  <option value="00" <?php if($mi1=="00") echo "selected"?>>00</option>
                  <option value="15"<?php if($mi1=="15") echo " selected"?>>15</option>
                  <option value="30"<?php if($mi1=="30") echo " selected"?>>30</option>
                  <option value="45"<?php if($mi1=="45") echo " selected"?>>45</option>
                </select>
                <?php //} ?>
                </font> </strong> </p>
              </td>
            <td width="42%"><div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"><strong>Lugar:</strong></font> 
                <font size="2"> 
                <?php /*if ($verif==1) { print $row2[lugar];}
				else {*/?>
                <input name="lugar" type="text" value="<?php echo $row2['lugar'];?>" size="35" maxlength="60">
                <?php //}?>
                </font></strong> </div></td>
          </tr>
        </table>
               
        <br>
        <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
            <td><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
                <strong>INVITADOS</strong></font></div></td>
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
		$sql24 = "SELECT * FROM invitados WHERE id_agenda='$id_agenda'";
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
				if ($row5['login_usr'])
				{echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";}
				else
				{
					echo "<td>&nbsp;$row24[nombre]</td>";
					$sql_uext="SELECT b.nombre FROM us_ext_user a, us_ext_mod b WHERE a.id_mod=b.id_mod AND a.nombre='$row24[nombre]'";
					$row_uext=mysql_fetch_array(mysql_db_query($db,$sql_uext,$link));
					$mod_ext=" - ".$row_uext['nombre'];
				}
				?>
            <td>&nbsp;<?php echo $row24['cargo'].$mod_ext?></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="3"> <div align="center"> 
                <input type="submit" name="INTERNO" value="EMPLEADO INVITADO" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="EXTERNO" value="INVITADO EXTERNO" <?php print $valid->onSubmit() ?>>
              </div></td>
          </tr>
        </table>
        <br>
        <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
            <td><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
                <strong>TEMAS PROPUESTOS</strong></font></div></td>
          </tr>
        </table>
                
        <table width="90%" border="2" align="center" cellpadding="0" cellspacing="0">
          <tr bgcolor="#006699"> 
            <td width="8%" height="21"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>N&ordf;</strong></font></div></td>
            <td width="51%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">TEMA</font></strong></font></div></td>
            <td width="26%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">RESPONSABLE</font></strong></font></div></td>
            <td width="15%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">DURACION 
                (min)</font></strong></font></div></td>
          </tr>
          <?php
		  $ttotal=0;
		$cont=0;	
		$sql27 = "SELECT * FROM temas WHERE id_agenda='$id_agenda'";
		$result27=mysql_db_query($db,$sql27,$link);
		while($row27=mysql_fetch_array($result27)) 
  		{
		$cont=$cont+1;
		 ?>
          <tr align="center"> 
            <td>&nbsp;<?php echo $cont?></td>
            <td >&nbsp;<?php echo $row27['tema']?></td>
            <?php 	$sql5 = "SELECT * FROM users WHERE login_usr='$row27[responsable]'";
		    	$result5 = mysql_db_query($db,$sql5,$link);
		    	$row5 = mysql_fetch_array($result5);
				if (!$row5) { echo "<td>$row27[responsable]</td>"; }
				else { echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>"; } ?>
            <td >&nbsp;<?php echo $row27['duracion']; $ttotal+=$row27['duracion'];?></td>
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
            <td colspan="8">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="8"> <div align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="TEMA" value="AGREGAR TEMA" <?php print $valid->onSubmit() ?>>
              </div></td>
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
          <textarea name="comentario" cols="100"><?php echo $row2['comentario'];?></textarea>
          </font><br>
          <br>
          <input type="submit" name="GUARDAR" value="GUARDAR" <?php print $valid->onSubmit() ?>>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input type="submit" name="RETORNAR" value="RETORNAR">
        </p>
        </form>
      
    </td>
  </tr>
</table>
<?php if ($verif=="0") { ?>
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
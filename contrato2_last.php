<?php 
session_start();
$tipo=$_SESSION["tipo"];
if ($tipo<>"A"){
header("location: pagina_error.php?variable1=2");
}else
{
if (isset($_REQUEST['ACEPTAR']))
{header("location: contrato1_last.php?IdContra=$var");}
elseif (isset($_REQUEST['insertar']))
    {include("conexion.php");
	$FechaVenc="$AnoV-$MesV-$DiaV";
	$VencPlazo="$AnoVP-$MesVP-$DiaVP";
		
	if ($_REQUEST['Fase']=="Nueva")
		{$sql8="SELECT MAX(Fase) AS Fas FROM contratofases WHERE IdContra='$var'";
	 	$result8=mysql_db_query($db,$sql8,$link);
		$row8=mysql_fetch_array($result8);	
		$Fa=$row8['Fas']+1;
		require_once('funciones.php');
		$var=_clean($var);
		$Fa=_clean($Fa);
		$Detalle=_clean($Detalle);
		$Monto=_clean($Monto);
		$FechaVenc=_clean($FechaVenc);
		$Garantia=_clean($Garantia);
		$VencPlazo=_clean($VencPlazo);
		
		$var=SanitizeString($var);
		$Fa=SanitizeString($Fa);
		$Detalle=SanitizeString($Detalle);
		$Monto=SanitizeString($Monto);
		$FechaVenc=SanitizeString($FechaVenc);
		$Garantia=SanitizeString($Garantia);
		$VencPlazo=SanitizeString($VencPlazo);
		$sql7="INSERT INTO ".
	 	"contratofases (IdContra,Fase,Detalle,Monto,FechaVenc,Garantia,VencPlazo) ".
		"VALUES ('$var','$Fa','$Detalle','$Monto','$FechaVenc','$Garantia','$VencPlazo')";
		mysql_db_query($db,$sql7,$link);
		header("location: contrato2_last.php?variable1=$var");}
	else
	{ 	if ($_REQUEST['numfase']==1)
			{$VencPlazo="0000-00-00";
			 $Garantia="NA";}
		$sql5="UPDATE contratofases SET Detalle='$Detalle',".
	        "Monto='$Monto',FechaVenc='$FechaVenc',Garantia='$Garantia',VencPlazo='$VencPlazo' ".
		    "WHERE IdContra='$var' AND Fase='$Fase'";
	  mysql_db_query($db,$sql5,$link);
	  header("location: contrato2_last.php?variable1=$var&numfase=$numfase");
	}
}
else { 
include("top.php");
$IdContra=($_GET['variable1']);
$Fases=  isset($_GET['variable3']);?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsTextNormal ( "Detalle",  "Detalle, $errorMsgJs[expresion]" );
$valid->addIsTextNormal ( "Monto",  "Monto, $errorMsgJs[expresion]" );
$valid->addIsTextNormal ( "Garantia",  "Garantia, $errorMsgJs[expresion]" );
$valid->addIsDate   ( "DiaV", "MesV", "AnoV", "Fecha de Vencimiento, $errorMsgJs[date]" );
$valid->addIsDate   ( "DiaVP", "MesVP", "AnoVP", "Fecha de Plazo, $errorMsgJs[date]" );
$valid->addCompareDates   ( "DiaV", "MesV", "AnoV","DiaVP", "MesVP", "AnoVP", "Fecha Vencimiento y Vencimiento $errorMsgJs[compareDates]");
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
<table width="94%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $IdContra;?>">
	<input name="numfase" type="hidden" value="<?php echo $numfase;?>">
	<input name="var3" type="hidden" value="<?php echo $Fases;?>">
	<tr> 
      <td height="150"> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th width="67" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">MODIFICAR 
              FASE</font></th>
            <th width="196" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">DETALLE</font></th>
            <th width="95" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">MONTO</font></th>
            <th width="188" nowrap bgcolor="#006699"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">FECHA 
                VENC. </font></div></th>
            <th width="164" nowrap bgcolor="#006699"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">GARANTIA</font></div></th>
            <th width="135" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">VENC. 
              PLAZO </font></th>
          </tr>
          <?php
			
		$sql1 = "SELECT *, DATE_FORMAT(FechaVenc, '%d/%m/%Y') AS FechaVenc2, DATE_FORMAT(VencPlazo, '%d/%m/%Y') AS VencPlazo2 FROM contratofases WHERE IdContra='$IdContra' ORDER BY Fase ASC";
		$result1=mysql_db_query($db,$sql1,$link);
		while($row1=mysql_fetch_array($result1)) 
  		{ 
		 ?>
          <tr align="center"> 
		    <?php echo "<td><a href=\"contrato2_last.php?variable1=$IdContra&variable3=".$row1['Fase']."&numfase=$numfase\">".$row1['Fase']."</a></font></td>";?> 
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row1['Detalle']?></font></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row1['Monto']?></font></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row1['FechaVenc2']?></font></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row1['Garantia']?></font></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php if ($row1['VencPlazo2']=="00/00/0000"){echo "NA";}else{echo $row1['VencPlazo2'];}?></font></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="6" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="67" nowrap height="7"><div align="center"> 
                <p><font size="2" face="Arial, Helvetica, sans-serif"> 
                  <select name="Fase">
                    <?php 
			     $sql2 = "SELECT * FROM contratofases WHERE IdContra='$IdContra'";
			     $result2 = mysql_db_query($db,$sql2,$link);
			     while ($row2 = mysql_fetch_array($result2)) 
				{   if ($row2['Fase']==$Fases)
				{echo "<option value=\"$row2[Fase]\"selected>$row2[Fase]</option>";}
			  else
				{echo "<option value=\"$row2[Fase]\">$row2[Fase]</option>";}}
			   ?>
               <?php if ($numfase!=1){?>
			   <option value="Nueva">Nueva</option>
			   <?php }?>
               </select>
                  <?php $sql3 = "SELECT * FROM contratofases WHERE IdContra='$IdContra' AND Fase='$Fases'";
			  	 $result3=mysql_db_query($db,$sql3,$link);
		      	 $row3=mysql_fetch_array($result3)?>
                  </font></p>
              </div></td>
            <td width="196" nowrap height="3"><div align="center"><strong> 
                <textarea name="Detalle" cols="20"><?php echo $row3['Detalle']?></textarea>
                </strong> </div></td>
            <td width="95" nowrap height="7"><div align="center"><strong> 
                <input name="Monto" type="text" id="estado_seg4" size="8" maxlength="9" value="<?php echo $row3['Monto']?>">
                </strong></div></td>
            <td width="188" nowrap height="7"> <div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="DiaV" id="select13">
                  <?php
				   if(!$row3['Fase'])
				   {
				    $hoy=date("Y-m-d");
					$a1=substr($hoy,0,4);
					$m1=substr($hoy,5,2);
					$d1=substr($hoy,8,2);}	
				   else
					{$a1=substr($row3['FechaVenc'],0,4);
					$m1=substr($row3['FechaVenc'],5,2);
					$d1=substr($row3['FechaVenc'],8,2);}
				for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($d1=="$i")echo "selected";echo">$i</option>";
				}
				?>
                </select>
                <select name="MesV" id="select14">
                  <?php
				for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
                </select>
                <select name="AnoV" id="select15">
                  <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
                </select>
                </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></div></td>
            <td height="7" nowrap> <div align="center"> 
                <textarea name="Garantia" cols="20"  <?php if ($numfase=="1"){echo "disabled";}?>><?php echo $row3['Garantia']?></textarea>
              </div></td>
            <td nowrap><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <select name="DiaVP" id="select" <?php if ($numfase=="1"){echo "disabled";}?>>
                <?php  
				if(!$row3['Fase'] OR $numfase=="1")
			   {
			    $hoy=date("Y-m-d");
				$a2=substr($hoy,0,4);
				$m2=substr($hoy,5,2);
				$d2=substr($hoy,8,2);}	
			   else
				{
				$a2=substr($row3['VencPlazo'],0,4);
				$m2=substr($row3['VencPlazo'],5,2);
				$d2=substr($row3['VencPlazo'],8,2);}
				for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($d2=="$i")echo "selected";echo">$i</option>";
				}
				?>
              </select>
              <select name="MesVP" id="select2" <?php if ($numfase=="1"){echo "disabled";}?>>
                <?php
				for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m2=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select>
              <select name="AnoVP" id="select3" <?php if ($numfase=="1"){echo "disabled";}?>>
                <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a2=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
              </select>
              <?php if ($numfase!=1){?><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong> 
              </font></strong><?php }?></td>
          </tr>
          <tr> 
            <td height="28" colspan="6" nowrap> <div align="center"><br>
                <input name="insertar" type="submit" id="reg_form3" value="GUARDAR DATOS" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="ACEPTAR" value="RETORNAR">
              </div></td>
          </tr>
        </table>
      </td>
    </tr></form>
  </table>
 <script language="JavaScript">
		<!-- 
		 var form="form2";
		var cal = new calendar1(document.forms[form].elements['DiaV'], document.forms[form].elements['MesV'], document.forms[form].elements['AnoV']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		<?php if ($numfase!=1){?>
		var cal1 = new calendar1(document.forms[form].elements['DiaVP'], document.forms[form].elements['MesVP'], document.forms[form].elements['AnoVP']);
		 	cal1.year_scroll = true;
			cal1.time_comp = false;
		<?php }?>
//-->
</script>
<?php } include("top_.php"); }?>

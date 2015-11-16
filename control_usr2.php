<?php
if ($Terminar) {header("location: lista_control_usr.php");}
if ($INSERTAR)
	{   include("conexion.php");
		$FechaOut="$AnoOu-$MesOu-$DiaOu";
			$sql="UPDATE control_usr SET FechaOut='$FechaOut',Observ='$Observ' WHERE IdControl='$var' AND IdUsr='$var2'";
			mysql_db_query($db,$sql,$link);
			header("location: control_usr2.php?IdControl=$var");
}
else { 
include("top.php");
$IdControl=($_GET['IdControl']);
$IdUsr=($_GET['IdUsr']);
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsDate   ( "DiaOu", "MesOu", "AnoOu", "Fecha de Ingreso, $errorMsgJs[date]" );
$valid->addLength ( "Observ",  "Observaciones, $errorMsgJs[length]" );
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
<table width="95%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="control_usr2.php" onKeyPress="return Form()">
    <input name="var" type="hidden" value="<?php echo $IdControl;?>">
	<input name="var2" type="hidden" value="<?php echo $IdUsr;?>">
    <tr> 
      <td height="203"> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th height="25" colspan="9" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">CONTROL 
              DE USUARIO</font></th>
          </tr>
          <tr align="center"> 
            <th width="26" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nro.</font></th>
            <th width="137" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nombre 
              Usuario </font></th>
            <th width="97" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Login</font></th>
            <th width="115" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Aplicacion 
              / Sistema</font></th>
            <th width="102" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tipo 
              de Acceso</font></th>
            <th width="100" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha 
              Ingreso </font></th>
            <th width="120" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha 
                Salida</font></div></th>
            <th width="80" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Observacion</font></th>
          </tr>
          <?php
			
		$sql = "SELECT *, DATE_FORMAT(FechaIn, '%d/%m/%Y') AS FechaIn, DATE_FORMAT(FechaOut, '%d/%m/%Y') AS FechaOut
				FROM control_usr WHERE IdControl='$IdControl' ORDER BY IdUsr ASC"; //HERE
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr align="center"> <?php echo "<td><a href=\"control_usr2.php?IdControl=$IdControl&IdUsr=".$row[IdUsr]."\">".$row[IdUsr]."</a></font></td>";
		   		$sql5 = "SELECT * FROM users WHERE login_usr='$row[NombreUsr]'";
		    	$result5 = mysql_db_query($db,$sql5,$link);
		    	$row5 = mysql_fetch_array($result5);
				echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";?> 
            <td><?php echo $row[Idu]?></td>
            <?php $sql2 = "SELECT * FROM sistemas WHERE Id_Sistema='$row[AplicSistema]'";
		    	$result2 = mysql_db_query($db,$sql2,$link);
		    	$row2 = mysql_fetch_array($result2);
				echo "<td>&nbsp;$row2[Descripcion]</td>";?>
            <td>&nbsp;<?php echo $row[TipoAcceso]?></td>
            <td>&nbsp;<?php echo $row[FechaIn]; ?></td>
            <?php if ($row[FechaOut]=="00/00/0000") { echo "<td>&nbsp;</td>";} else
			{?>
            <td>&nbsp;<?php echo $row[FechaOut];?></td>
            <?php }?>
          <td>&nbsp;<?php echo $row[Observ]?></td>
		  </tr>
          <?php 
		 }
		 ?>
          <tr align="center"> 
            <td height="7" colspan="9" nowrap>&nbsp;</td>
          </tr> 
          <?php $sql4 = "SELECT *, DATE_FORMAT(FechaIn, '%d/%m/%Y') AS FechaIn 
		  			  FROM control_usr WHERE IdControl='$IdControl' AND IdUsr='$IdUsr'"; //HERE
			  $result4 = mysql_db_query($db,$sql4,$link);
			  $row4 = mysql_fetch_array($result4);?>
          <tr align="center"> 
            <td width="26" height="7" nowrap>&nbsp;<?php echo $row4[IdUsr]?></td>
            <?php
					$sql5 = "SELECT * FROM users WHERE login_usr='$row4[NombreUsr]'";
			    	$result5 = mysql_db_query($db,$sql5,$link);
			    	$row5 = mysql_fetch_array($result5);
					echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";?>
            <td height="7" nowrap>&nbsp;<?php echo $row4[Idu] ?></td>
            <?php $sql6 = "SELECT * FROM sistemas WHERE Id_Sistema='$row4[AplicSistema]'";
			    	$result6 = mysql_db_query($db,$sql6,$link);
			    	$row6 = mysql_fetch_array($result6);?>
            <td width="97" nowrap height="7"><div align="center"> <font size="1" face="Arial, Helvetica, sans-serif"> 
                <?php if (!$row4[AplicSistema])echo "Para poder realizar la REVISION  presione primeramente el Nº de tarea a Revisar"; else echo $row6[Descripcion]?>
                </font></div></td>
            <td width="115" nowrap height="7"><div align="center"><strong>&nbsp;<?php echo $row4[TipoAcceso] ?></strong></div></td>
            <td width="102" nowrap height="7"><div align="center"><strong>&nbsp;<?php echo $row4[FechaIn]; ?></strong></div></td>
            <td height="7" nowrap><div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="DiaOu" >
                  <?php
if ($IdUsr=="")				
{	 $fsistema=date("Y-m-d");
	$a1=substr($fsistema,0,4);
	$m1=substr($fsistema,5,2);
	$d1=substr($fsistema,8,2);}
	else
		{				  
				  
				  
  				if ($row4[FechaOut]=="0000-00-00")				
					{$d1=substr($row4[FechaIn],0,2);
					$m1=substr($row4[FechaIn],3,2);
					$a1=substr($row4[FechaIn],6,4);}
				else
					{$a1=substr($row4[FechaOut],0,4);
					$m1=substr($row4[FechaOut],5,2);
					$d1=substr($row4[FechaOut],8,2);}
}					
					for($i=1;$i<=31;$i++)
					{echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";}
			    ?>
                </select>
                </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="MesOu">
                  <?php for($i=1;$i<=12;$i++)
					  {echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   ?>
                </select>
                <select name="AnoOu">
                  <?php for($i=2003;$i<=2020;$i++)
				      {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				?>
                </select>
                <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong> 
                </font></strong></font></strong></div></td>
            <td nowrap><textarea name="Observ" cols="20"><?php echo $row4[Observ] ?></textarea></td>
          </tr>
          <tr> 
            <td height="28" colspan="9" nowrap> <div align="center"><br>
                <input name="INSERTAR" type="submit" id="INSERTAR" value="INSERTAR" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="Terminar" value="TERMINAR">
              </div></td>
          </tr>
        </table></td>
    </tr>
  </form>
</table>
  <script language="JavaScript">
		<!-- 
		 var form="form2";
		 var cal = new calendar1(document.forms[form].elements['DiaOu'], document.forms[form].elements['MesOu'], document.forms[form].elements['AnoOu']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
//-->
</script>
<p> 
  <?php } ?>
</p>
<?php include("top_.php");?>

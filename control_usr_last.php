<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
require("conexion.php");
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($_REQUEST['Terminar'])) {header("location: lista_control_usr.php");}
if (isset($_REQUEST['INSERTAR']))
	{   
		$FechaIn="$AnoI-$MesI-$DiaI";
		$FechaOut="$AnoOu-$MesOu-$DiaOu";
			$sql="UPDATE control_usr SET Idu='$Idu',AplicSistema='$AplicSistema',TipoAcceso='$TipoAcceso',".
				 "FechaIn='$FechaIn',FechaOut='$FechaOut',Observ='$Observ' WHERE IdControl='$var' AND IdUsr='$var2'";
			mysql_query($sql);
			header("location: control_usr_last.php?IdControl=$var");
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
$valid->addExists ( "Idu",  "Login, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "AplicSistema",  "Aplicacion/Sistema, $errorMsgJs[empty]" );
$valid->addExists ( "TipoAcceso",  "Tipo de Acceso, $errorMsgJs[empty]" );
$valid->addIsDate   ( "DiaI", "MesI", "AnoI", "Fecha de Ingreso, $errorMsgJs[date]" );
$valid->addIsDate   ( "DiaOu", "MesOu", "AnoOu", "Fecha de Salida, $errorMsgJs[date]" );
$valid->addCompareDates   ( "DiaI", "MesI", "AnoI", "DiaOu", "MesOu", "AnoOu", "Fecha de Ingreso y Fecha de Salida, $errorMsgJs[compareDates]" );
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
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="control_usr_last.php" onKeyPress="return Form()">
    <input name="var" type="hidden" value="<?php echo $IdControl;?>">
	<input name="var2" type="hidden" value="<?php echo $IdUsr;?>">
    <tr> 
      <td height="100">
      <td height="203"> <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th height="10" colspan="8" background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">CONTROL 
              DE USUARIO - MODIFICACION</font></th>
          </tr>
          <tr align="center"> 
            <th width="22" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nro</font></th>
            <th width="108" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nombre 
              Usuario </font></th>
            <th width="109" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Login</font></th>
            <th width="108" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Aplicacion 
              / Sistema</font></th>
            <th width="152" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tipo 
              de Acceso</font></th>
            <th width="150" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha 
              Ingreso </font></th>
            <th width="113" background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha 
                Salida</font></div></th>
            <th width="112" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Observacion</font></th>
          </tr>
          <?php
			
		$sql = "SELECT *, DATE_FORMAT(FechaIn, '%d/%m/%Y') AS FechaIn, DATE_FORMAT(FechaOut, '%d/%m/%Y') AS FechaOut 
				FROM control_usr WHERE IdControl='$IdControl' ORDER BY IdUsr ASC";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr align="center"> <?php echo "<td><a href=\"control_usr_last.php?IdControl=$IdControl&IdUsr=".$row['IdUsr']."\">".$row['IdUsr']."</a></font></td>";
		   		$sql5 = "SELECT * FROM users WHERE login_usr='".$row['NombreUsr']."'";
		    	$result5 = mysql_query($sql5);
		    	$row5 = mysql_fetch_array($result5);
				echo '<td>&nbsp;'.$row5['nom_usr'].' '.$row5['apa_usr'].' '.$row5['ama_usr'].'</td>';?> 
            <td height="28"><?php echo $row['Idu'];?></td>
            <?php $sql2 = "SELECT * FROM sistemas WHERE Id_Sistema='$row[AplicSistema]'";
		    	$result2 = mysql_query($sql2);
		    	$row2 = mysql_fetch_array($result2);
				echo "<td>&nbsp;$row2[Descripcion]</td>";?>
            <td>&nbsp;<?php echo $row['TipoAcceso'];?></td>
            <td>&nbsp;<?php echo $row['FechaIn']; // HERE?></td>
            <?php if ($row['FechaOut']=="00/00/0000") { echo "<td>&nbsp;</td>";} else
			{?>
            <td>&nbsp;<?php echo $row['FechaOut']; //HERE ?></td>  
            <?php }?>
            <td>&nbsp;<?php echo $row['Observ'];?></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr align="center"> 
            <td height="7" colspan="9" nowrap>&nbsp;</td>
          </tr>
        </table>
        <br>
        <table width="100%" border="2" cellpadding="2" cellspacing="4">
          <?php $sql4 = "SELECT * FROM control_usr WHERE IdControl='$IdControl' AND IdUsr='$IdUsr'";
			  $result4 = mysql_query($sql4);
			  $row4 = mysql_fetch_array($result4);?>
          <tr align="center"> 
            <th height="7" nowrap><font size="2">Nro</font></th>
			<th width="30%" height="7" nowrap><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nombre 
              Usuario</font></th>
            <th width="30%" height="7" nowrap><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Login</font></th>
            <th height="7" nowrap><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Aplicacion 
              / Sistema</font></th>
            <th nowrap height="7"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tipo 
              de Acceso</font></th>
          </tr>
          <tr align="center"> 
            <td height="7" nowrap>&nbsp;<?php echo $row4['IdUsr'];?></td>
			<?php	$sql5 = "SELECT * FROM users WHERE login_usr='$row4[NombreUsr]'";
			   	$result5 = mysql_query($sql5);
			   	$row5 = mysql_fetch_array($result5);
				echo '<td>&nbsp;'.$row5['nom_usr'].' '.$row5['apa_usr'].' '.$row5['ama_usr'].'</td>';?>
            <td height="7" nowrap><input name="Idu" type="text" value="<?php echo $row4['Idu'];?>" size="18" maxlength="35"> 
            </td>
            <td height="7" nowrap> <select name="AplicSistema" id="select">
                <?php 
			  $sql7 = "SELECT * FROM sistemas";
			  $result7 = mysql_query($sql7);
			  while ($row7 = mysql_fetch_array($result7)) 
				{if ($row7['Id_Sistema']==$row4['AplicSistema'])
					echo '<option value="'.$row7['Id_Sistema'].'" selected>'. $row7['Descripcion'].'</option>';
				else
					echo '<option value="'.$row7['Id_Sistema'].'">'. $row7['Descripcion'].'</option>';}
	          ?>
              </select> </td>
            <td nowrap height="7"><strong> 
              <input name="TipoAcceso" type="text" value="<?php echo $row4['TipoAcceso'];?>" size="18" maxlength="30">
              </strong></td>
          </tr>
          <tr align="center"> 
            <th height="7" nowrap colspan="2"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha 
              Ingreso </font></th>
            <th height="7" nowrap><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha 
              Salida</font></th>
            <th nowrap height="7" colspan="2"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Observacion</font></th>
          </tr>
          <tr align="center">           
            <td nowrap height="7" colspan="2"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <select name="DiaI" >
                  <?php
if ($IdUsr=="")				
{	 $fsistema=date("Y-m-d");
	$a1=substr($fsistema,0,4);
	$m1=substr($fsistema,5,2);
	$d1=substr($fsistema,8,2);}
				  else
  					{$a1=substr($row4['FechaIn'],0,4);
					$m1=substr($row4['FechaIn'],5,2);
					$d1=substr($row4['FechaIn'],8,2);}
				for($i=1;$i<=31;$i++)
					{echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";}
			    ?>
                </select>
                </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="MesI">
                  <?php for($i=1;$i<=12;$i++)
					  {echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   ?>
                </select>
                <select name="AnoI">
                  <?php for($i=2003;$i<=2020;$i++)
				      {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				?>
                </select>
              <a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a> 
            </td>
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
					{$a1=substr($row4['FechaIn'],0,4);
					$m1=substr($row4['FechaIn'],5,2);
					$d1=substr($row4['FechaIn'],8,2);}
				else
					{$a1=substr($row4['FechaOut'],0,4);
					$m1=substr($row4['FechaOut'],5,2);
					$d1=substr($row4['FechaOut'],8,2);}
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
                <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong></font></strong> 
                </font></strong></font></strong></div></td>
            <td nowrap colspan="2"><textarea name="Observ" cols="20"><?php echo $row4['Observ'];?></textarea></td>
          </tr>
          <tr> 
            <td height="28" colspan="9" nowrap> <div align="center"><br>
                <input name="INSERTAR" type="submit" id="INSERTAR" value="GUARDAR CAMBIOS" <?php print $valid->onSubmit() ?>>
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
		 var cal = new calendar1(document.forms[form].elements['DiaI'], document.forms[form].elements['MesI'], document.forms[form].elements['AnoI']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		 var cal1 = new calendar1(document.forms[form].elements['DiaOu'], document.forms[form].elements['MesOu'], document.forms[form].elements['AnoOu']);
		 	cal1.year_scroll = true;
			cal1.time_comp = false;
//-->
</script>
<p> 
  <?php } ?>
</p>

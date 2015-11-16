<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
// Version: 	2.0
// Objetivo: 	SANEAR LOS REGISTROS PARA EVITAR SQL INJECTION
// Fecha: 		28/NOV/2012
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
@session_start();
require("conexion.php");
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($Terminar)) {header("location: lista_control_usr.php");}
if (isset($INSERTAR)){   
		$FechaIn="$AnoI-$MesI-$DiaI";
	
		$sql4 = "SELECT * FROM control_usr WHERE IdControl='$var'";
		$result4=mysql_query($sql4);
		$row4=mysql_fetch_array($result4);
		
		if ($row4[IdControl]<>$var) 
			{$sql5 = "SELECT MAX(IdControl) AS IdCont FROM control_usr";
			$result5=mysql_query($sql5);
			$row5=mysql_fetch_array($result5);
			$num1=$row5[IdCont]+1;
			$sql="INSERT INTO control_usr (IdControl,IdUsr,NombreUsr,Idu,AplicSistema,TipoAcceso,FechaIn,FechaOut,Observ) ".
				 "VALUES ('$num1','1','$NombreUsr','$Idu','$AplicSistema','$TipoAcceso','$FechaIn','0000-00-00','')";
			mysql_query($sql);
			header("location: control_usr1.php?IdControl=$var");}
		else
			{$sql5 = "SELECT MAX(IdUsr) AS IdUs FROM control_usr WHERE IdControl='$var'";
			$result5=mysql_query($sql5);
			$row5=mysql_fetch_array($result5);
			$num2=$row5[IdUs]+1;
			$sql="INSERT INTO control_usr (IdControl,IdUsr,NombreUsr,Idu,AplicSistema,TipoAcceso,FechaIn,FechaOut,Observ) ".
				 "VALUES ('$var','$num2','$row4[NombreUsr]','$Idu','$AplicSistema','$TipoAcceso','$FechaIn','0000-00-00','')";
			mysql_query($sql);
			header("location: control_usr1.php?IdControl=$var&a=$num2");}
}
else { 
include("top.php");
require_once('funciones.php');
$IdControl=SanitizeString($_GET['IdControl']);
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "NombreUsr",  "Nombre Usuario, $errorMsgJs[empty]" );
$valid->addExists ( "Idu",  "Login, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "AplicSistema",  "Aplicacion/Sistema, $errorMsgJs[empty]" );
$valid->addExists ( "TipoAcceso",  "Tipo de Acceso, $errorMsgJs[empty]" );
$valid->addIsDate   ( "DiaI", "MesI", "AnoI", "Fecha de Ingreso, $errorMsgJs[date]" );
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
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="control_usr1.php" onKeyPress="return Form()">
    <input name="var" type="hidden" value="<?php echo $IdControl;?>">
    <tr> 
      <td> <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th colspan="6" background="images/main-button-tileR2.jpg">CONTROL DE USUARIOS</th>
          </tr>
          <tr align="center"> 
            <th class="menu" background="images/main-button-tileR1.jpg">Nro.</th>
            <th class="menu" background="images/main-button-tileR1.jpg">Nombre Usuario</th>
            <th class="menu" background="images/main-button-tileR1.jpg">Login</th>
            <th class="menu" background="images/main-button-tileR1.jpg">Aplicacion / Sistema</th>
            <th width="180" class="menu" background="images/main-button-tileR1.jpg">Tipo de Acceso</th>
            <th class="menu" background="images/main-button-tileR1.jpg">Fecha Ingreso </th>
          </tr>
          <?php
		
		$sql = "SELECT *, DATE_FORMAT(FechaIn, '%d/%m/%Y') AS FechaIn FROM control_usr WHERE IdControl='$IdControl' ORDER BY IdUsr ASC";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr align="center"> 
            <td height="25">&nbsp;<?php echo $row['IdUsr'];?></td>
            <?php 	
		   		$sql5 = "SELECT * FROM users WHERE login_usr='".$row['NombreUsr']."'";
		    	$result5 = mysql_query($sql5);
		    	$row5 = mysql_fetch_array($result5);
				echo '<td>&nbsp;'.$row5['nom_usr'].' '.$row5['apa_usr'].' '.$row5['ama_usr'].'</td>';?>
            <td><?php echo $row['Idu'];?></td>
            <?php $sql2 = "SELECT * FROM sistemas WHERE Id_Sistema='$row[AplicSistema]'";
		    	$result2 = mysql_query($sql2);
		    	$row2 = mysql_fetch_array($result2);
				echo '<td>&nbsp;'.$row2['Descripcion'].'</td>';?>
            <td>&nbsp;<?php echo $row['TipoAcceso']?></td>
            <td>&nbsp;<?php echo $row['FechaIn'];?></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="6" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
        </table></td>
    </tr>
	<tr><td height="24">&nbsp;</td></tr>
	<tr>		
      <td> 
        <table width="100%" border="2" cellspacing="4" cellpadding="2">
          <tr align="center"> 
            <th class="menu" background="images/main-button-tileR1.jpg">Nombre Usuario</th>
            <th class="menu" background="images/main-button-tileR1.jpg">Login</th>
            <th class="menu" background="images/main-button-tileR1.jpg">Aplicacion / Sistema</th>
          </tr>
          <tr align="center"> 
         
            <?php 	$sql4 = "SELECT * FROM control_usr WHERE IdControl='$IdControl'";
				$result4=mysql_query($sql4);
				$row4=mysql_fetch_array($result4);
		
				if ($row4['IdControl']<>$IdControl) { ?>
            <td align="center"> <div align="center">
                <select name="NombreUsr" id="select3">
                  <?php 
						$sql = "SELECT * FROM users WHERE bloquear=0 AND (tipo2_usr='T' OR tipo2_usr='A' OR tipo2_usr='C') ORDER BY apa_usr ASC";
			  			$result = mysql_query($sql);
			  			while ($row = mysql_fetch_array($result)) 
						{
							$sql01 = "SELECT * FROM control_usr WHERE NombreUsr='$row[login_usr]'";
						  	$result01=mysql_query($sql01);
						  	$row01=mysql_fetch_array($result01);
							if (!$row01['NombreUsr'])
							{echo '<option value="'.$row['login_usr'].'">'.$row['apa_usr'].' '.$row['ama_usr'].' '.$row['nom_usr'].'</option>';}
			   			}
						?>
                </select>
              </div>
              <div align="center"></div>
              <?php } else {
			
					$sql5 = "SELECT * FROM users WHERE login_usr='$row4[NombreUsr]'";
			    	$result5 = mysql_query($sql5);
			    	$row5 = mysql_fetch_array($result5);
					echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";}?></td>
            <td align="center"> <input name="Idu" type="text" maxlength="35"> 
            </td>
            <td><div align="center">
                <select name="AplicSistema" id="select">
                  <?php 
			  $sql = "SELECT * FROM sistemas";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo '<option value="'.$row['Id_Sistema'].'">'.$row['Descripcion'].'</option>';
	            }
			   ?>
                </select>
              </div></td>
          </tr>
          <tr align="center"> 
            <th colspan="2" class="menu" background="images/main-button-tileR1.jpg">Tipo de Acceso</th>
            <th colspan="2" class="menu" background="images/main-button-tileR1.jpg">Fecha Ingreso </th>
          </tr>
          <tr> 
            <td colspan="2"><div align="center"><strong> 
                <input name="TipoAcceso" type="text" id="TipoAcceso" value="" size="30" maxlength="30">
                </strong></div></td>
            <td colspan="2" align="center"><strong> </strong> <div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="DiaI" >
                  <?php
  				$fsist=date("Y-m-d");
			  	$a1=substr($fsist,0,4);
				$m1=substr($fsist,5,2);
				$d1=substr($fsist,8,2);
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
                <strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong> 
                </font></strong></font></strong></div></td>
          </tr>
          <tr> 
            <td colspan="4"><div align="center"><br>
                <input name="INSERTAR" type="submit" id="INSERTAR2" value="INSERTAR" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="Terminar" value="RETORNAR">
              </div></td>
          </tr>
        </table> </td>
	</tr>
  </form>
</table>
<script language="JavaScript">
		<!-- 
		 var form="form2";
		 var cal = new calendar1(document.forms[form].elements['DiaI'], document.forms[form].elements['MesI'], document.forms[form].elements['AnoI']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
//-->
</script>
<p> 
  <?php } ?>
</p>

<?php
if ($RETORNAR){header("location: lista_telkey.php");}
if ($reg_form)
{ 
    include("conexion.php");
	
	if ($opcion1=="S")
	{
	$Fecharetiro="$AnoII-$MesII-$DiaII";
	}
	else
	{
	$Fecharetiro=$Fecharet;
	}
	$Fechaentrada= "$AnoI-$MesI-$DiaI";
	
	$sqlx="SELECT * FROM telkey WHERE idtelkey='$varia1'";
	$resultx=mysql_db_query($db,$sqlx,$link);
	$rowx=mysql_fetch_array($resultx);
	$id=$rowx[idtelkey]+1;
	$id=$id+1;
	
	$sql="INSERT INTO ".
	"telkey (Responsable,Cuenta,Tipo,Sistema,Fechaen,Fechare,Reemplazo,Observaciones) ".
	"VALUES ('$Responsable','$Cuenta','$Tipo','$Sistema','$Fechaentrada','$Fecharetiro','$Reemplazo','$Observ')";
	mysql_db_query($db,$sql,$link);
	//$var1=$id+1;
	//echo $sql;
	header("location: lista_telkey.php");
}
else {
include("top.php");
echo "<p>";
echo "&nbsp;";
echo "</p>";
$idtel=($_GET['varia1']);
//$idtel=$rowx[idtelkey];
?> 
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsTextNormal ( "Descripcion",  "Sistema, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty ( "id_tipo",  "ID, $errorMsgJs[empty]" );
$valid->addIsDate   ( "DiaI", "MesI", "AnoI", "Fecha Entrada, $errorMsgJs[date]" );
$valid->addIsDate   ( "DiaII", "MesII", "AnoII", "Fecha Retiro, $errorMsgJs[date]" );
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
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>


  <form name="form2" method="post" action="<?php echo $PHP_SELF ?>" onKeyPress="return Form()">
  <input name="var1" type="hidden" value="<?php echo $idsis;?>">
          
  <table width="95%" border="1" align="center" background="images/fondo.jpg" bgcolor="#EAEAEA">
    <tr> 
            <th colspan="9" background="images/main-button-tileR1.jpg">TELKEY</th>
    <tr align="center" bgcolor="#006699"> 
            <th width="5%" background="images/main-button-tileR2.jpg" class="menu">Nro.</th>
            <th width="29%" background="images/main-button-tileR2.jpg" class="menu">NOMBRE RESPONSABLE</th>
            <th width="11%" background="images/main-button-tileR2.jpg" class="menu">NOMBRE CUENTA</th>
            <th width="11%" background="images/main-button-tileR2.jpg" class="menu">TIPO DE CUENTA  </th>
            <th width="11%" background="images/main-button-tileR2.jpg" class="menu">SISTEMA </th>
            <th width="11%" background="images/main-button-tileR2.jpg" class="menu">FECHA DE ENTRADA</th>
            <th width="11%" background="images/main-button-tileR2.jpg" class="menu">FECHA DE RETIRO</th>
            <th width="11%" background="images/main-button-tileR2.jpg" class="menu">NOMBRE REEMPLAZO</th>
            <th width="11%" background="images/main-button-tileR2.jpg" class="menu">OBSERVACIONES</th>
    </tr>
          
          <?php
	$sql = "SELECT * FROM telkey WHERE idtelkey >='$idtel' ORDER BY idtelkey ASC";
	$result=mysql_db_query($db,$sql,$link);
	while($row=mysql_fetch_array($result)) 
	{?>
          <tr align="center"> 
            <td><?php echo $row[Idtelkey];?></td>
            <td><?php echo $row[Responsable];?></td>
            <td><?php echo $row[Cuenta];?></td>
		    <td><?php echo $row[Tipo];?></td>
		    <td><?php echo $row[Sistema];?></td>
		    <td><?php echo $row[Fechaen];?></td>
		    <td><?php echo $row[Fechare];?></td>
		    <td><?php echo $row[Reemplazo];?></td>
            <td><?php echo $row[Observaciones];?></td>
    </tr>
          <?php 
	 }
	?>
          <tr> 
            <td colspan="9" height="1" nowrap>&nbsp;</td>
          </tr>
    </table>
        
  <table width="95%" border="1" align="center" background="images/fondo.jpg">
    
          <tr bgcolor="#006699">
            <th width="23%" background="images/main-button-tileR1.jpg" class="menu">NOMBRE RESPONSABLE</th>
            <th width="19%" background="images/main-button-tileR1.jpg" class="menu">NOMBRE DE CUENTA</th> 
            <th width="26%" background="images/main-button-tileR1.jpg" class="menu">TIPO DE CUENTA</th>
            <th width="32%" background="images/main-button-tileR1.jpg" class="menu">SISTEMA</th>
          </tr>
          <tr> 
            <td><div align="center"> 
          <input name="Responsable" type="text" size="25" maxlength="40">
        </div></td>
            <td><div align="center">
              <input name="Cuenta" type="text" size="25" maxlength="40" />
            </div></td>
            <td><div align="center">
              <input name="Tipo" type="text" size="25" maxlength="40" />
            </div></td>
            <td><div align="center">
              <select name="Sistema" id="select">
                <?php 
			  $sql7 = "SELECT * FROM sistemas";
			  $result7 = mysql_db_query($db,$sql7,$link);
			  while ($row7 = mysql_fetch_array($result7)) 
				{if ($row7[Id_Sistema]==$row4[AplicSistema])
					echo "<option value=\"$row7[Descripcion]\" selected> $row7[Descripcion]</option>";
				else
					echo "<option value=\"$row7[Descripcion]\"> $row7[Descripcion]</option>";}
	          ?>
              </select>
            </div></td>
          </tr>
    </table>
        
  <table width="95%" border="1" align="center" background="images/fondo.jpg">
    
          <tr>
            <td width="25%" background="images/main-button-tileR1.jpg" bgcolor="#006699"><div align="center" class="style1">FECHA DE ENTRADA </div></td>
            <td width="49%" background="images/main-button-tileR1.jpg" bgcolor="#006699"><div align="center" class="style1">FECHA DE RETIRO</div></td>
            <td width="26%" background="images/main-button-tileR1.jpg" bgcolor="#006699"><div align="center" class="style1">NOMBRE REEEMPLAZO</div></td>
          </tr>
          <tr>
            <td><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
              <select name="DiaI" >
                <?php
if ($IdUsr=="")				
{	 $fsistema=date("Y-m-d");
	$a1=substr($fsistema,0,4);
	$m1=substr($fsistema,5,2);
	$d1=substr($fsistema,8,2);}
				  else
  					{$a1=substr($row4[FechaIn],0,4);
					$m1=substr($row4[FechaIn],5,2);
					$d1=substr($row4[FechaIn],8,2);}
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
            <a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha" /></a></div></td>
            <td align="center"><p>
              <label></label>
              <label>Por Fecha:</label>
              <label>
              <input type="checkbox" name="opcion1" value="S" />
              </label>
            </p>
              <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                <select name="DiaII" >
                  <?php
if ($IdUsr=="")				
{	 $fsistema=date("Y-m-d");
	$a1=substr($fsistema,0,4);
	$m1=substr($fsistema,5,2);
	$d1=substr($fsistema,8,2);}
				  else
  					{$a1=substr($row4[FechaIn],0,4);
					$m1=substr($row4[FechaIn],5,2);
					$d1=substr($row4[FechaIn],8,2);}
				for($i=1;$i<=31;$i++)
					{echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";}
			    ?>
                </select>
                </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                <select name="MesII">
                  <?php for($i=1;$i<=12;$i++)
					  {echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   ?>
                </select>
                <select name="AnoII">
                  <?php for($i=2003;$i<=2020;$i++)
				      {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				?>
                </select>
                <a href="javascript:call.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha" /></a> 
				<?php if($opcion1 == "S")
				{
                echo "<input name=\"Fecharet\" type=\"text\" size=\"25\" maxlength=\"40\" disabled=\"disabled\"/>";
				}
				else
				{
				echo "<input name=\"Fecharet\" type=\"text\" size=\"25\" maxlength=\"40\"/>";
				}
				?>
              </p>
            <div align="center"></div></td>
            <td><div align="center">
            <input name="Reemplazo" type="text" size="25" maxlength="40"/></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td  bgcolor="#006699" align="center"><div align="center" class="style1">OBSERVACIONES</div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="center"><textarea name="Observ" cols="20"></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td height="47" colspan="3">
<div align="center"> <br>
                <input name="reg_form" type="submit" id="reg_form" value="INSERTAR" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input name="RETORNAR" type="submit" id="RETORNAR2" value="RETORNAR">
              </div></td>
          </tr>
    </table>
</form>
  <script language="JavaScript">
		<!-- 
		 var form="form2";
		 var cal = new calendar1(document.forms[form].elements['DiaI'], document.forms[form].elements['MesI'], document.forms[form].elements['AnoI']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		 var call = new calendar1(document.forms[form].elements['DiaII'], document.forms[form].elements['MesII'], document.forms[form].elements['AnoII']);
		 	call.year_scroll = true;
			call.time_comp = false;
//-->
</script>
<?php } ?>
<?php include("top_.php");?>


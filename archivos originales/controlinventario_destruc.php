<?php if (isset($RETORNAR))
{   header("location: lista_controlinvent.php");}
include("conexion.php");
require_once('funciones.php');
$Codigo=_clean($Codigo);
$Codigo=SanitizeString($Codigo);
if (isset($insertar))
{
	$FechaDestruc="$AnoD-$MesD-$DiaD";
	$sql3="UPDATE controlinvent SET FechaDestruc='$FechaDestruc' WHERE Codigo='$var'";
	mysql_db_query($db,$sql3,$link);
	header("location: lista_controlinvent.php");
}
else { 
include("top.php");
$Codigo=($_GET['Codigo']);
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsDate ( "DiaD", "MesD", "AnoD", "Fecha, $errorMsgJs[date]" );
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
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $Codigo;?>">
	
	<tr> 
      <td height="161"> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th colspan="5" nowrap bgcolor="#006699"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">INVENTARIO 
              DE MEDIOS - DESTRUCCION DE MEDIO DE ALMACENAMIENTO</font></th>
          </tr>
          <tr> 
            <th width="109" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">CODIGO</font></th>
            <th width="184" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">FECHA 
              ALTA </font></th>
            <th width="276" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">TIPO</font></th>
            <th width="146" colspan="1" nowrap bgcolor="#006699"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">OBSERVACIONES</font></div></th>
            <th width="147" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">FECHA 
              BAJA </font></th>
          </tr>
          <?php
		
		$sql = "SELECT *, DATE_FORMAT(FechaAlta, '%d/%m/%Y') AS FechaAlta, DATE_FORMAT(FechaBaja, '%d/%m/%Y') AS FechaBaja 
				FROM controlinvent WHERE Codigo ='$Codigo'"; 
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{ 
		 ?>
          <tr align="center"> 
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['codigo_usu']?></font></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['FechaAlta']?></font></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php if(!empty($row['Tipo'])) { echo $row['Tipo']; }?></font></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['Observ']?></font></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['FechaBaja']?></font></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="6" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
        </table>
        <table width="100%" border="1">
          <tr> 
            <td width="71%"><div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">INSERTE 
                LA FECHA EN LA QUE SE DESTRUIRA AL MEDIO DE ALMACENAMIENTO DESCRITO</font></strong></div></td>
            <td width="29%"><div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="DiaD" id="select4">
                  <?php $a=date("Y-m-d");
				   	$a1=substr($a,0,4);
					$m1=substr($a,5,2);
					$d1=substr($a,8,2);
				 for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($d1=="$i")echo "selected";echo">$i</option>";
				}
				  ?>
                </select>
                <select name="MesD" id="select5">
                  <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
      			  ?>
                </select>
                <select name="AnoD" id="select6">
                  <?php for($i=2002;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				  ?>
                </select>
                </font><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></strong></div></td>
          </tr>
        </table>
        <table width="100%" border="1" align="center">
          <tr> 
            <td width="56%"><div align="center"><br>
                <input name="insertar" type="submit" id="insertar" value="GUARDAR" <?php print $valid->onSubmit() ?>>
              </div></td>
            <td width="44%"><div align="center"><br>
                <input type="submit" name="RETORNAR" value="RETORNAR">
              </div></td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
  <script language="JavaScript">
		<!-- 
		 var form="form2";
		 var cal = new calendar1(document.forms[form].elements['DiaD'], document.forms[form].elements['MesD'], document.forms[form].elements['AnoD']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
//-->
</script>
<p> 
  <?php } ?>
</p>
<?php include("top_.php");?>
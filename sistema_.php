<?php
if ($RETORNAR){header("location: lista_sistemas.php");}
if ($reg_form)
{ 
    include("conexion.php");
	$sql="INSERT INTO ".
	"sistemas (Descripcion,Id_Tipo,Titular1,Suplente1,Area,Titular2,Suplente2) ".
	"VALUES ('$Descripcion','$Id_Tipo','$Titular1','$Suplente1','$Area','$Titular2','$Suplente2')";
	mysql_db_query($db,$sql,$link);
	header("location: sistema.php?varia1=$var1");
}
else {
include("top.php");
$idsis=($_GET['varia1']);
?> 
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsTextNormal ( "Descripcion",  "Sistema, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty ( "id_tipo",  "ID, $errorMsgJs[empty]" );
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

  <form name="form2" method="post" action="<?php echo $PHP_SELF ?>" onKeyPress="return Form()">
  <input name="var1" type="hidden" value="<?php echo $idsis;?>">
          
  <table width="95%" border="1" align="center" background="images/fondo.jpg" bgcolor="#EAEAEA">
    <tr> 
            <th colspan="8">LISTADO DE PROPIETARIOS Y RESPONSABLES</th>
          <tr align="center" bgcolor="#006699"> 
            <th width="5%" rowspan="2" class="menu">Nro.</th>
            <th width="29%" rowspan="2" class="menu">SISTEMA</th>
            <th width="11%" rowspan="2" class="menu">TIPO</th>
            <th colspan="2" class="menu">UNIDAD DE SISTEMAS</th>
            <th colspan="3" class="menu">DUENO</th>
          </tr>
          <tr align="center" bgcolor="#006699"> 
            <th width="12%" class="menu">TITULAR</th>
            <th width="11%" class="menu">SOPORTE DE SISTEMAS</th>
            <th width="10%" class="menu">Area</th>
            <th width="11%" class="menu">TITULAR</th>
            <th width="11%" class="menu">SOPORTE DE NEGOCIO</th>
          </tr>
          <?php
	$sql = "SELECT * FROM sistemas WHERE Id_Sistema>='$idsis' ORDER BY Id_Sistema ASC";
	$result=mysql_db_query($db,$sql,$link);
	while($row=mysql_fetch_array($result)) 
	{?>
          <tr align="center"> 
            <td>&nbsp;<?php echo $row[Id_Sistema];?></td>
            <td>&nbsp;<?php echo $row[Descripcion];?></td>
            <td>&nbsp;<?php echo $row[Id_Tipo];?></td>
		<?php $sql5 = "SELECT * FROM users WHERE login_usr='$row[Titular1]'";
		   $result5 = mysql_db_query($db,$sql5,$link);
		   $row5 = mysql_fetch_array($result5);
			echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";
		    $sql5 = "SELECT * FROM users WHERE login_usr='$row[Suplente1]'";
		    $result5 = mysql_db_query($db,$sql5,$link);
		    $row5 = mysql_fetch_array($result5);
			echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";?>
            <td>&nbsp;<?php echo $row[Area];?></td>
            <?php $sql5 = "SELECT * FROM users WHERE login_usr='$row[Titular2]'";
		   $result5 = mysql_db_query($db,$sql5,$link);
		   $row5 = mysql_fetch_array($result5);
			echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";
		    $sql5 = "SELECT * FROM users WHERE login_usr='$row[Suplente2]'";
		    $result5 = mysql_db_query($db,$sql5,$link);
		    $row5 = mysql_fetch_array($result5);
			echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";?>

          </tr>
          <?php 
	 }
	?>
          <tr> 
            <td colspan="8" height="1" nowrap>&nbsp;</td>
          </tr>
        </table>
        
  <table width="95%" border="1" align="center" background="images/fondo.jpg">
    <tr bgcolor="#006699"> 
            <th width="23%" rowspan="2" class="menu">SISTEMA</th>
            <th width="19%" rowspan="2" class="menu">TIPO</th>
            <th colspan="2" bgcolor="#006699" class="menu">UNIDAD DE SISTEMA</th>
          </tr>
          <tr bgcolor="#006699"> 
            <th width="26%" class="menu">TITULAR</th>
            <th width="32%" class="menu">SOPORTE DE SISTEMAS</th>
          </tr>
          <tr> 
            <td><div align="center"> 
          <input name="Descripcion" type="text" size="25" maxlength="40">
        </div></td>
            <td><div align="center"> 		
				
				<select name="Id_Tipo">
				
                  <?php 
		  $sql0 = "SELECT *FROM menu_tipo WHERE `estado` =1 ORDER BY `descripcion` ASC";
		  $result0 = mysql_db_query($db,$sql0,$link);
		  while ($row0 = mysql_fetch_array($result0)) 
		  {
			echo "<option value=\"$row0[descripcion]\">$row0[descripcion]</option>";
		  }
		 ?>
                </select>
				
				
				
              </div></td>
            <td><div align="center"> 
                <select name="Titular1">
				<option></option>
                  <?php 
		  $sql = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
		  $result = mysql_db_query($db,$sql,$link);
		  while ($row = mysql_fetch_array($result)) 
		  {
			echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
		  }
		 ?>
                </select>
              </div></td>
            <td><div align="center"> 
                <select name="Suplente1">
				<option></option>
                  <?php 
		  $sql = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
		  $result = mysql_db_query($db,$sql,$link);
		  while ($row = mysql_fetch_array($result)) 
		  {
			echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
		  }
		?>
                </select>
              </div></td>
          </tr>
        </table>
        
  <table width="95%" border="1" align="center" background="images/fondo.jpg">
    <tr bgcolor="#006699"> 
            <td colspan="3"> <div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">DUENO</font></strong></div></td>
          </tr>
          <tr bgcolor="#006699"> 
            <th width="25%" class="menu">AREA</th>
            <th width="49%" class="menu">TITULAR</th>
            <th width="26%" class="menu">SOPORTE DE NEGOCIO</th>
          </tr>
          <tr> 
            <td><div align="center">
                <select name="Area">
				<option></option>
                  <?php 
		  $sql = "SELECT * FROM users GROUP BY area_usr";
		  $result = mysql_db_query($db,$sql,$link);
		  while ($row = mysql_fetch_array($result)) 
		  {
			echo "<option value=\"$row[area_usr]\">$row[area_usr]</option>";
		  }
		  ?>
                </select>
              </div></td>
            <td><div align="center">
                <select name="Titular2">
				<option></option>
                  <?php 
		  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear=0 ORDER BY apa_usr ASC";
		  $result = mysql_db_query($db,$sql,$link);
		  while ($row = mysql_fetch_array($result)) 
		  {
			echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
		  }
		  ?>
                </select>
              </div></td>
            <td><div align="center"> 
                <select name="Suplente2">
				<option></option>
                  <?php 
		  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear=0 ORDER BY apa_usr ASC";
		  $result = mysql_db_query($db,$sql,$link);
		  while ($row = mysql_fetch_array($result)) 
		  {
			echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
		  }
		?>
                </select>
              </div></td>
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

<?php } ?>
<?php include("top_.php");?>


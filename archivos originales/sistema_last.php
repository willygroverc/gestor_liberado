<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		14/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($RETORNAR)){header("location: lista_sistemas.php");}
if (isset($reg_form))
{ 
    require("conexion.php");
	$sql="UPDATE sistemas SET Descripcion='$Descripcion',Id_Tipo='$Id_Tipo',Titular1='$Titular1',Suplente1='$Suplente1',".
	"Area='$Area',Titular2='$Titular2',Suplente2='$Suplente2' WHERE Id_Sistema='$var1'";
	mysql_query($sql);
	header("location: sistema_last.php?IdSistema=$var1");
}
else {
include("top.php");
$idsis=($_GET['IdSistema']);
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
          
  <table width="90%" border="1" align="center" background="images/fondo.jpg" bgcolor="#EAEAEA">
    <tr> 
            <th colspan="8" background="images/main-button-tileR2.jpg" height="22">LISTADO DE PROPIETARIOS Y RESPONSABLES</th>
          <tr align="center" bgcolor="#006699"> 
            <th width="5%" rowspan="2" class="menu" background="images/main-button-tileR2.jpg">Nro.</th>
            <th width="29%" rowspan="2" class="menu" background="images/main-button-tileR2.jpg">SISTEMA</th>
            <th width="11%" rowspan="2" class="menu" background="images/main-button-tileR2.jpg">TIPO</th>
            <th colspan="2" class="menu" background="images/main-button-tileR2.jpg">UNIDAD DE SISTEMAS</th>
            <th colspan="3" class="menu" background="images/main-button-tileR2.jpg">DUENO</th>
          </tr>
          <tr align="center" bgcolor="#006699"> 
            <th width="12%" class="menu" background="images/main-button-tileR2.jpg">TITULAR</th>
            <th width="11%" class="menu" background="images/main-button-tileR2.jpg">SUPLENTE</th>
            <th width="10%" class="menu" background="images/main-button-tileR2.jpg">Area</th>
            <th width="11%" class="menu" background="images/main-button-tileR2.jpg">TITULAR</th>
            <th width="11%" class="menu" background="images/main-button-tileR2.jpg">SUPLENTE</th>
          </tr>
          <?php
	$sql = "SELECT * FROM sistemas WHERE Id_Sistema='$idsis' ORDER BY Id_Sistema ASC";
	$result=mysql_query($sql);
	while($row=mysql_fetch_array($result)) 
	{?>
          <tr align="center"> 
            <td>&nbsp;<?php echo $row['Id_Sistema'];?></td>
            <td>&nbsp;<?php echo $row['Descripcion'];?></td>
            <td>&nbsp;<?php echo $row['Id_Tipo'];?></td>
            <?php $sql5 = "SELECT * FROM users WHERE login_usr='$row[Titular1]'";
		   $result5 = mysql_query($sql5);
		   $row5 = mysql_fetch_array($result5);
			echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";
		    $sql5 = "SELECT * FROM users WHERE login_usr='$row[Suplente1]'";
		    $result5 = mysql_query($sql5);
		    $row5 = mysql_fetch_array($result5);
			echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";?>
			
            <td>&nbsp;<?php echo $row['Area'];?></td>
            
			<?php $sql5 = "SELECT * FROM users WHERE login_usr='$row[Titular2]'";
		   $result5 = mysql_query($sql5);
		   $row5 = mysql_fetch_array($result5);
			echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";
		    $sql5 = "SELECT * FROM users WHERE login_usr='$row[Suplente2]'";
		    $result5 = mysql_query($sql5);
		    $row5 = mysql_fetch_array($result5);
			echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";?>
          </tr>
               <tr> 
            <td colspan="8" height="1" nowrap>&nbsp;</td>
          </tr>
        </table>
        
  <table width="90%" border="1" align="center" background="images/fondo.jpg">
    <tr bgcolor="#006699"> 
            <th width="23%" rowspan="2" class="menu" background="images/main-button-tileR2.jpg">SISTEMA</th>
            <th width="19%" rowspan="2" class="menu" background="images/main-button-tileR2.jpg">TIPO</th>
            <th colspan="2" background="images/main-button-tileR2.jpg" class="menu">UNIDAD DE SISTEMA</th>
          </tr>
          <tr bgcolor="#006699"> 
            <th width="26%" class="menu" background="images/main-button-tileR2.jpg">TITULAR</th>
            <th width="32%" class="menu" background="images/main-button-tileR2.jpg">SUPLENTE</th>
          </tr>
          <tr> 
            <td><div align="center"> 
                
          <input name="Descripcion" type="text" value="<?php echo $row['Descripcion']?>" size="25" maxlength="40">
              </div></td>
            <td><div align="center"> 
                <select name="Id_Tipo">
                  <option value="APLICACION" <?php if ($row['Id_Tipo']=="APLICACION") echo "selected";?>>APLICACION</option>
				  <option value="OFIMATICA" <?php if ($row['Id_Tipo']=="OFIMATICA") echo "selected";?>>OFIMATICA</option>
        		  <option value="SISTEMA OPERATIVO" <?php if ($row['Id_Tipo']=="SISTEMA OPERATIVO") echo "selected";?>>SISTEMA OPERATIVO</option>
				  <option value="BASE DE DATOS" <?php if ($row['Id_Tipo']=="BASE DE DATOS") echo "selected";?>>BASE DE DATOS</option>
				  <option value="UTILITARIO" <?php if ($row['Id_Tipo']=="UTILITARIO") echo "selected";?>>UTILITARIO</option>
        		  <option value="VARIOS" <?php if ($row['Id_Tipo']=="VARIOS") echo "selected";?>>VARIOS</option>
                </select>
              </div></td>
            <td><div align="center"> 
                <select name="Titular1">
				<option></option>
                  <?php 
				 $sql3 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			     $result3 = mysql_query($sql3);
			     while ($row3 = mysql_fetch_array($result3)) 
				   {
				   if ($row['Titular1']==$row3['login_usr'])
				 			echo "<option value=\"$row3[login_usr]\" selected>$row3[apa_usr] $row3[ama_usr] $row3[nom_usr]</option>";			
				   else
							echo "<option value=\"$row3[login_usr]\">$row3[apa_usr] $row3[ama_usr] $row3[nom_usr]</option>";
	               } ?>
                </select>
              </div></td>
            <td><div align="center"> 
                <select name="Suplente1">
				<option></option>
                  <?php 
				 $sql3 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			     $result3 = mysql_query($sql3);
			     while ($row3 = mysql_fetch_array($result3)) 
				   {
				   if ($row['Suplente1']==$row3['login_usr'])
				 			echo "<option value=\"$row3[login_usr]\" selected>$row3[apa_usr] $row3[ama_usr] $row3[nom_usr]</option>";			
				   else
							echo "<option value=\"$row3[login_usr]\">$row3[apa_usr] $row3[ama_usr] $row3[nom_usr]</option>";
	               } ?>
                </select>
              </div></td>
          </tr>
        </table>
        
  <table width="90%" border="1" align="center" background="images/fondo.jpg">
    <tr bgcolor="#006699"> 
            <th colspan="3" class="menu" background="images/main-button-tileR2.jpg">DUENO</td>
          </tr>
          <tr bgcolor="#006699"> 
            <th width="25%" class="menu" background="images/main-button-tileR2.jpg">Area</th>
            <th width="49%" class="menu" background="images/main-button-tileR2.jpg">TITULAR</th>
            <th width="26%" class="menu" background="images/main-button-tileR2.jpg">SUPLENTE</th>
          </tr>
          <tr> 
            <td><div align="center">
                <select name="Area">
				<option></option>
                   <?php 
				 $sql3 = "SELECT * FROM users GROUP BY area_usr";;
			     $result3 = mysql_query($sql3);
			     while ($row3 = mysql_fetch_array($result3)) 
				   {
				   if ($row['Area']==$row3['area_usr'])
				 			echo "<option value=\"$row3[area_usr]\" selected> $row3[area_usr]</option>";			
				   else
							echo "<option value=\"$row3[area_usr]\"> $row3[area_usr]</option>";
	               } ?>
                </select>
              </div></td>
            <td><div align="center">
                <select name="Titular2">
				<option></option>
          <?php 
				 $sql3 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear=0 ORDER BY apa_usr ASC";
			     $result3 = mysql_query($sql3);
			     while ($row3 = mysql_fetch_array($result3)) 
				   {
				   if ($row['Titular2']==$row3['login_usr'])
				 			echo "<option value=\"$row3[login_usr]\" selected>$row3[apa_usr] $row3[ama_usr] $row3[nom_usr]</option>";			
				   else
							echo "<option value=\"$row3[login_usr]\">$row3[apa_usr] $row3[ama_usr] $row3[nom_usr]</option>";
	               } ?>
                </select>
              </div></td>
            <td><div align="center"> 
                <select name="Suplente2">
				<option></option>
                <?php 
				 $sql3 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear=0 ORDER BY apa_usr ASC";
			     $result3 = mysql_query($sql3);
			     while ($row3 = mysql_fetch_array($result3)) 
				   {
				   if ($row['Suplente2']==$row3['login_usr'])
				 			echo "<option value=\"$row3[login_usr]\" selected>$row3[apa_usr] $row3[ama_usr] $row3[nom_usr]</option>";			
				   else
							echo "<option value=\"$row3[login_usr]\">$row3[apa_usr] $row3[ama_usr] $row3[nom_usr]</option>";
	               } ?>
                </select>
              </div></td>
          </tr>
          <tr> 
            <td height="47" colspan="3">
<div align="center"> <br>
                <input name="reg_form" type="submit" id="reg_form" value="GUARDAR CAMBIOS" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input name="RETORNAR" type="submit" id="RETORNAR2" value="RETORNAR">
              </div></td>
          </tr>
       </table>
</form>

<?php }} ?>
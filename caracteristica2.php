<?php if (isset($_REQUEST['Terminar']))
header("location: lista_ficha.php");
?>
<?php
if (isset($_REQUEST['reg_form']))
{   
	if($_REQUEST['soft'] == "0"){$_REQUEST['soft'] = $_REQUEST['soft1'];}
	include("conexion.php");
	require_once('funciones.php');
        if (empty($_REQUEST['var2'])) { $_REQUEST['var2']="";} else { $_REQUEST['var2']=$_REQUEST['var2'];}
        $var2=$_REQUEST['var2'];
        $var1=$_REQUEST['var1'];
        $tipo=$_REQUEST['tipo'];
        $plataforma=$_REQUEST['plataforma'];
        $comp=$_REQUEST['comp'];
        $ver=$_REQUEST['ver'];
        $adicio=$_REQUEST['adicio'];
        $soft=$_REQUEST['soft'];
	
        $var1=_clean($var1);
	$tipo=_clean($tipo);
	$plataforma=_clean($plataforma);
	$comp=_clean($comp);
	$ver=_clean($ver);
	$adicio=_clean($adicio);
	$soft=_clean($soft);
	
	$var1=SanitizeString($var1);
	$tipo=SanitizeString($tipo);
	$plataforma=SanitizeString($plataforma);
	$comp=SanitizeString($comp);
	$ver=SanitizeString($ver);
	$adicio=SanitizeString($adicio);
	$soft=SanitizeString($soft);
	$sql="INSERT INTO ".
	"ficha_software (IdFicha,tipo,plataforma,comp,ver,adicio,soft) ".
	"VALUES ('$var1','$tipo','$plataforma','$comp','$ver','$adicio','$soft')";
        //print_r($sql);exit;
	mysql_db_query($db,$sql,$link);
	header("location: caracteristica2.php?variable1=$var1&variable2=$var2");
}
else { 
include("top.php");
$IdFi=($_GET['variable1']);
$IdFi2=($_GET['variable2']);
$IdFi3=  isset($_GET['otros']);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "soft",  "software, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "soft1",  "software, $errorMsgJs[empty]" );
print $valid->toHtml();
?>
<script language="JavaScript">
<!--

function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
function redirect(x){
	if (x==15 & form2.var3.value!=1){
		self.location="caracteristica.php?variable1="+form2.var1.value+"&variable2="+form2.var2.value+"&otros="+1;
	}
	if (x!=18 & form2.var3.value==1){
		self.location="caracteristica.php?variable1="+form2.var1.value+"&variable2="+form2.var2.value;
	}
}
-->
</script>
  <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
    <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
	<input name="var1" type="hidden" value="<?php echo $IdFi;?>">
	<input name="var2" type="hidden" value="<?php echo $IdFi2;?>">
	<input name="var3" type="hidden" value="<?php echo $IdFi3;?>">
	<tr> 
      <td height="190"> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th colspan="6" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">CARACTERISTICAS 
              DEL SOFTWARE</font></th>
          </tr>
          <tr> 
            <th width="160" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Software</font></th>
            <th width="92" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Tipo</font></th>
            <th width="94" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Plataforma</font></th>
            <th width="90" nowrap bgcolor="#006699"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Compa&ntilde;ia</font></div></th>
            <th width="94" nowrap bgcolor="#006699"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Version</font></div></th>
            <th width="90" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Adicional</font></th>
          </tr>
          <?php
			
		$sql = "SELECT * FROM ficha_software WHERE IdFicha='$IdFi' ORDER BY IdFicha ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr> 
            <td>&nbsp;<?php echo $row['soft']?></td>
            <td>&nbsp;<?php echo $row['tipo']?></td>
            <td>&nbsp;<?php echo $row['plataforma']?></div></td>
            <td>&nbsp;<?php echo $row['comp']?></div></td>
            <td>&nbsp;<?php echo $row['ver']?></div></td>
            <td>&nbsp;<?php echo $row['adicio']?></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="6" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="160" height="7" valign="middle"><strong> 
			<select name="soft" id="soft" onChange="cambiar(this.value)">
				<option value="0"></option>
				<?php 
                                
if (empty($_REQUEST['id'])) { $_REQUEST['id']="";} else { $_REQUEST['id']=$_REQUEST['id'];}
                                $id=$_REQUEST['id'];
				$sql_sel="SELECT * FROM sistemas";
				$res_sel=mysql_db_query($db,$sql_sel,$link);
				while($row_sel=mysql_fetch_array($res_sel)){
					if($id==$row_sel['Descripcion']) $value="selected";
					else $value="";
					echo "<option value=\"$row_sel[Descripcion]\" $value>$row_sel[Descripcion]</option>";
				}?>
				<option value="otros">Otros</option>
            </select>
			<?php if ($_REQUEST['id'] == "otros"){?><BR>OTRO 
			<input name="soft1" type="text" id="soft">
			<?php }?>
			
              </strong></td>
            <td width="92" nowrap height="7"><strong> 
			<?php //$id=$_REQUEST['id'];
			if(isset($_REQUEST['id'])) $sql_sel="SELECT * FROM sistemas WHERE Descripcion='$_REQUEST[id]'";
			$res_du=mysql_db_query($db,$sql_sel,$link);
			$row_du=mysql_fetch_array($res_du);
			$valor=$row_du['Id_Tipo'];
			?>
              <?php if(isset($_REQUEST['id']) <> "otros"){?>
				 <input name="tipo" type="text" readonly="yes" id="tipo" value="<?php echo $valor?>">
			  <?php }else{?>
                 <select name="tipo">
					<option value="APLICACION">APLICACION</option>
					<option value="OFIMATICA">OFIMATICA</option>
					<option value="SISTEMA OPERATIVO">SISTEMA OPERATIVO</option>
					<option value="BASE DE DATOS">BASE DE DATOS</option>
					<option value="UTILITARIO">UTILITARIO</option>
					<option value="LIBRO">LIBRO</option>
                 </select>
			  <?php }?>
			  
              </strong> </td>
            <td width="94" nowrap height="7"><strong> 
              <select name="plataforma" id="plataforma">
                <option value="Windows">Windows</option>
                <option value="Linux">Linux</option>
                <option value="Unix">Unix</option>
                <option value="Free BSD">Free BSD</option>
              </select>
              </strong></td>
            <td width="90" nowrap height="7"> <div align="center"><strong> 
                <input name="comp" type="text" id="estado_seg3" size="15" maxlength="40">
                </strong></div></td>
            <td width="94" nowrap height="7"><input name="ver" type="text" id="ver" size="15" maxlength="40"> 
            </td>
            <td width="90" nowrap><input name="adicio" type="text" id="adicio" size="15" maxlength="70"></td>
          </tr>
          <tr> 
            <td height="28" colspan="6" nowrap> <div align="center"> <br>
                <input name="reg_form" type="submit" id="reg_form3" value="INSERTAR DATOS" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="Terminar" value="TERMINAR">
              </div></td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
<p> 
  <?php }?>
</p>
<?php include("top_.php");?>
<script language="JavaScript" type="text/JavaScript">
    function cambiar(id){
//	dir= document.location.href+"&id="+id;
	dir="caracteristica2.php?variable1=<?php echo $_REQUEST['variable1']?>&variable2=<?php echo $_REQUEST['variable2']?>&id="+id
	self.location=dir
}
</script>
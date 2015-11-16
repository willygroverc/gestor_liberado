<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		13/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($soft))
	$software = $soft;
if (isset($Aceptar))
{   header("location: ficha_tecnica_last.php?IdFicha=$var1");
}
$bval=0;
?>
<?php
if (isset($reg_form))
{   require("conexion.php");
	if($soft=="0"){$soft=$soft1;}
	if(isset($idTabla))
	{
		$sql6= "SELECT * FROM ficha_software WHERE idTabla=$idTabla";
		$result6=mysql_query($sql6);
		$row6=mysql_fetch_array($result6);
		$fichaSoft = $row6['idTabla'];
	}
	else{
		$fichaSoft = 0;
	}
	
	
	if (!isset($fichaSoft))
	{
		$var1=_clean($var1);
		$tipo=_clean($tipo);
		$plataforma=_clean($plataforma);
		$comp=_clean($comp);
	
		$var1=SanitizeString($var1);
		$tipo=SanitizeString($tipo);
		$plataforma=SanitizeString($plataforma);
		$comp=SanitizeString($comp);
		$sql7="INSERT INTO ".
		"ficha_software (IdFicha,tipo,plataforma,comp,ver,adicio,soft) ".
		"VALUES ('$var1','$tipo','$plataforma','$comp','$ver','$adicio','$soft')";
	    mysql_query($sql7);
		header("location: caracteristica2_last.php?variable1=$var1&variable2=$var2&visual=1");

	}
	else
	{ 
	  $sql5="UPDATE ficha_software SET tipo='$tipo', plataforma='$plataforma',comp='$comp',ver='$ver',adicio='$adicio',soft='$soft1' WHERE idTabla=$idTabla";
	  mysql_query($sql5);
	  header("location: caracteristica2_last.php?variable1=$var1&variable2=$var2&visual=1");
	 }
}
else { 
include("top.php");
@$IdFi=($_GET['variable1']);
@$IdFi2=($_GET['variable2']);
@$IdFi3=($_GET['Acce']);
@$IdFi4=($_GET['otros']);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "soft",  "Software, $errorMsgJs[empty]" );
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
	if (x==15 & form2.var4.value!=1){
		self.location="caracteristica_last.php?variable1="+form2.var1.value+"&variable2="+form2.var2.value+"&otros="+1;
	}
	if (x!=18 & form2.var4.value==1){
		self.location="caracteristica_last.php?variable1="+form2.var1.value+"&variable2="+form2.var2.value;
	}
}
-->
</script>
<table width="85%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $PHP_SELF ?>" onKeyPress="return Form()">
	<input name="var1" type="hidden" value="<?php echo @$IdFi;?>">
	<input name="var2" type="hidden" value="<?php echo @$IdFi2;?>">
	<input name="var3" type="hidden" value="<?php echo @$IdFi3;?>">
	<input name="var4" type="hidden" value="<?php echo @$IdFi4;?>">
	<input name="idTabla" type="hidden" value="<?phpecho @$idTabla?>">
	<input name="edit" type="hidden" value="<?phpecho @$edit?>">
	<tr> 
      <td height="190"> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th background="images/main-button-tileR1.jpg" height="26" colspan="6" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">CARACTERISTICAS 
              DEL EQUIPO (VELOCIDAD, HD, RAM) </font></th>
          </tr>
          <tr> 
            <th background="images/main-button-tileR1.jpg" width="168" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Modificar 
              Software</font></th>
            <th background="images/main-button-tileR1.jpg" width="70" nowrap bgcolor="#006699"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Tipo</font></div></th>
            <th background="images/main-button-tileR1.jpg" width="64" nowrap bgcolor="#006699"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Plataforma</font></div></th>
            <th background="images/main-button-tileR1.jpg" width="64" nowrap bgcolor="#006699"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Compa&ntilde;ia</font></div></th>
            <th background="images/main-button-tileR1.jpg" width="93" nowrap bgcolor="#006699"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Version</font></div></th>
            <th background="images/main-button-tileR1.jpg" width="78" nowrap bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Adicional</font></div></th>
          </tr>
          <?php
		$sql = "SELECT * FROM ficha_software WHERE IdFicha='$IdFi' ORDER BY IdFicha ASC";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{ ?>
          <tr> 
		     
		    <?php 
				
				echo "<td><a href=\"caracteristica2_last.php?edit=1&valor=$row[tipo]&idTabla=$row[idTabla]&variable1=$IdFi&variable2=$IdFi2&soft=".$row[soft]."\">".$row[soft]."</a></td>";
			?> 
            <td>&nbsp;<?php echo $row['tipo'];?></td>
            <td>&nbsp;<?php echo $row['plataforma'];?></td>
            <td>&nbsp;<?php echo $row['comp'];?></td>
            <td>&nbsp;<?php echo $row['ver'];?></td>
            <td>&nbsp;<?php echo $row['adicio'];?></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="6" height="7" nowrap><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font> 
              </div>
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td height="7" nowrap><p><strong> 
                <?php $sql3 = "SELECT * FROM ficha_software";
				
			  	 $result3=mysql_query($sql3);
		      	 $row3=mysql_fetch_array($result3)?>
                <strong>
			<select name="soft" id="soft" onchange="cambiar(this.value)">
			  <option value="0"></option>
			  <?php 
					
					$sql_sel="SELECT * FROM sistemas";
					$res_sel=mysql_query($sql_sel);
					while($row_sel=mysql_fetch_array($res_sel)){
					
						if((isset ($id) && $id==$row_sel['Descripcion']) || (isset($soft) && $soft == $row_sel['Descripcion'])){ $value="selected";$visual=1; $sw=1; }
						else {$value="";}
						echo "<option value=\"$row_sel[Descripcion]\" $value>$row_sel[Descripcion]</option>";
			       }?>
  			<option value="otros">Otros</option>
			</select>
			<?php 
				 if (((isset($sw) && $sw == 0) and $visual == 0 || $soft=="otros" ) || (isset($edit) && $edit == 1)){
				   echo "<br>OTRO<BR><input name='soft1' type='text' id='soft' value='$software'>";
				 }
				?>
                </strong> </td>
            <td width="70" nowrap height="7"><strong> 
              <?php 
			if(isset($id)) $sql_sel="SELECT * FROM sistemas WHERE Descripcion='$id'";
			$res_du=mysql_query($sql_sel);
			$row_du=mysql_fetch_array($res_du);
			if(isset($id)) $valor=$row_du['Id_Tipo'];
			else $valor=$row_du['Id_Tipo'];
			if($valor == ""){$valor = $row3['tipo'];}
			?>
              <?php if(isset($id) && $id <> "otros"){?>
				 <input name="tipo" type="text" readonly="yes" id="tipo" value="<?php=$valor?>">
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
            <td width="64" nowrap height="7"><div align="center"><strong> 
                <select name="plataforma" id="plataforma">
                  <option value="Windows"<?php if($row3['plataforma']=='Windows') echo " Selected";?>>Windows</option>
                  <option value="Linux"<?php if($row3['plataforma']=='Linux') echo " Selected";?>>Linux</option>
                  <option value="Unix"<?php if($row3['plataforma']=='Unix') echo " Selected";?>>Unix</option>
                  <option value="Free BSD"<?php if($row3['plataforma']=='Free BSD') echo " Selected";?>>Free BSD</option>
                </select>
                </strong></div></td>
            <td width="64" nowrap height="7"> <div align="left"><strong> 
                <input name="comp" type="text" id="estado_seg3" value="<?php echo $row3['comp'];?>" size="10" maxlength="40">
                </strong></div></td>
            <td width="93" nowrap height="7"><input name="ver" type="text" id="ver" value="<?php echo $row3['ver'];?>" size="15" maxlength="40"></td>
            <td width="78" nowrap><input name="adicio" type="text" id="adicio" value="<?php echo $row3['adicio'];?>" size="13" maxlength="70"></td>
          </tr>
          <tr> 
            <td height="30" colspan="6" nowrap>
<div align="left"></div>
              <div align="center"> <br>
                <input name="reg_form" type="submit" id="reg_form3" value="GUARDAR CAMBIOS" onClick="return validar()">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="Aceptar" value="TERMINAR">
              </div>              </td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
<p> 
  <?php } ?>
</p>

<script language="JavaScript" type="text/JavaScript">
function cambiar(id){
//	dir= document.location.href+"&id="+id;

	dir="caracteristica2_last.php?variable1=<?php=$variable1?>&variable2=<?php=$variable2?>&id="+id
	self.location=dir
}
</script>
<script language="javascript1.2">
function validar()
{   
	sCad = "";
	if(document.form2.soft.value == "0" || document.form2.soft1.value == ""){sCad += "\nNombre del software no debe ser vacío";}
	if(sCad == "")
	{
		return true;
	}
	else
	{
		msg = "\n\nMensaje Generado por Gestor F1.";
		sCad = sCad + msg;
		alert(sCad);
		return false;
	}
}
</script>

<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		12/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}

if (isset($Acce))
	$hardware = $Acce;
if (isset($Aceptar))
{   header("location: ficha_tecnica_last.php?IdFicha=$var1");
};
$bval=0;
?>
<?php

if (isset($reg_form))
{   
	require("conexion.php");
	if($Acce=="0"){$Acce=$Acce1;}
	if(isset($idTabla))
	{
		$sql6= "SELECT * FROM caracfichtec WHERE IdTabla='$idTabla'";
		$result6=mysql_query($sql6);
		$row6=mysql_fetch_array($result6);
		$fichaHard = $row6['idTabla'];
	
	}else{
		$fichaHard = 0;
	}
	//if($Acce=="0"){$Acce=$Acce1;}
	if (!isset($fichaHard))
	{
		$sql7="INSERT INTO ".
		"caracfichtec (IdFicha,Accesorio,Capacid,Veloc,Marca,ModSerie,Adicio) ".
		"VALUES ('$var1','$Acce','$Capacid','$Veloc','$Marca','$ModSerie','$Adicio')";
		mysql_query($sql7);
		header("location: caracteristica_last.php?variable1=$var1&variable2=$var2&visual=1");
	}else{ 
		
		$sql5="UPDATE caracfichtec SET Accesorio='$Acce1',Capacid='$Capacid', Veloc='$Veloc',Marca='$Marca',ModSerie='$ModSerie',Adicio='$Adicio' WHERE IdTabla='$idTabla'";
		mysql_query($sql5);
		header("location: caracteristica_last.php?variable1=$var1&variable2=$var2&visual=1");
	}
}
	else { 
	include("top.php");
	@$IdFi=($_GET['variable1']);
	@$IdFi2=($_GET['variable2']);
	@$IdFi3=($_GET['Accesorio']);
	@$IdFi4=($_GET['otros']);
	
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "Accesorio",  "Accesorios, $errorMsgJs[empty]" );
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
  <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
	<input name="var1" type="hidden" value="<?php echo $IdFi;?>">
	<input name="var2" type="hidden" value="<?php echo $IdFi2;?>">
	<input name="var3" type="hidden" value="<?php echo $IdFi3;?>">
	<input name="var4" type="hidden" value="<?php echo $IdFi4;?>">
	<input name="idTabla" type="hidden" value="<?php=@$idTabla?>">
	<input name="edit" type="hidden" value="<?php=@$edit?>">
	<tr> 
      <td height="190"> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th background="images/main-button-tileR1.jpg" height="26" colspan="6" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">CARACTERISTICAS 
              DEL EQUIPO (VELOCIDAD, HD, RAM) </font></th>
          </tr>
          <tr> 
            <th background="images/main-button-tileR1.jpg" width="168" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Modificar 
              Accesorios</font></th>
            <th background="images/main-button-tileR1.jpg" width="70" nowrap bgcolor="#006699"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Capacidad</font></div></th>
            <th background="images/main-button-tileR1.jpg" width="64" nowrap bgcolor="#006699"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Velocidad</font></div></th>
            <th background="images/main-button-tileR1.jpg" width="64" nowrap bgcolor="#006699"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Marca</font></div></th>
            <th background="images/main-button-tileR1.jpg" width="93" nowrap bgcolor="#006699"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Modelo 
                / Serie</font></div></th>
            <th background="images/main-button-tileR1.jpg" width="78" nowrap bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Adicional</font></div></th>
          </tr>
          <?php
		$sql = "SELECT * FROM caracfichtec WHERE IdFicha='$IdFi' ORDER BY IdFicha ASC";
		//echo "<br>sql es : ".$sql;
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{ ?>
          <tr> 
		    <?php echo "<td><a href=\"caracteristica_last.php?edit=1&idTabla=$row[idTabla]&variable1=$IdFi&variable2=$IdFi2&Acce=".$row['Accesorio']."\">".$row['Accesorio']."</a></td>";?> 
            <td>&nbsp;<?php echo $row['Capacid'];?></td>
            <td>&nbsp;<?php echo $row['Veloc'];?></td>
            <td>&nbsp;<?php echo $row['Marca'];?></td>
            <td>&nbsp;<?php echo $row['ModSerie'];?></td>
            <td>&nbsp;<?php echo $row['Adicio'];?></td>
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
                <?php 
				 //echo "<br>algo : ".$idTabla;
				 if(isset($idTabla))
				 {
					$sql3 = "SELECT * FROM caracfichtec where idTabla ='$idTabla'";				 	
				 }else{
				 	@$sql3 = "SELECT * FROM caracfichtec where Accesorio like '$id'";
				 }
				 //echo "<br>sql es :::".$sql3;				 
			  	 $result3=mysql_query($sql3);
		      	 $row3=mysql_fetch_array($result3)?>
				 <!------>
						 <select name="Acce" id="Acce" onchange="cambiar(this.value)">
						  <option value="0"></option>
						  <?php 
								
								$sql_sel="SELECT * FROM accesorio order by NombAccesorio";
								$res_sel=mysql_query($sql_sel);
								while($row_sel=mysql_fetch_array($res_sel)){
								
									if($id==$row_sel['NombAccesorio'] || $Acce == $row_sel['NombAccesorio']){ $value="selected";$visual=1; $sw=1; }
									else {$value="";}
									echo '<option value="'.$row_sel[NombAccesorio].'" '.$value.'>'.$row_sel['NombAccesorio'].'</option>';
							   }?>
						<option value="otros">Otros</option>
						</select>
						
				 <!------>
				 <?php 
				 if (((isset($sw) && $sw == 0) and $visual == 0 || $Acce=="otros" ) || (isset($edit) && $edit == 1))
				 {
				   echo "<br>OTRO<BR><input name='Acce1' id='Acce' type='text' value='$hardware'>";
				 }
				?>
                </strong> </td>
                <?php //} ?>
                
			</td>
            <td width="70" nowrap height="7"><strong> 
			
			
			
              <input name="Capacid" type="text" id="obs_seg2" value="<?php echo $row3['Capacid'];?>" size="11" maxlength="25">
              </strong> </td>
            <td width="64" nowrap height="7"><div align="center"><strong> 
                <input name="Veloc" type="text" id="estado_seg4" value="<?php echo $row3['Veloc'];?>" size="9" maxlength="25">
                </strong></div></td>
            <td width="64" nowrap height="7"> <div align="left"><strong> 
                <input name="Marca" type="text" id="estado_seg3" value="<?php echo $row3['Marca'];?>" size="10" maxlength="40">
                </strong></div></td>
            <td width="93" nowrap height="7"><input name="ModSerie" type="text" value="<?php echo $row3['ModSerie'];?>" size="15" maxlength="40"> 
            </td>
            <td width="78" nowrap><input name="Adicio" type="text" value="<?php echo $row3['Adicio'];?>" size="13" maxlength="70"></td>
          </tr>
          <tr> 
            <td height="30" colspan="6" nowrap>
<div align="left"></div>
              <div align="center"> <br>
                <input name="reg_form" type="submit" id="reg_form3" value="GUARDAR CAMBIOS" onClick="return validar()">
                <input type="submit" name="Aceptar" value="TERMINAR">
              </div>
              </td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
  <p> 
  <?php } ?>
</p>
<script language="JavaScript" type="text/JavaScript">
    function cambiar(id)
{
	//dir= document.location.href+"&id="+id;
	dir="caracteristica_last.php?variable1=<?php=$variable1?>&variable2=<?php=$variable2?>&id="+id;
	self.location=dir
}
</script>

<script language="javascript1.2">
function validar()
{   
	sCad = "";
	if(document.form2.Acce.value == "0" || document.form2.Acce1.value == ""){sCad += "\nNombre del hardware no debe ser vac�o";}
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
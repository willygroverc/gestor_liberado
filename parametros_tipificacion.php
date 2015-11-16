<?php
include("conexion.php");
if($RETORNAR){
  if ($BUSCAR == "BUSCAR")
   header("location: lista_procesos.php?BUSCAR=$BUSCAR&menu=$menu&busc=$busc&pg=$pg");
  else
  header("location: lista_procesos.php");
}
//include("top.php");
if ($INSERTAR)
{   
	if($_POST[accion]=="actualizar") 
	{	
		$sql="UPDATE parametros_tipi SET tipi_2='$desc_tipi' WHERE id_tipi=$id_tipi";
	}	
	else 
	{	$sql0 = "SELECT * FROM parametros_tipi WHERE tipi_1='$op' AND tipi_2='$desc_tipi'";
 		$result0=mysql_db_query($db,$sql0,$link);
		$row0=mysql_fetch_array($result0);
		if (!$row0[id_tipi]){$sql="INSERT INTO parametros_tipi(tipi_1, tipi_2) VALUES ('$op', '$desc_tipi')";}
		else {$msg="Ya existe un registro de este tipo de recurso y con Nombre/Descripcion: ".$desc_tipi;}
	}
	$rs=mysql_db_query($db,$sql,$link);
	//if(mysql_affected_rows()!=1) $msg="Precaucion, no se han registrado los datos. Por favor, verifique e intentelo nuevamente. \\n\\nMensaje generado por GesTor F1.";
}
if($_GET[accion]=="editar"){
	$sql1="SELECT * FROM parametros_tipi WHERE id_tipi=$id_tipi";
	$row1=mysql_fetch_array(mysql_db_query($db,$sql1,$link));
	$accion="actualizar";
}
else $accion="";
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
if ($_GET[accion]!="editar")
{
	$valid->addIsTextNormal ( "tipo_tipi",  "Tipo, $errorMsgJs[expresion]" );
}
$valid->addIsTextNormal ( "desc_tipi",  "Nombre/Descripcion, $errorMsgJs[expresion]" );
echo $valid->toHtml ();
?>
<script language="JavaScript">
<!--
function Form () 
{
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
function irapagina(pagina)
{         
 		 if (pagina!="") {self.location = pagina;}
}
function cambio(numero)
{ 
	irapagina("parametros_tipificacion.php?op="+numero);				
}
function tipo(numero)
{        
	irapagina("parametros_tipificacion.php?op="+numero);
}
-->
</script>
<table width="80%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $PHP_SELF ?>" onKeyPress="return Form()">
    <input name="id_dep" type="hidden" value="<?php echo $row1[id_dep];?>">
    <tr> 
      <td> 
        <table width="100%" border="2" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <th colspan="4" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">PARAMETROS 
              DE TIPIFICACION</font></th>
          </tr>
          <tr> 
            <input name="op" type="hidden" value="<?php echo $op;?>">
            <th colspan="4"><font size="2">Seleccion el tipo de vista: 
              <input type="radio" name="t_grupo" value="1" <?php if ($op=="1" OR !$op){echo "checked";}?> onClick="tipo(this.value)">
              Informacion&nbsp;&nbsp;&nbsp;&nbsp; 
              <input type="radio" name="t_grupo" value="2" <?php if ($op=="2"){echo "checked";}?> onClick="tipo(this.value)">
              Aplicaciones &nbsp;&nbsp;&nbsp;&nbsp; 
              <input type="radio" name="t_grupo" value="3" <?php if ($op=="3"){echo "checked";}?> onClick="tipo(this.value)">
              Infraestructura &nbsp;&nbsp;&nbsp;&nbsp; 
              <input type="radio" name="t_grupo" value="4" <?php if ($op=="4"){echo "checked";}?> onClick="tipo(this.value)">
              Recurso Humano</font></th>
          </tr>
          <tr align="center"> 
            <td width="4%" height="25" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif" > 
              Nro. </font></td>
            <td width="23%" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif" >Tipo 
              de Recurso</font></td>
            <td width="63%" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nombre 
              / Descripcion</font></td>
            <td width="10%" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Editar</font></td>
          </tr>
          <?php
		 $c=1;
		if(!$op){$sql = "SELECT * FROM parametros_tipi WHERE tipi_1='1' ORDER BY id_tipi ASC";}
		else {$sql = "SELECT * FROM parametros_tipi WHERE tipi_1='$op' ORDER BY id_tipi ASC";}
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr> 
            <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $c++;?></font></div></td>
            <td> <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
                <?php 
			if ($row[tipi_1]=="1"){echo "Recurso 1";}
			elseif ($row[tipi_1]=="2"){echo "Recurso 2";}
			elseif ($row[tipi_1]=="3"){echo "Recurso 3";}
			elseif ($row[tipi_1]=="4"){echo "Recurso 4";}
		?>
                </font></div></td>
            <td align="center"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<?php echo $row[tipi_2];?> 
              </font> </div><td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo "<a href=\"$PHP_SELF?accion=editar&id_tipi=$row[id_tipi]&op=$op\"><img src=\"images/editar.gif\" alt=\"Editar\" border=\"0\"></a>"; ?> 
                </font></div></td>
          </tr>
          <?php 
		 }
		 ?>
		 </table>
          <table width="100%" border="2" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
		  <tr> 
            <td colspan="4"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr bgcolor="#006699"> 
            <th colspan="4"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif" > 
              <?php 	if($_GET[accion]=="editar") 
					{
						echo "Editando Tipificacion : $row1[tipi_2]";
					
					}
				else 
					{echo "Nuevo Registro";}
			?>
              </font></th>
          </tr>
          <tr> 
            <td colspan="2" nowrap> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
                <?php if($_GET[accion]=="editar"){?>
                <input name="id_tipi" type="hidden" value="<?php echo $id_tipi;?>">
                <?php }?>
                <select name="tipo_tip" <?php if($_GET[accion]=="editar"){echo "disabled";}?> onChange="cambio(this.value)">
                  <option value="1" <?php if($op=="1" OR !$op){echo "selected";}?>>Recurso 
                  1</option>
                  <option value="2" <?php if($row1[tipo_dep]=="2" OR $op=="2"){echo "selected";}?>>Recurso 
                  2</option>
                  <option value="3" <?php if($row1[tipo_dep]=="3" OR $op=="3"){echo "selected";}?>>Recurso 
                  3</option>
                  <option value="4" <?php if($row1[tipo_dep]=="4" OR $op=="4"){echo "selected";}?>>Recurso 
                  4</option>
                </select>
                </font></div></td>
            <td colspan="2" align="center" nowrap><font size="2" face="Arial, Helvetica, sans-serif"> 
              <input name="desc_tipi" type="text" id="desc_tipi" value="<?php=$row1[tipi_2] ?>" size="100" maxlength="100">
              </font></td>
          </tr>
          <tr> 
            <td height="49" colspan="4" nowrap> <div align="center"><br>
                <input name="INSERTAR" type="submit" id="INSERTAR" value="INSERTAR" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="RETORNAR" value="RETORNAR">
                <font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
                <input name="accion" type="hidden" value="<?php=$accion?>">
                </font> </div></td>
          </tr>
		  	 </table>
        </table></td>
    </tr>
</table>
<script language="JavaScript">
<!--
<?php if($msg) print "alert(\"$msg\");\n"; ?>
-->
</script>
<?php //include("top_.php");?>
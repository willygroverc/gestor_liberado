<?php  
include ("conexion.php");
if ($GUARDAR)
{	session_start();
	if (!session_is_registered("login")) { header("location: index_2.php"); }
	$login   = $_SESSION["login"];	
	$sql_ins = "UPDATE alarmas_riesgos SET mensaje_u='$mensaje_u',mensaje_p='$mensaje_p',".
				"mensaje_e='$mensaje_e',msn_celu='$msn',msn_mail='$mail' WHERE id_alarma='$id_alar'";
	mysql_db_query($db, $sql_ins, $link);		
	$sql = "SELECT MAX(id_alarma) AS id_alarma FROM alarmas_riesgos";
	$row = mysql_fetch_array(mysql_db_query($db, $sql, $link));
	
	$sql_usu0 = "DELETE FROM alarma_usuarios WHERE id_alarma='$id_alar'";
				mysql_db_query($db,$sql_usu0,$link);	 
	for ($i= 0; $i<count($lista); $i++)
	{	$usu = $lista[$i]; 
		$sql_usu = "INSERT INTO alarma_usuarios (id_alarma,usuario) VALUES ('$row[id_alarma]','$usu')";
		mysql_db_query($db, $sql_usu, $link);	    
	}

	$sql_pro0 = "DELETE FROM alarma_proveedores WHERE id_alarma='$id_alar'";
				mysql_db_query($db,$sql_pro0,$link);	 
	for ($i= 0; $i<count($lista2); $i++)
	{	$prov = $lista2[$i];
		$sql_pro = "INSERT INTO alarma_proveedores (id_alarma,id_proveedor) VALUES ('$row[id_alarma]','$prov')";
		mysql_db_query($db, $sql_pro, $link);	   
	}
	
	$sql_ent0 = "DELETE FROM alarma_entidad WHERE id_alarma='$id_alar'";
				mysql_db_query($db, $sql_ent0, $link);	   
	for ($i= 0; $i<count($lista3); $i++)
	{	$ent = $lista3[$i];
		$sql_ent = "INSERT INTO alarma_entidad (id_alarma,id_entidad) VALUES ('$row[id_alarma]','$ent')";
		mysql_db_query($db, $sql_ent, $link);	   
	}
	header("location: lista_alarmas.php");
}
if ($RETORNAR) header("location: lista_alarmas.php");

include ("top.php");
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addExists ( "mensaje_u", "Mensaje Usuarios, $errorMsgJs[empty]");
$valid->addExists ( "mensaje_p", "Mensaje Proveedores, $errorMsgJs[empty]");
$valid->addExists ( "mensaje_e", "Mensaje Entidades, $errorMsgJs[empty]");
print $valid->toHtml ();
?>
<html>
<head>
<link rel=stylesheet href="general.css" type="text/css">
<script lenguaje="javascript" type="text/javascript">
function irapagina(pagina){         
 	if (pagina!="") {
     	self.location = pagina;
    }
}
function cambio(numero)
{        
	if (!foco_texto)
	{	 irapagina("riesgo_alarmas.php?op="+numero);
	} 
}
var foco_texto=false;
</script>

<title>ALARMAS</title>
</head>
<body>
<?php
$sql = "SELECT * FROM alarmas_riesgos WHERE id_alarma='$id_alar'";
$result=mysql_db_query($db, $sql, $link);
$row=mysql_fetch_array($result);
?>

<form name="form1" method="post" action="<?php echo $PHP_SELF?>">
<input name="id_alar" type="hidden" value="<?php echo $id_alar;?>">
  <table width="80%" align="center" border="1">
    <tr><td>
<table background="images/fondo.jpg" align="center" width="100%">
          <tr> 
            <th height="23" colspan="3">PROGRAMACION DE ALARMAS</th>
          </tr>
          <tr> 
            <td colspan="3" align="right">FECHA: <?php echo date("d/m/Y")?>&nbsp;&nbsp;</td>
          </tr>
          <tr> 
            <td width="5%">&nbsp; </td>
            <td width="14%" class="titulo">TIPO DE RIESGO: </td>
            <td width="81%">&nbsp;<font size="2"> 
              <?php 
		$sql3 = "SELECT * FROM riesgo_tipos WHERE id_riesgo='$row[tipo_alarma]'";
		$res3 = mysql_db_query($db,$sql3,$link);
		$row3 = mysql_fetch_array($res3);
		echo $row3[descripcion];			
		?></select>
              </font></td>
          </tr>
          <tr> 
            <td width="5%">&nbsp; </td>
            <td width="14%" class="titulo">RIESGO: </td>
            <td width="81%">&nbsp;<font size="2"> 
              <?php
			$sql2 = "SELECT desc_riesgo FROM riesgo_pregunta WHERE tipo_r='$row[tipo_alarma]' AND id_riesgo='$row[alarma]'";
			$res2 = mysql_db_query($db,$sql2,$link);
			$row2 = mysql_fetch_array($res2);
			echo $row2[desc_riesgo];
			?>
              </font></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td class="titulo" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="90%" border="1" align="center" background="images/fondo.jpg">
          <tr bgcolor="#006699"> 
            <td class="titulo"><font color="#FFFFFF">&nbsp;USUARIOS:</font></td>
            <td width="45%" class="titulo"><div align="center"><font color="#FFFFFF">Mensaje 
                Usuarios</font></div></td>
          </tr>
          <tr> 
            <td width="55%" valign="top"> 
              <select size="6" name="lista[]" multiple style="width:400px; font-size:12px; font-family:ARIAL;" >
                <option value="0" <?php 
				$sql_usu0 = "SELECT usuario FROM alarma_usuarios WHERE usuario='0' AND id_alarma='$id_alar'";
				$res_usu0= mysql_db_query($db,$sql_usu0,$link);
				$row_usu0 = mysql_fetch_array($res_usu0);
				if ($row_usu0[usuario]=='0'){echo "selected";}?>>NA</option>
				<?php
				   	$sql_usu = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 order by apa_usr";
					$res_usu = mysql_db_query($db,$sql_usu,$link);
					while ($row_usu = mysql_fetch_array($res_usu))
					{
			       		echo "<option value=\"$row_usu[login_usr]\"";
						$sql_usu2 = "SELECT usuario FROM alarma_usuarios WHERE usuario='$row_usu[login_usr]' AND id_alarma='$id_alar'";
						$res_usu2 = mysql_db_query($db,$sql_usu2,$link);
						$row_usu2 = mysql_fetch_array($res_usu2);
						if ($row_usu2[usuario]){echo "selected";}
                		echo ">".$row_usu[apa_usr]." ".$row_usu[ama_usr]." ".$row_usu[nom_usr]." &nbsp;(". $row_usu[area_usr].")";
						echo "</option>";
                	}
				?>
              </select>
			</td>
            <td align="center" valign="middle"> 
              <textarea name="mensaje_u" cols="40" rows="5"><?php echo $row[mensaje_u];?></textarea>
            </td>
          </tr>
          <tr> 
            <td colspan="2" valign="top">&nbsp;</td>
          </tr>
        </table>
        <table width="90%" border="1" align="center" background="images/fondo.jpg">
          <tr bgcolor="#006699"> 
            <td width="55%" class="titulo"><font color="#FFFFFF">&nbsp;PROVEEDORES 
              :</font></td>
            <td width="45%" class="titulo"><div align="center"><font color="#FFFFFF">Mensaje 
                PROVEEDORES</font></div></td>
          </tr>
          <tr> 
            <td>
			  <select size="6" name="lista2[]" multiple style="width:400px; font-size:12px; font-family:ARIAL;" >
                
				<option value="0"
				<?php 
				$sql5_0 = "SELECT id_proveedor FROM alarma_proveedores WHERE id_proveedor='0' AND id_alarma='$id_alar'";
				$res5_0= mysql_db_query($db,$sql5_0,$link);
				$row5_0 = mysql_fetch_array($res5_0);
				if ($row5_0[id_proveedor]=='0'){echo "selected";}?>>NA</option>
				<?php 
				    $sql5 = "SELECT IdProv, NombProv FROM proveedor ORDER BY NombProv ASC";
					$res5 = mysql_db_query($db,$sql5,$link);
					while ($row5 = mysql_fetch_array($res5))
					{
				    	echo "<option value=\"$row5[IdProv]\"";
						$sql5_2 = "SELECT id_proveedor FROM alarma_proveedores WHERE id_proveedor='$row5[IdProv]' AND id_alarma='$id_alar'";
						$res5_2 = mysql_db_query($db,$sql5_2,$link);
						$row5_2 = mysql_fetch_array($res5_2);
						if ($row5_2[id_proveedor]){echo "selected";}
                		echo ">".$row5[NombProv]; 
					    echo "</option>";
					}
				?>
              </select>
			</td>
            <td align="center" valign="middle"> 
              <div align="center">
                <textarea name="mensaje_p" cols="40" rows="5"><?php echo $row[mensaje_p];?></textarea>
              </div></td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
        </table>
        <table width="90%" border="1" align="center" background="images/fondo.jpg">
          <tr bgcolor="#006699"> 
            <td width="55%" class="titulo"><font color="#FFFFFF">&nbsp;ENTIDADES 
              :</font></td>
            <td width="45%" class="titulo"><div align="center"><font color="#FFFFFF">&nbsp;Mensaje 
                ENTIDADES</font></div></td>
          </tr>
          <tr> 
            <td><select size="6" name="lista3[]" multiple style="width:400px; font-size:12px; font-family:ARIAL;" >
                <option value="0" 
				<?php 
				$sql4_0 = "SELECT id_entidad FROM alarma_entidad WHERE id_entidad='0' AND id_alarma='$id_alar'";
				$res4_0= mysql_db_query($db,$sql4_0,$link);
				$row4_0 = mysql_fetch_array($res4_0);
				if ($row4_0[id_entidad]=='0'){echo "selected";}?>
				>NA</option>
				<?php
				    $sql4 = "SELECT * FROM procesos_parametros WHERE tipo_dep ='2' ORDER BY desc_dep ASC";
					$res4 = mysql_db_query($db,$sql4,$link);
					while ($row4 = mysql_fetch_array($res4))
					{
				     	echo "<option value=\"$row4[id_dep]\"";
						$sql4_2 = "SELECT id_entidad FROM alarma_entidad WHERE id_entidad='$row4[id_dep]' AND id_alarma='$id_alar'";
						$res4_2 = mysql_db_query($db,$sql4_2,$link);
						$row4_2 = mysql_fetch_array($res4_2);
						if ($row4_2[id_entidad]){echo "selected";}
                		echo ">".$row4[desc_dep]; 
						echo "</option>";
					}
				 ?>
              </select></td>
            <td align="center" valign="middle"> 
              <textarea name="mensaje_e" cols="40" rows="5"><?php echo $row[mensaje_e];?></textarea>
            </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="90%" border="0" align="center" background="images/fondo.jpg">
          <tr> 
            <td colspan="2" class="titulo2">tipo de emision del mensaje:</td>
          </tr>
          <tr> 
            <td width="12%">&nbsp;</td>
            <td width="88%" class="titulo2">&nbsp; <input type="checkbox"  name="mail" value="1" <?php if ($row[msn_mail]==1){echo "checked";}?>>
              Correo electronico &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              <input type="checkbox" name="msn" value="1" <?php if ($row[msn_celu]==1){echo "checked";}?>>
              Mensaje por Celular </td>
          </tr>
        </table></td></tr></table>
<table width="311" align="center">
    <tr>
      <td height="40" align="center"> 
		<input type="submit" name="GUARDAR" value="  GUARDAR  " <?php print $valid->onSubmit() ?>>
	  </td>	
	  <td>&nbsp;</td>
	  <td align="center">
        <input type="submit" name="RETORNAR" value="  RETORNAR  ">
</td>
    </tr>							
</table>
</form>
</body>
</html>
<?php include ("top_.php");?>
<script language="JavaScript">

	function ValidaArchivo ()
	{	if (form1.mensaje_u.value == "")	
		{	alert ("Mensaje no puede ser vacio \n\nMensaje generado por GesTor F1.");			
			return false;
		}
		return true;
	}	
		
	function impresion_a(campo)
	{
		open('ver_alarmas.php?campo='+campo,'Alarmas','location=no,menubar=yes,status=no,toolbar=no,scrollbars=1,resizable=yes');	
	}
		
</script>
<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		13/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require ("conexion.php");
if (isset($_REQUEST['GUARDAR']))
{	//session_start();
	$tip_riesgo=$_REQUEST['tip_riesgo'];
	$riesgo=$_REQUEST['riesgo'];
	$mensaje_u=$_REQUEST['mensaje_u'];
	$mensaje_p=$_REQUEST['mensaje_p'];
	$mensaje_e=$_REQUEST['mensaje_e'];
	$lista=$_REQUEST['lista'];
	$lista2=$_REQUEST['lista2'];
	$lista3=$_REQUEST['lista3'];
	$mail=$_REQUEST['mail'];
	if (!$_SESSION["login"]) { header("location: index_2.php"); }
	$login   = $_SESSION["login"];	
	if(empty($mail)) { $mail=0; }
	$sql_ins = "INSERT INTO alarmas_riesgos (tipo_alarma,alarma,mensaje_u,mensaje_p,mensaje_e,msn_celu,msn_mail,login_creador,fec_creacion) ".
		      " VALUES ('$tip_riesgo','$riesgo','$mensaje_u','$mensaje_p','$mensaje_e','0','$mail','$login','".date("Y-m-d")."')";
	mysql_query( $sql_ins);		
	$sql = "SELECT MAX(id_alarma) AS id_alarma FROM alarmas_riesgos";
	$row = mysql_fetch_array(mysql_query( $sql));
	
	for ($i= 0; $i<count($lista); $i++)
	{	$usu = $lista[$i]; 
		$sql_usu = "INSERT INTO alarma_usuarios (id_alarma,usuario) VALUES ('$row[id_alarma]','$usu')";
		mysql_query( $sql_usu);	    
	}
	for ($i= 0; $i<count($lista2); $i++)
	{	$prov = $lista2[$i];
		$sql_pro = "INSERT INTO alarma_proveedores (id_alarma,id_proveedor) VALUES ('$row[id_alarma]','$prov')";
		mysql_query( $sql_pro);	   
	}
	
	for ($i= 0; $i<count($lista3); $i++)
	{	$ent = $lista3[$i];
		$sql_ent = "INSERT INTO alarma_entidad (id_alarma,id_entidad) VALUES ('$row[id_alarma]','$ent')";
		mysql_query( $sql_ent);	   
	}
	header("location: lista_alarmas.php?idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc");
}
if (isset($_REQUEST['RETORNAR'])) header("location: lista_alarmas.php?idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc");

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
{    //alert(numero);    
	if (!foco_texto)
	{	 irapagina("riesgo_alarmas.php?op="+numero);
	} 
}
var foco_texto=false;
</script>

<title>ALARMAS</title>
</head>
<body>
<form name="form1" method="post" action="">
  <table width="80%" align="center" border="1">
    <tr><td>
<table background="images/fondo.jpg" align="center" width="100%">
          <tr> 
            <th height="23" colspan="3" background="images/main-button-tileR2.jpg">PROGRAMACION DE ALARMAS</th>
          </tr>
          <tr> 
            <td colspan="3" align="right" background="images/main-button-tileR2.jpg">FECHA: <?php echo date("d/m/Y")?>&nbsp;&nbsp;</td>
          </tr>
          <tr> 
            <td width="5%" background="images/main-button-tileR2.jpg">&nbsp; </td>
            <td width="14%" class="titulo">TIPO DE RIESGO: </td>
            <td width="81%"> <select name="tip_riesgo"  onChange="cambio(this.value)">
                <?php 
		$sql3 = "SELECT * FROM riesgo_tipos";
		$res3 = mysql_query($sql3);
		while($row3 = mysql_fetch_array($res3)) {	
			if (isset($_REQUEST['op']) && $_REQUEST['op'] == $row3['id_riesgo'])
			echo "<option value='$row3[id_riesgo]' selected>$row3[descripcion]</option>";							
			else					
			echo "<option value='$row3[id_riesgo]'>$row3[descripcion]</option>";			
		}		
	?>
              </select> </td>
          </tr>
          <tr> 
            <td width="5%">&nbsp; </td>
            <td width="14%" class="titulo">RIESGO: </td>
            <td width="81%"> <select name="riesgo">
                <?php
	if (!isset($_REQUEST['op'])) $op = 1;
	else
		$op=$_REQUEST['op'];
	$sql2 = "SELECT id_riesgo, desc_riesgo  FROM riesgo_pregunta WHERE tipo_r='$op'";
	$res2 = mysql_query($sql2);
	while($row2 = mysql_fetch_array($res2)){	
		echo "<option value=\"$row2[id_riesgo]\">$row2[desc_riesgo]</option>";			
	}
	?>
              </select> </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td class="titulo" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="90%" border="1" align="center" background="images/fondo.jpg">
          <tr bgcolor="#006699"> 
            <td class="titulo" background="images/main-button-tileR2.jpg"><font color="#FFFFFF">&nbsp;USUARIOS:</font></td>
            <td width="45%" background="images/main-button-tileR2.jpg" class="titulo"><div align="center"><font color="#FFFFFF">Mensaje 
                Usuarios</font></div></td>
          </tr>
          <tr> 
            <td width="55%" valign="top"> 
              <select size="6" name="lista[]" multiple style="width:400px; font-size:12px; font-family:ARIAL;" >
                <option value="0" selected>NA</option>
				<?php
				   	$sql_usu = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 order by apa_usr";
					$res_usu = mysql_query($sql_usu);
					while ($row_usu = mysql_fetch_array($res_usu))
					{
			       		echo "<option value=\"$row_usu[login_usr]\">"; 
                		echo $row_usu['apa_usr']." ".$row_usu['ama_usr']." ".$row_usu['nom_usr']." &nbsp;(". $row_usu['area_usr'].")";
						echo "</option>";
                	}
				?>
              </select>
			</td>
            <td align="center" valign="middle"> 
              <textarea name="mensaje_u" cols="40" rows="5"></textarea>
            </td>
          </tr>
          <tr> 
            <td colspan="2" valign="top">&nbsp;</td>
          </tr>
        </table>
        <table width="90%" border="1" align="center" background="images/fondo.jpg">
          <tr bgcolor="#006699"> 
            <td width="55%" class="titulo" background="images/main-button-tileR2.jpg"><font color="#FFFFFF">&nbsp;PROVEEDORES 
              :</font></td>
            <td width="45%" class="titulo" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF">Mensaje 
                PROVEEDORES</font></div></td>
          </tr>
          <tr> 
            <td>
			  <select size="6" name="lista2[]" multiple style="width:400px; font-size:12px; font-family:ARIAL;" >
                <option value="0" selected>NA</option>
				<?php 
				    $sql5 = "SELECT IdProv, NombProv FROM proveedor ORDER BY NombProv ASC";
					$res5 = mysql_query($sql5);
					while ($row5 = mysql_fetch_array($res5))
					{
				    	echo "<option value=\"$row5[IdProv]\">";
               			echo $row5['NombProv']; 
					    echo "</option>";
					}
				?>
              </select>
			</td>
            <td align="center" valign="middle"> 
              <div align="center">
                <textarea name="mensaje_p" cols="40" rows="5"></textarea>
              </div></td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
        </table>
        <table width="90%" border="1" align="center" background="images/fondo.jpg">
          <tr bgcolor="#006699"> 
            <td width="55%" class="titulo" background="images/main-button-tileR2.jpg"><font color="#FFFFFF">&nbsp;ENTIDADES 
              :</font></td>
            <td width="45%" class="titulo" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF">&nbsp;Mensaje 
                ENTIDADES</font></div></td>
          </tr>
          <tr> 
            <td><select size="6" name="lista3[]" multiple style="width:400px; font-size:12px; font-family:ARIAL;" >
                <option value="0" selected>NA</option>
				<?php
				    $sql4 = "SELECT * FROM procesos_parametros WHERE tipo_dep ='2' ORDER BY desc_dep ASC";
					$res4 = mysql_query($sql4);
					while ($row4 = mysql_fetch_array($res4))
					{
				     	echo "<option value=\"$row4[id_dep]\">";
                		echo $row4['desc_dep']; 
						echo "</option>";
					}
				 ?>
              </select></td>
            <td align="center" valign="middle"> 
              <textarea name="mensaje_e" cols="40" rows="5"></textarea>
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
            <td width="88%" class="titulo2">&nbsp; <input type="checkbox"  name="mail" value="1">
              Correo electronico &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              <!--<input type="checkbox" name="msn" value="1">
              Mensaje por Celular--> </td>
          </tr>
        </table></td></tr></table>
  <input name="pg" type="hidden" id="pg" value="<?php echo $pg?>">
  <input name="idproc" type="hidden" id="idproc" value="<?php echo $idproc?>">
  <input name="BUSCAR" type="hidden" value="<?php echo $BUSCAR;?>">
  <input name="menu" type="hidden" value="<?php echo $menu;?>">
  <input name="busc" type="hidden" value="<?php echo $busc;?>">
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
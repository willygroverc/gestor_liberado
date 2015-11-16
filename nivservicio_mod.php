<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		24/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}

if (isset($Terminar)) 
	header("location: actividades_pre_last.php?tip=$varia2&varia2=$varia2&numer=$NumPlanif&ObjNegocio=$objnegocioaux&actividad=1");	
  @session_start();
  $login=$_SESSION["login"];


if (isset($_REQUEST['RETORNAR'])){header("location: nservicio.php");}
if (isset($_REQUEST['GDATOS'])){   
	include("conexion.php");
	//$vigencia="$ano1-$mes1-$dia1";
        $vigencia=$_REQUEST['ano1'].'-'.$_REQUEST['mes1'].'-'.$_REQUEST['dia1'];
        //$var=$_REQUEST['var'];
        //$var2=$_REQUEST['var2'];
        $id_servi=$_REQUEST['id_servi'];
        $desc_ser=$_REQUEST['desc_ser'];
	$clie_ser=$_REQUEST['clie_ser'];
	$especiali=$_REQUEST['especiali'];
	$negocios=$_REQUEST['negocios'];
	$tiem_ser=$_REQUEST['tiem_ser'];
	//$hora_ser=$_REQUEST['hora_ser'];
	$tecnico=$_REQUEST['tecnico'];
	//$tip_acu=$_REQUEST['tip_acu'];
        $hora_ser=$_REQUEST['hora_ser'];
	require_once('funciones.php');
	$desc_ser=_clean($desc_ser);
	$clie_ser=_clean($clie_ser);
	$especiali=_clean($especiali);
	$negocios=_clean($negocios);
	$tiem_ser=_clean($tiem_ser);
	$hora_ser=_clean($hora_ser);
	$vigencia=_clean($vigencia);
	$tecnico=_clean($tecnico);
	
	$desc_ser=SanitizeString($desc_ser);
	$clie_ser=SanitizeString($clie_ser);
	$especiali=SanitizeString($especiali);
	$negocios=SanitizeString($negocios);
	$tiem_ser=SanitizeString($tiem_ser);
	$hora_ser=SanitizeString($hora_ser);
	$vigencia=SanitizeString($vigencia);
	$tecnico=SanitizeString($tecnico);
	$sql5="UPDATE nivservicio SET desc_ser='$desc_ser',clie_ser='$clie_ser',especiali='$especiali',negocios='$negocios',".
	"tiem_ser='$tiem_ser',hora_ser='$hora_ser',vigencia='$vigencia',tecnico='$tecnico'". 
	"WHERE id_servi='$id_servi'";
	mysql_query($sql5);
	header("location: nservicio.php");
}

include("top.php");
$id_servi=($_GET['IdServi']);
$sql = "SELECT *, DATE_FORMAT(vigencia, '%d/%m/%Y') AS vigencia FROM nivservicio WHERE id_servi='$id_servi'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result); 
	$tip_t="tec";
 	$tip_t2=md5($tip_t);
	$tip_p="prov";
	$tip_p2=md5($tip_p);
?> 
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "tecnico",  "Tecnico, $errorMsgJs[empty]" );
$valid->addIsTextNormal ( "desc_ser",  "Descripcion, $errorMsgJs[expresion]" );
$valid->addLength ( "desc_ser",  "Descripcion, $errorMsgJs[length]" );
$valid->addExists ( "tiem_ser",  "Tiempo, $errorMsgJs[empty]" );
$valid->addExists ( "hora_ser",  "Hora, $errorMsgJs[empty]" );
$valid->addIsDate   ( "dia1", "mes1", "ano1", "Vigencia, $errorMsgJs[date]" );
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
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" bgcolor="#EAEAEA"  background="file:///C|/apache/htdocs/images/fondo.jpg">
  <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
    <input name="id_servi" type="hidden" value="<?php echo $id_servi;?>">
    <tr> 
      <td> <table width="100%" border="2" cellpadding="2" cellspacing="4" background="images/fondo.jpg" %align="center" dwcopytype="CopyTableRow">
          <tr> 
            <th colspan="9" bgcolor="#006699" width="100%" ><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>ACUERDO 
              DE NIVEL DE SERVICIO</strong></font></th>
          </tr>
          <tr> 
            <th rowspan="2" nowrap bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">
			<?php if ($tip_t2==$_REQUEST['varia2']){print "Tecnico";}
			   elseif ($tip_p2==$_REQUEST['varia2']){print "Proveedor";}			
			?></font></th>
            <th rowspan="2" nowrap bgcolor="#006699"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Descripcion</font></th>
            <th colspan="3" nowrap bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Responsabilidad 
              / Pre requisitos</font></th>
            <th rowspan="2" nowrap bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Tiempo</font></th>
            <th rowspan="2" nowrap bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Horario</font></th>
            <th rowspan="2" nowrap bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Vigencia</font> 
              <div align="center"></div></th>
          </tr>
          <tr> 
            <th height="19" nowrap bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Cliente</font></th>
            <th nowrap bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Especialista</font></th>
            <th nowrap bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Negocio</font></th>
          </tr>
          <tr align="center"> 
            <?php 
			$sql5 = "SELECT * FROM users WHERE login_usr='$row[tecnico]'";
		    $result5 = mysql_query($sql5);
		    $row5 = mysql_fetch_array($result5);
			if (!empty($row5))
			{echo '<td>&nbsp;'.$row5['nom_usr'].' '.$row5['apa_usr'].' '.$row5['ama_usr'].'</td>';}
			else
			{$sql5 = "SELECT * FROM proveedor WHERE IdProv='".$row['tecnico']."'";
		    $result5 = mysql_query($sql5);
		    $row5 = mysql_fetch_array($result5);
			echo "<td>&nbsp;$row5[NombProv]</td>";}?>
            <td nowrap height="48">&nbsp;<?php echo $row['desc_ser'];?></td>
            <td nowrap height="48">&nbsp;<?php echo $row['clie_ser'];?></td>
            <td nowrap height="48">&nbsp;<?php echo $row['especiali'];?></td>
            <td nowrap>&nbsp;<?php echo $row['negocios'];?></td>
            <td nowrap>&nbsp;<?php echo $row['tiem_ser'];?></td>
            <td nowrap>&nbsp;<?php echo $row['hora_ser'];?></td>
            <td height="48" nowrap>&nbsp;<?php echo $row['vigencia'];?></td>
          </tr>
          <tr> 
            <td height="7" colspan="8" nowrap>&nbsp;</td>
          </tr>
          <tr> 
            <td nowrap>
			<?php if ($tip_t2==$_REQUEST['varia2']){?>
			<select name="tecnico" id="select">
                <option value="0"></option>
              <?php 
			  $link = mysql_connect($host,$user,$pass) or die ("Error durante la conexion a la base de datos"); 
			  $sql8 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear='0' ORDER BY apa_usr ASC";
			  $result8 = mysql_query($sql8);
			  while ($row8 = mysql_fetch_array($result8)) 
				{
				echo '<option value="'.$row8['login_usr'].'"';
				if ($row8['login_usr']==$row['tecnico']) echo "selected";
				echo '>'.$row8['apa_usr'].' '.$row8['ama_usr'].' '.$row8['nom_usr'].'</option>';
	            }
			   ?>
              </select>
			  <?php }
			  elseif ($tip_p2==$_REQUEST['varia2']){?>
			  <select name="tecnico" id="select">
                <option value="0"></option>
              <?php 
			  $link = mysql_connect($host,$user,$pass) or die ("Error durante la conexion a la base de datos"); 
			  $sql8 = "SELECT IdProv, NombProv FROM proveedor ORDER BY NombProv ASC";
			  $result8 = mysql_query($sql8);
			  while ($row8 = mysql_fetch_array($result8)) 
				{
				echo '<option value="'.$row8['IdProv'].'"';
				if ($row8['IdProv']==$row['tecnico']) echo "selected";
				echo '>'.$row8['NombProv'].'</option>';
	            }
			   ?>
              </select>
			  <?php } ?>
			  </td>
            <td nowrap height="7"> <strong> </strong> <textarea name="desc_ser" cols="25"><?php echo $row['desc_ser']?></textarea> 
            </td>
            <td nowrap height="7"><strong> 
              <input name="clie_ser" type="text" value="<?php echo $row['clie_ser']?>" size="10" maxlength="20">
              </strong></td>
            <td nowrap height="7"> <div align="center"><strong> 
                <input name="especiali" type="text" value="<?php echo $row['especiali']?>" size="10" maxlength="30">
                </strong></div></td>
            <td nowrap><strong> 
              <input name="negocios" type="text" value="<?php echo $row['negocios']?>" size="10" maxlength="20">
              </strong></td>
            <td nowrap><strong> 
              <input name="tiem_ser" type="text" value="<?php echo $row['tiem_ser']?>" size="7" maxlength="20">
              </strong></td>
            <td nowrap><strong> 
              <input name="hora_ser" type="text" value="<?php echo $row['hora_ser']?>" size="7" maxlength="5">
              </strong></td>
			  
            <td height="7" nowrap><select name="dia1">
                <?php 
				$a1=substr($row['vigencia'],6,4);
				$m1=substr($row['vigencia'],3,2);
				$d1=substr($row['vigencia'],0,2);
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
              </select> <select name="mes1">
                <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select>
              <select name="ano1">
                <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
              </select>
              <font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font> 
            </td>
          </tr>
          <tr> 
            <td colspan="9" nowrap> <div align="center"><br>
                <input name="GDATOS" type="submit" value="GUARDAR CAMBIOS" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="RETORNAR" value="RETORNAR">
              </div></td>
          </tr>
        </table></td>
    </tr>
  </form>
</table>
<strong> </strong><br>
<script language="JavaScript">
		<!-- 
		 var form="form2";
		 var cal = new calendar1(document.forms[form].elements['dia1'], document.forms[form].elements['mes1'], document.forms[form].elements['ano1']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
//-->
</script>

<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		24/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
// Version: 	2.0
// Objetivo: 	Se ha validado algunos campos como la la hora y el registro de cantidad de tiempo.
// Fecha: 		20/DIC/2013
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($_REQUEST['RETORNAR'])){header("location: nservicio.php");}
if (isset($_REQUEST['reg_form']))
{	require("conexion.php");
	$vigencia=$_REQUEST['ano1'].'-'.$_REQUEST['mes1'].'-'.$_REQUEST['dia1'];
        $var=$_REQUEST['var'];
        $var2=$_REQUEST['var2'];
        $desc_ser=$_REQUEST['desc_ser'];
	$clie_ser=$_REQUEST['clie_ser'];
	$especiali=$_REQUEST['especiali'];
	$negocios=$_REQUEST['negocios'];
	$tiem_ser=$_REQUEST['tiem_ser'];
	//$hora_ser=$_REQUEST['hora_ser'];
	$tecnico=$_REQUEST['tecnico'];
	$tip_acu=$_REQUEST['tip_acu'];
	require_once('funciones.php');
	$desc_ser=_clean($desc_ser);
	$clie_ser=_clean($clie_ser);
	$especiali=_clean($especiali);
	$negocios=_clean($negocios);
	$tiem_ser=_clean($tiem_ser);
	$hora_ser=_clean($hora_ser);
	$vigencia=_clean($vigencia);
	$tecnico=_clean($tecnico);
	$tip_acu=_clean($tip_acu);
	
	$desc_ser=SanitizeString($desc_ser);
	$clie_ser=SanitizeString($clie_ser);
	$especiali=SanitizeString($especiali);
	$negocios=SanitizeString($negocios);
	$tiem_ser=SanitizeString($tiem_ser);
	$hora_ser=SanitizeString($hora_ser);
	$vigencia=SanitizeString($vigencia);
	$tecnico=SanitizeString($tecnico);
	$tip_acu=SanitizeString($tip_acu);
	$hora_ser=$_REQUEST['h'].":".$_REQUEST['m'];
	$sql3="INSERT INTO ".
	"nivservicio(desc_ser,clie_ser,especiali,negocios,tiem_ser,hora_ser,vigencia,tecnico,tip_acuerdo) ".
	"VALUES('$desc_ser','$clie_ser','$especiali','$negocios','$tiem_ser','$hora_ser','$vigencia','$tecnico','$tip_acu')";

        mysql_query($sql3);
	header("location: nivservicio.php?varia1=$var&varia2=$var2");
}
else
{ include("top.php");
$id_servi=($_GET['varia1']);
$tip_t_p=($_GET['varia2']);
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
//$valid->addExists ( "tiem_ser",  "Tiempo, $errorMsgJs[empty]" );
//$valid->addIsNumber  ( "tiem_ser", "Tiempo, $errorMsgJs[number]" );
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
</script><br>
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $id_servi;?>">
	<input name="var2" type="hidden" value="<?php echo $tip_t_p;?>">
	<tr> 
      <td>
        <table border="2" align="center" width="100%" cellpadding="2" cellspacing="4">
          <tr> 
            <th colspan="9" background="images/main-button-tileR1.jpg" height="25"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">ACUERDO 
              DE NIVEL DE SERVICIO</font></th>
          </tr>
          <tr> 
            <th width="20%" rowspan="2" background="images/main-button-tileR11.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">
			<?php if ($tip_t2==$_REQUEST['varia2']){print "Tecnico";}
			   elseif ($tip_p2==$_REQUEST['varia2']){print "Proveedor";}			
			?>
			</font></th>
            <th width="23%" rowspan="2" background="images/main-button-tileR11.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Descripcion</font></th>
            <th colspan="3" nowrap background="images/main-button-tileR11.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Responsabilidad 
              / Pre requisitos</font></th>
            <th width="6%" rowspan="2" nowrap background="images/main-button-tileR11.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Tiempo/dias</font></th>
            <th width="7%" rowspan="2" nowrap background="images/main-button-tileR11.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Horario</font></th>
            <th width="9%" rowspan="2" nowrap background="images/main-button-tileR11.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Vigencia</font> 
              <div align="center"></div></th>
          </tr>
          <tr> 
            <th width="6%" height="19" nowrap background="images/main-button-tileR11.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Cliente</font></th>
            <th width="10%" nowrap background="images/main-button-tileR11.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Especialista</font></th>
            <th width="19%" nowrap background="images/main-button-tileR11.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Negocio</font></th>
          </tr>
          <?php 
		$sql="SELECT *, DATE_FORMAT(vigencia, '%d/%m/%Y') AS vigencia FROM nivservicio WHERE id_servi>='$id_servi' ORDER BY id_servi ASC";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr> 
            <?php 
			$sql5 = "SELECT * FROM users WHERE login_usr='$row[tecnico]'";
		    $result5 = mysql_query($sql5);
		    $row5 = mysql_fetch_array($result5);
			if (!empty($row5))
			{echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";}
			else
			{$sql5 = "SELECT * FROM proveedor WHERE IdProv='$row[tecnico]'";
		    $result5 = mysql_query($sql5);
		    $row5 = mysql_fetch_array($result5);
			echo "<td>&nbsp;$row5[NombProv]</td>";}
			?>
			<td><?php echo $row['desc_ser'];?></td>
            <td>&nbsp;<?php echo $row['clie_ser'];?></td>
            <td>&nbsp;<?php echo $row['especiali'];?></td>
            <td>&nbsp;<?php echo $row['negocios'];?></td>
            <td>&nbsp;<?php echo $row['tiem_ser'];?></td>
            <td>&nbsp;<?php echo $row['hora_ser'];?></td>
            <td>&nbsp;<?php echo $row['vigencia'];?></td>
          </tr>
          <?php } ?>
        </table>
		<p>&nbsp;</p>		  
        <table border="2" width="100%" %align="center" cellpadding="2" cellspacing="4" dwcopytype="CopyTableRow">
          <tr> 
            <th colspan="9" background="images/main-button-tileR11.jpg" height="25"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">ACUERDO 
              DE NIVEL DE SERVICIO</font></th>
          </tr>
          <tr> 
            <th rowspan="2" nowrap background="images/main-button-tileR11.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">
			<?php if ($tip_t2==$_REQUEST['varia2']){print "Tecnico";}
			   elseif ($tip_p2==$_REQUEST['varia2']){print "Proveedor";}			
			?>
			</font></th>
            <th rowspan="2" nowrap background="images/main-button-tileR11.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Descripcion</font></th>
            <th colspan="3" nowrap background="images/main-button-tileR11.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Responsabilidad 
              / Pre requisitos</font></th>
            <th rowspan="2" nowrap background="images/main-button-tileR11.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Tiempo/dias</font></th>
            <th rowspan="2" nowrap background="images/main-button-tileR11.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Horario</font></th>
            <th rowspan="2" nowrap background="images/main-button-tileR11.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Vigencia</font></div></th>
          </tr>
          <tr> 
            <th height="19" nowrap background="images/main-button-tileR11.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Cliente</font></th>
            <th nowrap background="images/main-button-tileR11.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Especialista</font></th>
            <th nowrap background="images/main-button-tileR11.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Negocio</font></th>
          </tr>
          <tr> 
            <td nowrap height="7"> <div align="center">
        <?php 	if ($tipo=="A" || $tipo=="B") { 
			    	if ($tip_t2==$_REQUEST['varia2']){?>
					<input name="tip_acu" type="hidden" value="T">
					<select name="tecnico" id="select">
                	<option value="0"></option>
               			<?php
			  			$sql8 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear='0' ORDER BY apa_usr ASC";
			 		 	$result8 = mysql_query($sql8);
			  			while ($row8 = mysql_fetch_array($result8)) 
						{echo "<option value=\"$row8[login_usr]\">$row8[apa_usr] $row8[ama_usr] $row8[nom_usr]</option>";}
						?>
                	</select>
				  <?php } elseif ($tip_p2==$_REQUEST['varia2']){?>
				    <input name="tip_acu" type="hidden" value="P">
                    <select name="tecnico" id="select">
                	<option value="0"></option>
               			<?php
			  			$sql8 = "SELECT IdProv, NombProv FROM proveedor ORDER BY NombProv ASC";
			 		 	$result8 = mysql_query($sql8);
			  			while ($row8 = mysql_fetch_array($result8)) 
						{echo "<option value=\"$row8[IdProv]\">$row8[NombProv]</option>";}
						?>
                	</select>
				  <?php }} else { ?>
			  		<select name="tecnico" id="select">
					<option value="0"></option>	
						<?php $sql8 = "SELECT * FROM users WHERE login_usr='$login' ORDER BY apa_usr ASC";
			  			$result8 = mysql_query($sql8);
			  			$row8 = mysql_fetch_array($result8); 
						echo "<option value=\"$row8[login_usr]\">$row8[apa_usr] $row8[ama_usr] $row8[nom_usr]</option>";
				   		?>
                	</select>
			      <?php }  ?>
			  </div></td>
            <td nowrap><textarea name="desc_ser" cols="15"></textarea></td>
            <td nowrap height="7"><div align="center"><strong> 
                <input name="clie_ser" type="text" size="10" maxlength="20">
                </strong></div></td>
            <td nowrap height="7"> <div align="center"><strong> 
                <input name="especiali" type="text" size="10" maxlength="30">
                </strong></div></td>
            <td nowrap><div align="center"><strong> 
                <input name="negocios" type="text" size="10" maxlength="30">
                </strong></div></td>
            <td nowrap><div align="center"><strong> 
                <input name="tiem_ser" type="text" size="7" maxlength="20">
                </strong></div></td>
            <td nowrap><div align="center"><strong> 
                <!--<input name="hora_ser" type="text" size="7" maxlength="5">-->
				<select name="h" id="h">
				<?php
					for($i=1;$i<=23;$i++){
						if(strlen($i)==1)
						{	echo '<option value="'; echo "0".$i; echo '">'; echo "0".$i; echo '</option>';	}
						else
						{	echo '<option value="'; echo $i; echo '">'; echo $i; echo '</option>';	}
					}
				?>
				</select>&nbsp;&nbsp;&nbsp;
				<select name="m" id="m">
				<?php
					for($i=0;$i<=60;$i=$i+5){
						if(strlen($i)==1)
						{	echo '<option value="'; echo "0".$i; echo '">'; echo "0".$i; echo '</option>';	}
						else
						{	echo '<option value="'; echo $i; echo '">'; echo $i; echo '</option>';	}
					}
				?>
				</select>
                </strong></div></td>
            <td height="7" nowrap> <div align="center"> 
                <?php 
			  $fsist=date("Y-m-d");
			  
			   ?>
                <select name="dia1">
                  <?php
  				$a1=substr($fsist,0,4);
				$m1=substr($fsist,5,2);
				$d1=substr($fsist,8,2);
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
                </select>
                <select name="mes1">
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
              </div></td>
          </tr>
          <tr> 
            <td colspan="9" nowrap> <div align="center"><br>
                <input name="reg_form" type="submit" value="INSERTAR" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
              </div></td>
          </tr>
        </table>
      </td>
    </tr></form>
  </table>
 <?php } ?>
  <strong> </strong><br>
  <script language="JavaScript">
		<!-- 
		 var form="form2";
		 var cal = new calendar1(document.forms[form].elements['dia1'], document.forms[form].elements['mes1'], document.forms[form].elements['ano1']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
//-->
</script>
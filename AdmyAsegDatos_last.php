<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		23/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
else{
	header('location:login.php');
}

if (isset($_REQUEST['RETORNAR'])){header("location: lista_admyaseg.php");}
if (isset($_REQUEST['GUARDATOS'])) {
  include ("conexion.php");
  //$FechaAdAs="$ano1-$mes1-$dia1";
  $FechaAdAs=$_REQUEST['ano1'].'-'.$_REQUEST['mes1'].'-'.$_REQUEST['dia1'];
  $Tipo=$_REQUEST['Tipo'];
  $IdAdmyAseg=$_REQUEST['IdAdmyAseg'];
  $sql3="SELECT * FROM admyasegdatos WHERE IdAdmyAseg='$IdAdmyAseg' AND Tipo='$Tipo'";

  $result3 = mysql_query($sql3);
  $row3 = mysql_fetch_array($result3);
  if ($row3['NombProy']==$_REQUEST['NombProy']){
	  require_once("funciones.php");
	  $NombProy=_clean($NombProy);
	  $NombResp=_clean($NombResp);
	  $DocuRef=_clean($DocuRef);
	  $DocuSoporte=_clean($DocuSoporte);
	  
	  $NombProy=SanitizeString($NombProy);
	  $NombResp=SanitizeString($NombResp);
	  $DocuRef=SanitizeString($DocuRef);
	  $DocuSoporte=SanitizeString($DocuSoporte);
          
          $NombProy=$_REQUEST['NombProy'];
	  $NombResp=$_REQUEST['NombResp'];
	  $DocuRef=$_REQUEST['DocuRef'];
	  $DocuSoporte=$_REQUEST['DocuSoporte'];
      $sql = "UPDATE admyasegdatos SET NombProy='$NombProy',NombResp='$NombResp',DocuRef='$DocuRef',DocuSoporte='$DocuSoporte',".
  		     "FechaAdAs='$FechaAdAs' WHERE IdAdmyAseg='$IdAdmyAseg' AND Tipo='$Tipo'";
	  $result=mysql_query($sql);
	  if ($Tipo=="ADMINISTRACION DE RECURSOS HUMANOS")
	     {header("location: admrhumanos1_last.php?variable1=$IdAdmyAseg");}
	  else
	     {header("location: AdmyAsegAlcance_last.php?variable1=$_REQUEST[IdAdmyAseg]&variable2=$_REQUEST[Tipo]");}
  }
  else{
      $sql1 = "SELECT * FROM admyasegdatos WHERE Tipo='$Tipo' AND NombProy='$NombProy'";
      $result1 = mysql_query($sql1);
      $row1 = mysql_fetch_array($result1);
      if ($row1['IdAdmyAseg']){$msg="Ya existe un proyecto de tipo ".$Tipo." con el nombre ".$NombProy." registrado ";}
  }	
  $IdAdm=($_POST['IdAdm']);
  $Tip=($_POST['Tip']);
} 
else
{ 
$IdAdm=($_GET['IdAdmyAseg']);
$Tip=($_GET['Tipo']);
}
include ("top.php");?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addExists ( "NombProy",  "Nombre del Proyecto, $errorMsgJs[empty]" );
$valid->addLength( "NombProy",  "Nombre del Proyecto, $errorMsgJs[length]" );
$valid->addIsNotEmpty ( "NombResp",  "Nombre del Responsable, $errorMsgJs[empty]" );
$valid->addIsDate   ( "dia1", "mes1", "ano1", "Fecha, $errorMsgJs[date]" );
$valid->addExists ( "DocuRef",  "Documentacion de Referencia, $errorMsgJs[empty]" );
$valid->addLength( "DocuRef",  "Documentacion de Referencia, $errorMsgJs[length]" );
$valid->addExists ( "DocuSoporte",  "Documentacion de Soporte, $errorMsgJs[empty]" );
$valid->addLength( "DocuSoporte",  "Documentacion de Soporte, $errorMsgJs[length]" );
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
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" onKeyPress="return Form()">
    <input name="IdAdmyAseg" type="hidden" value="<?php echo $_REQUEST['IdAdmyAseg'];?>">
    <input name="Tipo" type="hidden" value="<?php echo $_REQUEST['Tipo'];?>">
  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="326"><div align="center"> 
          <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
            <tr> 
              <td><div align="center"><strong><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">ADMINISTRACION 
                  / ASEGURAMIENTO DE PROYECTOS</font></strong></div></td>
            </tr>
          </table>
         <table width="100%" border="1" cellpadding="1" cellspacing="0" background="images/fondo.jpg">
            <tr>
              <td height="250"> 
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr> 
                    <td colspan="3">
<div align="center">
<table width="100%">
                          <tr>
                            <td height="15">
                <div align="right"><font size="2" face="Arial, Helvetica, sans-serif"> 
                <?php 	$sql2 = "SELECT * FROM admyasegdatos WHERE Tipo='$Tip' AND IdAdmyAseg='$IdAdm'";
				$result2=mysql_query($sql2);
  				$row2=mysql_fetch_array($result2);?>
                                Nro. de Formulario :</font><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $IdAdm;?></font></div></td>
                          </tr>
                        </table>
                        <table width="100%">
                          <tr>
                            <td height="26">
<div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">TIPO 
                                DE FORMULARIO :</font>&nbsp;</strong> <font size="2" face="Arial, Helvetica, sans-serif"><?php echo $Tip;?></font> 
                              </div></td>
                          </tr>
                        </table>
                        
                        <br>
                      </div></td>
                  </tr>
                  <tr> 
                    <td width="19%" height="11"> <div align="center">&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">&nbsp;Nombre 
                        del proyecto :</font> </div></td>
                    <td width="81%">
						<select name="NombProy" id="NombProy">
                <?php
				
					echo "<option value=\"0\"></option>";
					$sql0 = "SELECT DISTINCT Requerimiento FROM solicproydatos ORDER BY Requerimiento ASC";
 			  		$result0=mysql_query($sql0);
			  		while ($row0=mysql_fetch_array($result0)) {
						if ($row2['NombProy']==$row0['Requerimiento'])
							echo '<option value="'.$row0['Requerimiento'].'" selected>'.$row0['Requerimiento']."</option>";
						else
							echo '<option value="'.$row0['Requerimiento'].'">'.$row0['Requerimiento'].'</option>';
					}
			   ?>
              </select>
                    <td width="0%" height="11">&nbsp;</td>
                  </tr>
                  <tr> 
                    <td height="19" colspan="3">&nbsp;</td>
                  </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td height="25" colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Nombre 
                      del Responsable :</font> <strong> 
                      <select name="NombResp" id="select2">
                        <option value="0"></option>
                        <?php 
			  $sql = "SELECT * FROM users WHERE bloquear=0 AND tipo2_usr='T' OR tipo2_usr='C' ORDER BY apa_usr ASC";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{
				   if ($row['login_usr']==$row2['NombResp'])
				 			echo '<option value="'.$row['login_usr'].'" selected>'.$row['apa_usr'].' '.$row['ama_usr'].' '.$row['nom_usr'].'</option>';
				   else
							echo '<option value="'.$row['login_usr'].'">'.$row['apa_usr'].' '.$row['ama_usr'].' '.$row['nom_usr'].'</option>';
	            }
			   ?>
                      </select>
                      </strong></td>
                    <td height="25" colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha 
                      :</font>&nbsp;<strong> 
                      <select name="dia1" >
                        <?php
  				$a1=substr($row2['FechaAdAs'],0,4);
				$m1=substr($row2['FechaAdAs'],5,2);
				$d1=substr($row2['FechaAdAs'],8,2);
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
                      <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font> 
                      </strong></td>
                  </tr>
                  <tr> 
                    <td width="19%" height="22"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Documentacion 
                        de Referencia&nbsp;&nbsp;:&nbsp;</font>&nbsp;&nbsp;&nbsp; 
                      </div></td>
                    <td width="34%"> <div align="left"> 
                        <textarea name="DocuRef" cols="30"><?php echo $row2['DocuRef'];?></textarea>
                      </div></td>
                    <td width="17%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                        Documentacion de Soporte:</font> </div></td>
                    <td width="30%"> <div align="left"> 
                        <textarea name="DocuSoporte" cols="30"><?php echo $row2['DocuSoporte'];?></textarea>
                      </div></td>
                  </tr>
                  <tr> 
                    <td colspan="2">&nbsp;</td>
                    <td colspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<br>
                        </font></div></td>
                  </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="100%" height="43"> 
                      <p align="center"><br>
                        <input type="submit" name="GUARDATOS" value="GUARDAR DATOS Y CONTINUAR"  <?php print $valid->onSubmit() ?>>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
                      </p></td>
                  </tr>
                </table>
                
              </td>
            </tr>
          </table>
             
          
        </div></td>
    </tr>
  </table>
</form>
    <script language="JavaScript">
		<!-- 
		 var form="form1";
		 var cal = new calendar1(document.forms[form].elements['dia1'], document.forms[form].elements['mes1'], document.forms[form].elements['ano1']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
//-->
</script>

<script language="JavaScript">
		<!-- 
		<?php if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
//-->
</script>
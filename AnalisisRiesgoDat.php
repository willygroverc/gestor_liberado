
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
if (isset($_REQUEST['RETORNAR'])){header("location: lista_analisisriesgos.php");}
if (isset($_REQUEST['GUARDATOS'])) {
  include ("conexion.php");
  require_once('funciones.php');
  $NombProy=$_REQUEST['NombProy'];
  $NombResp=$_REQUEST['NombResp'];
  $DocuRef=$_REQUEST['DocuRef'];
  $DescImpacto=$_REQUEST['DescImpacto'];
  $AccionPrev=$_REQUEST['AccionPrev'];
  $AccionConting=$_REQUEST['AccionConting'];
  $DocuSoporte=$_REQUEST['DocuSoporte'];
  
  $IdAnalisis=_clean($IdAnalisis);
  $NombProy=_clean($NombProy);
  $NombResp=_clean($NombResp);
  $DocuRef=_clean($DocuRef);
  $DescImpacto=_clean($DescImpacto);
  $AccionPrev=_clean($AccionPrev);
  $AccionConting=_clean($AccionConting);
  $DocuSoporte=_clean($DocuSoporte);
  $FechaAnalisis=_clean($FechaAnalisis);
  
  $IdAnalisis=SanitizeString($IdAnalisis);
  $NombProy=SanitizeString($NombProy);
  $NombResp=SanitizeString($NombResp);
  $DocuRef=SanitizeString($DocuRef);
  $DescImpacto=SanitizeString($DescImpacto);
  $AccionPrev=SanitizeString($AccionPrev);
  $AccionConting=SanitizeString($AccionConting);
  $DocuSoporte=SanitizeString($DocuSoporte);
  $FechaAnalisis=SanitizeString($FechaAnalisis);
  
  //$FechaAnalisis="$ano1-$mes1-$dia1";
  $FechaAnalisis=$_REQUEST['ano1'].'-'.$_REQUEST['mes1'].'-'.$_REQUEST['dia1'];
  
  $sql = "INSERT INTO analisisriesgdatos (NombProy,NombResp,DocuRef,DescImpacto,AccionPrev,AccionConting,DocuSoporte,FechaAnalisis) ".
         "VALUES ('$NombProy','$NombResp','$DocuRef','$DescImpacto','$AccionPrev','$AccionConting','$DocuSoporte','$FechaAnalisis')";
  $result=mysql_query($sql);
	//echo $sql;
  $sql2 = "SELECT MAX(IdAnalisis) AS ID FROM analisisriesgdatos";
  $result2=mysql_query($sql2);
  $row2=mysql_fetch_array($result2);
  if($row2['ID']==null)
	$row2['ID']=1;
  header("location: AnalisisRiesgoDesc.php?variable1=$row2[ID]");
  }
  
else { ?>
<?php include ("top.php");?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsTextNormal ( "NombProy",  "Nombre del Proyecto, $errorMsgJs[expresion]" );
$valid->addLength ( "NombProy",  "Nombre del Proyecto, $errorMsgJs[length]" );
$valid->addIsNotEmpty( "NombResp",  "Nombre del Responsable, $errorMsgJs[empty]" );
$valid->addIsDate( "dia1", "mes1", "ano1",  "Fecha, $errorMsgJs[date]" );
$valid->addIsTextNormal ( "DocuRef",  "Documentacion de Referencia, $errorMsgJs[expresion]" );
$valid->addLength ( "DocuRef",  "Documentacion de Referencia, $errorMsgJs[length]" );
$valid->addIsTextNormal ( "DescImpacto",  "Descripcion del Impacto, $errorMsgJs[expresion]" );
$valid->addLength ( "DescImpacto",  "Descripcion del Impacto, $errorMsgJs[length]" );
$valid->addIsTextNormal ( "AccionPrev",  "Acciones Preventivas, $errorMsgJs[expresion]" );
$valid->addLength ( "AccionPrev",  "Acciones Preventivas, $errorMsgJs[length]" );
$valid->addIsTextNormal ( "AccionConting",  "Acciones de Contingencia, $errorMsgJs[expresion]" );
$valid->addLength ( "AccionConting",  "Acciones de Contingencia, $errorMsgJs[length]" );
$valid->addIsTextNormal ( "DocuSoporte",  "Documentacion de Soporte, $errorMsgJs[expresion]" );
$valid->addLength ( "DocuSoporte",  "Documentacion de Soporte, $errorMsgJs[length]" );
print $valid->toHtml();
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
<form name="form1" method="post" action="" onKeyPress="return Form()">
  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td height="326">
<div align="center">
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
            <tr> 
              <td background="images/main-button-tileR1.jpg" height="20"><div align="center"><strong><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">ANALISIS 
                  DE RIESGOS DE PROYECTOS</font></strong></div></td>
            </tr>
          </table>
          <table width="100%" border="1" cellpadding="1" cellspacing="0" background="images/fondo.jpg">
            <tr>
              <td height="257"> 
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
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
								echo '<option value="'.$row0['Requerimiento'].'">'.$row0['Requerimiento'].'</option>';
						}
				   ?>
				   </select>					  
				   </td>
                   <td width="0%" height="11">&nbsp;</td>
                  </tr>
                  
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="471" height="25"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<br>
                      Nombre del Responsable :</font> <strong> 
                      <select name="NombResp" id="select2">
                        <option value="0"></option>
                        <?php 
			  $sql = "SELECT * FROM users WHERE bloquear=0 AND tipo2_usr='T' OR tipo2_usr='C' ORDER BY apa_usr ASC";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo '<option value="'.$row['login_usr'].'">'.$row['apa_usr'].' '.$row['ama_usr'].' '.$row['nom_usr'].'</option>';
	            }
			   ?>
                      </select>
                      <br>
                      </strong></td>
                    <td width="401" height="25" colspan="3"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                      Fecha :</font>&nbsp;<strong> 
                      <?php 
			  $fsist=date("Y-m-d");
			  
			   ?>
                      <select name="dia1" >
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
                      <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font> 
                      </strong></td>
                  </tr>
                  
                </table>
                <br>
                <table width="100%">
                  <tr>
                    <td width="15%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Documentacion 
                        de Referencia&nbsp;&nbsp;</font></div></td>
                    <td width="40%"><textarea name="DocuRef" cols="35"></textarea></td>
                    <td width="13%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Descripcion 
                        del Impacto</font> </div></td>
                    <td width="32%"><textarea name="DescImpacto" cols="35"></textarea></td>
                  </tr>
                </table>
                <table width="100%">
                  <tr> 
                    <td width="10%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Acciones 
                        Preventivas Recomendadas </font></div></td>
                    <td width="25%"><textarea name="AccionPrev" cols="27" id="AccionPrev"></textarea></td>
                    <td width="9%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Acciones 
                        de Contingencia Recomendadas</font></div></td>
                    <td width="24%"><textarea name="AccionConting" cols="27"></textarea></td>
                    <td width="9%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Documentacion 
                        de Soporte</font></div></td>
                    <td width="23%"><font size="2" face="Arial, Helvetica, sans-serif"> 
                      <textarea name="DocuSoporte" cols="27"></textarea>
                      </font></td>
                  </tr>
                  <tr> 
                    <td colspan="6">&nbsp;</td>
                  </tr>
                </table>
                <table width="100%">
                  <tr> 
                    <td><div align="center"> 
                        <input type="submit" name="GUARDATOS" value="GUARDAR Y CONTINUAR" <?php print $valid->onSubmit() ?>>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        <input name="RETORNAR" type="submit" id="RETORNAR3" value="RETORNAR">
                      </div></td>
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
<?php
} 
?>
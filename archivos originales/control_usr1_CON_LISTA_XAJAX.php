<?php
// Version: 	2.0
// Objetivo: 	Cambio de la estructura de registro, reduccion de tiempo en procesamiento de datos.
//				Control Acceso Directo a Fichero No Autorizado.
//				Limpieza de registro de datos.
// Fecha: 		28/AGO/2012
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
require_once('xajax/xajax.inc.php');
@session_start();
require_once('funciones.php');

function eliminarFila($id_campo, $cant_campos){
	$respuesta = new xajaxResponse();
	$respuesta->addRemove("rowDetalle_$id_campo"); 
	-- $cant_campos; 
	if($cant_campos == 0){
		$respuesta->addRemove("rowDetalle_0");
		$respuesta->addAssign("num_campos", "value", "0"); 
		$respuesta->addAssign("cant_campos", "value", "0");
	}
    $respuesta->addAssign("cant_campos", "value", $cant_campos);    
	return $respuesta;
}

function cancelar(){ 
    
    $respuesta = new xajaxResponse();
	$respuesta->addAssign("cant_campos", "value", "0");
    return $respuesta;
}

function agregarFila($formulario){
    $respuesta = new xajaxResponse();    
	extract($formulario);	
	include('conexion.php');
	$sql="SELECT Descripcion FROM sistemas WHERE Id_Sistema='$AplicSistema'";
	$result=mysql_query($sql);
	$fila=mysql_fetch_array($result);
	$tipoAcc=$fila['Descripcion'];
	$id_campos = $cant_campos = $num_campos+1;
	$sql_u="SELECT MAX(idControl) As ult FROM control_usr";
	$result_u=mysql_query($sql_u);
	$fila_u=mysql_fetch_array($result_u);
	$var=$fila_u['ult']+1;
	$cant_campos=SanitizeString($cant_campos);
	$NombreUsr=SanitizeString($NombreUsr);
	$Idu=SanitizeString($Idu);
	$tipoAcc=SanitizeString($tipoAcc);
	$TipoAcceso=SanitizeString($TipoAcceso);
	$fecha=SanitizeString($fecha);

	$str_html_td1 = $cant_campos . '<input type="hidden" id="hdncant_campos' . $id_campos . '" name="hdncant_campos' . $id_campos . '" value="' . $cant_campos . '"/>' ;
    $str_html_td2 = "$NombreUsr" . '<input type="hidden" id="hdnNombreUsr' . $id_campos . '" name="hdnNombreUsr' . $id_campos . '" value="' . $NombreUsr . '"/>' ;
    $str_html_td3 = "$Idu" . '<input type="hidden" id="hdnIdu' . $id_campos . '" name="hdnIdu' . $id_campos . '" value="' . $Idu . '"/>' ;
    $str_html_td4 = "$tipoAcc" . '<input type="hidden" id="hdntipoAcc' . $id_campos . '" name="hdntipoAcc' . $id_campos . '" value="' . $tipoAcc . '"/>' ;
    $str_html_td4 .= '<input type="hidden" id="AplicSistema' . $id_campos . '" name="AplicSistema' . $id_campos . '" value="' . $AplicSistema . '"/>' ;
	$str_html_td5 = "$TipoAcceso" . '<input type="hidden" id="hdnTipoAcceso' . $id_campos . '" name="hdnTipoAcceso' . $id_campos . '" value="' . $TipoAcceso . '"/>' ;
	$str_html_td6 = "$fecha" . '<input type="hidden" id="hdnfecha' . $id_campos . '" name="hdnfecha' . $id_campos . '" value="' . $fecha . '"/>' ;
	$str_html_td7 = '<img src="images/delete.png" width="16" height="16" alt="Eliminar" onclick="if(confirm(\'Realmente desea eliminar este detalle?\')){xajax_eliminarFila('. $id_campos .', proyecto.cant_campos.value);}"/>';
    $str_html_td7 .= '<input type="hidden" id="hdnIdCampos_'. $id_campos .'" name="hdnIdCampos[]" value="'. $id_campos .'" />';
	$str_html_td7 .= '<input type="hidden" id="hdnvar' . $id_campos . '" name="hdnvar' . $id_campos . '" value="' . $var . '"/>';

	if($num_campos == 0){ 
		$respuesta->addCreate("tbDetalle", "tr", "rowDetalle_0");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_01");  
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_02");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_03");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_04");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_05");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_06");
		$respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_07");

        $respuesta->addAssign("tdDetalle_01", "innerHTML", "Nro."); 
        $respuesta->addAssign("tdDetalle_02", "innerHTML", "Nombre de Usuario");
        $respuesta->addAssign("tdDetalle_03", "innerHTML", "Login");
        $respuesta->addAssign("tdDetalle_04", "innerHTML", "Aplicacion/Sistema");
        $respuesta->addAssign("tdDetalle_05", "innerHTML", "Tipo de Acceso");
        $respuesta->addAssign("tdDetalle_06", "innerHTML", "Fecha Ingreso");
		$respuesta->addAssign("tdDetalle_07", "innerHTML", "Eliminar");
	}
    $idRow = "rowDetalle_$id_campos";
    $idTd = "tdDetalle_$id_campos";
	$respuesta->addCreate("tbDetalle", "tr", $idRow);
    $respuesta->addCreate($idRow, "td", $idTd."1");    
    $respuesta->addCreate($idRow, "td", $idTd."2");
    $respuesta->addCreate($idRow, "td", $idTd."3");
    $respuesta->addCreate($idRow, "td", $idTd."4");
    $respuesta->addCreate($idRow, "td", $idTd."5");
    $respuesta->addCreate($idRow, "td", $idTd."6");
	$respuesta->addCreate($idRow, "td", $idTd."7");
	
	
    $respuesta->addAssign($idTd."1", "innerHTML", $str_html_td1);  
	$respuesta->addAssign($idTd."1", "align", "center");
    $respuesta->addAssign($idTd."2", "innerHTML", $str_html_td2);
	$respuesta->addAssign($idTd."2", "align", "center");
    $respuesta->addAssign($idTd."3", "innerHTML", $str_html_td3);
	$respuesta->addAssign($idTd."3", "align", "center");
    $respuesta->addAssign($idTd."4", "innerHTML", $str_html_td4);
	$respuesta->addAssign($idTd."4", "align", "center");
    $respuesta->addAssign($idTd."5", "innerHTML", $str_html_td5);
	$respuesta->addAssign($idTd."5", "align", "center");
    $respuesta->addAssign($idTd."6", "innerHTML", $str_html_td6);
	$respuesta->addAssign($idTd."6", "align", "center");
	$respuesta->addAssign($idTd."7", "innerHTML", $str_html_td7);
	$respuesta->addAssign($idTd."7", "align", "center");
	$respuesta->addAssign("num_campos","value", $id_campos);
	$respuesta->addAssign("cant_campos" ,"value", $id_campos);    
	return $respuesta;
}
function guardar($formulario) {
	$flag = 0;
    extract($formulario);
    $respuesta = new xajaxResponse();
	include("conexion.php");
    foreach($hdnIdCampos as $id){  
	$sqlin = "INSERT INTO control_usr (IdControl,IdUsr,NombreUsr,Idu,AplicSistema,TipoAcceso,FechaIn,FechaOut,Observ)
                        VALUES('" . $formulario['hdnvar' . $id] . "', '" . $formulario['hdncant_campos' . $id] . "', '" . $formulario['hdnNombreUsr' . $id] . "',
                        '" . $formulario['hdnIdu' . $id] . "', '". $formulario['AplicSistema' . $id] . "', '". $formulario['hdnTipoAcceso' . $id] . "', '". $formulario['hdnfecha' . $id] . "',
						'0000-00-00','null')";   
		if(mysql_query($sqlin))
		{	$flag = 1;	}
    }
    if($flag==1)
		$MSG = "Datos registrados...";
	else
		$MSG = "Error al insertar, contacte a soporte.";
    
	$respuesta->addAlert($MSG);
	$respuesta->redirect('lista_control_usr.php', 0);
    return $respuesta;	
}
function retornar($formulario){
	$respuesta = new xajaxResponse();
	$respuesta->redirect('lista_control_usr.php', 0);
    return $respuesta;
}
function ver($formulario) {
	include('conexion.php');
	$var1=$formulario['idcontrol'];
	//$sql = "SELECT *, DATE_FORMAT(FechaIn, '%d/%m/%Y') AS FechaIn FROM control_usr WHERE IdControl='$var1' ORDER BY IdUsr ASC";
	//$result=mysql_query($sql);
	$fla='<table width="90%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th colspan="6" background="images/main-button-tileR2.jpg">CONTROL DE USUARIOS</th>
          </tr><tr align="center"> 
            <th class="menu" background="images/main-button-tileR1.jpg">Nro.</th>
            <th class="menu" background="images/main-button-tileR1.jpg">Nombre Usuario</th>
            <th class="menu" background="images/main-button-tileR1.jpg">Login</th>
            <th class="menu" background="images/main-button-tileR1.jpg">Aplicacion / Sistema</th>
            <th width="180" class="menu" background="images/main-button-tileR1.jpg">Tipo de Acceso</th>
            <th class="menu" background="images/main-button-tileR1.jpg">Fecha Ingreso </th>
          </tr>';
		  $sql = "SELECT *, DATE_FORMAT(FechaIn, '%d/%m/%Y') AS FechaIn FROM control_usr WHERE IdControl='$var1' ORDER BY IdUsr ASC";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{   
			$fla .='<tr align="center">'; 
            $fla .='<td height="25">&nbsp;'. $row['IdUsr'].'</td>';
			$fla .= '
				<td>'. $row['Idu'].'</td>
				<td>&nbsp;'.$row['TipoAcceso'].'</td>
				<td>&nbsp;'. $row['FechaIn'].'</td>
			</tr>';
		}
	$fla .= '</table>';
   $respuesta = new xajaxResponse();
   $salida=$fla;
   $respuesta->addAssign("respuesta","innerHTML",$salida);
   return $respuesta;
}
$xajax=new xajax();        
$xajax->setCharEncoding("iso-8859-1"); 
$xajax->decodeUTF8InputOn();            
$xajax->registerFunction("agregarFila");
$xajax->registerFunction("cancelar");
$xajax->registerFunction("guardar");
$xajax->registerFunction("eliminarFila");
$xajax->registerFunction("ver");
$xajax->processRequests();
?>
<html>
<meta http-equiv="Pragma"content="no-cache">
<meta http-equiv="expires"content="0">
<head>
<?php $xajax->printJavascript("xajax"); 
include('top.php');
?>
<link href="CSS/style.css" rel="stylesheet" type="text/css">
</head>
<body onload="xajax_ver(xajax.getFormValues('frm_usu'));">
<div id="respuesta"></div>
<form name="frm_usu" id="frm_usu" action="" method="post">
<input type="hidden" id="num_campos" name="num_campos" value="0" />
<input type="hidden" id="cant_campos" name="cant_campos" value="0" />
<input type="hidden" id="idcontrol" name="idcontrol" value="<?php echo $IdControl;	?>" />
<div id="top" class="container">
<table width="90%" border="2" cellspacing="4" cellpadding="2" background="images/fondo.jpg">
          <tr align="center"> 
            <th class="menu" background="images/main-button-tileR1.jpg">Nombre Usuario</th>
            <th class="menu" background="images/main-button-tileR1.jpg">Login</th>
            <th class="menu" background="images/main-button-tileR1.jpg">Aplicacion / Sistema</th>
          </tr>
          <tr align="center"> 
         
            <?php 	$sql4 = "SELECT * FROM control_usr WHERE IdControl='$IdControl'";
				$result4=mysql_query($sql4);
				$row4=mysql_fetch_array($result4); ?>
            <td align="center"> <div align="center">
                <select name="NombreUsr" id="NombreUsr">
                  <?php 
						$sql = "SELECT * FROM users WHERE bloquear=0 AND (tipo2_usr='T' OR tipo2_usr='A' OR tipo2_usr='C') ORDER BY apa_usr ASC";
			  			$result = mysql_query($sql);
			  			while ($row = mysql_fetch_array($result)) 
						{
							$sql01 = "SELECT * FROM control_usr WHERE NombreUsr='$row[login_usr]'";
						  	$result01=mysql_query($sql01);
						  	$row01=mysql_fetch_array($result01);
							if (!$row01['NombreUsr'])
							{echo '<option value="'.$row['login_usr'].'">'.$row['apa_usr'].' '.$row['ama_usr'].' '.$row['nom_usr'].'</option>';}
			   			}
						?>
                </select>
              </div>
              <div align="center"></div></td>
            <td align="center"> <input name="Idu" id="Idu" type="text" maxlength="35"> 
            </td>
            <td><div align="center">
                <select name="AplicSistema" id="AplicSistema">
                  <?php 
				  $sql = "SELECT * FROM sistemas";
				  $result = mysql_query($sql);
				  while ($row = mysql_fetch_array($result)) 
					{
					echo '<option value="'.$row['Id_Sistema'].'">'.$row['Descripcion'].'</option>';
					}
					?>
                </select>
              </div></td>
          </tr>
          <tr align="center"> 
            <th colspan="2" class="menu" background="images/main-button-tileR1.jpg">Tipo de Acceso</th>
            <th colspan="2" class="menu" background="images/main-button-tileR1.jpg">Fecha Ingreso </th>
          </tr>
          <tr> 
            <td colspan="2"><div align="center"><strong> 
                <input name="TipoAcceso" type="text" id="TipoAcceso" value="" size="30" maxlength="30">
                </strong></div></td>
            <td colspan="2" align="center"><strong> </strong> <div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <input type="text" name="fecha" id="fecha" value="<?php echo date('Y-m-d');	?>" 
              
               
			   </font></strong></font></strong></div></td>
          </tr>
				<div class="clear"></div>
</table> 
</div>
<div class="button_div">   
</br> 
    <input type="reset" id="btnCancel" name="btnCancel" value="LIMPIAR DATOS" class="buttons_CANCEL" onclick="xajax_cancelar();" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" id="btnAgregar" name="btnAgregar" value="INSERTAR" class="buttons_aplicar" onclick="xajax_agregarFila(xajax.getFormValues('frm_usu'));" />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="button" id="btnAgregar" name="btnAgregar" value="GUARDAR TODO" class="buttons_OK" onclick="xajax_guardar(xajax.getFormValues('frm_usu'));" />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="button" id="btnRetornar" name="btnRetornar" value="RETORNAR" class="buttons_OK" onclick="xajax_retornar(xajax.getFormValues('frm_usu'));" />
	</div>
	</br>
	<div id="form3" class="form-horiz">
					<table width="90%" id="tblDetalle" class="tbl2" background="images/fondo.jpg" border="1"><tbody id="tbDetalle"></tbody></table>
					
				</div>
</form>
</body>
</html>
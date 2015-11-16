<?php
require_once('xajax/xajax.inc.php'); //incluimos la librelia xajax

function eliminarFila($id_campo, $cant_campos){
	$respuesta = new xajaxResponse();
	$respuesta->addRemove("rowDetalle_$id_campo"); //borro el detalle que indica el parametro id_campo
	-- $cant_campos; //Resto uno al numero de campos y si es cero borro todo
	if($cant_campos == 0){
		$respuesta->addRemove("rowDetalle_0");
		$respuesta->addAssign("num_campos", "value", "0"); //dejo en cero la cantidad de campos para seguir agregando si asi lo desea el usuario
		$respuesta->addAssign("cant_campos", "value", "0");
	}
    $respuesta->addAssign("cant_campos", "value", $cant_campos);    
	return $respuesta;
}

function cancelar(){  //elimina todo el contenido de la tabla y vuelve a cero los contadores
    
    $respuesta = new xajaxResponse();

    //$respuesta->addRemove("tbDetalle"); //vuelve a crear la tabla vacia
    //$respuesta->addCreate("tblDetalle", "tbody", "tbDetalle");
    //$respuesta->addAssign("num_campos", "value", "0");
	$respuesta->addAssign("cant_campos", "value", "0");
    return $respuesta;
}

function agregarFila($formulario){
    $respuesta = new xajaxResponse();    
	extract($formulario);	
	$id_campos = $cant_campos = $num_campos+1;
	require_once('funciones.php');
	$Descripcion=_clean($Descripcion);
	$Id_Tipo=_clean($Id_Tipo);
	$Titular1=_clean($Titular1);
	$Suplente1=_clean($Suplente1);
	$Area=_clean($Area);
	$Titular2=_clean($Titular2);
	$Suplente2=_clean($Suplente2);
	
	$Descripcion=SanitizeString($Descripcion);
	$Id_Tipo=SanitizeString($Id_Tipo);
	$Titular1=SanitizeString($Titular1);
	$Suplente1=SanitizeString($Suplente1);
	$Area=SanitizeString($Area);
	$Titular2=SanitizeString($Titular2);
	$Suplente2=SanitizeString($Suplente2);
	$str_html_td1 = $Descripcion . '<input type="hidden" id="hdnDescripcion_' . $id_campos . '" name="hdnDescripcion_' . $id_campos . '" value="' . $Descripcion . '"/>' ;
    $str_html_td2 = "$Id_Tipo" . '<input type="hidden" id="hdnId_Tipo_' . $id_campos . '" name="hdnId_Tipo_' . $id_campos . '" value="' . $Id_Tipo . '"/>' ;
    $str_html_td3 = "$Titular1" . '<input type="hidden" id="hdnTitular1_' . $id_campos . '" name="hdnTitular1_' . $id_campos . '" value="' . $Titular1 . '"/>' ;
    $str_html_td4 = "$Suplente1" . '<input type="hidden" id="hdnSuplente1_' . $id_campos . '" name="hdnSuplente1_' . $id_campos . '" value="' . $Suplente1 . '"/>' ;
    $str_html_td5 = "$Area" . '<input type="hidden" id="hdnArea_' . $id_campos . '" name="hdnArea_' . $id_campos . '" value="' . $Area . '"/>' ;
	$str_html_td6 = "$Titular2" . '<input type="hidden" id="hdnTitular2_' . $id_campos . '" name="hdnTitular2_' . $id_campos . '" value="' . $Titular2 . '"/>' ;
	$str_html_td7 = "$Suplente2" . '<input type="hidden" id="hdnSuplente2_' . $id_campos . '" name="hdnSuplente2_' . $id_campos . '" value="' . $Suplente2 . '"/>' ;
    $str_html_td8 = '<img src="images/delete.png" width="16" height="16" alt="Eliminar" onclick="if(confirm(\'Realmente desea eliminar este detalle?\')){xajax_eliminarFila('. $id_campos .', proyecto.cant_campos.value);}"/>';
    $str_html_td8 .= '<input type="hidden" id="hdnIdCampos_'. $id_campos .'" name="hdnIdCampos[]" value="'. $id_campos .'" />';
	
	/*$str_html_td1 = "$Descripcion" ;
    $str_html_td2 = "$Id_Tipo";
    $str_html_td3 = "$Titular1";
    $str_html_td4 = "$Suplente1";
    $str_html_td5 = "$Area";
	$str_html_td6 = "$Titular2";
	$str_html_td7 = "$Suplente2";
	$str_html_td8 = '<img src="images/delete.png" width="16" height="16" alt="Eliminar" onclick="if(confirm(\'Realmente desea eliminar este detalle?\')){xajax_eliminarFila('. $id_campos .', proyecto.cant_campos.value);}"/>';*/

	if($num_campos == 0){ // creamos un encabezado de lo contrario solo agragamos la fila
		$respuesta->addCreate("tbDetalle", "tr", "rowDetalle_0");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_01");    //creamos los campos
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_02");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_03");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_04");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_05");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_06");
		$respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_07");
		$respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_08");

        $respuesta->addAssign("tdDetalle_01", "innerHTML", "SISTEMA");   //asignamos el contenido
        $respuesta->addAssign("tdDetalle_02", "innerHTML", "TIPO");
        $respuesta->addAssign("tdDetalle_03", "innerHTML", "U. S. TITULAR");
        $respuesta->addAssign("tdDetalle_04", "innerHTML", "U. S. SUPLENTE");
        $respuesta->addAssign("tdDetalle_05", "innerHTML", "DUE&#209;O AREA");
        $respuesta->addAssign("tdDetalle_06", "innerHTML", "DUE&#209;O TITULAR");
		$respuesta->addAssign("tdDetalle_07", "innerHTML", "DUE&#209;O SUPLENTE");
		$respuesta->addAssign("tdDetalle_08", "innerHTML", "Eliminar");
	}
    $idRow = "rowDetalle_$id_campos";
    $idTd = "tdDetalle_$id_campos";
	$respuesta->addCreate("tbDetalle", "tr", $idRow);
    $respuesta->addCreate($idRow, "td", $idTd."1");     //creamos los campos
    $respuesta->addCreate($idRow, "td", $idTd."2");
    $respuesta->addCreate($idRow, "td", $idTd."3");
    $respuesta->addCreate($idRow, "td", $idTd."4");
    $respuesta->addCreate($idRow, "td", $idTd."5");
    $respuesta->addCreate($idRow, "td", $idTd."6");
	$respuesta->addCreate($idRow, "td", $idTd."7");
	$respuesta->addCreate($idRow, "td", $idTd."8");
/*
 *     Esta parte podria estar dentro de algun ciclo iterativo  */
    
    $respuesta->addAssign($idTd."1", "innerHTML", $str_html_td1);   //asignamos el contenido
    $respuesta->addAssign($idTd."2", "innerHTML", $str_html_td2);
    $respuesta->addAssign($idTd."3", "innerHTML", $str_html_td3);
    $respuesta->addAssign($idTd."4", "innerHTML", $str_html_td4);
    $respuesta->addAssign($idTd."5", "innerHTML", $str_html_td5);
    $respuesta->addAssign($idTd."6", "innerHTML", $str_html_td6);
	$respuesta->addAssign($idTd."7", "innerHTML", $str_html_td7);
	$respuesta->addAssign($idTd."8", "innerHTML", $str_html_td8);

/*  aumentamos el contador de campos  */

	$respuesta->addAssign("num_campos","value", $id_campos);
	$respuesta->addAssign("cant_campos" ,"value", $id_campos);    
	return $respuesta;
}
function guardar($formulario){
	$flag = 0;
    extract($formulario);
    $respuesta = new xajaxResponse();
	include("conexion.php");
    foreach($hdnIdCampos as $id){  
	$sqlin = "INSERT INTO sistemas (Descripcion,Id_Tipo,Titular1,Suplente1,Area,Titular2,Suplente2)
                        VALUES('" . $formulario['hdnDescripcion_' . $id] . "', '" . $formulario['hdnId_Tipo_' . $id] . "', '" . $formulario['hdnTitular1_' . $id] . "',
                        '" . $formulario['hdnSuplente1_' . $id] . "', '". $formulario['hdnArea_' . $id] . "', '". $formulario['hdnTitular2_' . $id] . "', '". $formulario['hdnSuplente2_' . $id] . "')";   
		if(mysql_query($sqlin))
		{	$MSG = "Datos guardados con exito";	}
    }
	
	
    $MSG = "Datos guardados con exito";
    $respuesta->addAlert($MSG);
    return $respuesta;
}
$xajax=new xajax();         // Crea un nuevo objeto xajax
$xajax->setCharEncoding("iso-8859-1"); // le indica la codificación que debe utilizar
$xajax->decodeUTF8InputOn();          
$xajax->registerFunction("agregarFila"); 
$xajax->registerFunction("cancelar");
$xajax->registerFunction("eliminarFila");
$xajax->registerFunction("guardar");
$xajax->processRequests();
?>

<html>
<meta http-equiv="Pragma"content="no-cache">
<meta http-equiv="expires"content="0">
<head>
<?php $xajax->printJavascript("xajax"); require_once('top.php'); ?>
<!--<link href="CSS/style.css" rel="stylesheet" type="text/css">-->
</head>
<body>
<form name="proyecto" id="proyecto" action="" method="post">
    <input type="hidden" id="num_campos" name="num_campos" value="0" />
    <input type="hidden" id="cant_campos" name="cant_campos" value="0" />
<div id="cont" class="container">
	<div class="top">
	<table width="95%" border="1" align="center" background="images/fondo.jpg">
    <tr bgcolor="#006699"> 
            <th width="23%" rowspan="2" class="menu" background="images/main-button-tileR2.jpg">SISTEMA</th>
            <th width="19%" rowspan="2" class="menu" background="images/main-button-tileR2.jpg">TIPO</th>
            <th colspan="2" bgcolor="#006699" class="menu" background="images/main-button-tileR2.jpg">UNIDAD DE SISTEMA</th>
          </tr>
          <tr bgcolor="#006699"> 
            <th width="26%" class="menu" background="images/main-button-tileR2.jpg">TITULAR</th>
            <th width="32%" class="menu" background="images/main-button-tileR2.jpg">SUPLENTE</th>
          </tr>
          <tr> 
            <td><div align="center"> 
		  <input type="text" id="Descripcion" name="Descripcion" value="" class="textbox" />
        </div></td>
            <td><div align="center"> 
				<select id="Id_Tipo" name="Id_Tipo" class="textbox txtFec">
					<option value="APLICACION">APLICACION</option>
					<option value="OFIMATICA">OFIMATICA</option>
					<option value="SISTEMA OPERATIVO">SISTEMA OPERATIVO</option>
					<option value="BASE DE DATOS">BASE DE DATOS</option>
					<option value="UTILITARIO">UTILITARIO</option>
					<option value="LIBRO">LIBRO</option>
                </select>
              </div></td>
            <td><div align="center"> 
				<select name="Titular1" id="Titular1" class="textbox txtFec">
				<option></option>
                  <?php 
		  $sql = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
		  $result = mysql_query($sql);
		  while ($row = mysql_fetch_array($result)) 
		  {
			echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
		  }
		 ?>
                </select>
              </div></td>
            <td><div align="center"> 
                <select name="Suplente1" id="Suplente1" class="textbox txtFec">
				<option></option>
                  <?php 
		  $sql = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
		  $result = mysql_query($sql);
		  while ($row = mysql_fetch_array($result)) 
		  {
			echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
		  }
		?>
                </select>
              </div></td>
          </tr>
        </table>
		<table width="95%" border="1" align="center" background="images/fondo.jpg">
    <tr bgcolor="#006699"> 
            <td colspan="3" background="images/main-button-tileR2.jpg"> <div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">DUENO</font></strong></div></td>
          </tr>
          <tr bgcolor="#006699"> 
            <th width="25%" class="menu" background="images/main-button-tileR2.jpg">AREA</th>
            <th width="49%" class="menu" background="images/main-button-tileR2.jpg">TITULAR</th>
            <th width="26%" class="menu" background="images/main-button-tileR2.jpg">SUPLENTE</th>
          </tr>
          <tr> 
            <td><div align="center">
                <select name="Area" id="Area" class="textbox txtFec">
				<option></option>
                  <?php 
		  $sql = "SELECT * FROM datos_adicionales GROUP BY nombre_dadicional";
		  $result = mysql_query($sql);
		  while ($row = mysql_fetch_array($result)) 
		  {
			echo "<option value=\"$row[nombre_dadicional]\">$row[nombre_dadicional]</option>";
		  }
		  ?>
                </select>
              </div></td>
            <td><div align="center">
                <select name="Titular2" id="Titular2" class="textbox txtFec">
				<option></option>
                  <?php 
		  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear=0 ORDER BY apa_usr ASC";
		  $result = mysql_query($sql);
		  while ($row = mysql_fetch_array($result)) 
		  {
			echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
		  }
		  ?>
                </select>
              </div></td>
            <td><div align="center"> 
                <select name="Suplente2" name="Suplente2" class="textbox txtFec">
				<option></option>
                  <?php 
		  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear=0 ORDER BY apa_usr ASC";
		  $result = mysql_query($sql);
		  while ($row = mysql_fetch_array($result)) 
		  {
			echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
		  }
		?>
                </select>
              </div></td>
          </tr>
       </table>
	</div>
	</br>
<div class="button_div">    
    <input type="reset" id="btnCancel" name="btnCancel" value="LIMPIAR DATOS" class="buttons_CANCEL" onclick="xajax_cancelar();" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" id="btnAgregar" name="btnAgregar" value="INSERTAR" class="buttons_aplicar" onclick="xajax_agregarFila(xajax.getFormValues('proyecto'));" />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="button" id="btnAgregar" name="btnAgregar" value="GUARDAR TODO" class="buttons_OK" onclick="xajax_guardar(xajax.getFormValues('proyecto'));" />
	</div>
    <div class="clear"></div>
    <div id="form3" class="form-horiz">
        <table width="100%" id="tblDetalle" class="listado"><tbody id="tbDetalle"></tbody></table>
    </div>
</div>
</form>
</body>
</html>
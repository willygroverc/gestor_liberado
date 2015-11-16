<?php
include('top.php');
require ("conexion.php");
@session_start();
$_SESSION['modulo']='gravamen';
?>
<html>
</head>
	<link href="css/validation.css" rel="stylesheet" type="text/css">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<script language="javascript" src="js/ajax.js"></script>
	<script language="javascript" src="js/gravamen.js"></script>
	<script language="javascript" src="js/validate.js"></script>
	<script language="javascript" src="js/jquery.js"></script>
	<script language="javascript">
		var siguienteCampo = "observaciones";  
		var nombreForm = "frm_gra" ;
		document.onkeydown = TelcaPulsada;          //asigna el evento pulsacion tecla a la funcion  
		function TelcaPulsada( e ) {  
		   if ( window.event != null)               //IE4+  
			  tecla = window.event.keyCode;  
		   else if ( e != null )                //N4+ o W3C compatibles  
			  tecla = e.which;  
		   else  
			  return;  
		   if (tecla == 13) {                   //se pulso enter  
			  if ( siguienteCampo == 'fin' ) {          //fin de la secuencia, hace el submit  
						guardar_gravamen();
						return false ;                 //sustituir por return true para hacer el submit  
			  } else {                      //da el foco al siguiente campo  
				 eval('document.' + nombreForm + '.' + siguienteCampo + '.focus()');
				 return false ; 
			  }  
		   }  
		}  
  
		if (document.captureEvents)             //netscape es especial: requiere activar la captura del evento  
			document.captureEvents(Event.KEYDOWN) ; 
	</script>
</head>
<body onload="document.getElementById('observaciones').focus();">
<?php
echo '<form name="frm_gra" id="frm_gra" method="POST" action="#">
	<table align="center" width="60%" border="1" background="images/fondo.jpg">
	<tr>
	<td align="center">
		<fieldset width="60%">
		<legend>Registro de accion a gravamen</legend>
		<input type="hidden" name="id_acciones" id="id_acciones" value="'.$num.'">
		<input type="hidden" name="aux" id="aux" value="'.$aux.'">';
	$sql="SELECT grav FROM gravamenes WHERE id_acciones='$num' ORDER BY fecha DESC";
	$resultado = mysql_query($sql);
	$fila_veri = mysql_fetch_array($resultado);
	//print_r ($fila_veri);
	//$var = $fila_veri[id];
	//echo $var;
	if($fila_veri[grav]==1)	{
		echo '<input type="radio" name="gravamen" id="gravamen1" value="1" checked>';
		echo 'En gravamen&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <input type="radio" name="gravamen" id="gravamen2" value="0"> No gravamen';
	} else {
		echo '<input type="radio" name="gravamen" id="gravamen1" value="1" >';
		echo 'En gravamen&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <input type="radio" name="gravamen" id="gravamen2" value="0" checked> No gravamen';
	}
	echo '</br></br>
		<p><b>OBSERVACIONES</b></p>
			<textarea name="observaciones" cols="80" rows="4" id="observaciones"> </textarea>
		</br></br>
		<input type="button" name="submit" id="submit" value="GUARDAR CAMBIOS" onclick="guardar_gravamen();" >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="submit" id="submit" value="RETORNAR" onclick="retornar(1);" >
		</fieldset>
		</br></br>
	</td>
	</tr>
</tabla>
<table align="center" >
<tr>
	<td>
		<div id="lbl_ajax" align="center">
			<div style="display: none;" class="success_box" id="success_box"></div>
			<div style="display: block;" class="error_box" id="error_box">Los campos con marcados con (*) son obligatorios</div>
		</div>
	</td>
</tr>
</tabla>

</form>';
include("top_.php");
?>
</body>
</html>
<html>
<head>
	<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen">
	<script language="javascript" src="../js/validate.js"></script>
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/login.js"></script>
	<script type="text/javascript" src="../js/ajax.js"></script>
	<script type="text/javascript" src="../js/jquery.realperson.js"></script>
	<style>
			.error_box {
			background:#FAD3C4;
			border:1px solid #A75B4E;
			border-radius:5px;
			-webkit-border-radius:5px;
			-moz-border-radius:5px;
			color:#444444;
			display:none;
			font-size:13px;
			margin:0px 0px 15px 0px;
			padding:8px 8px;
			width:472px;
		}

		.success_box {
			background:#E2F1BB;
			border:1px solid #598800;
			border-radius:5px;
			-webkit-border-radius:5px;
			-moz-border-radius:5px;
			color:#000000;
			display:none;
			font-size:13px;
			margin:0px 0px 15px 0px;
			padding:8px 8px;
			width:472px;
		}

	</style>
	<style type="text/css">
		@import "../css/jquery.realperson.css";
		label { display: inline-block; width: 20%; }
		.realperson-challenge { display: inline-block }
	</style>
	<script type="text/javascript">
		$(function() {
		$('#defaultReal').realperson();
		});
	</script>
	<script>
		var siguienteCampo = "email_alter";  
		var nombreForm = "frm_rec_pass" ;
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
				 recuperar_pass_envio();         
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
<body onload="document.getElementById('email_alter').focus();">
	<form id="frm_rec_pass" name="frm_rec_pass" onSubmit="return false" method="post">
	<br><br><br>
	<table id="box-table-b" align="center" border="1" class="tbl1">
		<tr><th colspan="2" align="center">Ingrese Correo Electronico:</th></tr>
		<tr>
			<td colspan="2" align="center"><input type="text" size="40" id="email_alter" name="email_alter" onFocus="siguienteCampo ='defaultReal';"></input></td>
		</tr>
		<tr>
			<th colspan="2" align="center">Ingrese el codigo:</th>
		</tr>

		<tr>		
			<td colspan="2" align="center">
				<br><input type="text" id="defaultReal" name="defaultReal"  onFocus="siguienteCampo ='fin';">
			</td>
		</tr>
		
		<tr>
			<th align="center" colspan="2"><input type="button" value="ENVIAR" onclick="recuperar_pass_envio();"></input></th>
		</tr>
	</table>
	<table align="center">
		<tr>
			<td><br>
				<div align="center" valign="center" id="div_ajax">
					<div style="display: none;" class="success_box"></div>
					<div style="display: block;" class="error_box" id="error_box">A continuaci&oacute;n ingrese el correo alternativo ingresado en su cuenta de usuario..</div>
				</div>
			</td>
		</tr>
	</table>
	</form>
	<br>
	</body>
</html>
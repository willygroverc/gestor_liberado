<?php
// Version: 	1.0
// Objetivo: 	Actualizar funciones ambiguas php NO recomendadas para version 5.3 o posterior
//				Implementacion de Mejora en asistente de busqueda de ordenes de trabajo.
// Autor:		Cesar Cuenca
// Fecha:		16/NOV/12, 14/ENE/2013
//_____________________________________________________________________________________________
// Version: 	2.0
// Objetivo: 	Corregir el origen de las ordenes en el caso que estas sean anidadas
// Autor:		Alvaro ROdriguez
// Fecha:		16/AGO/13
//_____________________________________________________________________________________________

include ("top.php");
include("funciones.inc.php");
include("conexion.php");	
@session_start();
$_SESSION['modulo']='lista';
?>
<p>

<script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {

	// load messages every 1000 milliseconds from server.
	load_data = {'fetch':1};
	
	//method to trigger when user hits enter key
	$("#shout_message").keypress(function(evt) {
		if(evt.which == 13) {
				var iusername = $('#shout_username').val();
				var imessage = $('#shout_message').val();
				post_data = {'username':iusername, 'message':imessage};
			 	
				//send data to "shout.php" using jQuery $.post()
				$.post('shout.php', post_data, function(data) {
					
					//append data into messagebox with jQuery fade effect!
					$(data).hide().appendTo('.message_box').fadeIn();
	
					//keep scrolled to bottom of chat!
					var scrolltoh = $('.message_box')[0].scrollHeight;
					$('.message_box').scrollTop(scrolltoh);
					
					//reset value of message box
					$('#shout_message').val('');
					
				}).fail(function(err) { 
				
				//alert HTTP server error
				alert(err.statusText); 
				});
			}
	});
	
	//toggle hide/show shout box
	$(".close_btn").click(function (e) {
		//get CSS display state of .toggle_chat element
		var toggleState = $('.toggle_chat').css('display');
		
		//toggle show/hide chat box
		$('.toggle_chat').slideToggle();
		
		//use toggleState var to change close/open icon image
		if(toggleState == 'block')
		{
			$(".header div").attr('class', 'open_btn');
		}else{
			$(".header div").attr('class', 'close_btn');
		}
		 
		 
	});
});

</script>
<script language="javascript" src="js/ordenes.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/ajax.js"></script>
<table border="1" align="center" bgcolor="#006699">
    <tr> 
		<td align="center" colspan="8">
			<input type="hidden" id="txt_tipo_usr" name="txt_tipo_usr" value="<?php echo $_SESSION['tipo']?>"></input>
			<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Asistente de B&uacute;squeda</strong></font> 
		<td>
	</tr>
	<tr>
	<?php 
		if ($_SESSION['tipo']=='S'){
			echo '<td><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Agencia :</strong></font></td>';
			echo '<td>';
			include('lib/cmb_agencia.php');
			echo '</td>';
		}
		if ($_SESSION['tipo']=='A'){
			echo '<td><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Area :</strong></font></td>';
			echo '<td>';
			echo '<select id="area_usr" name="area_usr" onchange="document.getElementById(\'pg\').value=1;filtrar_lista();">
			<option value="0">SELECCIONE</option>';
				$sql="SELECT id_dadicional, nombre_dadicional FROM datos_adicionales WHERE tipo_dadicional='area' AND estado='0'";
				$recordset=mysql_query($sql);
				for ($i=1;$i<=mysql_num_rows($recordset);$i++){
					$fila=mysql_fetch_array($recordset);
					echo '<option value="'.$fila['id_dadicional'].'">'.$fila['nombre_dadicional'].'</option>';
				}
			echo '</select>';
			echo '</td>';
		}
		?>
		<td><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Tipo :</strong></font> </td>
			<?php 
			echo '<td align="center">';
			if ($_SESSION['tipo']=='T' || $_SESSION['tipo']=='C')
				echo	'<select name="cmb_filtro" id="cmb_filtro" onchange="document.getElementById(\'pg\').value=1;filtrar_lista();">
						<option value="0">Enviado por</option>
						<option value="1">Asignado a</option>
						<option value="2">No Asignado a</option>
						<option value="3">Solucionado por</option>
						<option value="4">No Solucionado por</option>
						<option value="5">Conformidad de</option>
						<option value="6">Sin Conformidad de</option>
						</select>';
			if ($_SESSION['tipo']=='S' || $_SESSION['tipo']=='A')
				echo	'<select name="cmb_filtro" id="cmb_filtro" onchange="document.getElementById(\'pg\').value=1;filtrar_lista();">
						<option value="0">Sin filtro</option>
						<option value="1">Asignados</option>
						<option value="2">No Asignados</option>
						<option value="3">Solucionados</option>
						<option value="4">No Solucionados</option>
						<option value="5">Con Conformidad</option>
						<option value="6">Sin Conformidad</option>
					</select>';
		echo '</td>';	
		if ($_SESSION['tipo']=='A'){
			echo '<td><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Enviado Por:</strong></font></td>';
			echo '<td><div id="ajax_env" name="ajax_env"></div></td>';
		}
		if ($_SESSION['tipo']=='T' || $_SESSION['tipo']=='C'){
			echo '<td><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Usuario:</strong></font> </td>';
			echo '<td>';
			include('lib/cmb_usuarios.php');
			echo '</td>';
		}
		?>
		<td><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Con las palabras :</strong></font> </td>
		<td>
			<input name="txt_busqueda" id="txt_busqueda" type="text" size="25" maxlength="25" value="" onkeyup="filtrar_lista();"></input>
		</td>
		 <td>
			<input name="pg" id="pg" type="hidden" size="5" value="1"></input>
			
		 </td>
	</tr>
       
  </table><br><br>
<div id="tbl_ajax">


</div>
<br>
<?php 
	if ($_SESSION['tipo']=='A')
		echo '<script>filtrar_usuario_lista();</script>';
	else
		echo '<script>filtrar_lista();</script>';
?>

<script language="JavaScript">
function openStat_2() {	
	window.open("orden_estadistica.php",'Estadìsticas', 'width=610,height=200,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
function openStat_3() {	
	window.open("orden_estadistica2a.php",'Estadìsticas', 'width=610,height=300,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
function openStat_4() {	
window.open("report_pre_temp.php",'pre_tiempos', 'width=610,height=200,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
</script>
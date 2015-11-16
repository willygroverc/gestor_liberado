<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}

 include("top.php");?>
<?php
	if(isset($_REQUEST['cambiar']))
	{	
		if($_REQUEST['color'] == 0)
		{ 	$act = "update fondo set fndActive = 0";
		    mysql_query($act);
			$sl = "update fondo set fndValor = 'Ninguno', fndActive = 1 where fndCampo = 0";
			echo '<script languaje="Javascript">location.href="menu_config.php"</script>';
		}
		if($_REQUEST['color'] == 1)
		{ 	 
			 $act = "update fondo set fndActive = 0";
                        mysql_query($act);
                        $extension = explode(".",$background_name); 
			 $num = count($extension)-1; 
			 if($extension[$num]=="gif" OR $extension[$num]=="jpg")
			 {  
				$sl = "update fondo set fndActive = 1 where fndCampo = 1";
				$arch_nomb="background.jpg";
				copy($background,"images/".$arch_nomb);
				$msg="SU IMAGEN FUE ENVIADA CORRECTAMENTE, PARA PODER VISUALIZAR LA NUEVA IMAGEN, RECARGUE LA P�GINA O PRESIONE F5";
				/*echo '<script languaje="Javascript">location.href="menu_config.php"</script>';	 */
			 }
			 else { $msg="LA IMAGEN SOLO DEBE SER DE EXTENSION .gif o .jpg";
			     	$sl = "update fondo set fndActive = 1 where fndCampo = 1";
				  }
			 //
		}
		else if($_REQUEST['color'] == 2)
		{ 	$act = "update fondo set fndActive = 0";
		    mysql_query($act);
			$sl = "update fondo set fndValor = '$_REQUEST[bgcolor]', fndActive = 1 where fndCampo = 2";
                        print_r($sl);exit;
                        mysql_query($sl);
			echo '<script languaje="Javascript">location.href="menu_config.php"</script>';
		}
	}
	if (isset($sl))
		mysql_query($sl);
?>
<!--------------------------------------->

<table border=1 background="images/fondo.jpg">
<tr bgcolor="#006699">
	<td background="images/main-button-tileR1.jpg" height="22"><div align="center"><FONT face="Arial, Helvetica, sans-serif" color=#ffffff size=3><STRONG>VALORES PARA EL FONDO DE LA P�GINA</STRONG></FONT></font></div>
	</td>
</tr>
<tr><td align="center">
<form action="" method="post" name="frmAdd" enctype="multipart/form-data">
		<select name="color" onChange="mostrar()">
			<option value="0" selected>Ninguno</option>
			<option value="1" >Background</option>
			<option value="2" >Bgcolor</option>
		</select>
		<input name="bgcolor" type="text" id="bgcolor" style="display:none " maxlength="6" size="6">
		<input name="background" type="file" id="background" style="display:none " value="<?php echo @$background ?>">
		<br><br><br>
		<!--------------------Paleta de colores---------------------------------------->
		<center>
					<table border=1 id="paleta" style="display:none ">
					<tr>
							 <td bgcolor="#000000"><a href="JavaScript:l()"
					onMouseOver="r('#000000'); return true;"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#000033"><a href="JavaScript:l()"
					onMouseOver="r('#000033'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#000066"><a href="JavaScript:l()"
					onMouseOver="r('#000066'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#000099"><a href="JavaScript:l()"
					onMouseOver="r('#000099'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#0000cc"><a href="JavaScript:l()"
					onMouseOver="r('#0000cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#0000ff"><a href="JavaScript:l()"
					onMouseOver="r('#0000ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#006600"><a href="JavaScript:l()"
					onMouseOver="r('#006600'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#006633"><a href="JavaScript:l()"
					onMouseOver="r('#006633'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#006666"><a href="JavaScript:l()"
					onMouseOver="r('#006666'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#006699"><a href="JavaScript:l()"
					onMouseOver="r('#006699'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#0066cc"><a href="JavaScript:l()"
					onMouseOver="r('#0066cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#0066ff"><a href="JavaScript:l()"
					onMouseOver="r('#0066ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#00cc00"><a href="JavaScript:l()"
					onMouseOver="r('#00cc00'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#00cc33"><a href="JavaScript:l()"
					onMouseOver="r('#00cc33'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#00cc66"><a href="JavaScript:l()"
					onMouseOver="r('#00cc66'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#00cc99"><a href="JavaScript:l()"
					onMouseOver="r('#00cc99'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#00cccc"><a href="JavaScript:l()"
					onMouseOver="r('#00cccc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#00ccff"><a href="JavaScript:l()"
					onMouseOver="r('#00ccff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
					</tr>
					<tr>
							<td bgcolor="#003300"><a href="JavaScript:l()"
					onMouseOver="r('#003300'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#003333"><a href="JavaScript:l()"
					onMouseOver="r('#003333'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#003366"><a href="JavaScript:l()"
					onMouseOver="r('#003366'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#003399"><a href="JavaScript:l()"
					onMouseOver="r('#003399'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#0033cc"><a href="JavaScript:l()"
					onMouseOver="r('#0033cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#0033ff"><a href="JavaScript:l()"
					onMouseOver="r('#0033ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#009900"><a href="JavaScript:l()"
					onMouseOver="r('#009900'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#009933"><a href="JavaScript:l()"
					onMouseOver="r('#009933'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#009966"><a href="JavaScript:l()"
					onMouseOver="r('#009966'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#009999"><a href="JavaScript:l()"
					onMouseOver="r('#009999'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#0099cc"><a href="JavaScript:l()"
					onMouseOver="r('#0099cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#0099ff"><a href="JavaScript:l()"
					onMouseOver="r('#0099ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#00ff00"><a href="JavaScript:l()"
					onMouseOver="r('#00ff00'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#00ff33"><a href="JavaScript:l()"
					onMouseOver="r('#00ff33'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#00ff66"><a href="JavaScript:l()"
					onMouseOver="r('#00ff66'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#00ff99"><a href="JavaScript:l()"
					onMouseOver="r('#00ff99'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#00ffcc"><a href="JavaScript:l()"
					onMouseOver="r('#00ffcc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#00ffff"><a href="JavaScript:l()"
					onMouseOver="r('#00ffff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
					</tr>
					<tr>
							<td bgcolor="#330000"><a href="JavaScript:l()"
					onMouseOver="r('#330000'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#330033"><a href="JavaScript:l()"
					onMouseOver="r('#330033'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#330066"><a href="JavaScript:l()"
					onMouseOver="r('#330066'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#330099"><a href="JavaScript:l()"
					onMouseOver="r('#330099'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#3300cc"><a href="JavaScript:l()"
					onMouseOver="r('#3300cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#3300ff"><a href="JavaScript:l()"
					onMouseOver="r('#3300ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#336600"><a href="JavaScript:l()"
					onMouseOver="r('#336600'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#336633"><a href="JavaScript:l()"
					onMouseOver="r('#336633'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#336666"><a href="JavaScript:l()"
					onMouseOver="r('#336666'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#336699"><a href="JavaScript:l()"
					onMouseOver="r('#336699'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#3366cc"><a href="JavaScript:l()"
					onMouseOver="r('#3366cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#3366ff"><a href="JavaScript:l()"
					onMouseOver="r('#3366ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#33cc00"><a href="JavaScript:l()"
					onMouseOver="r('#33cc00'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#33cc33"><a href="JavaScript:l()"
					onMouseOver="r('#33cc33'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#33cc66"><a href="JavaScript:l()"
					onMouseOver="r('#33cc66'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#33cc99"><a href="JavaScript:l()"
					onMouseOver="r('#33cc99'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#33cccc"><a href="JavaScript:l()"
					onMouseOver="r('#33cccc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#33ccff"><a href="JavaScript:l()"
					onMouseOver="r('#33ccff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
					</tr>
					<tr>
							<td bgcolor="#333300"><a href="JavaScript:l()"
					onMouseOver="r('#333300'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#333333"><a href="JavaScript:l()"
					onMouseOver="r('#333333'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#333366"><a href="JavaScript:l()"
					onMouseOver="r('#333366'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#333399"><a href="JavaScript:l()"
					onMouseOver="r('#333399'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#3333cc"><a href="JavaScript:l()"
					onMouseOver="r('#3333cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#3333ff"><a href="JavaScript:l()"
					onMouseOver="r('#3333ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#339900"><a href="JavaScript:l()"
					onMouseOver="r('#339900'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#339933"><a href="JavaScript:l()"
					onMouseOver="r('#339933'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#339966"><a href="JavaScript:l()"
					onMouseOver="r('#339966'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#339999"><a href="JavaScript:l()"
					onMouseOver="r('#339999'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#3399cc"><a href="JavaScript:l()"
					onMouseOver="r('#3399cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#3399ff"><a href="JavaScript:l()"
					onMouseOver="r('#3399ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#33ff00"><a href="JavaScript:l()"
					onMouseOver="r('#33ff00'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#33ff33"><a href="JavaScript:l()"
					onMouseOver="r('#33ff33'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#33ff66"><a href="JavaScript:l()"
					onMouseOver="r('#33ff66'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#33ff99"><a href="JavaScript:l()"
					onMouseOver="r('#33ff99'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#33ffcc"><a href="JavaScript:l()"
					onMouseOver="r('#33ffcc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#33ffff"><a href="JavaScript:l()"
					onMouseOver="r('#33ffff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
					</tr>
					<tr>
							<td bgcolor="#660000"><a href="JavaScript:l()"
					onMouseOver="r('#660000'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#660033"><a href="JavaScript:l()"
					onMouseOver="r('#660033'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#660066"><a href="JavaScript:l()"
					onMouseOver="r('#660066'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#660099"><a href="JavaScript:l()"
					onMouseOver="r('#660099'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#6600cc"><a href="JavaScript:l()"
					onMouseOver="r('#6600cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#6600ff"><a href="JavaScript:l()"
					onMouseOver="r('#6600ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#666600"><a href="JavaScript:l()"
					onMouseOver="r('#666600'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#666633"><a href="JavaScript:l()"
					onMouseOver="r('#666633'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#666666"><a href="JavaScript:l()"
					onMouseOver="r('#666666'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#666699"><a href="JavaScript:l()"
					onMouseOver="r('#666699'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#6666cc"><a href="JavaScript:l()"
					onMouseOver="r('#6666cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#6666ff"><a href="JavaScript:l()"
					onMouseOver="r('#6666ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#66cc00"><a href="JavaScript:l()"
					onMouseOver="r('#66cc00'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#66cc33"><a href="JavaScript:l()"
					onMouseOver="r('#66cc33'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#66cc66"><a href="JavaScript:l()"
					onMouseOver="r('#66cc66'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#66cc99"><a href="JavaScript:l()"
					onMouseOver="r('#66cc99'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#66cccc"><a href="JavaScript:l()"
					onMouseOver="r('#66cccc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#66ccff"><a href="JavaScript:l()"
					onMouseOver="r('#66ccff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
					</tr>
					<tr>
							<td bgcolor="#663300"><a href="JavaScript:l()"
					onMouseOver="r('#663300'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#663333"><a href="JavaScript:l()"
					onMouseOver="r('#663333'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#663366"><a href="JavaScript:l()"
					onMouseOver="r('#663366'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#663399"><a href="JavaScript:l()"
					onMouseOver="r('#663399'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#6633cc"><a href="JavaScript:l()"
					onMouseOver="r('#6633cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#6633ff"><a href="JavaScript:l()"
					onMouseOver="r('#6633ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#669900"><a href="JavaScript:l()"
					onMouseOver="r('#669900'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#669933"><a href="JavaScript:l()"
					onMouseOver="r('#669933'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#669966"><a href="JavaScript:l()"
					onMouseOver="r('#669966'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#669999"><a href="JavaScript:l()"
					onMouseOver="r('#669999'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#6699cc"><a href="JavaScript:l()"
					onMouseOver="r('#6699cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#6699ff"><a href="JavaScript:l()"
					onMouseOver="r('#6699ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#66ff00"><a href="JavaScript:l()"
					onMouseOver="r('#66ff00'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#66ff33"><a href="JavaScript:l()"
					onMouseOver="r('#66ff33'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#66ff66"><a href="JavaScript:l()"
					onMouseOver="r('#66ff66'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#66ff99"><a href="JavaScript:l()"
					onMouseOver="r('#66ff99'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#66ffcc"><a href="JavaScript:l()"
					onMouseOver="r('#66ffcc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#66ffff"><a href="JavaScript:l()"
					onMouseOver="r('#66ffff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
					
					</tr>
					<tr>
							<td bgcolor="#990000"><a href="JavaScript:l()"
					onMouseOver="r('#990000'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#990033"><a href="JavaScript:l()"
					onMouseOver="r('#990033'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#990066"><a href="JavaScript:l()"
					onMouseOver="r('#990066'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#990099"><a href="JavaScript:l()"
					onMouseOver="r('#990099'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#9900cc"><a href="JavaScript:l()"
					onMouseOver="r('#9900cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#9900ff"><a href="JavaScript:l()"
					onMouseOver="r('#9900ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#996600"><a href="JavaScript:l()"
					onMouseOver="r('#996600'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#996633"><a href="JavaScript:l()"
					onMouseOver="r('#996633'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#996666"><a href="JavaScript:l()"
					onMouseOver="r('#996666'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#996699"><a href="JavaScript:l()"
					onMouseOver="r('#996699'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#9966cc"><a href="JavaScript:l()"
					onMouseOver="r('#9966cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#9966ff"><a href="JavaScript:l()"
					onMouseOver="r('#9966ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#99cc00"><a href="JavaScript:l()"
					onMouseOver="r('#99cc00'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#99cc33"><a href="JavaScript:l()"
					onMouseOver="r('#99cc33'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#99cc66"><a href="JavaScript:l()"
					onMouseOver="r('#99cc66'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#99cc99"><a href="JavaScript:l()"
					onMouseOver="r('#99cc99'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#99cccc"><a href="JavaScript:l()"
					onMouseOver="r('#99cccc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#99ccff"><a href="JavaScript:l()"
					onMouseOver="r('#99ccff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
					
					</tr>
					<tr>
							<td bgcolor="#993300"><a href="JavaScript:l()"
					onMouseOver="r('#993300'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#993333"><a href="JavaScript:l()"
					onMouseOver="r('#993333'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#993366"><a href="JavaScript:l()"
					onMouseOver="r('#993366'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#993399"><a href="JavaScript:l()"
					onMouseOver="r('#993399'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#9933cc"><a href="JavaScript:l()"
					onMouseOver="r('#9933cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#9933ff"><a href="JavaScript:l()"
					onMouseOver="r('#9933ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#999900"><a href="JavaScript:l()"
					onMouseOver="r('#999900'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#999933"><a href="JavaScript:l()"
					onMouseOver="r('#999933'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#999966"><a href="JavaScript:l()"
					onMouseOver="r('#999966'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#999999"><a href="JavaScript:l()"
					onMouseOver="r('#999999'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#9999cc"><a href="JavaScript:l()"
					onMouseOver="r('#9999cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#9999ff"><a href="JavaScript:l()"
					onMouseOver="r('#9999ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#99ff00"><a href="JavaScript:l()"
					onMouseOver="r('#99ff00'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#99ff33"><a href="JavaScript:l()"
					onMouseOver="r('#99ff33'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#99ff66"><a href="JavaScript:l()"
					onMouseOver="r('#99ff66'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#99ff99"><a href="JavaScript:l()"
					onMouseOver="r('#99ff99'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#99ffcc"><a href="JavaScript:l()"
					onMouseOver="r('#99ffcc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#99ffff"><a href="JavaScript:l()"
					onMouseOver="r('#99ffff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
					
					</tr>
					<tr>
							<td bgcolor="#cc0000"><a href="JavaScript:l()"
					onMouseOver="r('#cc0000'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cc0033"><a href="JavaScript:l()"
					onMouseOver="r('#cc0033'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cc0066"><a href="JavaScript:l()"
					onMouseOver="r('#cc0066'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cc0099"><a href="JavaScript:l()"
					onMouseOver="r('#cc0099'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cc00cc"><a href="JavaScript:l()"
					onMouseOver="r('#cc00cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cc00ff"><a href="JavaScript:l()"
					onMouseOver="r('#cc00ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cc6600"><a href="JavaScript:l()"
					onMouseOver="r('#cc6600'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cc6633"><a href="JavaScript:l()"
					onMouseOver="r('#cc6633'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cc6666"><a href="JavaScript:l()"
					onMouseOver="r('#cc6666'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cc6699"><a href="JavaScript:l()"
					onMouseOver="r('#cc6699'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cc66cc"><a href="JavaScript:l()"
					onMouseOver="r('#cc66cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cc66ff"><a href="JavaScript:l()"
					onMouseOver="r('#cc66ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cccc00"><a href="JavaScript:l()"
					onMouseOver="r('#cccc00'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cccc33"><a href="JavaScript:l()"
					onMouseOver="r('#cccc33'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cccc66"><a href="JavaScript:l()"
					onMouseOver="r('#cccc66'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cccc99"><a href="JavaScript:l()"
					onMouseOver="r('#cccc99'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cccccc"><a href="JavaScript:l()"
					onMouseOver="r('#cccccc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ccccff"><a href="JavaScript:l()"
					onMouseOver="r('#ccccff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
					
					</tr>
					<tr>
							<td bgcolor="#cc3300"><a href="JavaScript:l()"
					onMouseOver="r('#cc3300'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cc3333"><a href="JavaScript:l()"
					onMouseOver="r('#cc3333'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cc3366"><a href="JavaScript:l()"
					onMouseOver="r('#cc3366'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cc3399"><a href="JavaScript:l()"
					onMouseOver="r('#cc3399'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cc33cc"><a href="JavaScript:l()"
					onMouseOver="r('#cc33cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cc33ff"><a href="JavaScript:l()"
					onMouseOver="r('#cc33ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cc9900"><a href="JavaScript:l()"
					onMouseOver="r('#cc9900'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cc9933"><a href="JavaScript:l()"
					onMouseOver="r('#cc9933'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cc9966"><a href="JavaScript:l()"
					onMouseOver="r('#cc9966'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cc9999"><a href="JavaScript:l()"
					onMouseOver="r('#cc9999'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cc99cc"><a href="JavaScript:l()"
					onMouseOver="r('#cc99cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#cc99ff"><a href="JavaScript:l()"
					onMouseOver="r('#cc99ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ccff00"><a href="JavaScript:l()"
					onMouseOver="r('#ccff00'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ccff33"><a href="JavaScript:l()"
					onMouseOver="r('#ccff33'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ccff66"><a href="JavaScript:l()"
					onMouseOver="r('#ccff66'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ccff99"><a href="JavaScript:l()"
					onMouseOver="r('#ccff99'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ccffcc"><a href="JavaScript:l()"
					onMouseOver="r('#ccffcc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ccffff"><a href="JavaScript:l()"
					onMouseOver="r('#ccffff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
					
					</tr>
					
					
					<tr>
							<td bgcolor="#ff0000"><a href="JavaScript:l()"
					onMouseOver="r('#ff0000'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ff0033"><a href="JavaScript:l()"
					onMouseOver="r('#ff0033'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ff0066"><a href="JavaScript:l()"
					onMouseOver="r('#ff0066'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ff0099"><a href="JavaScript:l()"
					onMouseOver="r('#ff0099'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ff00cc"><a href="JavaScript:l()"
					onMouseOver="r('#ff00cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ff00ff"><a href="JavaScript:l()"
					onMouseOver="r('#ff00ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ff6600"><a href="JavaScript:l()"
					onMouseOver="r('#ff6600'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ff6633"><a href="JavaScript:l()"
					onMouseOver="r('#ff6633'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ff6666"><a href="JavaScript:l()"
					onMouseOver="r('#ff6666'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ff6699"><a href="JavaScript:l()"
					onMouseOver="r('#ff6699'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ff66cc"><a href="JavaScript:l()"
					onMouseOver="r('#ff66cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ff66ff"><a href="JavaScript:l()"
					onMouseOver="r('#ff66ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ffcc00"><a href="JavaScript:l()"
					onMouseOver="r('#ffcc00'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ffcc33"><a href="JavaScript:l()"
					onMouseOver="r('#ffcc33'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ffcc66"><a href="JavaScript:l()"
					onMouseOver="r('#ffcc66'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ffcc99"><a href="JavaScript:l()"
					onMouseOver="r('#ffcc99'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ffcccc"><a href="JavaScript:l()"
					onMouseOver="r('#ffcccc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ffccff"><a href="JavaScript:l()"
					onMouseOver="r('#ffccff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
					
					</tr>
					<tr>
							<td bgcolor="#ff3300"><a href="JavaScript:l()"
					onMouseOver="r('#ff3300'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ff3333"><a href="JavaScript:l()"
					onMouseOver="r('#ff3333'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ff3366"><a href="JavaScript:l()"
					onMouseOver="r('#ff3366'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ff3399"><a href="JavaScript:l()"
					onMouseOver="r('#ff3399'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ff33cc"><a href="JavaScript:l()"
					onMouseOver="r('#ff33cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ff33ff"><a href="JavaScript:l()"
					onMouseOver="r('#ff33ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ff9900"><a href="JavaScript:l()"
					onMouseOver="r('#ff9900'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ff9933"><a href="JavaScript:l()"
					onMouseOver="r('#ff9933'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ff9966"><a href="JavaScript:l()"
					onMouseOver="r('#ff9966'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ff9999"><a href="JavaScript:l()"
					onMouseOver="r('#ff9999'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ff99cc"><a href="JavaScript:l()"
					onMouseOver="r('#ff99cc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ff99ff"><a href="JavaScript:l()"
					onMouseOver="r('#ff99ff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ffff00"><a href="JavaScript:l()"
					onMouseOver="r('#ffff00'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ffff33"><a href="JavaScript:l()"
					onMouseOver="r('#ffff33'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ffff66"><a href="JavaScript:l()"
					onMouseOver="r('#ffff66'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ffff99"><a href="JavaScript:l()"
					onMouseOver="r('#ffff99'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ffffcc"><a href="JavaScript:l()"
					onMouseOver="r('#ffffcc'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
							<td bgcolor="#ffffff"><a href="JavaScript:l()"
					onMouseOver="r('#ffffff'); return true"><img src="file:///C|/Apache/htdocs/prueba/w.gif" height=10
					width=10 border=0></a></td>
					</tr>
					</table>

	<!--------------------Fin Paleta----------------------------------------------->
	
		<br><br><br>
	<input name="cambiar" type="submit" value="APLICAR CAMBIOS" id="boton">
	<br><br><input type="button" value="RETORNAR" onClick="window.location.href='menu_parametros.php'" >
	</table>
</form>
</td></tr>
</table>
<script language="JavaScript">
		<!-- 
		<?php 
		if (isset($msg)) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
</script>
<?php 
if (isset($retornar)){header("location: admi_fuentes.php?Naveg=Cambios >> Administracion de Fuentes");}
include("top.php");
include ("conexion.php");
?>
<table width="60%" align="center" background="images/fondo.jpg" border="1">
<tr bgcolor="#006699">
	<?php 
	$modulos=1;
	if ($id=='repositorio'){
		echo "<th background=\"windowsvista-assets1/main-button-tile.jpg\" height=\"30\">REPOSITORIO</th>";
		$sql="SELECT DISTINCT(modulo.nombre_mod),modulo.id_mod FROM modulo,datos_archivos WHERE modulo.estado=0 AND datos_archivos.eliminado=0 AND datos_archivos.estado=0 AND modulo.id_mod=datos_archivos.id_mod ORDER BY modulo.nombre_mod ASC";
		$result=mysql_db_query($db,$sql,$link);
		while ($row=mysql_fetch_array($result)){
			$total[$modulos]=$row['nombre_mod'];
			$total_id_mod[$modulos]=$row['id_mod'];
			$modulos++;
		}
	}
	if ($id=='ctrabajo'){
		echo "<th background=\"windowsvista-assets1/main-button-tile.jpg\" height=\"30\">COPIA DE TRABAJO</th>";
		$sql="SELECT DISTINCT(modulo.nombre_mod),modulo.id_mod  FROM control_archivos,datos_archivos,modulo WHERE control_archivos.ubicacion='c' AND control_archivos.login_b='$login' AND control_archivos.id_arch=datos_archivos.id_arch AND datos_archivos.id_mod=modulo.id_mod";
		$result=mysql_db_query($db,$sql,$link);
		while ($row=mysql_fetch_array($result)){
			$total[$modulos]=$row['nombre_mod'];
			$total_id_mod[$modulos]=$row['id_mod'];
			$modulos++;
		}
	}
	if ($id=='replica'){ 
		echo "<th background=\"images/main-button-tileR1.jpg\">REPLICA</th>";
		$sql="SELECT DISTINCT(modulo.nombre_mod),modulo.id_mod FROM control_archivos,datos_archivos,modulo WHERE control_archivos.ubicacion='b' AND control_archivos.id_arch=datos_archivos.id_arch AND datos_archivos.id_mod=modulo.id_mod";
		$result=mysql_db_query($db,$sql,$link);
		while ($row=mysql_fetch_array($result)){
			$total[$modulos]=$row['nombre_mod'];
			$total_id_mod[$modulos]=$row['id_mod'];
			$modulos++;
		}
	}
	if ($id=='revision'){
		echo "<th background=\"images/main-button-tileR1.jpg\">REVISION</th>";	
		$sql="SELECT DISTINCT(modulo.nombre_mod),modulo.id_mod FROM asignacion_cvs,datos_archivos,modulo WHERE asignacion_cvs.login_resp='$login' AND asignacion_cvs.estado=1 AND asignacion_cvs.id_arch=datos_archivos.id_arch AND datos_archivos.id_mod=modulo.id_mod";
		$result=mysql_db_query($db,$sql,$link);
		while ($row=mysql_fetch_array($result)){
			$total[$modulos]=$row['nombre_mod'];
			$total_id_mod[$modulos]=$row['id_mod'];
			$modulos++;
		}
	}
	?>
</tr>
<tr>
	<td>
		<table background="images/fondo.jpg">
		<?php 
		$tope=$modulos;
		$filas=($modulos/5)+1;
		$modulos=1;
		for ($i=1;$i<=$filas;$i++){
			echo "<tr>";
			for ($j=1;$j<6;$j++){
				if ($modulos<$tope){
					echo "<td>";
					echo "<table>";
					echo "<tr><td align=\"center\" width=\"120\" height=\"60\" valign=\"bottom\"><img src=\"images/carpeta.gif\" border=\"0\"></td>";
					if ($id=='repositorio')
						echo "<tr><td align=\"center\" width=\"120\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><a href=\"repositorio_archivos.php?id_mod=$total_id_mod[$modulos]&id=$id\">$total[$modulos]</a></td></tr>";
					if ($id=='ctrabajo')
						echo "<tr><td align=\"center\" width=\"120\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><a href=\"copia_trabajo.php?id_mod=$total_id_mod[$modulos]&id=$id&op=1\">$total[$modulos]</a></td></tr>";
					if ($id=='replica')
						echo "<tr><td align=\"center\" width=\"120\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><a href=\"replica.php?id_mod=$total_id_mod[$modulos]&id=$id\">$total[$modulos]</a></td></tr>";
					if ($id=='revision')
						echo "<tr><td align=\"center\" width=\"120\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><a href=\"revision.php?id_mod=$total_id_mod[$modulos]&id=$id&op=1\">$total[$modulos]</a></td></tr>";							
					$modulos++;
					echo "</table>";
					echo "</td>";	
				}
			}
			echo "</tr>";
		}
 		?>
		</table>
		<br>
	</td>
</tr>
</table>
<form name="form1" method="post" action="">
<table align="center">
  	<tr>
  		<td width="150"><div align="center"><input name="retornar" type="submit" id="retornar" value="RETORNAR"></div></td>
	</tr>
</table>
</form>
<?php include("top_.php");?>
<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		17/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require ("conexion.php");
function nom_comp($login_us){
	$sql_nom="SELECT nom_usr, apa_usr, ama_usr FROM users WHERE login_usr='$login_us'";
	$row_nom=mysql_fetch_array(mysql_query($sql_nom));
	$nom_co="$row_nom[nom_usr] $row_nom[apa_usr] $row_nom[ama_usr]";
	return($nom_co);
}
if(isset($ver))
{
	$ejec=0;
	if($selec=="Tarea" OR !$selec){
		$num=count($tareas);
		if($num<>"0"){
			for ($i=0;$i<$num;$i++){	
				if($i==$num-1){$tipo_tarea=$tipo_tarea.$tareas[$i];}
				else {$tipo_tarea=$tipo_tarea.$tareas[$i]."|*|";}
			}
		}
		else{$ejec=1; $msg=1;}
	}
	elseif($selec=="Asignado")
	{
		$num=count($asignado);
		if($num<>"0")
		{
			for ($i=0;$i<$num;$i++)
			{	if($i==$num-1){$tipo_asignado=$tipo_asignado."@".$asignado[$i]."@";}
				else {$tipo_asignado=$tipo_asignado."@".$asignado[$i]."@|*|";}
			}
		}
		else{$ejec=1; $msg=2;}
	}
if($ejec=="0"){
?>
<script language="JavaScript" type="text/JavaScript">
<!--
	var mes="<?php echo $mes;?>";
	var ano="<?php echo $AnoP;?>";
	var selec="<?php echo $selec;?>";
	if(selec=="Tarea" || selec=="")
	{	
		var tareas="<?php echo $tipo_tarea;?>";
		window.open ( "ver_lista_tareasdiaria_1.php?mes0=" + mes + "&ano0=" + ano + "&tareas=" + tareas + "&selec=" + selec, "Diario");
	}
	if(selec=="Asignado")
	{	
		var asignado="<?php echo $tipo_asignado;?>";
		window.open ( "ver_lista_tareasdiaria_1.php?mes0=" + mes + "&ano0=" + ano + "&asignado=" + asignado + "&selec=" + selec, "Diario");
	}
	close();
-->
</script>
<?php
	}
}
?>
<html>
<head>
<title>GesTor F1 - Programacion de Tareas</title>
</head>
<body>
<form name="form1" method="post" action="">
<input name="selec" type="hidden" value="<?php if (isset($selec)) echo $selec;?>">
<table width="98%"  border="1" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
    <tr> 
      <th background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
       <?php echo "REPORTE PROGRAMACION DE TAREAS DIARIAS";?>
        </font></th>
    </tr>
    <tr align="center"> 
      <td> <table width="100%" border="0">
          <tr> 
            <td colspan="3"><div align="center"> 
                <input type="radio" name="tip_imp" value="Tarea" <?php if((isset($selec) && $selec=="Tarea") OR !isset($selec)){echo "checked";}?> onClick="cambia('Tarea')">
                <strong><font size="2" face="Arial, Helvetica, sans-serif">Por 
                tareas&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="radio" name="tip_imp" value="Asignado" <?php if(isset($selec) && $selec=="Asignado"){echo "checked";}?> onClick="cambia('Asignado')">
                Por asignado</font></strong> &nbsp;<br>
                <hr>
              </div></td>
          </tr>
          <tr> 
            <td width="7%">&nbsp;</td>
            <td width="17%"><strong><font face="Arial, Helvetica, sans-serif">Mes 
              - A&ntilde;o:</font></strong></td>
            <td width="76%">&nbsp; <select name="mes">
                <option value="1">Enero</option>
                <option value="2">Febrero</option>
                <option value="3">Marzo</option>
                <option value="4">Abril</option>
                <option value="5">Mayo</option>
                <option value="6">Junio</option>
                <option value="7">Julio</option>
                <option value="8">Agosto</option>
                <option value="9">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
              </select> &nbsp;&nbsp;&nbsp;&nbsp; <select name="AnoP">
                <?php for($i=2000;$i<=date("Y");$i++)
				      {echo "<option value=\"$i\""; if(date("Y")=="$i") echo "selected"; echo">$i</option>";}
				?>
              </select> </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td valign="top"><strong><font face="Arial, Helvetica, sans-serif"><?php if((isset($selec) && $selec=="Tarea") OR !isset($selec)){echo "Tareas:";}else{echo "Asignado a:";}?></font></strong></td>
            <td>&nbsp; 
			<?php if((isset($selec) && $selec=="Tarea") OR !isset($selec)){?>
			<select name="tareas[]" size="5" multiple style="width:250px">
                <?php	$sql="SELECT Actividad, IdProgTarea FROM progtareasdiaria ORDER BY HoraDe ASC";	
					$result=mysql_query($sql);
					$limbo=1;
					while($row=mysql_fetch_array($result))
					{	
						echo '<option value="'.$row['IdProgTarea'].'"';
						if($limbo==1){echo " selected";}
						echo ">".substr($row['Actividad'],0, 35)."</option>";
						$limbo++;
					}
				?>
            </select> 
			<?php }
			elseif($selec=="Asignado"){?>
			<select name="asignado[]" size="5" multiple style="width:250px">
                <?php	
					$sql="SELECT d_asig FROM progtareasdiaria WHERE d_asig<>'0' GROUP BY d_asig ORDER BY IdProgTarea ASC";	
					$result=mysql_query($sql);
					$sql2="SELECT d_asig FROM progtareasdiaria WHERE d_asig='0' GROUP BY d_asig ORDER BY IdProgTarea ASC";
					$result2=mysql_query($sql2);
					$row2=mysql_fetch_array($result2);
					if($row2){echo "<option value=\"0\" selected>Todos</option>";}
					while($row=mysql_fetch_array($result))
					{	
						$nom_asig=nom_comp($row['d_asig']);
						echo "<option value=\"$row[d_asig]\">$nom_asig</option>";
					}
				?>
            </select> 
			<?php }?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              <input name="ver" type="submit" value="     VER     " onClick="openprint()"> 
              <br> &nbsp;&nbsp;<strong><font size="1">Nota: Para seleccionar mas 
              de una tarea, presione la tecla Control (Ctrl).</font></strong></td>
          </tr>
        </table>
  </table>
</form>
</body>
</html>
<script lenguaje="javascript" type="text/javascript">
<!--
function irapagina(pagina){         
 		 if (pagina!="") {
     	 	self.location = pagina;
 		 }
}
function cambia(valor)
{        
 	 irapagina("ver_lista_tareasdiaria_pre.php?selec="+valor);
}
<?php
	if (isset($msg)){
		if ($msg=="1"){
			print "var msg=\"No existe ninguna tarea seleccionada\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		}
		if ($msg=="2"){
			print "var msg=\"No existe ningun responsable seleccionado\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		}
	}
?>
-->
</script>
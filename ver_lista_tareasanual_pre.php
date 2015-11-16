<?php
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
	if((isset($selec) && $selec=="Tarea") OR !isset($selec)){
		$num=count($tareas);
		if($num<>"0"){
			for ($i=0;$i<$num;$i++){	
				if($i==$num-1){$tipo_tarea=$tipo_tarea.$tareas[$i];}
				else {$tipo_tarea=$tipo_tarea.$tareas[$i]."|*|";}
			}7
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
	$num2=count($AnoP);
	for ($i=0;$i<$num2;$i++)
	{	if($i==$num2-1){$tipo_ano=$tipo_ano.$AnoP[$i];}
		else {$tipo_ano=$tipo_ano.$AnoP[$i]."|*|";}
	}
	
if($ejec=="0"){
?>
<script language="JavaScript" type="text/JavaScript">
<!--
	var ano2="<?php echo $tipo_ano?>";
	var ano="<?php echo $AnoP?>";
	var selec="<?php echo $selec?>";
	if(selec=="Tarea" || selec=="")
	{	
		var tareas="<?php echo $tipo_tarea?>";
		window.open ( "ver_lista_tareasanual_1.php?ano0=" + ano2 + "&tareas=" + tareas + "&selec=" + selec, "trimestre");
	}
	if(selec=="Asignado")
	{	
		var asignado="<?php echo $tipo_asignado?>";
		window.open ( "ver_lista_tareasanual_1.php?ano0=" + ano2 + "&asignado=" + asignado + "&selec=" + selec, "trimestre");
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
<input name="selec" type="hidden" value="<?php echo $selec;?>">
<table width="98%"  border="1" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
    <tr> 
      <th background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
       <?php echo "REPORTE PROGRAMACION DE TAREAS TRIMESTRALES";?>
        </font></th>
    </tr>
    <tr align="center"> 
      <td height="235"> <table width="100%" border="0">
          <tr> 
            <td colspan="4"><div align="center"> 
                <input type="radio" name="tip_imp" value="Tarea" <?php if($selec=="Tarea" OR !$selec){echo "checked";}?> onClick="cambia('Tarea')">
                <strong><font size="2" face="Arial, Helvetica, sans-serif">Por 
                tareas&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="radio" name="tip_imp" value="Asignado" <?php if($selec=="Asignado"){echo "checked";}?> onClick="cambia('Asignado')">
                Por asignado</font></strong> &nbsp;<br>
                <hr>
              </div></td>
          </tr>
          <tr> 
            <td width="3%" height="40">&nbsp;</td>
            <td width="20%" valign="top"><strong><font face="Arial, Helvetica, sans-serif">Mes 
              - A&ntilde;o:</font></strong></td>
            <td width="77%">&nbsp; 
			  <select name="AnoP[]" size="4" multiple style="width:80px">
                <?php for($i=2000;$i<=date("Y");$i++)
				      {echo "<option value=\"$i\""; if(date("Y")=="$i") echo "selected"; echo">$i</option>";}
				?>
              </select>
              &nbsp;&nbsp; </td>
          </tr>
          <tr> 
            <td height="107">&nbsp;</td>
            <td valign="top"><strong><font face="Arial, Helvetica, sans-serif">
              <?php if($selec=="Tarea" OR !$selec){echo "Tareas:";}else{echo "Asignado a:";}?>
              </font></strong></td>
            <td colspan="2">&nbsp; 
              <?php if($selec=="Tarea" OR !$selec){?>
              <select name="tareas[]" size="5" multiple style="width:250px">
                <?php	$sql="SELECT Actividad, IdProgTarea FROM progtareasanual ORDER BY Dia ASC, HoraDe ASC";	
					$result=mysql_query($sql);
					$limbo=1;
					while($row=mysql_fetch_array($result))
					{	
						echo "<option value=\"$row[IdProgTarea]\"";
						if($limbo==1){echo "selected";}
						echo ">".substr($row['Actividad'],0, 35)."</option>";
						$limbo++;
					}
				?>
              </select> 
              <?php }
			elseif(isset($selec) && $selec=="Asignado"){?>
              <select name="asignado[]" size="5" multiple style="width:250px">
                <?php	
					$sql="SELECT a_asig FROM progtareasanual WHERE a_asig<>'0' GROUP BY a_asig ORDER BY IdProgTarea ASC";	
					$result=mysql_query($sql);
					$sql2="SELECT a_asig FROM progtareasanual WHERE a_asig='0' GROUP BY a_asig ORDER BY IdProgTarea ASC";
					$result2=mysql_query($sql2);
					$row2=mysql_fetch_array($result2);
					if($row2){echo "<option value=\"0\" selected>Todos</option>";}
					while($row=mysql_fetch_array($result))
					{	
						$nom_asig=nom_comp($row['a_asig']);
						echo "<option value=\"$row[a_asig]\">$nom_asig</option>";
					}
				?>
              </select>
              <?php }?>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              <input name="ver" type="submit" value="     VER     " onClick="openprint()"> 
              <br>
              &nbsp;&nbsp;<strong><font size="1">Nota: Para seleccionar mas de 
              una opcion, presione la tecla Control (Ctrl).</font></strong></td>
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
 	 irapagina("ver_lista_tareasanual_pre.php?selec="+valor);
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
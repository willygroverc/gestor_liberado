<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		13/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($impres))
{	
	session_start();
	if ($menu=="general")
	{ 	$_SESSION["campos"]="NA";?>
			<script language="JavaScript">
			Print();
			function Print () 
			{
			var form=document.form1;
			window.open ( "ver_proceso_2.php", "Estadisticas");
			close();
			return false;
			}
			-->
			</script>
	<?php }	
	elseif($menu=="por_campo")
	{
		if($campo=="")
		{	header("location: impresion_proc.php?tipo=camp&msg=1");}
		else
		{
			$num=count($campo);
			for ($i=0;$i<$num;$i++)
			{	if($i==$num-1){$campos=$campos.$campo[$i];}
				else {$campos=$campos.$campo[$i].",";}
			}
			$_SESSION["campos"]=$campos;
		
			?>
			<script language="JavaScript">
			Print();
			function Print () 
			{
			var form=document.form1;
			window.open ( "ver_proceso_2.php", "Estadisticas");
			close();
			return false;
			}
			-->
			</script>
<?php }}}?>
<html>
<head>
<title>GesTor - PCN - Impresion</title></head>
<body topmargin="0" >
<table background="images/fondo.jpg" width="98%"  align="center" border="1">
<tr>
  <td  bgcolor="#006699" align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica"><b>IMPRESIONES</b></font></td>
</tr>
<tr><form action="" method="POST" name="form1">
	 <td> 
        <table border="1"><tr>
            <td height="132"> 
              <table width="100%" border="0">
                <tr> 
                  <td height="40"></td>
                  <td colspan="4"><strong>Seleccione el Campo por el cual desea 
                    Ordenar : </strong></td>
                </tr>
                <tr> 
                  <td width="17" height="40"></td>
                  <td width="118"><font size="2" face="Arial, Helvetica"><B>Campo 
                    :</B></font></td>
                  <td colspan="3"> 
				    <select name="menu" id="select">
                      <option value="P" selected>Probabilidad</option>
					  <option value="I" selected>Impacto</option>
					  <option value="R" selected>Riesgo</option>                      
                    </select> </td>
                </tr>
                <tr> 
                  <td width="17" height="40"></td>
                  <td width="118" valign="top"><font size="2" face="Arial, Helvetica"><B>Ordenamiento 
                    : </B></font></td>
                  <td width="161" valign="top"> <input type="radio" name="orden" value="A">
                    &nbsp;Ascendente<br>
                    <input type="radio" name="orden" value="D" checked>
                    &nbsp;Descendente</td>
                  <td width="121" valign="bottom"> 
				  <?php if(isset($cons)){?>
				  <input name="impres" type="button" value="    VER    " onClick="imprime2()"> 
				  <?php }else{?>
				  <input name="impres" type="button" value="    VER    " onClick="imprime()"> 
				  <?php }?>
                    <br>
                  </td>
                  <td width="296">&nbsp;</td>
                </tr>
              </table>
		</td></tr>
		</table>
	</td></form>
</tr>
</table>
<script language="JavaScript">
function imprime()
{
	var hola="<?php echo $codigo;?>";
	var aa=document.form1.menu.value;
	if(document.form1.orden[0].checked=="1"){var bb="A";}
	if(document.form1.orden[1].checked=="1"){var bb="D";}
	window.open ( "riesgo-resultados1_impre.php?codigo="+hola+"&campo="+aa+"&orden="+bb);
	close();
}
function imprime2()
{
	var hola="<?php echo @$cons;?>";
	var aa=document.form1.menu.value;
	if(document.form1.orden[0].checked=="1"){var bb="A";}
	if(document.form1.orden[1].checked=="1"){var bb="D";}
	window.open ( "riesgo-resultados1_impre.php?cons="+hola+"&campo="+aa+"&orden="+bb);
	close();
}
</script>
</body>
</html>
<?php
include ("conexion.php");
session_start();
$login_usr = $_SESSION["login"];
include("top.php");  ?>

<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg">
        <tr> 
          <th colspan="20">ORDENES DE TRABAJO</th>
        </tr>
        <tr align="center"> 
          <td width="25" height="25" class="menu">Nro</td>
		  <td width="20" height="25" class="menu">ORIGEN</td>
          <td width="72" class="menu">FECHA Y HORA</td>
          <td width="84" class="menu">ENVIADO POR</td>
          <td width="17" class="menu">TIPO</td>
          <td width="60" class="menu">CLIENTE / TITULAR</td>
          <td width="61" class="menu">FECHA SOLUCION</td>
          <td width="17" class="menu">TIPO</td>
          <td width="60" class="menu">CLIENTE / TITULAR</td>
          <td width="61" class="menu">FECHA SOLUCION</td>
		  <td width="61" class="menu">FECHA SOLUCION</td>
		</tr>
<?php
		$sql11 = "SELECT * FROM control_parametros";
		$result11=mysql_db_query($db,$sql11,$link);
		$row11=mysql_fetch_array($result11);
		if(empty($row11[num_ord_pag])) {$_pagi_cuantos =20 ; }
		else{  $_pagi_cuantos = $row11[num_ord_pag] ;}
		if (empty($_GET['pg'])) {$_pagi_actual = 1;}
		else{$_pagi_actual = $_GET['pg'];}
		echo $_pagi_cuantos;
		echo "<br>pag actual : ".$_pagi_actual;
	
		$sql9 = "select count(cod_usr)as pagi_totalReg from ordenes where  cod_usr = '$login_usr'";
		echo "<br>sql nueve es : ".$sql9;
		$result9=mysql_db_query($db,$sql9,$link);
		$row9=mysql_fetch_array($result9);
		echo "<br>pagi total reg : ".$row9[pagi_totalReg];
		$_pagi_totalPags = ceil($row9[pagi_totalReg] / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	
		$sql = "select *from ordenes where  cod_usr = '$login_usr' limit $_pagi_inicial,$_pagi_cuantos";
	
	
	$res = mysql_db_query($db,$sql,$link);
	while($row = mysql_fetch_array($res))
	{
?>
		<tr align="center"> 
          <td width="25"><?php=$row[id_orden]?></td>
		  <td width="20"><?php=$row[fecha]?></td>
          <td width="72"><?php=$row['time']?></td>
          <td width="84"><?php=$row[cod_usr]?></td>
          <td width="17"><?php=$row[desc_inc]?></td>
          <td width="60"><?php=$row[tipo]?></td>
          <td width="220" ><?php=$row[nomb_archivo]?></td>
          <td width="100" ><?php=$row[ci_ruc]?></td>
          <td width="61" ><?php=$row[id_anidacion]?></td>
          <td width="17" ><?php=$row[origen]?></td>
          <td width="17" ><?php=$row[hash_archivo]?></td>

		</tr>
			  
<?php  }?>
</table>
<!----------------------->

<form name="form1" method="post" action="">
  <table width="100%" border="0" align="center">
    <tr> 
      <td height="20"> 
        <div align="center"> 
          <p><font size="2"><strong> Pagina(s) :&nbsp; 
            <?php
//if($numRows!=0){

	$_pagi_enlace = $_SERVER['PHP_SELF'];
	$_pagi_query_string = "?";
	
	if(isset($_GET)){
		$_pagi_variables = $_GET;
		foreach($_pagi_variables as $_pagi_clave => $_pagi_valor){
			if($_pagi_clave != 'pg'){
				
				$_pagi_query_string .= $_pagi_clave."=".$_pagi_valor."&";
			}
		}
	}
	//Anadimos el query string a la url.
	$_pagi_enlace .= $_pagi_query_string;
	
	//La variable $_pagi_navegacion contendrá los enlaces a las páginas.
	$_pagi_navegacion = '';

	if ($_pagi_actual != 1)
	{
		//Si no estamos en la página 1. Ponemos el enlace "anterior"
		$_pagi_url = $_pagi_actual - 1;//será el numero de página al que enlazamos
		$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_url."'>&laquo; Anterior</a>&nbsp;";
	}
//Enlaces a numeros de página:
	 if ($_pagi_actual>5)
	 {
		 $pagi=$_pagi_actual-5;
		 $totpag=$_pagi_actual+5;
	 }
	 else
	 {
		 $pagi=1;
		 $totpag=10;
	 }
	if ($totpag >= $_pagi_totalPags)
	{
		 $totpag = $_pagi_totalPags;
		 $pagi=$totpag-10;
			if ($pagi<=1){$pagi=1;}
	}
	for ($_pagi_i = $pagi; $_pagi_i<=$totpag; $_pagi_i++)
	{//Desde página 1 hasta ultima página ($_pagi_totalPags)
			if ($_pagi_i == $_pagi_actual) 
			{
				//Si el numero de página es la actual ($_pagi_actual). Se escribe el numero, pero sin enlace y en negrita.
				$_pagi_navegacion .= "<b>&nbsp;$_pagi_i&nbsp;</b>";
			}
			else
			{
				//Si es cualquier otro. Se escibe el enlace a dicho numero de página.
				$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_i."'>".$_pagi_i."</a>&nbsp;";
			}
	}

	if ($_pagi_actual < $_pagi_totalPags)
	{
		//Si no estamos en la ultima página. Ponemos el enlace "Siguiente"
		$_pagi_url = $_pagi_actual+1;//será el numero de página al que enlazamos
		$_pagi_navegacion .="<a href='".$_pagi_enlace."pg=".$_pagi_url."'>Siguiente &raquo;</a>";
	}

print $_pagi_navegacion;
//}else{ print 0;}
//Hasta acá hemos completado la "barra de navegacion"
?>
          
</form>
<!------------------------->

<?php include("top_.php"); ?>
 

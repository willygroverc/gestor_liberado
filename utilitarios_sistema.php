<?php
if (isset($retorna))
{ header("location: seguridad_opt.php?Naveg=Seguridad >> Panel de Control");
}

include ("top.php");
include ("conexion.php");
?>
<html>
<head>
<link rel=stylesheet href="general.css" "type=text/css">
<title>Utilitarios Sistema</title>
</head>
<body>
<script language="JavaScript" src="calendar.js"></script>
<table width="55%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" bgcolor="#F4F2EA" >
  <tr> 
    <td>
	 <table width="100%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg">
         <tr> 
            <th>UTILITARIOS DEL SISTEMA </th>
        </tr>
          <tr align="center" > 
            
          <td> <table width="100%" border="0">
              <tr class="tit_form"> 
                <td width="32%" align="center" ><?php echo "<a class='lin' href=\"datos_telefonia_movil.php?Naveg=Seguridad >> Telefonia Movil\"> "?>
				<img border="0" src="images/fono.gif"><br>
				TELEFONIA MOVIL
				<br>
                 </a></td>
                <td width="38%" align="center">
				<?php echo "<a class='lin' href=\"boletin.php?Naveg=Seguridad >> Boletin Informativo\">";?>
				<img border="0" src="images/personas.gif" align="center"><br><br>
				BOLETIN INFORMATIVO							
                 </a></div></td>
                <td width="38%" align="center">
				<?php
		  		$sql1="SELECT * FROM control_parametros";
		 	 	$rs1=mysql_db_query($db,$sql1,$link);
		  		$row1=mysql_fetch_array($rs1);		
		  		if ($row1[agencia]=="si") {				
				?>
				<?php echo "<a class='lin' href=\"datos_adicionales.php?Naveg=Seguridad >> Datos Adicionales\">";?>
				<img border="0" src="images/nuevo.gif" align="center"><br><br>
				DATOS ADICIONALES							
                 </a>
				 <?php } else echo "&nbsp;";?>
			    </td>				 
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td></xtd>
              </tr>
			  <tr>
                <td width="32%" align="center" class="tit_form"><?php echo "<a class='lin' href=\"adm_recordatorios.php?Naveg=Seguridad >> Recordatorios\"> "?>
				<img border="0" src="images/informacion.png"><br>
				 RECORDATORIOS
				<br>
                </a></td>			  	
				<td>&nbsp;</td>
				<td>&nbsp;</td>	
			  </tr>
            </table></td>	
          </tr>
      </table></td>
  </tr>
</table>
<form name="form1" action="" method="post">
  <input name="retorna" type="submit" value="RETORNAR">
</form>
</body>	
</html>
<?php include ("top_.php")?>	
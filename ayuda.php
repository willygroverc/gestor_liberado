<?php
include ("top.php");
?>
<style type="text/css">
<!--
.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 14px;
}
-->
</style>
<p>
<TABLE WIDTH="80%" BORDER="2" align="center" CELLPADDING="2" CELLSPACING="0" >
    <tr align="center" valign="middle"> 
	
        <td background="images/main-button-tileR.jpg"><span class="Estilo1">MANUAL USUARIO</span></td>
<?php	if (($tipo=="T") or ($tipo=="A") or ($tipo=="SA"))
		{
          echo "<td background=\"images/main-button-tileR.jpg\"><span class=\"Estilo1\">MANUAL TECNICO</span></td>";
		  //echo "<tr>";
		  }
		if (($tipo=="A") or ($tipo=="SA")) 
		 {
         echo "<td background=\"images/main-button-tileR.jpg\"><span class=\"Estilo1\">MANUAL ADMINISTRADOR</span></td>";
		 }
		/* if ( ($tipo=="T") or ($tipo=="A") or ($tipo=="B"))
		 {
         echo "<td background=\"images/main-button-tileR.jpg\"><span class=\"Estilo1\">POLITICAS NORMAS Y PROCEDIMIENTOS</span></td>";
		 }*/
		 echo "</tr>";
		 ?>
		 <!--<td height="69"><div align="center"><a href="ayuda1/cliente/guia_usuario.pdf" target="_blank"><img src="images/cliente.gif" width="129" height="76" border="0"></a></div></td>-->
		 <td height="69"><div align="center"><A href="ayuda1/cliente/guia_usuario.pdf" target="_blank"><img src="images/cliente.gif" width="129" height="76" border="0"></A></div></td>
		 <?php
		 if (($tipo=="T") or ($tipo=="A") or ($tipo=="SA"))
		 echo "<td height=\"69\"><div align=\"center\"><a href=\"ayuda1/tecnico/ayuda.html\" target=\"_blank\"><img src=\"images/tecnico.gif\" width=\"100\" height=\"103\" border=\"0\"></a></div></td>";
       	if (($tipo=="A") or ($tipo=="SA")) 
		 echo "<td height=\"69\"><div align=\"center\"><a href=\"ayuda1/adm/ayuda.html\" target=\"_blank\"><img src=\"images/administrador.gif\" width=\"100\" height=\"103\" border=\"0\"></a></div></td>";
		 if ( ($tipo=="T") or ($tipo=="A") or ($tipo=="B")) 
         //echo "<td><a class=\"menu\" href=\"ayuda1/pnps/index.html\" target=\"_blank\">POLITICAS NORMAS Y PROCEDIMIENTOS</a></td>";
		 /*echo "<td><div align=\"center\"><a href=\"ayuda1/pnps/index.html\" target=\"_blank\"><img src=\"images/administrador.gif\" width=\"100\" height=\"103\" border=\"0\"></a></div></td>";*/
?>

	</TR>

</TABLE>
</p>
<?php 
//if ($tipo=="A")
//{
//include ("pagina_inicio2.php");
//}
include ("top_.php"); ?>
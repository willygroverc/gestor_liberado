<?php
include ("top.php");
?>
<p>
 <TABLE WIDTH="80%" BORDER="2" align="center" CELLPADDING="2" CELLSPACING="0">
    <TR bgcolor="#006699" align="center" valign="middle"> 
        <td><a class="menu" href="ayuda1/cliente/ayuda.html" target="_blank">MANUAL USUARIO</a></td>
<?php	if (($tipo=="T") or ($tipo=="A") or ($tipo=="B"))
          echo "<td width='30%'><a class=\"menu\" href=\"ayuda1/tecnico/ayuda.html\" target=\"_blank\">MANUAL TECNICO</a></td>";
		if (($tipo=="A") or ($tipo=="B")) 
         echo "<td width='30%'><a class=\"menu\" href=\"ayuda1/adm/ayuda.html\" target=\"_blank\">MANUAL ADMINISTRADOR</a></td>";
	    if ( ($tipo=="T") or ($tipo=="A") or ($tipo=="B")) 
         echo "<td width='40%'><a class=\"menu\" href=\"ayuda1/pnps/index.html\" target=\"_blank\">POLITICAS NORMAS Y PROCEDIMIENTOS</a></td>";
?>

	</TR>

</TABLE>
</p>
<?php 
include ("pagina_inicio2.php");
include ("top_.php"); ?>
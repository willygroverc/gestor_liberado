<?php include ("top.php");
$sql="SELECT * FROM roles WHERE login_usr='$login'";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result);
?>
  <TABLE WIDTH="40%" BORDER="2" align="center" CELLPADDING="2" CELLSPACING="0">
    <TR bgcolor="#006699" align="center" valign="middle">
       <?php if ($row[Produccion]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
          echo "<td background=\"windowsvista-assets1/main-button-tile.jpg\" height=\"30\"><a ".$clas." href=\"lista_ordenrev1.php?Naveg=Problemas >> Produccion\">PRODUCCION - PROAPD</a></td>";
		  if ($row[DesaMante]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
          echo "<td><a ".$clas." href=\"enconstruccion.php?Naveg=Problemas >> D y M\">D & M - PROADM</a></td>";?>
    </TR>
</TABLE>
<?php 
include("pagina_inicio2.php");
include("top_.php");?>
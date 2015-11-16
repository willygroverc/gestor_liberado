<?php
echo "<script language=\"Javascript\">\n";
echo "   \n";
echo "     ventana=confirm(\"Desea salir del sistema\");\n";
echo "     if (ventana) {\n";
echo "	 \n";
echo "     window.location.replace(\"index.php\");\n";
echo "     }\n";
echo "                                      \n";
echo "    \n";
echo "    </script>\n";

?>
<?php
/*cierra la base de datos
session_start();
$_SESSION = array();
session_destroy();
header("location:index.php");*/
?>


  <!--  <script language="Javascript">
   
     ventana=confirm("Desea salir del sistema");
     if (ventana) {
	 <?php
	 session_start();
	$_SESSION = array();
	session_destroy();
	 ?>
     window.location.replace("listae.php");
     }
                                      
    
    </script>-->
<html><head><body background="images/fondo.jpg">
</body></head></html>


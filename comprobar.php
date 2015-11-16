<?php
// Version:		1.0
// Objetivo:	Control acceso directo No autorizado.
//				Modificacion funciones php obsoletas para version 5.3
// Fecha:		27/DIC/2012 
// Autor:		Cesar Cuenca
//______________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
else{
	header('location:login.php');
}
	require("conexion.php");
	if(isset($_REQUEST['codigo'])){
	$sql="SELECT CodActFijo FROM datfichatec WHERE CodActFijo='$_REQUEST[codigo]'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if ($row>0){
	?>
	<script language="JavaScript">
		window.alert("El codigo ya existe")
	</script>
	<?php
	}
	else{
	?>
	<script language="JavaScript">
			var cod_act='<?php echo $_REQUEST['codigo']?>';
			window.alert("Codigo Aceptado, puede rellernar el formulario");
			irapagina2("comprobar.php?cod_act="+cod_act+"&val=SI");
			function irapagina2(pagina2){         
 		 		if (pagina2!="") {
     	 	self.location = pagina2;
 		 		}};
	</script>
	<?php
	}}
?>
<html>
<head>
<title>Comprobar Codigo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<table width="100%" border="1"  align="center" background="images/fondo.jpg">
  <tr> 
    <td  bgcolor="#006699" align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica"><b>COMPROBAR 
      CODIGO DE ACTIVO FIJO</b></font></td>
  </tr>
  <tr> 
    <td align="center">
        <BR>
        <table width="75%" border="0">
        <tr valign="baseline"> 
          <td width="60%"><font size="2" face="Arial, Helvetica"><B>Ingrese el 
            codigo de activo fijo:</B></font></td>
            
          <td width="40%"> 
            <form name="form">
              <input name="codigo" type="text" id="codigo" value="<?php if (isset($_REQUEST['cod_act']))echo $_REQUEST['cod_act']?>">
            </form></td>
          </tr>
        </table>
	       	  <?php if(isset($_REQUEST['val']) && $_REQUEST['val']=='SI'){?>
        <input name="llenar" type="button" id="llenar" value="Llenar Ficha" onClick="ir_a2()">          
		  <input name="comprobar" type="button" id="comprobar" value="Comprobar Nuevo" onClick="ir_a()">
		  <?php }else{?>
           <input name="comprobar" type="button" id="comprobar" value="Comprobar" onClick="ir_a()">
		   <?php }?>
          <BR><BR>
        
      </td>
  </tr>
</table>
</body>
</html>
	<script language="JavaScript">
		function irapagina(pagina){         
 		 if (pagina!="") {
     	 	self.location = pagina;
 		 }
		};
		function ir_a(){
		 	irapagina("comprobar.php?codigo="+form.codigo.value);
		 };
		function ir_a2(){
		    var varia2="<?php echo isset($_REQUEST['cod_act']); ?>";
			opener.document.form1.CodActFijo.value = varia2;
			close(); 
		};
	</script>
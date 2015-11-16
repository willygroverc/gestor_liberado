<?php 
$connect=mysql_connect("localhost","fubrecti","gruosi2005");
mysql_select_db("fubrecti_bdcursoweb",$connect);
if (isset($retornar))
{ header("location: lista_capacitacion.php?Naveg=Gestion >> Capacitacion");}
if (isset($cmdok))
{$sql="INSERT INTO test (test_dominio,test_num,test_pregunta,test_respuesta,test_optA,test_optB,test_optC,test_optD,test_explicacion,".
"test_idioma) VALUES('$txtdominio','$txtnum','$txtpregunta','$txtrespuesta','$txtresA','$txtresB','$txtresC','$txtresD','$txtexplicacion','$op')";
mysql_query($sql,$connect);}

include("top.php");?>
<script lenguaje="javascript" type="text/javascript">
function irapagina(pagina){         
 		 if (pagina!="") {
     	 	self.location = pagina;
			
 		 }
}

function cambio(numero){ 
		 if (!foco_texto){
				 irapagina("preguntas.php?op="+numero);
		 } 
}
var foco_texto=false;
</script>
<link rel=stylesheet href="general.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>

<body>
<p><font color="#000000" size="5" face="Arial, Helvetica, sans-serif"></font></p>
 
<form action="" method="post" name="form1" id="">
<input name="op" type="hidden" value="<?php echo $op;?>">
<table width="90%" border="1" align="center" background="images/fondo.jpg">
  <tr> 
    <td colspan="2" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>INGRESAR 
        LAS PREGUNTAS</strong></font></div></td>
  </tr>
  <tr> 
    <td width="15%"> <div align="left"><font face="Geneva, Arial, Helvetica, sans-serif"><strong>Idioma 
        de la pregunta:</strong></font></div></td>
      <td width="85%">&nbsp; 
        <input type="radio" name="tipo_iden" value="e" onClick="cambio(this.value)" <?php if ($op == e) print "checked";  ?>>
      Espa&ntilde;ol&nbsp;&nbsp;&nbsp; 
      <input type="radio" name="tipo_iden" value="i" onClick="cambio(this.value)" <?php if ($op == i) print "checked";  ?>>
      Ingles </tr>
  <tr> 
    <td> 
      <div align="left"><font face="Geneva, Arial, Helvetica, sans-serif"><strong>Dominio 
        de la pregunta:</strong></font></div></td>
    <td>&nbsp; 
      <?php if ($op=="i") { ?>
      <select name="txtdominio" class="texto1"  <?php if ($op==""){echo "disabled";}?> onChange="showtext(document.form1.txtdominio.selectedIndex)">
		 <option value="">SELECT A DOMAIN</option>
		 <option value="1">CHAPTER 1: THE INFORMATION SYSTEM AUDIT PROCESS</option>
 		 <option value="2">CHAPTER 2: MANAGEMENT, PLANNING, AND ORGANIZATION OF INFORMATION SYSTEMS</option>
 		 <option value="3">CHAPTER 3: TECHNICAL INFRASTRUCTURE AND OPERATIONAL PRACTICES</option>
 		 <option value="4">CHAPTER 4: PROTECTION OF INFORMATION ASSETS</option>
 		 <option value="5">CHAPTER 5: DISASTER RECOVERY AND BUSINESS CONTINUITY</option>
 		 <option value="6">CHAPTER 6: BUSINESS APPLICATION SYSTEMS DEVELOPMENT, ACQUISITION, IMPLEMENTATION, AND MAINTENANCE</option>
 		 <option value="7">CHAPTER 7: BUSINESS PROCESS EVALUATION AND RISK MANAGEMENT</option>
        </select>
	<?php } if ($op=="e") {?>
      	 <select name="txtdominio" class="texto1" <?php if ($op==""){echo "disabled";}?> onChange="showtext(document.form1.txtdominio.selectedIndex)">
		 <option value="">SELECCIONE UN DOMINIO</option>
		 <option value="1">CAPITULO 1: EL PROCESO DE AUDITORIA DE SI</option>
 		 <option value="2">CAPITULO 2: ADMINISTRACION, PLANEACION Y ORGANIZACION DE SI</option>
 		 <option value="3">CAPITULO 3: INFRAESTRUCTURA TECNICA Y PRACTICAS OPERATIVAS</option>
 		 <option value="4">CAPITULO 4: PROTECCION DE LOS ACTIVOS DE INFORMACION</option>
 		 <option value="5">CAPITULO 5: RECUPERACION DE DESASTRES Y CONTINUIDAD DEL NEGOCIO</option>
 		 <option value="6">CAPITULO 6: DESARROLLO, ADQUISICION, IMPLEMENTACION Y MANTENIMIENTO DE LOS SISTEMAS DE APLICACION DEL NEGOCIO</option>
 		 <option value="7">CAPITULO 7: EVALUACION DEL PROCESO DEL NEGOCIO Y ADMINISTRACION DE RIESGOS</option>
        </select>
		<?php } ?>
     </td>
  </tr>
  <tr> 
    <td height="26">
<div align="left"><font face="Geneva, Arial, Helvetica, sans-serif"><strong>N&ordm; 
        de Pregunta:</strong></font></div></td>
    <?php $connect=mysql_connect("localhost","fubrecti","gruosi2005");
mysql_select_db("fubrecti_bdcursoweb",$connect);
	   $sql="SELECT max(test_num) FROM test WHERE test_idioma='$op' AND test_dominio='$txtdominio'";
	   $numero=mysql_fetch_array(mysql_query($sql,$connect));
	   $num=$numero[0]+1;?>
	<td>&nbsp;&nbsp; 
      <input name="txtnum" type="text" id="txtnum" value="0" size="10" readonly="true" <?php if ($op==""){echo "disabled";}?>>
      </td>
  </tr>
  <tr> 
    <td height="37"> <div align="left"><font face="Geneva, Arial, Helvetica, sans-serif"><strong>Pregunta:</strong></font></div></td>
    <td>&nbsp; 
      <textarea name="txtpregunta" cols="115" rows="3" id="txtpregunta" <?php if ($op==""){echo "disabled";}?>></textarea></td>
  </tr>
  <tr> 
    <td height="37"> <div align="left"><font face="Geneva, Arial, Helvetica, sans-serif"><strong>Respuesta 
        Opcion A:</strong></font></div></td>
    <td>&nbsp; 
      <textarea name="txtresA" cols="115" rows="2" id="txtresA" <?php if ($op==""){echo "disabled";}?>></textarea></td>
  </tr>
  <tr> 
    <td height="33"> <div align="left"><font face="Geneva, Arial, Helvetica, sans-serif"><strong>Respuesta 
        Opcion B:</strong></font></div></td>
    <td>&nbsp; 
      <textarea name="txtresB" cols="115" rows="2" id="txtresB" <?php if ($op==""){echo "disabled";}?>></textarea></td>
  </tr>
  <tr> 
    <td height="37"> <div align="left"><font face="Geneva, Arial, Helvetica, sans-serif"><strong>Respuesta 
        Opcion C:</strong></font></div></td>
    <td>&nbsp; 
      <textarea name="txtresC" cols="115" rows="2" id="txtresC" <?php if ($op==""){echo "disabled";}?>></textarea></td>
  </tr>
  <tr> 
    <td height="37"> <div align="left"><font face="Geneva, Arial, Helvetica, sans-serif"><strong>Respuesta 
        Opcion D:</strong></font></div></td>
    <td>&nbsp; 
      <textarea name="txtresD" cols="115" rows="2" id="txtresD" <?php if ($op==""){echo "disabled";}?>></textarea></td>
  </tr>
  <tr> 
    <td><div align="left"><font face="Geneva, Arial, Helvetica, sans-serif"><strong>Respuesta 
        Corrrecta:</strong></font></div></td>
    <td>&nbsp; 
      <select name="txtrespuesta" id="txtrespuesta" <?php if ($op==""){echo "disabled";}?>>
        <option>A</option>
        <option>B</option>
        <option>C</option>
        <option>D</option>
      </select></td>
  </tr>
  <tr> 
    <td> 
      <div align="left"><font face="Geneva, Arial, Helvetica, sans-serif"><strong> 
        Explicaci&oacute;n:</strong></font></div></td>
    <td>&nbsp; 
      <textarea name="txtexplicacion" cols="115" rows="4" id="txtexplicacion" <?php if ($op==""){echo "disabled";}?>></textarea></td>
  </tr>
  <tr> 
    <td colspan="2"><div align="center">
        <input name="cmdok" type="submit" id="cmdok2" value="GUARDAR">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        <input type="submit" name="retornar" value="RETORNAR">
      </div></td>
  </tr>
</table>
</form>
<p>&nbsp;</p>
<?php include("top_.php");?>
<script language="JavaScript" type="text/javascript">
<!--
var shortcut=document.form1
var descriptions=new Array()

//extend this list if neccessary to accomodate more selections
/*<?php if ($op<>""){?>
shortcut.txtnum.value=descriptions[shortcut.txtdominio.selectedIndex]
<?php }?>
function gothere(){
location=shortcut.txtdominio.options[shortcut.txtdominio.selectedIndex].value
}*/

function showtext(index){
<?php $connect=mysql_connect("localhost","fubrecti","gruosi2005");
mysql_select_db("fubrecti_bdcursoweb",$connect);?>
var ind=index;
if (ind==0)
{ var y=0;}
if (ind==1)
{ <?php $sql="SELECT max(test_num) as numer FROM test WHERE test_idioma='$op' AND test_dominio='1'";
	 $numero=mysql_fetch_array(mysql_query($sql,$connect));
  ?>
  var y=<?php echo $numero[numer]+1;?>}
if (ind==2)
 { <?php $sql="SELECT max(test_num) as numer FROM test WHERE test_idioma='$op' AND test_dominio='2'";
	 $numero=mysql_fetch_array(mysql_query($sql,$connect));
  ?>
  var y=<?php echo $numero[numer]+1;?>}
if (ind==3)
 { <?php $sql="SELECT max(test_num) as numer FROM test WHERE test_idioma='$op' AND test_dominio='3'";
	 $numero=mysql_fetch_array(mysql_query($sql,$connect));
  ?>
  var y=<?php echo $numero[numer]+1;?>}
if (ind==4)
 { <?php $sql="SELECT max(test_num) as numer FROM test WHERE test_idioma='$op' AND test_dominio='4'";
	 $numero=mysql_fetch_array(mysql_query($sql,$connect));
  ?>
  var y=<?php echo $numero[numer]+1;?>}
if (ind==5)
 { <?php $sql="SELECT max(test_num) as numer FROM test WHERE test_idioma='$op' AND test_dominio='5'";
	 $numero=mysql_fetch_array(mysql_query($sql,$connect));
  ?>
  var y=<?php echo $numero[numer]+1;?>}
if (ind==6)
 { <?php $sql="SELECT max(test_num) as numer FROM test WHERE test_idioma='$op' AND test_dominio='6'";
	 $numero=mysql_fetch_array(mysql_query($sql,$connect));
  ?>
var y=<?php echo $numero[numer]+1;?>}
if (ind==7)
 { <?php $sql="SELECT max(test_num) as numer FROM test WHERE test_idioma='$op' AND test_dominio='7'";
	 $numero=mysql_fetch_array(mysql_query($sql,$connect));
  ?>
  var y=<?php echo $numero[numer]+1;?>}

		<?php //$numero=mysql_fetch_array(mysql_query($sql,$connect));
		//$num=$numero[numer]+1;
		?>
shortcut.txtnum.value=y;
}


//-->
</script>

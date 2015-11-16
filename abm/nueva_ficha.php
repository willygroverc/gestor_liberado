<?php 
@session_start();
require ("../conexion.php");
require_once('../funciones.php');

//$CodActFijo1=_clean($_POST['CodActFijo']);
//$CodActFijo1="abc-1233";
	$marca=$_POST['marca'];
	$AdicUSI1=$_POST['AdicUSI1'];
	$Modelo1=$_POST['Modelo1'];
	$CodActFijo1=$_POST['CodActFijo1'];
	$NumSerie1=$_POST['NumSerie1'];
	//$RealizFicha1=$_POST['RealizFicha1'];
	$FechAlta=$_POST['FechAlta'];
	$GarantDe=$_POST['GarantDe'];
	$GarantAl=$_POST['GarantAl'];
$sql="SELECT CodActFijo FROM datfichatec WHERE CodActFijo='$CodActFijo1' LIMIT 1";
$recordset=mysql_query($sql);

if (mysql_num_rows($recordset)>0){ // Verificación de Activo Fijo existente en bd.
	echo -2;
}
else
{
	//$var = $FechAlta."()".$GarantDe."()".$GarantAl;
	$marca=_clean($marca);
	$AdicUSI1=_clean($AdicUSI1);
	$AdicUSI=_clean($_POST['AdicUSI1']);
	$Modelo1=_clean($Modelo1);
	$CodActFijo1=_clean($CodActFijo1);
	$NumSerie1=_clean($NumSerie1);
	
	$marca=SanitizeString($marca);
	$AdicUSI1=SanitizeString($AdicUSI1);
	$AdicUSI=SanitizeString($AdicUSI);
	$Modelo1=SanitizeString($Modelo1);
	$CodActFijo1=SanitizeString($CodActFijo1);
	$NumSerie1=SanitizeString($NumSerie1);
	
	$marca=normaliza($marca);
	$AdicUSI1=normaliza($AdicUSI1);
	$AdicUSI=normaliza($AdicUSI);
	$Modelo1=normaliza($Modelo1);
	$CodActFijo1=normaliza($CodActFijo1);
	$NumSerie1=normaliza($NumSerie1);
	//ajax.send("RealizFicha="+RealizFicha.value+"marca="+marca.value+"&AdicUSI1="+AdicUSI1.value+"&Modelo1="+Modelo.value+"&CodActFijo1="+CodActFijo1.value+"&NumSerie1="+NumSerie.value+"&FechAlta="+FechAlta.value+"&GarantDe="+GarantDe.value+"&GarantAl="+GarantAl.value);
	$sql_in="INSERT INTO datfichatec (CodUsr,TpRegFicha,FechPruFunc,RealizFicha,Marca,AdicUSI,Modelo,CodActFijo,NumSerie,FechAlta,Proveedor,GarantDe,GarantAl,Elim)"."
 								VALUES('$login','$CodActFijo1','$FechAlta','admin','$marca','$AdicUSI1','$Modelo1','$CodActFijo1','$NumSerie1','$FechAlta','Yanap','$GarantDe','$GarantAl','0')";
	
	if (mysql_query($sql_in))
			echo 0; // Insercion correcta
		else
			echo -1;
}
?>
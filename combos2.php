<?php
 function conexion(){
	if (!($link=mysql_connect("localhost","root",""))){
		die("Error conectando a la base de datos.");
	}
	if (!$link=mysql_select_db("prueba",$link)){ 
		die("Error seleccionando la base de datos.");
	}
	    return($link);
	
  }
$conection = conexion();
$idcombo = $_POST["id"];
$action =$_POST["combo"];
switch($action){
	case "area":{
		$res = mysql_query("SELECT id_dominio,dominio FROM dominio WHERE id_area = $idcombo order by dominio ASC");
		while($rs = mysql_fetch_array($res))
			echo '<option value="'.$rs["id_dominio"].'">'.htmlentities($rs["dominio"]).'</option>';	
	break;
	}
	case "dominio":{		
		$res = mysql_query("SELECT id_objetivo,objetivo FROM objetivos WHERE id_dominio = $idcombo order by objetivo ASC");
		while($rs = mysql_fetch_array($res))
			echo '<option value="'.$rs["id_objetivo"].'">'.htmlentities($rs["objetivo"]).'</option>';	
	break;
	}
}
?>
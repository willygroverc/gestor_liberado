<?php
//echo "hola mundo esto es una prueba";
//$d=$f;

require_once('conexion.php');

	//$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD); 
	//$dbsic = mysql_select_db(DB_DATABASE, $link)or die ('no se puede conectar daloradius');
	

	$cont=0;
        $qry ="SELECT * FROM ordenes";//selecion de todos las ordenes de trabajo
	$result=mysql_query($qry)or die($qry. "<br/><br/>".mysql_error());//EJECUTO LA CONSULTA
	while ($row = mysql_fetch_assoc($result)){
                        if ($row['objetivo']=='0'){
                            $cont=$cont+1;
                            
			echo 'la orden nro: '.$row['id_orden'].' creada por '.$row['cod_usr'].' no esta tipificada';
                        echo '</br>';
			//$log->lwrite($qrye.'</br>');
			//$row_cnt = mysql_num_rows($resultl);
                        }
                        
	}
echo 'Se encontraron :'.$cont.'ordenes no tipificadas';
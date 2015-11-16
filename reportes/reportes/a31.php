<?php         if(isset($fecha1) && $fecha2)
			{
				$sql_alt="  AND a.fecha BETWEEN '$fecha1' AND '$fecha2'";
			}
				else
			{
				$sql_alt="";

			}
           $sql_users="SELECT DISTINCT(CONCAT(nom_usr,' ',apa_usr)) as nom, cod_usr FROM ordenes a, users b WHERE b.login_usr=a.cod_usr AND id_orden NOT IN(SELECT id_orden FROM solucion) $sql_alt ORDER BY nom";
           $res_users=mysql_query($sql_users);
           $sub2=0;
   		  while($row_users=mysql_fetch_array($res_users)){
	            $arrData[$sub2][1] = $row_users['nom'];
   	         //obtiene las areas
					$sql_ar="SELECT DISTINCT(area) as cod_area FROM ordenes a WHERE id_orden NOT IN(SELECT id_orden FROM solucion) $sql_alt ORDER BY area";
					$res_ar=mysql_query($sql_ar);
   	      	$sub1=2;
   				while($row_ar=mysql_fetch_array($res_ar)){
   						$sql_cantidad="SELECT COUNT(*) as num FROM ordenes a WHERE cod_usr='".$row_users['cod_usr']."' AND area=$row_ar[cod_area] $sql_alt AND id_orden NOT IN(SELECT id_orden FROM solucion)";
   						$res_cantidad=mysql_query($sql_cantidad);
   						while($row_cantidad=mysql_fetch_array($res_cantidad)){
	   							$arrData[$sub2][$sub1] = $row_cantidad['num'];
   						}
   						$sub1++;
   				}
           $sub2++;        
        }  						

           $strXML = "<chart caption='Ordenes no Solucionadas por Area' numberSuffix=' ordenes' xAxisName='Usuario' yAxisName='Area' showValues='0'>";
           $categorias = "<categories>";
			  for($i=0;$i<$sub2;$i++){
					$categorias.="<category label='" . $arrData[$i][1] . "' />"		;	  	
			  	}
			  $categorias.= "</categories>";
           $sql_ar="SELECT DISTINCT(area) as area, area_nombre FROM ordenes a, area b WHERE a.area=b.area_cod AND id_orden NOT IN(SELECT id_orden FROM solucion) $sql_alt ORDER BY area";
			  $res_ar=mysql_query($sql_ar);
			  $cont_area=2;
   	     while($row_ar=mysql_fetch_array($res_ar)){
   		  		$categorias.="<dataset seriesName='".$row_ar['area_nombre']."'>";
   		  		for($i=0;$i<$sub2;$i++){
   		  				$categorias.="<set value='" . $arrData[$i][$cont_area] . "' />";	
   		  			}
   		  		$cont_area++;
   		  		$categorias .= "</dataset>";
   		  	}   				
           $strXML .= $categorias . "</chart>";
         
        ?>
<head>
   <script language="JavaScript" src="Charts/FusionCharts.js"></script>
</head>

<body bgcolor="#ffffff">

   <div id="chartdiv<?php $ra=rand(); echo $ra?>" align="center">The chart will appear within this DIV. This text will be replaced by the chart.</div>
   <script type="text/javascript">
      var myChart = new FusionCharts("Charts/MSBar3D.swf", "myChartId", "<?php=$tam1?>", "800", "0", "0");
      myChart.setDataXML("<?php echo $strXML;?>");
      myChart.render("chartdiv<?php=$ra?>");
   </script>

</body>
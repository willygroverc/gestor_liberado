<?php
         if(isset($fecha1) && $fecha2)
			{
				$sql_alt="  AND a.fecha BETWEEN '$fecha1' AND '$fecha2'";
			}
				else
			{
				$sql_alt="";

			}
           $sql_users="SELECT DISTINCT(CONCAT(nom_usr,' ',apa_usr)) as nom, cod_usr FROM ordenes a, users b WHERE b.login_usr=a.cod_usr AND id_orden IN(SELECT id_orden FROM asignacion) $sql_alt ORDER BY nom";
           $res_users=mysql_query($sql_users);
           $sub2=0;
   		  while($row_users=mysql_fetch_array($res_users)){
	            $arrData[$sub2][1] = $row_users['nom'];
					//obtiene no solucionados
					$sql_nosol="SELECT COUNT(*) as num FROM ordenes a WHERE cod_usr='".$row_users['cod_usr']."' AND id_orden IN(SELECT id_orden FROM asignacion) AND id_orden NOT IN(SELECT id_orden FROM solucion) $sql_alt";					
					$res_nosol=mysql_query($sql_nosol);
   				$row_nosol=mysql_fetch_array($res_nosol);
   				$arrData[$sub2][2] = $row_nosol['num'];
					//obtiene solucionados
					$sql_nosol="SELECT COUNT(*) as num FROM ordenes a WHERE cod_usr='".$row_users['cod_usr']."' AND id_orden IN(SELECT id_orden FROM asignacion) AND id_orden IN(SELECT id_orden FROM solucion) $sql_alt";					
					$res_nosol=mysql_query($sql_nosol);
   				$row_nosol=mysql_fetch_array($res_nosol);
   				$arrData[$sub2][3] = $row_nosol['num'];
   				$sub2++;
        }  						

           $strXML = "<chart caption='Ordenes Asignadas' numberSuffix=' ordenes' xAxisName='Usuario' yAxisName='Ordenes' showValues='0' labelDisplay='ROTATE' slantLabels='1'>";
////////////////			  
			  $strCategories = "<categories>";			  
			  $strDataCurr = "<dataset seriesName='No Solucionados'>";
           $strDataPrev = "<dataset seriesName='Solucionados'>";
           //Iterate through the data 
           foreach ($arrData as $arSubData) {
    	       //Append <category label='...' /> to strCategories
   	        $strCategories .= "<category label='" . $arSubData[1] . "' />";
   	        //Add <set value='...' /> to both the datasets
   	        $strDataCurr .= "<set value='" . $arSubData[2] . "' />";
  		        $strDataPrev .= "<set value='" . $arSubData[3] . "' />";
           }
           //Close <categories> element
           $strCategories .= "</categories>";
           //Close <dataset> elements
           $strDataCurr .= "</dataset>";
           $strDataPrev .= "</dataset>";
           //Assemble the entire XML now
           $strXML .= $strCategories . $strDataCurr . $strDataPrev . "</chart>";
              ?>
<head>
   <script language="JavaScript" src="Charts/FusionCharts.js"></script>
</head>

<body bgcolor="#ffffff">

   <div id="chartdiv<?php $ra=rand(); echo $ra?>" align="center">The chart will appear within this DIV. This text will be replaced by the chart.</div>
   <script type="text/javascript">
      var myChart = new FusionCharts("Charts/MSColumn3D.swf", "myChartId", "<?php=$tam1?>", "400", "0", "0");
      myChart.setDataXML("<?php echo $strXML;?>");
      myChart.render("chartdiv<?php=$ra?>");
   </script>

</body>
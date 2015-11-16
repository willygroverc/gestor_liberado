<?php
/**Wil
 * Clase Pruebas recuperacion
 *
 * @version $Id$
 * @copyright 2003 
 **/
class PruebasRecuperacion {
	var $msgOk;
	var $msgError;
	var $cn;
	var $db;
	var $tableMaster;
	var $tableDetail;
	
	function PruebasRecuperacion ($cnDb, $nameDb) {
		$this->cn=$cnDb;
		$this->db=$nameDb;
		$this->msgError="";
		$this->msgOk="";//"Operacion satisfactoria.<br>";
		$this->tableMaster="pruebrecup";
		$this->tableDetail="pruebrecuptipo";
//		mysql_select_db($this->db, $this->cn);
	}
	/**
	 *
	 * @access public
	 * @return void 
	 **/
	function InsertDetail($record){
		$sqlType="SELECT MAX(tipo2) AS tipo2 FROM pruebrecuptipo WHERE id_pru='$record[id_pru]' AND id_tipopru='$record[id_tipopru]' AND resact='$record[resact]' ORDER BY id_pruresin DESC";
//		print $sqlType;
		$rsType=mysql_db_query($this->db, $sqlType);
		$type=mysql_fetch_array($rsType);
		
		$record[tipo2]=$type[tipo2];
		//print "tipo".$record[tipo2];
		$record[tipo2]++;
		
		$sql="INSERT INTO ".$this->tableDetail." (resact, nombresin, fechain, horain, fechacon, horacon, resulresin, obsresin, tipo, id_tipopru, id_pru, tipo2) 
			 VALUES ('$record[resact]', '$record[nombresin]', '$record[fechain]', '$record[horain]', '$record[fechacon]', '$record[horacon]', '$record[resulresin]', '$record[obsresin]', '$record[tipo]', '$record[id_tipopru]', '$record[id_pru]', '$record[tipo2]')";
		$rs=mysql_db_query($this->db, $sql);
		//print $sql;
		if (mysql_affected_rows()==1) {
		    print $this->msgOk;			
			return mysql_insert_id();
		}
		else {
			//print $this->msgError;
			//print "Error: ".mysql_errno()." ".mysql_error();
			return mysql_affected_rows();
		}
	}
	function InsertDetail2($record){
		$sql="INSERT INTO ".$this->tableDetail." (resact, nombresin, fechain, horain, fechacon, horacon, resulresin, obsresin, tipo, id_tipopru, id_pru, tipo2) 
			 VALUES ('$record[resact]', '$record[nombresin]', '$record[fechain]', '$record[horain]', '$record[fechacon]', '$record[horacon]', '$record[resulresin]', '$record[obsresin]', '$record[tipo]', '$record[id_tipopru]', '$record[id_pru]', 0)";
		$rs=mysql_db_query($this->db, $sql);
		//print $sql;
		if (mysql_affected_rows()==1) {
		    print $this->msgOk;			
			return mysql_insert_id();
		}
		else {
			//print $this->msgError;
			//print "Error: ".mysql_errno()." ".mysql_error();
			return mysql_affected_rows();
		}
	}
	function InsertMaster($record){
		$sql="INSERT INTO ".$this->tableMaster." (ord_ayu, fecpru, aplipro, serpro, sitconti, nomapc, nomeval) 
			 VALUES ('$record[ord_ayu]', '$record[fecpru]', '1', '$record[serpro]', '$record[sitconti]', '$record[nomapc]', '$record[nomeval]')";
		$rs=mysql_db_query($this->db, $sql);
		//print $sql;
		if (mysql_affected_rows()==1) {
		    print $this->msgOk;			
			//print "idInsert".mysql_insert_id();
			return mysql_insert_id();
		}
		else {
			//print $this->msgError;
			//print "Error: ".mysql_errno()." ".mysql_error();
			return mysql_affected_rows();
		}
	}	
	function UpdateMaster($record){
		$sql="UPDATE ".$this->tableMaster." SET fecpru='$record[fecpru]', aplipro='$record[aplipro]', serpro='$record[serpro]', sitconti='$record[sitconti]', nomapc='$record[nomapc]', nomeval='$record[nomeval]' WHERE ord_ayu=$record[ord_ayu]";
		$rs=mysql_db_query($this->db, $sql);
		//print $sql;
		if (mysql_affected_rows()==1) {
		    print $this->msgOk;			
			return mysql_affected_rows();
		}
		else {
			//print $this->msgError;
			//print "Error: ".mysql_errno()." ".mysql_error();
			return mysql_affected_rows();
		}}
		//resact=$record[resact] , $record[resact]
	function UpdateDetail($record){
		$sql="UPDATE ".$this->tableDetail." SET resact='$record[resact]', nombresin='$record[nombresin]', fechain='$record[fechain]', horain='$record[horain]', fechacon='$record[fechacon]', horacon='$record[horacon]', resulresin='$record[resulresin]', obsresin='$record[obsresin]' WHERE id_pruresin=$record[id_pruresin]";
//		print $sql;
		$rs=mysql_db_query($this->db, $sql);
		if (mysql_affected_rows()==1) {
		    print $this->msgOk;			
			return mysql_affected_rows();
		}
		else {
			//print $this->msgError;
			//print "Error: ".mysql_errno()." ".mysql_error();
			return mysql_affected_rows();
		}}
	function UpdateDetailCon($record){
		$sql="UPDATE ".$this->tableDetail." SET fechacon='$record[fechacon]', horacon='$record[horacon]', resulresin='$record[resulresin]', obsresin='$record[obsresin]' WHERE id_pruresin=$record[id_pruresin]";
		$rs=mysql_db_query($this->db, $sql);
		//print $sql;
		if (mysql_affected_rows()==1) {
		    print $this->msgOk;			
			return mysql_affected_rows();
		}
		else {
			//print $this->msgError;
			//print "Error: ".mysql_errno()." ".mysql_error();
			return mysql_affected_rows();
		}}
	function UpdateDetail2($record){
	//verificar uso
		$sql="UPDATE ".$this->tableDetail." SET resact='$record[resact]', nombresin='$record[nombresin]', fechain='$record[fechain]', horain='$record[horain]', fechacon='$record[fechacon]', horacon='$record[horacon]', resulresin='$record[resulresin]', obsresin='$record[obsresin]' WHERE id_pruresin=$record[id_pruresin]";
		$rs=mysql_db_query($this->db, $sql);
		//print $sql;
		if (mysql_affected_rows()==1) {
		    print $this->msgOk;			
			return mysql_affected_rows();
		}
		else {
			//print $this->msgError;
			//print "Error: ".mysql_errno()." ".mysql_error();
			return mysql_affected_rows();
		}}
	function GetMaster($record=0){
		if (!empty($record)) {
		    //$sql="SELECT pruebrecup.*, sistemas.Descripcion as aplipro FROM pruebrecup, sistemas WHERE pruebrecup.aplipro=sistemas.Id_Sistema AND ord_ayu=$record[ord_ayu]";
			$sql="SELECT pruebrecup.* FROM pruebrecup WHERE ord_ayu=$record[ord_ayu]";
		}
		//else $sql="SELECT * FROM pruebrecup";
		else $sql="SELECT pruebrecup.* FROM pruebrecup";
//		print $sql;
		$rs=mysql_db_query($this->db, $sql);
		$i=0;
		while($fields=mysql_fetch_array($rs)){
			$record[$i]=$fields;			
			$i++;
		} // while
		return $record;
	}	
	function GetDetail($type=0, $id=0, $id_pruresin=0){
		if (!empty($id)) {
			if($type==2) $sql="SELECT pruebrecuptipo.*, DATE_FORMAT(fechain, '%d/%m/%Y') AS fechain, DATE_FORMAT(fechacon, '%d/%m/%Y') AS fechacon, proveedor.NombProv as nombresin FROM pruebrecuptipo, proveedor WHERE pruebrecuptipo.nombresin=proveedor.IdProv AND id_pru=$id AND id_tipopru=$type ORDER BY resact, id_pruresin ASC";
			elseif ($type==3) $sql="SELECT pruebrecuptipo.*,DATE_FORMAT(fechain, '%d/%m/%Y') AS fechain, DATE_FORMAT(fechacon, '%d/%m/%Y') AS fechacon, CONCAT(datfichatec.Modelo, '-', datfichatec.AdicUSI) as nombresin FROM pruebrecuptipo, datfichatec WHERE pruebrecuptipo.nombresin=datfichatec.IdFicha AND id_pru=$id AND id_tipopru=$type ORDER BY resact, id_pruresin ASC";
			elseif ($type==4 || $type==5 || $type==6 || $type==7) $sql="SELECT pruebrecuptipo.*, DATE_FORMAT(fechain, '%d/%m/%Y') AS fechain, DATE_FORMAT(fechacon, '%d/%m/%Y') AS fechacon, sistemas.Descripcion as nombresin FROM pruebrecuptipo, sistemas WHERE pruebrecuptipo.nombresin=sistemas.Id_Sistema AND id_pru=$id AND id_tipopru=$type ORDER BY  resact, id_pruresin ASC";
		    else $sql="SELECT *, DATE_FORMAT(fechain, '%d/%m/%Y') AS fechain, DATE_FORMAT(fechacon, '%d/%m/%Y') AS fechacon FROM pruebrecuptipo WHERE id_pru=$id AND id_tipopru=$type ORDER BY resact, id_pruresin ASC";
		}
		else {
			if($type==2) $sql="SELECT pruebrecuptipo.*, DATE_FORMAT(fechain, '%d/%m/%Y') AS fechain, DATE_FORMAT(fechacon, '%d/%m/%Y') AS fechacon, proveedor.NombProv as nombresin FROM pruebrecuptipo, proveedor WHERE pruebrecuptipo.nombresin=proveedor.IdProv AND id_pruresin=$id_pruresin ORDER BY resact, id_pruresin ASC";
			elseif($type==3) $sql="SELECT pruebrecuptipo.*, DATE_FORMAT(fechain, '%d/%m/%Y') AS fechain, DATE_FORMAT(fechacon, '%d/%m/%Y') AS fechacon, CONCAT(datfichatec.Modelo, '-', datfichatec.AdicUSI) as nombresin FROM pruebrecuptipo, datfichatec WHERE pruebrecuptipo.nombresin=datfichatec.IdFicha AND id_pruresin=$id_pruresin ORDER BY resact, id_pruresin ASC";
			elseif ($type==4 || $type==5 || $type==6 || $type==7) $sql="SELECT pruebrecuptipo.*, DATE_FORMAT(fechain, '%d/%m/%Y') AS fechain, DATE_FORMAT(fechacon, '%d/%m/%Y') AS fechacon, sistemas.Descripcion as nombresin FROM pruebrecuptipo, sistemas WHERE pruebrecuptipo.nombresin=sistemas.Id_Sistema AND id_pruresin=$id_pruresin";
			else $sql="SELECT *, DATE_FORMAT(fechain, '%d/%m/%Y') AS fechain, DATE_FORMAT(fechacon, '%d/%m/%Y') AS fechacon FROM pruebrecuptipo WHERE id_pruresin=$id_pruresin ORDER BY resact, id_pruresin ASC";
		}
		//print $sql;
		//print mysql_error();
		$rs=mysql_db_query($this->db, $sql);
		$i=0;
		while($fields=mysql_fetch_array($rs)){
			$record[$i]=$fields;			
			$i++;
		} // while
		return $record;
	}	
	function GetDetail2($type=0, $id=0, $id_pruresin=0){
		if (!empty($id) && !empty($type)) {
		    $sql="SELECT pruebrecuptipo.*, DATE_FORMAT(fechain, '%d/%m/%Y') AS fechain, DATE_FORMAT(fechacon, '%d/%m/%Y') AS fechacon, CONCAT(apa_usr,' ',ama_usr,' ',nom_usr) as usuario FROM pruebrecuptipo, users WHERE pruebrecuptipo.nombresin=users.login_usr AND id_pru=$id AND id_tipopru=$type ORDER BY resact, tipo2, apa_usr ASC";
			//$sql="SELECT pruebrecuptipo.*, DATE_FORMAT(fechain, '%d/%m/%Y') AS fechain, CONCAT(apa_usr,' ',ama_usr,' ',nom_usr) as usuario FROM pruebrecuptipo, users WHERE pruebrecuptipo.nombresin=users.login_usr AND id_pru=$id AND id_tipopru=$type ORDER BY resact, tipo2, apa_usr ASC";
		}
		else $sql="SELECT pruebrecuptipo.*, DATE_FORMAT(fechain, '%d/%m/%Y') AS fechain, DATE_FORMAT(fechacon, '%d/%m/%Y') AS fechacon, CONCAT(apa_usr,' ',ama_usr,' ',nom_usr) as usuario FROM pruebrecuptipo, users WHERE pruebrecuptipo.nombresin=users.login_usr AND id_pruresin=$id_pruresin ORDER BY apa_usr ASC";
		//print $sql;
		//print mysql_error();
		$rs=mysql_db_query($this->db, $sql);
		$i=0;	
		    while($fields=mysql_fetch_array($rs)){
			$record[$i]=$fields;			
			$i++;
		} // while
		return $record;
	}	
	function ChkMaster($record){
		$sql="SELECT * FROM pruebrecup WHERE ord_ayu=$record[ord_ayu]";
//		print $sql;
//		print mysql_error();
		$rs=mysql_db_query($this->db, $sql);		
		return mysql_num_rows($rs);
	}	
	function GetIdMaster($record){
	//sin utilizaar
		$sql="SELECT id_pru FROM pruebrecup WHERE ord_ayu=$record[ord_ayu]";
//		print $sql;
//		print mysql_error();
		$rs=mysql_db_query($this->db, $sql);		
		return mysql_num_rows($rs);
	}	
}
?>
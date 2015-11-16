<?php

/**Wil
 * Clase Pruebas recuperacion
 *
 * @version $Id$
 * @copyright 2003 
 **/

class DbTools {
	var $msgOk;
	var $msgError;
	var $cn;
	var $db;
	var $table1;//sistemas
	var $table2;//users
	var $table3;//proveedor
	var $table4;//datfichtec
	
	function DbTools ($cnDb, $nameDb) {
		$this->cn=$cnDb;
		$this->db=$nameDb;
		$this->msgError="Precaucion, no se han registrado los datos. Por favor, intentelo nuevamente.<br>";
		$this->msgOk="Operacion satisfactoria.<br>";
		$this->table1="sistemas";
		$this->table2="users";
		$this->table3="proveedor";
		$this->table4="datfichatec";
		//mysql_select_db($this->db, $this->cn);
	}
	/**
	 *
	 * @access public
	 * @return void 
	 **/
	function GetTable1($type=0){
		switch($type){
			case 1: 
				$sql="SELECT Id_Sistema, Descripcion FROM sistemas WHERE Id_Tipo='APLICACION'";
				break;
			case 2: 
				$sql="SELECT Id_Sistema, Descripcion FROM sistemas";
				break;
			case 3: 
				$sql="SELECT Id_Sistema, Descripcion FROM sistemas WHERE Id_Tipo='SISTEMA OPERATIVO'";
				break;
			case 4: 
				$sql="SELECT Id_Sistema, Descripcion FROM sistemas WHERE Id_Tipo='Sistema Operativo' OR Id_Tipo='Base de Datos'";
				break;
			case 5: 
				$sql="SELECT Id_Sistema, Descripcion FROM sistemas WHERE Id_Tipo='OFIMATICA'";
				break;
			case 6: 
				$sql="SELECT Id_Sistema, Descripcion FROM sistemas WHERE Id_Tipo='UTILITARIO'";
				break;
			case 7: 
				$sql="SELECT Id_Sistema, Descripcion FROM sistemas WHERE Id_Tipo='VARIOS'";
				break;
			default:
				$sql="SELECT Id_Sistema, Descripcion FROM sistemas WHERE Id_Tipo='BASE DE DATOS'";;
		} // switch
//		print $type.$sql;
		$rs=mysql_db_query($this->db, $sql);
		print mysql_error();
		while($fields=mysql_fetch_array($rs)){
			$record[$fields[Id_Sistema]]=$fields["Descripcion"];
			
		} // while
		return $record;
	}
	function GetTable2($type="C"){
		if ($type=="T") {
		    $sql="SELECT login_usr, CONCAT(apa_usr,' ',ama_usr,' ', nom_usr) AS nombre FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
		}
		elseif ($type=="TC") {
		    $sql="SELECT login_usr, CONCAT(apa_usr,' ',ama_usr,' ', nom_usr) AS nombre FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear=0 ORDER BY apa_usr ASC";
		}
		else $sql="SELECT login_usr, CONCAT(apa_usr,' ',ama_usr,' ', nom_usr) AS nombre FROM users WHERE tipo2_usr='C' AND bloquear=0 ORDER BY apa_usr ASC";

		$rs=mysql_db_query($this->db, $sql);
		while($fields=mysql_fetch_array($rs)){
			$record[$fields[login_usr]]=$fields["nombre"];
			
		} // while
		return $record;
	}
	function GetTable3(){
		$sql="SELECT IdProv, NombProv FROM proveedor ORDER BY NombProv";
		$rs=mysql_db_query($this->db, $sql);
		while($fields=mysql_fetch_array($rs)){
			$record[$fields[IdProv]]=$fields["NombProv"];
			
		} // while
		return $record;
	}
	function GetTable4($type=0){
		if ($type==1) $sql="SELECT IdFicha, CONCAT(Modelo, '-', AdicUSI) as TpRegFicha FROM datfichatec WHERE TpRegFicha = 'Computadores de Escritorio' ORDER BY TpRegFicha";
		elseif ($type==2) $sql="SELECT IdFicha, CONCAT(Modelo, '-', AdicUSI) as TpRegFicha FROM datfichatec WHERE TpRegFicha = 'Computadores Portatiles' ORDER BY TpRegFicha";
		elseif ($type==3) $sql="SELECT IdFicha, CONCAT(Modelo, '-', AdicUSI) as TpRegFicha FROM datfichatec WHERE TpRegFicha = 'Servidores' ORDER BY TpRegFicha";
		elseif ($type==4) $sql="SELECT IdFicha, CONCAT(Modelo, '-', AdicUSI) as TpRegFicha FROM datfichatec WHERE TpRegFicha = 'Otros' ORDER BY TpRegFicha";
		else $sql="SELECT IdFicha, CONCAT(Modelo, '-', AdicUSI) as TpRegFicha FROM datfichatec ORDER BY TpRegFicha";
		$rs=mysql_db_query($this->db, $sql);
		while($fields=mysql_fetch_array($rs)){
			$record[$fields[IdFicha]]=$fields["TpRegFicha"];			
		} // while
		return $record;
	}	
	function InsertMaster($record){
		$sql="INSERT INTO ".$this->tableMaster." () VALUES ()";
		$rs=mysql_query($sql, $this->cn);
		if (mysql_affected_rows($this->cn)==1) {
		    print $this->msgOk;
			print "Error: ".mysql_errno($this->cn)." ".mysql_error($this->cn);
			return mysql_insert_id($this->cn);
		}
		else {
			print $this->msgError;
			return mysql_affected_rows($this->cn);
		}
	}
	function GetNumberType ($id_pru, $type, $listCombo=0){
		switch($type){
			case 2: 
				$sql="SELECT id_pruresin, CONCAT(resact, ' ', tipo2) AS resact FROM pruebrecuptipo WHERE id_pru=$id_pru AND id_tipopru=$type ORDER BY resact ASC";
				break;
			case 5: 
				$sql="SELECT id_pruresin, CONCAT(resact, ' ', tipo2) AS resact FROM pruebrecuptipo WHERE id_pru=$id_pru AND id_tipopru=$type ORDER BY resact ASC";
				break;
			default:
				$sql="SELECT id_pruresin, CONCAT(resact, ' ', tipo2) AS resact  FROM pruebrecuptipo WHERE id_pru=$id_pru AND id_tipopru=$type ORDER BY id_pruresin DESC";
		} // switch	
		//print $sql;
		$rs=mysql_db_query($this->db, $sql);
		if (sizeof($listCombo)>0) {
				    foreach ($listCombo as $k => $v){
					$tmp2[$k]=$v;
				}}
		if (mysql_num_rows($rs)>0) {
				while($tmp1=mysql_fetch_array($rs)){
					$tmp2[$tmp1[id_pruresin]]=$tmp1[resact];
				} // while				
		}
		return $tmp2;
	}	
}
?>